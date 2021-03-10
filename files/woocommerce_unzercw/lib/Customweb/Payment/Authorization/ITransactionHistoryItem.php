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

require_once 'Customweb/I18n/LocalizableString.php';

/**
 * The history item describes a state of the transaction. 
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_Authorization_ITransactionHistoryItem {

	const ACTION_LOG = 'log';
	const ACTION_AUTHORIZATION = 'authorization';
	const ACTION_CAPTURING = 'capturing';
	const ACTION_CANCELLATION = 'cancellation';
	const ACTION_REFUND = 'refund';

	/**
	 * The message which describes this history item.
	 * 
	 * @return Customweb_I18n_LocalizableString
	 */
	public function getMessage();

	/**
	 * The action that is performed. The action can be one of:
	 * <ul>
	 *   <li>Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_AUTHORIZATION</li>
	 *   <li>Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_CAPTURING</li>
	 *   <li>Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_CANCELLATION</li>
	 *   <li>Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_REFUND</li>
	 * </ul>
	 * 
	 * @return string
	 */
	public function getActionPerformed();
	
	/**
	 * The date on which the history item was created.
	 * 
	 * @return DateTime
	 */
	public function getCreationDate();

}