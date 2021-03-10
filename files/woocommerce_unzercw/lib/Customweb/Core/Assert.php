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
 * Util methods to check variable content.
 * 
 * @author Thomas Hunziker
 *
 */
final class Customweb_Core_Assert {
	
	private function __construct() {
		
	}
	
	/**
	 * Checks that the given array has at least one element in it.
	 * 
	 * @param array $array
	 * @param string $message
	 * @throws Exception
	 */
	public static function hasSize(array $array, $message = false) {
		if (count($array) <= 0) {
			if ($message === false) {
				$message = 'Argument needs to have at least one element in the array.';
			}
			throw new Exception($message);
		}
	}
	
	/**
	 * Check that the given string is not empty.
	 * 
	 * @param string $string
	 * @param string $message
	 * @throws Exception
	 */
	public static function hasLength($string, $message = false) {
		if (!is_string($string)) {
			$string = (string)$string;
		}
		if (empty($string)) {
			if ($message === false) {
				$message = 'Argument needs not to be empty.';
			}
			throw new Exception($message);
		}
	}
	
	/**
	 * Checks that the given object is not null.
	 * 
	 * @param object $object
	 * @param string $message
	 * @throws Exception
	 */
	public static function notNull($object, $message = false) {
		if ($object === null) {
			if ($message === false) {
				$message = 'Argument needs not to be NULL.';
			}
			throw new Exception($message);
		}
	}
	
}