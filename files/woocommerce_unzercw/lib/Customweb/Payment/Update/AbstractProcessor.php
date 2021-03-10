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



abstract class Customweb_Payment_Update_AbstractProcessor {
	
	private $handler;
	
	private $updateAdapter = null;
	
	abstract public function process();

	public function __construct(Customweb_Payment_Update_IHandler $handler) {
		$this->handler = $handler;
	}
	
	public function getHandler(){
		return $this->handler;
	}

	/**
	 * @return Customweb_Payment_Update_IAdapter
	 */
	protected function getUpdateAdapter() {
		
		if ($this->updateAdapter === null) {
			if ($this->getHandler()->getContainer()->hasBean('Customweb_Payment_Update_IAdapter')) {
				$this->updateAdapter = $this->getHandler()->getContainer()->getBean('Customweb_Payment_Update_IAdapter');
			}
			else {
				$this->updateAdapter = false;
			}
		}
		
		if ($this->updateAdapter === false) {
			return null;
		}
		else {
			return $this->updateAdapter;
		}
	}
	
	
	/**
	 * @return Customweb_Storage_IBackend
	 */
	protected function getStorageBackend() {
		return $this->getHandler()->getContainer()->getBean('Customweb_Storage_IBackend');
	}
	
	/**
	 * @return Customweb_Payment_ITransactionHandler
	 */
	protected function getTransactionHandler() {
		return $this->getHandler()->getContainer()->getBean('Customweb_Payment_ITransactionHandler');
	}
	
	/**
	 * @return Customweb_Database_IDriver
	 */
	protected function getDriver() {
		return $this->getHandler()->getContainer()->getBean('Customweb_Database_IDriver');
	}
}