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

require_once 'Customweb/Payment/Authorization/ITransaction.php';

/**
 * This interface defines how to cancel a transaction.
 * 
 * In case this interface is implemented by a store, the store must ensure, that the transaction 
 * is stored during the execution of the methods.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_BackendOperation_Adapter_ICancellationAdapter{
	
	/**
	 * The invocation of this method cancels the given transaction.
	 *
	 * @throws Exception In case the cancellation fails, this method may throw an exception.
	 * @return void
	 */
	public function cancel(Customweb_Payment_Authorization_ITransaction $transaction);

}
