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
require_once 'UnzerCw/Util.php';
require_once 'UnzerCw/ContextRequest.php';
require_once 'UnzerCw/Controller/Abstract.php';



/**
 *
 * @author Nico Eigenmann
 *
 */
class UnzerCw_Controller_Payment extends UnzerCw_Controller_Abstract {

	public function indexAction(){
		$parameters = UnzerCw_ContextRequest::getInstance()->getParameters();
		$aliasTransactionId = null;
		try {
			$order = $this->loadOrder($parameters);
		}
		catch (Exception $e) {
			return $this->formatErrorMessage($e->getMessage());
		}
		
		$orderPostId= $order->get_id();
		
		if (!isset($parameters['cwpmc'])) {
			return $this->formatErrorMessage(__('Missing payment method.', 'woocommerce_unzercw'));
		}
		$paymentMethodClass = $parameters['cwpmc'];
			
		if (isset($parameters['cwalias'])) {
			$aliasTransactionId = $parameters['cwalias'];
		}
		
		$paymentMethod = UnzerCw_Util::getPaymentMehtodInstance(strip_tags($paymentMethodClass));
		
		$response = $paymentMethod->processTransaction($orderPostId, $aliasTransactionId);
		
		if (is_array($response) && isset($response['redirect'])) {
			header('Location: ' . $response['redirect']);
			die();
		}
		
		return $response;
	}
}