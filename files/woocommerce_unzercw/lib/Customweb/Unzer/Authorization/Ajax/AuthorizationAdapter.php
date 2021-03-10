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
require_once 'Customweb/Unzer/Util/Form.php';
require_once 'Customweb/Payment/Authorization/Ajax/IAdapter.php';


/**
 * Adapter to handle ajax authorization
 *
 * @Bean
 */
class Customweb_Unzer_Authorization_Ajax_AuthorizationAdapter extends Customweb_Unzer_Authorization_AbstractAdapter implements 
		Customweb_Payment_Authorization_Ajax_IAdapter {

	public function getAdapterPriority(){
		return 100;
	}

	public function getVisibleFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext){
		try {
			return $this->getPaymentMethodOC($orderContext)->getVisibleFormFields($orderContext, $aliasTransaction, $failedTransaction,
					$paymentCustomerContext);
		}
		catch (Exception $e) {
			return array(
				Customweb_Unzer_Util_Form::getStopElement($e->getMessage())
			);
		}
	}

	public function getJavaScriptCallbackFunction(Customweb_Payment_Authorization_ITransaction $transaction){
		return $this->getPaymentMethodByTransaction($transaction)->getJavascriptCallbackFunction($transaction);
	}

	public function getAjaxFileUrl(Customweb_Payment_Authorization_ITransaction $transaction){
		return (string) $this->getPaymentMethodByTransaction($transaction)->getAjaxFile($transaction);
	}

	public function createTransaction(Customweb_Payment_Authorization_Ajax_ITransactionContext $transactionContext, $failedTransaction){
		return $this->createTransactionBase($transactionContext, $failedTransaction);
	}

	public function getAuthorizationMethodName(){
		return self::AUTHORIZATION_METHOD_NAME;
	}
}