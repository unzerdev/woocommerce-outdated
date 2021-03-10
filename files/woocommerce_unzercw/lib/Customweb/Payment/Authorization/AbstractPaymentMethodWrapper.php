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
require_once 'Customweb/Payment/Authorization/IPaymentMethodWrapper.php';

/**
 * 
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_Payment_Authorization_AbstractPaymentMethodWrapper implements Customweb_Payment_Authorization_IPaymentMethodWrapper {

	/**
	 * @var Customweb_Payment_Authorization_IPaymentMethod
	 */
	private $paymentMethod = null;
	
	private $info = null;
	
	private $supportedCountries = null;
	
	private $supportedCurrencies = null;
	
	private $paymentMethodParameters = array();
	
	private $notSupportedFeatures = array();
	
	private $creditCardInformation = array();
	
	abstract protected function getPaymentInformationMap();

	public function __construct(Customweb_Payment_Authorization_IPaymentMethod $paymentMethod) {
		$this->paymentMethod = $paymentMethod;
		
		$info = $this->getPaymentInformationMap();
		$method = strtolower($this->getPaymentMethodName());
		if (!isset($info[$method])) {
			throw new Exception(Customweb_I18n_Translation::__(
					"Could not find the payment method !paymentMethodName.",
					array(
							'!paymentMethodName' => $this->getPaymentMethodName(),
					)
			));
		}
		
		$methodName = strtolower($this->getPaymentMethodName());
		$this->info = $info[$methodName];
		
		if (isset($this->info['supported_countries'])) {
			$this->supportedCountries = $this->info['supported_countries'];
		}
			if (isset($this->info['supported_currencies'])) {
			$this->supportedCurrencies = $this->info['supported_currencies'];
		}
		if (isset($this->info['not_supported_features'])) {
			$this->notSupportedFeatures = $this->info['not_supported_features'];
		}
		if (isset($this->info['parameters'])) {
			$this->paymentMethodParameters = $this->info['parameters'];
		}
		
		if (isset($this->info['credit_card_information'])) {
			$this->creditCardInformation = $this->info['credit_card_information'];
		}
		
	}
	
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
			Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext) {
		if (!$this->isCountrySupported($orderContext->getBillingCountryIsoCode())) {
			throw new Exception(Customweb_I18n_Translation::__(
				"The payment method !paymentMethodName is not available in your country ('!country').",
				array(
					'!paymentMethodName' => $this->getPaymentMethodDisplayName(),
					'!country' => $orderContext->getBillingCountryIsoCode(),
				)
			));
		}
		
		if (!$this->isCurrencySupported($orderContext->getCurrencyCode())) {
			throw new Exception(Customweb_I18n_Translation::__(
				"The payment method !paymentMethodName does not support the currency '!currency'.",
				array(
					'!paymentMethodName' => $this->getPaymentMethodDisplayName(),
					'!currency' => $orderContext->getCurrencyCode(),
				)
			));
		}
		
		return true;	
	}
	
	/**
	 * Returns true, when credit card information are available for this 
	 * payment method.
	 * 
	 * @return boolean
	 */
	public function isCreditCardInformationPresent() {
		return count($this->creditCardInformation) > 0;
	}
	
	/**
	 * This method returns the issuer identification prefixes for this 
	 * payment method. The issuer identification prefixes can be used
	 * to identify the brand of a credit card. 
	 * 
	 * @return array
	 */
	public function getCreditCardIssuerIdentificationPrefixes() {
		if (isset($this->creditCardInformation['issuer_identification_number_prefixes'])) {
			return $this->creditCardInformation['issuer_identification_number_prefixes'];
		}
		else {
			return array();
		}
	}
	
	public function getAcceptedCreditCardLengths() {
		if ($this->isCreditCardInformationPresent()) {
			if (isset($this->creditCardInformation['lengths'])) {
				return $this->creditCardInformation['lengths'];
			}
			else {
				// We assume a default length of 16 chars.
				return 16;
			}
		}
		else {
			throw new Exception("No credit card information present.");
		}
	}
	
	public function getPaymentMethodName() {
		return $this->paymentMethod->getPaymentMethodName();
	}

	public function getPaymentMethodDisplayName() {
		return $this->paymentMethod->getPaymentMethodDisplayName();
	}

	public function getPaymentMethodConfigurationValue($key, $languageCode = null) {
		return $this->paymentMethod->getPaymentMethodConfigurationValue($key, $languageCode);
	}
	
	public function existsPaymentMethodConfigurationValue($key, $languageCode = null) {
		return $this->paymentMethod->existsPaymentMethodConfigurationValue($key, $languageCode);
	}
	
	/**
	 * Checks wether this country is supported or not by the payment method.
	 * 
	 * @param string $countryCode Country ISO code (2 chars)
	 * @return boolean
	 */
	public function isCountrySupported($countryCode) {
	    if (empty( $countryCode)) {
	        return true;
	    }
		if ($this->getSupportedCountries() === null) {
			return true;
		}
		else {
			return in_array(strtoupper($countryCode), $this->getSupportedCountries());
		}
	}
	
	/**
	 * Checks wether this currency is supported or not by the payment method.
	 *
	 * @param string $currencyCode Country ISO code (3 chars)
	 * @return boolean
	 */
	public function isCurrencySupported($currencyCode) {
		if ($this->getSupportedCurrencies() === null) {
			return true;
		}
		else {
			return in_array(strtoupper($currencyCode), $this->getSupportedCurrencies());
		}
	}
	
	/**
	 * Checks wether the payment method supportes the given authorization method or not.
	 * 
	 * @param string $authorization The machine name of the authorization method.
	 * @return boolean
	 */
	public function isAuthorizationMethodSupported($authorization) {
		return !in_array($authorization, $this->getNotSupportedFeatures());
	}
	
	/**
	 * Checks whether this method supports recurring payment or not.
	 * 
	 * @return boolean
	 */
	public function isRecurringPaymentSupported() {
		return !in_array('Recurring', $this->getNotSupportedFeatures());
	}
	
	/**
	 * This method returns the set of supported countries by this payment method.
	 * If this method returns null, then all countries are supported.
	 *
	 * @return array List of countries supported
	 */
	public function getSupportedCountries() {
		return $this->supportedCountries;
	}
	/**
	 * This method returns the set of supported currencies by this payment method.
	 * If this method returns null, then all currencies are supported.
	 * 
	 * @return array List of countries supported
	 */
	public function getSupportedCurrencies() {
		return $this->supportedCurrencies;		
	}
	
	/**
	 * This method returns the set of not supported features by this payment method.
	 * 
	 * @return array List of not supported features.
	 */
	public function getNotSupportedFeatures() {
		return $this->notSupportedFeatures;
	}
	
	/**
	 * This method returns the parameters provided for this payment method.
	 * 
	 * @return array List of parameters
	 */
	public function getPaymentMethodParameters() {
		return $this->paymentMethodParameters;
	}

	
}