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

require_once 'Customweb/Unzer/Communication/Operation/DirectCharge/ResponseProcessor.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/I18n/Translation.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Operation_DirectCharge_PaymentInformationResponseProcessor extends Customweb_Unzer_Communication_Operation_DirectCharge_ResponseProcessor {

	protected function processCharge() {
		$this->processPaymentInformation($this->data);
		return parent::processCharge();
	}

	private function processPaymentInformation(array $data){
		if(!isset($data['processing'])) {
			throw new Exception("Processing not set.");
		}
		$paymentInformation = Customweb_I18n_Translation::__(
				"Please pay the amount of !amount !currency using the following bank data:<br/><b>Descriptor:</b> !descriptor<br/><b>Account Holder:</b> !holder<br/><b>IBAN:</b> !iban<br/><b>BIC:</b> !bic<br/>",
				array(
					'!amount' => Customweb_Util_Currency::formatAmount($this->transaction->getAuthorizationAmount(), $this->transaction->getCurrencyCode()),
					'!currency' => $this->transaction->getCurrencyCode(),
					'!descriptor' => $data['processing']['descriptor'],
					'!holder' => $data['processing']['holder'],
					'!iban' => $data['processing']['iban'],
					'!bic' => $data['processing']['bic']
				))->toString();
		$this->transaction->setPaymentInformation($paymentInformation);
	}
}