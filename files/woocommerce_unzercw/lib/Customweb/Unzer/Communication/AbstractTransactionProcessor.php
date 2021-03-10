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

require_once 'Customweb/Payment/Authorization/ErrorMessage.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Payment/Exception/PaymentErrorException.php';
require_once 'Customweb/Unzer/Communication/AbstractResponseProcessor.php';


/**
 *
 * @author Sebastian Bossert
 */
abstract class Customweb_Unzer_Communication_AbstractTransactionProcessor extends Customweb_Unzer_Communication_AbstractResponseProcessor {
	protected $transaction;

	public function __construct(Customweb_Unzer_Authorization_Transaction $transaction, Customweb_DependencyInjection_IContainer $container){
		$this->transaction = $transaction;
		parent::__construct($container);
	}

	protected function processError(){
		$this->transaction->setUnzErrorId($this->data['id']);
		parent::processError();
	}

	/**
	 * Helper function to process resource json object to transaction.
	 *
	 * @param array $resource
	 */
	protected function processResourceIds(array $resource){
		$this->getLogger()->logDebug("Processing resources obj");
		$this->getLogger()->logDebug(json_encode($resource));
		if (isset($resource['paymentId'])) {
			$this->transaction->setUnzPaymentId($resource['paymentId']);
			$this->getContainer()->getTransactionLoader()->registerPaymentId($resource['paymentId'], $this->transaction->getExternalTransactionId());
		}
		if (isset($resource['basketId'])) {
			$this->transaction->setUnzBasketId($resource['basketId']);
		}
		if (isset($resource['customerId'])) {
			$this->transaction->setUnzCustomerId($resource['customerId'], $this->getPaymentMethodByTransaction($this->transaction)->getPublicKey());
		}
		if (isset($resource['metadataId'])) {
			$this->transaction->setUnzMetadataId($resource['metadataId']);
		}
		if (isset($resource['typeId'])) {
			$this->transaction->setUnzTypeId($resource['typeId']);
		}
		if (isset($resource['traceId'])) {
			$this->transaction->setUnzTraceId($resource['traceId']);
		}
	}

	/**
	 * Helper function to process processing json object to transaction.
	 *
	 * @param array $processing
	 */
	protected function processProcessingIds(array $processing){
		if (isset($processing['uniqueId'])) {
			$this->transaction->setUniqueId($processing['uniqueId']);
		}
		if (isset($processing['shortId'])) {
			$this->transaction->setShortId($processing['shortId']);
			$this->transaction->setPaymentId($processing['shortId']);
		}
		if (isset($processing['traceId'])) {
			$this->transaction->setTraceID($processing['traceId']);
		}
	}

	protected function saveException(Exception $e){
		if ($e instanceof Customweb_Payment_Exception_PaymentErrorException) {
			$this->transaction->addErrorMessage($e->getErrorMessage());
		}
		else {
			$this->getLogger()->logException($e, $this->response);
			$this->transaction->addErrorMessage(
					new Customweb_Payment_Authorization_ErrorMessage(
							Customweb_I18n_Translation::__("An unkown exception occurred: @message.", array(
								'@message' => $e->getMessage()
							))));
		}
	}
}