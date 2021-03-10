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

require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Unzer/Method/Default.php';
require_once 'Customweb/Util/Invoice.php';


/**
 *
 * @author Sebastian Bossert
 * @Method(paymentMethods={'OpenInvoice'})
 */
class Customweb_Unzer_Method_ReceiptMethod extends Customweb_Unzer_Method_Default {

	public function refund(Customweb_Unzer_Authorization_Transaction $transaction, array $items, $close){
		$this->refundOnCharges($transaction, $items, $close);
	}

	protected function refundOnCharges(Customweb_Unzer_Authorization_Transaction $transaction, array $items, $close){
		$this->getLogger()->logInfo("Process refunds start.");
		$transaction->refundByLineItemsDry($items, $close);
		$restToRefund = Customweb_Util_Invoice::getTotalAmountIncludingTax($items);
		$restItemsToRefund = $items;
		$currency = $transaction->getCurrencyCode();
		$cancelCharges = array();

		foreach ($transaction->getCharges() as $id => $charge) { // map refunds to charges instead of captures
			if (Customweb_Util_Currency::compareAmount($restToRefund, 0, $currency) === 1 && $charge['status'] === 'success') {
				$cancelCharge = $this->getRefundByCharge($transaction, $id, $charge, $restItemsToRefund, $restToRefund, $close);
				if ($cancelCharge) {
					$restItemsToRefund = Customweb_Util_Invoice::getResultingLineItemsByDeltaItems($restItemsToRefund, $cancelCharge['items']);
					$restToRefund = Customweb_Util_Currency::roundAmount($restToRefund - $cancelCharge['amount'], $currency);
					$cancelCharges[] = $cancelCharge;
				}
			}
		}

		$this->getLogger()->logInfo("Cancelling charges as following.", $cancelCharges);

		foreach ($cancelCharges as $cancelCharge) {
			$this->processCancelCharge($transaction, $cancelCharge['charge'], $cancelCharge['items'], $cancelCharge['close']);
			$transaction->cancelCharge($cancelCharge['charge'], $cancelCharge['amount']);
		}

		$this->processUnrefundedAmount($transaction, $restToRefund);
		$this->getLogger()->logInfo("Process refunds complete");
	}

	protected function getRefundByCharge(Customweb_Unzer_Authorization_Transaction $transaction, $id, array $charge, array $restItemsToRefund, $restToRefund, $close){
		$available = $charge['amount'];
		if (isset($charge['cancelled'])) {
			$available -= $charge['cancelled'];
		}
		if (Customweb_Util_Currency::compareAmount($available, 0, $transaction->getCurrencyCode()) <= 0) {
			return null;
		}
		$amountToRefund = $restToRefund;
		if (Customweb_Util_Currency::compareAmount($restToRefund, $available, $transaction->getCurrencyCode()) === 1) {
			$amountToRefund = $available;
		}
		$amountToRefund = Customweb_Util_Currency::roundAmount($amountToRefund, $transaction->getCurrencyCode());
		$refundItems = Customweb_Util_Invoice::getItemsByReductionAmount($restItemsToRefund, $amountToRefund, $transaction->getCurrencyCode());

		return array(
			'charge' => $id,
			'amount' => $amountToRefund,
			'items' => $refundItems,
			'close' => Customweb_Util_Currency::compareAmount($amountToRefund, 0, $transaction->getCurrencyCode()) === 0 && $close
		);
	}
}