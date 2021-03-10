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
require_once 'Customweb/Payment/Authorization/DefaultPaymentCustomerContext.php';


/**
 *
 * @Index(columnNames = {'customerId'}, unique = true)
 *
 * @Filter(name = 'loadByCustomerId', where = 'customerId = >customerId', orderBy = 'customerId')
 *
 */
abstract class Customweb_Payment_Entity_AbstractPaymentCustomerContext implements Customweb_Payment_Authorization_IPaymentCustomerContext{

	private $contextId;

	private $map;

	private $customerId;

	private $context = null;

	private $versionNumber;
	
	public function __construct() {
		$this->context = new Customweb_Payment_Authorization_DefaultPaymentCustomerContext(array());
	}

	public function __sleep() {
		return array();
	}
	
	public function __wakeup() {
		$this->context = new Customweb_Payment_Authorization_DefaultPaymentCustomerContext(array());
	}

	public function onAfterLoad(Customweb_Database_Entity_IManager $entityManager) {
		$this->context = new Customweb_Payment_Authorization_DefaultPaymentCustomerContext($this->getStoreMap());
	}

	public function onBeforeSave(Customweb_Database_Entity_IManager $entityManager) {
		if ($this->getContextId() !== null) {
			$currentContext = $entityManager->fetch(get_class($this), $this->getContextId());
			$newMap = $this->context->applyUpdatesOnMap($currentContext->getMap());
			$this->setStoreMap($newMap);
		}
		else {
			$this->setStoreMap($this->context->getMap());
		}
	}

	/**
	 * @PrimaryKey
	 */
	public function getContextId(){
		return $this->contextId;
	}

	public function setContextId($contextId){
		$this->contextId = $contextId;
		return $this;
	}

	/**
	 * @Column(type = 'varchar')
	 */
	public function getCustomerId(){
		return $this->customerId;
	}

	public function setCustomerId($customerId){
		$this->customerId = $customerId;
		return $this;
	}

	/**
	 * @Column(name='context_values', type = 'object')
	 */
	public function getStoreMap() {
		return $this->map;
	}

	public function setStoreMap($map) {
		$this->map = $map;
		return $this;
	}

	/**
	 * @Version
	 */
	public function getVersionNumber() {
		return $this->versionNumber;
	}
	
	public function setVersionNumber($version) {
		$this->versionNumber = $version;
		return $this;
	}

	public function updateMap(array $update) {
		return $this->context->updateMap($update);
	}

	public function getMap() {
		return $this->context->getMap();
	}

	public function getContext(){
		return $this->context;
	}

	public function setContext($context){
		$this->context = $context;
		return $this;
	}
}