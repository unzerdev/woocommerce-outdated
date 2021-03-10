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
require_once 'Customweb/Payment/Authorization/ITransaction.php';



/**
 * This class cleans the transcation table.
 *
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_AbstractTransactionCleanUpBean {
	
	/**
	 *
	 * @var Customweb_Database_Entity_IManager
	 */
	private $manager = null;
	
	/**
	 *
	 * @var string
	 */
	private $transactionClassName = null;

	public function __construct(Customweb_Database_Entity_IManager $manager, $transactionClassName){
		$this->manager = $manager;
		$this->transactionClassName = $transactionClassName;
	}

	public function cleanUp(){
		$maxEndtime = Customweb_Core_Util_System::getScriptExecutionEndTime() - 4;
		$where = '(updatedOn < NOW() - INTERVAL 2 MONTH AND authorizationStatus = "' .
				 Customweb_Payment_Authorization_ITransaction::AUTHORIZATION_STATUS_FAILED .
				 '") OR (updatedOn < NOW() - INTERVAL 6 MONTH AND authorizationStatus = "' .
				 Customweb_Payment_Authorization_ITransaction::AUTHORIZATION_STATUS_PENDING .
				 '" ) OR (updatedOn < NOW() - INTERVAL 1 MONTH AND (authorizationStatus = "" OR authorizationStatus IS NULL )) LIMIT 0,40';
		$removable = $this->manager->searchPrimaryKey($this->transactionClassName, $where);
		
		foreach ($removable as $remove) {
			if ($maxEndtime > time()) {
				$this->manager->removeByPrimaryKey($this->transactionClassName, $remove);
			}
			else {
				break;
			}
		}
	}
}