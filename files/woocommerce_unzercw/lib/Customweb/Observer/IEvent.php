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
 * This interface defines the event object propagated to all listeners. The listeners
 * may change some variables or replace them.
 * 
 * The Dispatcher creates the event and propagate it to all the listeners and returns 
 * the event object back to the event triggerer.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Observer_IEvent {
	
	/**
	 * Returns the value of the given variable.
	 * 
	 * @param string $name
	 * @return mixed
	 */
	public function getVariable($name);
	
	/**
	 * This method sets a given variable.
	 * 
	 * @param string $name
	 * @param mixed $value
	 * @return Customweb_Observer_IEvent
	 */
	public function setVariable($name, $value);
	
}