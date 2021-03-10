<?php 

require_once 'Customweb/Observer/IListenerRegistry.php';
require_once 'Customweb/Annotation/Scanner.php';


class Customweb_Observer_ListenerAnnotationRegistry implements Customweb_Observer_IListenerRegistry
{	
	private $listeners = array();
	
	public function registerListener($eventName, $callback, $priority = self::MIDDLE_PRIORITY)
	{
		throw new Exception('Not supported: Listeners are registers via annotations.');
	}
	
	public function getListeners($eventName)
	{
		if (!isset($this->listeners[$eventName])) {
			$listeners = array();
			$scanner = new Customweb_Annotation_Scanner();
			$annotations = $scanner->find('Customweb_Observer_Annotation_EventListener');
			foreach ($annotations as $name => $annotation) {
				if($annotation->eventName == $eventName) {
					$listenerClass = substr($name, 0, strpos($name, '::'));
					$listenerMethod = substr($name, strlen($listenerClass)+2);
					$listeners[$annotation->priority][] = array($listenerClass, $listenerMethod);
				}
			}
			
			ksort($listeners);
			
			$rs = array();
			foreach ($listeners as $listenerGroup) {
				foreach ($listenerGroup as $listener) {
					$rs[] = $listener;
				}
			}
			
			$this->listeners[$eventName] = $rs;
		}
		return $this->listeners[$eventName];
	}
}