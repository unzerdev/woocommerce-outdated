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


/**
 * This storage implementation uses a database backend. The locks are realized by using
 * database transactions.
 *
 * @author Thomas Hunziker
 * @Bean
 *
 */
// TODO: We can improve the performance by caching locally the primary key and do not use always the space and key.
class Customweb_Storage_Backend_Database implements Customweb_Storage_IBackend {

	/**
	 * @var Customweb_Database_Entity_IManager
	 */
	private $entityManager;

	/**
	 * @var Customweb_Database_IDriver
	 */
	private $driver;

	/**
	 * @var string
	 */
	private $entityClassName;
	
	
	private $lockedKeys = array();
	private $started = false;
	/**
	 *
	 * @param Customweb_Database_Entity_IManager $manager
	 * @param string $entityClassName
	 * @Inject({'Customweb_Database_Entity_IManager', 'Customweb_Database_IDriver', 'storageDatabaseEntityClassName'})
	 */
	public function __construct(Customweb_Database_Entity_IManager $manager, Customweb_Database_IDriver $driver, $entityClassName){
		$this->entityManager = $manager;
		$this->driver = $driver;
		$this->entityClassName = $entityClassName;
	}

	public function lock($space, $key, $type){
		$this->lockedKeys[$space.'-'.$key] = true;
		if (!$this->driver->isTransactionRunning()) {
			$this->started = true;
			$this->driver->beginTransaction();
			register_shutdown_function(array($this, 'commit'));
		}

		// By loading the entity we create a shared lock.
		$entity = $this->loadEntity($space, $key, false);

		if ($entity === null) {
			$this->write($space, $key, null);
			$entity = $this->loadEntity($space, $key, false);
		}

		if ($type == self::EXCLUSIVE_LOCK) {
			// When we write the entity back to the database, we force that the
			// row is exclusivly locked. We need to write the whole entity (all fields) otherwise
			// we may lock only certain fields.
			$this->entityManager->persist($entity, false);
		}
	}

	public function unlock($space, $key){
		unset($this->lockedKeys[$space.'-'.$key]);
		if(empty($this->lockedKeys) && $this->started){
			$this->started = false;
			$this->driver->commit();
		}
	}

	public function read($space, $key){
		$entity = $this->loadEntity($space, $key, false);
		if ($entity !== null) {
			return $entity->getKeyValue();
		} else {
			return null;
		}
	}
	
	/**
	 * Commits a given transaction. This is required to make sure that the 
	 * transaction is closed.
	 * 
	 * @return void
	 */
	public function commit() {
		if ($this->driver->isTransactionRunning()) {
			$this->driver->commit();
		}
	}

	public function write($space, $key, $value){
		$entity = $this->loadEntity($space, $key, false);
		if ($entity === null) {
			$className = $this->entityClassName;
			$entity = new $className();
		}
		$entity->setKeyName($key)->setKeySpace($space)->setKeyValue($value);
		$this->entityManager->persist($entity);
	}

	public function remove($space, $key){
		$entity = $this->loadEntity($space, $key);
		if ($entity !== null) {
			$this->entityManager->remove($entity);
		}
	}

	/**
	 * This method loads the given entity. The cache flag can be used to by pass the entity
	 * managers cache.
	 *
	 * @param string $space
	 * @param string $key
	 * @param boolean $cache
	 * @return Customweb_Storage_Backend_Database_AbstractKeyEntity
	 */
	public function loadEntity($space, $key, $cache = true){
		$entities = $this->entityManager->searchByFilterName($this->entityClassName, 'loadByKeyAndSpace', array(
			'>key' => $key,
			'>space' => $space
		), $cache);

		if (count($entities) > 0) {
			$entity = current($entities);
			return $entity;
		} else {
			return null;
		}
	}

	/**
	 * Returns the schema to use this storage backend. The resulting SQL string must be
	 * executed prior to use this backend.
	 *
	 * @return string
	 */
	public function generateSchema(){
		return $this->entityManager->generateEntitySchema($this->entityClassName);
	}

	/**
	 * @return Customweb_Database_Entity_IManager
	 */
	public function getEntityManager(){
		return $this->entityManager;
	}

	/**
	 * @return Customweb_Database_IDriver
	 */
	public function getDriver(){
		return $this->driver;
	}

	/**
	 * @return string
	 */
	public function getEntityClassName(){
		return $this->entityClassName;
	}

}