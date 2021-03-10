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
 * This util to handle strings.
 * 
 * @author Thomas Hunziker
 *
 */
final class Customweb_Util_String {
	
	private function __construct() {}
	
	
	/**
	 * This method retrieves a substring of a UTF-8 string. The regular substr
	 * method does not support UTF-8.
	 *
	 * @param string $string The original string
	 * @param int $start The start char index.
	 * @param int $end [optional] The end char index. If not set the length of the string is used.
	 * @return string The resulting new string.
	 */
	public static function substrUtf8($string, $start, $end = NULL) {
		if ($end == NULL) {
			return utf8_encode(substr(utf8_decode($string), $start));
		}
		else {
			return utf8_encode(substr(utf8_decode($string), $start, $end));
		}
	}
	
	/**
	 * This methdo cuts of the start of a string, so the string is not longer as the given max
	 * length.
	 * 
	 * @param string $string
	 * @param int $maxLength
	 */
	public static function cutStartOff($string, $maxLength) {
		if (strlen($string) > $maxLength) {
			$diff = strlen($string) - $maxLength;
			return self::substrUtf8($string, $diff, $maxLength);
		}
		else {
			return $string;
		}
	}
	
	/**
	 * Format string.
	 * 
	 * @param string $string
	 * @param array $args
	 */
	public static function formatString($string, $args) {
		$cleanedArgs = array();
		if (is_array($args)) {
			foreach ($args as $key => $value) {
				switch ($key[0]) {
					case '!':
						$cleanedArgs[$key] = $value;
						break;
			
					case '@':
						$cleanedArgs[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
						break;
			
				}
			}
		}
	
		return strtr($string, $cleanedArgs);
	}
	
}