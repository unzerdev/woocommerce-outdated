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

require_once 'Customweb/Core/String.php';


/**
 * Util methods
 * 
 * @author Sebastian Bossert
 */
final class Customweb_Unzer_Util_String {

	private function __construct(){}

	/**
	 * Simple Schema applier which supports externalTransactionId, orderId and transactionId. No maximum length.
	 * @param string $schema
	 * @param Customweb_Unzer_Authorization_Transaction $transaction
	 * @return string
	 */
	public static function applySchema($schema, Customweb_Unzer_Authorization_Transaction $transaction){
		return str_replace(array(
			"{id}",
			"{oid}",
			"{tid}"
		), array(
			$transaction->getExternalTransactionId(),
			$transaction->getTransactionContext()->getOrderId(),
			$transaction->getTransactionId()
		), $schema);
	}
	
	/**
	 * Clean phone number according to unzer restrictions.
	 * 
	 * @param string $number
	 * @return mixed
	 */
	public static function cleanPhone($number) {
		return self::substr(preg_replace('/[^0-9+]+/', '', $number), 20);
	}

	/**
	 * Helper method to cut string to length.
	 * 
	 * @param string $str
	 * @param int $length
	 * @return string
	 */
	public static function substr($str, $length){
		return Customweb_Core_String::_($str)->substring(0, $length)->toString();
	}
	
	public static function extractPaymentIdFromUrl($url) {
		return self::extractPattern($url, '/s-pay-[0-9]*/');
	}
	
	public static function extractChargeIdFromUrl($url) {
		return self::extractPattern($url, '/s-chg-[0-9]*/');
	}
	
	public static function extractCancelIdFromUrl($url) {
		return self::extractPattern($url, '/s-cnl-[0-9]*/');
	}
	
	public static function extractAuthorizeIdFromUrl($url) {
		return self::extractPattern($url, '/s-aut-[0-9]*/');
	}
	
	public static function extractChargebackIdFromUrl($url) {
		return self::extractPattern($url, '/s-cbk-[0-9]*/');
	}
	
	private static function extractPattern($target, $pattern, $default = null) {
		$matches = array();
		$res = preg_match($pattern, $target, $matches);
		if($res) {
			return $matches[0];
		}
		return $default;
	}
}
