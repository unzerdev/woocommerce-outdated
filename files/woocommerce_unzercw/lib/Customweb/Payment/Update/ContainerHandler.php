<?php 
/**
  * You are allowed to use this API in your web application.
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

require_once 'Customweb/Payment/Update/IHandler.php';
require_once 'Customweb/Payment/Entity/AbstractTransaction.php';


/**
 * 
 * @author Thomas Hunziker / Simon Schurter
 * @Bean
 */
class Customweb_Payment_Update_ContainerHandler implements Customweb_Payment_Update_IHandler {
	
	/**
	 * @var Customweb_Database_Entity_IManager
	 */
	private $manager = null;
	
	/**
	 * @var Customweb_Database_IDriver
	 */
	private $driver = null;
	
	private $transactionClassName = null;
	
	/**
	 * @var Customweb_DependencyInjection_IContainer
	 */
	private $container = null;
	
	/**
	 * 
	 * @Inject({'Customweb_Database_Entity_IManager', 'Customweb_DependencyInjection_IContainer', 'databaseTransactionClassName', 'Customweb_Database_IDriver'})
	 */
	public function __construct(Customweb_Database_Entity_IManager $manager, Customweb_DependencyInjection_IContainer $container, $transactionClassName, Customweb_Database_IDriver $driver) {
		$this->manager = $manager;
		$this->transactionClassName = $transactionClassName;
		$this->container = $container;
		$this->driver = $driver;
	}
		
	public function getContainer() {
		return $this->container;
	}

	public function beginTransaction() {
		$this->driver->beginTransaction();
	}

	public function commitTransaction() {
		$this->driver->commit();
	}

	public function loadTransactionObject($transactionId) {
		return $this->loadTransaction($transactionId)->getTransactionObject();
	}

	public function persistTransactionObject($transactionId, Customweb_Payment_Authorization_ITransaction $transactionObject) {
		$transaction = $this->loadTransaction($transactionId)->setTransactionObject($transactionObject);
		$this->manager->persist($transaction);
	}

	public function findTransactionIdByPaymentId($paymentId) {
		$transactions = $this->manager->searchByFilterName($this->transactionClassName, 'loadByPaymentId', array('>paymentId' => $paymentId));
		if (count($transactions) !== 1) {
			throw new Exception("Transaction could not be loaded by payment id.");
		}
		$transaction = end($transactions);
		if (!($transaction instanceof Customweb_Payment_Entity_AbstractTransaction)) {
			throw new Exception("Transaction must be of type Customweb_Payment_Entity_AbstractTransaction");
		}
		return $transaction->getTransactionId();
	}

	public function log($message, $type) {
		// Should be overriden
	}

	public function getRequestParameters() {
		return $_REQUEST;
	}

	public function getScheduledTransactionIds() {
		$primaryKeys = $this->manager->searchPrimaryKey(
				$this->transactionClassName,
				'executeUpdateOn IS NOT NULL AND executeUpdateOn < NOW() LIMIT 0,' . (int)$this->getMaxNumberOfTransaction()
		);
		if (count($primaryKeys) < 1) {
			throw new Exception("No Scheduled Transactions found.");
		}
		return $primaryKeys;
	}
	
	protected function loadTransaction($transactionId) {
		$transaction = $this->manager->fetch($this->transactionClassName, $transactionId);
		if (!($transaction instanceof Customweb_Payment_Entity_AbstractTransaction)) {
			throw new Exception("Transaction must be of type Customweb_Payment_Entity_AbstractTransaction");
		}
		return $transaction;
	}
	
	/**
	 * Returns the maximal number of transaction, which should be loaded to process in one update iteration.
	 * 
	 * @return number
	 */
	protected function getMaxNumberOfTransaction() {
		return 100;
	}

}