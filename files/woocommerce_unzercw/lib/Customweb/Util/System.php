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
 * @author hunziker
 * @deprecated Use instead Customweb_Core_Util_System
 */
class Customweb_Util_System {

	private function __construct() {

	}

	public static function getMaxExecutionTime() {
		$maxExecutionTime = ini_get('max_execution_time');

		// Returns the default value, in case the ini_get fails.
		if ($maxExecutionTime === null || empty($maxExecutionTime)) {
			return 30;
		}
		else {
			return intval($maxExecutionTime);
		}
	}

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

}