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
 * This util class provides some functions to handle the translations process.
 * 
 * @author Thomas Hunziker
 */
final class Customweb_I18n_Util {
	
	private function __construct() {
		
	}
	
	/**
	 * This method cleans up the language key.
	 * 
	 * @return $string Cleaned up string
	 */
	public static function cleanLanguageKey($string) {
		$string = str_replace("\n", " ", $string);
		$string = preg_replace("/\t++/", " ", $string);
		$string = preg_replace("/[^a-zA-Z0-9_ ]*/", "", $string);
		$string = preg_replace("/( +)/", " ", $string);
		$string = trim($string);
		return $string;
	}
	
	
}