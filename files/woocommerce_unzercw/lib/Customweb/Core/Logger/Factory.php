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

require_once 'Customweb/Core/Logger/DefaultLogger.php';

/**
 * This class contains all loggers and listeners. By registering
 * a listener, it will receive every message that is send by 
 * any logger.
 * 
 * @author Thomas Hunziker
 *
 */
final class Customweb_Core_Logger_Factory {
	
	private static $loggers = array();
	
	private static $listeners = array();
	
	private function __construct() {
		
	}
	
	/**
	 * @param string $name
	 * @return Customweb_Core_ILogger
	 */
	public static function getLogger($name) {
		if (!isset(self::$loggers[$name])) {
			self::$loggers[$name] = new Customweb_Core_Logger_DefaultLogger($name);
		}
		return self::$loggers[$name];
	}
	/**
	 * Registers a listener to receive logs and handle them accordingly.
	 * 
	 * @param Customweb_Core_Logger_IListener $listener
	 */
	public static function addListener(Customweb_Core_Logger_IListener $listener) {
		self::$listeners[] = $listener;
	}
	
	/**
	 * @return Customweb_Core_Logger_IListener[]
	 */
	public static function getListeners() {
		return self::$listeners;
	}
	
}