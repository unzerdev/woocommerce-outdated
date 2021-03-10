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
 * The listener registry can be used to register a listener
 * for a certain event. The dispatcher then calls the given
 * callback, when the event is triggered.
 * 
 * The order of calling the callbacks can be denoted by indicating 
 * the priority. May be the default priority flags should be used. However
 * also custom priorities can be used to resolve order issues.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Observer_IListenerRegistry {
	
	const LOW_PRIORITY = 1000;
	
	const MIDDLE_PRIORITY = 0;
	
	const HIGH_PRIORITY = -1000;
	
	/**
	 * This method register a listener for an event. The listener is called by 
	 * the given callback.
	 * 
	 * The calling priority is controlled by the given int number. The lower the number
	 * the higher the priority is.
	 * 
	 * @param string $eventName
	 * @param callable $callback
	 * @param int $priority
	 * @throws Exception
	 * @return void
	 */
	public function registerListener($eventName, $callback, $priority = self::MIDDLE_PRIORITY);
	
	/**
	 * This method returns a list of callbacks for the given event name. The order is already 
	 * correct for executing the callbacks.
	 * 
	 * @param string $eventName
	 * @return array
	 */
	public function getListeners($eventName);
	
	
}