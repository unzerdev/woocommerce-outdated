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

/**
 * This exception should be thrown, when a cast of an object fails. 
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Core_Exception_CastException extends Exception  {
	
	private $expectedClassName = null;
	
	public function __construct($expectedClassName) {
		parent::__construct((string)Customweb_Core_String::_("Failed to cast to type '@name'.")->format(array('@name' => $expectedClassName)));
		$this->expectedClassName = $expectedClassName;
	}
	
	/**
	 * 
	 * @return string Name of the expected class.
	 */
	public function getExpectedClassName() {
		return $this->expectedClassName;
	}
}