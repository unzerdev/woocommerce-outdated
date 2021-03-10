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



final class Customweb_Core_Util_Reflection {
	
	
	private function __construct() {
		
	}
	
	/**
	 * Returns the type of the parameter. In case the parameter has no type (e.g. primitive) the
	 * method returns null. 
	 * 
	 * @param ReflectionParameter $param
	 * @return string
	 */
	public static function getParameterType(ReflectionParameter $param) {
		$matches = array();
		preg_match('/\[\s\<\w+?>\s([\w]+)/s', $param->__toString(), $matches);
		if (isset($matches[1])) {
			return $matches[1];
		}
		else {
			return null;
		}
	}

}