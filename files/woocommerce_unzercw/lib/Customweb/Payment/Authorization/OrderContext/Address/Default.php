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

require_once 'Customweb/Payment/Authorization/OrderContext/IAddress.php';
require_once 'Customweb/Payment/Authorization/OrderContext/Address/Default.php';



/**
 * Default implementation of an address.
 * Any implementation of the interface should extend from this class. This makes
 * it more easy in the future to implement new methods.
 *
 * @author Thomas Hunziker / Nico Eigenmann
 *
 */
class Customweb_Payment_Authorization_OrderContext_Address_Default implements Customweb_Payment_Authorization_OrderContext_IAddress {
	private $emailAddress;
	private $gender;
	private $salutation;
	private $firstName;
	private $lastName;
	private $street;
	private $city;
	private $postCode;
	private $state;
	private $countryIsoCode;
	private $phoneNumber;
	private $mobilePhoneNumber;
	private $dateOfBirth;
	private $commercialRegisterNumber;
	private $companyName;
	private $salesTaxNumber;
	private $socialSecurityNumber;

	public function __construct(Customweb_Payment_Authorization_OrderContext_IAddress $address = null){
		if ($address !== null) {
			$this->city = $address->getCity();
			$this->commercialRegisterNumber = $address->getCommercialRegisterNumber();
			$this->companyName = $address->getCompanyName();
			$this->countryIsoCode = $address->getCountryIsoCode();
			$this->dateOfBirth = $address->getDateOfBirth();
			$this->emailAddress = $address->getEMailAddress();
			$this->firstName = $address->getFirstName();
			$this->gender = $address->getGender();
			$this->lastName = $address->getLastName();
			$this->mobilePhoneNumber = $address->getMobilePhoneNumber();
			$this->phoneNumber = $address->getPhoneNumber();
			$this->postCode = $address->getPostCode();
			$this->salesTaxNumber = $address->getSalesTaxNumber();
			$this->salutation = $address->getSalutation();
			$this->state = $address->getState();
			$this->street = $address->getStreet();
		}
	}

	/**
	 * Compares the given object to this object. In case they are equal this method
	 * returns true. 
	 * 
	 * @param object $address
	 * @return boolean
	 */
	public function equals($address){
		if ($address === null) {
			return false;
		}
		else if (!($address instanceof Customweb_Payment_Authorization_OrderContext_Address_Default)) {
			return false;
		}
		else if ($this->getCity() != $address->getCity()) {
			return false;
		}
		else if ($this->getCommercialRegisterNumber() != $address->getCommercialRegisterNumber()) {
			return false;
		}
		else if ($this->getCompanyName() != $address->getCompanyName()) {
			return false;
		}
		else if ($this->getCountryIsoCode() != $address->getCountryIsoCode()) {
			return false;
		}
		else if ($this->getDateOfBirth() != $address->getDateOfBirth()) {
			return false;
		}
		else if ($this->getEMailAddress() != $address->getEMailAddress()) {
			return false;
		}
		else if ($this->getFirstName() != $address->getFirstName()) {
			return false;
		}
		else if ($this->getGender() != $address->getGender()) {
			return false;
		}
		else if ($this->getLastName() != $address->getLastName()) {
			return false;
		}
		else if ($this->getMobilePhoneNumber() != $address->getMobilePhoneNumber()) {
			return false;
		}
		else if ($this->getPhoneNumber() != $address->getPhoneNumber()) {
			return false;
		}
		else if ($this->getPostCode() != $address->getPostCode()) {
			return false;
		}
		else if ($this->getSalesTaxNumber() != $address->getSalesTaxNumber()) {
			return false;
		}
		else if ($this->getSalutation() != $address->getSalutation()) {
			return false;
		}
		else if ($this->getState() != $address->getState()) {
			return false;
		}
		else if ($this->getStreet() != $address->getStreet()) {
			return false;
		}
		
		return true;
	}

	public function getEMailAddress(){
		return $this->emailAddress;
	}

	public function setEMailAddress($emailAddress){
		$this->emailAddress = $emailAddress;
		return $this;
	}

	public function getGender(){
		return $this->gender;
	}

	public function setGender($gender){
		$this->gender = $gender;
		return $this;
	}

	public function getSalutation(){
		return $this->salutation;
	}

	public function setSalutation($salutation){
		$this->salutation = $salutation;
		return $this;
	}

	public function getFirstName(){
		return $this->firstName;
	}

	public function setFirstName($firstName){
		$this->firstName = $firstName;
		return $this;
	}

	public function getLastName(){
		return $this->lastName;
	}

	public function setLastName($lastName){
		$this->lastName = $lastName;
		return $this;
	}

	public function getStreet(){
		return $this->street;
	}

	public function setStreet($street){
		$this->street = $street;
		return $this;
	}

	public function getCity(){
		return $this->city;
	}

	public function setCity($city){
		$this->city = $city;
		return $this;
	}

	public function getPostCode(){
		return $this->postCode;
	}

	public function setPostCode($postCode){
		$this->postCode = $postCode;
		return $this;
	}

	public function getState(){
		return $this->state;
	}

	public function setState($state){
		$this->state = $state;
		return $this;
	}

	public function getCountryIsoCode(){
		return $this->countryIsoCode;
	}

	public function setCountryIsoCode($countryIsoCode){
		$this->countryIsoCode = $countryIsoCode;
		return $this;
	}

	public function getPhoneNumber(){
		return $this->phoneNumber;
	}

	public function setPhoneNumber($phoneNumber){
		$this->phoneNumber = $phoneNumber;
		return $this;
	}

	public function getMobilePhoneNumber(){
		return $this->mobilePhoneNumber;
	}

	public function setMobilePhoneNumber($mobilePhoneNumber){
		$this->mobilePhoneNumber = $mobilePhoneNumber;
		return $this;
	}

	public function getDateOfBirth(){
		return $this->dateOfBirth;
	}

	public function setDateOfBirth($dateOfBirth){
		$this->dateOfBirth = $dateOfBirth;
		return $this;
	}

	public function getCommercialRegisterNumber(){
		return $this->commercialRegisterNumber;
	}

	public function setCommercialRegisterNumber($commercialRegisterNumber){
		$this->commercialRegisterNumber = $commercialRegisterNumber;
		return $this;
	}

	public function getCompanyName(){
		return $this->companyName;
	}

	public function setCompanyName($companyName){
		$this->companyName = $companyName;
		return $this;
	}

	public function getSalesTaxNumber(){
		return $this->salesTaxNumber;
	}

	public function setSalesTaxNumber($salesTaxNumber){
		$this->salesTaxNumber = $salesTaxNumber;
		return $this;
	}

	public function getSocialSecurityNumber(){
		return $this->socialSecurityNumber;
	}

	public function setSocialSecurityNumber($socialSecurityNumber){
		$this->socialSecurityNumber = $socialSecurityNumber;
		return $this;
	}
}