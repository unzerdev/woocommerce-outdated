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

require_once 'Customweb/Payment/ITransactionHandler.php';
require_once 'Customweb/Payment/Exception/OptimisticLockingException.php';
require_once 'Customweb/Payment/Entity/AbstractTransaction.php';



/**
 *
 * @author Thomas Hunziker
 * @Bean
 */
class Customweb_Payment_TransactionHandler implements Customweb_Payment_ITransactionHandler {
	
	/**
	 *
	 * @var Customweb_Database_Entity_IManager
	 */
	private $manager = null;
	
	/**
	 *
	 * @var Customweb_Database_IDriver
	 */
	private $driver = null;
	
	/**
	 *
	 * @var string
	 */
	private $transactionClassName = null;

	/**
	 * @Inject({'Customweb_Database_Entity_IManager', 'databaseTransactionClassName', 'Customweb_Database_IDriver'})
	 */
	public function __construct(Customweb_Database_Entity_IManager $manager, $transactionClassName, Customweb_Database_IDriver $driver){
		$this->manager = $manager;
		$this->transactionClassName = $transactionClassName;
		$this->driver = $driver;
	}

	public function isTransactionRunning(){
		return $this->getDriver()->isTransactionRunning();
	}

	public function beginTransaction(){
		return $this->getDriver()->beginTransaction();
	}

	public function commitTransaction(){
		return $this->getDriver()->commit();
	}

	public function rollbackTransaction(){
		return $this->getDriver()->rollBack();
	}

	public function findTransactionByTransactionExternalId($transactionId, $useCache = true){
		return $this->findTransactionEntityByTransactionExternalId($transactionId, $useCache)->getTransactionObject();
	}

	/**
	 *
	 * @param string $transactionId
	 * @throws Exception
	 * @return Customweb_Payment_Entity_AbstractTransaction
	 */
	protected function findTransactionEntityByTransactionExternalId($transactionId, $useCache = true){
		$transactions = $this->getManager()->searchByFilterName($this->getTransactionClassName(), 'loadByExternalId', 
				array(
					'>transactionExternalId' => $transactionId 
				), $useCache);
		if (count($transactions) !== 1) {
			throw new Exception("Transaction could not be loaded by the external transaction id.");
		}
		$transaction = end($transactions);
		if (!($transaction instanceof Customweb_Payment_Entity_AbstractTransaction)) {
			throw new Exception("Transaction must be of type Customweb_Payment_Entity_AbstractTransaction");
		}
		return $transaction;
	}

	public function findTransactionByPaymentId($paymentId, $useCache = true){
		$transactions = $this->getManager()->searchByFilterName($this->getTransactionClassName(), 'loadByPaymentId', 
				array(
					'>paymentId' => $paymentId 
				), $useCache);
		if (count($transactions) !== 1) {
			throw new Exception("Transaction could not be loaded by the payment id.");
		}
		$transaction = end($transactions);
		if (!($transaction instanceof Customweb_Payment_Entity_AbstractTransaction)) {
			throw new Exception("Transaction must be of type Customweb_Payment_Entity_AbstractTransaction");
		}
		return $transaction->getTransactionObject();
	}

	public function findTransactionByTransactionId($transactionId, $useCache = true){
		$transaction = $this->getManager()->fetch($this->getTransactionClassName(), $transactionId, $useCache);
		if (!($transaction instanceof Customweb_Payment_Entity_AbstractTransaction)) {
			throw new Exception("Transaction must be of type Customweb_Payment_Entity_AbstractTransaction");
		}
		return $transaction->getTransactionObject();
	}

	public function findTransactionsByOrderId($orderId, $useCache = true){
		$transactions = $this->getManager()->searchByFilterName($this->getTransactionClassName(), 'loadByOrderId', array(
			'>orderId' => $orderId 
		), $useCache);
		$rs = array();
		foreach ($transactions as $transaction) {
			if (!($transaction instanceof Customweb_Payment_Entity_AbstractTransaction)) {
				throw new Exception("Transaction must be of type Customweb_Payment_Entity_AbstractTransaction");
			}
			if ($transaction->getTransactionObject() !== null) {
				$rs[$transaction->getTransactionId()] = $transaction->getTransactionObject();
			}
		}
		
		return $rs;
	}

	public function persistTransactionObject(Customweb_Payment_Authorization_ITransaction $transactionObject){
		$transaction = $this->getManager()->fetch($this->getTransactionClassName(), $transactionObject->getTransactionId(), false);
		if (!($transaction instanceof Customweb_Payment_Entity_AbstractTransaction)) {
			throw new Exception("Unable to find transaction with id " . $transactionObject->getTransactionId() . ".");
		}
		if($transaction->getAuthorizationStatus() == Customweb_Payment_Entity_AbstractTransaction::AUTHORIZATION_STATUS_AUTHORIZING) {
			throw new Customweb_Payment_Exception_OptimisticLockingException($transaction->getTransactionId());
		}
		if ($transaction->isAuthorizationRequired($transactionObject)) {
			$transaction->setAuthorizationStatus(Customweb_Payment_Entity_AbstractTransaction::AUTHORIZATION_STATUS_AUTHORIZING);
			$transaction->setSkipOnSaveMethods(true);
			try {
				$this->getManager()->persist($transaction);
			}
			catch (Customweb_Database_Entity_Exception_OptimisticLockingException $e) {
				throw new Customweb_Payment_Exception_OptimisticLockingException($transaction->getTransactionId());
			}
			$transaction = $this->getManager()->fetch($this->getTransactionClassName(), $transactionObject->getTransactionId(), false);
			if (!method_exists($transactionObject, 'setVersionNumber')) {
				throw new Exception('setVersionNumber function is required on the transactionObject.');
			}
			$transactionObject->setVersionNumber($transaction->getVersionNumber());
		}		
		$transaction->setTransactionObject($transactionObject);
		try {
			$this->getManager()->persist($transaction);
		}
		catch (Customweb_Database_Entity_Exception_OptimisticLockingException $e) {
			throw new Customweb_Payment_Exception_OptimisticLockingException($transaction->getTransactionId());
		}
	}

	protected function getManager(){
		return $this->manager;
	}

	protected function getDriver(){
		return $this->driver;
	}

	protected function getTransactionClassName(){
		return $this->transactionClassName;
	}
}