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

require_once 'Customweb/Payment/Update/IHandler.php';
require_once 'Customweb/Payment/Update/AbstractProcessor.php';
require_once 'Customweb/Util/String.php';


/**
 * This processor can be used to update / process a single transaction. This can
 * be useful, when the update should be done manually e.g. from the backend of the 
 * store.
 * 
 * @author Thomas Hunziker / Simon Schurter
 *
 */
class Customweb_Payment_Update_PullProcessor extends Customweb_Payment_Update_AbstractProcessor {
	
	private $transactionId = null;
	
	public function __construct(Customweb_Payment_Update_IHandler $handler, $transactionId) {
		parent::__construct($handler);
		$this->transactionId = $transactionId;
	}
	
	public function process() {
		if ($this->transactionId == null) {
			return;
		}
		
		if ($this->getUpdateAdapter() === null) {
			return;
		}
		$this->getTransactionHandler()->beginTransaction();
		try{
			
			$transactionObject = $this->getTransactionHandler()->findTransactionByTransactionId($this->transactionId);
			if ($transactionObject == null) {
				$this->getHandler()->log(Customweb_Util_String::formatString("No transaction found for transaction id '!id'.", array('!id' => $this->transactionId)), Customweb_Payment_Update_IHandler::LOG_TYPE_ERROR);
			}
			else {
				try {
					$this->getUpdateAdapter()->updateTransaction($transactionObject);
					$this->getHandler()->log(
						Customweb_Util_String::formatString(
							"Transaction with id '!id' successful updated.",
							array('!id' => $this->transactionId)
						),
						Customweb_Payment_Update_IHandler::LOG_TYPE_INFO
					);
				}
				catch(Exception $e) {
					$this->getHandler()->log($e->getMessage(), Customweb_Payment_Update_IHandler::LOG_TYPE_ERROR);
				}
				$this->getTransactionHandler()->persistTransactionObject($transactionObject);
			}
			$this->getTransactionHandler()->commitTransaction();
		}
		catch(Exception $e){
			$this->getTransactionHandler()->rollbackTransaction();
			$this->getHandler()->log(Customweb_Util_String::formatString("Error updating transaction '!id'. Excpetion: !exc", array('!id' => $this->transactionId, '!exc' => $e->getMessage())), Customweb_Payment_Update_IHandler::LOG_TYPE_ERROR);
		
		}
	}
}