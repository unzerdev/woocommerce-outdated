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

require_once 'Customweb/DependencyInjection/Bean/Object.php';
require_once 'Customweb/DependencyInjection/IContainer.php';


/**
 * This implementation is a wrapper around an existing container. The container adds a layer by which
 * additional beans can be added after the initialization. The original container is not changed.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_DependencyInjection_Container_Extendable implements Customweb_DependencyInjection_IContainer {
	
	private $beans = array();
	private $beansByClasses = array();
	private $container = null;
	
	
	public function __construct(Customweb_DependencyInjection_IContainer $container) {
		$this->container = $container;
	}
	
	
	public function getBean($identifier) {
		$key = strtolower($identifier);
		if (isset($this->beans[$key])) {
			return $this->beans[$key];
		}
		else {
			return $this->container->getBean($identifier);
		}
	}
	
	public function getBeansByType($type) {
		$key = strtolower($type);
		$rs = array();
		if (isset($this->beansByClasses[$key])) {
			$rs = $this->beansByClasses[$key];
		}
		return array_merge(
			$rs,
			$this->getBeansByType($type)
		);
	}
	
	public function hasBean($identifier) {
		$key = strtolower($identifier);
		if (isset($this->beans[$key])) {
			return true;
		}
		else {
			return $this->container->hasBean($identifier);
		}
	}
	
	/**
	 * Adds the given bean to the container.
	 * 
	 * @param Customweb_DependencyInjection_IBean $bean
	 * @return Customweb_DependencyInjection_Container_Extendable
	 */
	public function addBean(Customweb_DependencyInjection_IBean $bean) {
		$instance = $bean->getInstance($this);
		$className = get_class($instance);
		$classes = $bean->getClasses();
		$beanId = strtolower($bean->getBeanId());
		
		$this->beans[$beanId] = $instance;
		
		foreach ($classes as $class) {
			$class = strtolower($class);
			if (!isset($this->beansByClasses[$class])) {
				$this->beansByClasses[$class] = array();
			}
			$this->beansByClasses[$class][] = $instance;
			$this->beans[$class] = $instance;
		}
		
		return $this;
	}
	
	/**
	 * Add the given object to the container.
	 * 
	 * @param object $object
	 * @return Customweb_DependencyInjection_Container_Extendable
	 */
	public function addObject($object) {
		$bean = new Customweb_DependencyInjection_Bean_Object($object);
		$this->addBean($bean);
		return $this;
	}
	
	/**
	 * @return Customweb_DependencyInjection_IContainer
	 */
	protected function getWrappedContainer() {
		return $this->container;
	}
	
}