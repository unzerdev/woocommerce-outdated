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

require_once 'Customweb/Payment/Endpoint/Annotation/ExtractionMethod.php';


/**
 * Abstract implementation of a controller which allows the have transactions in the 
 * action arguement list.
 * 
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_Payment_Endpoint_Controller_Abstract {
		
	/**
	 * @var Customweb_DependencyInjection_IContainer
	 */
	private $container = null;
	
	/**
	 * @param Customweb_DependencyInjection_IContainer $container
	 */
	public function __construct(Customweb_DependencyInjection_IContainer $container) {
		$this->container = $container;
	}
	
	/**
	 * @param Customweb_Core_Http_IRequest $request
	 * @ExtractionMethod
	 */
	public function getTransactionId(Customweb_Core_Http_IRequest $request) {
		$parameters = $request->getParameters();
		if (isset($parameters['cw_transaction_id'])) {
			return array(
				'id' => $parameters['cw_transaction_id'],
				'key' => Customweb_Payment_Endpoint_Annotation_ExtractionMethod::EXTERNAL_TRANSACTION_ID_KEY,
			);
		}
		
		throw new Exception("No transaction id present in the request.");
	}
	
	protected function getUrl($controllerName, $actionName = 'index', $parameters = array()) {
		return $this->getEndpointAdapter()->getUrl($controllerName, $actionName, $parameters);
	}
	
	
	/**
	 * @return Customweb_Payment_Authorization_IAdapterFactory
	 */
	protected function getAdapterFactory(){
		return $this->getContainer()->getBean('Customweb_Payment_Authorization_IAdapterFactory');
	}
	
	/**
	 * @return Customweb_Asset_IResolver
	 */
	protected function getAssetResolver() {
		return $this->getContainer()->getBean('Customweb_Asset_IResolver');
	}
	
	/**
	 * @return Customweb_Mvc_Layout_IRenderer
	 */
	protected function getLayoutRenderer() {
		return $this->getContainer()->getBean('Customweb_Mvc_Layout_IRenderer');
	}
	
	/**
	 * @return Customweb_Mvc_Template_IRenderer
	 */
	protected function getTemplateRenderer() {
		return $this->getContainer()->getBean('Customweb_Mvc_Template_IRenderer');
	}

	/**
	 * @return Customweb_Payment_Endpoint_IAdapter
	 */
	protected function getEndpointAdapter() {
		return $this->getContainer()->getBean('Customweb_Payment_Endpoint_IAdapter');
	}
	
	/**
	 * @return Customweb_Payment_ITransactionHandler
	 */
	protected function getTransactionHandler() {
		return $this->getContainer()->getBean('Customweb_Payment_ITransactionHandler');
	}
	
	/**
	 * @return Customweb_Form_IRenderer
	 */
	public function getFormRenderer() {
		return $this->getEndpointAdapter()->getFormRenderer();
	}

	/**
	 * @return Customweb_DependencyInjection_IContainer
	 */
	protected function getContainer(){
		return $this->container;
	}
	
}