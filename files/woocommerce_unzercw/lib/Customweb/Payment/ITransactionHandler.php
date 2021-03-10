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
interface Customweb_Payment_ITransactionHandler {

	/**
	 * Returns true, when a database transaction is
	 * running.
	 * Hence the calling of beginTransaction()
	 * will throw an exception.
	 *
	 * @return boolean
	 */
	public function isTransactionRunning();

	/**
	 * Starts a database transaction.
	 *
	 * @return void
	 */
	public function beginTransaction();

	/**
	 * Commits a database transaction.
	 *
	 * @return void
	 */
	public function commitTransaction();

	/**
	 * Rollbacks a database transaction.
	 *
	 * @return void
	 */
	public function rollbackTransaction();

	/**
	 * Loads a transaction object by the given transaction number.
	 * The transaction number
	 * is the value returned by Customweb_Payment_Authorization_ITransaction::getExternalTransactionId()
	 *
	 *
	 * @param string $transactionNumber
	 * @param boolean $useCache
	 * @return Customweb_Payment_Authorization_ITransaction
	 */
	public function findTransactionByTransactionExternalId($transactionId, $useCache = true);

	/**
	 * Loads a transaction object by the given payment id.
	 * The payment id is the value returned
	 * by Customweb_Payment_Authorization_ITransaction::getPaymentId()
	 *
	 * @param string $paymentId
	 * @param boolean $useCache
	 * @return Customweb_Payment_Authorization_ITransaction
	 */
	public function findTransactionByPaymentId($paymentId, $useCache = true);

	/**
	 * Loads a transaction object by the given transaction id.
	 * This is the shop
	 * internal id not the number returned by Customweb_Payment_Authorization_ITransaction::getTransactionId().
	 *
	 * @param string $transactionNumber
	 * @param boolean $useCache
	 * @return Customweb_Payment_Authorization_ITransaction
	 */
	public function findTransactionByTransactionId($transactionId, $useCache = true);

	/**
	 * This method finds all transactions related to the given order id.
	 *
	 * @param string $orderId
	 * @param boolean $useCache
	 * @return Customweb_Payment_Authorization_ITransaction[]
	 */
	public function findTransactionsByOrderId($orderId, $useCache = true);

	/**
	 * Persists a given transaction object into the database.
	 * This function throws an Customweb_Payment_Exception_OptimisticLockingException, if the transaction object could not be persisted because the
	 * optimistic locking failed.
	 *
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @return void
	 * @throws Customweb_Payment_Exception_OptimisticLockingException
	 */
	public function persistTransactionObject(Customweb_Payment_Authorization_ITransaction $transaction);
}
