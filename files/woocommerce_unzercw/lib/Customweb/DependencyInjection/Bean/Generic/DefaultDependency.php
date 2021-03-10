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

require_once 'Customweb/DependencyInjection/Bean/Generic/IDependency.php';



class Customweb_DependencyInjection_Bean_Generic_DefaultDependency implements Customweb_DependencyInjection_Bean_Generic_IDependency {
	
	private $accessMethodName;
	private $injects = array();
	
	public function __construct($accessMethodName, array $injects) {
		$this->accessMethodName = $accessMethodName;
		$this->injects = $injects;
	}
	
	public function getAccessMethodName() {
		return $this->accessMethodName;
	}

	public function getInjects() {
		return $this->injects;
	}

	public function getInstanceByInject(Customweb_DependencyInjection_IContainer $container, $inject) {
		return $container->getBean($inject);
	}

}