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

require_once 'Customweb/Observer/IDispatcher.php';
require_once 'Customweb/Observer/ListenerAnnotationRegistry.php';
require_once 'Customweb/Observer/Event.php';


/**
 * This class implements the interface Customweb_Observer_IDispatcher. This is
 * a default implementation of the dispatcher.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Observer_Dispatcher implements Customweb_Observer_IDispatcher {
	
	/**
	 * @var Customweb_Observer_IListenerRegistry
	 */
	private $listenerRegistry = null;
	
	private static $instance = null;
	
	private function __construct() {
		$this->listenerRegistry = new Customweb_Observer_ListenerAnnotationRegistry();
	}
	
	public static function getInstance() {
		if( self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;		
	}
	
	public function dispatch($eventName, array $variables = array()) {
		$event = new Customweb_Observer_Event($variables);
		
		$listeners = $this->getListenerRegistry()->getListeners($eventName);
		foreach ($listeners as $callback) {
			call_user_func_array($callback, array($event));
		}
		
		return $event;
	}
	
	/**
	 * @return Customweb_Observer_IListenerRegistry
	 */
	public function getListenerRegistry() {
		return $this->listenerRegistry;
	}
	
	public function setListenerRegistry(Customweb_Observer_IListenerRegistry $registry) {
		$this->listenerRegistry = $registry;
	}
}
