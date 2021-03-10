<?php
/**
  * You are allowed to use this API in your web application.
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

require_once 'Customweb/Payment/Authorization/Hidden/ITransactionContext.php';
require_once 'UnzerCw/Util.php';
require_once 'Customweb/Payment/Authorization/Server/ITransactionContext.php';
require_once 'Customweb/Payment/Authorization/Ajax/ITransactionContext.php';
require_once 'Customweb/Payment/Authorization/PaymentPage/ITransactionContext.php';
require_once 'Customweb/Payment/Authorization/ITransaction.php';
require_once 'Customweb/Payment/Authorization/Iframe/ITransactionContext.php';
require_once 'Customweb/Payment/Authorization/Widget/ITransactionContext.php';


class UnzerCw_TransactionContext implements Customweb_Payment_Authorization_PaymentPage_ITransactionContext,
Customweb_Payment_Authorization_Hidden_ITransactionContext, Customweb_Payment_Authorization_Server_ITransactionContext,
Customweb_Payment_Authorization_Iframe_ITransactionContext, Customweb_Payment_Authorization_Ajax_ITransactionContext,
Customweb_Payment_Authorization_Widget_ITransactionContext
{
	protected $capturingMode;
	protected $aliasTransactionId = null;
	protected $paymentCustomerContext = null;
	protected $orderContext;
	protected $databaseTransactionId = null;
	protected $userId = null;
	protected $notificationUrl = null;
	protected $successUrl = null;
	protected $failedUrl = null;
	protected $ifameBreakoutUrl = null;

	private $databaseTransaction = null;

	public function __construct(UnzerCw_Entity_Transaction $transaction, UnzerCw_OrderContext $orderContext, $aliasTransaction = null) {
		
		$this->userId = $orderContext->getCustomerId();
		$this->orderContext = $orderContext;
		
		$aliasTransactionIdCleaned = null;
		if ($orderContext->getPaymentMethod()->isAliasManagerActive() && $this->userId > 0) {
			if ($aliasTransaction == 'new' ) {
				$aliasTransactionIdCleaned = 'new';
			}
			else if($aliasTransaction instanceof  Customweb_Payment_Authorization_ITransaction) {
				$aliasTransactionIdCleaned = $aliasTransaction->getTransactionId();
			}
		}
		$this->aliasTransactionId = $aliasTransactionIdCleaned;

		$this->paymentCustomerContext = UnzerCw_Util::getPaymentCustomerContext($this->userId);

		$this->databaseTransaction = $transaction;
		$this->databaseTransactionId = $transaction->getTransactionId();
		$this->notificationUrl = UnzerCw_Util::getPluginUrl('notification');
		$this->successUrl = UnzerCw_Util::getPluginUrl('success');
		$this->failedUrl = UnzerCw_Util::getPluginUrl('failure');
		$this->ifameBreakoutUrl = UnzerCw_Util::getPluginUrl('iframe', array(), 'breakOut');
	}

	/**
	 * @return UnzerCw_Entity_Transaction
	 */
	public function getDatabaseTransaction() {
		if ($this->databaseTransaction === null) {
			$this->databaseTransaction = UnzerCw_Util::getTransactionById($this->databaseTransactionId);
		}

		return $this->databaseTransaction;
	}

	public function getOrderId() {
		return $this->getDatabaseTransaction()->getOrderId();
	}
	
	public function isOrderIdUnique() {
		return true;
	}

	public function __sleep() {
		return array('capturingMode', 'aliasTransactionId', 'paymentCustomerContext', 'orderContext', 'databaseTransactionId', 'userId', 'notificationUrl', 'successUrl', 'failedUrl', 'ifameBreakoutUrl');
	}

	public function getOrderContext() {
		return $this->orderContext;
	}

	public function getTransactionId() {
		return $this->databaseTransactionId;
	}

	public function getCapturingMode()
	{
		return null;
	}

	public function createRecurringAlias() {
		if ($this->getOrderContext()->isNewSubscription()) {
			return true;
		}
		else {
			return false;
		}
	}

	public function getAlias() {
		return UnzerCw_Util::getAliasTransactionObject($this->aliasTransactionId, $this->userId);
	}

	public function getCustomParameters() {
		$params = array(
			'cwtid' => $this->getDatabaseTransaction()->getTransactionId(),
			'cwtt' => UnzerCw_Util::computeTransactionValidateHash($this->getDatabaseTransaction())
		);

		$params = apply_filters('unzercw_custom_parameters', $params);
		return $params;
	}

	public function getSuccessUrl() {
		return $this->successUrl;
	}

	public function getFailedUrl() {
		return $this->failedUrl;
	}

	public function getPaymentCustomerContext() {
		return $this->paymentCustomerContext;
	}

	public function getNotificationUrl() {
		return $this->notificationUrl;
	}

	public function getIframeBreakOutUrl() {
		return $this->ifameBreakoutUrl;
	}


	public function getJavaScriptSuccessCallbackFunction() {
		return '
		function (redirectUrl) {
			window.location = redirectUrl
		}';
	}

	public function getJavaScriptFailedCallbackFunction() {
		return '
		function (redirectUrl) {
			window.location = redirectUrl
		}';
	}


}