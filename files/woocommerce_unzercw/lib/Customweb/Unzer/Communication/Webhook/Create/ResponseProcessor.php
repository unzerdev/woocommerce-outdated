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

require_once 'Customweb/Unzer/Communication/Processor/DefaultProcessor.php';
require_once 'Customweb/Unzer/Communication/Webhook/Get/ResponseProcessor.php';
require_once 'Customweb/Unzer/Util/Webhook.php';
require_once 'Customweb/Unzer/Communication/Webhook/Get/RequestBuilder.php';
require_once 'Customweb/Unzer/Communication/AbstractResponseProcessor.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Webhook_Create_ResponseProcessor extends Customweb_Unzer_Communication_AbstractResponseProcessor {
	private $paymentMethod;

	public function __construct(Customweb_Unzer_Method_Default $paymentMethod, Customweb_DependencyInjection_IContainer $container){
		parent::__construct($container);
		$this->paymentMethod = $paymentMethod;
	}

	public function process(Customweb_Core_Http_IResponse $response){
		$url = null;
		try {
			parent::process($response);
			if (!isset($this->data['url'])) {
				throw new Exception(__METHOD__ . ' - No url found in response.');
			}
			$url = $this->data['url'];
		}
		catch (Customweb_Unzer_Communication_Exception $e) {
			if ($e->hasErrorCode('API.510.310.009')) {
				$url = $this->retrieveWebhooks();
			}
			else {
				throw $e;
			}
		}
		if (!$url) {
			throw new Exception(__METHOD__ . ' - Unable to create or retrieve url.');
		}
		$this->getContainer()->getStorageHelper()->writeStorage(Customweb_Unzer_Util_Webhook::getStorageKey($this->paymentMethod), $url);
	}

	private function retrieveWebhooks(){
		$requestBuilder = new Customweb_Unzer_Communication_Webhook_Get_RequestBuilder($this->getContainer(),
				$this->paymentMethod->getPrivateKey());
		$responseProcessor = new Customweb_Unzer_Communication_Webhook_Get_ResponseProcessor($this->getContainer());
		$processor = new Customweb_Unzer_Communication_Processor_DefaultProcessor($requestBuilder, $responseProcessor,
				$this->getContainer());
		return $processor->process();
	}

	protected function getValidResponseCodes(){
		return array(
			201
		);
	}
}