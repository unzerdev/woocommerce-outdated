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


class Customweb_Mvc_Controller_Exception_ControllerNotFoundException extends Exception {
	
	private $controllerName = null;
	
	public function __construct($controllerName) {
		$this->controllerName = $controllerName;
		parent::__construct(Customweb_Core_String::_("No controller found for controller name '@controllerName'.")->format(array('@controllerName' => $controllerName)));
	}
	
	public function getControllerName() {
		return $this->controllerName;
	}
}