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

require_once 'Customweb/Unzer/Container.php';
require_once 'Customweb/Unzer/Communication/AbstractTransactionRequestBuilder.php';
require_once 'Customweb/Core/Http/IRequest.php';


/**
 * Calls the resource given by a webhook.
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Webhook_RetrieveRequestBuilder extends Customweb_Unzer_Communication_AbstractTransactionRequestBuilder {
	protected $paymentMethod;
	protected $retrieveUrl;
	
	public function __construct(Customweb_Unzer_Authorization_Transaction $transaction, Customweb_DependencyInjection_IContainer $container, array $webhookData){
		$container = Customweb_Unzer_Container::get($container);
		$this->paymentMethod = $container->getPaymentMethodByTransaction($transaction);
		$this->processWebhookData($webhookData, $container);
		parent::__construct($transaction, $container);
	}
	
	private function processWebhookData(array $webhookData, Customweb_Unzer_Container $container) {
		if(!isset($webhookData['retrieveUrl'])) {
			throw new Exception("No retrieveUrl set.");
		}
		if($this->isValidRetrieveUrl($container, $webhookData['retrieveUrl'])){
			throw new Exception("RetrieveUrl does not seem to be a heidelpay URL, please contact support.");
		}
		$this->retrieveUrl = $webhookData['retrieveUrl'];
		if(!isset($webhookData['publicKey'])) {
			throw new Exception("No publicKey set.");
		}
		if($this->paymentMethod->getPublicKey() !== $webhookData['publicKey']) {
			throw new Exception("Received publicKey does not match configured key for payment method {$this->paymentMethod->getPaymentMethodName()}.");
		}
	}
	
	private function isValidRetrieveUrl(Customweb_Unzer_Container $container, $url) {
		$comparator = $container->getConfiguration()->getApiUrl('payments');
		return strpos($comparator, $url) === 0;
	}
	
	public function getUrl(){
		return $this->retrieveUrl;
	}
	
	protected function getPayload(){
		return null;
	}

	protected function getUrlPath(){
		return null;
	}

	protected function getMethod(){
		return Customweb_Core_Http_IRequest::METHOD_GET;
	}
}