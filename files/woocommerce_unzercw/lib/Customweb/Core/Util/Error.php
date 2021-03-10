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
 * 
 * @author Thomas Hunziker
 */
final class Customweb_Core_Util_Error {
	
	private static $lastErrorMessage = null;

	public static function startErrorHandling() {
		self::$lastErrorMessage = null;
		set_error_handler( array('Customweb_Core_Util_Error', 'handleErrors' ) );
	}
	
	public static function endErrorHandling() {
		restore_error_handler();
		
		return self::$lastErrorMessage;
	}
	
	/**
	 * Method which handles errors and convert them into exceptions.
	 *
	 * @throws Exception
	 */
	public static function handleErrors($errno, $errstr, $errfile, $errline) {
		$message = $errstr;
		$endOfFunctionName = strpos($errstr, '):');
		if ($endOfFunctionName !== false) {
			$message = substr($errstr, $endOfFunctionName + 2);
		}
		self::$lastErrorMessage = trim($message);
		restore_error_handler();
		throw new ErrorException(self::$lastErrorMessage, 0, $errno, $errfile, $errline);
	}
	
	public static function deactivateErrorMessages() {
		set_error_handler(array('Customweb_Core_Util_Error', 'ignoreError'));
	}
	
	public static function activateErrorMessages() {
		restore_error_handler();
	}
	
	public static function ignoreError() {
		
	}
	
}