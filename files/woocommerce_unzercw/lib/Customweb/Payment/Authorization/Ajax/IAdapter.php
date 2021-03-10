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


interface Customweb_Payment_Authorization_Ajax_IAdapter extends Customweb_Payment_Authorization_IAdapter {
	
	const AUTHORIZATION_METHOD_NAME = 'AjaxAuthorization';
	
	/**
	 * This method creates a new transaction object for the given $transactionContext.
	 * The transaction object must be supplied to all further actions. Hence
	 * the client must ensure the persistence of this object.
	 *
	 * @param Customweb_Payment_Authorization_PaymentPage_ITransactionContext $transactionContext
	 * @return Customweb_Payment_Authorization_ITransaction Transaction object
	 */
	public function createTransaction(Customweb_Payment_Authorization_Ajax_ITransactionContext $transactionContext, $failedTransaction);
	
	/**
	 * This method has to return the URL on which the Ajax functions for processing
	 * payments can be found. This script is embedded into the HTML page on
	 * which also the payment form is presented to the customer.
	 * 
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @return string JavaScript File URL
	 */
	public function getAjaxFileUrl(Customweb_Payment_Authorization_ITransaction $transaction);
	
	/**
	 * This method must return a JavaScript callback function. This callback
	 * function is invoked, after the user accepts the order. The callback function
	 * receives as a function argument the values of the fields filled in by the
	 * user.
	 * 
	 * The method has to call either the success or failed callback function
	 * provided by the TransactionContext. 
	 * 
	 * In case the PSP does not allow the calling of a notification URL in the
	 * background, this callback function has to do an Ajax call to the 
	 * Ajax notification URL given by the TransactionContext.
	 * 
	 * A sample callback function:
	 * <code>
	 * function (formFieldValues) {
	 *     var params = {
	 *        'account_id': 'whaterver',
	 *        'amount': '560.00',
	 *        'currency': 'EUR',
	 *        'callback': function() {
	 *            if (success) {
	 *        	      theSuccessCallbackFunctionFromTheTransactionContext(successRedirectUrl);
	 *            }
	 *            else {
	 *                theFailedCallbackFunctionFromTheTransactionContext(errorRedirectUrl);
	 *            }
	 *         }
	 *     };
	 *     aJavaScriptMethodFromPsp(params, formFieldValues);
	 * }
	 * </code>
	 * 
	 * If the payment process function of the PSP required to evaluate the data
	 * before calling the success or failed callback, a custom function may be added
	 * through self::getJavaScriptCode().
	 * 
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @return string Callback function
	 */
	public function getJavaScriptCallbackFunction(Customweb_Payment_Authorization_ITransaction $transaction);
	
		
	/**
	 * This method returns all visible form fields for this payment method. This
	 * fields must be filled in by the customer. 
	 * 
	 * The $failedTransaction is a transaction that is generated previously in the order process. It can be used to provide 
	 * more information on the form whats wrong with the user input. $failedTransaction can be NULL.
	 * 
	 * @param Customweb_Payment_Authorization_IOrderContext $orderContext The context of the order 
	 * @param Customweb_Payment_Authorization_ITransaction $aliasTransaction The alias to use with this form field. If NULL no alias is used.
	 * @param Customweb_Payment_Authorization_ITransaction $failedTransaction A previous transaction which may provide additional information.
	 * @param Customweb_payment_authorization_IPaymentCustomerContext $paymentCustomerContext The payment customer context.
	 * @return Customweb_Form_IElement[] List of visible form fields for this payment method.
	 */
	public function getVisibleFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, 
			$aliasTransaction, 
			$failedTransaction,
			$paymentCustomerContext);
	
}