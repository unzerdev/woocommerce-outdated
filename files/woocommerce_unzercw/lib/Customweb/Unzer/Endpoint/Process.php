<?php

/**
 *  * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2018 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 */

require_once 'Customweb/Unzer/Container.php';
require_once 'Customweb/Payment/Endpoint/Controller/Abstract.php';
require_once 'Customweb/Unzer/Util/Form.php';
require_once 'Customweb/Unzer/Helper/TransactionLoader.php';
require_once 'Customweb/Payment/Authorization/ErrorMessage.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Unzer/Endpoint/Process.php';
require_once 'Customweb/Core/Http/Response.php';
require_once 'Customweb/Core/Logger/Factory.php';


/**
 *
 * @author Sebastian Bossert
 * @Controller("process")
 */
class Customweb_Unzer_Endpoint_Process extends Customweb_Payment_Endpoint_Controller_Abstract {
	const RETRIES = 5;
	const RETRY_DELAY = 2;
	const HASH_PARAMETER = 'securityHash';
	private $logger;
	private $transactionHandler;

	public function __construct(Customweb_DependencyInjection_IContainer $container){
		parent::__construct(Customweb_Unzer_Container::get($container));
	}

	/**
	 *
	 * @Action("returntostore")
	 * @param Customweb_Core_Http_IRequest $request
	 */
	public function returnToStore(Customweb_Core_Http_IRequest $request){
		$this->transactionHandler = $this->getTransactionHandler();
		$transactionId = $this->getTransactionId($request);
		$transaction = null;
		for ($i = 0; $i < self::RETRIES; $i++) {
			$transaction = $this->getContainer()->getTransactionLoader()->loadTransaction($transactionId['id'], $transactionId['key']);
			if (!$transaction->isAuthorizationFailed() && !$transaction->isAuthorized()) {
				$this->getContainer()->getPaymentMethodByTransaction($transaction)->update($transaction);
			}
			if ($transaction->isAuthorizationFailed()) {
				return Customweb_Core_Http_Response::redirect($transaction->getFailedUrl());
			}
			else if ($transaction->isAuthorized()) {
				return Customweb_Core_Http_Response::redirect($transaction->getSuccessUrl());
			}
			$this->getLogger()->logDebug("Transaction not auth / failed, delay.",
					array(
						'id' => $transaction->getExternalTransactionId(),
						'history' => $transaction->getHistoryItems()
					));
			sleep(self::RETRY_DELAY);
		}
		if(empty($transaction)) {
			throw new Exception("Unable to load transaction.");
		}
		return Customweb_Core_Http_Response::redirect($this->getPendingUrl($transaction));
	}
	
	private function getPendingUrl(Customweb_Unzer_Authorization_Transaction $transaction){
		return $this->getContainer()->createSecuredEndpointUrl('pending', 'index', $transaction);
	}
	
	/**
	 *
	 * @Action("webhook")
	 * @param Customweb_Core_Http_IRequest $request
	 */
	public function webhook(Customweb_Core_Http_IRequest $request){
		$this->transactionHandler = $this->getTransactionHandler();
		$webhookData = json_decode($request->getBody(), true);
		try {
			$this->processWebhook($webhookData);
		}
		catch (Customweb_Unzer_Endpoint_UnsupportedWebhookException $e) {
			$this->getLogger()->logDebug("Processing webhook skipped: {$e->getMessage()}.");
		}
		catch (Exception $e) {
			$this->getLogger()->logDebug("Processing webhook failed: {$e->getMessage()}.");
		}
		return Customweb_Core_Http_Response::_("")->setStatusCode(200);
	}

	private function processWebhook(array $webhookData){
		$transaction = $this->loadTransactionFromWebhook($webhookData);
		if ($transaction) {
			$processor = $this->getContainer()->getPaymentMethodByTransaction($transaction)->getWebhookProcessor($transaction, $webhookData);
			$processor->process();
		}
		else {
			$this->getLogger()->logDebug('Unable to load transaction for webhook, skipping further processing.');
		}
	}

	private function loadTransactionFromWebhook(array $webhookData){
		if (isset($webhookData['paymentId'])) {
			return $this->getContainer()->getTransactionLoader()->loadTransaction($webhookData['paymentId'],
					Customweb_Unzer_Helper_TransactionLoader::EXTRACTION_METHOD_UNZ_PAYMENT_ID);
		}
		else {
			if ($webhookData['event'] === 'types') {
				$parts = explode('/', $webhookData['retrieveUrl']);
				$typeId = end($parts);
				return $this->getContainer()->getTransactionLoader()->loadTransaction($typeId,
						Customweb_Unzer_Helper_TransactionLoader::EXTRACTION_METHOD_TYPE_ID);
			}
		}
		return null;
	}

	/**
	 *
	 * @Action("payment")
	 * @param Customweb_Core_Http_IRequest $request
	 */
	public function payment(Customweb_Core_Http_IRequest $request){
		$this->transactionHandler = $this->getTransactionHandler();
		$parameters = $request->getParsedQuery();
		$transactionId = $this->getTransactionId($request);
		$transaction = $this->getContainer()->getTransactionLoader()->loadTransaction($transactionId['id'], $transactionId['key']);
		$transaction->checkSecuritySignature('processpayment', $parameters[Customweb_Unzer_Endpoint_Process::HASH_PARAMETER]);
		$data = json_decode($request->getBody(), true);
		return $this->processPayment($transaction, $data);
	}

	/**
	 *
	 * @Action("error")
	 * @param Customweb_Core_Http_IRequest $request
	 */
	public function error(Customweb_Core_Http_IRequest $request){
		$this->transactionHandler = $this->getTransactionHandler();
		$parameters = $request->getParsedQuery();
		$transactionId = $this->getTransactionId($request);
		$transaction = $this->getContainer()->getTransactionLoader()->loadTransaction($transactionId['id'], $transactionId['key']);
		$transaction->checkSecuritySignature('processerror', $parameters[Customweb_Unzer_Endpoint_Process::HASH_PARAMETER]);
		$this->processError($transactionId['id'], $parameters['error']);
		return Customweb_Core_Http_Response::redirect($transaction->getFailedUrl());
	}

	/**
	 *
	 * @param string $externalTransactionId
	 * @param string $message
	 */
	private function processError($transactionId, $message){
		for ($i = 0; $i < self::RETRIES; $i++) {
			try {
				if ($this->transactionHandler->isTransactionRunning()) {
					continue;
				}
				$this->transactionHandler->beginTransaction();
				$transaction = $this->transactionHandler->findTransactionByTransactionExternalId($transactionId);
				$error = new Customweb_Payment_Authorization_ErrorMessage($message);
				if ($transaction->isAuthorizationFailed() || $transaction->isAuthorized()) {
					$transaction->addErrorMessage($error);
				}
				else {
					$transaction->setAuthorizationFailed($error);
				}
				$this->transactionHandler->persistTransactionObject($transaction);
				$this->transactionHandler->commitTransaction();
				return;
			}
			catch (Customweb_Payment_Exception_OptimisticLockingException $e) {
				$this->getLogger()->logInfo("Setting error failed: {$e->getMessage()}");
				$this->transactionHandler->rollbackTransaction();
			}
			sleep(self::RETRY_DELAY);
		}
		$this->getLogger()->logError("Unable to add error to transaction with id [{$transactionId}]: '{$message}'.");
	}

	private function processPayment(Customweb_Unzer_Authorization_Transaction $transaction, array $data){
		$this->processFormData($transaction, $data);
		$transaction->setUnzTypeId($data['result']['id']); //used in sendPaymentRequest, is persisted to transaction later.
		$processor = $this->getContainer()->getPaymentMethodByTransaction($transaction)->getPaymentProcessor($transaction);
		return $processor->process();
	}

	private function processFormData(Customweb_Unzer_Authorization_Transaction $transaction, array $data){
		if(empty($data)){
			return;
		}
		$this->getLogger()->logDebug(__METHOD__, $data);
		$last = null;
		$this->getContainer()->getTransactionLoader()->registerTypeId($data['result']['id'], $transaction->getExternalTransactionId());
		for ($attempt = 0; $attempt < self::RETRIES; $attempt++) {
			try {
				$this->getTransactionHandler()->beginTransaction();
				if ($attempt > 0) {
					$transaction = $this->getTransactionHandler()->findTransactionByTransactionExternalId($transaction->getExternalTransactionId(),
							false);
				}
				Customweb_Unzer_Util_Form::processFormData($transaction, $data['form']);
				$transaction->setUnzTypeId($data['result']['id']); //used in sendPaymentRequest, is persisted to transaction later.
				$this->getContainer()->getTransactionHandler()->persistTransactionObject($transaction);
				$this->getContainer()->getTransactionHandler()->commitTransaction();
				return $transaction;
			}
			catch (Exception $e) {
				$last = $e;
			}
		}
		if ($last) {
			throw Exception(Customweb_I18n_Translation::__("Unable to process form data: '@inner'.", array(
				'@inner' => $e->getMessage()
			)));
		}
	}

	/**
	 *
	 * @return Customweb_Unzer_Container
	 */
	protected function getContainer(){
		return parent::getContainer();
	}

	/**
	 *
	 * @return Customweb_Core_ILogger
	 */
	private function getLogger(){
		if ($this->logger === null) {
			$this->logger = Customweb_Core_Logger_Factory::getLogger(get_class());
		}
		return $this->logger;
	}
}