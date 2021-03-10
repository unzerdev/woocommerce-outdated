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
final class Customweb_Core_Util_System {

	private static $defaultTimeZone = null;
	private static $defaultDateFormat = null;
	
	private function __construct() {

	}
	
	public static function getDefaultTimeZone() {
		if (self::$defaultTimeZone === null) {
			return date_default_timezone_get();
		}
		else {
			return self::$defaultTimeZone;
		}
	}
	
	public static function setDefaultTimeZone($timeZone) {
		self::$defaultTimeZone = $timeZone;
	}

	public static function getDefaultDateFormat() {
		// TODO: Implement a better default value
		if (self::$defaultDateFormat === null) {
			return 'Y/m/d';
		}
		else {
			return self::$defaultDateFormat;
		}
	}

	public static function getDefaultDateTimeFormat() {
		return self::getDefaultDateFormat() . ' G:i:s';
	}
	
	public static function setDefaultDateFormat($format) {
		self::$defaultDateFormat = $format;
	}
	
	/**
	 * 
	 * @return string
	 */
	public static function getTemporaryDirPath() {
		return rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
	}

	/**
	 * Returns the IP address of the client connected to the
	 * server. In case a proxy is used the method tries to find
	 * the correct IP address.
	 * 
	 * @throws Exception
	 * @deprecated Use instead always the provided request object
	 * @return string
	 */
	public static function getClientIPAddress(){
		return Customweb_Core_Http_ContextRequest::getClientIPAddress();
	}

	/**
	 * Returns the max execution time of the current request.
	 * 
	 * @return number
	 */
	public static function getMaxExecutionTime() {
		$maxExecutionTime = ini_get('max_execution_time');

		// Returns the default value, in case the ini_get fails.
		if ($maxExecutionTime === null || empty($maxExecutionTime) || $maxExecutionTime < 0) {
			return 30;
		}
		else {
			return intval($maxExecutionTime);
		}
	}
	
	/**
	 * Returns the unix timestamp of the script execution start time.
	 * 
	 * @return number
	 */
	public static function getScriptStartTime() {
		// TODO: Add here a better approach to get the time.
		if (isset($_SERVER['REQUEST_TIME'])) {
			return $_SERVER['REQUEST_TIME'];
		}
		else {
			return time();
		}
	}
	
	/**
	 * This method returns the maximal script execution time.
	 * 
	 * @return number Unix time stamp, when the script will be killed.
	 */
	public static function getScriptExecutionEndTime() {
		return self::getScriptStartTime() + self::getMaxExecutionTime();
	}

	/**
	 * This method returns the position at which the compiler halts with compilation.
	 * 
	 * @param string $file Path to the file.
	 * @throws Exception
	 * @return number
	 */
	public static function getCompilerHaltOffset($file) {
		if (defined('__COMPILER_HALT_OFFSET__')) {
			return __COMPILER_HALT_OFFSET__;
		}

		$handle = fopen($file, 'r');
		$buffer = '';
		while (false !== ($char = fgetc($handle))) {
			$buffer .= $char;
			if ($buffer == '__halt_compiler();') {
				return ftell($handle);
			} elseif (strpos('__halt_compiler();', $buffer) !== 0) {
				$buffer = '';
			}
		}

		throw new Exception('__halt_compiler() not found.');
	}
	
	
	/**
	 * Returns the URL of the current request.
	 *
	 * @return string
	 * @deprecated Use instead the provided request object.
	 */
	public static function getRequestUrl() {
		$protocol = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
			$protocol = 'https';
		}
	
		$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
		return $protocol . "://" . self::getRequestHost() . $port . $_SERVER['REQUEST_URI'];
	}
	
	/**
	 * Returns the host of the current request.
	 *
	 * @return string
	 * @deprecated Use instead the provided request object.
	 */
	public static function getRequestHost() {
		if (isset($_SERVER['HTTP_X_FORWARDED_HOST']) && !empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
			$host = $_SERVER['HTTP_X_FORWARDED_HOST'];
			$elements = explode(',', $host);
			$host = trim(end($elements));
		}
		else {
			if (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST'])) {
				$host = $_SERVER['HTTP_HOST'];
			}
			else {
				if (isset($_SERVER['SERVER_NAME']) && !empty($_SERVER['SERVER_NAME'])) {
					$host = $_SERVER['SERVER_NAME'];
				}
				else {
					if (isset($_SERVER['SERVER_ADDR']) && !empty($_SERVER['SERVER_ADDR'])) {
						$host = $_SERVER['SERVER_ADDR'];
					}
					else {
						$host = '';
					}
				}
			}
		}
	
		// Remove port number from host
		$host = preg_replace('/:\d+$/', '', $host);
	
		return trim($host);
	}
	
	/**
	 * Clears the output buffer. Prevents any error reporting.
	 */
	public static function clearOutputBuffer() {
		set_error_handler(array('Customweb_Core_Util_System', 'voidErrors'));
		ob_end_clean();
		restore_error_handler();
	}
	
	public static function voidErrors() {
		
	}

}