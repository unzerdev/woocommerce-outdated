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
 * This interface allows the handling of the checkout process.
 *
 * During the checkout process the user input has to be stored. This interface
 * the methods to update the following information:
 * - Provider Customer ID
 * - Shipping and Billing Address
 * - Shipping Method
 * - Payment Method
 *
 * After providing this information the checkout can be completed by
 * calling self::createOrder().
 *
 * <p>
 * This interface is implemented by the e-commerce solution. The implementation
 * must be added to the dependency injection container.
 *
 * <p>
 * The process of interaction is as follow:
 * <ol>
 * <li>Customer chooses the checkout to use.</li>
 * <li>Customer is redirect to the provider.</li>
 * <li>Customer select billing and shipping address.</li>
 * <li>Customer returns to the merchant.</li>
 * <li>Customer confirms the order on a endpoint provided by the provider.</li>
 * </ol>
 *
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_ExternalCheckout_ICheckoutService {

	/**
	 * Loads the checkout context given by the checkout id.
	 *
	 * @param string $contextId
	 * @param boolean $cache When true, load from cache when possible.
	 * @return Customweb_Payment_ExternalCheckout_IContext
	 */
	public function loadContext($contextId, $cache = true);
	
	/**
	 * The security token can be used to restrict access to the checkout process. 
	 * 
	 * This method returns always a valid security token for one hour.
	 * The checkSecurityTokenValidity() method can be used to verify that the token is valid.
	 * 
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @return string Security Token
	 */
	public function createSecurityToken(Customweb_Payment_ExternalCheckout_IContext $context);
	
	/**
	 * Checks if the given security token is valid or not.
	 * 
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @param string $token
	 * @throws Customweb_Payment_Exception_ExternalCheckoutTokenExpiredException, if the token is invalid
	 * @throws Customweb_Payment_Exception_ExternalCheckoutInvalidTokenException, if the token is expired
	 */
	public function checkSecurityTokenValidity(Customweb_Payment_ExternalCheckout_IContext $context, $token);
	
	/**
	 * Mark the context as failed.
	 * The error message should give the customer more details why
	 * the checkout fails.
	 *
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @param string $message
	 */
	public function markContextAsFailed(Customweb_Payment_ExternalCheckout_IContext $context, $message);

	/**
	 * Updates the context with given provider data. The provider data may be used to store 
	 * additional information received from the provider.
	 * 
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @param array $data
	 */
	public function updateProviderData(Customweb_Payment_ExternalCheckout_IContext $context, array $data);
	
	/**
	 * Executes an authentication of the user. This method should be used when 
	 * the provider is unable to prevent hijacking of the e-mail address.
	 * 
	 * The implementor has to make sure that the user is authenticated when he is redirected to the success URL. 
	 * The e-mail address should be also set on the context.
	 * 
	 * The provided mail address may be used as pre-filled value for the login screen.
	 * 
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @param string $emailAddress
	 * @param string $successUrl
	 * @return Customweb_Core_Http_IResponse
	 */
	public function authenticate(Customweb_Payment_ExternalCheckout_IContext $context, $emailAddress, $successUrl);
	
	/**
	 * Updates the e-mail address of the customer.
	 * The e-mail address may be used to merge
	 * the customer with an existing one. The provider has to make sure that the mail address
	 * cannot be hijacked by an attacker. In case this is not possible use the authenticate() method.
	 *
	 * The implementor has to make sure that the user is afterwards authorized in case a user account already exists.
	 * 
	 * The implementor has to handle the case, where no shipping or billing address is set on the context, when this function is called.
	 *
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @param string $emailAddress
	 * @return void
	 */
	public function updateCustomerEmailAddress(Customweb_Payment_ExternalCheckout_IContext $context, $emailAddress);

	/**
	 * Updates the shipping address.
	 * By changing the address the total
	 * amount and the shipping line items may be changed of the checkout
	 * context object.
	 *
	 * @param Customweb_Payment_ExternalCheckout_IContext $checkout
	 * @param Customweb_Payment_Authorization_OrderContext_IAddress $address
	 * @return void
	 */
	public function updateShippingAddress(Customweb_Payment_ExternalCheckout_IContext $context, Customweb_Payment_Authorization_OrderContext_IAddress $address);

	/**
	 * Updates the billing address.
	 * By changing the address the total
	 * amount and the shipping line items may be changed of the checkout
	 * context object.
	 *
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @param Customweb_Payment_Authorization_OrderContext_IAddress $address
	 * @return void
	 */
	public function updateBillingAddress(Customweb_Payment_ExternalCheckout_IContext $context, Customweb_Payment_Authorization_OrderContext_IAddress $address);

	/**
	 * Renders a selection of shipping methods.
	 * This selection is shown to the customer.
	 *
	 * <p>
	 * In case the context contains only virtual products, we may skip this step.
	 * 
	 * <p>
	 * The implementor has to make sure that the following conditions are met:
	 * - No additional form tag should be added.
	 * - A 'store shipping method' button must be added.
	 * - No back button / cancel button is allowed.
	 * - The provided error message should be shown if not empty.
	 * - The customer should not get any way to leave the page.
	 *
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @param string $errorMessages Error Message for the customer.
	 * @return string HTML of the pane.
	 */
	public function renderShippingMethodSelectionPane(Customweb_Payment_ExternalCheckout_IContext $context, $errorMessages);

	/**
	 * This method is called to update the shipping method based on the selection
	 * done by the customer.
	 * The $request contains the resulting HTTP request. The request
	 * contains the form field content.
	 *
	 * <p>
	 * After calling this method the $context needs to contain a shipping method. In case
	 * the user input is invalid the method must throw an exception. The message of the exception
	 * is shown to the customer as error message.
	 *
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @param Customweb_Core_Http_IRequest $request
	 * @return void
	 */
	public function updateShippingMethod(Customweb_Payment_ExternalCheckout_IContext $context, Customweb_Core_Http_IRequest $request);

	/**
	 * Returns a list of possible payment methods.
	 * The set of the payment methods is restricted to the
	 * one which are provided by the provider.
	 *
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @return Customweb_Payment_Authorization_IPaymentMethod[]
	 */
	public function getPossiblePaymentMethods(Customweb_Payment_ExternalCheckout_IContext $context);

	/**
	 * Updates the payment method for this checkout.
	 * The payment method
	 * should be one of the possible payment methods (see self::getPossiblePaymentMethods()).
	 *
	 * By changing the payment method the order total may be changed.
	 *
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @param Customweb_Payment_Authorization_IPaymentMethod $method
	 * @param string $errorMessage Error Message for the customer
	 * @return void
	 */
	public function updatePaymentMethod(Customweb_Payment_ExternalCheckout_IContext $context, Customweb_Payment_Authorization_IPaymentMethod $method);

	/**
	 * This method renders a review pane for the given checkout.
	 * The review pane should contain
	 * a list of products including the order total. This overview may be presented to the
	 * user as the final review step.
	 *
	 * In case the review pane should also contain the confirmation of GTC the flag is $renderGtc is
	 * set to true.
	 *
	 * The result of any user actions are validated with validateReviewForm().
	 * 
	 * The implementor has to make sure that the following requirements are fulfilled:
	 * - A list of products including all totals are shown. 
	 * - Shipping and Billing address.
	 * - No link to leave the page.
	 * - Render a confirmation button if '$renderConfirmationFormElements' is true.
	 * - Render GTC checkbox if '$renderConfirmationFormElements' is true and if the merchant wants that.
	 * - If the confirmation is not possible (e.g. no shipping method selected) the button must be disabled.
	 * - If $errorMessage is not empty, show the message to the customer.
	 * - No 'cancel' or 'back' button should be shown.
	 * - The form should never contain other elements as listed above (means no other form elements).
	 *
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @param boolean $renderConfirmationFormElements If this field is true, 
	 * @return string HTML of the pane.
	 */
	public function renderReviewPane(Customweb_Payment_ExternalCheckout_IContext $context, $renderConfirmationFormElements, $errorMessage);

	/**
	 * Validates the input from the customer.
	 * 
	 * This method should be called after the user has confirmed the order on the review page.
	 * 
	 * In case it is not valid the method should throw an exception. 
	 *
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @throws Exception In case the input is invalid.
	 */
	public function validateReviewForm(Customweb_Payment_ExternalCheckout_IContext $context, Customweb_Core_Http_IRequest $request);

	/**
	 * This method may render additional form elements.
	 * 
	 * The e-commerce system may provide through this method additional form elements to collect more information
	 * about the customer.
	 * 
	 * The form elements should be presented to the customer before the order is confirmed by the user. Means the additional form
	 * element should be shown when no more information is provided through other methods. (e.g. address data etc.)
	 * 
	 * The additional form elements may be placed in the same form as the review pane.
	 * 
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @param string $errorMessage Error Message for the customer.
	 * @return string HTML of the pane.
	 */
	public function renderAdditionalFormElements(Customweb_Payment_ExternalCheckout_IContext $context, $errorMessage);
	
	/**
	 * This method should be used to process the user input from the additional form elements.
	 * 
	 * The implementor of this method may process the form data from the request object and may update the
	 * context accordingly.
	 * 
	 * In case the input is not valid the method should throw an exception.
	 * 
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @param Customweb_Core_Http_IRequest $request
	 * @throws Exception In case the input is invalid.
	 */
	public function processAdditionalFormElements(Customweb_Payment_ExternalCheckout_IContext $context, Customweb_Core_Http_IRequest $request);
	
	/**
	 * Creates an order based on the checkout context.
	 * The method returns a transaction. The client has to make sure that the transaction 
	 * is authorized later and it gets stored. 
	 * The authorization should be done in a separate call, to make sure that the transaction
	 * is written to the database before.
	 *
	 * The Customweb_Payment_ITransactionHandler can be found in the DI container.
	 *
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @return Customweb_Payment_Authorization_ITransaction
	 */
	public function createOrder(Customweb_Payment_ExternalCheckout_IContext $context);
}