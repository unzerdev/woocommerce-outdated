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

require_once 'Customweb/Unzer/Authorization/AbstractAdapter.php';
require_once 'Customweb/Payment/Exception/RecurringPaymentErrorException.php';
require_once 'Customweb/Payment/Authorization/Recurring/IAdapter.php';


/**
 * Adapter to handle recurring authorization
 *
 * @Bean
 */
class Customweb_Unzer_Authorization_Recurring_AuthorizationAdapter extends Customweb_Unzer_Authorization_AbstractAdapter implements 
		Customweb_Payment_Authorization_Recurring_IAdapter {

	public function getAdapterPriority(){
		return 200;
	}

	public function process(Customweb_Payment_Authorization_ITransaction $transaction){
		/**
		 * @var Customweb_Payment_Authorization_Recurring_ITransactionContext $context
		 */
		$context = $transaction->getTransactionContext();
		$method = $this->getPaymentMethodByTransaction($context->getInitialTransaction());
		$transaction->loadFromTransaction($context->getInitialTransaction(), $method->getPublicKey());
		try {
			$method->getRecurringProcessor($transaction)->process();
		}
		catch (Exception $e) {
			$this->getLogger()->logException($e);
			throw new Customweb_Payment_Exception_RecurringPaymentErrorException();
		}
	}

	public function isPaymentMethodSupportingRecurring(Customweb_Payment_Authorization_IPaymentMethod $paymentMethod){
		try {
			$this->getContainer()->getPaymentMethod($paymentMethod, $this->getAuthorizationMethodName());
			return true;
		}
		catch (Exception $e) {
		}
		return false;
	}

	public function createTransaction(Customweb_Payment_Authorization_Recurring_ITransactionContext $transactionContext){
		return $this->createTransactionBase($transactionContext, null);
	}

	public function getAuthorizationMethodName(){
		return self::AUTHORIZATION_METHOD_NAME;
	}
}