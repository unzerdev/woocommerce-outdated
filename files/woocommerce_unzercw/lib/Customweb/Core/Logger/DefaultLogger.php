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

require_once 'Customweb/Core/ILogger.php';
require_once 'Customweb/Core/Logger/Factory.php';


/**
 * This is the default implementation of {@link Customweb_Core_ILogger}.
 */
class Customweb_Core_Logger_DefaultLogger implements Customweb_Core_ILogger {
	private $name;
	public function __construct($name) {
		$this->name = $name;
	}
	public function log($level, $message, Exception $e = null, $object = null) {
		foreach ( Customweb_Core_Logger_Factory::getListeners () as $listener ) {
			try {
				$listener->addLogEntry ( $this->name, $level, $message, $e, $object);
			} catch ( Exception $e ) {
				// We ignore any exception to avoid failing only because of the log writting.
			}
		}
	}
	public function logDebug($message, $object= null) {
		$this->log ( self::LEVEL_DEBUG, $message, null, $object);
	}
	public function logInfo($message, $object= null) {
		$this->log ( self::LEVEL_INFO, $message, null, $object);
	}
	public function logError($message, $object= null) {
		$this->log ( self::LEVEL_ERROR, $message, null, $object);
	}
	public function logException(Exception $e, $object = null) {
		$this->log ( self::LEVEL_ERROR, $e->getMessage (), $e, $object);
	}
}