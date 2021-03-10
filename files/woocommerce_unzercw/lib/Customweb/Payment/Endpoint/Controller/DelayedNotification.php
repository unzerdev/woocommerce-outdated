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

require_once 'Customweb/Mvc/Template/RenderContext.php';
require_once 'Customweb/Payment/Endpoint/Controller/Abstract.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Payment/Endpoint/Annotation/ExtractionMethod.php';
require_once 'Customweb/Mvc/Template/SecurityPolicy.php';
require_once 'Customweb/Mvc/Layout/RenderContext.php';
require_once 'Customweb/Payment/Authorization/DefaultTransaction.php';
require_once 'Customweb/Core/Http/Response.php';
require_once 'Customweb/Util/JavaScript.php';



/**
 * Abstract Implementation of a controller waiting until the notification from the PSP is processed
 *
 * @author Nico Eigenmann
 *
 */
abstract class Customweb_Payment_Endpoint_Controller_DelayedNotification extends Customweb_Payment_Endpoint_Controller_Abstract {
	
	const HASH_PARAMETER = 'securityHash';
	
	/**
	 * @Action("index")
	 */
	public function process(Customweb_Core_Http_IRequest $request){
		$transaction = $this->loadTransaction($request);
		$parameters = $request->getParameters();
		if (!isset($parameters[static::HASH_PARAMETER])) {
			throw new Exception('Security Hash not set');
		}
		$transaction->checkSecuritySignature($this->getControllerName() . 'index', $parameters[static::HASH_PARAMETER]);
		
		$templateContext = new Customweb_Mvc_Template_RenderContext();
		$templateContext->setSecurityPolicy(new Customweb_Mvc_Template_SecurityPolicy());
		$templateContext->setTemplate('delayedNotification');
		$templateContext->addVariable('script', $this->getPollingJs($transaction));
		$templateContext->addVariable('text', $this->getWaitingText($transaction));
		
		$templateRenderer = $this->getTemplateRenderer();
		$content = $templateRenderer->render($templateContext);
		$layoutContext = new Customweb_Mvc_Layout_RenderContext();
		$layoutContext->setMainContent($content);
		$layoutContext->setTitle(Customweb_I18n_Translation::__('Awaiting confirmation'));
		return $this->getLayoutRenderer()->render($layoutContext);
	}
	
	/**
	 * @Action("check")
	 */
	public function check(Customweb_Core_Http_IRequest $request){
		$transaction = $this->loadTransaction($request);
		$parameters = $request->getParameters();
		if (!isset($parameters[static::HASH_PARAMETER])) {
			throw new Exception('Security Hash not set');
		}
		$transaction->checkSecuritySignature($this->getControllerName() . 'check', $parameters[static::HASH_PARAMETER]);
		$status = 'unkown';
		$url = null;
		if ($transaction->isAuthorized()) {
			$status = 'complete';
			$url = $transaction->getSuccessUrl();
		}
		elseif ($transaction->isAuthorizationFailed()) {
			$status = 'complete';
			$url = $transaction->getFailedUrl();
		}
		$json = json_encode(array(
			'status' => $status,
			'redirect' => $url
		));
		return Customweb_Core_Http_Response::_($json)->setContentType("application/json");
	}
	
	/**
	 *
	 * @param Customweb_Core_Http_IRequest $request
	 * @throws Exception
	 * @return Customweb_Payment_Authorization_DefaultTransaction
	 */
	private function loadTransaction(Customweb_Core_Http_IRequest $request){
		$transactionHandler = $this->getContainer()->getBean('Customweb_Payment_ITransactionHandler');
		$idMap = $this->getTransactionId($request);
		if ($idMap['key'] == Customweb_Payment_Endpoint_Annotation_ExtractionMethod::EXTERNAL_TRANSACTION_ID_KEY) {
			$transaction = $transactionHandler->findTransactionByTransactionExternalId($idMap['id']);
		}
		if ($transaction === null) {
			throw new Exception('No transaction found');
		}
		if (!$transaction instanceof Customweb_Payment_Authorization_DefaultTransaction) {
			throw new Exception('Transaction is not of type Customweb_Payment_Authorization_DefaultTransaction');
		}
		return $transaction;
	}
	
	abstract protected function getControllerName();
	
	protected function getWaitingText(Customweb_Payment_Authorization_ITransaction $transaction) {
		return Customweb_I18n_Translation::__('Dear customer, it appears to us that your payment was successful, but we are still waiting for confirmation. You can wait on this page and we will redirect you after we received the confirmation. Or you can close this window and we will send out an order confirmation email.');
	}
	
	protected function getPollingJs($transaction){
		//@formatter:off
		$pollingFunction =  '
			(function cwStatusChecker() {
				if(typeof window.jQuery == "undefined") {
					window.jQuery = cwJQuery;
				}
			    setTimeout(function() {
			        window.jQuery.ajax({
			            url: "' . $this->getUrl($this->getControllerName(), 'check', array('cw_transaction_id' => $transaction->getExternalTransactionId(), static::HASH_PARAMETER => $transaction->getSecuritySignature($this->getControllerName().'check'))) . '",
			            type: "POST",
			            success: function(data) {
			                if(data.status == "complete") {
			            		window.location.replace(data.redirect);
			            		return;
			            	}
			            	cwStatusChecker();
			            },
			            error: function(request, message, code) {
			            	cwStatusChecker();
			            },
			            dataType: "json",
			           	cache: false,
			            timeout: 30000
			        })
			    },  2000);
			})';
		//@formatter:on
		$jQuerySnippet = Customweb_Util_JavaScript::getLoadJQueryCode(null, 'cwJQuery', $pollingFunction);
		return '<script type="text/javascript">' . $jQuerySnippet . '</script>';
	}
}