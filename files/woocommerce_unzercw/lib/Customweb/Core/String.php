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

require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Core/String.php';
require_once 'Customweb/Core/Charset.php';
require_once 'Customweb/Core/Charset/UTF8.php';
require_once 'Customweb/Core/Exception/BadMethodCallException.php';



/**
 * This implementation of a string provides facilities to manipulate strings
 * in the context of a charset.
 *
 *
 * It supports UTF-8 and multi byte string manipulations. The class is immutable.
 * Each manipulation will return a new reference to a string object.
 *
 *
 * @author Thomas Hunziker
 *
 */
final class Customweb_Core_String implements Iterator, ArrayAccess, Countable {

	/**
	 * Internal representation of the string.
	 *
	 * @var string
	 */
	private $string = null;

	/**
	 *
	 * @var string
	 */
	private $charset = null;

	/**
	 * Length of the string
	 *
	 * @var int
	 */
	private $length = null ;

	/**
	 *
	 * @var Customweb_Core_Charset
	 */
	private $charsetObject = null;

	/**
	 * Pointer on the current index.
	 *
	 * @var int
	 */
	private $index = 0;

	/**
	 * Short hand for the constructor to provide better access to the fluend API.
	 * See also self::__construct()
	 *
	 * @param string $string
	 * @param tring | Customweb_Core_Charset $charset
	 * @param boolean $keepCharset
	 * @return Customweb_Core_String
	 */
	public static function _($string, $charset = null, $keepCharset = false){
		return new Customweb_Core_String($string, $charset, $keepCharset);
	}

	/**
	 * Constructor of the string.
	 *
	 *
	 * If no charset is provided the default charset is assumed. The default charset
	 * can be set on the Customweb_Core_Charset. If the charset is set to 'fix' than
	 * the string is tried to convert to UTF-8 by keeping UTF-8 chars and converting
	 * ISO-8859-1 and WINOWS-1250 chars to UTF-8. This may be useful in cases, when
	 * the charset is unclear. However it will be never perfect. See
	 * Customweb_Core_Charset_UTF8::fixCharset for more information.
	 *
	 * If the flag keepCharset is set to true, then the charset is kept as provided.
	 * Otherwise the string is converted to the default charset.
	 *
	 *
	 * @param string $string
	 * @param string | Customweb_Core_Charset $charset
	 * @param boolean $keepCharset
	 */
	public function __construct($string, $charset = null, $keepCharset = false){
		$this->string = (string) $string;

		// In case no charset is provided we assume it is the default charset.
		if ($charset === null) {
			$charset = Customweb_Core_Charset::getDefaultCharset();
		}

		if ($charset === 'fix') {
			$this->string = Customweb_Core_Charset_UTF8::fixCharset($this->string);
			$charset = 'UTF-8';
		}

		// Since we may serialize this object, we store the charset name and not the
		// whole charset.
		if (is_object($charset)) {
			if (!($charset instanceof Customweb_Core_Charset)) {
				throw new Customweb_Core_Exception_CastException('Customweb_Core_Charset');
			}
			$this->charsetObject = $charset;
			$this->charset = $charset->getName();
		}
		else {
			$this->charsetObject = Customweb_Core_Charset::forName($charset);
			$this->charset = $this->charsetObject->getName();
		}

		// Convert to default charset, if not defined differently
		if ($keepCharset !== true && $this->charset !== Customweb_Core_Charset::getDefaultCharset()->getName()) {
			$this->string = Customweb_Core_Charset::convert($this->string, $this->charsetObject, Customweb_Core_Charset::getDefaultCharset());
			$this->charsetObject = Customweb_Core_Charset::getDefaultCharset();
			$this->charset = $this->charsetObject->getName();
		}
	}

	/**
	 * Ensures that the serialization of the object works well.
	 *
	 * @return multitype:string
	 */
	public function __sleep(){
		return array(
			'string',
			'charset'
		);
	}

	/**
	 * Returns the charset of the string.
	 *
	 * @return Customweb_Core_Charset
	 */
	public function getCharset(){
		if ($this->charsetObject === null) {
			$this->charsetObject = Customweb_Core_Charset::forName($this->charset);
		}

		return $this->charsetObject;
	}

	/**
	 * This method returns the length of the string.
	 *
	 * @return number
	 */
	public function getLength(){
		if ($this->length === null) {
			$this->length = $this->getCharset()->getStringLength($this->string);
		}
		return $this->length;
	}

	/**
	 * This method returns true, when the given string is inside the string.
	 *
	 * @param string | Customweb_Core_String $string
	 * @return boolean
	 */
	public function contains($string){
		if (is_object($string) && $string instanceof Customweb_Core_String) {
			$string = $string->convertTo($this->getCharset());
		}
		$pos = $this->getCharset()->getStringPosition($this->string, (string) $string);
		if ($pos === false) {
			return false;
		}
		else {
			return true;
		}
	}

	/**
	 * Returns true, when the given string equals this string.
	 *
	 * @param string | Customweb_Core_String $string
	 * @return boolean
	 */
	public function equals($string){
		if (is_object($string) && $string instanceof Customweb_Core_String) {
			$string = $string->convertTo($this->getCharset());
		}
		return $this->string === (string) $string;
	}

	/**
	 * Returns true, when the given string equals this string.
	 * The upper and
	 * lower case chars.
	 *
	 * @param string | Customweb_Core_String $string
	 * @return boolean
	 */
	public function equalsIgnoreCase($string){
		if (is_object($string) && $string instanceof Customweb_Core_String) {
			$string = $string->convertTo($this->getCharset());
		}
		$lower1 = $this->getCharset()->toLowerCase($this->string);
		$lower2 = $this->getCharset()->toLowerCase((string) $string);
		if ($lower1 === $lower2) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns true, when this string starts with the given string.
	 *
	 * @param string | Customweb_Core_String $string
	 * @return boolean
	 */
	public function startsWith($string){
		if (is_object($string) && $string instanceof Customweb_Core_String) {
			$string = $string->convertTo($this->getCharset());
		}
		$pos = $this->getCharset()->getStringPosition($this->string, (string) $string);
		if ($pos === 0) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns true, when this string ends with the given string.
	 *
	 * @param string | Customweb_Core_String $string
	 * @return boolean
	 */
	public function endsWith($string){
		if (is_object($string) && $string instanceof Customweb_Core_String) {
			$string = $string->convertTo($this->getCharset());
		}
		$pos = $this->getCharset()->getStringPosition($this->string, (string) $string);
		if ($pos === $this->getLength()) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns the char at the given index.
	 *
	 * @param int $index
	 * @return string A single char
	 */
	public function charAt($index){
		return $this->getCharset()->getCharAt($this->string, (int) $index);
	}

	/**
	 * Returns true, when the string contains no char.
	 *
	 * @return boolean
	 */
	public function isEmpty(){
		return $this->string === '';
	}

	/**
	 * Returns true, when the string contains no visible char.
	 *
	 * @return boolean
	 */
	public function isBlank(){
		return ($this->trim()->string === '');
	}

	/**
	 * Returns the string in upper case.
	 *
	 * @return Customweb_Core_String
	 */
	public function toUpperCase(){
		return new Customweb_Core_String($this->getCharset()->toUpperCase($this->string), $this->getCharset(), true);
	}

	/**
	 * Returns the string in lower case.
	 *
	 * @return Customweb_Core_String
	 */
	public function toLowerCase(){
		return new Customweb_Core_String($this->getCharset()->toLowerCase($this->string), $this->getCharset(), true);
	}

	/**
	 * Removes the given chars from the start and end of the string.
	 *
	 * @param string $chars (Optional) A list of chars, default all white spaces.
	 * @return Customweb_Core_String
	 */
	public function trim($chars = ''){
		$string = $this->getCharset()->trimEnd($this->trimStart($chars), $chars);
		return new Customweb_Core_String($string, $this->getCharset(), true);
	}

	/**
	 * Removes the given chars from the start of the string.
	 *
	 * @param string $chars (Optional) A list of chars, default all white spaces.
	 * @return Customweb_Core_String
	 */
	public function trimStart($chars = ''){
		return new Customweb_Core_String($this->getCharset()->trimStart($chars), $this->getCharset(), true);
	}

	/**
	 * Removes the given chars from teh end of the string.
	 *
	 * @param string $chars (Optional) A list of chars, default all white spaces.
	 * @return Customweb_Core_String
	 */
	public function trimEnd($chars = ''){
		return new Customweb_Core_String($this->getCharset()->trimEnd($chars), $this->getCharset(), true);
	}

	/**
	 * Replace all occurrences of the search string with the replacement.
	 *
	 * @param string | Customweb_Core_String $search
	 * @param string | Customweb_Core_String $replaceWith
	 * @return Customweb_Core_String
	 */
	public function replace($search, $replaceWith){
		// str_replace seems to be multi byte safe. Hence we use it directly.
		return new Customweb_Core_String(str_replace((string) $search, (string) $replaceWith, (string) $this->string), $this->getCharset(), true);
	}

	/**
	 * Returns the substring of the given string.
	 * In case no length is provided,
	 * the length is extended until the end of the string.
	 *
	 * @param number $startIndex The start index.
	 * @param number $length (Optional) The length from the start index.
	 * @return Customweb_Core_String
	 */
	public function substring($startIndex, $length = 0){
		return new Customweb_Core_String($this->getCharset()->getSubstring($this->string, $startIndex, $length), $this->getCharset(), true);
	}

	/**
	 * Convert this string into a native PHP string.
	 *
	 * @return string
	 */
	public function __toString(){
		return $this->string;
	}

	/**
	 * Convert this string into a native PHP string.
	 *
	 * @return string
	 */
	public function toString(){
		return $this->__toString();
	}

	/**
	 * This method converts the string into the given charset.
	 * See Customweb_Core_Charset for more
	 * information about the conversion.
	 *
	 * @param string | Customweb_Core_Charset $charset The target charset.
	 * @throws Customweb_Core_Exception_CastException
	 * @return Customweb_Core_String
	 */
	public function convertTo($charset){
		if (is_string($charset)) {
			$charset = Customweb_Core_Charset::forName($charset);
		}
		else if (!($charset instanceof Customweb_Core_Charset)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Core_Charset');
		}

		$string = Customweb_Core_Charset::convert($this->string, $this->getCharset(), $charset);
		return new Customweb_Core_String($string, $charset, true);
	}

	/**
	 * Format the given string with the arguments.
	 * The arguments must be a list
	 * of key / value pairs. The key is replaced with the value.
	 * The key must either start with '!' or '@'. In case it starts
	 * with an '!' the the value is not cleaned. If it starts with '@' than the
	 * value is processed with htmlentities.
	 *
	 * @param array $args
	 * @return Customweb_Core_String
	 */
	public function format(array $args){
		$cleanedArgs = array();
		$string = $this->string;
		foreach ($args as $key => $value) {

			if (!is_string($value)) {
				if (is_object($value)) {
					$value = (string) $value;
				}
				else if(is_int($value)){
					$value = (string) $value;
				}
				else {
					throw new Exception("Invalid type of argument. The arguments for format must be a list of strings.");
				}
			}

			switch ($key[0]) {
				case '!':
					$cleanedArgs[$key] = $value;
					break;

				case '@':
					$cleanedArgs[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
					break;
			}
			$string = str_replace($key, $cleanedArgs[$key], $string);
		}
		return new Customweb_Core_String($string, $this->getCharset(), true);
	}

	/**
	 * Returns the position of the first occurrence of the specified string.
	 *
	 * @param string | Customweb_Core_String $string
	 * @return int
	 */
	public function indexOf($string){
		if (is_object($string) && $string instanceof Customweb_Core_String) {
			$string = $string->convertTo($this->getCharset());
		}
		return $this->getCharset()->getStringPosition($this->string, (string) $string);
	}

	/**
	 * Returns the position of the first occurrence of the specified string by ignoring the case.
	 *
	 * @param string | Customweb_Core_String $string
	 * @return int
	 */
	public function indexOfIgnoreCase($string){
		if (is_object($string) && $string instanceof Customweb_Core_String) {
			$string = $string->convertTo($this->getCharset())->toLowerCase();
		}
		else {
			$string = self::_((string) $string, $this->getCharset(), true)->toLowerCase();
		}
		return $this->getCharset()->getStringPosition($this->toLowerCase()->string, (string) $string);
	}

	/**
	 * Returns the position of the last occurrence of the specified string.
	 *
	 * @param string | Customweb_Core_String $string
	 * @return number
	 */
	public function lastIndexOf($string){
		if (is_object($string) && $string instanceof Customweb_Core_String) {
			$string = $string->convertTo($this->getCharset());
		}
		return $this->getCharset()->getLastStringPosition($this->string, (string) $string);
	}

	/**
	 * Returns the position of the last occurrence of the specified string by ignoring the case.
	 *
	 * @param string | Customweb_Core_String $string
	 * @return number
	 */
	public function lastIndexOfIgnoreCase($string){
		if (is_object($string) && $string instanceof Customweb_Core_String) {
			$string = $string->convertTo($this->getCharset())->toLowerCase();
		}
		else {
			$string = self::_((string) $string, $this->getCharset(), true)->toLowerCase();
		}
		return $this->getCharset()->getLastStringPosition($this->toLowerCase()->string, (string) $string);
	}

	/**
	 * Returns true, when the given pattern matches the current string.
	 * For other arguments see
	 * preg_match.
	 *
	 * @param string $pattern
	 * @param array $matches
	 * @param number $flags
	 * @param number $offset
	 * @return boolean
	 */
	public function match($pattern, array &$matches = null, $flags = 0, $offset = 0){
		if (is_object($pattern) && $pattern instanceof Customweb_Core_String) {
			$pattern = $pattern->convertTo($this->getCharset());
		}
		return $this->getCharset()->match($this->string, (string) $pattern, $matches, $flags, $offset);
	}

	/**
	 * Match the given pattern against the string and return the matches.
	 * For the flags see preg_match_all.
	 *
	 * @param string $pattern
	 * @param string $flags
	 * @param number $offset
	 * @return array
	 */
	public function matchAll($pattern, $flags = PREG_PATTERN_ORDER, $offset = 0){
		if (is_object($pattern) && $pattern instanceof Customweb_Core_String) {
			$pattern = $pattern->convertTo($this->getCharset());
		}
		$matches = array();
		$this->getCharset()->matchAll($this->string, (string) $pattern, $matches, $flags, $offset);
		return $matches;
	}

	/**
	 * Search in the string for the pattern and replace it with the replacement.
	 *
	 *
	 * @param string | string[] | Customweb_Core_String | Customweb_Core_String[] $pattern
	 * @param string | string[] | Customweb_Core_String | Customweb_Core_String[] $replacement
	 * @param int $limit (Optional)
	 * @param string $count (Optional)
	 * @return Customweb_Core_String
	 */
	public function replaceAll($pattern, $replacement, $limit = -1, &$count = null){
		if (is_object($pattern) && $pattern instanceof Customweb_Core_String) {
			$pattern = $pattern->convertTo($this->getCharset())->__toString();
		}
		else if (is_array($pattern)) {
			foreach ($pattern as $key => $p) {
				if (is_object($p) && $p instanceof Customweb_Core_String) {
					$pattern[$key] = (string) $p->convertTo($this->getCharset());
				}
				else {
					$pattern[$key] = (string) $p;
				}
			}
		}
		else {
			$pattern = (string) $pattern;
		}

		if (is_object($replacement) && $replacement instanceof Customweb_Core_String) {
			$replacement = $replacement->convertTo($this->getCharset())->__toString();
		}
		else if (is_array($replacement)) {
			foreach ($replacement as $key => $p) {
				if (is_object($p) && $p instanceof Customweb_Core_String) {
					$replacement[$key] = (string) $p->convertTo($this->getCharset());
				}
				else {
					$replacement[$key] = (string) $p;
				}
			}
		}
		else {
			$replacement = (string) $replacement;
		}

		$rs = $this->getCharset()->replaceAll($this->string, $pattern, $replacement, $limit, $count);
		return self::_($rs, $this->getCharset(), true);
	}

	/**
	 * This method replaces all special chars with HTML entities.
	 * This
	 * method does also consider entities which are not handled by
	 * htmlentities.
	 *
	 * This method does not replace XML special chars (quotes etc.).
	 *
	 * @return Customweb_Core_String
	 */
	public function replaceNonAsciiCharsWithEntities(){
		$string = $this;
		$utf8Charset = Customweb_Core_Charset::forName('UTF-8');
		if ($this->getCharset() != $utf8Charset) {
			$string = $this->convertTo('UTF-8');
		}
		$charArray = $utf8Charset->toArray($string->string);
		$result = '';
		for ($i = 0; $i < count($charArray); $i++) {
			$char = $charArray[$i];
			$ord = Customweb_Core_Charset_UTF8::getUnicode($char);
			if ($ord > 127) {
				$result .= '&#' . $ord . ';';
			}
			else {
				$result .= $char;
			}
		}

		return new Customweb_Core_String($result, $utf8Charset);
	}

	/**
	 * Returns true, when the current string contains any multi byte chars.
	 *
	 * @return boolean
	 */
	public function containsMultiByteChars(){
		return strlen($this->string) !== $this->getLength();
	}

	public function current(){
		return $this->charAt($this->index);
	}

	public function next(){
		++$this->index;
	}

	public function key(){
		return $this->index;
	}

	public function valid(){
		return $this->getLength() > $this->index;
	}

	public function rewind(){
		$this->index = 0;
	}

	public function offsetExists($offset){
		return ($offset >= 0 && $offset < $this->getLength());
	}

	public function offsetGet($offset){
		return $this->charAt($offset);
	}

	public function offsetSet($offset, $value){
		throw new Customweb_Core_Exception_BadMethodCallException();
	}

	public function offsetUnset($offset){
		throw new Customweb_Core_Exception_BadMethodCallException();
	}

	public function count(){
		return $this->getLength();
	}
}