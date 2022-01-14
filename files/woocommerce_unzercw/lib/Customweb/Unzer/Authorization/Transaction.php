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

require_once 'Customweb/Unzer/Authorization/Capture.php';
require_once 'Customweb/Unzer/Authorization/ChargebackHistoryItem.php';
require_once 'Customweb/Payment/Authorization/ITransactionCapture.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Unzer/Authorization/Refund.php';
require_once 'Customweb/Unzer/Util/String.php';
require_once 'Customweb/Unzer/Authorization/Cancel.php';
require_once 'Customweb/Payment/Authorization/Recurring/IAdapter.php';
require_once 'Customweb/Payment/Authorization/DefaultTransaction.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Authorization_Transaction extends Customweb_Payment_Authorization_DefaultTransaction {
	private $unzAuthorizationId;
	private $unzPaymentId;
	private $unzChargeId;
	private $unzBasketId;
	private $unzCustomerId;
	private $unzMetadataId;
	private $unzTypeId;
	private $unzTraceId;
	private $unzErrorId;

	// processing ids
	private $uniqueId;
	private $shortId;
	private $traceId;
	private $redirectUrl;
	private $formData;

	/**
	 * Custom transaction labels which can be added to via addLabel() method
	 *
	 * @var array
	 */
	private $transactionLabels = array();

	/**
	 *
	 * @var string
	 */
	private $paymentInformation;
	private $refundSupported = false;
	private $captureSupported = false;
	private $partialCaptureSupported = false;
	private $cancelSupported = false;
	private $cancelPendingChargeSupported = false;

	/**
	 * List containing all events which were processed but could not be automatically mapped, to prevent duplicate messages.
	 *
	 * @var array
	 */
	private $processedIds = array();

	/**
	 * Array containing all succesfull chargebacks
	 */
	private $chargebacks = array();

	/**
	 *
	 * @return boolean
	 */
	public function getCancelPendingChargeSupported(){
		return $this->cancelPendingChargeSupported;
	}

	/**
	 *
	 * @param boolean $cancelPendingChargeSupported
	 */
	public function setCancelPendingChargeSupported($cancelPendingChargeSupported){
		$this->cancelPendingChargeSupported = $cancelPendingChargeSupported;
	}

	/**
	 *
	 * @return boolean
	 */
	public function getPartialCaptureSupported(){
		return $this->partialCaptureSupported;
	}

	public function isCaptureClosable(){
		return $this->getPartialCaptureSupported();
	}

	/**
	 *
	 * @param boolean $partialCaptureSupported
	 */
	public function setPartialCaptureSupported($partialCaptureSupported){
		$this->partialCaptureSupported = $partialCaptureSupported;
	}

	/**
	 *
	 * @return boolean
	 */
	public function getRefundSupported(){
		return $this->refundSupported;
	}

	/**
	 *
	 * @return boolean
	 */
	public function getCaptureSupported(){
		return $this->captureSupported;
	}

	/**
	 *
	 * @return boolean
	 */
	public function getCancelSupported(){
		return $this->cancelSupported;
	}

	/**
	 *
	 * @param boolean $refundSupported
	 */
	public function setRefundSupported($refundSupported){
		$this->refundSupported = $refundSupported;
	}

	/**
	 *
	 * @param boolean $captureSupported
	 */
	public function setCaptureSupported($captureSupported){
		$this->captureSupported = $captureSupported;
	}

	/**
	 *
	 * @param boolean $cancelSupported
	 */
	public function setCancelSupported($cancelSupported){
		$this->cancelSupported = $cancelSupported;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getFormData(){
		return $this->formData;
	}

	/**
	 *
	 * @param mixed $formData
	 */
	public function setFormData($formData){
		$this->formData = $formData;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getUniqueId(){
		return $this->uniqueId;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getShortId(){
		return $this->shortId;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getTraceId(){
		return $this->traceId;
	}

	/**
	 *
	 * @param mixed $uniqueId
	 */
	public function setUniqueId($uniqueId){
		$this->uniqueId = $uniqueId;
	}

	/**
	 *
	 * @param mixed $shortId
	 */
	public function setShortId($shortId){
		$this->shortId = $shortId;
	}

	/**
	 *
	 * @param mixed $traceId
	 */
	public function setTraceId($traceId){
		$this->traceId = $traceId;
	}

	protected function getTransactionSpecificLabels(){
		return array_merge($this->transactionLabels, $this->getIdLabels(), $this->getProcessingLabels());
	}

	public function getPaymentInformation(){
		return $this->paymentInformation;
	}

	public function setPaymentInformation($paymentInformation){
		$this->paymentInformation = $paymentInformation;
	}

	/**
	 *
	 * @return array
	 */
	private function getIdLabels(){
		$labels = array();
		if ($this->getUnzTypeId()) {
			$labels[] = array(
				"label" => Customweb_I18n_Translation::__("Unzer Type ID"),
				"value" => $this->getUnzTypeId()
			);
		}
		if ($this->getUnzPaymentId()) {
			$labels[] = array(
				"label" => Customweb_I18n_Translation::__("Unzer Payment ID"),
				"value" => $this->getUnzPaymentId()
			);
		}
		if ($this->getUnzAuthorizationId()) {
			$labels[] = array(
				"label" => Customweb_I18n_Translation::__("Unzer Authorization ID"),
				"value" => $this->getUnzAuthorizationId()
			);
		}
		if ($this->getUnzChargeId()) {
			$labels[] = array(
				"label" => Customweb_I18n_Translation::__("Unzer Charge ID"),
				"value" => $this->getUnzChargeId()
			);
		}
		if ($this->getUnzCustomerId()) {
			$labels[] = array(
				"label" => Customweb_I18n_Translation::__("Unzer Customer ID"),
				"value" => $this->getUnzCustomerId()
			);
		}
		if ($this->getUnzBasketId()) {
			$labels[] = array(
				"label" => Customweb_I18n_Translation::__("Unzer Basket ID"),
				"value" => $this->getUnzBasketId()
			);
		}
		if ($this->getUnzMetadataId()) {
			$labels[] = array(
				"label" => Customweb_I18n_Translation::__("Unzer Metadata ID"),
				"value" => $this->getUnzMetadataId()
			);
		}
		if ($this->getUnzTraceId()) {
			$labels[] = array(
				"label" => Customweb_I18n_Translation::__("Unzer Trace ID"),
				"value" => $this->getUnzTraceId()
			);
		}
		return $labels;
	}

	/**
	 *
	 * @return array
	 */
	private function getProcessingLabels(){
		$labels = array();
		if ($this->getUniqueId()) {
			$labels[] = array(
				"label" => Customweb_I18n_Translation::__("Unzer Unique ID"),
				"value" => $this->getUniqueId()
			);
		}
		if ($this->getShortId()) {
			$labels[] = array(
				"label" => Customweb_I18n_Translation::__("Unzer Short ID"),
				"value" => $this->getShortId()
			);
		}
		if ($this->getTraceId()) {
			$labels[] = array(
				"label" => Customweb_I18n_Translation::__("Unzer Trace ID (processing)"),
				"value" => $this->getTraceId()
			);
		}
		return $labels;
	}

	/**
	 */
	public function loadFromPaymentCustomerContext($key){
		$map = $this->getPaymentCustomerContext()->getMap();
		if (isset($map[$key . '_unzCustomerId'])) {
			$this->setUnzCustomerId($map[$key . '_unzCustomerId'], $key);
		}
	}

	/**
	 *
	 * @param Customweb_Unzer_Authorization_Transaction $transaction
	 */
	public function loadFromTransaction(Customweb_Unzer_Authorization_Transaction $transaction, $key){
		$this->setUnzCustomerId($transaction->getUnzCustomerId(), $key);
		$this->setUnzTypeId($transaction->getUnzTypeId());
	}

	/**
	 *
	 * @return mixed
	 */
	public function getUnzTypeId(){
		return $this->unzTypeId;
	}

	/**
	 *
	 * @param mixed $unzTypeId
	 */
	public function setUnzTypeId($unzTypeId){
		$this->unzTypeId = $unzTypeId;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getRedirectUrl(){
		return $this->redirectUrl;
	}

	/**
	 *
	 * @return void
	 */
	public function setRedirectUrl($redirectUrl){
		$this->redirectUrl = $redirectUrl;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getUnzAuthorizationId(){
		return $this->unzAuthorizationId;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getUnzPaymentId(){
		return $this->unzPaymentId;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getUnzChargeId(){
		return $this->unzChargeId;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getUnzBasketId(){
		return $this->unzBasketId;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getUnzCustomerId(){
		return $this->unzCustomerId;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getUnzMetadataId(){
		return $this->unzMetadataId;
	}

	/**
	 *
	 * @param mixed $unzAuthorizationId
	 */
	public function setUnzAuthorizationId($unzAuthorizationId){
		$this->unzAuthorizationId = $unzAuthorizationId;
	}

	/**
	 *
	 * @param mixed $unzPaymentId
	 */
	public function setUnzPaymentId($unzPaymentId){
		$this->unzPaymentId = $unzPaymentId;
	}

	/**
	 *
	 * @param mixed $unzChargeId
	 */
	public function setUnzChargeId($unzChargeId){
		$this->unzChargeId = $unzChargeId;
	}

	/**
	 *
	 * @param mixed $unzBasketId
	 */
	public function setUnzBasketId($unzBasketId){
		$this->unzBasketId = $unzBasketId;
	}

	/**
	 *
	 * @param mixed $unzCustomerId
	 */
	public function setUnzCustomerId($unzCustomerId, $key){
		$this->unzCustomerId = $unzCustomerId;
		$this->getPaymentCustomerContext()->updateMap(array(
			$key . '_unzCustomerId' => $unzCustomerId
		));
	}

	/**
	 *
	 * @param mixed $unzMetadataId
	 */
	public function setUnzMetadataId($unzMetadataId){
		$this->unzMetadataId = $unzMetadataId;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getUnzTraceId(){
		return $this->unzTraceId;
	}

	/**
	 *
	 * @param mixed $unzTraceId
	 */
	public function setUnzTraceId($unzTraceId){
		$this->unzTraceId = $unzTraceId;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getUnzErrorId(){
		return $this->unzErrorId;
	}

	/**
	 *
	 * @param mixed $unzErrorId
	 */
	public function setUnzErrorId($unzErrorId){
		$this->unzErrorId = $unzErrorId;
	}

	/**
	 *
	 * @return boolean
	 */
	public function isZeroCheckout(){
		return (Customweb_Util_Currency::compareAmount($this->getAuthorizationAmount(), 0, $this->getCurrencyCode()) == 0) &&
				$this->getTransactionContext()->createRecurringAlias();
	}

	/**
	 *
	 * @return boolean
	 */
	public function isRecurring(){
		return $this->getAuthorizationMethod() === Customweb_Payment_Authorization_Recurring_IAdapter::AUTHORIZATION_METHOD_NAME;
	}

	public function partialCaptureByLineItems($items, $close = false, $additionalMessage = ''){
		/**
		 *
		 * @var Customweb_Unzer_Authorization_Capture $capture
		 */
		$capture = parent::partialCaptureByLineItems($items, $close, $additionalMessage);
		$capture->setLineItems($items);
		return $capture;
	}

	protected function buildNewCancelObject($cancelId, $status = NULL){
		return new Customweb_Unzer_Authorization_Cancel($cancelId, $status);
	}

	protected function buildNewCaptureObject($captureId, $amount, $status = NULL){
		return new Customweb_Unzer_Authorization_Capture($captureId, $amount, $status);
	}

	protected function buildNewRefundObject($refundId, $amount, $status = NULL){
		return new Customweb_Unzer_Authorization_Refund($refundId, $amount, $status);
	}

	public function addLabel($label, $value, $key = null){
		if (empty($key)) {
			$key = md5($label);
		}
		$this->transactionLabels[$key] = array(
			'label' => $label,
			'value' => $value
		);
	}

	// expose parent methods for api checks (automatic interaction)
	public function isApiCapturePossible(){
		return parent::isPartialCapturePossible(); // if we do not call parent directly, will call overwritten method below which is not correct.
	}

	public function isApiPartialCapturePossible(){
		return parent::isPartialCapturePossible();
	}

	public function isApiRefundPossible(){
		return parent::isRefundPossible();
	}

	public function isApiCancelPossible(){
		return parent::isCancelPossible();
	}

	// override parent functions for ui availability (manual interaction)
	public function isCapturePossible(){
		return $this->getCaptureSupported() && parent::isCapturePossible();
	}

	public function isPartialCapturePossible(){
		return parent::isPartialCapturePossible();
	}

	public function isRefundPossible(){
		return $this->getRefundSupported() && parent::isRefundPossible() && !$this->hasBlockingCapture();
	}

	private function hasBlockingCapture(){
		if (!$this->cancelPendingChargeSupported) {
			/**
			 *
			 * @var $capture Customweb_Payment_Authorization_ITransactionCapture
			 */
			foreach ($this->getCaptures() as $capture) {
				if ($capture->getStatus() === Customweb_Payment_Authorization_ITransactionCapture::STATUS_PENDING) {
					return true;
				}
			}
		}
		return false;
	}

	public function isCancelPossible(){
		return $this->getCancelSupported() && parent::isCancelPossible();
	}

	public function addProcessed($id){
		$this->processedIds[] = $id;
	}

	public function isProcessed($id){
		return in_array($id, $this->processedIds);
	}

	/**
	 * Adds a chargeback on the transaction, provided the given chargeback is successfull.
	 *
	 * @param array $chargeback
	 */
	public function addChargeback(array $chargeback){
		if ($chargeback['status'] === 'success') {
			$id = Customweb_Unzer_Util_String::extractChargebackIdFromUrl($chargeback['url']);
			$this->chargebacks[$id] = $chargeback['amount'];
			$this->addHistoryItem(new Customweb_Unzer_Authorization_ChargebackHistoryItem($chargeback));
		}
	}
	private $charges = array();

	/**
	 * Add or update a charge.
	 * Returns true if added, false if updated.
	 *
	 * @param array $charge
	 */
	public function processCharge(array $charge){
		$id = Customweb_Unzer_Util_String::extractChargeIdFromUrl($charge['url']);
		if (array_key_exists($id, $this->charges)) {
			array_merge($this->charges[$id], $charge);
			return false;
		}
		else {
			$this->charges[$id] = $charge;
			return true;
		}
	}

	public function cancelCharge($id, $amount){
		if (array_key_exists('cancelled', $this->charges[$id])) {
			$this->charges[$id]['cancelled'] = Customweb_Util_Currency::formatAmount($this->charges[$id]['cancelled'] + $amount,
					$this->getCurrencyCode());
		}
		else {
			$this->charges[$id]['cancelled'] = $amount;
		}
	}

	public function getCharges(){
		return $this->charges;
	}

	public function getCapturedAmount(){
		if ($this->getCancelPendingChargeSupported()) {
			return parent::getCapturedAmount();
		}
		$amount = 0;
		$processed = array();
		/**
		 *
		 * @var $capture Customweb_Unzer_Authorization_Capture
		 */
		foreach ($this->getCaptures() as $capture) {
			if ($capture->getStatus() === Customweb_Payment_Authorization_ITransactionCapture::STATUS_SUCCEED) {
				$amount += $capture->getAmount();
				$processed[] = $capture->getChargeId();
			}
		}
		foreach ($this->charges as $id => $charge) {
			if (!in_array($id, $processed)) {
				if ($charge['status'] === 'success') {
					$amount += $charge['amount'];
				}
			}
		}
		return $amount;
	}

	public function getChargebackAmount(){
		$total = 0;
		foreach ($this->chargebacks as $amount) {
			$total += $amount;
		}
		return $total;
	}
}