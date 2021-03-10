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
require_once 'Customweb/Unzer/Communication/Processor/AbstractProcessor.php';


/**
 * Processor to process recurring payment requests.
 * Does not use optimistic locking.
 *
 * @author sebastian
 *
 */
class Customweb_Unzer_Communication_Operation_RecurringPaymentProcessor extends Customweb_Unzer_Communication_Processor_AbstractProcessor {
	private $transaction;
	private $paymentMethod;

	public function __construct(Customweb_Unzer_Authorization_Transaction $transaction, Customweb_DependencyInjection_IContainer $container){
		$container = Customweb_Unzer_Container::get($container);
		$this->transaction = $transaction;
		$this->paymentMethod = $container->getPaymentMethodByTransaction($transaction);
		parent::__construct($container);
	}

	public function process(){
		$this->paymentMethod->sendCustomer($this->transaction);
		$this->paymentMethod->sendBasket($this->transaction);
		return parent::process();
	}

	protected function getResponseProcessor(){
		return $this->paymentMethod->getRecurringResponseProcessor($this->transaction);
	}

	protected function getRequestBuilder(){
		return $this->paymentMethod->getRecurringRequestBuilder($this->transaction);
	}
}