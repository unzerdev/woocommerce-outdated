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

require_once 'Customweb/Payment/Authorization/ITransactionHistoryItem.php';
require_once 'Customweb/Date/DateTime.php';

/**
 * The history item describes a state of the transaction. 
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_Authorization_DefaultTransactionHistoryItem implements Customweb_Payment_Authorization_ITransactionHistoryItem {
	
	private $message;
	private $action;
	private $date;
	
	public function __construct($message, $action) {
		if ($message instanceof Customweb_Payment_Authorization_IErrorMessage) {
			$this->message = $message->getBackendMessage();
		}
		else if (is_string($message)) {
			$this->message = new Customweb_I18n_LocalizableString($message);
		}
		else {
			$this->message = $message;
		}
		$this->action = $action;
		$this->date = new Customweb_Date_DateTime();
	}
	
	public function getMessage() {
		return $this->message;
	}
	
	public function getActionPerformed() {
		return $this->action;
	}
	
	public function getCreationDate()
	{
		return $this->date;
	}
	
}