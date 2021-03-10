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
 * Stores card information about a brand.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_Authorization_Method_CreditCard_CardInformation {
	
	/**
	 * @var string
	 */
	private $brand = null;
	
	/**
	 * @var string
	 */
	private $brandKey = null;
	
	/**
	 * @var string
	 */
	private $mappedBrandKey = null;
	
	/**
	 * @var int[]
	 */
	private $issuerIdentificationNumberPrefixes = array();
	
	/**
	 * @var int[]
	 */
	private $cardNumberLengths = array();
	
	/**
	 * @var string[]
	 */
	private $validators = array();
	
	/**
	 * @var int
	 */
	private $cvvLength = 0;
	
	/**
	 * @var boolean
	 */
	private $cvvRequired = false;
	
	/**
	 * @var boolean
	 */
	private $cvvPresentOnCard = false;
	
	/**
	 * @var string
	 */
	private $greyImageUrl = null;
	
	/**
	 * @var string
	 */
	private $colorImageUrl = null;
	
	/**
	 * This method creates a map of Customweb_Payment_Authorization_Method_CreditCard_CardInformation objects, with the
	 * brand as the key. It can be optionally filtered by a list of brands. Only the brands indicated by $filterByBrands
	 * will be in the returned map.
	 * 
	 * @param array $data
	 * @param array|string $filterByBrands Either an array with accepted brands or a single brand name.
	 * @param string $parameterKeyForMappedBrand The key name for the parameter to map the brands to.
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation[]
	 */
	public static function getCardInformationObjects(array $data, $filterByBrands = null, $parameterKeyForMappedBrand = null) {
		
		if (is_string($filterByBrands)) {
			$filterByBrands = array($filterByBrands);
		}
		
		// Ensures lowercase
		if (is_array($filterByBrands)) {
			foreach($filterByBrands as $key => $value) {
				$filterByBrands[$key] = strtolower($value);
			}
		}
		
		
		$objects = array();
		
		foreach ($data as $brand => $information) {
			$brand = strtolower($brand);
			// Filter the brand, in case it is not in the given list of accepted brands
			if ($filterByBrands !== null && !in_array($brand, $filterByBrands)) {
				continue;
			}
			
			if (!isset($information['credit_card_information'])) {
				continue;
			}

			$ccInformation = $information['credit_card_information'];
			
			$object = new Customweb_Payment_Authorization_Method_CreditCard_CardInformation();
			$object
				->setBrandName($information['method_name'])
				->setBrandKey($brand)
				->setCardNumberLengths($ccInformation['lengths'])
				->setIssuerIdentificationNumberPrefixes($ccInformation['issuer_identification_number_prefixes'])
				->setValidators($ccInformation['validators'])
				->setGreyImageUrl($information['image_grey'])
				->setColorImageUrl($information['image_color']);
			
			if (isset($ccInformation['cvv_length'])) {
				$object->setCvvLength($ccInformation['cvv_length']);
				$object->setCvvPresentOnCard(true);
				if (isset($ccInformation['cvv_required']) && $ccInformation['cvv_required'] == 'true') {
					$object->setCvvRequired(true);
				}
			}
			else {
				$object->setCvvPresentOnCard(false);
			}
			
			if ($parameterKeyForMappedBrand !== null && isset($information['parameters'][$parameterKeyForMappedBrand])) {
				$object->setMappedBrandKey($information['parameters'][$parameterKeyForMappedBrand]);
			}
			
			$brand = strtolower($brand);
			$objects[$brand] = $object;
		}
		
		return $objects;
	}
	
	/**
	 * Returns the brand key. The brand key identifies the brand. It 
	 * does not contain whitespaces or any other special chars.
	 * 
	 * @return string
	 */
	public function getBrandKey() {
		return $this->brandKey;
	}
	
	/**
	 * Sets the brand key. 
	 * 
	 * @param string $key
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation
	 */
	public function setBrandKey($key) {
		$this->brandKey = $key;
		return $this;
	}
	
	/**
	 * Returns the key, which is mapped to this brand. When no key is mapped
	 * the brand key is returned.
	 * 
	 * @return string
	 */
	public function getMappedBrandKey() {
		if ($this->mappedBrandKey === null) {
			return $this->getBrandKey();
		}
		else {
			return $this->mappedBrandKey;
		}
	}
	
	/**
	 * This method sets the mapped brand key for this brand.
	 * 
	 * @param string $mappedKey
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation
	 */
	public function setMappedBrandKey($mappedKey) {
		$this->mappedBrandKey = $mappedKey;
		return $this;
	}
	
	/**
	 * Returns the brand name linked with this card information.
	 * 
	 * @return string Brand Name
	 */
	public function getBrandName() {
		return $this->brand;
	}
	
	/**
	 * Sets the brand name linked with this card information.
	 * 
	 * @param string $brand
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation
	 */
	public function setBrandName($brand) {
		$this->brand = $brand;
		return $this;
	}
	
	/**
	 * Returns a list of prefixes, that identifies this card brand.
	 * 
	 * @return int[]
	 */
	public function getIssuerIdentificationNumberPrefixes() {
		return $this->issuerIdentificationNumberPrefixes;
	}
	
	/**
	 * Sets the prefixes, that identifies this card brand.
	 * 
	 * @param int[] $prefixes
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation
	 */
	public function setIssuerIdentificationNumberPrefixes($prefixes) {
		$this->issuerIdentificationNumberPrefixes = $prefixes;
		return $this;
	}
	
	/**
	 * This method adds a prefix to the list of prefixes.
	 * 
	 * @param int $prefix
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation
	 */
	public function appendIssuerIdentificationNumberPrefix($prefix) {
		$this->issuerIdentificationNumberPrefixes[] = $prefix;
		return $this;
	}
	
	/**
	 * Returns a list of card lengths, accepted for this brand.
	 * @return int[]
	 */
	public function getCardNumberLengths() {
		return $this->cardNumberLengths;
	}
	
	/**
	 * Sets the list of lengths accepted for this brand.
	 * 
	 * @param int[] $lengths
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation
	 */
	public function setCardNumberLengths($lengths) {
		$this->cardNumberLengths = $lengths;
		return $this;
	}
	
	/**
	 * Adds a accepted length to the list.
	 * 
	 * @param int $length
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation
	 */
	public function appendCardNumberLength($length) {
		$this->cardNumberLengths[] = $length;
		return $this;
	}
	
	/**
	 * Returns a list of validators applied on this card brand. 
	 * 
	 * @return string[]
	 */
	public function getValidators() {
		return $this->validators;
	}
	
	/**
	 * Sets the validators applied on this card brand.
	 * 
	 * @param string[] $validators
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation
	 */
	public function setValidators($validators) {
		$this->validators = $validators;
		return $this;
	}
	
	/**
	 * Adds the given validator to the list of validators applied on
	 * this card brand.
	 * 
	 * @param string $validator
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation
	 */
	public function appendValidator($validator) {
		$this->validators[] = $validator;
		return $this;
	}

	/**
	 * Returns the length of CVV.
	 * 
	 * @return int
	 */
	public function getCvvLength() {
		return $this->cvvLength;
	}
	
	/**
	 * Sets the CVV length for this brand.
	 * 
	 * @param int $length
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation
	 */
	public function setCvvLength($length) {
		$this->cvvLength = $length;
		return $this;
	}
	
	/**
	 * Returns, if the CVV is required for this brand.
	 * 
	 * @return boolean
	 */
	public function isCvvRequired() {
		if ($this->cvvRequired === true) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * Sets whether the CVV is a required value for this 
	 * card brand.
	 * 
	 * @param boolean $required
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation
	 */
	public function setCvvRequired($required = true) {
		$this->cvvRequired = $required;
		return $this;
	}
	
	/**
	 * Returns true, when the card brand may have a CVV. 
	 * 
	 * @return boolean
	 */
	public function isCvvPresentOnCard() {
		if ($this->cvvPresentOnCard === true) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * Sets if this card brand may have a CVV value.
	 * 
	 * @param boolean $present
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation
	 */
	public function setCvvPresentOnCard($present = true) {
		$this->cvvPresentOnCard = $present;
		return $this;
	}
	
	/**
	 * Returns the URL to the grey scale image of this brand.
	 * 
	 * @return string
	 */
	public function getGreyImageUrl() {
		return $this->greyImageUrl;
	}
	
	/**
	 * Sets the URL to the grey scale image.
	 * 
	 * @param string $url
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation
	 */
	public function setGreyImageUrl($url) {
		$this->greyImageUrl = $url;
		return $this;
	}
	
	/**
	 * Returns the color image URL for this brand.
	 * 
	 * @return string
	 */
	public function getColorImageUrl() {
		return $this->colorImageUrl;
	}
	
	/**
	 * Sets the color image URL for this brand.
	 * 
	 * @param string $url
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation
	 */
	public function setColorImageUrl($url) {
		$this->colorImageUrl = $url;
		return $this;
	}
		
}