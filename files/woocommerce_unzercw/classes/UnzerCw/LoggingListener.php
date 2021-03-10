<?php
/**
 *  * You are allowed to use this API in your web application.
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
require_once 'Customweb/Core/Logger/IListener.php';
require_once 'UnzerCw/ConfigurationAdapter.php';
require_once 'Customweb/Core/ILogger.php';


/**
 * Logging listener using the WC_Logger
 */
class UnzerCw_LoggingListener implements Customweb_Core_Logger_IListener {
	
	private static $logger;
	
	public function addLogEntry($loggerName, $level, $message, Exception $e = null, $object = null){
		if(!$this->isLevelActive($level)){
			return;
		}
		
		if (self::$logger == null) {
			self::$logger = new WC_Logger();
		}

		$content = '[' . $level . '] ' . $loggerName . ': ' . $message;

		if ($e !== null) {
			$content .= "\n";
			$content .= $e->getMessage();
			$content .= "\n";
			$content .= $e->getTraceAsString();
		}

		if ($object !== null) {
			ob_start();
			var_dump($object);
			$content .= "\n";
			$content .= ob_get_contents();
			ob_end_clean();
		}

		self::$logger->add('UnzerCw', $content);
	}

	private function isLevelActive($level){
		switch (UnzerCw_ConfigurationAdapter::getLoggingLevel()) {
			case 'debug':
				return true;
			case 'info':
				if ($level == Customweb_Core_ILogger::LEVEL_DEBUG) {
					return false;
				}
				return true;
			case 'error':
				if ($level == Customweb_Core_ILogger::LEVEL_ERROR) {
					return true;
				}
				return false;
			default:
				return false;
		}
	}

}