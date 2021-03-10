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
require_once 'Customweb/Core/String.php';
require_once 'Customweb/Core/Enum.php';



/**
 * Abstract Enum implementation which allows creation of Enums in PHP.
 *
 * Sub classes can create static public methods which holds the Enum values. Sub classes should implement
 * the static methods values() and valueOf() based up on the implementation of this class.
 *
 * <pre>
 * class SampleEnum extends Customweb_Core_Enum {
 * public static function TEST() {
 * return self::instance(__CLASS__, 'test');
 * }
 *
 * public static function TEST2() {
 * return self::instance(__CLASS__, 'test2');
 * }
 *
 * public static function values() {
 * return self::valuesInner(__CLASS__);
 * }
 *
 * public static function valueOf($key) {
 * return self::valueOfInner(__CLASS__, $key);
 * }
 * }
 * </pre>
 *
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_Core_Enum {
	private $key;
	private static $instances = array();
	private static $instancesCreated = array();

	protected function __construct($key){
		$this->key = $key;
	}

	public function __toString(){
		return $this->key;
	}

	public function getKey(){
		return $this->key;
	}

	/**
	 * Creates a new instance for the given key and the given arguments.
	 * Beside the key and the className any other arguments are passed to the
	 * constructor in the same order.
	 *
	 * @param string $className
	 * @param string $key
	 */
	protected static function instance($className, $key){
		if (!isset(self::$instances[$className])) {
			self::$instances[$className] = array();
		}
		
		if (!isset(self::$instances[$className][$key])) {
			$arguments = func_get_args();
			array_shift($arguments);
			self::$instances[$className][$key] = self::createInstance($className, $arguments);
		}
		
		return self::$instances[$className][$key];
	}

	protected static function valuesInner($className){
		if (!isset(self::$instancesCreated[$className])) {
			self::$instancesCreated[$className] = true;
			$methods = self::findEnumValueMethods($className);
			foreach ($methods as $method) {
				$method->invoke(null);
			}
		}
		
		return self::$instances[$className];
	}

	protected static function valueOfInner($className, $key){
		$values = self::valuesInner($className);
		if (isset($values[$key])) {
			return $values[$key];
		}
		else {
			throw new Exception(
					Customweb_Core_String::_("The key '@key' does not exists on the Enum '@enum'.")->format(
							array(
								'@key' => $key,
								'@enum' => $className 
							)));
		}
	}

	/**
	 * Creates a new instance of the enum.
	 *
	 * @param string $className
	 * @param array $arguments
	 * @return object
	 */
	protected final static function createInstance($className, $arguments){
		// Some optimizations
		if (count($arguments) == 1) {
			return new $className($arguments[0]);
		}
		else if (count($arguments) == 2) {
			return new $className($arguments[0], $arguments[1]);
		}
		else if (count($arguments) == 3) {
			return new $className($arguments[0], $arguments[1], $arguments[2]);
		}
		else if (count($arguments) == 4) {
			return new $className($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
		}
		else if (count($arguments) == 5) {
			return new $className($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4]);
		}
		
		// For any constructor with more arguments we use eval.
		$args = array();
		for ($i = 0; $i < count($arguments); $i++) {
			$args[] = '$arguments[' . $i . ']';
		}
		$instance = null;
		eval('$instance = new ' . $className . '(' . implode(',', $args) . ');');
		return $instance;
	}

	/**
	 * Returns a list of methods which are enum value methods.
	 *
	 * @param string $className
	 * @throws Customweb_Core_Exception_CastException
	 * @return ReflectionMethod[]
	 */
	protected static function findEnumValueMethods($className){
		$reflection = new ReflectionClass($className);
		
		$methods = array();
		$blackList = self::getNonEnumValueMethods();
		foreach ($reflection->getMethods(ReflectionMethod::IS_STATIC) as $method) {
			if (!($method instanceof ReflectionMethod)) {
				throw new Customweb_Core_Exception_CastException('ReflectionMethod');
			}
			if ($method->isPublic() && !in_array($method->getName(), $blackList)) {
				$methods[] = $method;
			}
		}
		
		return $methods;
	}

	/**
	 * Returns public static methods, which should not be considered as Enum value methods.
	 *
	 * Subclasses may override this method to add additional methods to the list.
	 *
	 * @return multitype:string
	 */
	protected static function getNonEnumValueMethods(){
		return array(
			'values',
			'valueOf' 
		);
	}
}