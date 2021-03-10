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

require_once 'Customweb/Core/Util/System.php';



/**
 * Abstract implementation of a bean implementation which is able to clean up 
 * external contexts which are not required any more (failed / outdated).
 * 
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_Payment_ExternalCheckout_AbstractContextCleanUpBean {
	
	/**
	 * @var Customweb_Database_Entity_IManager
	 */
	private $entityManager;
	
	private $contextEntityName;
	
	public function __construct(Customweb_Database_Entity_IManager $entityManager, $contextEntityName) {
		$this->entityManager = $entityManager;
		$this->contextEntityName = $contextEntityName;
	}
	
	public function cleanUp() {
		$maxEndtime = Customweb_Core_Util_System::getScriptExecutionEndTime() - 4;
		
		// Remove all contexts which are not changed in the last 2 days and the state is not completed.
		$where = 'updatedOn < NOW() - INTERVAL 2 DAY AND state != "completed" LIMIT 0,40';
		$entities = $this->entityManager->search($this->contextEntityName, $where);
		foreach ($entities as $entity) {
			if ($maxEndtime > time()) {
				$this->entityManager->remove($entity);
			}
			else {
				break;
			}
		}
	}
	
}