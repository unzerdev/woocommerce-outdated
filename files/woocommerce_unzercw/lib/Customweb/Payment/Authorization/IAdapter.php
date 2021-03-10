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

require_once 'Customweb/Payment/Authorization/IOrderContext.php';
require_once 'Customweb/Payment/Authorization/IPaymentCustomerContext.php';

interface Customweb_Payment_Authorization_IAdapter {
	
	/**
	 * This value defines the priority of the adapter. The adapter
	 * with the lowest priority is the last one use and it is the fallback 
	 * for all other adapters.
	 * 
	 * @return int
	 */
	public function getAdapterPriority();
		
	/**
	 * Returns the authorization name. The name should not contain any whitespaces and 
	 * it should not be localized.
	 * 
	 * @return string
	 */
	public function getAuthorizationMethodName();
	
	/**
	 * This method checks whether the given authorization method is supported for 
	 * this transaction or not.
	 * 
	 * @param Customweb_Payment_Authorization_IOrderContext $transaction
	 * @return boolean True when the authorization method is supported. False if not.
	 */
	public function isAuthorizationMethodSupported(Customweb_Payment_Authorization_IOrderContext $orderContext);

	/**
	 * This method checks whether deferred capturing is supported and hence it can
	 * be forced on the ITransactionContext.
	 * 
	 * @param Customweb_Payment_Authorization_IOrderContext $orderContext The order context
	 * @param Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext
	 * @return boolean Either true, when it is suppored or false, when it is not supported.
	 */
	public function isDeferredCapturingSupported(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext);
	
	
	/**
	 * This method checks whether the given order in the given payment context is
	 * processable or not. If it is not processable an exception is thrown.
	 * 
	 * In any case the call has to make sure that the $paymentContext is stored.
	 * Independent if an exception was thrown or not. (The initialization and 
	 * storage of the $paymentContext must be done outside of the try / catch 
	 * block.)
	 * 
	 * This method can be called before the payment method selection is done. 
	 * 
	 * @param Customweb_Payment_Authorization_IOrderContext $orderContext
	 * @param Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext
	 * 		The context for this payment.
	 * @throws Exception In case the order can not be processed an exception is thrown.
	 * @return void
	 */
	public function preValidate(Customweb_Payment_Authorization_IOrderContext $orderContext, 
			Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext);
	
	/**
	 * This method validates the order context including the provide formData. This method is called
	 * after the payment method is selected and the user may entered some data. 
	 * 
	 * @param Customweb_Payment_Authorization_IOrderContext $orderContext
	 * @param Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext
	 * @param array $formData
	 * @throws Exception In case the order can not be processed an exception is thrown.
	 * @return void
	 */
	public function validate(Customweb_Payment_Authorization_IOrderContext $orderContext, 
			Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext, array $formData);
	
	
	
	
}