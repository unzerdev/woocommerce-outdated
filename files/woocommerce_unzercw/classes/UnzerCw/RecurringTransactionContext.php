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

require_once 'Customweb/Payment/Authorization/Recurring/ITransactionContext.php';
require_once 'UnzerCw/Util.php';
require_once 'UnzerCw/TransactionContext.php';


class UnzerCw_RecurringTransactionContext extends UnzerCw_TransactionContext implements Customweb_Payment_Authorization_Recurring_ITransactionContext
{
	private $initialTransactionId;
	
	private $initialTransaction;
	
	public function __construct(UnzerCw_Entity_Transaction $transaction, UnzerCw_RecurringOrderContext $orderContext) {
		parent::__construct($transaction, $orderContext);
		$initialTransactionId = $orderContext->getInitialTransactionId();
		$initialTransaction = UnzerCw_Util::getTransactionById($initialTransactionId);
		if ($initialTransaction === null) {
			throw new Exception(sprintf("No initial transaction found for order %s.", $orderContext->getOrderObject()->getId()));
		}
		if(!$initialTransaction->getTransactionObject()->isAuthorized()){
			throw new Exception("The initial transaction was never authorized.");
		}
		$this->initialTransaction = $initialTransaction;		
		$this->initialTransactionId = $initialTransactionId;
		
	}
	
	public function __sleep() {
		$fields = parent::__sleep();
		$fields[] = 'initialTransactionId';
		return $fields;
	}
	
	public function getInitialTransaction() {
		if ($this->initialTransaction === null) {
			$this->initialTransaction = UnzerCw_Util::getTransactionById($this->initialTransactionId);
		}
		return $this->initialTransaction->getTransactionObject();
	}
}