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

require_once 'Customweb/DependencyInjection/Bean/IProvider.php';
require_once 'Customweb/Annotation/Scanner.php';
require_once 'Customweb/DependencyInjection/Bean/Provider/Annotation/Util.php';


/**
 * This class scans the include path and find all classes annotated with '@Bean'. Only the 
 * indicated packages are scanned.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_DependencyInjection_Bean_Provider_Annotation implements  Customweb_DependencyInjection_Bean_IProvider {
	
	private $packages = array();
	private $beans = array();
	
	public function __construct(array $packages) {
		$this->packages = $packages;
		$this->scan();
	}
	
	final protected function scan() {
		$scanner = new Customweb_Annotation_Scanner();
		$annotations = $scanner->find('Customweb_DependencyInjection_Bean_Provider_Annotation_Bean', $this->packages);
		
		foreach ($annotations as $className => $annotationInstance) {
			if (empty($annotationInstance->beanId)) {
				$annotationInstance->beanId = $className;
			}
			$this->beans[] = Customweb_DependencyInjection_Bean_Provider_Annotation_Util::createBeanInstance($annotationInstance->beanId, $className);
		}
	}
	
	
	
	public function getBeans() {
		return $this->beans;
	}

}