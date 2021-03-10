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
require_once 'Customweb/Unzer/Communication/Webhook/Create/RequestBuilder.php';
require_once 'Customweb/Unzer/Communication/Webhook/Get/ResponseProcessor.php';
require_once 'Customweb/Unzer/Adapter.php';
require_once 'Customweb/Unzer/Communication/Webhook/Get/RequestBuilder.php';
require_once 'Customweb/Unzer/Communication/Webhook/Create/ResponseProcessor.php';


/**
 * Registers webhooks
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_WebhookAdapter extends Customweb_Unzer_Adapter {

	public function run(Customweb_Unzer_Method_Default $paymentMethod){
		if ($this->hasWebhooks($paymentMethod)) {
			return;
		}
		$this->registerWebhooks($paymentMethod);
	}

	private function hasWebhooks(Customweb_Unzer_Method_Default $paymentMethod){
		return $this->pullWebhooks($paymentMethod);
	}

	private function pullWebhooks(Customweb_Unzer_Method_Default $paymentMethod){
		$requestBuilder = new Customweb_Unzer_Communication_Webhook_Get_RequestBuilder($this->getContainer(),
				$paymentMethod->getPrivateKey());
		$responseProcessor = new Customweb_Unzer_Communication_Webhook_Get_ResponseProcessor($this->getContainer());
		try {
			$processor = new Customweb_Unzer_Communication_Processor_DefaultProcessor($requestBuilder, $responseProcessor,
					$this->getContainer());
			$processor->process();
		}
		catch (Exception $e) {
			return false;
		}
		return true;
	}

	private function registerWebhooks(Customweb_Unzer_Method_Default $paymentMethod){
		$requestBuilder = new Customweb_Unzer_Communication_Webhook_Create_RequestBuilder($this->getContainer(),
				$paymentMethod->getPrivateKey());
		$responseProcessor = new Customweb_Unzer_Communication_Webhook_Create_ResponseProcessor($paymentMethod, $this->getContainer());
		$processor = new Customweb_Unzer_Communication_Processor_DefaultProcessor($requestBuilder, $responseProcessor,
				$this->getContainer());
		$processor->process();
	}
}