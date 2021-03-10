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



/**
 * Webhook util class
 *
 * @author sebastian
 *
 */
class Customweb_Unzer_Util_Webhook {
	const KEY_PREFIX = 'webhook-all-';

	private function __construct(){}

	/**
	 * Does this fit somewhere else better?
	 *
	 * @param Customweb_Unzer_Method_Default $paymentMethod
	 * @return string
	 */
	public static function getStorageKey(Customweb_Unzer_Method_Default $paymentMethod){
		return self::KEY_PREFIX . ($paymentMethod->getPublicKey());
	}
}