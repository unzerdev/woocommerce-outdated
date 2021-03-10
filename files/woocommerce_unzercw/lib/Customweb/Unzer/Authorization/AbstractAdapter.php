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

require_once 'Customweb/Unzer/Authorization/Transaction.php';
require_once 'Customweb/Payment/Authorization/IAdapter.php';
require_once 'Customweb/Unzer/Adapter.php';


/**
 * Adapter offering base implementations
 */
abstract class Customweb_Unzer_Authorization_AbstractAdapter extends Customweb_Unzer_Adapter implements 
		Customweb_Payment_Authorization_IAdapter {

	public function validate(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext, array $formData){
		return $this->getPaymentMethodOC($orderContext)->validate($orderContext, $paymentContext, $formData);
	}

	public function isAuthorizationMethodSupported(Customweb_Payment_Authorization_IOrderContext $orderContext){
		try {
			$this->getPaymentMethodOC($orderContext); // throws exception if unable to resolve
			return true;
		}
		catch (Exception $e) {
			return false;
		}
	}

	public function isDeferredCapturingSupported(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext){
		return $this->getPaymentMethodOC($orderContext)->isDeferredCapturingActive();
	}

	public function preValidate(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext){
		$this->getPaymentMethodOC($orderContext)->preValidate($orderContext, $paymentContext);
	}

	protected function createTransactionBase(Customweb_Payment_Authorization_ITransactionContext $transactionContext, $failedTransaction){
		$transaction = new Customweb_Unzer_Authorization_Transaction($transactionContext);
		$transaction->setLiveTransaction(!$this->getContainer()->getConfiguration()->isTestMode());
		$transaction->setAuthorizationMethod($this->getAuthorizationMethodName());
		$method = $this->getPaymentMethodByTransaction($transaction);
		$transaction->setCaptureSupported($method->isCaptureSupported());
		$transaction->setPartialCaptureSupported($method->isPartialCaptureSupported());
		$transaction->setCancelPendingChargeSupported($method->canCancelPendingCharge());
		$transaction->setRefundSupported($method->isRefundSupported());
		$transaction->setCancelSupported($method->isCancelSupported());
		if ($this->getPaymentMethodOC($transactionContext->getOrderContext())->isSendCustomerActive()) {
			$transaction->loadFromPaymentCustomerContext($method->getPublicKey());
		}
		return $transaction;
	}

	protected function getPaymentMethodOC(Customweb_Payment_Authorization_IOrderContext $orderContext){
		return $this->getContainer()->getPaymentMethod($orderContext->getPaymentMethod(), $this->getAuthorizationMethodName());
	}
}