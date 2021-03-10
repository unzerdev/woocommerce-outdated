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

require_once 'Customweb/Payment/Authorization/IPaymentCustomerContext.php';

/**
 * Default implementation of Customweb_Payment_Authorization_IPaymentCustomerContext.
 *
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_Authorization_DefaultPaymentCustomerContext implements
Customweb_Payment_Authorization_IPaymentCustomerContext {

	private $map = array();
	private $updates = array();
	
	public function __construct($map) {
		if($map === null || !is_array($map)){
			$map = array();
		}
		$this->map = $map;
		
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IPaymentCustomerContext::getMap()
	 */
	public function getMap() {
		return $this->map;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IPaymentCustomerContext::updateMap()
	 */
	public function updateMap(array $update) {
		$this->map = self::replaceRecursive($this->map, $update);
		$this->updates[] = $update;
		
		return $this;
	}
	
	/**
	 * This method applies all the updates collected to the given map and resets
	 * the internal storage of the updates.
	 * 
	 * @param array $map
	 * @return array Updated map
	 */
	public function applyUpdatesOnMapAndReset($map) {
		$map = $this->applyUpdatesOnMap($map);
		$this->resetUpdateStorage();
		return $map;
	}
	
	/**
	 * This method applies all the updates collected to the given map.
	 * 
	 * @param array $map
	 * @return array Updated map
	 */
	public function applyUpdatesOnMap($map) {
		if($map === null || !is_array($map)){
			$map = array();
		}
		foreach ($this->updates as $update) {
			$map = self::replaceRecursive($map, $update);
		}
		return $map;
	}

	/**
	 * This method resets the interal storage of the updates.
	 * 
	 * @return Customweb_Payment_Authorization_DefaultPaymentCustomerContext
	 */
	public function resetUpdateStorage() {
		$this->updates = array();
		return $this;
	}
	
	protected static function replaceRecursive($array, $array1) {
		$args = func_get_args();
		$array = $args[0];
		if (!is_array($array)) {
			return $array;
		}
		
		for ($i = 1; $i < count($args); $i++) {
			if (is_array($args[$i])) {
				$array = self::recurse($array, $args[$i]);
			}
		}
		return $array;
	}
	
	protected static function recurse($array, $array1) {
		foreach ($array1 as $key => $value)	{
			if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key]))) {
				$array[$key] = array();
			}

			if (is_array($value)) {
				$value = self::recurse($array[$key], $value);
			}
			$array[$key] = $value;
		}
		return $array;
	}

}