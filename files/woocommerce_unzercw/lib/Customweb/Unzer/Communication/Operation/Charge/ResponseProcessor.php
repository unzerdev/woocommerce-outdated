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
require_once 'Customweb/Unzer/Communication/Operation/AbstractItemsResponseProcessor.php';
require_once 'Customweb/Payment/Authorization/ITransactionHistoryItem.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Payment/Authorization/DefaultTransactionHistoryItem.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Operation_Charge_ResponseProcessor extends Customweb_Unzer_Communication_Operation_AbstractItemsResponseProcessor {

	public function process(Customweb_Core_Http_IResponse $response){
		parent::process($response);
		try {
			$this->processCharge();
			return $this->transaction->getSuccessUrl();
		}
		catch (Exception $e) {
			$this->saveException($e);
			throw $e;
		}
	}

	protected function processCharge(){
		if ($this->getPaymentMethodByTransaction($this->transaction)->isShipmentSupported()) {
			$this->chargeWithoutCapture();
		}
		else {
			$this->chargeWithCapture();
		}
	}

	protected function chargeWithoutCapture(){
		$this->getLogger()->logDebug(__METHOD__, $this->data);
		$this->transaction->setUnzChargeId($this->data['id']); // if shipment is supported, our capture process should create a shipment
		$this->transaction->addHistoryItem(
				new Customweb_Payment_Authorization_DefaultTransactionHistoryItem(
						Customweb_I18n_Translation::__("Charge @id over @amount was created.",
								array(
									'@id' => $this->data['id'],
									'@amount' => $this->data['amount']
								)), Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_CAPTURING));
	}

	protected function chargeWithCapture(){
		$this->getLogger()->logDebug("start capture");
		$capture = $this->transaction->partialCaptureByLineItems($this->items, $this->close);
		$capture->setChargeId($this->data['id']);
		if ($this->data['isSuccess']) {
			$capture->setStatus(Customweb_Payment_Authorization_ITransactionCapture::STATUS_SUCCEED);
		}
		else if ($this->data['isPending']) {
			$capture->setStatus(Customweb_Payment_Authorization_ITransactionCapture::STATUS_PENDING);
		}
		$this->getLogger()->logDebug("capture complete");
	}

	protected function getValidResponseCodes(){
		return array(
			201
		);
	}
}