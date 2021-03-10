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

require_once 'Customweb/Storage/IBackend.php';
require_once 'Customweb/Util/System.php';
require_once 'Customweb/Payment/Update/AbstractProcessor.php';


abstract class Customweb_Payment_Update_AbstractLockProcessor extends Customweb_Payment_Update_AbstractProcessor {
	
	const STORAGE_BACKEND_LAST_START_UPDATE_KEY = "last_start_update";
	const STORAGE_BACKEND_IS_UPDATE_RUNNING_KEY = "is_update_running";
	
	private $startTime = null;
		
	abstract protected function getBackendStorageSpace();

	protected function tryLockUpdate() {
		$this->getStorageBackend()->lock($this->getBackendStorageSpace(), self::STORAGE_BACKEND_IS_UPDATE_RUNNING_KEY, Customweb_Storage_IBackend::EXCLUSIVE_LOCK);
		$locked = $this->getStorageBackend()->read($this->getBackendStorageSpace(), self::STORAGE_BACKEND_IS_UPDATE_RUNNING_KEY);
		if ($locked == 'yes') {
			$time = $this->getStorageBackend()->read($this->getBackendStorageSpace(), self::STORAGE_BACKEND_LAST_START_UPDATE_KEY);
			if (empty($time)) {
				$time = 0;
			}
			$timeout = Customweb_Util_System::getMaxExecutionTime() * 2;
			if ($time + $timeout < time()) {
				$success = true;
			}
			else {
				$success = false;
			}
		}
		else {
			$success = true;
		}
		if ($success) {
			$this->getStorageBackend()->write($this->getBackendStorageSpace(), self::STORAGE_BACKEND_LAST_START_UPDATE_KEY, time());
			$this->getStorageBackend()->write($this->getBackendStorageSpace(), self::STORAGE_BACKEND_IS_UPDATE_RUNNING_KEY, 'yes');
		}
		$this->getStorageBackend()->unlock($this->getBackendStorageSpace(), self::STORAGE_BACKEND_IS_UPDATE_RUNNING_KEY);
	
		return $success;
	}
	
	protected function unlockUpdate() {
		$this->getStorageBackend()->lock($this->getBackendStorageSpace(), self::STORAGE_BACKEND_IS_UPDATE_RUNNING_KEY, Customweb_Storage_IBackend::EXCLUSIVE_LOCK);
		$this->getStorageBackend()->write($this->getBackendStorageSpace(), self::STORAGE_BACKEND_IS_UPDATE_RUNNING_KEY, 'no');
		$this->getStorageBackend()->unlock($this->getBackendStorageSpace(), self::STORAGE_BACKEND_IS_UPDATE_RUNNING_KEY);
	}

	/**
	 * Sets the start time. Based on this time the runtime of the process is determine.
	 *
	 * @return Customweb_Payment_Update_AbstractLockProcessor
	 */
	public function setStartTime($startTime) {
		$this->startTime = $startTime;
		return $this;
	}

	/**
	 * Returns the start time of the process.
	 *
	 * @return int
	 */
	public function getStartTime() {
		if ($this->startTime === null) {
			if (isset($_SERVER['REQUEST_TIME'])) {
				$this->startTime = $_SERVER['REQUEST_TIME'];
			}
			else {
				$this->startTime = time();
			}
		}
	
		return $this->startTime;
	}
	
}