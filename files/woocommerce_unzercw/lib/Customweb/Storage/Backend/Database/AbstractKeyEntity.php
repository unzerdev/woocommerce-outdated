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



/**
 *
 * @author Thomas Hunziker
 *
 * @Filter(name = 'loadByKeyAndSpace', where = 'keySpace = >space AND keyName = >key')
 * @Index(columnNames = {'keyName', 'keySpace'}, unique = true)
 * 
 * For unique key we take 165 chars which results in 3 * 2 * 165 = 990 bytes. The limit
 * of typical mysql dbs is 1000 bytes.
 *
 */
abstract class Customweb_Storage_Backend_Database_AbstractKeyEntity {

	private $keyId;

	private $keyName;

	private $keySpace;

	private $keyValue;

	/**
	 * @PrimaryKey
	 */
	public function getKeyId(){
		return $this->keyId;
	}

	public function setKeyId($keyId){
		$this->keyId = $keyId;
		return $this;
	}

	/**
	 * @Column(type = 'varchar', size = '165')
	 */
	public function getKeyName(){
		return $this->keyName;
	}

	public function setKeyName($keyName){
		$this->keyName = $keyName;
		return $this;
	}

	/**
	 * @Column(type = 'varchar', size = '165')
	 */
	public function getKeySpace(){
		return $this->keySpace;
	}

	public function setKeySpace($keySpace){
		$this->keySpace = $keySpace;
		return $this;
	}

	/**
	 * @Column(type = 'object')
	 */
	public function getKeyValue(){
		return $this->keyValue;
	}

	public function setKeyValue($keyValue){
		$this->keyValue = $keyValue;
		return $this;
	}

}