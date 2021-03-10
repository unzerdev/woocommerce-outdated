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

require_once 'Customweb/Payment/Authorization/ITransactionCapture.php';
require_once 'Customweb/Unzer/Communication/Operation/Authorize/ResponseProcessor.php';
require_once 'Customweb/Unzer/Util/Message.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Operation_DirectCharge_ResponseProcessor extends Customweb_Unzer_Communication_Operation_Authorize_ResponseProcessor {

	public function process(Customweb_Core_Http_IResponse $response){
		$result = parent::process($response);
		if (!$this->transaction->isAuthorizationFailed()) {
			$this->processCharge();
		}
		return $result;
	}

	protected function processCharge(){
		$this->getLogger()->logDebug(__METHOD__);
		$paymentMethod = $this->getPaymentMethodByTransaction($this->transaction);
		if (!$paymentMethod->isShipmentSupported()) {
			if ($this->data['isSuccess']) {
				return $this->createCapture();
			}
			else if ($this->data['isPending'] && $paymentMethod->isCreatePendingCapture()) {
				$capture = $this->createCapture();
				$capture->setStatus(Customweb_Payment_Authorization_ITransactionCapture::STATUS_PENDING);
				return $capture;
			}
		}
	}

	protected function createCapture(){
		$this->getLogger()->logDebug(__METHOD__);
		if (!$this->transaction->isAuthorized()) {
			$this->transaction->authorize();
		}
		$capture = $this->transaction->capture(Customweb_Unzer_Util_Message::getCustomerMessage($this->data));
		$capture->setChargeId($this->data['id']);
		return $capture;
	}

	protected function setPaymentId(array $data){
		$this->getLogger()->logDebug(__METHOD__, $data);
		$this->transaction->setUnzChargeId($data['id']);
	}
}