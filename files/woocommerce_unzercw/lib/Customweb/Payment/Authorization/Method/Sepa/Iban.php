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

require_once 'Customweb/Core/String.php';
require_once 'Customweb/Payment/Authorization/ErrorMessage.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Payment/Exception/PaymentErrorException.php';


/**
 * Simple class which allows the interacting with IBANs. 
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_Authorization_Method_Sepa_Iban {
	
	private static $gmpInstalled = null;
	
	private static $bcmathInstalled = null;
	
	private $data = array();
	
	/**
	 * This method accepts a map of IBAN formats. (e.g. given by self::getIbanFormats()). 
	 * Only the given formats are used.
	 * 
	 * @param string $data (Optional) List of formats. Default: All.
	 */
	public function __construct($data = null) {
		if ($data === null) {
			$this->data = self::getIbanFormats();
		}
		else {
			$this->data = $data;
		}
	}
	
	/**
	 * Checks if the given IBAN is valid.
	 * 
	 * @param string $iban
	 * @throws Exception
	 * @return boolean
	 */
	public function validate($iban) {
		$format = $this->getFormat($iban);
		$allowedLength = $format['length'];
		
		if (strlen($iban) != $allowedLength) {
			throw new Customweb_Payment_Exception_PaymentErrorException(
				new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__("The length of the IBAN is invalid.")));
		}
		
		$regex = '/^' . $format['format'] . '$/i';
		if (!preg_match($regex, substr($iban, 4))) {
			throw new Customweb_Payment_Exception_PaymentErrorException(
				new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__("The format of the IBAN is invalid.")));
		}
		
		if (!self::validateCheckSum($iban)) {
			throw new Customweb_Payment_Exception_PaymentErrorException(
				new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__("The checksum of the IBAN is invalid.")));
		}
		
		return true;
	}
	
	/**
	 * Removes any obvious non valid char.
	 * 
	 * @param string $bic
	 * @return string
	 */
	public function sanitize($iban) {
		return strip_tags(str_replace(' ', '', $iban));
	}
	
	
	protected function getFormat($iban) {
		$countryCode = self::extractCountryCode($iban);
		if (isset($this->data[$countryCode])) {
			return $this->data[$countryCode];
		}
		else {
			throw new Exception(Customweb_Core_String::_("No valid country code in the given IBAN. Country Code: '!code'")->format(array('!code' => $countryCode)));
		}
	}
	
	/**
	 * Returns true when the checksum of the given IBAN is valid.
	 * 
	 * @param string $iban
	 * @return boolean
	 */
	public static function validateCheckSum($iban) {
		$iban = strtoupper($iban);
		$digitRepresentation = self::replaceLetters(substr($iban, 4) . substr($iban, 0, 4));
		
		if (self::mod97($digitRepresentation) === 1) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * This method calculates the mod 97 on the given number. Depending on the 
	 * available native implementations the calcuation can be faster.
	 * 
	 * @param string $numberAsString
	 * @return int
	 */
	private static function mod97($numberAsString) {
		if (self::isBcMathInstalled()) {
			return (int)bcmod($numberAsString, '97');
		}
		else if(self::isGmpInstalled()) {
			return (int)gmp_intval(gmp_mod(gmp_init($numberAsString, 10),'97')); 
		}
		else {
			$checksum = intval(substr($numberAsString, 0, 1));
			for ($pos = 1; $pos < strlen($numberAsString); $pos++) {
				$checksum *= 10;
				$checksum += intval(substr($numberAsString, $pos, 1));
				$checksum %= 97;
			}
			return (int)$checksum;
		}
	}
	
	private static function isGmpInstalled() {
		if (self::$gmpInstalled === null) {
			if (function_exists('gmp_intval')) {
				self::$gmpInstalled = true;
			}
			else {
				self::$gmpInstalled = false;
			}
		}
		
		return self::$gmpInstalled;
	}
	
	private static function isBcMathInstalled() {
		if (self::$bcmathInstalled === null) {
			if (function_exists('bcmod')) {
				self::$bcmathInstalled = true;
			}
			else {
				self::$bcmathInstalled = false;
			}
		}
		
		return self::$bcmathInstalled;
	}

	private static function replaceLetters($string) {
		$replaceChars = range('A','Z');
		foreach (range(10,35) as $number) { 
			$replacements[] = strval($number); 
		}
		return str_replace($replaceChars, $replacements, $string);
	}
	
	
	public static function extractCountryCode($iban) {
		return strtoupper(substr($iban, 0, 2));
	}
	
	
	/**
	 * Returns a map which contains a mapping between the format 
	 * and the country code.
	 * 
	 * @return multitype:multitype:number string
	 */
	public static function getIbanFormats() {
		return self::$formats;
	}
	
	private static $formats = array(
		'AL' => array(
			'length' => 28,
			'format' => '[0-9]{8}[a-zA-Z0-9]{16}',
		),
		'AD' => array(
			'length' => 24,
			'format' => '[0-9]{8}[a-zA-Z0-9]{12}',
		),
		'AT' => array(
			'length' => 20,
			'format' => '[0-9]{16}',
		),
		'AZ' => array(
			'length' => 28,
			'format' => '[a-zA-Z0-9]{4}[0-9]{20}',
		),
		'BH' => array(
			'length' => 22,
			'format' => '[A-Za-z]{4}[a-zA-Z0-9]{14}',
		),
		'BE' => array(
			'length' => 16,
			'format' => '[0-9]{12}',
		),
		'BA' => array(
			'length' => 20,
			'format' => '[0-9]{16}',
		),
		'BR' => array(
			'length' => 29,
			'format' => '[0-9]{23}[A-Za-z]{1}[a-zA-Z0-9]{1}',
		),
		'BG' => array(
			'length' => 22,
			'format' => '[A-Za-z]{4}[0-9]{6}[a-zA-Z0-9]{8}',
		),
		'CR' => array(
			'length' => 21,
			'format' => '[0-9]{17}',
		),
		'HR' => array(
			'length' => 21,
			'format' => '[0-9]{17}',
		),
		'CY' => array(
			'length' => 28,
			'format' => '[0-9]{8}[a-zA-Z0-9]{16}',
		),
		'CZ' => array(
			'length' => 24,
			'format' => '[0-9]{20}',
		),
		'DK' => array(
			'length' => 18,
			'format' => '[0-9]{14}',
		),
		'DO' => array(
			'length' => 28,
			'format' => '[A-Za-z]{4}[0-9]{20}',
		),
		'EE' => array(
			'length' => 20,
			'format' => '[0-9]{16}',
		),
		'FO' => array(
			'length' => 18,
			'format' => '[0-9]{14}',
		),
		'FI' => array(
			'length' => 18,
			'format' => '[0-9]{14}',
		),
		'FR' => array(
			'length' => 27,
			'format' => '[0-9]{10}[a-zA-Z0-9]{11}[0-9]{2}',
		),
		'GE' => array(
			'length' => 22,
			'format' => '[A-Za-z]{2}[0-9]{16}',
		),
		'DE' => array(
			'length' => 22,
			'format' => '[0-9]{18}',
		),
		'GI' => array(
			'length' => 23,
			'format' => '[A-Za-z]{4}[a-zA-Z0-9]{15}',
		),
		'GR' => array(
			'length' => 27,
			'format' => '[0-9]{7}[a-zA-Z0-9]{16}',
		),
		'GL' => array(
			'length' => 18,
			'format' => '[0-9]{14}',
		),
		'GT' => array(
			'length' => 28,
			'format' => '[a-zA-Z0-9]{24}',
		),
		'HU' => array(
			'length' => 28,
			'format' => '[0-9]{24}',
		),
		'IS' => array(
			'length' => 26,
			'format' => '[0-9]{22}',
		),
		'IE' => array(
			'length' => 22,
			'format' => '[a-zA-Z0-9]{4}[0-9]{14}',
		),
		'IL' => array(
			'length' => 23,
			'format' => '[0-9]{19}',
		),
		'IT' => array(
			'length' => 27,
			'format' => '[A-Za-z]{1}[0-9]{10}[a-zA-Z0-9]{12}',
		),
		'JO' => array(
			'length' => 30,
			'format' => '[A-Za-z]{4}[0-9]{22}',
		),
		'KZ' => array(
			'length' => 20,
			'format' => '[0-9]{3}[a-zA-Z0-9]{13}',
		),
		'KU' => array(
			'length' => 30,
			'format' => '[A-Za-z]{4}[a-zA-Z0-9]{22}',
		),
		'LV' => array(
			'length' => 21,
			'format' => '[A-Za-z]{4}[a-zA-Z0-9]{13}',
		),
		'LB' => array(
			'length' => 28,
			'format' => '[0-9]{4}[a-zA-Z0-9]{20}',
		),
		'LI' => array(
			'length' => 21,
			'format' => '[0-9]{5}[a-zA-Z0-9]{12}',
		),
		'LT' => array(
			'length' => 20,
			'format' => '[0-9]{16}',
		),
		'LU' => array(
			'length' => 20,
			'format' => '[0-9]{3}[a-zA-Z0-9]{13}',
		),
		'MK' => array(
			'length' => 19,
			'format' => '[0-9]{3}[a-zA-Z0-9]{10}[0-9]{2}',
		),
		'MT' => array(
			'length' => 31,
			'format' => '[A-Za-z]{4}[0-9]{5}[a-zA-Z0-9]{18}',
		),
		'MR' => array(
			'length' => 27,
			'format' => '[0-9]{23}',
		),
		'MU' => array(
			'length' => 30,
			'format' => '[A-Za-z]{4}[0-9]{19}[A-Za-z]{3}',
		),
		'MO' => array(
			'length' => 27,
			'format' => '[0-9]{10}[a-zA-Z0-9]{11}[0-9]{2}',
		),
		'MD' => array(
			'length' => 24,
			'format' => '[a-zA-Z0-9]{2}[0-9]{18}',
		),
		'ME' => array(
			'length' => 22,
			'format' => '[0-9]{18}',
		),
		'NL' => array(
			'length' => 18,
			'format' => '[A-Za-z]{4}[0-9]{10}',
		),
		'NO' => array(
			'length' => 15,
			'format' => '[0-9]{11}',
		),
		'PK' => array(
			'length' => 24,
			'format' => '[a-zA-Z0-9]{4}[0-9]{16}',
		),
		'PS' => array(
			'length' => 29,
			'format' => '[a-zA-Z0-9]{4}[0-9]{21}',
		),
		'PL' => array(
			'length' => 28,
			'format' => '[0-9]{24}',
		),
		'PT' => array(
			'length' => 25,
			'format' => '[0-9]{21}',
		),
		'QA' => array(
			'length' => 29,
			'format' => '[A-Za-z]{4}[a-zA-Z0-9]{21}',
		),
		'RO' => array(
			'length' => 24,
			'format' => '[A-Za-z]{4}[a-zA-Z0-9]{16}',
		),
		'SM' => array(
			'length' => 27,
			'format' => '[A-Za-z]{1}[0-9]{10}[a-zA-Z0-9]{12}',
		),
		'SA' => array(
			'length' => 24,
			'format' => '[0-9]{2}[a-zA-Z0-9]{18}',
		),
		'RS' => array(
			'length' => 22,
			'format' => '[0-9]{18}',
		),
		'SK' => array(
			'length' => 24,
			'format' => '[0-9]{20}',
		),
		'SI' => array(
			'length' => 19,
			'format' => '[0-9]{15}',
		),
		'ES' => array(
			'length' => 24,
			'format' => '[0-9]{20}',
		),
		'SE' => array(
			'length' => 24,
			'format' => '[0-9]{20}',
		),
		'CH' => array(
			'length' => 21,
			'format' => '[0-9]{5}[a-zA-Z0-9]{12}',
		),
		'TN' => array(
			'length' => 24,
			'format' => '[0-9]{20}',
		),
		'TR' => array(
			'length' => 26,
			'format' => '[0-9]{5}[a-zA-Z0-9]{17}',
		),
		'AE' => array(
			'length' => 23,
			'format' => '[0-9]{3}[a-zA-Z0-9]{16}',
		),
		'GB' => array(
			'length' => 22,
			'format' => '[A-Za-z]{4}[0-9]{14}',
		),
		'VG' => array(
			'length' => 24,
			'format' => '[a-zA-Z0-9]{4}[0-9]{16}',
		),
	);
	
	
	
}