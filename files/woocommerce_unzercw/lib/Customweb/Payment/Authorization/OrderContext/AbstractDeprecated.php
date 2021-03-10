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
require_once 'Customweb/Payment/Authorization/OrderContext/Address/Default.php';


/**
 * Implementation for order contexts which does not yet extend the 
 * Customweb_Payment_Authorization_OrderContext_Abstract class. This 
 * class will be removed in the future.
 * 
 * @author Nico Eigenmann
 * @deprecated
 */
abstract class Customweb_Payment_Authorization_OrderContext_AbstractDeprecated implements Customweb_Payment_Authorization_IOrderContext {
	
	public function isAjaxReloadRequired() {
		return false;
	}
	
	public function getBillingAddress() {
		$address = new Customweb_Payment_Authorization_OrderContext_Address_Default();
		$address->setCity($this->getBillingCity())
			->setCommercialRegisterNumber($this->getBillingCommercialRegisterNumber())
			->setCompanyName($this->getBillingCompanyName())
			->setCountryIsoCode($this->getBillingCountryIsoCode())
			->setDateOfBirth($this->getBillingDateOfBirth())
			->setEMailAddress($this->getBillingEMailAddress())
			->setFirstName($this->getBillingFirstName())
			->setGender($this->getBillingGender())
			->setLastName($this->getBillingLastName())
			->setMobilePhoneNumber($this->getBillingMobilePhoneNumber())
			->setPhoneNumber($this->getBillingPhoneNumber())
			->setPostCode($this->getBillingPostCode())
			->setSalesTaxNumber($this->getBillingSalesTaxNumber())
			->setSalutation($this->getBillingSalutation())
			->setSocialSecurityNumber($this->getBillingSocialSecurityNumber())
			->setState($this->getBillingState())
			->setStreet($this->getBillingStreet());
		return $address;
		
	
	}
	
	public function getShippingAddress() {
		$address = new Customweb_Payment_Authorization_OrderContext_Address_Default();
		$address->setCity($this->getShippingCity())
			->setCommercialRegisterNumber($this->getShippingCommercialRegisterNumber())
			->setCompanyName($this->getShippingCompanyName())
			->setCountryIsoCode($this->getShippingCountryIsoCode())
			->setDateOfBirth($this->getShippingDateOfBirth())
			->setEMailAddress($this->getShippingEMailAddress())
			->setFirstName($this->getShippingFirstName())
			->setGender($this->getShippingGender())
			->setLastName($this->getShippingLastName())
			->setMobilePhoneNumber($this->getShippingMobilePhoneNumber())
			->setPhoneNumber($this->getShippingPhoneNumber())
			->setPostCode($this->getShippingPostCode())
			->setSalesTaxNumber($this->getShippingSalesTaxNumber())
			->setSalutation($this->getShippingSalutation())
			->setSocialSecurityNumber($this->getShippingSocialSecurityNumber())
			->setState($this->getShippingState())
			->setStreet($this->getShippingStreet());
		return $address;
	}
}