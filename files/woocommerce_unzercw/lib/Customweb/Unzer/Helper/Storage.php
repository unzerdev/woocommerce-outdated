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

require_once 'Customweb/Unzer/Container.php';
require_once 'Customweb/Storage/IBackend.php';


/**
 * Helper to access storage easily.
 *
 * @author Sebastian Bossert
 * @Bean
 */
class Customweb_Unzer_Helper_Storage {
	private $container;
	const SPACE = 'UnzerStorage';

	public function __construct(Customweb_DependencyInjection_IContainer $container){
		$this->container = Customweb_Unzer_Container::get($container);
	}
	
	public function readStorage($key){
		$storage = $this->getContainer()->getStorage();
		$storage->lock(self::SPACE, $key, Customweb_Storage_IBackend::SHARED_LOCK);
		$data = $storage->read(self::SPACE, $key);
		$storage->unlock(self::SPACE, $key);
		return base64_decode($data);
	}
	
	public function clearStorage($key){
		$storage = $this->getContainer()->getStorage();
		$storage->lock(self::SPACE, $key, Customweb_Storage_IBackend::EXCLUSIVE_LOCK);
		$storage->remove(self::SPACE, $key);
		$storage->unlock(self::SPACE, $key);
	}

	public function writeStorage($key, $data){
		$data = base64_encode($data);
		$storage = $this->getContainer()->getStorage();
		$storage->lock(self::SPACE, $key, Customweb_Storage_IBackend::EXCLUSIVE_LOCK);
		$storage->write(self::SPACE, $key, $data);
		$storage->unlock(self::SPACE, $key);
	}

	protected function getContainer(){
		return $this->container;
	}
}