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
require_once 'Customweb/Payment/Authorization/ITransactionCapture.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Unzer/Authorization/Refund.php';
require_once 'Customweb/Payment/Authorization/ITransactionCancel.php';
require_once 'Customweb/Payment/Authorization/ITransactionRefund.php';


/**
 * Util methods
 *
 * @author Sebastian Bossert
 */
final class Customweb_Unzer_Util_Transaction {
	private static $captureStatusMapping = array(
		'success' => Customweb_Payment_Authorization_ITransactionCapture::STATUS_SUCCEED,
		'pending' => Customweb_Payment_Authorization_ITransactionCapture::STATUS_PENDING,
		'failed' => Customweb_Payment_Authorization_ITransactionCapture::STATUS_FAILED,
		'failure' => Customweb_Payment_Authorization_ITransactionCapture::STATUS_FAILED,
		'error' => Customweb_Payment_Authorization_ITransactionCapture::STATUS_FAILED
	);
	private static $cancelStatusMapping = array(
		'success' => Customweb_Payment_Authorization_ITransactionCancel::STATUS_SUCCEED,
		'pending' => Customweb_Payment_Authorization_ITransactionCancel::STATUS_PENDING,
		'failed' => Customweb_Payment_Authorization_ITransactionCancel::STATUS_FAILED,
		'failure' => Customweb_Payment_Authorization_ITransactionCancel::STATUS_FAILED,
		'error' => Customweb_Payment_Authorization_ITransactionCancel::STATUS_FAILED
	);
	private static $refundStatus = array(
		'success' => Customweb_Payment_Authorization_ITransactionRefund::STATUS_SUCCEED,
		'pending' => Customweb_Payment_Authorization_ITransactionRefund::STATUS_PENDING,
		'failed' => Customweb_Payment_Authorization_ITransactionRefund::STATUS_FAILED,
		'failure' => Customweb_Payment_Authorization_ITransactionRefund::STATUS_FAILED,
		'error' => Customweb_Payment_Authorization_ITransactionRefund::STATUS_FAILED
	);

	private function __construct(){}

	/**
	 * Calculate the captured total for all successful charge transactions.
	 *
	 * @param Customweb_Unzer_Authorization_Transaction $transaction
	 * @return number
	 */
	public static function getCaptureAmount(Customweb_Unzer_Authorization_Transaction $transaction){
		$amount = 0;
		foreach ($transaction->getCaptures() as $capture) {
			/** @var $capture Customweb_Unzer_Authorization_Capture */
			if ($capture->getStatus() == Customweb_Payment_Authorization_ITransactionCapture::STATUS_SUCCEED) {
				$amount += $capture->getAmount();
			}
		}
		return $amount;
	}

	/**
	 * Calculate the refunded total for all successful refund transactions.
	 *
	 * @param Customweb_Unzer_Authorization_Transaction $transaction
	 * @return number
	 */
	public static function getRefundAmount(Customweb_Unzer_Authorization_Transaction $transaction){
		$amount = 0;
		foreach ($transaction->getRefunds() as $refund) {
			/** @var $refund Customweb_Unzer_Authorization_Refund */
			if ($refund->getStatus() == Customweb_Payment_Authorization_ITransactionRefund::STATUS_SUCCEED) {
				$amount += $refund->getAmount();
			}
		}
		$amount += $transaction->getChargebackAmount();
		return $amount;
	}

	public static function mapCaptureStatus($status){
		if (isset(self::$captureStatusMapping[$status])) {
			return self::$captureStatusMapping[$status];
		}
		return Customweb_Payment_Authorization_ITransactionCapture::STATUS_PENDING;
	}

	public static function mapRefundStatus($status){
		if (isset(self::$refundStatus[$status])) {
			return self::$refundStatus[$status];
		}
		return Customweb_Payment_Authorization_ITransactionRefund::STATUS_PENDING;
	}

	public static function mapCancelStatus($status){
		if (isset(self::$cancelStatusMapping[$status])) {
			return self::$cancelStatusMapping[$status];
		}
		return Customweb_Payment_Authorization_ITransactionCancel::STATUS_PENDING;
	}

	public static function getCaptureByChargeId(Customweb_Unzer_Authorization_Transaction $transaction, $id){
		foreach ($transaction->getCaptures() as $capture) {
			if ($capture instanceof Customweb_Unzer_Authorization_Capture && $capture->getChargeId() == $id) {
				return $capture;
			}
		}
		return null;
	}

	public static function getCaptureByAmount(Customweb_Unzer_Authorization_Transaction $transaction, $amount){
		foreach ($transaction->getCaptures() as $capture) {
			if ($capture instanceof Customweb_Unzer_Authorization_Capture &&
					Customweb_Util_Currency::compareAmount($capture->getAmount(), $amount, $transaction->getCurrencyCode()) == 0) {
				return $capture;
			}
		}
		return null;
	}

	public static function getRefundByCancelChargeId(Customweb_Unzer_Authorization_Transaction $transaction, $id){
		foreach ($transaction->getRefunds() as $refund) {
			if ($refund instanceof Customweb_Unzer_Authorization_Refund && $refund->getCancelChargeId() == $id) {
				return $refund;
			}
		}
		return null;
	}
}
