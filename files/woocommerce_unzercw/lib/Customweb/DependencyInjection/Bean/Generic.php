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

require_once 'Customweb/Core/Util/Class.php';
require_once 'Customweb/DependencyInjection/IBean.php';


class Customweb_DependencyInjection_Bean_Generic implements Customweb_DependencyInjection_IBean{
	
	private $beanId;
	private $beanClassName;
	
	/**
	 * @var Customweb_DependencyInjection_Bean_Generic_IDependency[]
	 */
	private $dependencies = array();
	
	/**
	 * 
	 * @param string $beanId
	 * @param string $beanClassName
	 * @param Customweb_DependencyInjection_Bean_Generic_IDependency[] $dependencies
	 */
	public function __construct($beanId, $beanClassName, array $dependencies) {
		$this->beanId = $beanId;
		$this->beanClassName = $beanClassName;
		$this->dependencies = $dependencies;
	}

	public function getBeanId() {
		return $this->beanId;
	}
	
	public function getInstance(Customweb_DependencyInjection_IContainer $container) {
		Customweb_Core_Util_Class::loadLibraryClassByName($this->getBeanClassName());
	
		$reflection = new ReflectionClass($this->getBeanClassName());
		/* @var $constructor ReflectionMethod */
		$constructor = $reflection->getConstructor();
		$args = array();
		if ($constructor !== null && count($constructor->getParameters()) > 0) {
			foreach ($this->getDependencies() as $dependency) {
				if ($dependency->getAccessMethodName() == $constructor->getName()) {
					$args = $this->getMethodInvocationArguments($constructor, $dependency, $container);
					break;
				}
			}
			if (count($args) != count($constructor->getParameters())) {
				throw new Exception("Could not resolve all parameters for the contructor of " . $this->getBeanClassName() . "::" . $constructor->getName() . "().");
			}
		}
		
		if (count($args) === 0) {
			$instance = $reflection->newInstance();
		}
		else {
			$instance = $reflection->newInstanceArgs($args);
		}
				
		foreach ($this->getDependencies() as $dependency) {
			$this->injectDependency($instance, $dependency, $container);
		}
		
		return $instance;
	}

	public function getClasses() {
		$classes = Customweb_Core_Util_Class::getAllTypes($this->getBeanClassName());
		
		return $classes;
	}
	
	
	/**
	 * @return Customweb_DependencyInjection_Bean_Generic_IDependency[]
	 */
	protected function getDependencies() {
		return $this->dependencies;
	}
	
	protected function getBeanClassName() {
		return $this->beanClassName;
	}

	/**
	 * This method injects the given dependency on the given bean instance.
	 *
	 * @param object $beanInstance
	 * @param Customweb_DependencyInjection_IDependency $dependency
	 * @param object $instanceOfDependency
	 * @throws Exception
	 */
	protected function injectDependency($beanInstance, Customweb_DependencyInjection_Bean_Generic_IDependency $dependency, Customweb_DependencyInjection_IContainer $container) {
		$reflection = new ReflectionClass(get_class($beanInstance));
		
		$setMethodName = $dependency->getAccessMethodName();
		$propertyName = $dependency->getAccessMethodName();
		
		if ($reflection->hasMethod($setMethodName)) {
			$method = $reflection->getMethod($setMethodName);
			$arguments = $this->getMethodInvocationArguments($method, $dependency, $container);
			$method->invokeArgs($beanInstance, $arguments);
		}
		else {
			throw new Exception("Unable to set dependency on '" . $identifier . "' by using method '" . $setMethodName . "'.");
		}
	}
	
	/**
	 * This method returns the list of arguements as defined by the suplied ReflectionMethod.
	 *
	 * @param ReflectionMethod $method
	 * @param string $beanClassName
	 * @param Customweb_DependencyInjection_IDependency $dependency
	 * @throws Exception
	 * @return array
	 */
	protected function getMethodInvocationArguments(ReflectionMethod $method, Customweb_DependencyInjection_Bean_Generic_IDependency $dependency, Customweb_DependencyInjection_IContainer $container) {
		$arguments = array();
	
		if (count($method->getParameters()) !== count($dependency->getInjects())) {
			throw new Exception("The number of arguments of the method '" . $method->getName() . "' and the number of injects defined do not correspond on class '" . $this->getBeanClassName() . "'.");
		}
		foreach ($dependency->getInjects() as $injectId) {
			$arguments[] = $dependency->getInstanceByInject($container, $injectId);
		}
	
		return $arguments;
	}
	
	
}