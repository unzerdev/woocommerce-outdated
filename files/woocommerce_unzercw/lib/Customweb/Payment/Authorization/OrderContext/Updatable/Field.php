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

require_once 'Customweb/Payment/Authorization/OrderContext/Updatable/IField.php';


/**
 * Default implementation of the Customweb_Payment_Authorization_OrderContext_Updatable_IField interface.
 * 
 * @author Nico Eigenmann / Thomas Hunziker
 *
 */
class Customweb_Payment_Authorization_OrderContext_Updatable_Field implements Customweb_Payment_Authorization_OrderContext_Updatable_IField {
	
	private $semanticKey = null;
	private $value = null;
	
	public function __construct($semanticKey, $value) {
		$reflection = new ReflectionClass($this);
		if (!in_array($semanticKey, $reflection->getConstants())) {
			throw new InvalidArgumentException("The given semantic key is not defined on the interface Customweb_Payment_Authorization_OrderContext_Updatable_IField.");
		}
		$this->value = $value;
		$this->semanticKey = $semanticKey;
	}
	
	public function getValue() {
		return $this->value;
	}
	
	public function getSemanticKey() {
		return $this->semanticKey;
	}
	
}