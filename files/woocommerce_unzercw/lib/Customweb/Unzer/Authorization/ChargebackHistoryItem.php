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

require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Unzer/Util/String.php';
require_once 'Customweb/Payment/Authorization/DefaultTransactionHistoryItem.php';


/**
 *
 * @author Sebastian Bossert
 */
final class Customweb_Unzer_Authorization_ChargebackHistoryItem extends Customweb_Payment_Authorization_DefaultTransactionHistoryItem {
	const ACTION = 'chargeback';

	public function __construct(array $chargeback){
		parent::__construct(
				Customweb_I18n_Translation::__("A chargeback with id @id has been received for @amount. Please review this transaction manually.",
						array(
							'@id' => Customweb_Unzer_Util_String::extractChargebackIdFromUrl($chargeback['url']),
							'@amount' => $chargeback['amount']
						)), self::ACTION);
	}
}