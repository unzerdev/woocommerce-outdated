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

/**
 * The order context describs the order. This data is provided
 * by the store.
 *
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_Authorization_IOrderContext {
	/**
	 * This method indicates if a javascript object must be reloaded before submission due to page reloads or similar.
	 * 
	 * @return boolean
	 */
	public function isAjaxReloadRequired();
	
	/**
	 * The checkout id identifies a checkout session. The checkout id is
	 * unique. 
	 * 
	 * The checkout id remains the same id as long as no transaction was created
	 * from the order context.
	 * 
	 * The length must be not longer than 64 chars.
	 * 
	 * @return string Checkout ID (max length 64 chars)
	 */
	public function getCheckoutId();
	
	/**
	 * Returns the shipping address for this order.
	 * 
	 * @return Customweb_Payment_Authorization_OrderContext_IAddress
	 */
	public function getShippingAddress();
	
	/**
	 * Returns the billing address for this order.
	 * 
	 * @return Customweb_Payment_Authorization_OrderContext_IAddress
	 */
	public function getBillingAddress();
	
	/**
	 * This method returns a unique integer, which identifies the
	 * customer in the shop system.
	 *
	 * @return int
	 */
	public function getCustomerId();

	/**
	 * This method indicates if a customer is a new customer or
	 * a returning customer. The determination if a customer
	 * is new or not, depends on the number of paid orders. If
	 * the customer has more than one paid orders, it is not
	 * new anymore.
	 *
	 * @return 'new' | 'existing' | 'unkown'
	 */
	public function isNewCustomer();

	/**
	 * The date on which the customer creates his account.
	 *
	 * @return null | DateTime
	 */
	public function getCustomerRegistrationDate();

	/**
	 * The email address of the customer.
	 *
	 * @return String The e-mail address of the customer.
	 */
	public function getCustomerEMailAddress();
	
	/**
	 * The order amount in decimal / float representation in the curreny
	 * given by the method self::getCurrencyCode(). The rounding is
	 * done directly by the library.
	 *
	 * @return float The transaction amount.
	 */
	public function getOrderAmountInDecimals();

	/**
	 * The currency code in ISO format.
	 *
	 * @return String ISO code of the currency used for the transactions.
	 */
	public function getCurrencyCode();

	/**
	 * This method returns a list of invoice items. A invoice item can be a product or any other
	 * item on the invoice.
	 *
	 * @return Customweb_Payment_Authorization_IInvoiceItem[]
	 */
	public function getInvoiceItems();

	/**
	 * The shipping method.
	 *
	 * If the shipping method is not available to the implementer, null
	 * may be returned. The API will make sure that the shipping method
	 * is entered by the user if needed.
	 *
	 * @return null | string Shipping Method
	 */
	public function getShippingMethod();

	/**
	 * The name of the payment method that sould be used for this transaction. If this
	 * method returns null, no preseleciton is done and the customer can select between
	 * multiple payment methods.
	 *
	 * @return Customweb_Payment_Authorization_IPaymentMethod
	 */
	public function getPaymentMethod();

	/**
	 * This method returns the language spoken by the customer.
	 *
	 * @return Customweb_Core_Language
	 */
	public function getLanguage();

	/**
	 * This method returns a list of parameters, which may modify
	 * the behaviour of the order process. The result-producing parameters
	 * depends on the concrete payment interface.
	 *
	 * @return array Map of parameters
	 */
	public function getOrderParameters();
	
	
	////////////// Deprecated methods /////////////////////
	
	/**
	 * The email address of the billing address.
	 *
	 * @return string The e-mail address of the billing address.
	 * @deprecated Use instead the address object
	 */
	public function getBillingEMailAddress();

	/**
	 * The gender for the billing address.
	 *
	 * @return null | String 'male' | 'female' | 'company'
	 * @deprecated Use instead the address object
	 */
	public function getBillingGender();

	/**
	 * The salutation for the billing address.
	 *
	 * If the salutation is not available to the implementer, null may be returned. The
	 * API will make sure that the salutation is entered by the user if needed.
	 *
	 * @return null | string
	 * @deprecated Use instead the address object
	 */
	public function getBillingSalutation();

	/**
	 * The billing address first name.
	 *
	 * @return String The first name of the billing address.
	 * @deprecated Use instead the address object
	 */
	public function getBillingFirstName();

	/**
	 * The billing address last name.
	 *
	 * @return String The last name of the billing address.
	 * @deprecated Use instead the address object
	 */
	public function getBillingLastName();

	/**
	 * The billing address street.
	 *
	 * @return String The first name of the street.
	 * @deprecated Use instead the address object
	 */
	public function getBillingStreet();

	/**
	 * The billing address city.
	 *
	 * @return String The city of the billing address.
	 * @deprecated Use instead the address object
	 */
	public function getBillingCity();

	/**
	 * The billing address post code (ZIP).
	 *
	 * @return String The post code of the billing address.
	 * @deprecated Use instead the address object
	 */
	public function getBillingPostCode();

	/**
	 * The billing address state in ISO format (2-3 letters).
	 *
	 * @return null | String The state code of the billing address.
	 * @deprecated Use instead the address object
	 */
	public function getBillingState();

	/**
	 * The billing address country code in ISO format (2 letters).
	 *
	 * @return String The country code of the billing address.
	 * @deprecated Use instead the address object
	 */
	public function getBillingCountryIsoCode();

	/**
	 * This method returns a phone number of the person, which is billed.
	 *
	 * @return null | string
	 * @deprecated Use instead the address object
	 */
	public function getBillingPhoneNumber();

	/**
	 * This method returns a mobile phone number of the person,
	 * which is billed.
	 * The method should only return mobile phone numbers, not others.
	 *
	 * @return null | string
	 * @deprecated Use instead the address object
	 */
	public function getBillingMobilePhoneNumber();

	/**
	 * The date of of birth of the person that is billed.
	 *
	 * If the date of of birth is not available to the implementer, null may be returned.
	 * The API will make sure that the date of of birth is entered by the user if needed.
	 *
	 * @return null | DateTime
	 * @deprecated Use instead the address object
	 */
	public function getBillingDateOfBirth();

	/**
	 * The commercial register number of the company that is billed.
	 *
	 * If the commercial register number is not available to the implementer, null
	 * may be returned. The API will make sure that the commercial register number
	 * is entered by the user if needed.
	 *
	 * @return null | string The commercial register number as a string.
	 * @deprecated Use instead the address object
	 */
	public function getBillingCommercialRegisterNumber();

	/**
	 * The name of the company that is billed.
	 *
	 * If the name of the company is not available to the implementer, null
	 * may be returned. The API will make sure that the name of the company
	 * is entered by the user if needed.
	 *
	 * @return null | string Compay name.
	 * @deprecated Use instead the address object
	 */
	public function getBillingCompanyName();

	/**
	 * The sales tax number of the billing address.
	 *
	 * If the sales tax number is not available to the implementer, null
	 * may be returned. The API will make sure that the sales tax number
	 * is entered by the user if needed.
	 *
	 * @return null | string The sales tax number
	 * @deprecated Use instead the address object
	 */
	public function getBillingSalesTaxNumber();

	/**
	 * The social security number of the person that is billed.
	 *
	 * If the SSN is not available to the implementer, null
	 * may be returned. The API will make sure that the SSN
	 * is entered by the user if needed.
	 *
	 * @return null | string Social security number.
	 * @deprecated Use instead the address object
	 */
	public function getBillingSocialSecurityNumber();

	/**
	 * The email address of the billing address.
	 *
	 * @return string The e-mail address of the billing address.
	 * @deprecated Use instead the address object
	 */
	public function getShippingEMailAddress();

	/**
	 * The gender for the shipping address.
	 *
	 * @return null | String 'male' | 'female' | 'company'
	 * @deprecated Use instead the address object
	 */
	public function getShippingGender();

	/**
	 * The salutation for the shipping address.
	 *
	 * If the salutation is not available to the implementer, null
	 * may be returned. The API will make sure that the salutation
	 * is entered by the user if needed.
	 *
	 * @return null | string
	 * @deprecated Use instead the address object
	 */
	public function getShippingSalutation();

	/**
	 * The shipping address first name.
	 *
	 * @return String The first name of the shipping address.
	 * @deprecated Use instead the address object
	 */
	public function getShippingFirstName();

	/**
	 * The shipping address last name.
	 *
	 * @return String The last name of the shipping address.
	 * @deprecated Use instead the address object
	 */
	public function getShippingLastName();

	/**
	 * The shipping address street including the street number.
	 *
	 * @return String The street of the shipping address.
	 * @deprecated Use instead the address object
	 */
	public function getShippingStreet();

	/**
	 * The shipping address city.
	 *
	 * @return String The city of the shipping address.
	 * @deprecated Use instead the address object
	 */
	public function getShippingCity();

	/**
	 * The shipping address post code (ZIP).
	 *
	 * @return String The post code of the shipping address.
	 * @deprecated Use instead the address object
	 */
	public function getShippingPostCode();

	/**
	 * The shipping address state in ISO format (2-3 letters).
	 *
	 * @return null | String The state code of the shipping address.
	 * @deprecated Use instead the address object
	 */
	public function getShippingState();

	/**
	 * The shipping address country as ISO code (2 letters).
	 *
	 * @return String The country code of the shipping address.
	 * @deprecated Use instead the address object
	 */
	public function getShippingCountryIsoCode();

	/**
	 * This method returns a phone number of the person to which
	 * the products are shipped to.
	 *
	 * @return null | string
	 * @deprecated Use instead the address object
	 */
	public function getShippingPhoneNumber();

	/**
	 * This method returns a mobile phone number of the person,
	 * which is billed.
	 * The method should only return mobile phone numbers, not others.
	 *
	 * @return null | string
	 * @deprecated Use instead the address object
	 */
	public function getShippingMobilePhoneNumber();

	/**
	 * The date of of birth of the person to which the product is shipped to.
	 *
	 * If the date of of birth is not available to the implementer, null may be returned.
	 * The API will make sure that the date of of birth is entered by the user if needed.
	 *
	 * @return null | DateTime
	 * @deprecated Use instead the address object
	 */
	public function getShippingDateOfBirth();

	/**
	 * The name of the company the products are shipped to.
	 *
	 * If the company name is not available to the implementer, null
	 * may be returned. The API will make sure that the company name
	 * is entered by the user if needed.
	 *
	 * @return null | string Company name
	 * @deprecated Use instead the address object
	 */
	public function getShippingCompanyName();

	/**
	 * The commercial register number of the company to which
	 * the product is shipped to.
	 *
	 * If the commercial register number is not available to the implementer, null
	 * may be returned. The API will make sure that the commercial register number
	 * is entered by the user if needed.
	 *
	 * @return null | string The commercial register number as a string.
	 * @deprecated Use instead the address object
	 */
	public function getShippingCommercialRegisterNumber();

	/**
	 * The sales tax number of the shipping address.
	 *
	 * If the sales tax number is not available to the implementer, null
	 * may be returned. The API will make sure that the sales tax number
	 * is entered by the user if needed.
	 *
	 * @return null | string The sales tax number
	 * @deprecated Use instead the address object
	 */
	public function getShippingSalesTaxNumber();

	/**
	 * The social security number of the person to which
	 * the product is shipped to.
	 *
	 * If the SSN is not available to the implementer, null
	 * may be returned. The API will make sure that the SSN
	 * is entered by the user if needed.
	 *
	 * @return null | string Social security number.
	 * @deprecated Use instead the address object
	 */
	public function getShippingSocialSecurityNumber();

}