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

require_once 'Customweb/Observer/IEvent.php';


/**
 * This is an default implementation of Customweb_Observer_IEvent. 
 * Internally for storing the data an array is used. 
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Observer_Event implements Customweb_Observer_IEvent {
	
	private $variables = array();
	
	public function __construct(array $variables) {
		$this->variables = $variables;
	}
	
	public function getVariable($name) {
		if (isset($this->variables[$name])) {
			return $this->variables[$name];
		}
		else {
			return null;
		}
	}
	
	public function setVariable($name, $value) {
		$this->variables[$name] = $value;
		return $this;
	}
	
}