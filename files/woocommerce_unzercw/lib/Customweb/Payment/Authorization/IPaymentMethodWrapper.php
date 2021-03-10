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

require_once 'Customweb/Payment/Authorization/IPaymentMethod.php';
require_once 'Customweb/I18n/Translation.php';

/**
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_Authorization_IPaymentMethodWrapper extends Customweb_Payment_Authorization_IPaymentMethod {
	
	/**
	 * This method validates if the given $orderContext and $paymentContext are valid to be 
	 * processed with this payment method. 
	 * 
	 * Subclasses may override this method, but they should call the parent method.
	 * 
	 * @param Customweb_Payment_Authorization_IOrderContext $orderContext
	 * @param Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext
	 * @throws Exception In case something is not valid.
	 */
	public function preValidate(Customweb_Payment_Authorization_IOrderContext $orderContext,
			Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext);
	
	/**
	 * Returns true, when credit card information are available for this 
	 * payment method.
	 * 
	 * @return boolean
	 */
	public function isCreditCardInformationPresent();
	
	/**
	 * This method returns the issuer identification prefixes for this 
	 * payment method. The issuer identification prefixes can be used
	 * to identify the brand of a credit card. 
	 * 
	 * @return array
	 */
	public function getCreditCardIssuerIdentificationPrefixes();
	
	/**
	 * Checks wether this country is supported or not by the payment method.
	 * 
	 * @param string $countryCode Country ISO code (2 chars)
	 * @return boolean
	 */
	public function isCountrySupported($countryCode);
	
	/**
	 * Checks wether this currency is supported or not by the payment method.
	 *
	 * @param string $currencyCode Country ISO code (3 chars)
	 * @return boolean
	 */
	public function isCurrencySupported($currencyCode);
	
	/**
	 * Checks wether the payment method supportes the given authorization method or not.
	 * 
	 * @param string $authorization The machine name of the authorization method.
	 * @return boolean
	 */
	public function isAuthorizationMethodSupported($authorization);
	
	/**
	 * Checks whether this method supports recurring payment or not.
	 * 
	 * @return boolean
	 */
	public function isRecurringPaymentSupported();
	
	/**
	 * This method returns the set of supported countries by this payment method.
	 * If this method returns null, then all countries are supported.
	 *
	 * @return array List of countries supported
	 */
	public function getSupportedCountries();
	
	/**
	 * This method returns the set of supported currencies by this payment method.
	 * If this method returns null, then all currencies are supported.
	 * 
	 * @return array List of countries supported
	 */
	public function getSupportedCurrencies();
	
	/**
	 * This method returns the set of not supported features by this payment method.
	 * 
	 * @return array List of not supported features.
	 */
	public function getNotSupportedFeatures();
	
	/**
	 * This method returns the parameters provided for this payment method.
	 * 
	 * @return array List of parameters
	 */
	public function getPaymentMethodParameters();
	
}