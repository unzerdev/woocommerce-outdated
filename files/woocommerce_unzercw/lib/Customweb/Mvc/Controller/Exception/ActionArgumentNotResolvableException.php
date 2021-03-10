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


class Customweb_Mvc_Controller_Exception_ActionArgumentNotResolvableException extends Exception {
	
	private $methodName = null;
	private $type = null;
	
	public function __construct($methodName, $type) {
		$this->methodName = $methodName;
		$this->type = $type;
		parent::__construct(Customweb_Core_String::_("The parameter '@parameter' on method '@method' could not be resolved.")->format(array('@method' => $methodName, '@parameter' => $type)));
	}

	public function getMethodName(){
		return $this->methodName;
	}

	public function getType(){
		return $this->type;
	}
	
	
}