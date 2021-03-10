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

require_once 'Customweb/Payment/Authorization/ErrorMessage.php';
require_once 'Customweb/I18n/Translation.php';


/**
 * Util to extract messages from response.
 *
 * @author sebastian
 *
 */
class Customweb_Unzer_Util_Message {

	private function __construct(){}

	public static function getCustomerMessage(array $json, $default = ''){
		if (isset($json['message']) && isset($json['message']['customer'])) {
			return $json['message']['customer'];
		}
		return $default;
	}
	
	public static function prependToError(Customweb_I18n_ILocalizableString $text, Customweb_Payment_Authorization_ErrorMessage $errorMessage){
		return new Customweb_Payment_Authorization_ErrorMessage(
				Customweb_I18n_Translation::__('@prepend: @error', array(
					'@prepend' => $text,
					'@error' => $errorMessage->getUserMessage()
				)), Customweb_I18n_Translation::__('@prepend: @error', array(
					'@prepend' => $text,
					'@error' => $errorMessage->getBackendMessage()
				)));
	}
}