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

require_once 'Customweb/I18n/Translation.php';


final class Customweb_Payment_Update_Util {
	
	private function __construct() {
		
	}
	
	public static function handlePendingTransaction(Customweb_Payment_Authorization_DefaultTransaction $transaction, $timeout, $interval) {
		$transaction->setUpdateExecutionDate(null);
		if (!$transaction->isAuthorized() && !$transaction->isAuthorizationFailed()) {
			$diff = time() - $transaction->getCreatedOn()->getTimestamp();
			if ($diff > $timeout) {
				$transaction->setAuthorizationFailed(Customweb_I18n_Translation::__("The customer does not finish the payment with in the timeout."));
			}
			else {
				$date = new DateTime();
				$date->setTimestamp(time() + $interval);
				$transaction->setUpdateExecutionDate($date);
			}
		}
	}
	
}
