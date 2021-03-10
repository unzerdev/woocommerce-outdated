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
 * This util produces random strings.
 *
 * @author Thomas Hunziker
 * @deprecated
 *  Use instead Customweb_Core_Util_Rand
 */
final class Customweb_Util_Rand {

	private function __construct() {
	}

	private static $listOfChars = array(
		'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M',
		'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
		'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l',
		'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x',
		'y', 'z', '1', '2', '3', '4', '5', '6', '7', '8', '9'
	);

	/**
	 * This method generates a random string. The $length indicates
	 * the length of the resulting string. The $charsToExclude indicates
	 * which of the elements are not used. By default 'l', 'i' and '1' are
	 * not used.
	 *
	 * @param integer $length
	 * @param string $charsToExclude
	 * @return string Random string
	 */
	public static function getRandomString($length, $charsToExclude = 'li1' ) {
		$characters = array();
		foreach (self::$listOfChars as $char) {
			if (!strstr($charsToExclude, $char)) {
				$characters[] = $char;
			}
		}

		$numberOfCharacters = count($characters);
		$code = '';
		for ($c = 0; $c < $length; $c++) {
			$randIndex = mt_rand(0, $numberOfCharacters-1);
			$code .= $characters[$randIndex];
		}

		return $code;
	}

	public static function getUuid() {
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
			mt_rand( 0, 0x0fff ) | 0x4000,
			mt_rand( 0, 0x3fff ) | 0x8000,
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ) );
	}

}