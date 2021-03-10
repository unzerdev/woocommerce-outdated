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

require_once 'Customweb/Observer/IListenerRegistry.php';


/**
 * This is a default implementation of Customweb_Observer_IListenerRegistry. 
 * 
 * 
 * @author Thomas Hunziker
 */
class Customweb_Observer_ListenerRegistry implements Customweb_Observer_IListenerRegistry {
	
	private $listeners = array();
	
	public function registerListener($eventName, $callback, $priority = self::MIDDLE_PRIORITY) {
		$priority = intval($priority);
		$key = strtolower($eventName);
		if (!is_callable($callback)) {
			throw new Exception("The given callback is not a callback.");
		}
		
		if (!isset($this->listeners[$key][$priority])) {
			$this->listeners[$key][$priority] = array();
		}
		
		$this->listeners[$key][$priority][] = $callback;
	}

	public function getListeners($eventName) {
		$key = strtolower($eventName);
		if (!isset($this->listeners[$key])) {
			return array();
		}
		$listeners = $this->listeners[$key];
		ksort($listeners);
		
		$rs = array();
		foreach ($listeners as $listenerGroup) {
			foreach ($listenerGroup as $listener) {
				$rs[] = $listener;
			}
		}
		
		return $rs;
	}
	
}