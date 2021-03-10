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
interface Customweb_Mvc_Controller_IDispatcher {
	
	/**
	 * This method calls based on the given request the action on the controller.
	 *
	 * @param Customweb_Core_Http_IRequest $request
	 * @return Customweb_Core_Http_IResponse
	 */
	public function dispatch(Customweb_Core_Http_IRequest $request);
	
	/**
	 * This method invokes given controller and action with the request object given.
	 *
	 * @param Customweb_Core_Http_IRequest $request
	 * @param string $controllerName
	 * @param string $actionName
	 * @return Customweb_Core_Http_IResponse
	 */
	public function invokeControllerAction(Customweb_Core_Http_IRequest $request, $controllerName, $actionName);
	
}
