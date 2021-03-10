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

require_once 'Customweb/Payment/ExternalCheckout/IContext.php';
require_once 'Customweb/Core/Language.php';
require_once 'Customweb/Util/Invoice.php';



/**
 * Abstract implementation of the context entity.
 * 
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_Payment_ExternalCheckout_AbstractContext implements Customweb_Payment_ExternalCheckout_IContext {
	private $contextId;
	private $state = Customweb_Payment_ExternalCheckout_IContext::STATE_PENDING;
	private $failedErrorMessage;
	private $cartUrl;
	private $defaultCheckoutUrl;
	
	/**
	 *
	 * @var Customweb_Payment_Authorization_IInvoiceItem[]
	 */
	private $invoiceItems = array();
	private $orderAmountInDecimals;
	private $currencyCode;
	private $languageCode;
	private $customerEmailAddress;
	private $customerId;
	private $transactionId;
	
	/**
	 *
	 * @var Customweb_Payment_Authorization_OrderContext_IAddress
	 */
	private $shippingAddress;
	
	/**
	 *
	 * @var Customweb_Payment_Authorization_OrderContext_IAddress
	 */
	private $billingAddress;
	private $shippingMethodName;
	private $paymentMethodMachineName;
	
	/**
	 *
	 * @var Customweb_Payment_Authorization_IPaymentMethod
	 */
	private $paymentMethod;
	
	private $providerData = array();
	
	private $createdOn;
	
	private $updatedOn;
	
	private $securityToken;
	
	private $securityTokenExpiryDate;
	
	private $authenticationSuccessUrl;
	
	private $authenticationEmailAddress;
	
	private $versionNumber;

	abstract protected function loadPaymentMethodByMachineName($machineName);

	public function onBeforeSave(Customweb_Database_Entity_IManager $manager){
		if ($this->getContextId() === null) {
			$this->setCreatedOn(new DateTime());
		}
		$this->setUpdatedOn(new DateTime());
		if (is_object($this->paymentMethod)) {
			$this->paymentMethodMachineName = $this->paymentMethod->getPaymentMethodName();
		}
	}

	public function onAfterLoad(Customweb_Database_Entity_IManager $manager){
		if (!empty($this->paymentMethodMachineName)) {
			$this->paymentMethod = $this->loadPaymentMethodByMachineName($this->paymentMethodMachineName);
		}
	}

	/**
	 * @PrimaryKey
	 */
	public function getContextId(){
		return $this->contextId;
	}

	/**
	 * @Column(type = 'varchar')
	 */
	public function getState(){
		return $this->state;
	}

	/**
	 * @Column(type = 'varchar')
	 */
	public function getFailedErrorMessage(){
		return $this->failedErrorMessage;
	}

	/**
	 * @Column(type = 'varchar')
	 */
	public function getCartUrl(){
		return $this->cartUrl;
	}

	/**
	 * @Column(type = 'varchar')
	 */
	public function getDefaultCheckoutUrl(){
		return $this->defaultCheckoutUrl;
	}

	/**
	 * @Column(type = 'object')
	 */
	public function getInvoiceItems(){
		return $this->invoiceItems;
	}

	public function setInvoiceItems(array $items){
		$this->invoiceItems = $items;
		$this->orderAmountInDecimals = Customweb_Util_Invoice::getTotalAmountIncludingTax($items);
		return $this;
	}

	public function addInvoiceItem(Customweb_Payment_Authorization_IInvoiceItem $item){
		$this->invoiceItems[] = $item;
		$this->orderAmountInDecimals = Customweb_Util_Invoice::getTotalAmountIncludingTax($this->invoiceItems);
		return $this;
	}
	
	/**
	 * @Column(type = 'decimal')
	 */
	public function getOrderAmountInDecimals(){
		return $this->orderAmountInDecimals;
	}
	
	/**
	 * @Column(type = 'varchar')
	 */
	public function getCurrencyCode(){
		return $this->currencyCode;
	}

	public function getLanguage(){
		return new Customweb_Core_Language($this->languageCode);
	}
	
	/**
	 * @Column(type = 'varchar')
	 */
	public function getLanguageCode() {
		return $this->languageCode;
	}
	
	public function setLanguageCode($code) {
		$this->languageCode = $code;
		return $this;
	}

	/**
	 * @Column(type = 'varchar')
	 */
	public function getCustomerEmailAddress(){
		return $this->customerEmailAddress;
	}

	/**
	 * @Column(type = 'varchar')
	 */
	public function getCustomerId(){
		return $this->customerId;
	}

	/**
	 * @Column(type = 'integer')
	 */
	public function getTransactionId(){
		return $this->transactionId;
	}

	/**
	 * @Column(type = 'object')
	 * @return Customweb_Payment_Authorization_OrderContext_IAddress
	 */
	public function getShippingAddress(){
		return $this->shippingAddress;
	}

	/**
	 * @param Customweb_Payment_Authorization_OrderContext_IAddress $shippingAddress
	 * @return Customweb_Payment_ExternalCheckout_AbstractContext
	 */
	public function setShippingAddress($shippingAddress){
		$this->shippingAddress = $shippingAddress;
		return $this;
	}
	
	/**
	 * @Column(type = 'object')
	 * @return Customweb_Payment_Authorization_OrderContext_IAddress
	 */
	public function getBillingAddress(){
		return $this->billingAddress;
	}

	/**
	 * @param Customweb_Payment_Authorization_OrderContext_IAddress $address
	 * @return Customweb_Payment_ExternalCheckout_AbstractContext
	 */
	public function setBillingAddress($address){
		$this->billingAddress = $address;
		return $this;
	}

	/**
	 * @Column(type = 'varchar')
	 */
	public function getShippingMethodName(){
		return $this->shippingMethodName;
	}

	public function setShippingMethodName($name){
		$this->shippingMethodName = $name;
		return $this;
	}

	public function getPaymentMethod(){
		return $this->paymentMethod;
	}

	/**
	 * @param Customweb_Payment_Authorization_IPaymentMethod $paymentMethod
	 * @return Customweb_Payment_ExternalCheckout_AbstractContext
	 */
	public function setPaymentMethod($paymentMethod){
		$this->paymentMethod = $paymentMethod;
		return $this;
	}

	/**
	 * @Column(type = 'varchar')
	 */
	public function getPaymentMethodMachineName(){
		return $this->paymentMethodMachineName;
	}

	public function setPaymentMethodMachineName($name){
		$this->paymentMethodMachineName = $name;
		return $this;
	}


	public function setContextId($contextId){
		$this->contextId = $contextId;
		return $this;
	}

	public function setState($state){
		$this->state = $state;
		return $this;
	}

	public function setFailedErrorMessage($failedErrorMessage){
		$this->failedErrorMessage = $failedErrorMessage;
		return $this;
	}

	public function setCartUrl($cartUrl){
		$this->cartUrl = $cartUrl;
		return $this;
	}

	public function setDefaultCheckoutUrl($defaultCheckoutUrl){
		$this->defaultCheckoutUrl = $defaultCheckoutUrl;
		return $this;
	}

	public function setCurrencyCode($currencyCode){
		$this->currencyCode = $currencyCode;
		return $this;
	}

	public function setCustomerEmailAddress($customerEmailAddress){
		$this->customerEmailAddress = $customerEmailAddress;
		return $this;
	}

	public function setCustomerId($customerId){
		$this->customerId = $customerId;
		return $this;
	}

	public function setTransactionId($transactionId){
		$this->transactionId = $transactionId;
		return $this;
	}

	/**
	 * @Column(type = 'object')
	 */
	public function getProviderData(){
		return $this->providerData;
	}

	public function setProviderData($providerData){
		$this->providerData = $providerData;
		return $this;
	}

	/**
	 * @Column(type = 'datetime')
	 */
	public function getCreatedOn(){
		return $this->createdOn;
	}

	public function setCreatedOn($createdOn){
		$this->createdOn = $createdOn;
		return $this;
	}

	/**
	 * @Column(type = 'datetime')
	 */
	public function getUpdatedOn(){
		return $this->updatedOn;
	}

	public function setUpdatedOn($updatedOn){
		$this->updatedOn = $updatedOn;
		return $this;
	}

	public function setOrderAmountInDecimals($orderAmountInDecimals){
		$this->orderAmountInDecimals = $orderAmountInDecimals;
		return $this;
	}
	
	/**
	 * @Column(type = 'varchar')
	 */
	public function getSecurityToken() {
		return $this->securityToken;
	}
	
	public function setSecurityToken($token) {
		$this->securityToken = $token;
		return $this;
	}
	
	/**
	 * @Column(type = 'datetime')
	 */
	public function getSecurityTokenExpiryDate() {
		return $this->securityTokenExpiryDate;
	}
	
	public function setSecurityTokenExpiryDate($date) {
		$this->securityTokenExpiryDate = $date;
		return $this;
	}

	/**
	 * @Column(type = 'varchar', size=512)
	 */
	public function getAuthenticationSuccessUrl(){
		return $this->authenticationSuccessUrl;
	}

	public function setAuthenticationSuccessUrl($authenticationSuccessUrl){
		$this->authenticationSuccessUrl = $authenticationSuccessUrl;
		return $this;
	}

	/**
	 * @Column(type = 'varchar')
	 */
	public function getAuthenticationEmailAddress(){
		return $this->authenticationEmailAddress;
	}

	public function setAuthenticationEmailAddress($authenticationEmailAddress){
		$this->authenticationEmailAddress = $authenticationEmailAddress;
		return $this;
	}
	
	
	/**
	 * @Version
	 */
	public function getVersionNumber(){
		return $this->versionNumber;
	}
	
	public function setVersionNumber($version){
		$this->versionNumber = $version;
		return $this;
	}
	
}