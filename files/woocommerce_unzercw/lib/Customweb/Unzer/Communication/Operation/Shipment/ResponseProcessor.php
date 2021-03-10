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

require_once 'Customweb/Unzer/Communication/AbstractTransactionProcessor.php';
require_once 'Customweb/Payment/Authorization/ErrorMessage.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Util/Invoice.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Operation_Shipment_ResponseProcessor extends Customweb_Unzer_Communication_AbstractTransactionProcessor {
	private $items;

	public function __construct(Customweb_Unzer_Authorization_Transaction $transaction, $items, $container){
		parent::__construct($transaction, $container);
		$this->items = $items;
	}

	public function process(Customweb_Core_Http_IResponse $response){
		try {
			$this->getLogger()->logDebug("Processing shipment");
			parent::process($response);
			$capture = $this->transaction->partialCaptureByLineItems($this->items,
					Customweb_I18n_Translation::__("Shipment created over @amount.",
							array(
								'@amount' => Customweb_Util_Invoice::getTotalAmountIncludingTax($this->items)
							)));
			$capture->setChargeId($this->transaction->getUnzChargeId()); // for refund mapping
		}
		catch (Exception $e) {
			$this->getLogger()->logException($e);
			$this->transaction->addErrorMessage(
					new Customweb_Payment_Authorization_ErrorMessage(
							Customweb_I18n_Translation::__('@prepend: @error',
									array(
										'@prepend' => $this->getFailedMessage(),
										'@error' => $e->getMessage()
									))));
			throw $e;
		}
	}

	private function getFailedMessage(){
		return Customweb_I18n_Translation::__("Processing shipment failed");
	}

	protected function getValidResponseCodes(){
		return array(
			201
		);
	}
}