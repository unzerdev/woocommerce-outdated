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

require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Core/Charset.php';
require_once 'Customweb/Core/Exception/InvalidPatternException.php';
require_once 'Customweb/Core/Exception/CharsetNotFoundException.php';
require_once 'Customweb/Core/Util/Class.php';


/**
 * Abstract implementation of a charset. A charset defines how a string
 * representation must be interpreted. 
 * 
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_Core_Charset {
	
	const CONVERSION_BEHAVIOR_EXCEPTION = 0x01;
	const CONVERSION_BEHAVIOR_REMOVE = 0x02;
	const CONVERSION_BEHAVIOR_REPLACE = 0x03;
	
	
	/**
	 * @var array
	 */
	private static $charsets = array();
	
	private static $conversionBehavior = self::CONVERSION_BEHAVIOR_REPLACE;
	
	/**
	 * @var Customweb_Core_Charset
	 */
	private static $defaultCharset = null;
	
	private static $classMap = array(
		'UTF-8' =>	 		'Customweb_Core_Charset_UTF8',
		'ASCII' =>	 		'Customweb_Core_Charset_ASCII',
		'WINDOWS-1250' => 	'Customweb_Core_Charset_WINDOWS1250',
		'WINDOWS-1251' => 	'Customweb_Core_Charset_WINDOWS1251',
		'WINDOWS-1252' => 	'Customweb_Core_Charset_WINDOWS1252', 
		'WINDOWS-1254' => 	'Customweb_Core_Charset_WINDOWS1254',
		'WINDOWS-1255' => 	'Customweb_Core_Charset_WINDOWS1255',
		'WINDOWS-1256' => 	'Customweb_Core_Charset_WINDOWS1256',
		'WINDOWS-1257' => 	'Customweb_Core_Charset_WINDOWS1257',
		'WINDOWS-1258' => 	'Customweb_Core_Charset_WINDOWS1258',
		'ISO-8859-1' =>	 	'Customweb_Core_Charset_ISO88591', 
		'ISO-8859-2' =>	 	'Customweb_Core_Charset_ISO88592', 
		'ISO-8859-3' =>	 	'Customweb_Core_Charset_ISO88593', 
		'ISO-8859-4' =>	 	'Customweb_Core_Charset_ISO88594', 
		'ISO-8859-5' =>	 	'Customweb_Core_Charset_ISO88595',
		'ISO-8859-6' =>	 	'Customweb_Core_Charset_ISO88596', 
		'ISO-8859-7' =>		'Customweb_Core_Charset_ISO88597', 
		'ISO-8859-8' =>	 	'Customweb_Core_Charset_ISO88598', 
		'ISO-8859-9' =>	 	'Customweb_Core_Charset_ISO88599', 
		'ISO-8859-10' =>	'Customweb_Core_Charset_ISO885910',
		'ISO-8859-11' =>	'Customweb_Core_Charset_ISO885911',
		'ISO-8859-13' =>	'Customweb_Core_Charset_ISO885913', 
		'ISO-8859-14' =>	'Customweb_Core_Charset_ISO885914', 
		'ISO-8859-15' =>	'Customweb_Core_Charset_ISO885915', 
		'ISO-8859-16' =>	'Customweb_Core_Charset_ISO885916',
		'WINDOWS-437' => 	'Customweb_Core_Charset_WINDOWS437',
		'WINDOWS-737' => 	'Customweb_Core_Charset_WINDOWS737',
		'WINDOWS-775' => 	'Customweb_Core_Charset_WINDOWS775',
		'WINDOWS-850' => 	'Customweb_Core_Charset_WINDOWS850',
		'WINDOWS-852' => 	'Customweb_Core_Charset_WINDOWS852',
		'WINDOWS-855' => 	'Customweb_Core_Charset_WINDOWS855',
		'WINDOWS-857' => 	'Customweb_Core_Charset_WINDOWS857',
		'WINDOWS-860' => 	'Customweb_Core_Charset_WINDOWS860',
		'WINDOWS-861' => 	'Customweb_Core_Charset_WINDOWS861',
		'WINDOWS-862' => 	'Customweb_Core_Charset_WINDOWS862',
		'WINDOWS-863' => 	'Customweb_Core_Charset_WINDOWS863',
		'WINDOWS-864' => 	'Customweb_Core_Charset_WINDOWS864',
		'WINDOWS-865' => 	'Customweb_Core_Charset_WINDOWS865',
		'WINDOWS-866' => 	'Customweb_Core_Charset_WINDOWS866',
		'WINDOWS-869' => 	'Customweb_Core_Charset_WINDOWS869',
		'WINDOWS-874' => 	'Customweb_Core_Charset_WINDOWS874',
		'MAC-CYRILLIC' => 	'Customweb_Core_Charset_MACCYRILLIC',
		'MAC-GREEK' => 		'Customweb_Core_Charset_MACGREEK',
		'MAC-ICELAND' => 	'Customweb_Core_Charset_MACICELAND',
		'MAC-LATIN2' => 	'Customweb_Core_Charset_MACLATIN2',
		'MAC-ROMAN' => 		'Customweb_Core_Charset_MACROMAN',
		'MAC-TURKISH' => 	'Customweb_Core_Charset_MACTURKISH',
		'NUMERIC' => 		'Customweb_Core_Charset_Numeric',
		'ALPHANUMERIC' => 	'Customweb_Core_Charset_AlphaNumeric',
	);
	
	
	/**
	 * This method converts the given string in the current charset to UTF-8. The input string can be
	 * either an array of chars or a PHP string.
	 * 
	 * @param string $string Char sequence in the current charset.
	 * @return string Char sequence encoded as UTF-8
	 */
	abstract protected function toUTF8($string);

	/**
	 * This method converts the given UTF-8 string to the charset. This method may drop some chars,
	 * because the target charset is not able to represent all chars. The input string can be
	 * either an array of chars or a PHP string.
	 * 
	 * @param string $string
	 * @return string Char sequence encoded in charset.
	 */
	abstract protected function toCharset($string);
	
	/**
	 * Returns the name of the charset.
	 * 
	 * @return string Charset name
	 */
	abstract public function getName();
	
	/**
	 * Returns a list of alias names.
	 * 
	 * @return string[]
	 */
	abstract public function getAliases();
	
	/**
	 * Returns the length of the string.
	 * 
	 * @param string $string The string to check.
	 * @return int
	 */
	abstract public function getStringLength($string);
	
	/**
	 * Return the char at the given index.
	 * 
	 * @param string $string
	 * @param int $index
	 * @return string
	 */
	abstract public function getCharAt($string, $index);
	
	/**
	 * Returns the substring of the given substring starting at start and
	 * ending at the given offset from the start by the length.
	 * 
	 * @param string $string
	 * @param int $start
	 * @param int $length
	 * @return string
	 */
	abstract public function getSubstring($string, $start, $length);

	/**
	 * Returns the position of the first occurrence of needle in the specified string.
	 *
	 * @param string $stringSearchIn
	 * @param string $stringSearchFor
	 * @return int
	 */
	abstract public function getStringPosition($stringSearchIn, $needle, $offset = 0);

	/**
	 * Returns the position of the last occurrence of needle in the specified string.
	 *
	 * @param string $stringSearchIn
	 * @param string $stringSearchFor
	 * @return int
	 */
	abstract public function getLastStringPosition($stringSearchIn, $needle, $offset = 0);
	
	/**
	 * 
	 * @param string $subject
	 * @param string $pattern
	 * @param array $matches
	 * @param number $flags
	 * @param number $offset
	 * @return boolean
	 * @throws Customweb_Core_Exception_InvalidPatternException
	 */
	public function match($subject, $pattern, array &$matches = null, $flags = 0, $offset = 0) {
		$this->regexErrorMessage = null;
		set_error_handler( array( $this, 'handleRegexErrors' ) );
		$rs = preg_match($pattern, $subject, $matches, $flags, $offset);
		restore_error_handler();
	
		if ($this->regexErrorMessage !== null) {
			throw new Customweb_Core_Exception_InvalidPatternException($this->regexErrorMessage);
		}
		else {
			return $rs;
		}
	}
	
	/**
	 * 
	 * @param string $subject
	 * @param string $pattern
	 * @param array $matches
	 * @param string $flags
	 * @param number $offset
	 * @return number
	 * @throws Customweb_Core_Exception_InvalidPatternException
	 */
	public function matchAll($subject, $pattern, array &$matches = null, $flags = PREG_PATTERN_ORDER, $offset = 0) {
		$this->regexErrorMessage = null;
		set_error_handler( array( $this, 'handleRegexErrors' ) );
		$rs = preg_match_all($pattern, $subject, $matches, $flags, $offset);
		restore_error_handler();
	
		if ($this->regexErrorMessage !== null) {
			throw new Customweb_Core_Exception_InvalidPatternException($this->regexErrorMessage);
		}
		else {
			return $rs;
		}
	}
	
	/**
	 *
	 * @param string $subject
	 * @param array | string $pattern
	 * @param array | string $replacement
	 * @param int $limit
	 * @param int $count
	 * @return string
	 * @throws Customweb_Core_Exception_InvalidPatternException
	 */
	public function replaceAll($subject, $pattern, $replacement, $limit = -1, &$count = null) {
		$this->regexErrorMessage = null;
		set_error_handler( array( $this, 'handleRegexErrors' ) );
		$rs = preg_replace($pattern, $replacement, $subject, $limit, $count);
		restore_error_handler();
	
		if ($rs === NULL) {
			if ($this->regexErrorMessage !== null) {
				throw new Customweb_Core_Exception_InvalidPatternException($this->regexErrorMessage);
			}
			else {
				throw new Customweb_Core_Exception_InvalidPatternException('Evaluation of regex fails with an unknown error.');
			}
		}
		else {
			return $rs;
		}
	}

	/**
	 * Converts the given $string into a upper case string.
	 *
	 * @param string $string
	 */
	abstract public function toUpperCase($string);

	/**
	 * Converts the given $string into a lower case string.
	 *
	 * @param string $string
	 */
	abstract public function toLowerCase($string);
	
	/**
	 * Converts the given string into a char array.
	 * 
	 * @param string $string
	 * @return array
	 */
	abstract public function toArray($string);
	
	/**
	 * Removes all the given chars from the start of the string.
	 * 
	 * @param string $string
	 * @param string $chars (Optional)List of chars
	 * @return string
	 */
	abstract public function trimStart($string, $chars = '');
	
	/**
	 * Removes all the given chars from the end of the string.
	 * 
	 * @param string $string
	 * @param string $chars (Optional)List of chars
	 * @return string
	 */
	abstract public function trimEnd($string, $chars = '');
	
	/**
	 * 
	 * @param string $name
	 * @throws Customweb_Core_Exception_CharsetNotFoundException
	 * @return Customweb_Core_Charset
	 */
	public static function forName($name) {
		$name = self::normalizeCharsetName((string)$name);
		
		if (!isset(self::$charsets[$name])) {
			
			if (isset(self::$classMap[$name])) {
				$className = self::$classMap[$name];
				Customweb_Core_Util_Class::loadLibraryClassByName($className);
				self::$charsets[$name] = new $className($name);
			}
			else {
				$charsetName = self::searchAllAliasForName($name);
				if ($charsetName === null) {
					throw new Customweb_Core_Exception_CharsetNotFoundException($name);
				}
				$name = $charsetName;
			}
		}
		
		return self::$charsets[$name];
	}
	
	/**
	 * Returns a list of supported charsets.
	 * 
	 * @return multitype:string
	 */
	public static function getSupportedCharsets() {
		return array_keys(self::$classMap);
	}
	
	/**
	 * Converts the given string from the given charset into the given charset.
	 * 
	 * @param string $string
	 * @param string | Customweb_Core_Charset $charsetIn
	 * @param string | Customweb_Core_Charset $charsetOut
	 * @return string
	 */
	public static function convert($string, $charsetIn, $charsetOut) {
		
		if (is_string($charsetIn)) {
			$charsetIn = Customweb_Core_Charset::forName($charsetIn);
		}
		else if (!($charsetIn instanceof Customweb_Core_Charset)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Core_Charset');
		}
		
		if (is_string($charsetOut)) {
			$charsetOut = Customweb_Core_Charset::forName($charsetOut);
		}
		else if (!($charsetOut instanceof Customweb_Core_Charset)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Core_Charset');
		}
		
		$utf8String = $charsetIn->toUTF8($string);
		return $charsetOut->toCharset($utf8String);
	}
	
	/**
	 * This method sets the default charset. The default charset is used, whenever
	 * no charset is provided.
	 * 
	 * Changing the default charset may have a high impact on the whole string 
	 * manipulation. Per default UTF-8 is set as the default charset.
	 * 
	 * @param string | Customweb_Core_Charset $charset
	 * @throws Exception
	 * @return Customweb_Core_Charset
	 */
	public static function setDefaultCharset($charset) {
		if (is_string($charset)) {
			$charset = Customweb_Core_Charset::forName($charset);
		}
		else if (!($charset instanceof Customweb_Core_Charset)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Core_Charset');
		}
		self::$defaultCharset = $charset;
		
		return self::$defaultCharset;
	}
	
	/**
	 * Returns the default charset. The default charset is used whenever no 
	 * charset is defined. 
	 * See also self::setDefaultCharset().
	 * 
	 * @return Customweb_Core_Charset
	 */
	public static function getDefaultCharset() {
		if (self::$defaultCharset === null) {
			return self::forName('UTF-8');
		}
		return self::$defaultCharset;
	}
	
	/**
	 * Charset conversions can lead to situations, when a char can not be translated. This setting
	 * controls how the behavior is in this situations. 
	 * 
	 * It can be either:
	 * - CONVERSION_BEHAVIOR_EXCEPTION: An exception is thrown.
	 * - CONVERSION_BEHAVIOR_REMOVE: The char is removed.
	 * - CONVERSION_BEHAVIOR_REPLACE: The char is replaced by a best fit or removed when no replacement exists.
	 * 
	 * @param  $behavior
	 * @return void
	 */
	public static function setConversionBehavior($behavior) {
		self::$conversionBehavior = $behavior;
	}
	
	/**
	 * Returns the currently configured conversion behavior. See setConversionBehavior() for more information.
	 * 
	 * @return string
	 */
	public static function getConversionBehavior() {
		return self::$conversionBehavior;
	}
	
	/**
	 * With this method a custom encoding can be added to the set of supported 
	 * charsets. The name is the primary name. More names can be defined on the 
	 * method 'getAliases' on the given class. The class must implement extend
	 * 'Customweb_Core_Charset'.
	 * 
	 * @param string $name
	 * @param string $className
	 */
	public static function registerCustomEncoding($name, $className) {
		$name = self::normalizeCharsetName((string)$name);
		self::$classMap[$name] = $className;
	}
	
	protected static function normalizeCharsetName($name) {
		return strtoupper(str_replace('_', '-', str_replace(' ', '-', (string) $name)));
	}
	
	private static function searchAllAliasForName($name) {
		foreach (self::$classMap as $charSetName => $className) {
			if (!isset(self::$charsets[$charSetName])) {
				Customweb_Core_Util_Class::loadLibraryClassByName($className);
				self::$charsets[$charSetName] = new $className($name);
			}
				
			foreach (self::$charsets[$charSetName]->getAliases() as $alias) {
				$alias = self::normalizeCharsetName($alias);
				self::$charsets[$alias] = self::$charsets[$charSetName];
				if ($alias == $name) {
					return $charSetName;
				}
			}
		}
	
		return null;
	}

	private function handleRegexErrors($errno, $errstr, $errfile, $errline) {
		$errstr = str_replace('preg_match():', '', $errstr);
		$errstr = str_replace('preg_match_all():', '', $errstr);
		$errstr = str_replace('preg_replace():', '', $errstr);
		$this->regexErrorMessage = trim($errstr);
	}
}