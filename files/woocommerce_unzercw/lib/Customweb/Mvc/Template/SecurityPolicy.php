<?php
/**
 *  * You are allowed to use this API in your web application.
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

require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Mvc/Template/ISecurityPolicy.php';
require_once 'Customweb/Mvc/Template/SecurityException.php';


/**
 * This is the default security policy to protect the template engine from
 * abuse the enviroment.
 *
 * @author Nico Eigenmann / Thomas Hunziker
 */
class Customweb_Mvc_Template_SecurityPolicy implements Customweb_Mvc_Template_ISecurityPolicy
{
	private $allowedTypes = array();

	private $allowedMethods = array();

	private $unallowedMethods = array();

	public function checkMethodAllowed($object, $method)
	{
		$method = strtolower($method);
		foreach ($this->getUnallowedMethods() as $class => $methods) {
			if ($object instanceof $class && isset($methods[$method])) {
				throw new Customweb_Mvc_Template_SecurityException(sprintf('Calling "%s" method on a "%s" object is not allowed.', $method, get_class($object)));
			}
		}
		
		$allowed = false;
		foreach ($this->getAllowedMethods() as $class => $methods) {
			if ($object instanceof $class && isset($methods[$method])) {
				$allowed = true;
				break;
			}
		}
		
		if (! $allowed) {
			throw new Customweb_Mvc_Template_SecurityException(sprintf('Calling "%s" method on a "%s" object is not allowed.', $method, get_class($object)));
		} else {
			return true;
		}
	}

	public function getAllowedTypes()
	{
		return $this->allowedTypes;
	}

	public function setAllowedTypes(array $allowedTypes)
	{
		foreach ($this->allowedTypes as $type) {
			unset($this->allowedMethods[$type]);
		}
		$this->allowedTypes = array();
		
		foreach ($allowedTypes as $type) {
			$this->addAllowedType($type);
		}
		return $this;
	}

	protected function updateAllowedTypes()
	{
		foreach ($this->allowedTypes as $type) {
			$this->addAllowedType($type);
		}
	}

	public function addAllowedType($type)
	{
		$this->allowedTypes[strtolower($type)] = $type;
		
		$reflection = new ReflectionClass($type);
		foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
			if (! ($method instanceof ReflectionMethod)) {
				throw new Customweb_Core_Exception_CastException('ReflectionMethod');
			}
			if (! $method->isStatic()) {
				$this->addAllowedMethod($type, $method->getName());
			}
		}
		
		return $this;
	}

	public function getAllowedMethods()
	{
		return $this->allowedMethods;
	}

	public function setAllowedMethods(array $methods)
	{
		$this->allowedMethods = array();
		$this->updateAllowedTypes();
		foreach ($methods as $class => $methodName) {
			$this->addAllowedMethod($class, $methodName);
		}
		return $this;
	}

	public function addAllowedMethod($type, $methodName)
	{
		if (! isset($this->allowedMethods[strtolower($type)])) {
			$this->allowedMethods[strtolower($type)] = array();
		}
		if (is_array($methodName)) {
			foreach ($methodName as $method) {
				$this->allowedMethods[strtolower($type)][strtolower($method)] = $method;
			}
		} else {
			$this->allowedMethods[strtolower($type)][strtolower($methodName)] = $methodName;
		}
		return $this;
	}

	public function removeAllowedMethod($type, $methodName)
	{
		$type = strtolower($type);
		$methodName = strtolower($methodName);
		if (isset($this->allowedMethods[$type][$methodName])) {
			unset($this->allowedMethods[$type][$methodName]);
		}
		$this->updateAllowedTypes();
		if (isset($this->allowedMethods[$type][$methodName])) {
			throw new Exception("You can not remove a method with removeAllowedMethod(), when the method is allowed by addAllowedType().");
		}
		
		return $this;
	}

	public function getUnallowedMethods()
	{
		return $this->unallowedMethods;
	}

	public function setUnallowedMethods(array $methods)
	{
		$this->unallowedMethods = array();
		foreach ($methods as $class => $methodName) {
			$this->addUnallowedMethod($class, $methodName);
		}
		return $this;
	}

	public function addUnallowedMethod($type, $methodName)
	{
		if (! isset($this->unallowedMethods[strtolower($type)])) {
			$this->unallowedMethods[strtolower($type)] = array();
		}
		if (is_array($methodName)) {
			foreach ($methodName as $method) {
				$this->unallowedMethods[strtolower($type)][strtolower($method)] = $method;
			}
		} else {
			$this->unallowedMethods[strtolower($type)][strtolower($methodName)] = $methodName;
		}
		return $this;
	}

	public function removeUnallowedMethod($type, $methodName)
	{
		$type = strtolower($type);
		$methodName = strtolower($methodName);
		if (isset($this->unallowedMethods[$type][$methodName])) {
			unset($this->unallowedMethods[$type][$methodName]);
		}
		return $this;
	}
}