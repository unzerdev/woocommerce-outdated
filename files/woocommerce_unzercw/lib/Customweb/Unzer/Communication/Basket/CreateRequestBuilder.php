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
require_once 'Customweb/Payment/Authorization/IInvoiceItem.php';
require_once 'Customweb/Unzer/Communication/AbstractTransactionRequestBuilder.php';
require_once 'Customweb/Core/Http/IRequest.php';
require_once 'Customweb/Util/Invoice.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Basket_CreateRequestBuilder extends Customweb_Unzer_Communication_AbstractTransactionRequestBuilder {
	private $currency;
	private $reservedIds = array();
	
	public function __construct(Customweb_Unzer_Authorization_Transaction $transaction, Customweb_DependencyInjection_IContainer $container){
		parent::__construct($transaction, $container);
		$this->currency = $transaction->getCurrencyCode();
	}
	
	protected function getMethod(){
		return Customweb_Core_Http_IRequest::METHOD_POST;
	}

	protected function getInvoiceItems(){
		return $this->getTransaction()->getTransactionContext()->getOrderContext()->getInvoiceItems();
	}

	protected function getPayload(){
		$items = $this->getInvoiceItems();
		$discountTotal = $this->getTotalDiscountAmount($items);
		//@formatter:off
		return array(
			'orderId' => $this->getOrderId(),
			'amountTotalGross' => $this->format(Customweb_Util_Invoice::getTotalAmountIncludingTax($items) + $discountTotal),
			'amountTotalDiscount' => $this->format($discountTotal),
			'amountTotalVat' => $this->format(Customweb_Util_Invoice::getTotalTaxAmount($items)),
			'basketItems' => array_map(array($this, 'getItemParameter'), $items),
		);
		//@formatter:on
	}
	
	private function getTotalDiscountAmount(array $items) {
		$total = 0;
		foreach($items as $item) {
			if($item->getType() === Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT) {
				$total += $item->getAmountIncludingTax();
			}
		}
		return Customweb_Util_Currency::formatAmount($total, $this->getOrderContext()->getCurrencyCode());
	}
	
	private function getItemParameter(Customweb_Payment_Authorization_IInvoiceItem $item){
		$quantity = $item->getQuantity();
		if (intval($quantity) !== $quantity) {
			$quantity = 1; // fallback
		}

		$parameters = array(
			'basketItemReferenceId' => $this->getBasketReferenceId($item),
			'quantity' => $quantity,
			'title' => $item->getName(),
			'type' => $this->getItemType($item),
			'vat' => number_format($item->getTaxRate(), 4)
		);

		if ($item->getType() === Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT) {
			$parameters['amountPerUnit'] = 0;
			$parameters['amountDiscount'] = $this->format($item->getAmountIncludingTax());
		}
		else {
			$parameters['amountPerUnit'] = $this->format($item->getAmountIncludingTax() / $quantity);
			$parameters['amountGross'] = $this->format($item->getAmountIncludingTax());
			$parameters['amountNet'] = $this->format($item->getAmountExcludingTax());
			$parameters['amountVat'] = $this->format($item->getTaxAmount());
		}

		return $parameters;
	}
	
	private function getBasketReferenceId(Customweb_Payment_Authorization_IInvoiceItem $item) {
		$originalClean = $clean = preg_replace('/[^a-zA-Z0-9.:_-]/', '-', $item->getSku());
		$i = 0;
		while(in_array($clean, $this->reservedIds)) {
			$clean = $originalClean . '-' . ++$i;
		}
		$this->reservedIds[] = $clean;
		return $clean;
	}
	
	private function format($amount) {
		return Customweb_Util_Currency::formatAmount($amount, $this->currency);
	}

	private function getItemType(Customweb_Payment_Authorization_IInvoiceItem $item){
		switch ($item->getType()) {
			case Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT:
				return 'voucher';
			case Customweb_Payment_Authorization_IInvoiceItem::TYPE_FEE:
				return 'fee';
			case Customweb_Payment_Authorization_IInvoiceItem::TYPE_SHIPPING:
				return 'shipment';
			case Customweb_Payment_Authorization_IInvoiceItem::TYPE_PRODUCT:
			default:
				return 'goods';
		}
	}

	protected function getUrlPath(){
		return 'baskets';
	}

	private function getRequestType(){
		return 'basket';
	}
}