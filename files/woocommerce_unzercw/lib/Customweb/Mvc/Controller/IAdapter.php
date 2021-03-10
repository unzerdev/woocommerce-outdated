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



/**
 * This interface defines the methods required to access configurations 
 * required to access the controllers.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Mvc_Controller_IAdapter {
	
	/**
	 * Returns an URL to an endpoint indicated by the controller name and the action name.
	 * 
	 * @param string $controllerName
	 * @param string $actionName
	 * @param array $parameters
	 */
	public function getUrl($controllerName, $actionName, array $parameters = array());
	
	/**
	 * Extracts the URL parameters from the request, which are passed to the URL generation.
	 * 
	 * @param Customweb_Core_Http_IRequest $request
	 * @return array
	 */
	public function extractUrlParameters(Customweb_Core_Http_IRequest $request);
	
	/**
	 * Extracts the form data in the request.
	 * 
	 * @param Customweb_Core_Http_IRequest $request
	 */
	public function extractFormData(Customweb_Core_Http_IRequest $request);

	/**
	 * Extracts the controller name of the request.
	 *
	 * @param Customweb_Core_Http_IRequest $request
	 * @return string Controller Name
	 * @throws Exception In case no controller is present in the request
	 */
	public function extractControllerName(Customweb_Core_Http_IRequest $request);
	
	/**
	 * Extracts the action name of the request. In case the request does not contain
	 * a action, this method returns null.
	 * 
	 * @param Customweb_Core_Http_IRequest $request
	 * @return string Action Name
	 * @throws Exception
	 */
	public function extractActionName(Customweb_Core_Http_IRequest $request);
	
}