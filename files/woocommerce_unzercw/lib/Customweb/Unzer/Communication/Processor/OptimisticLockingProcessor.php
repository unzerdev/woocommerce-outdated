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

require_once 'Customweb/Unzer/Communication/Processor/AbstractProcessor.php';


/**
 * Processor to send request and process response based on a transaction which may be locked.
 * Implementing classes must implement their own getResponseProcessor to ensure the changes are saved.
 *
 * @author sebastian
 *
 */
abstract class Customweb_Unzer_Communication_Processor_OptimisticLockingProcessor extends Customweb_Unzer_Communication_Processor_AbstractProcessor {
	const DELAY = 1;
	const RETRIES = 5;
	private $attempt = 0;
	private $transactionId;
	private $transaction;
	protected $requestBuilder;
	protected $responseProcessor;
	
	/**
	 *
	 *
	 * @param string|array $transactionId Either use externalTransactionId, or mirror Endpoint ExtractionMethod strategy (array key => type, id => id)
	 * @param Customweb_Unzer_Communication_AbstractRequestBuilder $requestBuilder
	 * @param Customweb_Unzer_Communication_AbstractResponseProcessor $responseProcessor
	 * @param Customweb_DependencyInjection_IContainer $container
	 */
	public function __construct($transactionId, Customweb_Unzer_Communication_AbstractRequestBuilder $requestBuilder, Customweb_DependencyInjection_IContainer $container) {
		parent::__construct($container);
		$this->requestBuilder = $requestBuilder;
		$this->transactionId = $transactionId;
	}
	
	/**
	 * Processes response to transaction while handling optimistic locking exceptions.
	 * 
	 * {@inheritDoc}
	 * @see Customweb_Unzer_Communication_Processor_AbstractProcessor::processResponse()
	 */
	protected function processResponse(){
		$this->getLogger()->logDebug("OPTLOCK: processResponse start");
		$lastException = null;
		$transactionHandler = $this->getContainer()->getTransactionHandler();
		$wait = 0;
		while($transactionHandler->isTransactionRunning()) {
			$this->getLogger()->logDebug("OPTLOCK: transaction running, waiting");
			sleep(self::DELAY);
			if($wait++ > 100) {
				$this->getLogger()->logDebug("OPTLOCK: Transaction is not unlocking, throwing exception.");
				throw new Exception("Transaction is not unlocking.");
			}
		}
		$this->getLogger()->logDebug("OPTLOCK: transaction no longer running");
		while ($this->isRetry()) {
			$this->getLogger()->logDebug("OPTLOCK: attempt");
			try {
				$transactionHandler->beginTransaction();
				$this->getLogger()->logDebug("OPTLOCK: transaction begin");
				$this->transaction = $this->loadTransaction($transactionHandler);
				if(empty($this->transaction)) {
					throw new Exception("Unable to load transaction."); //TODO
				}
				$this->getLogger()->logDebug("OPTLOCK: transaction loaded");
				$result = parent::processResponse();
				$this->getLogger()->logDebug("OPTLOCK: response processed");
				$transactionHandler->persistTransactionObject($this->transaction);
				$this->getLogger()->logDebug("OPTLOCK: transaction persisted");
				$transactionHandler->commitTransaction();
				$this->getLogger()->logDebug("OPTLOCK: transaction committed, returning result");
				return $result;
			}
			catch (Customweb_Payment_Exception_OptimisticLockingException $lockingException) {
				$this->getLogger()->logDebug("OPTLOCK: locked, rolling back");
				$transactionHandler->rollbackTransaction();
				$this->getLogger()->logDebug("OPTLOCK: rolled back");
				$lastException = $lockingException;
				sleep(self::DELAY);
			}
			catch(Customweb_Unzer_Endpoint_UnsupportedWebhookException $e) {
				$transactionHandler->rollbackTransaction();
				return;
			}
			catch(Exception $e) {
				$this->getLogger()->logException($e, $this->transaction->getExternalTransactionId());
				$transactionHandler->rollbackTransaction();
				throw $e;
			}
			$this->attempt++;
		}
		$this->getLogger()->logDebug("OPTLOCK: failed, throwing exception");
		throw $lastException;
	}
	
	/**
	 * 
	 * @param Customweb_Payment_ITransactionHandler $transactionHandler
	 * @return Customweb_Unzer_Authorization_Transaction
	 */
	protected function loadTransaction(Customweb_Payment_ITransactionHandler $transactionHandler) {
		if(is_array($this->transactionId)) {
			return $this->getContainer()->getTransactionLoader()->loadTransaction($this->transactionId['id'], $this->transactionId['key']);
		}
		return $transactionHandler->findTransactionByTransactionExternalId($this->transactionId, false);
	}
	
	protected function getTransaction() {
		return $this->transaction;
	}
	
	protected function isRetry(){
		return $this->attempt < self::RETRIES;
	}
	
	/**
	 *
	 * @return Customweb_Payment_ITransactionHandler
	 */
	private function getTransactionHandler() {
		if($this->transactionHandler === null) {
			$this->transactionHandler = $this->getContainer()->getTransactionHandler();
		}
		return $this->transactionHandler;
	}

	protected function getRequestBuilder(){
		return $this->requestBuilder;
	}

}