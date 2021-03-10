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

require_once 'Customweb/Unzer/Communication/Processor/DefaultProcessor.php';
require_once 'Customweb/Unzer/Communication/Processor/OptimisticLockingProcessor.php';


/**
 * Processor to process payment request.
 * Sends customer & basket in initial transaction, then processes payment in second transaction since webhook may arrive concurrently.
 *
 * @author sebastian
 *
 */
class Customweb_Unzer_Communication_Operation_PaymentProcessor extends Customweb_Unzer_Communication_Processor_OptimisticLockingProcessor {
	private $typeId;

	public function __construct($transactionId, $requestBuilder, Customweb_DependencyInjection_IContainer $container, $typeId){
		parent::__construct($transactionId, $requestBuilder, $container);
		$this->typeId = $typeId; //TODO cleaner
	}

	public function process(){
		$transactionHandler = $this->getContainer()->getTransactionHandler();
		$transactionHandler->beginTransaction();
		$transaction = $this->loadTransaction($transactionHandler);
		if(empty($transaction)) {
			throw new Exception("Unable to load transaction."); //TODO
		}

		$paymentMethod = $this->getContainer()->getPaymentMethodByTransaction($transaction);
		$paymentMethod->sendCustomer($transaction);
		$this->getLogger()->logDebug("Sent customer, id now: {$transaction->getUnzCustomerId()}");
		$paymentMethod->sendBasket($transaction);
		$this->getLogger()->logDebug("Sent basket, id now: {$transaction->getUnzBasketId()}");
		$paymentMethod->sendMetadata($transaction);
		$this->getLogger()->logDebug("Sent metadata, id now: {$transaction->getUnzMetadataId()}");

		if ($this->typeId) {
			$transaction->setUnzTypeId($this->typeId);
		}
		$this->requestBuilder = $this->getContainer()->getPaymentMethodByTransaction($transaction)->getPaymentRequestBuilder($transaction);
		$transactionHandler->persistTransactionObject($transaction);
		$transactionHandler->commitTransaction();
		$this->getLogger()->logDebug("processed metadata, customer & basket, now processing payment");

		$result = null;
		try {
			$result = parent::process();
			$this->getLogger()->logDebug("payment processed, result $result");
		}
		catch (Exception $e) {
			$this->getLogger()->logDebug("payment processing failed {$e->getMessage()}.");
			$this->getLogger()->logException($e);
			throw $e;
		}
		return $result;
	}

	/**
	 * Must always recreate due to database transactions
	 *
	 * {@inheritdoc}
	 * @see Customweb_Unzer_Communication_Processor_DefaultProcessor::getResponseProcessor()
	 */
	protected function getResponseProcessor(){
		return $this->getContainer()->getPaymentMethodByTransaction($this->getTransaction())->getPaymentResponseProcessor($this->getTransaction());
	}
}