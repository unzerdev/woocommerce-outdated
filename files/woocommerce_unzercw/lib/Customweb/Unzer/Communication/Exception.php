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
require_once 'Customweb/Payment/Exception/PaymentErrorException.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Exception extends Customweb_Payment_Exception_PaymentErrorException {
	protected $codes = array();

	public function __construct(array $json){
		$error = $this->processErrorMessage($json);
		parent::__construct($error);
	}

	public function hasErrorCode($code){
		return in_array($code, $this->codes);
	}

	protected function processErrorMessage(array $json){
		$userMessages = array();
		$merchantMessages = array();
		if (is_array($json) && array_key_exists('errors', $json)) {
			foreach ($json['errors'] as $jsonError) {
				$userMessage = $this->processCustomerMessage($jsonError);
				$merchantMessage = $this->processMerchantMessage($jsonError);
				if (!in_array($userMessage, $userMessages)) {
					$userMessages[] = $userMessage;
				}
				if (!in_array($merchantMessage, $merchantMessages)) {
					$merchantMessages[] = $merchantMessage;
				}
			}
		}
		$merchantMessage = $userMessage = Customweb_I18n_Translation::__("The transaction failed for an unknown reason.");
		if (!empty($userMessages)) {
			$userMessage = implode(" ", $userMessages);
		}
		if (!empty($merchantMessages)) {
			$merchantMessage = implode(" ", $merchantMessages);
		}
		return new Customweb_Payment_Authorization_ErrorMessage($userMessage, $merchantMessage);
	}

	protected function processCustomerMessage(array $jsonError){
		if (isset($jsonError['customerMessage'])) {
			return $jsonError['customerMessage'];
		}
		return Customweb_I18n_Translation::__("An unknown error occurred.");
	}

	protected function processMerchantMessage(array $jsonError){
		$merchantMessage = '';
		if (isset($jsonError['merchantMessage'])) {
			$merchantMessage = $jsonError['merchantMessage'];
		}
		else {
			$merchantMessage = $this->processCustomerMessage($jsonError);
		}
		if (isset($jsonError['code'])) {
			$this->codes[] = $this->code = $jsonError['code'];
			$merchantMessage .= " " . Customweb_I18n_Translation::__("Code: '@code'", array(
				"@code" => $jsonError['code']
			));
		}
		return $merchantMessage;
	}
}