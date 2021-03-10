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

require_once 'UnzerCw/Util.php';
require_once 'Customweb/Payment/Authorization/ITransaction.php';
require_once 'Customweb/Payment/Entity/AbstractTransaction.php';
require_once 'Customweb/Payment/Authorization/Recurring/IAdapter.php';

/**
 * This class represents a transaction.
 *
 * @author Thomas Hunziker
 *
 *
 * @Entity(tableName = 'woocommerce_unzercw_transactions')
 * @Filter(name = 'loadByPostId', where = 'postId = >postId', orderBy = 'postId')
 */
class UnzerCw_Entity_Transaction extends Customweb_Payment_Entity_AbstractTransaction {
	private $paymentClass = null;
	private $postId = null;

	/**
	 * @Column(type = 'varchar')
	 */
	public function getPaymentClass(){
		return $this->paymentClass;
	}

	public function setPaymentClass($paymentClass){
		$this->paymentClass = $paymentClass;
		return $this;
	}
	
	/**
	 * @Column(type = 'varchar')
	 */
	public function getPostId(){
		return $this->postId;
	}
	
	public function setPostId($postId){
		$this->postId = $postId;
		return $this;
	}

	public function getOrder(){
		// We load the order object always fresh from the database, to make sure,
		// that no old status is shared between the different usages.
		$orderPostId = $this->getPostId();
		if(empty($orderPostId)) {
			return new WC_Order($this->getOrderId());
		}
		return new WC_Order($orderPostId);
		
	}

	public function onBeforeSave(Customweb_Database_Entity_IManager $entityManager){
		if($this->isSkipOnSafeMethods()){
			return;
		}
		$transactionObject = $this->getTransactionObject();
		// In case a order is associated with this transaction and the authorization failed, we have to cancel the order.
		if ($transactionObject !== null && $transactionObject instanceof Customweb_Payment_Authorization_ITransaction &&
				 $transactionObject->isAuthorizationFailed()) {
			$this->forceTransactionFailing();
		}
		return parent::onBeforeSave($entityManager);
	}

	protected function updateOrderStatus(Customweb_Database_Entity_IManager $entityManager, $orderStatus, $orderStatusSettingKey){
		//Switch language to the transaction language so emails are translated correctly
		$this->changeLanguage();		
		$GLOBALS['woocommerce_unzercw__status_change'] = true;
		$order = $this->getOrder();
		$paymentMethod = UnzerCw_Util::getPaymentMehtodInstance($this->getPaymentClass());
		if ($orderStatusSettingKey != 'status_authorized' || $paymentMethod->getPaymentMethodConfigurationValue('status_authorized') != 'use-default') {
			$order->update_status($orderStatus, __('Payment Notification', 'woocommerce_unzercw'));
		}
		//Restore the original language
		$this->restoreLanguage();
		unset($GLOBALS['woocommerce_unzercw__status_change']);
	}

	protected function authorize(Customweb_Database_Entity_IManager $entityManager){
		if ($this->getTransactionObject()->isAuthorized()) {
			$GLOBALS['woocommerce_unzercw__status_change'] = true;
			$orderPostId = $this->getPostId();
			if(empty($orderPostId)) {
				$orderPostId = $this->getOrderId();
			}
			
			//Switch language to the transaction language so emails are translated correctly
			$this->changeLanguage();
			delete_post_meta( $orderPostId, '_unzercw_pending_state' );
			
			// Ensure that the mail is send to the administrator
			$this->getOrder()->update_status('wc-pending');
				
			$paymentMethod = UnzerCw_Util::getPaymentMehtodInstance($this->getPaymentClass());
			$orderStatus = $paymentMethod->getPaymentMethodConfigurationValue('status_authorized');
			if ($orderStatus != 'use-default') {
				$GLOBALS['woocommerce_unzercw_complete_order_status'] = $orderStatus;
				add_filter('woocommerce_payment_complete_order_status', 'woocommerce_unzercw_complete_order_status', 10 , 3);
			}
			// Mark the order as completed
			apply_filters('woocommerce_payment_successful_result', array(
				'result' => 'success' 
			), $orderPostId);
			$this->getOrder()->payment_complete($this->getTransactionObject()->getPaymentId());

			
			if (function_exists('wcs_order_contains_subscription') && wcs_order_contains_subscription($this->getOrder())) {
				if ($this->getTransactionObject()->getTransactionContext()->createRecurringAlias()) {
					$subscriptions = wcs_get_subscriptions(array(
						'order_id' => $orderPostId
					));
					$subscriptions = wcs_get_subscriptions_for_order( $orderPostId, array( 'order_type' => array( 'parent', 'renewal' )));
					foreach ($subscriptions as $subscription) {
						update_post_meta($subscription->get_id(), 'cwInitialTransactionRecurring', $this->getTransactionId());
					}
				}
			}
			
			
			$this->restoreLanguage();
			unset($GLOBALS['woocommerce_unzercw__status_change']);
		}
	}

	protected function forceTransactionFailing(){
		$GLOBALS['woocommerce_unzercw__status_change'] = true;
		$message = current($this->getTransactionObject()->getErrorMessages());
		
		if(UnzerCw_Util::getAuthorizedTransactionByPostId($this->getPostId()) !== null){
			//Another Transaction has already sucessfuly authorized this transaction, do not mark the order as cancelled
			return;
		}
		$this->getOrder()->add_order_note(__('Error Message: ', 'woocommerce_unzercw') . $message);
		$orderId= $this->getOrder()->get_id();
		delete_post_meta( $orderId, '_unzercw_pending_state' );
		
		if ($this->getAuthorizationType() != Customweb_Payment_Authorization_Recurring_IAdapter::AUTHORIZATION_METHOD_NAME && $this->getTransactionObject()->getTransactionContext()->createRecurringAlias()) {
			// Activate hook to remove subscription cancel email, if the initial transaction failed
			add_action( 'woocommerce_email', 'woocommerce_unzercw_unhook_subscription_cancel' );
		}
			
		$this->getOrder()->update_status('cancelled');
		unset($GLOBALS['woocommerce_unzercw__status_change']);
	}

	
	private function changeLanguage(){
		do_action( 'wpml_switch_language', $this->getTransactionObject()->getTransactionContext()->getOrderContext()->getLanguage()->getIso2LetterCode());
		$GLOBALS['woo_unzercwAuthorizeLanguage'] = $this->getTransactionObject()->getTransactionContext()->getOrderContext()->getLanguage()->getIetfCode();
		add_filter('locale', 'woocommerce_unzercw_locale');
	}
	
	private function restoreLanguage(){
		
		do_action( 'wpml_switch_language', null);
		remove_filter('locale', 'woocommerce_unzercw_locale');
	}
	
}

