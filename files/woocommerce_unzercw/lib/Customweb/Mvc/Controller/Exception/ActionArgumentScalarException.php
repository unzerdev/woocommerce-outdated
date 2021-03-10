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

require_once 'Customweb/Core/String.php';


class Customweb_Mvc_Controller_Exception_ActionArgumentScalarException extends Exception {
	
	private $methodName = null;
	
	public function __construct($methodName) {
		$this->methodName = $methodName;
		parent::__construct(Customweb_Core_String::_("The method '@method' has a sclar parameter value. This is not supported on action methods.")->format(array('@method' => $methodName)));
	}

	public function getMethodName(){
		return $this->methodName;
	}
	
	
}