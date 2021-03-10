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
require_once 'Customweb/Payment/Authorization/OrderContext/AbstractDeprecated.php';
require_once 'UnzerCw/Util.php';
require_once 'UnzerCw/CartUtil.php';
require_once 'Customweb/Core/Language.php';
require_once 'Customweb/Core/Util/Rand.php';
require_once 'Customweb/Payment/Authorization/Recurring/IAdapter.php';


/**
 * This class implements a order context based on user data and the current cart.
 * This order context should never be persisted!
 * 
 * @author hunziker
 *
 */
class UnzerCw_CartOrderContext extends Customweb_Payment_Authorization_OrderContext_AbstractDeprecated {
	
	
	private $cart;
	private $orderAmount;
	private $currencyCode;
	private $paymentMethod;
	private $language;
	private $userId;
	private $userData;
	private $checkoutId;

	public function __construct($userData, Customweb_Payment_Authorization_IPaymentMethod $paymentMethod, $userId = null){
		global $woocommerce;
		
		$sessionHandler = $woocommerce->session;
		$checkoutId = $sessionHandler->get('UnzerCwCheckoutId', null);
		if($checkoutId === null) {
			$checkoutId = Customweb_Core_Util_Rand::getUuid();
			$sessionHandler->set('UnzerCwCheckoutId', $checkoutId);
		}

		$this->checkoutId = $checkoutId;
		
		$this->cart = $woocommerce->cart;
		if (!isset($this->cart->totalCalculatedCw)) {
			$this->cart->calculate_totals();
		}
		
		if (!isset($userData['billing_country']) || $userData['billing_country'] == '') {
			$wcCountries = new WC_Countries();
			$allowedCountries = $wcCountries->get_allowed_countries();
			if (count($allowedCountries) == 1) {
				reset($allowedCountries);
				$userData['billing_country'] = key($allowedCountries);
			}
		}
		
		$this->userData = $userData;
		$this->currencyCode = get_woocommerce_currency();
		$this->paymentMethod = $paymentMethod;
		$this->orderAmount = $this->cart->total;
		$this->language = get_bloginfo('language');
		
		if ($userId === null) {
			$this->userId = get_current_user_id();
		}
		else {
			$this->userId = $userId;
		}
		
	}	
	
	public function isNewSubscription(){
		$result = false;
		
		if( class_exists('WC_Subscriptions_Cart') && class_exists('WC_Subscriptions_Admin') && WC_Subscriptions_Cart::cart_contains_subscription() &&
					 ('yes' != get_option(WC_Subscriptions_Admin::$option_prefix . '_turn_off_automatic_payments', 'no'))){
			try{
				$adapter = UnzerCw_Util::getAuthorizationAdapter(
						Customweb_Payment_Authorization_Recurring_IAdapter::AUTHORIZATION_METHOD_NAME);
				if ($adapter->isPaymentMethodSupportingRecurring($this->getPaymentMethod())) {
					$result = true;
				}
			}catch(Customweb_Payment_Authorization_Method_PaymentMethodResolutionException $e){
				
			}
		}
		
		return $result;
	}

	public function getInvoiceItems(){
		return UnzerCw_CartUtil::getInoviceItemsFromCart($this->cart);
	}

	public function getShippingMethod(){
		return $this->cart->shipping_label;
	}

	public function getCustomerId(){
		return $this->userId;
	}
	
	public function isNewCustomer(){
		return 'unknown';
	}
	
	public function getCustomerRegistrationDate(){
		return null;
	}
	
	public function getOrderAmountInDecimals(){
		return $this->orderAmount;
	}
	
	public function getCurrencyCode(){
		return $this->currencyCode;
	}
	
	public function getPaymentMethod(){
		return $this->paymentMethod;
	}
	
	public function getLanguage(){
		return new Customweb_Core_Language($this->language);
	}
	
	public function getCustomerEMailAddress(){
		return $this->getBillingEMailAddress();
	}
	
	public function getBillingEMailAddress(){
		return $this->userData['billing_email'];
	}
		
	public function getBillingFirstName(){
		return $this->userData['billing_first_name'];
	}
	
	public function getBillingLastName(){
		return $this->userData['billing_last_name'];
	}
	
	public function getBillingStreet(){
		$second = null;
		if (isset($this->userData['billing_address_2'])) {
			$second = $this->userData['billing_address_2'];
		}
		if (empty($second)) {
			return $this->userData['billing_address_1'];
		}
		return $this->userData['billing_address_1'] . " " . $second;
	}
	
	public function getBillingCity(){
		return $this->userData['billing_city'];
	}
	
	public function getBillingPostCode(){
		return $this->userData['billing_postcode'];
	}
	
	public function getBillingState(){
		if (isset($this->userData['billing_state'])) {
			return UnzerCw_Util::cleanUpStateField($this->userData['billing_state'], $this->getBillingCountryIsoCode());
		}
		else {
			return null;
		}
	}	
	
	public function getBillingCompanyName(){
		if (isset($this->userData['billing_company'])) {
			return $this->userData['billing_company'];
		}
		else {
			return null;
		}
	}
	
	public function getBillingCountryIsoCode(){
		return $this->userData['billing_country'];
	}
	
	public function getBillingPhoneNumber(){
		if (isset($this->userData['billing_phone'])) {
			return $this->userData['billing_phone'];
		}
		else {
			return null;
		}
	}
	
	
	public function getBillingGender(){
		$billingCompany = trim($this->getBillingCompanyName());
		if (!empty($billingCompany)) {
			return 'company';
		}
		else {
			$billingGender = '';
			if(!empty($this->userData['billing_gender'])){
				$billingGender = $this->userData['billing_gender'];
			}
			elseif(!empty($this->userData['_billing_gender'])){
				$billingGender = $this->userData['_billing_gender'];
			}
			
			if(!empty($billingGender)){
				if(strtolower($billingGender) == 'm' || strtolower($billingGender) == "male"){
					return 'male';
				}
				elseif(strtolower($billingGender) == 'f' || strtolower($billingGender) == "female"){
					return 'female';
				}
			}
			return null;
		}
	}
	
	public function getBillingDateOfBirth(){
		$dateOfBirthString = '';
		if(!empty($this->userData['billing_date_of_birth'])){
			$dateOfBirthString =  $this->userData['billing_date_of_birth'];
		}
		elseif(!empty($this->userData['_billing_date_of_birth'])){
			$dateOfBirthString = $this->userData['_billing_date_of_birth'];
		}
		if(!empty($dateOfBirthString)){
			$dateOfBirth = UnzerCw_Util::tryToParseDate($dateOfBirthString);
			if($dateOfBirth !== false){
				return $dateOfBirth;
			}
		}
		return null;
	}
	
	public function getBillingSalutation(){
		return null;
	}
	
	public function getBillingMobilePhoneNumber(){
		return null;
	}	
	
	public function getBillingCommercialRegisterNumber(){
		return null;
	}
	
	public function getBillingSalesTaxNumber(){
		return null;
	}
	
	public function getBillingSocialSecurityNumber(){
		return null;
	}
	
	public function getShippingEMailAddress(){
		if ($this->isShipToBilling() || !isset($this->userData['shipping_email'])) {
			return $this->getBillingEMailAddress();
		}
		else {
			$shippingEmail = $this->userData['shipping_email'];
			if (!empty($shippingEmail)) {
				return $shippingEmail;
			}
			else {
				return $this->getBillingEMailAddress();
			}
		}
	}
		
	public function getShippingFirstName(){
		if ($this->isShipToBilling() || !isset($this->userData['shipping_first_name'])) {
			return $this->getBillingFirstName();
		}
		else {
			return $this->userData['shipping_first_name'];
		}
	}
	
	public function getShippingLastName(){
		if ($this->isShipToBilling() || !isset($this->userData['shipping_last_name'])) {
			return $this->getBillingLastName();
		}
		else {
			return $this->userData['shipping_last_name'];
		}
	}
	
	public function getShippingStreet(){
		if ($this->isShipToBilling() || !isset($this->userData['shipping_address_1'])) {
			return $this->getBillingStreet();
		}
		else {
			$second = $this->userData['shipping_address_2'];
			if (empty($second)) {
				return $this->userData['shipping_address_1'];
			}
			return $this->userData['shipping_address_1'] . " " . $second;
		}
	}
	
	public function getShippingCity(){
		if ($this->isShipToBilling() || !isset($this->userData['shipping_city'])) {
			return $this->getBillingCity();
		}
		else {
			return $this->userData['shipping_city'];
		}
	}
	
	public function getShippingPostCode(){
		if ($this->isShipToBilling() || !isset($this->userData['shipping_postcode'])) {
			return $this->getBillingPostCode();
		}
		else {
			return $this->userData['shipping_postcode'];
		}
	}
	
	public function getShippingState(){
		if ($this->isShipToBilling() || !isset($this->userData['shipping_state'])) {
			return $this->getBillingState();
		}
		else {
			return UnzerCw_Util::cleanUpStateField($this->userData['shipping_state'], $this->getShippingCountryIsoCode());
		}
	}
	
	public function getShippingCountryIsoCode(){
		if ($this->isShipToBilling() || !isset($this->userData['shipping_country'])) {
			return $this->getBillingCountryIsoCode();
		}
		else {
			return $this->userData['shipping_country'];
		}
	}
	
	public function getShippingPhoneNumber(){
		if ($this->isShipToBilling()) {
			return $this->getBillingPhoneNumber();
		}
		else {
			$shippingPhone = $this->userData['shipping_phone'];
			if (!empty($shippingPhone)) {
				return $shippingPhone;
			}
			else {
				return $this->getBillingPhoneNumber();
			}
		}
	}	
	
	public function getShippingGender(){
		if ($this->isShipToBilling()) {
			return $this->getBillingGender();
		}
		else {
			$company = trim($this->getShippingCompanyName());
			if (!empty($company)) {
				return 'company';
			}
			else {
				return null;
			}
		}
	}
	
	public function getShippingDateOfBirth(){
		if ($this->isShipToBilling()) {
			return $this->getBillingDateOfBirth();
		}
		else {
			return null;
		}
	}
	
	public function getShippingCompanyName(){
		if ($this->isShipToBilling()) {
			return $this->getBillingCompanyName();
		}
		else {
			if (isset($this->userData['shipping_company'])) {
				return $this->userData['shipping_company'];
			}
			return null;
		}
	}
	
	public function getShippingSalutation(){
		return null;
	}
	
	public function getShippingMobilePhoneNumber(){
		return null;
	}
		
	public function getShippingCommercialRegisterNumber(){
		return null;
	}
	
	public function getShippingSalesTaxNumber(){
		return null;
	}
	
	public function getShippingSocialSecurityNumber(){
		return null;
	}
	
	public function getOrderParameters(){
		return array();
	}
		
	public function getCheckoutId(){
		return $this->checkoutId;
	}
	
	private function isShipToBilling(){
		if (isset($this->userData['ship_to_different_address']) && $this->userData['ship_to_different_address'] == '1') {
			return false;
		}
		else {
			return true;
		}
	}
}