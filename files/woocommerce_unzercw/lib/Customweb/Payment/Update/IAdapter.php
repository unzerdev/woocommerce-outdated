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
 * This interface defines an adapter which is used for pull updates. 
 * 
 * There are two cases when this adapter is used to execute a update:
 * <ul>
 *   <li>A manual update triggered by the merchant.</li>
 *   <li>The transaction is marked for updating. See Customweb_Payment_Authorization_ITransaction::getUpdateExecutionDate()</li>
 * </ul>
 * 
 * For both use cases this adapter is invoked. To work with this adapter 
 * the feature 'Update' must be supported. The adapter must appear in the 
 * container.
 * 
 * Any other kind of update triggered by external entities has to be
 * realized by endpoints.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_Update_IAdapter {

	/**
	 * This method updates the transaction. The method may invoke a remote webservice to 
	 * update the state of the transaction.
	 * 
	 * In case the method the executed update must be confirmed in a two phase mode, than
	 * the Customweb_Payment_ITransactionHandler should be used to coordinate the database
	 * transaction accordingly.
	 * 
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @return void
	 */
	public function updateTransaction(Customweb_Payment_Authorization_ITransaction $transaction);
	
}