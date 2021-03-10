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
 * This util provides function to manipulate strings, that are not available in PHP 5.2
 *
 * @author Thomas Hunziker
 */
final class Customweb_Core_Util_String {

	private function __construct() {
	}

	public static function ucFirst($string) {
		if(empty($string)) {
			return $string;
		}
		$string[0] = strtoupper($string[0]);
		return (string) $string;
	}
	
	
	public static function lcFirst($string) {
		if(empty($string)) {
			return $string;
		}
		$string[0] = strtolower($string[0]);
		return (string) $string;
	}
	
}