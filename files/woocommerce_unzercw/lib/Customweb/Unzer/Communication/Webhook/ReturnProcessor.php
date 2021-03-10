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
require_once 'Customweb/Unzer/Communication/Processor/DefaultProcessor.php';
require_once 'Customweb/Unzer/Communication/Processor/OptimisticLockingProcessor.php';
require_once 'Customweb/Unzer/Communication/Webhook/PaymentResponseProcessor.php';
require_once 'Customweb/Unzer/Communication/GetRequestBuilder.php';


/**
 * Processor to send retrieve payment status on returntostore.
 *
 * @author sebastian
 *
 */
class Customweb_Unzer_Communication_Webhook_ReturnProcessor extends Customweb_Unzer_Communication_Processor_OptimisticLockingProcessor {

	public function __construct(Customweb_Unzer_Authorization_Transaction $transaction, Customweb_DependencyInjection_IContainer $container){
		$requestBuilder = new Customweb_Unzer_Communication_GetRequestBuilder($container, Customweb_Unzer_Container::get($container)->getPaymentMethodByTransaction($transaction)->getPrivateKey(),
				'payments/' . $transaction->getUnzPaymentId());
		parent::__construct($transaction->getExternalTransactionId(), $requestBuilder, $container);
	}

	/**
	 * Must always recreate due to database transactions
	 *
	 * {@inheritdoc}
	 * @see Customweb_Unzer_Communication_Processor_DefaultProcessor::getResponseProcessor()
	 */
	protected function getResponseProcessor(){
		return new Customweb_Unzer_Communication_Webhook_PaymentResponseProcessor($this->getTransaction(), $this->getContainer());
	}
}