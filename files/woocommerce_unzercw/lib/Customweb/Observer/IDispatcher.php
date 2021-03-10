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
 * This interface defines a event dispatcher. The event dispatcher invokes
 * all listener registered for a certain event.
 * 
 * The dispatcher is used to propagate a specific event to the listeners.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Observer_IDispatcher {
	
	/**
	 * This method calls all listeners for a certain event name and with the 
	 * given $variables in the the Customweb_Observer_IEvent.
	 * 
	 * The returned Customweb_Observer_IEvent contains all changes done by the 
	 * listeners.
	 * 
	 * @param string $eventName
	 * @param array $variables
	 * @throws Exception
	 * @return Customweb_Observer_IEvent
	 */
	public function dispatch($eventName, array $variables = array());
	
}