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
require_once 'Customweb/Unzer/Method/Default.php';


/**
 *
 * @author Sebastian Bossert
 * @Method(paymentMethods={'creditcard'})
 */
class Customweb_Unzer_Method_CreditCard extends Customweb_Unzer_Method_Default {

	public function getRequiredPlaceholders(){
		return array(
			'number' => Customweb_I18n_Translation::__("Card Number"),
			'expiry' => Customweb_I18n_Translation::__("Expiry Date"),
			'cvc' => Customweb_I18n_Translation::__("CVC")
		);
	}

	public function processTypeData(Customweb_Unzer_Authorization_Transaction $transaction, array $type){
		parent::processTypeData($transaction, $type);
		if ($transaction->getTransactionContext()->createRecurringAlias()) {
			if (isset($type['recurring']) && $type['recurring'] && isset($type['number'])) {
				$transaction->setAliasForDisplay($type['number']);
			}
		}
		if (isset($type['method']) && $type['method'] == 'card') {
			if (isset($type['number'])) {
				$transaction->addLabel(Customweb_I18n_Translation::__("Card Number"), $type['number']);
			}
			if (isset($type['brand'])) {
				$transaction->addLabel(Customweb_I18n_Translation::__("Card Brand"), $type['brand']);
			}
			if (isset($type['expiryDate'])) {
				$transaction->addLabel(Customweb_I18n_Translation::__("Card Expiry"), $type['expiryDate']);
			}
			$threed = isset($type['3ds']) ? Customweb_I18n_Translation::__("Yes") : Customweb_I18n_Translation::__("No");
			$transaction->addLabel(Customweb_I18n_Translation::__("Card 3Ds"), $threed);
		}
	}
}
