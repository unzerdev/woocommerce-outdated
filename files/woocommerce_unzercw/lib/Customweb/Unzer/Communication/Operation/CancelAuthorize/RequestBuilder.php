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
require_once 'Customweb/Unzer/Communication/AbstractTransactionRequestBuilder.php';
require_once 'Customweb/Core/Http/IRequest.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Operation_CancelAuthorize_RequestBuilder extends Customweb_Unzer_Communication_AbstractTransactionRequestBuilder {
	protected $amount;

	/**
	 * 
	 * @param Customweb_Unzer_Authorization_Transaction $transaction
	 * @param Customweb_DependencyInjection_IContainer $container
	 * @param float|null $amount The amount to be cancelled. Leaving this empty causes a full cancel to be created. Can be set to cancel the rest of a transaction (capture + close)
	 */
	public function __construct(Customweb_Unzer_Authorization_Transaction $transaction, Customweb_DependencyInjection_IContainer $container, $amount = null){
		parent::__construct($transaction, $container);
		$this->amount = $amount;
		$this->currency = $transaction->getCurrencyCode();
	}

	protected function getUrlPath(){
		return str_replace(array(
			'{paymentId}',
			'{chargeId}'
		), array(
			$this->transaction->getUnzPaymentId()
		), "payments/{paymentId}/authorize/cancels");
	}

	protected function getPayload(){
		if ($this->amount) {
			return array(
				'amount' => $this->getFormattedAmount()
			);
		}
		return null;
	}
	
	protected function getFormattedAmount() {
		return Customweb_Util_Currency::formatAmount($this->amount, $this->currency);
	}

	protected function getMethod(){
		return Customweb_Core_Http_IRequest::METHOD_POST;
	}
}