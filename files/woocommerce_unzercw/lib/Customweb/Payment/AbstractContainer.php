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

require_once 'Customweb/Core/Http/ContextRequest.php';
require_once 'Customweb/DependencyInjection/IContainer.php';



/**
 * This implementation of the dependency container allows to access some common beans in the
 * container over getter methods.
 * Subclasses may add more getter methods for other beans in the container (e.g. configurations, adapters etc.).
 *
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_Payment_AbstractContainer implements Customweb_DependencyInjection_IContainer {
	
	/**
	 *
	 * @var Customweb_DependencyInjection_IContainer
	 */
	private $container;

	/**
	 * Constructor
	 *
	 * The given container will be wrapped with this one.
	 *
	 * @param Customweb_DependencyInjection_IContainer $container
	 */
	public function __construct(Customweb_DependencyInjection_IContainer $container){
		$this->container = $container;
	}

	public function getBean($identifier){
		return $this->container->getBean($identifier);
	}

	public function getBeansByType($type){
		return $this->container->getBeansByType($type);
	}

	public function hasBean($identifier){
		return $this->container->hasBean($identifier);
	}

	/**
	 * Returns the transaction handler.
	 *
	 * The transaction handler allows the loading and the storage of payment transactions.
	 *
	 * @return Customweb_Payment_ITransactionHandler
	 */
	public function getTransactionHandler(){
		return $this->getBean('Customweb_Payment_ITransactionHandler');
	}

	/**
	 * Returns the endpoint adapter.
	 *
	 * The endpoint adapter allows the generation of URLs to endpoints and the generation of layouts.
	 *
	 * @return Customweb_Payment_Endpoint_IAdapter
	 */
	public function getEndpointAdapter(){
		return $this->getBean('Customweb_Payment_Endpoint_IAdapter');
	}

	/**
	 * Returns the shop capture adapter.
	 *
	 * The shop capture adapter allows to trigger a capture within the shop.
	 *
	 * @return Customweb_Payment_BackendOperation_Adapter_Shop_ICapture
	 */
	public function getShopCaptureAdapter(){
		return $this->getBean('Customweb_Payment_BackendOperation_Adapter_Shop_ICapture');
	}

	/**
	 * Returns the shop cancel adapter.
	 *
	 * The shop capture adapter allows to trigger a cancel within the shop.
	 *
	 * @return Customweb_Payment_BackendOperation_Adapter_Shop_ICancel
	 */
	public function getShopCancelAdapter(){
		return $this->getBean('Customweb_Payment_BackendOperation_Adapter_Shop_ICancel');
	}

	/**
	 * Returns the shop refund adapter.
	 *
	 * The shop capture adapter allows to trigger a refund within the shop.
	 *
	 * @return Customweb_Payment_BackendOperation_Adapter_Shop_IRefund
	 */
	public function getShopRefundAdapter(){
		return $this->getBean('Customweb_Payment_BackendOperation_Adapter_Shop_IRefund');
	}
	
	/**
	 * @return Customweb_Mvc_Layout_IRenderer
	 */
	public function getLayoutRenderer() {
		return $this->getBean('Customweb_Mvc_Layout_IRenderer');
	}

	/**
	 * @return Customweb_Mvc_Template_IRenderer
	 */
	public function getTemplateRenderer() {
		return $this->getBean('Customweb_Mvc_Template_IRenderer');
	}
	
	/**
	 * Returns the HTTP request.
	 * 
	 * @return Customweb_Core_Http_IRequest
	 */
	public function getHttpRequest() {
		if ($this->hasBean('Customweb_Core_Http_IRequest')) {
			return $this->getBean('Customweb_Core_Http_IRequest');
		}
		else {
			return Customweb_Core_Http_ContextRequest::getInstance();
		}
	}
	
}
