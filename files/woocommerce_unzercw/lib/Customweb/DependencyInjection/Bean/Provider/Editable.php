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
require_once 'Customweb/DependencyInjection/Bean/Simple.php';
require_once 'Customweb/DependencyInjection/Bean/Object.php';


class Customweb_DependencyInjection_Bean_Provider_Editable implements Customweb_DependencyInjection_Bean_IProvider {
	
	/**
	 * @var Customweb_DependencyInjection_IBean[]
	 */
	private $beans;
	
	public function __construct(Customweb_DependencyInjection_Bean_IProvider $provider) {
		$this->beans = $provider->getBeans();
	}
	
	public function getBeans() {
		return $this->beans;
	}
	
	/**
	 * Adds a bean definition to the provider.
	 * 
	 * @param Customweb_DependencyInjection_IBean $bean
	 * @return Customweb_DependencyInjection_Bean_Provider_Editable
	 */
	public function addBean(Customweb_DependencyInjection_IBean $bean) {
		$this->beans[] = $bean;
		return $this;
	}
	
	/**
	 * Add directly an object or a scalar value to the container.
	 * 
	 * @param string $id
	 * @param string $value
	 * @return Customweb_DependencyInjection_Bean_Provider_Editable
	 */
	public function add($id, $value) {
		$this->addBean(new Customweb_DependencyInjection_Bean_Simple($id, $value));
		return $this;
	}
	
	/**
	 * Adds an object to the container without an explicit bean id. The bean
	 * id is determine by the class.
	 * 
	 * @param object $object
	 * @return Customweb_DependencyInjection_Bean_Provider_Editable
	 */
	public function addObject($object) {
		$this->addBean(new Customweb_DependencyInjection_Bean_Object($object));
		return $this;
	}

}