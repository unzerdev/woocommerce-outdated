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
 * A storage backend is a implementation of key / value store. It provides an
 * interface to store a value assosiated with given key in a space.
 * 
 * The space and key builds the primary key. The value must be a string. In case
 * there are special chars, the client may encod it as base64 to prevent the 
 * corruption of the data.
 * 
 * The key and the space strings should not be longer than 160 chars.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Storage_IBackend {
	
	/**
	 * The exclusive lock prevents other processes from reading or writing at
	 * the same time.
	 * 
	 * @var bin
	 */
	const EXCLUSIVE_LOCK = 0x001;
	
	/**
	 * The shared lock allows other processes to read the key, but prevents 
	 * other process from writing to it.
	 * 
	 * @var bin
	 */
	const SHARED_LOCK = 0x002;
	
	/**
	 * This method locks the given key with the given lock type. The lock type can be 
	 * either a exclusive or a shared. 
	 * 
	 * The exclusive prevents any other to read or write the value. The shared lock allows other
	 * to read, but not to write.
	 * 
	 * This operation is blocking the process. Means the process control returns when the lock
	 * was granted.
	 * 
	 * The key should not be removed when a lock is applied on it.
	 * 
	 * @param string $space
	 * @param string $key
	 * @param LockType $type
	 * @return void
	 */
	public function lock($space, $key, $type);
	
	/**
	 * This method unlocks a given key. The unlock may not be applied immediately. It 
	 * may take sometime untile the lock is removed. However the lock is latest removed
	 * when the PHP request is finished.
	 * 
	 * @param string $space
	 * @param string $key
	 * @return void
	 */
	public function unlock($space, $key);
	
	/**
	 * This method retrives the value by the given space and key. The mehtod 
	 * may throw an exception in case something went wrong.
	 * 
	 * In case the key does not exists this method returns null.
	 * 
	 * @param string $space
	 * @param string $key
	 * @return object The value.
	 * @throws Exception
	 */
	public function read($space, $key);
	
	/**
	 * This method stores the given value to the store. 
	 * 
	 * @param string $space
	 * @param string $key
	 * @param object $value
	 * @throws Exception
	 * @return void
	 */
	public function write($space, $key, $value);
	
	/**
	 * This method removes the given value from the store.
	 * 
	 * @param string $space
	 * @param string $key
	 * @throws Exception
	 * @return void
	 */
	public function remove($space, $key);
	
}