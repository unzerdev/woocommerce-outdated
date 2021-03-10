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

require_once 'Customweb/DependencyInjection/Exception/BeanNotFoundException.php';
require_once 'Customweb/DependencyInjection/IContainer.php';
require_once 'Customweb/Core/Util/Class.php';


/**
 * 
 * 
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_DependencyInjection_Container_Abstract implements Customweb_DependencyInjection_IContainer {
	
	private $beans = array();
	
	private $beansByClasses = array();
	
	/**
	 * @var Customweb_DependencyInjection_Bean_IProvider
	 */
	private $provider = null;
	
	/**
	 * @var Customweb_DependencyInjection_IBean[]
	 */
	private $beanDefintionById = array();
	
	/**
	 * @var Customweb_DependencyInjection_IBean[]
	 */
	private $beanDefintionByClass = array();
	

	final public function hasBean($identifier) {
		if (isset($this->beans[strtolower($identifier)])) {
			return true;
		}
		else {
			$beanDefintion = $this->getBeanConfigurationByIdentifier($identifier);
			if ($beanDefintion !== null) {
				return true;
			}
			else {
				return false;
			}
		}
	}
	
	final public function getBean($identifier) {
		$key = strtolower($identifier);
		if (!isset($this->beans[$key])) {
			$beanDefintion = $this->resolveBeanDefinition($identifier);
			$instance = $this->createInstance($beanDefintion);
			$aliases = $beanDefintion->getClasses();
			$aliases[] = $identifier;
			$this->addBean($aliases, $instance);
		}
	
		return $this->beans[$key];
	}
	
	final public function getBeansByType($type) {
		$key = strtolower($type);
		if (isset($this->beansByClasses[$key])) {
			$beans = $this->beansByClasses[$key];
			
			$rs = array();
			foreach($beans as $bean) {
				if (is_object($bean)) {
					$rs[] = $bean;
				}
				else {
					$rs[]  = $this->getBean($bean);
				}
			}
			
			return $rs;
		}
		else {
			return array();
		}
	}
	
	/**
	 * This method setups based on the provider how the bean structure is.
	 * 
	 * @return void
	 */
	final protected function setupBeanDefinitions() {
		$this->beanDefintionById = array();
		$this->beanDefintionByClass = array();
		
		foreach ($this->getBeansFromProvider() as $bean) {
			$this->beanDefintionById[$bean->getBeanId()] = $bean;
			foreach ($bean->getClasses() as $class) {
				$this->beanDefintionByClass[$class] = $bean;
				
				// We add all classes to the range query index.
				$class = strtolower($class);
				if (!isset($this->beansByClasses[$class])) {
					$this->beansByClasses[$class] = array();
				}
				$this->beansByClasses[$class][] = $bean->getBeanId();
			}
		}
	}
	
	/**
	 * This method adds a given bean instance to the container. Since the instance can 
	 * have multiple identifiers, this method requires also an array of identifiers.
	 * 
	 * @param array $identifiers
	 * @param object $instance
	 * @return void
	 */
	protected function addBean(array $identifiers, $instance) {
		foreach ($identifiers as $identifier) {
			$key = strtolower($identifier);
			$this->beans[$key] = $instance;
		}
	}
	
	/**
	 * This method adds the container to the internal bean list. Hence beans
	 * can access the bean container.
	 * 
	 * @return void
	 */
	protected function addSelfToContainer() {
		$className = get_class($this);
		$classes = Customweb_Core_Util_Class::getAllTypes($className);
		$this->addBean($classes, $this);
		
		// We need to add the bean container to the range query index.
		foreach ($classes as $class) {
			$class = strtolower($class);
			if (!isset($this->beansByClasses[$class])) {
				$this->beansByClasses[$class] = array();
			}
			$this->beansByClasses[$class][] = $this;
		}
	}
	
	protected function getBeansFromProvider() {
		return $this->getProvider()->getBeans();
	}
	
	protected function setProvider(Customweb_DependencyInjection_Bean_IProvider $provider) {
		$this->provider = $provider;
	}

	/**
	 * @return Customweb_DependencyInjection_Bean_IProvider
	 */
	protected function getProvider() {
		return $this->provider;
	}
	
	/**
	 * This method resolves the given $identifier to a bean defintion. Sub classes may override this method.
	 * 
	 * @param string $identifier
	 * @throws Customweb_DependencyInjection_Exception_BeanNotFoundException
	 * @return Customweb_DependencyInjection_IBean
	 */
	protected function resolveBeanDefinition($identifier) {
		$beanDefintion = $this->getBeanConfigurationByIdentifier($identifier);
		if ($beanDefintion === null) {
			throw new Customweb_DependencyInjection_Exception_BeanNotFoundException($identifier);
		}
		
		return $beanDefintion;
	}
	
	/**
	 * This method creates an instance of the given bean. Sub classes may override this method.
	 * 
	 * @param Customweb_DependencyInjection_IBean $bean
	 * @return object
	 */
	protected function createInstance(Customweb_DependencyInjection_IBean $bean) {
		return $bean->getInstance($this);
	}
	
	/**
	 * 
	 * @param string $identifier
	 * @return Customweb_DependencyInjection_IBean|NULL
	 */
	final protected function getBeanConfigurationByIdentifier($identifier) {
		if (isset($this->beanDefintionById[$identifier])) {
			return $this->beanDefintionById[$identifier];
		}
		else if (isset($this->beanDefintionByClass[$identifier])) {
			return $this->beanDefintionByClass[$identifier];
		}
		else {
			return null;
		}
	}

}