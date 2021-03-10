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

require_once 'Customweb/Unzer/Communication/Operation/AbstractItemsResponseProcessor.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Payment/Authorization/ITransactionRefund.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Operation_CancelCharge_RefundResponseProcessor extends Customweb_Unzer_Communication_Operation_AbstractItemsResponseProcessor {
	private $chargeId;

	public function __construct(Customweb_Unzer_Authorization_Transaction $transaction, array $items, $close, $chargeId, Customweb_DependencyInjection_IContainer $container){
		parent::__construct($transaction, $items, $close, $container);
		$this->chargeId = $chargeId;
	}

	public function process(Customweb_Core_Http_IResponse $response){
		$this->getLogger()->logInfo(__METHOD__);
		parent::process($response);
		$this->getLogger()->logInfo("Refunding line items", $this->items);
		/**
		 *
		 * @var Customweb_Unzer_Authorization_Refund $refund
		 */
		$refund = $this->transaction->refundByLineItems($this->items, $this->close, $this->getMessage());
		$refund->setCancelChargeId($this->data['id']);
		if ($this->data['isSuccess']) {
			$refund->setStatus(Customweb_Payment_Authorization_ITransactionRefund::STATUS_SUCCEED);
		}
		else if ($this->data['isPending']) {
			$refund->setStatus(Customweb_Payment_Authorization_ITransactionRefund::STATUS_PENDING);
		}
		$this->getLogger()->logInfo("Process Refund response complete.");
	}

	protected function getMessage(){
		return Customweb_I18n_Translation::__("Cancelling @amount for charge with id @id.",
				array(
					'@amount' => $this->data['amount'],
					'@id' => $this->chargeId
				));
	}

	protected function getValidResponseCodes(){
		return array(
			201
		);
	}
}