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

/**
 * This interface defines a context of a checkout.
 * During the checkout
 * this context is used to exchange the information between the provider
 * and the e-commerce solution.
 *
 *
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_ExternalCheckout_IContext {
	
	/**
	 * This state is set when the context was changed by the provider.
	 * Hence
	 * the context can not be reused by another provider. In this case a new
	 * context must be created.
	 */
	const STATE_PENDING = 'pending';
	
	/**
	 * The context was used to create an order.
	 */
	const STATE_COMPLETED = 'completed';
	
	/**
	 * The context was not usable to create an order.
	 * The failed error message
	 * may give more information about why the order could not be completed.
	 */
	const STATE_FAILED = 'failed';

	/**
	 * Returns a unique id of the context.
	 * The id is used to identify
	 * the checkout in the remote system. The id is never changed
	 * during one checkout process.
	 * 
	 * This id is always a numeric value.
	 *
	 * @return string
	 */
	public function getContextId();

	/**
	 * Returns the state of the context.
	 * see the
	 * constants for all possible states.
	 *
	 * @return string
	 */
	public function getState();

	/**
	 * Returns an error message why the context could not be used to complete the checkout.
	 *
	 * @return string
	 */
	public function getFailedErrorMessage();

	/**
	 * Returns an URL of the shopping cart.
	 * The customer is sent to this URL back, when
	 * something goes wrong during the checkout or when the customer cancels 
	 * the process.
	 * 
	 * In case of an error, the context's error message has to be shown on 
	 * the cart page. Therefore it must be possible to load the current context
	 * in the cart.
	 *
	 * @return string URL of the basket inside the e-commerce solution.
	 */
	public function getCartUrl();
	
	/**
	 * Returns an URL on which the customer is able to complete the checkout 
	 * with the default checkout process of the e-commerce solution.
	 * 
	 * @return string
	 */
	public function getDefaultCheckoutUrl();

	/**
	 * Returns a list of line items in the cart.
	 * The items may be modified during a
	 * checkout session according to changes done on the shipping method, the payment method,
	 * the billing address or the shipping address.
	 *
	 * @return Customweb_Payment_Authorization_IInvoiceItem[]
	 */
	public function getInvoiceItems();

	/**
	 * The order amount in decimal / float representation in the currency
	 * given by the method self::getCurrencyCode().
	 *
	 *
	 * @return float
	 */
	public function getOrderAmountInDecimals();

	/**
	 * The currency code in ISO format.
	 *
	 * @return String ISO code of the currency used for the transactions.
	 */
	public function getCurrencyCode();

	/**
	 * This method returns the language spoken by the customer.
	 * This should
	 * be remain the same during the whole checkout.
	 *
	 * @return Customweb_Core_Language
	 */
	public function getLanguage();

	/**
	 * Returns the customer e-mail address of the customer.
	 * This method may
	 * return null in the initial state of the checkout.
	 *
	 * @return string E-Mail address of the customer.
	 */
	public function getCustomerEmailAddress();

	/**
	 * Returns the customer id as defined by the e-commerce solution.
	 * The
	 * customer account is created during the creation of the order hence
	 * this can be null until the order is created.
	 *
	 * @return string
	 */
	public function getCustomerId();

	/**
	 * Returns the transaction id.
	 * This method will return null until the order
	 * is created.
	 *
	 * @return string
	 */
	public function getTransactionId();

	/**
	 * Returns the shipping address.
	 * This method returns in the initial state
	 * null. The address should be set with self::setShippingAddress()
	 *
	 * @return Customweb_Payment_Authorization_OrderContext_IAddress
	 */
	public function getShippingAddress();

	/**
	 * Returns the billing address.
	 * This method returns in the initial state
	 * null.
	 *
	 * @return Customweb_Payment_Authorization_OrderContext_IAddress
	 */
	public function getBillingAddress();

	/**
	 * Returns the current set shipping method.
	 * At the initial state of
	 * the checkout this method will normally return null.
	 *
	 * @return string
	 */
	public function getShippingMethodName();

	/**
	 * Returns the payment method set for this checkout.
	 * At the initial state this
	 * method will return null.
	 *
	 * @return Customweb_Payment_Authorization_IPaymentMethod
	 */
	public function getPaymentMethod();
	
	/**
	 * Returns an array with provider data.
	 * 
	 * This data can be set over the checkout service.
	 * 
	 * @return array
	 */
	public function getProviderData();
	
}