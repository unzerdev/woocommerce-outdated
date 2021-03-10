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
require_once 'Customweb/Payment/Authorization/DefaultInvoiceItem.php';
require_once 'UnzerCw/OrderContext.php';
require_once 'Customweb/Util/Invoice.php';

class UnzerCw_RecurringOrderContext extends UnzerCw_OrderContext {
	
	private $initialTransactionId;

	
	public function __construct($order, $paymentMethod, $amountToCharge){
		parent::__construct($order, $paymentMethod);
		$this->orderAmount = $amountToCharge;
		$orderId= $order->get_id();
		$subscriptions = wcs_get_subscriptions_for_order($orderId, array(
			'order_type' => array(
				'parent',
				'renewal' 
			) 
		));
		if (1 == count($subscriptions)) {
			$subscription = end($subscriptions);
			$initialTransactionId = get_post_meta($subscription->get_id(), 'cwInitialTransactionRecurring', true);
			$initialTransaction = null;
			if(!empty($initialTransactionId)) {
				$initialTransaction = UnzerCw_Util::getTransactionById($initialTransactionId);
			}
			if ($initialTransaction === null) {
				throw new Exception(sprintf("No initial transaction found for recurring order %s.", $orderId));
			}
			$this->initialTransactionId = $initialTransactionId;
			$this->language = $initialTransaction->getTransactionObject()->getTransactionContext()->getOrderContext()->getLanguage();
			$this->currencyCode = $initialTransaction->getTransactionObject()->getCurrencyCode();
			$this->userId = $initialTransaction->getCustomerId();
		}
		else{
			throw new Exception(sprintf("Initial transaction not found for recurring order %s.", $orderId));
		}
	}
		
	public function getInitialTransactionId(){
		return $this->initialTransactionId;
	}
	

	public function getInvoiceItems(){
		$items = $this->getInvoiceItemsInternal();
		
		// Calculate the difference to the amountToCharge. This can happen, when some outstanding payments are added to this one.
		$total = $this->getLineTotalsWithTax($items);
		$difference = $this->orderAmount - $total;
		if ($difference > 0) {
			$taxRate = 0;
			$items[] = new Customweb_Payment_Authorization_DefaultInvoiceItem('outstanding-payments', __('Outstanding Payments'), $taxRate, 
					$difference, 1, Customweb_Payment_Authorization_DefaultInvoiceItem::TYPE_PRODUCT);
		}
		else if ($difference < 0) {
			$taxRate = 0;
			$items[] = new Customweb_Payment_Authorization_DefaultInvoiceItem('other-discount', 
					__('Other Discount', 'woocommerce_unzercw'), $taxRate, abs($difference), 1, 
					Customweb_Payment_Authorization_DefaultInvoiceItem::TYPE_DISCOUNT);
		}
		
		return Customweb_Util_Invoice::cleanupLineItems($items, $this->getOrderAmountInDecimals(), $this->getCurrencyCode());
	}

	public function isNewSubscription(){
		return false;
	}
}