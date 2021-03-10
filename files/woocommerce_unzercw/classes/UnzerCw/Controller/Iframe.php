<?php 
/**
  * You are allowed to use this API in your web application.
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
require_once 'Customweb/Payment/Authorization/Iframe/IAdapter.php';
require_once 'Customweb/Util/Url.php';
require_once 'UnzerCw/ContextRequest.php';
require_once 'UnzerCw/OrderContext.php';
require_once 'UnzerCw/Controller/Abstract.php';
require_once 'UnzerCw/PaymentMethodWrapper.php';


/**
 *
 * @author Nico Eigenmann
 *
 */
class UnzerCw_Controller_Iframe extends UnzerCw_Controller_Abstract {

	public function indexAction() {
		$parameters = UnzerCw_ContextRequest::getInstance()->getParameters();
		if(!isset($parameters['cwsubmit'])|| $parameters['cwsubmit'] != 'true') {
			return;
		}
		try {
			$order = $this->loadOrder($parameters);
		}
		catch(Exception $e) {
			return $this->formatErrorMessage($e->getMessage());
		}
		
		$paymentModule = $this->getPaymentMethodModule($order);
	
		if ($paymentModule === null) {
			return $this->formatErrorMessage(__('Could not load payment module.', 'woocommerce_unzercw'));
		}
	
		$orderContext = new UnzerCw_OrderContext($order, new UnzerCw_PaymentMethodWrapper($paymentModule));
		
		$authorizationAdapter = UnzerCw_Util::getAuthorizationAdapterByContext($orderContext);
	
		if (!($authorizationAdapter instanceof Customweb_Payment_Authorization_Iframe_IAdapter)) {
			return $this->formatErrorMessage(__('Wrong authorization type.', 'woocommerce_unzercw'));
		}
	
		$this->validateTransaction($orderContext, $authorizationAdapter, $parameters);
		
		$aliasTransaction = $this->getAlias($parameters, $orderContext->getCustomerId());
		$failedTransaction = $this->getFailed($parameters);
		
		$dbTransaction = $paymentModule->prepare($orderContext, $aliasTransaction, $failedTransaction);
	
		$variables = array(
			'iframe_url' => $authorizationAdapter->getIframeUrl($dbTransaction->getTransactionObject(), $parameters),
			'iframe_height' => $authorizationAdapter->getIframeHeight($dbTransaction->getTransactionObject(), $parameters),
		);
		UnzerCw_Util::getEntityManager()->persist($dbTransaction);
	
		if($dbTransaction->getTransactionObject()->isAuthorizationFailed()){
			$url = UnzerCw_Util::getPluginUrl('failure', array('cwtid' => $dbTransaction->getTransactionId(), 'cwtt' => UnzerCw_Util::computeTransactionValidateHash($dbTransaction)));
			header('Location: ' . $url);
			die();
		}
		
		ob_start();
		UnzerCw_Util::includeTemplateFile('payment_iframe', $variables);
		$content = ob_get_clean();
		return $content;
	}

	public function breakOutAction() {
		
		$GLOBALS['woo_unzercwTitle'] = __('Break Out' , 'woocommerce_unzercw');
		
		$parameters = UnzerCw_ContextRequest::getInstance()->getParameters();
		$dbTransaction = null;
		try {
			$dbTransaction = $this->loadTransaction($parameters);
		}
		catch(Exception $e) {
			echo $this->formatErrorMessage($e->getMessage());
			die();
		}
	
		$redirectionUrl = '';
		if ($dbTransaction->getTransactionObject()->isAuthorizationFailed()) {
			$redirectionUrl = Customweb_Util_Url::appendParameters(
					$dbTransaction->getTransactionObject()->getTransactionContext()->getFailedUrl(),
					$dbTransaction->getTransactionObject()->getTransactionContext()->getCustomParameters()
			);
		}
		else {
			$redirectionUrl = Customweb_Util_Url::appendParameters(
					$dbTransaction->getTransactionObject()->getTransactionContext()->getSuccessUrl(),
					$dbTransaction->getTransactionObject()->getTransactionContext()->getCustomParameters()
			);
		}
	
		ob_start();
		$variables = array( 'url' => $redirectionUrl);
		UnzerCw_Util::includeTemplateFile('iframe_break_out', $variables);
		$content = ob_get_clean();
		echo $content;
		die();
	}
	
}