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

require_once 'Customweb/Unzer/Container.php';
require_once 'Customweb/Core/DateTime.php';
require_once 'Customweb/Unzer/Util/String.php';
require_once 'Customweb/Unzer/Communication/AbstractTransactionRequestBuilder.php';
require_once 'Customweb/Core/Http/IRequest.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Customer_CreateRequestBuilder extends Customweb_Unzer_Communication_AbstractTransactionRequestBuilder {
	protected $paymentMethod;

	public function __construct(Customweb_Unzer_Authorization_Transaction $transaction, Customweb_DependencyInjection_IContainer $container){
		$container = Customweb_Unzer_Container::get($container);
		$this->paymentMethod = $container->getPaymentMethodByTransaction($transaction);
		parent::__construct($transaction, $container);
	}

	protected function getMethod(){
		return Customweb_Core_Http_IRequest::METHOD_POST;
	}

	private function getTypeSpecificParameters(){
		if ($this->isB2B()) {
			return $this->getB2BParameters();
		}
		return $this->getB2CParameters();
	}

	private function getB2BParameters(){
		$parameters = array();

		$registerNumber = $this->getCommercialRegistrationNumber();
		if ($registerNumber) {
			$parameters = array(
				'companyInfo' => array(
					'registrationType' => 'registered',
					'commercialRegisterNumber' => $registerNumber
				)
			);
		}
		else {
			$parameters = $this->getOptionalParameter('birthDate', $this->getBirthdate());
			$parameters['companyInfo'] = array(
				'registrationType' => 'not_registered',
				'commercialSector' => $this->getCustomerDataByKey('unzer-commercial-sector')
			);
		}

		return array_merge($parameters, $this->getConditionallyMandatoryParameter('email', $this->getEMailAddress(), 100));
	}

	private function getCommercialRegistrationNumber(){
		$number = $this->getAddress()->getCommercialRegisterNumber();
		if (empty($number)) {
			$number = $this->getCustomerDataByKey('unzer-commercial-register-number', false);
		}
		return $number;
	}

	private function getB2CParameters(){
		//@formatter:off
		return array_merge(
				$this->getOptionalParameter('birthDate',  $this->getBirthdate()),
				$this->getConditionallyMandatoryParameter('email', $this->getEMailAddress(), 100)
		);
		//@formatter:on
	}

	private function getAddressParameter($type, Customweb_Payment_Authorization_OrderContext_IAddress $address){
		// @formatter:off
		return array(
			$type . 'Address' => array_merge(
				array('name' => $address->getFirstName() . ' ' . $address->getLastName()),
				$this->getOptionalParameter('street', $address->getStreet(), 50),
				$this->getOptionalParameter('state', $address->getState(), 8),
				$this->getOptionalParameter('zip', $address->getPostCode(), 10),
				$this->getOptionalParameter('city', $address->getCity(), 30),
				$this->getOptionalParameter('country', $address->getCountryIsoCode())
			)
		);
		// @formatter:on
	}

	protected function getPayload(){
		$address = $this->getAddress();
		//@formatter:off
		return array_merge(
			$this->getTypeSpecificParameters(),
			$this->getAddressParameter('billing', $address),
			$this->getAddressParameter('shipping', $this->getOrderContext()->getShippingAddress()),
			$this->getMandatoryParameter('firstname', $address->getFirstName(), 40),
			$this->getMandatoryParameter('lastname', $address->getLastName(), 40),
			array('salutation' => $this->getSalutation($address)),
			$this->getOptionalParameter('company', $address->getCompanyName(), 40),
			$this->getOptionalParameter('customerId', $this->getOrderContext()->getCustomerId(), 256),
			$this->getOptionalParameter('phone', Customweb_Unzer_Util_String::cleanPhone($address->getPhoneNumber())),
			$this->getOptionalParameter('mobile', Customweb_Unzer_Util_String::cleanPhone($address->getMobilePhoneNumber()))
		);
		//@formatter:on
	}

	private function getBirthdate(){
		$dob = $this->getAddress()->getDateOfBirth();
		if (empty($dob)) {
			$required = $this->paymentMethod->isBirthdateRequired(); // is possible that is set via form for b2b, but not required by payment method. send if present
			$y = $this->getCustomerDataByKey('unzer-dob-y', $required);
			$m = $this->getCustomerDataByKey('unzer-dob-m', $required);
			$d = $this->getCustomerDataByKey('unzer-dob-d', $required);
			if ($y && $m && $d) {
				$dob = Customweb_Core_DateTime::createFromFormat('Y-m-d', "{$y}-{$m}-{$d}")->setTime(0, 0, 0);
			}
			else {
				return null;
			}
		}
		return $dob->format('Y-m-d');
	}
	
	private function getEmailAddress() {
		$email = $this->getAddress()->getEMailAddress();
		if(empty($email)) {
			$email = $this->getCustomerDataByKey('unzer-email', $this->paymentMethod->isEmailRequired());
		}
		return $email;
	}

	private function isB2B(){
		return $this->paymentMethod->isB2B($this->getOrderContext());
	}

	private function getAddress(){
		return $this->getOrderContext()->getBillingAddress();
	}

	private function getSalutation(Customweb_Payment_Authorization_OrderContext_IAddress $address){
		$mappings = array(
			'male' => 'MR',
			'female' => 'MRS',
			'mr' => 'MR',
			'ms' => 'MRS',
			'miss' => 'MRS',
			'mz' => 'MRS',
			'mrs' => 'MRS'
		);
		$keys = array(
			strtolower($address->getSalutation()),
			strtolower($address->getGender())
		);
		foreach ($keys as $key) {
			if (isset($mappings[$key])) {
				return $mappings[$key];
			}
		}
		return strtoupper($this->getCustomerDataByKey('unzer-salutation'));
	}

	protected function getConditionallyMandatoryParameter($name, $value, $maxLength = null){
		if ($this->paymentMethod->isParameterMandatory($name, $this->getRequestType())) {
			return $this->getMandatoryParameter($name, $value, $maxLength);
		}
		return $this->getOptionalParameter($name, $value, $maxLength);
	}

	protected function getUrlPath(){
		return 'customers';
	}

	private function getRequestType(){
		return 'customer';
	}
}