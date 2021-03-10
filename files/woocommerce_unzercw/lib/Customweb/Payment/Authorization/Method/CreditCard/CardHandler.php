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

// TODO: Add card number & CVV validation method.

/**
 * This class handles the intercation with card numbers and brand information.
 * 
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_Authorization_Method_CreditCard_CardHandler {
	
	/**
	 * @var Customweb_Payment_Authorization_Method_CreditCard_CardInformation[]
	 */
	private $cardInformationObjects = array();
	
	/**
	 * @var array
	 */
	private $prefixMap = null;
	
	/**
	 * @var boolean
	 */
	private $cvcPresent = null;
	
	/**
	 * @var boolean
	 */
	private $cvcRequired = null;
	
	/**
	 * @var array
	 */
	private $toExternalBrandMap = null;
	
	/**
	 * @var array
	 */
	private $toInternalBrandMap = null;
	
	/**
	 * @param Customweb_Payment_Authorization_Method_CreditCard_CardInformation[] $cardInformationObjects
	 */
	public function __construct(array $cardInformationObjects) {
		$this->cardInformationObjects = $cardInformationObjects;
	}
	
	/**
	 * This method returns the brand key for the given card number.
	 * 
	 * @param string $brand
	 * @throws Exception
	 */
	public function getBrandKeyByCardNumber($cardNumber) {
		
		$cardNumber = $this->sanitizeCardNumber($cardNumber);
		$prefixes = $this->getCardNumberPrefixMap();
		$cardBrand = null;
		foreach ($prefixes as $prefix => $brand) {
			if (substr($cardNumber, 0, strlen($prefix)) == $prefix) {
				return $brand;
			}
		}
		
		throw new Exception(Customweb_I18n_Translation::__("Could not find a brand for the given card number."));
	}
	
	/**
	 * This method checks if the given card number with the CVC is valid. In case not the method throws an exception.
	 * 
	 * @param string $cardNumber
	 * @param string $cvc
	 * @throws Exception
	 * @return void
	 */
	public function validateCardNumberAndCvc($cardNumber, $cvc) {
		$cardNumber = $this->sanitizeCardNumber($cardNumber);
		$cvc = $this->sanitizeCardNumber($cvc);
		$brandKey = $this->getBrandKeyByCardNumber($cardNumber);
		$information = $this->getCardInformationObjectByBrand($brandKey);
		$information->getCvvLength();
		
		if ($information->isCvvRequired()) {
			if (strlen($cvc) != $information->getCvvLength()) {
				throw new Exception(Customweb_I18n_Translation::__("The given CVC code has the wrong length."));
			}
		}
	
		$lengthMatch = false;
		foreach ($information->getCardNumberLengths() as $length) {
			if (strlen($cardNumber) == $length) {
				$lengthMatch = true;
				break;
			}
		}
		
		if (!$lengthMatch) {
			throw new Exception(Customweb_I18n_Translation::__("The given card number has an invalid length."));
		}
		
		if (!self::isValidLuhnCheckSum($cardNumber)) {
			throw new Exception(Customweb_I18n_Translation::__("The given card number has an invalid check sum."));
		}
	}
	
	/**
	 * Remove not accepted chars from the card number.
	 * 
	 * @param string $cardNumber
	 * @return string
	 */
	protected function sanitizeCardNumber($cardNumber) {
		return preg_replace('/[^0-9]+/', '', $cardNumber);
	}
	
	/**
	 * This method returns a sorted list of prefixes, which map to a given brand. The list
	 * is sorted by the length of the prefix.
	 * 
	 * @return array
	 */
	public function getCardNumberPrefixMap() {
		if ($this->prefixMap === null) {
			$this->prefixMap = array();
			
			foreach ($this->getCardInformationObjects() as $information) {
				/* @var $information Customweb_Payment_Authorization_Method_CreditCard_CardInformation */
				foreach ($information->getIssuerIdentificationNumberPrefixes() as $prefix) {
					$this->prefixMap[$prefix] = strtolower($information->getBrandKey());
				}
			}
			uksort($this->prefixMap, array('Customweb_Payment_Authorization_Method_CreditCard_CardHandler', 'compareStringLengths'));
		}
		
		return $this->prefixMap;
	}
	
	/**
	 * This method returns a card information object for the given brand key.
	 * 
	 * @param string $brandKey The key name for the given brand.
	 * @throws Exception
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation
	 */
	public function getCardInformationObjectByBrand($brandKey) {
		$key = strtolower($brandKey);
		if (isset($this->cardInformationObjects[$key])) {
			return $this->cardInformationObjects[$key];
		}
		
		throw new Exception(Customweb_I18n_Translation::__("The brand with key '!key' was not found in the card information map.", array('!key' => $brandKey)));
	}
	
	/**
	 * Returns a map of Customweb_Payment_Authorization_Method_CreditCard_CardInformation objects.
	 * 
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardInformation[]
	 */
	public function getCardInformationObjects() {
		return $this->cardInformationObjects;
	}
	
	/**
	 * Returns true, when the CVC is present for one of the brands.
	 *
	 * @return boolean
	 */
	public function isCvcPresentOnAnyBrand() {
		if ($this->cvcPresent === null) {
			$this->cvcPresent = false;
			foreach ($this->getCardInformationObjects() as $information) {
				if ($information->isCvvPresentOnCard()) {
					$this->cvcPresent = true;
					break;
				}
			}
		}
	
		return $this->cvcPresent;
	}
	
	/**
	 * Returns true, when the CVC is a required for one of the brands.
	 *
	 * @return boolean
	 */
	public function isCvcRequiredForAnyBrand() {
		if ($this->cvcRequired === null) {
			$this->cvcRequired = false;
			foreach ($this->getCardInformationObjects() as $information) {
				if ($information->isCvvRequired()) {
					$this->cvcRequired = true;
					break;
				}
			}
		}
		
		return $this->cvcRequired;
	}
	
	/**
	 * This method returns the external (PSP specific) name for 
	 * the given brand key. 
	 * 
	 * @param string $brandKey
	 * @return string
	 */
	public function mapBrandNameToExternalName($brand) {
		$map = $this->getExternalBrandMap();
		$key = strtolower($brand);
		if (isset($map[$key])) {
			return $map[$key];
		}
		
		throw new Exception(Customweb_I18n_Translation::__("The brand with key '!key' was not found in the card information map.", array('!key' => $brand)));
	}
	
	/**
	 * This method maps the external name for a brand to the internal
	 * brand key.
	 * 
	 * @param string $externalBrand
	 * @return string Interal brand key
	 * @throws Exception
	 */
	public function mapExternalBrandNameToBrandKey($brand) {
		$map = $this->getInteralBrandMap();
		$key = strtolower($brand);
		if (isset($map[$key])) {
			return $map[$key];
		}
		
		throw new Exception(Customweb_I18n_Translation::__("The brand with external name '!key' was not present in the map.", array('!key' => $brand)));
		
	}
	
	/**
	 * Returns a map which maps the brand key (key of the map) to the external
	 * PSP specific brand name (value of the map).
	 * 
	 * @return array
	 */
	public function getExternalBrandMap() {
		$this->generateBrandMaps();
		return $this->toExternalBrandMap;
	}
	
	/**
	 * Returns a map which maps the PSP specific name (key of the map) to the brand
	 * key (value of the map).
	 * 
	 * @return array
	 */
	public function getInteralBrandMap() {
		$this->generateBrandMaps();
		return $this->toInternalBrandMap;
	}
	
	protected function generateBrandMaps() {
		if ($this->toExternalBrandMap === null) {
			$this->toExternalBrandMap = array();
			foreach ($this->getCardInformationObjects() as $information) {
				/* @var $information Customweb_Payment_Authorization_Method_CreditCard_CardInformation */
				$this->toExternalBrandMap[strtolower($information->getBrandKey())] = $information->getMappedBrandKey();
				$this->toInternalBrandMap[strtolower($information->getMappedBrandKey())] = $information->getBrandKey();
			}
		}
	}
	
	/**
	 * Returns true, when the given numer has a valid
	 * Luhn check sum.
	 * 
	 * @param string $number
	 * @param boolean
	 */
	private static function isValidLuhnCheckSum($number) {
		settype($number, 'string');
		$sumTable = array(
			array(0,1,2,3,4,5,6,7,8,9),
			array(0,2,4,6,8,1,3,5,7,9)
		);
		$sum = 0;
		$flip = 0;
		for ($i = strlen($number) - 1; $i >= 0; $i--) {
			$sum += $sumTable[$flip++ & 0x1][$number[$i]];
		}
		return $sum % 10 === 0;
	}
	
	
	private static function compareStringLengths($a, $b)
	{
		if (strlen($a) == strlen($b)) {
			return 0;
		}
		else if (strlen($a) < strlen($b)) {
			return 1;
		}
		else {
			return -1;
		}
	}
}