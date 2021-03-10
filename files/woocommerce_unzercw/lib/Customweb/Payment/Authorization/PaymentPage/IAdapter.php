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
require_once 'Customweb/Payment/Authorization/PaymentPage/IAdapter.php';


/**
 * This interface defines the methods available for the interaction with a payment
 * page implementation.
 *
 * The payment page is the simplest possible payment integration type. The customer
 * is redirected to the payment service provider. The payment service provider
 * collects the credentials in a PCI-DSS compliant environment.
 *
 * The redirection of the customer can be done in two ways:
 * <ul>
 *   <li>By using the Customweb_Payment_Authorization_PaymentPage_IAdapter::getRedirectionUrl() and a
 *   redirection with a HTTP header or</li>
 *   <li>by adding a form with the Customweb_Payment_Authorization_PaymentPage_IAdapter::getFormActionUrl()
 *   as the form action and with a set of hidden fields from the method
 *   Customweb_Payment_Authorization_PaymentPage_IAdapter::getParameters().</li>
 * </ul>
 * 
 * The client of this adapter must follow the following steps:
 * <ol>
 *   <li>Show the form producible by self::getVisibleFormFields(). The target of this form must be the shop server.</li>
 *   <li>Collect the data sent by the customer.</li>
 *   <li>Decide which redirection method is appropriate. Use therefore the method self::isHeaderRedirectionSupported().</li>
 *   <li>Redirect the customer by the selected redireciton method.</li>
 * </ol>
 *
 * The implementor of this interface has to make sure, that the class is imutable.
 *
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_Authorization_PaymentPage_IAdapter extends Customweb_Payment_Authorization_IAdapter {

	const AUTHORIZATION_METHOD_NAME = 'PaymentPage';
	
	/**
	 * This method creates a new transaction object for the given $transactionContext.
	 * The transaction object must be supplied to all further actions. Hence
	 * the client must ensure the persistence of this object.
	 *
	 * @param Customweb_Payment_Authorization_PaymentPage_ITransactionContext $transactionContext
	 * @return Customweb_Payment_Authorization_ITransaction Transaction object
	 */
	public function createTransaction(Customweb_Payment_Authorization_PaymentPage_ITransactionContext $transactionContext, $failedTransaction);
	
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
	 * @param Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext The payment customer context.
	 * @return Customweb_Form_IElement[] List of visible form fields for this payment method.
	 */
	public function getVisibleFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext,
			$aliasTransaction,
			$failedTransaction, $paymentCustomerContext);
	
	/**
	 * This method checks whether the API supports for this transaction a header
	 * redirection or not. The client has to make sure that he is calling always
	 * this method first before using the self::getRedirectionUrl() method.
	 *
	 * If this method returns false, the client has to use the second redirection variant
	 * with a form.
	 *
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @param array $formData The form field data collected by showing self::getVisibleFormFields() form fields.
	 * @return boolean True, when a HTTP header redirection is possible.
	 */
	public function isHeaderRedirectionSupported(Customweb_Payment_Authorization_ITransaction $transaction, array $formData);
	
	/**
	 * This method creates the URL for redirecting the customer to the payment page.
	 *
	 * @param array $formData The form field data collected by showing self::getVisibleFormFields() form fields.
	 * @return String The URL for redirection
	 */
	public function getRedirectionUrl(Customweb_Payment_Authorization_ITransaction $transaction, array $formData);

	/**
	 * This method returns a map of parameters to invoke the payment page.
	 *
	 * @param array $formData The form field data collected by showing self::getVisibleFormFields() form fields.
	 * @return array Map of Parameters (Key / Value Pairs)
	 */
	public function getParameters(Customweb_Payment_Authorization_ITransaction $transaction, array $formData);

	/**
	 * This method returns the URL to which the payment page form must point to.
	 *
	 * @param array $formData The form field data collected by showing self::getVisibleFormFields() form fields.
	 * @return String URL to the payment page for HTML forms
	 */
	public function getFormActionUrl(Customweb_Payment_Authorization_ITransaction $transaction, array $formData);

}