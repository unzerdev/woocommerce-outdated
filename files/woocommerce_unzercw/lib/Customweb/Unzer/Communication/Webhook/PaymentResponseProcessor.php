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

require_once 'Customweb/Unzer/Communication/Type/RetrieveRequestBuilder.php';
require_once 'Customweb/Payment/Authorization/ITransactionHistoryItem.php';
require_once 'Customweb/Unzer/Util/Transaction.php';
require_once 'Customweb/Unzer/Util/String.php';
require_once 'Customweb/Payment/Authorization/DefaultTransactionHistoryItem.php';
require_once 'Customweb/Util/Invoice.php';
require_once 'Customweb/Unzer/Communication/Type/ResponseProcessor.php';
require_once 'Customweb/Unzer/Communication/Processor/DefaultProcessor.php';
require_once 'Customweb/Unzer/Communication/AbstractTransactionProcessor.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/I18n/Translation.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Webhook_PaymentResponseProcessor extends Customweb_Unzer_Communication_AbstractTransactionProcessor {
	const STATE_PENDING = 0;
	const STATE_COMPLETED = 1;
	const STATE_CANCELED = 2;
	const STATE_PARTLY = 3;
	const STATE_REVIEW = 4;
	const STATE_CHARGEBACK = 5;
	const TRANSACTION_TYPE_AUTHORIZE = 'authorize';
	const TRANSACTION_TYPE_CANCEL_AUTHORIZE = 'cancel-authorize';
	const TRANSACTION_TYPE_CHARGE = 'charge';
	const TRANSACTION_TYPE_CANCEL_CHARGE = 'cancel-charge';
	const TRANSACTION_TYPE_CHARGEBACK = 'chargeback';
	const TRANSACTION_STATE_SUCCESS = 'success';
	private $callAdapter = true;

	public function process(Customweb_Core_Http_IResponse $response){
		try {
			parent::process($response);
			$this->processTransactions();
			$this->processState();

			if ($this->transaction->isCaptured()) {
				$this->getLogger()->logDebug('Transaction is captured, updating type information');
				$requestBuilder = new Customweb_Unzer_Communication_Type_RetrieveRequestBuilder($this->transaction,
						$this->getContainer());
				$responseProcessor = new Customweb_Unzer_Communication_Type_ResponseProcessor($this->transaction, $this->getContainer());
				$processor = new Customweb_Unzer_Communication_Processor_DefaultProcessor($requestBuilder, $responseProcessor,
						$this->getContainer());
				$processor->process();
			}
			else {
				$this->getLogger()->logDebug('Transaction is not captured yet');
			}
		}
		catch (Exception $e) {
			$this->fail($e->getMessage());
			return $this->transaction->getFailedUrl();
		}
	}

	protected function processTransactions(){
		if (isset($this->data['transactions'])) {
			foreach ($this->data['transactions'] as $transaction) {
				switch ($transaction['type']) {
					case self::TRANSACTION_TYPE_AUTHORIZE:
						$this->processAuthorize($transaction);
						break;
					case self::TRANSACTION_TYPE_CHARGE:
						$this->processCharge($transaction);
						break;
					case self::TRANSACTION_TYPE_CANCEL_CHARGE:
						$this->processCancelCharge($transaction);
						break;
					case self::TRANSACTION_TYPE_CANCEL_AUTHORIZE:
						$this->processCancelAuthorize($transaction);
						break;
					case self::TRANSACTION_TYPE_CHARGEBACK:
						$this->processChargeback($transaction);
						break;
				}
			}
		}
	}

	protected function processAuthorize($transaction){
		$this->getLogger()->logDebug("processAuthorize called", $transaction);
		if ($this->transaction->isAuthorized()) {
			$this->getLogger()->logDebug("transaction already authorized, skipping");
			return;
		}
		$id = Customweb_Unzer_Util_String::extractAuthorizeIdFromUrl($transaction['url']);
		if ($transaction['status'] === self::TRANSACTION_STATE_SUCCESS) {
			$this->getLogger()->logDebug("authorizing transaction");
			$this->transaction->setUnzAuthorizationId($id);
			$this->transaction->authorize('', $this->getPaymentMethodByTransaction($this->transaction)->isAuthorizePaid());
			$this->callAdapter = false;
		}
	}

	protected function processNewCapture($id, $transaction){
		$this->getLogger()->logDebug("creating new capture");
		try {
			$this->transaction->partialCaptureDry($transaction['amount']);
			$capture = $this->transaction->partialCapture($transaction['amount']);
			if ($this->callAdapter) {
				$this->getLogger()->logDebug("calling capture adapter");
				$this->getContainer()->getShopCaptureAdapter()->partialCapture($this->transaction, $capture->getCaptureItems(),
						!$this->transaction->isCapturePossible());
			}
			/** @var $capture Customweb_Unzer_Authorization_Capture */
			$capture->setChargeId($id);
			return $capture;
		}
		catch (Exception $e) {
			$this->getLogger()->logException($e, $transaction);
			$this->transaction->addHistoryItem(
					new Customweb_Payment_Authorization_DefaultTransactionHistoryItem(
							Customweb_I18n_Translation::__("Creating new charge failed: @message.", array(
								'@message' => $e->getMessage()
							)), Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_LOG));
		}
		return null;
	}

	protected function processUnmappedCharge($id, array $transaction, $isNewCharge){
		if (!$this->getPaymentMethodByTransaction($this->transaction)->isDeferredCapturingActive() && !$this->transaction->isAuthorized()) {
			$this->getLogger()->logDebug("authorizing direct charge");
			$this->transaction->authorize();
		}
		if (!$this->transaction->isCaptured() &&
				Customweb_Util_Currency::compareAmount($this->transaction->getCapturableAmount(), $transaction['amount'],
						$this->transaction->getCurrencyCode()) === 1) {
			$capture = $this->processNewCapture($id, $transaction);
		}
		else {
			$capture = Customweb_Unzer_Util_Transaction::getCaptureByAmount($this->transaction, $transaction['amount']);
			if ($capture) {
				$capture->setChargeId($id);
			}
			else if ($isNewCharge) { // only add once
				$this->addChargeReceivedMessage($id, $transaction);
			}
		}
	}

	protected function processCharge($transaction){
		$this->getLogger()->logDebug("processCharge called", $transaction);
		$isNewCharge = $this->transaction->processCharge($transaction);
		$id = Customweb_Unzer_Util_String::extractChargeIdFromUrl($transaction['url']);
		$capture = Customweb_Unzer_Util_Transaction::getCaptureByChargeId($this->transaction, $id);
		if ($capture === null && $this->isCreateCapture($transaction)) {
			$this->processUnmappedCharge($id, $transaction, $isNewCharge);
		}
		if ($capture) {
			$this->getLogger()->logDebug("setting capture status");
			$capture->setStatus(Customweb_Unzer_Util_Transaction::mapCaptureStatus($transaction['status']));
		}
	}

	protected function addChargeReceivedMessage($id, array $transaction){
		$this->transaction->addHistoryItem(
				new Customweb_Payment_Authorization_DefaultTransactionHistoryItem(
						Customweb_I18n_Translation::__("Charge @id for @amount received and processed.",
								array(
									'@id' => $id,
									'@amount' => $transaction['amount']
								)), Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_LOG));
	}

	protected function isCreateCapture($transaction){
		$paymentMethod = $this->getPaymentMethodByTransaction($this->transaction);
		return !$paymentMethod->isShipmentSupported() && // do not create captures if capture should create shipments
				($transaction['status'] === self::TRANSACTION_STATE_SUCCESS ||
				($transaction['status'] == 'pending' && $paymentMethod->isCreatePendingCapture()));
	}

	protected function processCancelCharge($transaction){
		$this->getLogger()->logDebug("processCancelCharge called", $transaction);
		if (!$this->transaction->isCaptured()) {
			$this->getLogger()->logDebug("not captured, cancelling auth directly (skipping pending / failed charge step)");
			$this->processCancelAuthorize($transaction); // pending capture was not created, do normal cancellation process
			return;
		}
		$chargeId = Customweb_Unzer_Util_String::extractChargeIdFromUrl($transaction['url']);
		$cancelId = Customweb_Unzer_Util_String::extractCancelIdFromUrl($transaction['url']);
		if (empty($chargeId) || empty($cancelId)) {
			$this->getLogger()->logError("Unable to process cancel charge", $transaction);
			return;
		}
		if ($this->transaction->isProcessed($cancelId)) {
			$this->getLogger()->logInfo("Already processed $cancelId, skipping");
			return;
		}
		$refund = Customweb_Unzer_Util_Transaction::getRefundByCancelChargeId($this->transaction, $cancelId);
		if ($refund == null) {
			$this->getLogger()->logDebug("creating new refund");
			$refund = $this->transaction->refund($transaction['amount']);
			$refund->setCancelChargeId($cancelId);
			if ($this->callAdapter) {
				$this->getLogger()->logDebug("calling refund adapter");
				$this->getContainer()->getShopRefundAdapter()->partialRefund($this->transaction, $refund->getRefundItems(),
						!$this->transaction->isRefundPossible());
			}
		}
		$refund->setStatus(Customweb_Unzer_Util_Transaction::mapRefundStatus($transaction['status']));
	}

	protected function processCancelAuthorize($transaction){
		$this->getLogger()->logDebug("processCancelAuthorize called", $transaction);
		$cancelId = Customweb_Unzer_Util_String::extractCancelIdFromUrl($transaction['url']);
		if (!$this->transaction->isProcessed($cancelId)) {
			$this->getLogger()->logDebug("processing new cancel");
			$this->transaction->addProcessed($cancelId);
			if (Customweb_Util_Currency::compareAmount($transaction['amount'], $this->transaction->getAuthorizationAmount(),
					$this->transaction->getCurrencyCode()) === 0) {
				$this->transaction->cancel();
				if ($this->callAdapter) {
					$this->getContainer()->getShopCancelAdapter()->cancel($this->transaction);
				}
			}
		}
	}

	protected function processChargeback($transaction){
		$this->getLogger()->logDebug("processChargeback called", $transaction);
		$this->transaction->addChargeback($transaction);
		$this->chargeback();
	}

	/**
	 * Backup to ensure state is correct if transactions could not be processed correctly.
	 */
	protected function processState(){
		switch ($this->data['state']['id']) {
			case self::STATE_PENDING:
				$this->pending();
				break;
			case self::STATE_COMPLETED:
				$this->capture();
				break;
			case self::STATE_CANCELED:
				$this->fail();
				break;
			case self::STATE_PARTLY:
				$this->partialCapture();
				break;
			case self::STATE_REVIEW:
				$this->review();
				break;
			case selF::STATE_CHARGEBACK:
				$this->chargeback();
				break;
		}
	}

	protected function pending(){
		$paymentMethod = $this->getPaymentMethodByTransaction($this->transaction);
		if ($paymentMethod->isPendingAuthorization()) {
			$this->authorize(Customweb_I18n_Translation::__("The transaction is pending."),
					$this->getPaymentMethodByTransaction($this->transaction)->isPendingAuthorizePaid());
			if ($paymentMethod->isPendingUncertain()) {
				$this->transaction->setAuthorizationUncertain(true);
			}
		}
	}

	protected function authorize($message = ''){
		if ($this->transaction->isAuthorized()) {
		}
		else if ($this->transaction->isAuthorizationFailed()) {
			$this->transaction->addHistoryItem(
					new Customweb_Payment_Authorization_DefaultTransactionHistoryItem(
							Customweb_I18n_Translation::__("Transaction was authorized, but is already failed in store."),
							Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_LOG));
		}
		else {
			$this->transaction->authorize($message, $this->getPaymentMethodByTransaction($this->transaction)->isAuthorizePaid());
			$this->callAdapter = false;
		}
		$this->transaction->setAuthorizationUncertain(false);
	}

	protected function capture(){
		$this->getLogger()->logDebug(__METHOD__);
		$this->authorize();
		if ($this->transaction->isApiCapturePossible()) {
			/**
			 *
			 * @var Customweb_Unzer_Authorization_Capture $capture
			 */
			$capture = $this->transaction->capture();
			foreach ($this->data['transactions'] as $transaction) {
				if ($transaction['type'] === self::TRANSACTION_TYPE_CHARGE) {
					if ($transaction['status'] === self::TRANSACTION_STATE_SUCCESS &&
							Customweb_Util_Currency::compareAmount($transaction['amount'], $capture->getAmount(),
									$this->transaction->getCurrencyCode()) === 0) {
						$chargeId = Customweb_Unzer_Util_String::extractChargebackIdFromUrl($transaction['url']);
						$capture->setChargeId($chargeId);
					}
				}
			}
			if ($capture->getChargeId() == null) {
				$capture->setChargeId($this->transaction->getUnzChargeId());
			}
			if ($this->callAdapter) {
				$this->getContainer()->getShopCaptureAdapter()->capture($this->transaction);
			}
		}
		else if (!$this->transaction->isCaptured()) {
			$this->transaction->addHistoryItem(
					new Customweb_Payment_Authorization_DefaultTransactionHistoryItem(
							Customweb_I18n_Translation::__(
									"Transaction was captured in Unzer, but cannot be captured in store."),
							Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_LOG));
		}
		$this->transaction->setPaid($this->getPaymentMethodByTransaction($this->transaction)->isCompletedPaid());
	}

	protected function partialCapture(){
		$this->authorize();
		$this->transaction->addHistoryItem(
				new Customweb_Payment_Authorization_DefaultTransactionHistoryItem(
						Customweb_I18n_Translation::__("Transaction is in state partial capture."),
						Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_LOG));
	}

	protected function fail($message = null){
		if ($this->transaction->isAuthorized()) {
			$nonRefunded = $this->transaction->getNonRefundedLineItems();
			$totalNonRefunded = Customweb_Util_Invoice::getTotalAmountIncludingTax($nonRefunded);
			if ($this->transaction->isAuthorizationUncertain()) {
				$this->transaction->setUncertainTransactionFinallyDeclined();
			}
			if ($this->transaction->isApiCancelPossible()) {
				$this->transaction->cancel($message);
				if ($this->callAdapter) {
					$this->getContainer()->getShopCancelAdapter()->cancel($this->transaction);
				}
			}
			else if ($this->transaction->isApiRefundPossible()) {
				$this->transaction->refundByLineItems($nonRefunded, true, $message);
				if ($this->callAdapter) {
					$this->getContainer()->getShopRefundAdapter()->partialRefund($this->transaction, $nonRefunded, true);
				}
			}
			else if (!$this->transaction->isUncertainTransactionFinallyDeclined() && !$this->transaction->isCancelled() &&
					Customweb_Util_Currency::compareAmount($totalNonRefunded, 0, $this->transaction->getCurrencyCode()) !== 0) { // not cancelled, and still items not refunded.
				$this->getLogger()->logDebug("Unable to cancel not possible, not cancelled, not refundable, open items:", $nonRefunded);
				if (empty($message)) {
					$message = Customweb_I18n_Translation::__(
							"Transaction was cancelled or refunded, but status change cannot be reflected in store.");
				}
				$this->transaction->addHistoryItem(
						new Customweb_Payment_Authorization_DefaultTransactionHistoryItem($message,
								Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_LOG));
			}
		}
		else if (!$this->transaction->isAuthorizationFailed()) {
			if (empty($message)) {
				$message = Customweb_I18n_Translation::__("The transaction was cancelled.");
			}
			$this->transaction->setAuthorizationFailed($message);
		}
		$this->transaction->setPaid(false);
	}

	protected function review(){
		$this->transaction->setAuthorizationUncertain(true);
		$this->transaction->addHistoryItem(
				new Customweb_Payment_Authorization_DefaultTransactionHistoryItem(
						Customweb_I18n_Translation::__("Transaction should be manually reviewed."),
						Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_LOG));
	}

	protected function chargeback(){
		$this->transaction->setAuthorizationUncertain(true);
		$this->transaction->setPaid(false);
	}

	protected function getValidResponseCodes(){
		return array(
			200
		);
	}
}