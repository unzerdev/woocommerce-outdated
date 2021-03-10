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

require_once 'Customweb/Payment/Authorization/Moto/IAdapter.php';
require_once 'Customweb/Payment/Authorization/AbstractAdapterWrapper.php';

abstract class Customweb_Payment_Authorization_Recurring_AbstractWrapper extends Customweb_Payment_Authorization_AbstractAdapterWrapper
implements Customweb_Payment_Authorization_Recurring_IAdapter
{
	/**
	 * @var Customweb_Payment_Authorization_Recurring_IAdapter
	 */
	private $adapter = null;
	
	public function __construct($adapter) {
		parent::__construct($adapter);
		$this->adapter = $adapter;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_Moto_IAdapter::createTransaction()
	 */
	public function createTransaction(Customweb_Payment_Authorization_Recurring_ITransactionContext $transactionContext) {
		return $this->adapter->createTransaction($transactionContext);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_Recurring_IAdapter::isPaymentMethodSupportingRecurring()
	 */
	public function isPaymentMethodSupportingRecurring(Customweb_Payment_Authorization_IPaymentMethod $paymentMethod) {
		return $this->adapter->isPaymentMethodSupportingRecurring($paymentMethod);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_Recurring_IAdapter::process()
	 */
	public function process(Customweb_Payment_Authorization_ITransaction $transaction) {
		return $this->adapter->process($transaction);
	}
	

}