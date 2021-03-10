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


/**
 * A abstract implementation of a order context. Any order context should extend from this
 * class.
 * 
 * @author Thomas Hunziker / Nico Eigenmann
 *
 */
abstract class Customweb_Payment_Authorization_OrderContext_Abstract implements Customweb_Payment_Authorization_IOrderContext {
	
	private $shippingAddress = null;
	
	private $billingAddress = null;
	
	public function __construct(Customweb_Payment_Authorization_OrderContext_IAddress $billingAddress, Customweb_Payment_Authorization_OrderContext_IAddress $shippingAddress = null) {
		$this->billingAddress = $billingAddress;
		$this->shippingAddress = $shippingAddress;
		if ($this->shippingAddress === null) {
			$this->shippingAddress = $this->billingAddress;
		}
	}
	
	public function isAjaxReloadRequired() {
		return false;
	}

	public function getShippingAddress(){
		return $this->shippingAddress;
	}
	
	public function getBillingAddress(){
		return $this->billingAddress;
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingEMailAddress() {
		return $this->getBillingAddress()->getEMailAddress();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingGender() {
		return $this->getBillingAddress()->getGender();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingSalutation() {
		return $this->getBillingAddress()->getSalutation();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingFirstName() {
		return $this->getBillingAddress()->getFirstName();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingLastName() {
		return $this->getBillingAddress()->getLastName();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingStreet() {
		return $this->getBillingAddress()->getStreet();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingCity() {
		return $this->getBillingAddress()->getCity();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingPostCode() {
		return $this->getBillingAddress()->getPostCode();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingState() {
		return $this->getBillingAddress()->getState();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingCountryIsoCode() {
		return $this->getBillingAddress()->getCountryIsoCode();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingPhoneNumber() {
		return $this->getBillingAddress()->getPhoneNumber();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingMobilePhoneNumber() {
		return $this->getBillingAddress()->getMobilePhoneNumber();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingDateOfBirth() {
		return $this->getBillingAddress()->getDateOfBirth();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingCommercialRegisterNumber() {
		return $this->getBillingAddress()->getCommercialRegisterNumber();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingCompanyName() {
		return $this->getBillingAddress()->getCompanyName();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingSalesTaxNumber() {
		return $this->getBillingAddress()->getSalesTaxNumber();
	}
	
	/**
	 * @deprecated
	 */
	public function getBillingSocialSecurityNumber() {
		return $this->getBillingAddress()->getSocialSecurityNumber();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingEMailAddress() {
		return $this->getShippingAddress()->getEMailAddress();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingGender() {
		return $this->getShippingAddress()->getGender();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingSalutation() {
		return $this->getShippingAddress()->getSalutation();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingFirstName() {
		return $this->getShippingAddress()->getFirstName();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingLastName() {
		return $this->getShippingAddress()->getLastName();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingStreet() {
		return $this->getShippingAddress()->getStreet();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingCity() {
		return $this->getShippingAddress()->getCity();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingPostCode() {
		return $this->getShippingAddress()->getPostCode();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingState() {
		return $this->getShippingAddress()->getState();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingCountryIsoCode() {
		return $this->getShippingAddress()->getCountryIsoCode();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingPhoneNumber() {
		return $this->getShippingAddress()->getPhoneNumber();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingMobilePhoneNumber() {
		return $this->getShippingAddress()->getMobilePhoneNumber();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingDateOfBirth() {
		return $this->getShippingAddress()->getDateOfBirth();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingCompanyName() {
		return $this->getShippingAddress()->getCompanyName();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingCommercialRegisterNumber() {
		return $this->getShippingAddress()->getCommercialRegisterNumber();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingSalesTaxNumber() {
		return $this->getShippingAddress()->getSalesTaxNumber();
	}
	
	/**
	 * @deprecated
	 */
	public function getShippingSocialSecurityNumber() {
		return $this->getShippingAddress()->getSocialSecurityNumber();
	}
	
	
}