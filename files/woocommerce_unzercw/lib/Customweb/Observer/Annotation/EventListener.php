<?php 

require_once 'Customweb/Observer/IListenerRegistry.php';
require_once 'Customweb/IAnnotation.php';


/**
 *
 * @author Thomas Hunziker
 * @Target({'Method'})
 *
 */

class Customweb_Observer_Annotation_EventListener implements Customweb_IAnnotation {
	
	public $priority = Customweb_Observer_IListenerRegistry::MIDDLE_PRIORITY;
	
	public $eventName;
	
}