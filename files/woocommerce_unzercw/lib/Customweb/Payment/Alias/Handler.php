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

require_once 'Customweb/Payment/Entity/AbstractTransaction.php';
require_once 'Customweb/Payment/Alias/IRemoveAdapter.php';


/**
 * @Bean
 * @author Thomas Hunziker / Simon Schurter
 */
class Customweb_Payment_Alias_Handler {

	/**
	 * @var Customweb_Database_Entity_IManager
	 */
	private $manager = null;

	private $transactionClassName = null;

	/**
	 * @var Customweb_DependencyInjection_IContainer
	 */
	private $container = null;

	/**
	 *
	 * @Inject({'Customweb_Database_Entity_IManager', 'Customweb_DependencyInjection_IContainer', 'databaseTransactionClassName'})
	 */
	public function __construct(Customweb_Database_Entity_IManager $manager, Customweb_DependencyInjection_IContainer $container, $transactionClassName) {
		$this->manager = $manager;
		$this->transactionClassName = $transactionClassName;
		$this->container = $container;
	}

	/**
	 * Fetches a list of transaction which can be used as alias transactions for the given order context.
	 *
	 * @param Customweb_Payment_Authorization_IOrderContext $orderContext
	 * @return Customweb_Payment_Entity_AbstractTransaction[]
	 */
	public function getAliasTransactions(Customweb_Payment_Authorization_IOrderContext $orderContext) {
		$customerId = $orderContext->getCustomerId();
		if (empty($customerId)) {
			return array();
		}

		$transactions = $this->manager->search(
			$this->transactionClassName,
			'customerId = >customerId AND paymentMachineName = >paymentMethodName AND aliasActive = "y" AND aliasForDisplay IS NOT NULL AND aliasForDisplay != ""',
			'createdOn DESC', array(
				'>customerId' => $customerId,
				'>paymentMethodName' => $orderContext->getPaymentMethod()->getPaymentMethodName(),
			)
		);

		$result = array();
		foreach ($transactions as $transaction) {
			/* @var $transaction Customweb_Payment_Entity_AbstractTransaction */
			if (!isset($result[$transaction->getAliasForDisplay()])) {
				$result[$transaction->getAliasForDisplay()] = $transaction;
			}
		}

		return $result;
	}

	/**
	 * Removes the given alias from the database. In case it can be also removed on the remote system it will be also
	 * removed their.
	 *
	 * @param int $transactionId
	 * @throws Exception
	 */
	public function removeAlias($transactionId) {
		$transaction = $this->manager->fetch($this->transactionClassName, $transactionId);
		if (!($transaction instanceof Customweb_Payment_Entity_AbstractTransaction)) {
			throw new Exception("Transaction must be of type Customweb_Payment_Entity_AbstractTransaction");
		}
		$this->deactivateAlias($transactionId);

		if ($this->container->hasBean('Customweb_Payment_Alias_IRemoveAdapter')) {
			$removeAdapter = $this->container->getBean('Customweb_Payment_Alias_IRemoveAdapter');
			if (!($removeAdapter instanceof Customweb_Payment_Alias_IRemoveAdapter)) {
				throw new Exception("Remove adapter must be of type 'Customweb_Payment_Alias_IRemoveAdapter'");
			}
			$removeAdapter->remove($transaction->getTransactionObject());
			$this->manager->persist($transaction);
		}
	}

	/**
	 * Deactivates the alias. It is not selected anymore by getAliasTransactions().
	 *
	 * @param int $transactionId
	 * @throws Exception
	 */
	public function deactivateAlias($transactionId) {
		$transaction = $this->manager->fetch($this->transactionClassName, $transactionId);
		if (!($transaction instanceof Customweb_Payment_Entity_AbstractTransaction)) {
			throw new Exception("Transaction must be of type Customweb_Payment_Entity_AbstractTransaction");
		}
		$transaction->setAliasActive(false);
		$this->manager->persist($transaction);
	}


}
