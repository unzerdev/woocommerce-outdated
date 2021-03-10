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

require_once 'Customweb/Payment/Endpoint/Controller/Abstract.php';
require_once 'Customweb/Util/Rand.php';
require_once 'Customweb/Core/Util/Class.php';
require_once 'Customweb/Payment/Exception/ExternalCheckoutInvalidTokenException.php';
require_once 'Customweb/Util/JavaScript.php';

abstract class Customweb_Payment_ExternalCheckout_AbstractCheckoutEndpoint extends Customweb_Payment_Endpoint_Controller_Abstract {

	protected final function checkContextTokenInRequest(Customweb_Core_Http_IRequest $request, Customweb_Payment_ExternalCheckout_IContext $context){
		$parameters = $request->getParameters();
		if (!isset($parameters['token'])) {
			throw new Customweb_Payment_Exception_ExternalCheckoutInvalidTokenException();		
		}
		$this->getCheckoutService()->checkSecurityTokenValidity($context, $parameters['token']);		
	}

	/**
	 *
	 * @return Customweb_Payment_ExternalCheckout_ICheckoutService
	 */
	protected final function getCheckoutService(){
		return $this->getContainer()->getBean('Customweb_Payment_ExternalCheckout_ICheckoutService');
	}

	/**
	 *
	 * @param Customweb_Core_Http_IRequest $request
	 * @throws Exception
	 * @return Customweb_Payment_ExternalCheckout_IContext
	 */
	protected final function loadContextFromRequest(Customweb_Core_Http_IRequest $request){
		$parameters = $request->getParameters();
		if (empty($parameters['context-id'])) {
			throw new Exception("No context id provided.");
		}
		return $this->getCheckoutService()->loadContext($parameters['context-id']);
	}

	protected final function getSecurityTokenFromRequest(Customweb_Core_Http_IRequest $request){
		$parameters = $request->getParameters();
		if (isset($parameters['token'])) {
			return $parameters['token'];
		}
		else {
			throw new Exception("No security token present in request.");
		}
	}

	/**
	 * Get the javascript to send the shipping method form via ajax.
	 *
	 * $shippingPaneSelector and $confirmationPaneSelector are jquery selectors pointing to the pane element surrounding the shipping method and
	 * confirmation forms.
	 *
	 * Customweb.ExternalCheckout.submit() can be used to submit the shipping method form manually.
	 *
	 * @param string $shippingPaneSelector
	 * @param string $confirmationPaneSelector
	 * @return string
	 */
	protected final function getAjaxJavascript($shippingPaneSelector, $confirmationPaneSelector){
		$jqueryVariableName = 'j' . Customweb_Util_Rand::getRandomString(30);
		
		$javascript = Customweb_Core_Util_Class::readResource('Customweb_Payment_ExternalCheckout', 'ExternalCheckout.js') . "\n\n";
		
		$variables = array(
			'jQueryNameSpace' => $jqueryVariableName 
		);
		
		foreach ($variables as $variableName => $value) {
			$javascript = str_replace('____' . $variableName . '____', $value, $javascript);
		}
		
		$javascript .= Customweb_Util_JavaScript::getLoadJQueryCode('1.10.2', $jqueryVariableName, 
				'function() { Customweb.ExternalCheckout.init("' . $shippingPaneSelector . '", "' . $confirmationPaneSelector . '"); }') . "\n\n";
		
		return $javascript;
	}
}
	