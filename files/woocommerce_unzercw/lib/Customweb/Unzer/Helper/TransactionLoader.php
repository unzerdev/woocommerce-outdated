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

require_once 'Customweb/Payment/Endpoint/Annotation/ExtractionMethod.php';
require_once 'Customweb/Core/Logger/Factory.php';


/**
 * Helper class to load transaction in a db transaction.
 *
 * @author Sebastian Bossert
 */
final class Customweb_Unzer_Helper_TransactionLoader {
	const EXTRACTION_METHOD_TYPE_ID = 'typeId';
	const EXTRACTION_METHOD_UNZ_PAYMENT_ID = 'unzPaymentId';
	private $storageHelper;
	private $transactionHandler;
	private $logger;
	const RETRIES = 5;
	const DELAY = 1;

	public function __construct(Customweb_Payment_ITransactionHandler $transactionHandler, Customweb_Unzer_Helper_Storage $storageHelper){
		$this->transactionHandler = $transactionHandler;
		$this->storageHelper = $storageHelper;
		$this->logger = Customweb_Core_Logger_Factory::getLogger(get_class());
	}

	/**
	 *
	 * @param string $id
	 * @param string $strategy
	 * @throws Exception
	 * @return Customweb_Unzer_Authorization_Transaction
	 */
	public function loadTransaction($id, $strategy = 'externalTransactionId'){
		$this->logger->logDebug("Load transaction start.");
		$message = 'unkown error';
		for ($i = 0; $i < self::RETRIES; $i++) {
			try {
				if (!$this->transactionHandler->isTransactionRunning()) {
					$this->transactionHandler->beginTransaction();
					$transaction = $this->loadTransactionByStrategy($id, $strategy);
					$this->transactionHandler->commitTransaction();
					$this->logger->logDebug("Load transaction complete.");
					return $transaction;
				}
			}
			catch (Customweb_Payment_Exception_OptimisticLockingException $e) {
				$message = $e->getMessage();
				$this->transactionHandler->rollbackTransaction();
			}
			catch(Exception $e) {
				$message = $e->getMessage();
				$this->transactionHandler->rollbackTransaction();
				break;
			}
			$this->logger->logDebug("Transaction running, delaying load.");
			sleep(self::DELAY);
		}
		$this->logger->logInfo("Load transaction failed: [id: $id, strategy: $strategy]: $message");
		return null;
	}

	private function loadTransactionByStrategy($id, $strategy, $useCache = false){
		switch ($strategy) {
			case Customweb_Payment_Endpoint_Annotation_ExtractionMethod::PAYMENT_ID_KEY:
				return $this->transactionHandler->findTransactionByPaymentId($id, $useCache);
			case Customweb_Payment_Endpoint_Annotation_ExtractionMethod::TRANSACTION_ID_KEY:
				return $this->transactionHandler->findTransactionByTransactionId($id, $useCache);
			case self::EXTRACTION_METHOD_UNZ_PAYMENT_ID:
			case self::EXTRACTION_METHOD_TYPE_ID:
				$transactionId = $this->readId($strategy, $id);
				return $this->transactionHandler->findTransactionByTransactionExternalId($transactionId, $useCache);
			case Customweb_Payment_Endpoint_Annotation_ExtractionMethod::EXTERNAL_TRANSACTION_ID_KEY:
			default:
				return $this->transactionHandler->findTransactionByTransactionExternalId($id, $useCache);
		}
	}
	
	/**
	 * Register a type ID so transactions may be loaded using it.
	 * 
	 * @param string $typeId
	 * @param string $externalTransactionId
	 */
	public function registerTypeId($typeId, $externalTransactionId) {
		$this->registerId(self::EXTRACTION_METHOD_TYPE_ID, $typeId, $externalTransactionId);
	}
	
	/**
	 * Register an unzer payment ID so transactions may be loaded using it.
	 *
	 * @param string $typeId
	 * @param string $externalTransactionId
	 */
	public function registerPaymentId($paymentId, $externalTransactionId) {
		$this->registerId(self::EXTRACTION_METHOD_UNZ_PAYMENT_ID, $paymentId, $externalTransactionId);
	}
	
	private function registerId($strategy, $id, $externalTransactionId) {
		$key = self::getStorageKey($strategy, $id);
		$this->logger->logDebug("Registering transaction load [$key => $externalTransactionId]");
		$this->storageHelper->writeStorage($key, $externalTransactionId);
	}
	
	/**
	 * Load transaction by unz type id (e.g. s-crd-xx)
	 * 
	 * @param string $id
	 * @param boolean $useCache
	 * @return Customweb_Payment_Authorization_ITransaction
	 */
	private function loadTransactionByTypeId($id, $useCache = false) {
		$this->logger->logDebug("Attempting to load transaction via type id: $id.");
		$transactionId = $this->readId(self::EXTRACTION_METHOD_TYPE_ID, $id);
		return $this->transactionHandler->findTransactionByTransactionExternalId($transactionId, $useCache);
	}
	
	/**
	 * Load transaction by unz payment id (s-pay-xx).
	 * Due to short id being preferred as paymentId, must manually map
	 * 
	 * @param string $id
	 * @param boolean $useCache
	 * @return Customweb_Payment_Authorization_ITransaction
	 */
	private function loadTransactionByUnzPaymentId($id, $useCache = false) {
		$this->logger->logDebug("Attempting to load transaction via unzer payment id: $id.");
		$transactionId = $this->readId(self::EXTRACTION_METHOD_UNZ_PAYMENT_ID, $id);
		return $this->transactionHandler->findTransactionByTransactionExternalId($transactionId, $useCache);
	}
	
	private function readId($strategy, $id) {
		return $this->storageHelper->readStorage(self::getStorageKey($strategy, $id));
	}
	
	private static function getStorageKey($strategy, $id) {
		return $strategy . '-' . $id;
		
	}
}
