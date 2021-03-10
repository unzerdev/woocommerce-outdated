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

require_once 'Customweb/Core/Charset.php';
require_once 'Customweb/Core/Exception/UnexpectedCharException.php';

abstract class Customweb_Core_Charset_TableBasedCharset extends Customweb_Core_Charset {
	
	protected abstract function getConversionTable();
	
	private $regexErrorMessage = null;
	
	private static $replacementTable = array(
		'€' => 'EUR',
		'$' => 'USD',
		'£' => 'GBP',
		'¢' => 'Cent',
		'¥' => 'JPY',
		'¡' => 'i',
		'¨' => '"',
		'«' => '"',
		'»' => '"',
		'μ' => 'mu',
		'·' => 'x',
		'¼' => '1/4',
		'½' => '1/2',
		'¾' => '3/4',
		'ö' => 'oe',
		'Ö' => 'Oe',
		'ü' => 'ue',
		'Ü' => 'Ue',
		'ä' => 'ae',
		'Ä' => 'Ae',
		'À' => 'A',
		'Á' => 'A',
		'Â' => 'A',
		'Ã' => 'A',
		'Å' => 'A',
		'Ñ' => 'N',
		'È' => 'E',
		'É' => 'E',
		'Ê' => 'E',
		'Ë' => 'E',
		'Ì' => 'I',
		'Í' => 'I',
		'Î' => 'I',
		'Ï' => 'I',
		'Ð' => 'D',
		'Ò' => 'O',
		'Ó' => 'O',
		'Ô' => 'O',
		'Õ' => 'O',
		'×' => 'x',
		'Ø' => 'O',
		'Ù' => 'U',
		'Ú' => 'U',
		'Û' => 'U',
		'ß' => 'ss',
		'é' => 'e',
		'è' => 'e',
		'à' => 'a',
		'á' => 'a',
		'â' => 'a',
		'ã' => 'a',
		'å' => 'a',
		'æ' => 'ae',
		'ç' => 'c',
		'Ç' => 'C',
		'Æ' => 'Ae',
		'ê' => 'e',
		'ë' => 'e',
		'î' => 'i',
		'ï' => 'i',
		'í' => 'i',
		'ì' => 'i',
		'ò' => 'o',
		'ó' => 'o',
		'ô' => 'o',
		'ø' => 'o',
		'ù' => 'u',
		'ú' => 'u',
		'û' => 'u',
		'ý' => 'y',
		'ｚ' => 'z',
		'ｙ' => 'y',
		'ｘ' => 'x',
		'ｗ' => 'w',
		'ｖ' => 'v',
		'ｕ' => 'u',
		'ｔ' => 't',
		'ｓ' => 's',
		'ｒ' => 'r',
		'ｑ' => 'q',
		'ｐ' => 'p',
		'ｏ' => 'o',
		'ｎ' => 'n',
		'ñ' => 'n',
		'ｍ' => 'm',
		'ｌ' => 'l',
		'ｋ' => 'k',
		'ｊ' => 'j',
		'ｉ' => 'i',
		'ｈ' => 'h',
		'ｇ' => 'g',
		'ｆ' => 'f',
		'ｅ' => 'e',
		'ｄ' => 'd',
		'ｃ' => 'c',
		'ｂ' => 'b',
		'ａ' => 'a',
		'ǳ' => 'dz',
		'ǌ' => 'nj',
		'ǉ' => 'lj',
		'ſ' => 's',
		'œ' => 'oe',
		'ĳ' => 'ij',
		'æ' => 'ae',
		'µ' => 'u',
		'Ｚ' => 'Z',
		'Ｙ' => 'Y',
		'Ｘ' => 'X',
		'Ｗ' => 'W',
		'Ｖ' => 'V',
		'Ｕ' => 'U',
		'Ｔ' => 'T',
		'Ｓ' => 'S',
		'Ｒ' => 'R',
		'Ｑ' => 'Q',
		'Ｐ' => 'P',
		'Ｏ' => 'O',
		'Ｎ' => 'N',
		'Ｍ' => 'M',
		'Ｌ' => 'L',
		'Ｋ' => 'K',
		'Ｊ' => 'J',
		'Ｉ' => 'I',
		'Ｈ' => 'H',
		'Ｇ' => 'G',
		'Ｆ' => 'F',
		'Ｅ' => 'E',
		'Ｄ' => 'D',
		'Ｃ' => 'C',
		'Ｂ' => 'B',
		'Ａ' => 'A',
		'ǲ' => 'Dz',
		'ǋ' => 'Nj',
		'ǈ' => 'Lj',
		'Œ' => 'OE',
		'Ĳ' => 'IJ',
		'Æ' => 'AE',
		'دج' => 'DA',
	);

	/**
	 * Returns a map of UTF-8 chars as key and a replacement of it in the 
	 * resulting charset. This table is used to replace chars which 
	 * are not translatable into the target charset.
	 * 
	 * @return array
	 */
	protected function getReplacementTable() {
		return self::$replacementTable; 
	}
		
	protected function getNoChangesRanges() {
		return array();
	}

	public function getStringLength($string) {
		if (is_array($string)) {
			return count($string);
		}
		else {
			return strlen($string);
		}
	}
	
	public function getCharAt($string, $index){
		if (is_array($string)) {
			if (count($string) <= $index) {
				throw new Customweb_Core_Exception_IndexOutOfBoundException();
			}
			return $string[$index];
		}
		else {
			if (strlen($string) <= $index) {
				throw new Customweb_Core_Exception_IndexOutOfBoundException();
			}
			return $string[$index];
		}
	}
	
	public function getSubstring($string, $start, $length){
		if (is_array($string)) {
			return implode( array_slice( $string , $start , $length ) );
		}
		else {
			return substr($string, $start, $length);
		}
	}
	
	public function getStringPosition($stringSearchIn, $needle, $offset = 0){
		if (is_array($stringSearchIn)) {
			$stringSearchIn = implode($stringSearchIn);
		}
		return strpos($stringSearchIn, $needle, $offset === 0 ? null : $offset);
	}
	
	public function toUpperCase($string){
		if (is_array($string)) {
			$rs = array();
			foreach ($string as $char) {
				$rs[] = strtoupper($char);
			}
			return $rs;
		}
		else {
			return strtoupper($string);
		}
	}
	
	public function toLowerCase($string){
		if (is_array($string)) {
			$rs = array();
			foreach ($string as $char) {
				$rs[] = strtolower($char);
			}
			return $rs;
		}
		else {
			return strtolower($string);
		}
	}
	
	public function toArray($string) {
		if(empty($string)){
			return array();
		}
		else if (is_array($string)) {
			return $string;
		}
		else {
			return str_split($string);
		}
	}
	
	public function trimStart($string, $chars = '') {
		return ltrim($string, $chars);
	}
	
	public function trimEnd($string, $chars = '') {
		return rtrim($string, $chars);
	}
	
	public function getLastStringPosition($stringSearchIn, $needle, $offset = 0) {
		if (is_array($stringSearchIn)) {
			$stringSearchIn = implode($stringSearchIn);
		}
		return strrpos($stringSearchIn, $needle, $offset === 0 ? null : $offset);
	}
	
	
	protected function toCharset($string) {
		$table = array_flip($this->getConversionTable());
		$ranges = $this->getNoChangesRanges();
		if (is_array($string)) {
			$rs = array();
			foreach ($string as $char) {
				$rs[] = $this->converCharFromUTF8($char, $table, $ranges);
			}
			return $rs;
		}
		else {
			$charset = self::forName('UTF-8');
			$chars = $charset->toArray($string);
			$buf = '';
			foreach ($chars as $char) {
				$buf .= $this->converCharFromUTF8($char, $table, $ranges);
			}
			return $buf;
		}
	}
	
	protected function toUTF8($string) {
		$table = $this->getConversionTable();
		$ranges = $this->getNoChangesRanges();
		if (is_array($string)) {
			$rs = array();
			foreach ($string as $char) {
				$rs[] = $this->converCharToUTF8($char, $table, $ranges);
			}
			return $rs;
		}
		else {
			$max = strlen($string);
			$buf = "";
			for($i = 0; $i < $max; $i ++) {
				$buf .= $this->converCharToUTF8($string[$i], $table, $ranges);
			}
		}
		
		return $buf;
	}

	private function converCharToUTF8($char, array $table, array $ranges) {
		if (isset($table[$char])) {
			return $table[$char];
		}
		else {
			$ord = ord($char);
			foreach ($ranges as $range) {
				if ($range['start'] <= $ord && $range['end'] >= $ord) {
					return $char;
				}
			}
			if (self::getConversionBehavior() === self::CONVERSION_BEHAVIOR_EXCEPTION) {
				throw new Customweb_Core_Exception_UnexpectedCharException($ord, $char);
			}
			else {
				return '';
			}			
		}
	}

	private function converCharFromUTF8($char, array $table, array $ranges) {
		if (isset($table[$char])) {
			return $table[$char];
		}
		else {
			$ord = ord($char);
			foreach ($ranges as $range) {
				if ($range['start'] <= $ord && $range['end'] >= $ord) {
					return $char;
				}
			}
			if (self::getConversionBehavior() === self::CONVERSION_BEHAVIOR_EXCEPTION) {
				throw new Customweb_Core_Exception_UnexpectedCharException($ord, $char);
			}
			else if (self::getConversionBehavior() === self::CONVERSION_BEHAVIOR_REMOVE){
				return '';
			}
			else {
				$table = $this->getReplacementTable();
				if (isset($table[$char])) {
					return $table[$char];
				}
				else {
					return '';
				}
			}
		}
	}
	
	
	
}