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

require_once 'Customweb/Storage/IBackend.php';
require_once 'Customweb/Payment/Cache/ICacheHandler.php';



/**
 * Class to cache return values from a callback.
 *
 * @author Sebastian Bossert
 */
class Customweb_Payment_Cache_CacheHandler implements Customweb_Payment_Cache_ICacheHandler {
	private $container;
	private $timeout;
	private $callback;
	private $storageNamespace;
	const TIMESTAMP = 'timestamp';
	const RESULT = 'result';

	/**
	 *
	 * @param Customweb_DependencyInjection_IContainer $container
	 * @param array $callback Callable (first element = object, second element = method name). The return value must be serializable.
	 * @param string $storageNamespace
	 * @param integer $timeout In seconds, the period of validity of the retrieved result
	 */
	public function __construct(Customweb_DependencyInjection_IContainer $container, array $callback, $storageNamespace = 'cwCacheHandler', $timeout = 600){
		$this->container = $container;
		$this->callback = $callback;
		$this->storageNamespace = $storageNamespace;
		$this->timeout = $timeout;
	}

	public function getCachedResult($key){
		$result = $this->read($key);
		if ($this->isTimeoutExceeded($result)) {
			$result = null;
		}
		return $result;
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see Customweb_Payment_Cache_ICacheHandler::getResult()
	 */
	public function getResult($key, array $parameters){
		$result = $this->read($key);
		if ($result == null || $this->isTimeoutExceeded($result)) {
			if (empty($parameters)) {
				$resultObject = call_user_func($this->getCallback());
			}
			else {
				$resultObject = call_user_func_array($this->getCallback(), $parameters);
			}
			$result = array(
				self::RESULT => $resultObject,
				self::TIMESTAMP => time() 
			);
			$this->write($key, $result);
		}
		return $result[self::RESULT];
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see Customweb_Payment_Cache_ICacheHandler::clearResult()
	 */
	public function clearResult($key){
		$this->remove($key);
	}

	protected function getCallback(){
		return $this->callback;
	}

	protected function getTimeout(){
		return $this->timeout;
	}

	protected function remove($key){
		$this->getStorage()->lock($this->storageNamespace, $key, Customweb_Storage_IBackend::EXCLUSIVE_LOCK);
		$this->getStorage()->remove($this->storageNamespace, $key);
		$this->getStorage()->unlock($this->storageNamespace, $key);
	}

	protected function read($key){
		return unserialize(base64_decode($this->getStorage()->read($this->storageNamespace, $key)));
	}

	protected function write($key, $value){
		$this->getStorage()->lock($this->storageNamespace, $key, Customweb_Storage_IBackend::SHARED_LOCK);
		$this->getStorage()->write($this->storageNamespace, $key, base64_encode(serialize($value)));
		$this->getStorage()->unlock($this->storageNamespace, $key);
	}

	/**
	 *
	 * @return Customweb_Storage_IBackend
	 */
	protected function getStorage(){
		return $this->getContainer()->getBean('Customweb_Storage_IBackend');
	}

	/**
	 *
	 * @return Customweb_DependencyInjection_IContainer
	 */
	protected function getContainer(){
		return $this->container;
	}

	protected function isTimeoutExceeded($result){
	    return is_array($result) && isset($result[self::TIMESTAMP]) && ($result[self::TIMESTAMP] + $this->getTimeout() <= time());
	}
}