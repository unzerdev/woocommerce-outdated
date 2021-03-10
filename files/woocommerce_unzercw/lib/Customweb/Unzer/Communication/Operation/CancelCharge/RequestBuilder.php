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
require_once 'Customweb/Unzer/Communication/AbstractRequestBuilder.php';
require_once 'Customweb/Core/Http/IRequest.php';
require_once 'Customweb/Util/Invoice.php';


/**
 * Used for refunds.
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Operation_CancelCharge_RequestBuilder extends Customweb_Unzer_Communication_AbstractRequestBuilder {
	protected $paymentId;
	protected $chargeId;
	protected $items;
	protected $splitAmounts;

	public function __construct($paymentId, $chargeId, $items, $currency, $splitAmounts, Customweb_DependencyInjection_IContainer $container, $privateKey){
		parent::__construct($container, $privateKey);
		$this->paymentId = $paymentId;
		$this->chargeId = $chargeId;
		$this->items = $items;
		$this->currency = $currency;
		$this->splitAmounts = $splitAmounts;
	}

	protected function getUrlPath(){
		return str_replace(array(
			'{paymentId}',
			'{chargeId}'
		), array(
			$this->paymentId,
			$this->chargeId
		), "payments/{paymentId}/charges/{chargeId}/cancels");
	}
	
	protected function getPayload(){
		$parameters = $this->splitAmounts ? $this->getSplitAmounts() : $this->getSingleAmount();
		$parameters['reasonCode'] = 'cancel';
		return $parameters;
	}
	
	protected function getSplitAmounts() {
		return array(
			'amountGross' => $this->getGrossAmount(),
			'amountNet' => $this->getNetAmount(),
			'amountVat' => $this->getVatAmount()
		);
	}
	
	protected function getSingleAmount() {
		return array(
			'amount' => $this->getGrossAmount()
		);
	}
	
	protected function getGrossAmount() {
		return Customweb_Util_Currency::formatAmount(Customweb_Util_Invoice::getTotalAmountIncludingTax($this->items), $this->currency);
	}
	
	protected function getNetAmount() {
		return Customweb_Util_Currency::formatAmount(Customweb_Util_Invoice::getTotalAmountExcludingTax($this->items), $this->currency);
	}
	
	protected function getVatAmount() {
		return Customweb_Util_Currency::formatAmount(Customweb_Util_Invoice::getTotalTaxAmount($this->items), $this->currency);
	}

	protected function getMethod(){
		return Customweb_Core_Http_IRequest::METHOD_POST;
	}
}