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


require_once 'Customweb/Core/Reflection/Class.php';

class Customweb_Core_Reflection_Class extends ReflectionClass {
	
	private $recursiveMethods = array();
	private $recursiveProperties = array();

	/**
	 * Gets all method recursive the inheritance tree along.
	 * 
	 * @param string $filter  <p>
	 * Any combination of ReflectionMethod::IS_STATIC,
	 * ReflectionMethod::IS_PUBLIC,
	 * ReflectionMethod::IS_PROTECTED,
	 * ReflectionMethod::IS_PRIVATE,
	 * ReflectionMethod::IS_ABSTRACT,
	 * ReflectionMethod::IS_FINAL.
	 * @return ReflectionMethod[]
	 */
	public function getMethodsRecursive($filter = -1){
		$filterKey = (string)$filter;
		if (!isset($this->recursiveMethods[$filterKey])) {
			$methods = $this->getMethods($filter);
			$parent = $this->getParentClass();
			if ($parent !== false) {
				$methods = array_merge($methods, $parent->getMethodsRecursive($filter));
			}
			$this->recursiveMethods[$filterKey] = $methods;
		}
		
		return $this->recursiveMethods[$filterKey];
	}
	
	/**
	 * Gets all properties recursive the inheritance tree along.
	 * 
	 * @param string $filter  <p>
	 * Any combination of ReflectionMethod::IS_STATIC,
	 * ReflectionMethod::IS_PUBLIC,
	 * ReflectionMethod::IS_PROTECTED,
	 * ReflectionMethod::IS_PRIVATE,
	 * ReflectionMethod::IS_ABSTRACT,
	 * ReflectionMethod::IS_FINAL.
	 * @return ReflectionProperty
	 */
	public function getPropertiesRecursive($filter = -1){
		$filterKey = (string)$filter;
		if (!isset($this->recursiveProperties[$filterKey])) {
			$properties = $this->getProperties($filter);
			$parent = $this->getParentClass();
			if ($parent !== false) {
				$properties = array_merge($properties, $parent->getPropertiesRecursive($filter));
			}
			$this->recursiveProperties[$filterKey] = $properties;
		}
	
		return $this->recursiveProperties[$filterKey];
	}

	public function hasMethodRecursive($name) {
		if ($this->hasMethod($name)) {
			return true;
		}
		foreach ($this->getMethodsRecursive() as $method) {
			if ($method->getName() == $name) {
				return true;
			}
		}
		return false;
	}

	public function hasPropertyRecursive($name) {
		if ($this->hasProperty($name)) {
			return true;
		}
		foreach ($this->getPropertiesRecursive() as $property) {
			if ($property->getName() == $name) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * @return Customweb_Core_Reflection_Class[]
	 */
	public function getInterfaces(){
		$result = array();
		
		foreach (parent::getInterfaces() as $interface) {
			$result[] = $this->createReflectionClass($interface);
		}
		
		return $result;
	}

	/**
	 * @return Customweb_Core_Reflection_Class
	 */
	public function getParentClass(){
		$class = parent::getParentClass();
		
		return $this->createReflectionClass($class);
	}
	
	
	private function createReflectionClass($class)
	{
		return ($class !== false) ? new Customweb_Core_Reflection_Class($class->getName()) : false;
	}
}