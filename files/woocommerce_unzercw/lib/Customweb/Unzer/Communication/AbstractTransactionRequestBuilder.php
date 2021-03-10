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
require_once 'Customweb/Unzer/Util/String.php';
require_once 'Customweb/Unzer/Communication/AbstractRequestBuilder.php';


/**
 *
 * @author Sebastian Bossert
 */
abstract class Customweb_Unzer_Communication_AbstractTransactionRequestBuilder extends Customweb_Unzer_Communication_AbstractRequestBuilder {
	protected $transaction;
	protected $orderContext;
	protected $customerData;
	
	public function __construct(Customweb_Unzer_Authorization_Transaction $transaction, Customweb_DependencyInjection_IContainer $container){
		$this->transaction = $transaction;
		$this->orderContext = $transaction->getTransactionContext()->getOrderContext();
		$this->customerData = $transaction->getFormData();
		$container = Customweb_Unzer_Container::get($container);
		parent::__construct($container, $container->getPaymentMethodByTransaction($transaction)->getPrivateKey());
	}
	
	protected function getOrderId(){
		return Customweb_Unzer_Util_String::applySchema($this->getContainer()->getConfiguration()->getOrderIdSchema(), $this->getTransaction());
	}

	/**
	 *
	 * @return Customweb_Unzer_Authorization_Transaction
	 */
	protected function getTransaction(){
		return $this->transaction;
	}
	
	protected function getCustomerDataByKey($key, $required = true){
		if (isset($this->customerData[$key])) {
			return $this->customerData[$key];
		}
		if(!$required) {
			return null;
		}
		throw new Exception("No key $key found in customerData.");
	}
	
	protected function getOrderContext(){
		return $this->orderContext;
	}
}