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
require_once 'Customweb/Payment/Authorization/DefaultInvoiceItem.php';
require_once 'Customweb/Core/Util/Rand.php';
require_once 'Customweb/Payment/Authorization/Recurring/IAdapter.php';
require_once 'Customweb/Util/Invoice.php';
require_once 'Customweb/Core/String.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Payment/Authorization/IInvoiceItem.php';
require_once 'Customweb/Core/Language.php';
require_once 'UnzerCw/ConfigurationAdapter.php';

class UnzerCw_OrderContext extends Customweb_Payment_Authorization_OrderContext_AbstractDeprecated {

	protected $order;
	protected $orderAmount;
	protected $currencyCode;
	protected $paymentMethod;
	protected $language;
	protected $userId;
	protected $checkoutId;
	
	public function __construct($order, Customweb_Payment_Authorization_IPaymentMethod $paymentMethod){
		if ($order == null) {
			throw new Exception("The order parameter cannot be null.");
		}
		
		$this->currencyCode = $order->get_currency();
		$this->order = $order;
		$this->paymentMethod = $paymentMethod;
		
		$this->orderAmount = $order->get_total();
		$this->language = get_bloginfo('language');
		
		$userId = $order->get_customer_id();
		if ($userId === null) {
			$this->userId = get_current_user_id();
		}
		else {
			$this->userId = $userId;
		}
		
		if ($this->userId === null) {
			$this->userId = 0;
		}
		
		global $woocommerce;		
		$sessionHandler = $woocommerce->session;
		if ($sessionHandler != null) {
			$checkoutId = $sessionHandler->get('UnzerCwCheckoutId', null);
			if ($checkoutId === null) {
				$checkoutId = Customweb_Core_Util_Rand::getUuid();
				$sessionHandler->set('UnzerCwCheckoutId', $checkoutId);
			}
		}
		else {
			//if a recurring payment is activated manually from the backend, the session handler is not avaiable
			//we do not need to store checkout id in this case, we just need to generate one
			$checkoutId = Customweb_Core_Util_Rand::getUuid();
		}
		
		$this->checkoutId = $checkoutId;
	}

	protected function getInvoiceItemsInternal(){
		$items = array();
		$wooCommerceItems = $this->order->get_items(array(
			'line_item' 
		));
		foreach ($wooCommerceItems as $wooItem) {
					
			$product = $wooItem->get_product();
			if (is_object($product)) {
				$sku = $product->get_sku();
			}
			if (empty($sku)) {
				$sku = Customweb_Core_String::_($wooItem['name'])->replace(" ", "")->replace("\t", "")->convertTo('ASCII')->toLowerCase()->toString();
			}
			
			$name = $wooItem['name'];
			
			if (isset($wooItem['line_subtotal']) && isset($wooItem['quantity']) && isset($wooItem['line_subtotal_tax'])) {
				$amountExclTax = $wooItem['line_subtotal'];
				$amountIncludingTax = $wooItem['line_subtotal'] + $wooItem['line_subtotal_tax'];
				$taxRate = 0;
				if ($amountExclTax != 0) {
					$taxRate = ($amountIncludingTax - $amountExclTax) / $amountExclTax * 100;
				}
				$quantity = $wooItem['quantity'];
			}
			else {
				$quantity = 1;
				$amountExclTax = $wooItem['line_total'];
				$amountIncludingTax = $wooItem['line_total'] + $wooItem['line_tax'];
				$taxRate = 0;
				if ($amountExclTax != 0) {
					$taxRate = ($amountIncludingTax - $amountExclTax) / $amountExclTax * 100;
				}
			}
			
			$item = new Customweb_Payment_Authorization_DefaultInvoiceItem($sku, $name, $taxRate, $amountIncludingTax, $quantity);
			$items[] = $item;
			$discountAmount = $item->getAmountIncludingTax() - $this->order->get_line_total($wooItem, true);
			if (Customweb_Util_Currency::compareAmount($discountAmount, 0, $this->getCurrencyCode()) > 0) {
				$discountItem = new Customweb_Payment_Authorization_DefaultInvoiceItem($sku . '-discount',
						__("Discount", "woocommerce_unzercw") . ' ' . $wooItem['name'], $taxRate, $discountAmount, $quantity,
						Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT);
				$items[] = $discountItem;
			}
		}
		
		$wooCommerceFees = $this->order->get_items(array(
			'fee' 
		));
		foreach ($wooCommerceFees as $fees) {
			$name = $fees['name'];
			$sku = Customweb_Core_String::_($name)->replace(" ", "")->replace("\t", "")->convertTo('ASCII')->toString();
			if (empty($sku)) {
				$sku = "fee" . rand();
			}
			
			if (isset($fees['line_subtotal']) && isset($fees['quantity']) && isset($fees['line_subtotal_tax'])) {
				$amountExclTax = $fees['line_subtotal'];
				$amountIncludingTax = $fees['line_subtotal'] + $fees['line_subtotal_tax'];
				$taxRate = 0;
				if ($amountExclTax != 0) {
					$taxRate = ($amountIncludingTax - $amountExclTax) / $amountExclTax * 100;
				}
				$quantity = $fees['quantity'];
			}
			else {
				$quantity = 1;
				$amountExclTax = $fees['line_total'];
				$amountIncludingTax = $fees['line_total'] + $fees['line_tax'];
				$taxRate = 0;
				if ($amountExclTax != 0) {
					$taxRate = ($amountIncludingTax - $amountExclTax) / $amountExclTax * 100;
				}
			}
			
			$item = new Customweb_Payment_Authorization_DefaultInvoiceItem($sku, $name, $taxRate, $amountIncludingTax, $quantity,
					Customweb_Payment_Authorization_IInvoiceItem::TYPE_FEE);
			$items[] = $item;
		}
		
		$wooCommerceShipping = $this->order->get_items(array(
			'shipping' 
		));
		foreach ($wooCommerceShipping as $shipping) {
			$name = $shipping['name'];
			
			$sku = Customweb_Core_String::_($name)->replace(" ", "")->replace("\t", "")->convertTo('ASCII')->toString();
			if(empty($sku)){
				$sku = $shipping['method_id'];
			}
			
			$quantity = 1;
			$amountExclTax = $shipping['cost'];
			$taxAmount = 0;
			$taxesString = $shipping['taxes'];
			if (is_string($taxesString)) {
				$taxesArray = unserialize($taxesString);
				if ($taxesArray !== false) {
					$taxAmount = end($taxesArray);
				}
			}
			elseif (is_array($taxesString) && isset($taxesString['total'])) {
				$taxAmount = end($taxesString['total']);
				if (is_array($taxAmount) && empty($taxAmount)) {
					$taxAmount = 0;
				}
				elseif (is_array($taxAmount)) {
					$taxAmount = end($taxAmount);
				}
			}
			
			$amountIncludingTax = $amountExclTax + $taxAmount;
			$taxRate = 0;
			if ($amountExclTax != 0) {
				$taxRate = ($amountIncludingTax - $amountExclTax) / $amountExclTax * 100;
			}
			$item = new Customweb_Payment_Authorization_DefaultInvoiceItem($sku, $name, $taxRate, $amountIncludingTax, $quantity,
					Customweb_Payment_Authorization_IInvoiceItem::TYPE_SHIPPING);
			$items[] = $item;
		}
		return $items;
	}

	public function getInvoiceItems(){
		$items = $this->getInvoiceItemsInternal();
		return Customweb_Util_Invoice::cleanupLineItems($items, $this->getOrderAmountInDecimals(), $this->getCurrencyCode());
	}

	public function getShippingMethod(){
		return $this->order->get_shipping_method();
	}

	public function isNewSubscription(){
		$result = false;
		
		if (function_exists('wcs_order_contains_subscription') && wcs_order_contains_subscription($this->getOrderObject()) &&
				 ('yes' != get_option(WC_Subscriptions_Admin::$option_prefix . '_turn_off_automatic_payments', 'no'))) {
			try {
				$adapter = UnzerCw_Util::getAuthorizationAdapter(
						Customweb_Payment_Authorization_Recurring_IAdapter::AUTHORIZATION_METHOD_NAME);
				if ($adapter->isPaymentMethodSupportingRecurring($this->getPaymentMethod())) {
					$result = true;
				}
			}
			catch (Customweb_Payment_Authorization_Method_PaymentMethodResolutionException $e) {
			}
		}
		
		return $result;
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
	
	public function getOrderObject(){
		return $this->order;
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
		return $this->order->get_billing_email();
	}
	
	public function getBillingGender(){
		$billingCompany = trim($this->getBillingCompanyName());
		if (!empty($billingCompany)) {
			return 'company';
		}
		else {
			$genderString = $this->getOrderObject()->get_meta( 'billing_gender' , true, 'edit' );
			if (empty($genderString)) {
				$genderString = $this->getOrderObject()->get_meta( '_billing_gender' , true, 'edit' );
			}
			if (!empty($genderString)) {
				if (strtolower($genderString) == 'm' || strtolower($genderString) == "male") {
					return 'male';
				}
				elseif (strtolower($genderString) == 'f' || strtolower($genderString) == "female") {
					return 'female';
				}
			}
			return null;
		}
	}
	
	public function getBillingSalutation(){
		return null;
	}
	
	public function getBillingFirstName(){
		return $this->order->get_billing_first_name();
	}
	
	public function getBillingLastName(){
		return $this->order->get_billing_last_name();
	}
	
	public function getBillingStreet(){
		$second = $this->order->get_billing_address_2();
		if (empty($second)) {
			return $this->order->get_billing_address_1();
		}
		return $this->order->get_billing_address_1() . " " . $second;
	}
	
	public function getBillingCity(){
		return $this->order->get_billing_city();
	}
	
	public function getBillingPostCode(){
		return $this->order->get_billing_postcode();
	}
	
	public function getBillingState(){
		$state = $this->order->get_billing_state();
		return UnzerCw_Util::cleanUpStateField($state, $this->getBillingCountryIsoCode());
		
	}
	
	public function getBillingCountryIsoCode(){
		return $this->order->get_billing_country();
	}
	
	public function getBillingPhoneNumber(){
		$phoneNumber = $this->order->get_billing_phone();
		$phoneNumber = trim($phoneNumber);
		if (!empty($phoneNumber)) {
			return $phoneNumber;
		}
		return null;
	}
	
	public function getBillingMobilePhoneNumber(){
		return null;
	}
	
	public function getBillingDateOfBirth(){
		$dateOfBirthString = $this->getOrderObject()->get_meta( 'billing_date_of_birth', true, 'edit' );
		if (empty($dateOfBirthString)) {
			$dateOfBirthString = $this->getOrderObject()->get_meta( '_billing_date_of_birth', true, 'edit' );
		}
		if (!empty($dateOfBirthString)) {
			$dateOfBirth = UnzerCw_Util::tryToParseDate($dateOfBirthString);
			if ($dateOfBirth !== false) {
				return $dateOfBirth;
			}
		}
		return null;
	}
	
	public function getBillingCompanyName(){
		return $this->order->get_billing_company();
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
		return $this->getBillingEMailAddress();
	}
	
	public function getShippingGender(){
		$company = trim($this->getShippingCompanyName());
		if (!empty($company)) {
			return 'company';
		}
		else {
			return null;
		}
	}
	
	public function getShippingSalutation(){
		return null;
	}
	
	public function getShippingFirstName(){
		$result = $this->order->get_shipping_first_name();
		if(!empty($result)){
			return $result;
		}
		return $this->getBillingFirstName();
	}
	
	public function getShippingLastName(){
		$result  = $this->order->get_shipping_last_name();
		if(!empty($result)){
			return $result;
		}
		return $this->getBillingLastName();
	}
	
	public function getShippingStreet(){
		$result = null;
		$second = $this->order->get_shipping_address_2();
		if (empty($second)) {
			$result = $this->order->get_shipping_address_1();
		}
		else{
			$result = $this->order->get_shipping_address_1() . " " . $second;
		}
		
		if(!empty($result)){
			return $result;
		}
		return $this->getBillingStreet();
	}
	
	public function getShippingCity(){
		$result = $this->order->get_shipping_city();
		if(!empty($result)){
			return $result;
		}
		return $this->getBillingCity();
	}
	
	public function getShippingPostCode(){
		$result =  $this->order->get_shipping_postcode();
		if(!empty($result)){
			return $result;
		}
		return $this->getBillingPostCode();
	}
	
	public function getShippingState(){
		$state = $this->order->get_shipping_state();
		if (!empty($state)) {
			return UnzerCw_Util::cleanUpStateField($state, $this->getShippingCountryIsoCode());
		}
		return $this->getBillingState();
	}
	
	public function getShippingCountryIsoCode(){
		$result = $this->order->get_shipping_country();
		if(!empty($result)){
			return $result;
		}
		return $this->getBillingCountryIsoCode();
	}
	
	public function getShippingPhoneNumber(){
		return $this->getBillingPhoneNumber();
	}
	
	public function getShippingMobilePhoneNumber(){
		return null;
	}
	
	public function getShippingDateOfBirth(){
		return null;
	}
	
	public function getShippingCompanyName(){
		$result = $this->order->get_shipping_company();
		if(!empty($result)){
			return $result;
		}
		return $this->getBillingCompanyName();
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
	
	protected function getLineTotalsWithTax(array $lines){
		$total = 0;
		foreach ($lines as $line) {
			if ($line->getType() == Customweb_Payment_Authorization_DefaultInvoiceItem::TYPE_DISCOUNT) {
				$total -= $line->getAmountIncludingTax();
			}
			else {
				$total += $line->getAmountIncludingTax();
			}
		}		
		return $total;
	}
	
	public function getCheckoutId(){
		return $this->checkoutId;
	}
	
	public function getOrderPostId(){
		return $this->order->get_id();
	}
	
	public function getOrderNumber(){
		$orderNumber = null;
		if (UnzerCw_ConfigurationAdapter::getOrderNumberIdentifier() == 'ordernumber') {
			$orderNumber = preg_replace('/[^a-zA-Z\d]/', '', $this->order->get_order_number());
		}
		else {
			$orderNumber = $this->order->get_id();
		}
		$existing = UnzerCw_Util::getTransactionsByOrderId($orderNumber);
		if (!empty($existing)) {
			$count = 0;
			while(true){
				$orderNumber = $orderNumber . '_' . $count;
				$existing = UnzerCw_Util::getTransactionsByOrderId($orderNumber);
				if(empty($existing) ){
					break;
				}
				$count++;
			}
		}
		return $orderNumber;
	}
}