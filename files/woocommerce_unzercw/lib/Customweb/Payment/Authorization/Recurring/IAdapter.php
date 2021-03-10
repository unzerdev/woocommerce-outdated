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

require_once 'Customweb/Payment/Authorization/IAdapter.php';


interface Customweb_Payment_Authorization_Recurring_IAdapter extends Customweb_Payment_Authorization_IAdapter{

	const AUTHORIZATION_METHOD_NAME = 'Recurring';

	/**
	 * This method returns true, when the given payment method supports recurring payments.
	 *
	 * @param Customweb_Payment_Authorization_IPaymentMethod $paymentMethod
	 * @return boolean
	 */
	public function isPaymentMethodSupportingRecurring(Customweb_Payment_Authorization_IPaymentMethod $paymentMethod);

	/**
	 * This method creates a new recurring transaction.
	 *
	 * @param Customweb_Payment_Authorization_Recurring_ITransactionContext $transactionContext
	 */
	public function createTransaction(Customweb_Payment_Authorization_Recurring_ITransactionContext $transactionContext);

	/**
	 * This method debits the given recurring transaction on the customers card.
	 *
	 * The implementor of this method must make sure that the HTTP call to the processor
	 * is reliable. Means this method may be called more than once per transaction and hence
	 * the implementor must make sure that in those cases only one charge on the customer
	 * account is created. The best approach is using the transaction id (or order id) as the
	 * primary identifier. When the processor should ignore transactions with the same id. In case
	 * the processor expects the execution in two phases. The creation phase can be done in
	 * createTransaction() and the charge phase can be done in the process() method.
	 *
	 * The client of this method should save the transaction in case an exception is thrown.
	 *
	 * If the payment failed, this method throws an Customweb_Payment_Exception_RecurringPaymentErrorException. In this case, the subscription is moved to the 'failed' state.
	 *
	 * If a general error occurred, an Exception is thrown. In this case, the subscription is moved to the 'error' state.
	 *
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @throws Customweb_Payment_Exception_RecurringPaymentErrorException If a payment error occurred
	 * @throws Exception If a general error occurred
	 * @return void
	 */
	public function process(Customweb_Payment_Authorization_ITransaction $transaction);

}
