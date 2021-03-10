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


interface Customweb_Payment_Authorization_AdvancedFrame_IAdapter extends Customweb_Payment_Authorization_IAdapter {
	
	const AUTHORIZATION_METHOD_NAME = 'AdvancedFrameAuthorization';
	
	public function getJavaScriptUrl(Customweb_Payment_Authorization_IOrderContext $orderContext, 
			$aliasTransaction, 
			$failedTransaction,
			$paymentCustomerContext);

	public function getJavaScriptFormCreationCallbackFunction(Customweb_Payment_Authorization_IOrderContext $orderContext,
			$aliasTransaction,
			$failedTransaction,
			$paymentCustomerContext);

	public function getJavaScriptValidationCallbackFunction(Customweb_Payment_Authorization_IOrderContext $orderContext,
			$aliasTransaction,
			$failedTransaction,
			$paymentCustomerContext);
	

	public function getJavaScriptSubmitCallbackFunction(Customweb_Payment_Authorization_ITransaction $transaction);

	/**
	 * This method creates a new transaction object for the given $transactionContext.
	 * The transaction object must be supplied to all further actions. Hence
	 * the client must ensure the persistence of this object.
	 *
	 * @param Customweb_Payment_Authorization_PaymentPage_ITransactionContext $transactionContext
	 * @return Customweb_Payment_Authorization_ITransaction Transaction object
	 */
	public function createTransaction(Customweb_Payment_Authorization_AdvancedFrame_ITransactionContext $transactionContext, $failedTransaction);
	
}