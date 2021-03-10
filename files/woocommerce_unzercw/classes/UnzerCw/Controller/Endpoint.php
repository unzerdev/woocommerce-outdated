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
require_once 'Customweb/Payment/Endpoint/Dispatcher.php';
require_once 'UnzerCw/EndpointAdapter.php';
require_once 'UnzerCw/ContextRequest.php';
require_once 'UnzerCw/Controller/Abstract.php';
require_once 'Customweb/Core/Http/Response.php';


/**
 *
 * @author Nico Eigenmann
 *
 */
class UnzerCw_Controller_Endpoint extends UnzerCw_Controller_Abstract {

	public function indexAction() {
		$container = UnzerCw_Util::createContainer();
		$packages = array(
			0 => 'Customweb_Unzer',
 			1 => 'Customweb_Payment_Authorization',
 		);
		$adapter = new UnzerCw_EndpointAdapter();
		
		$dispatcher = new Customweb_Payment_Endpoint_Dispatcher($adapter, $container, $packages);
		$response = $dispatcher->dispatch(UnzerCw_ContextRequest::getInstance());
		$wrapper = new Customweb_Core_Http_Response($response);
		$wrapper->send();
		die();
	}
	
}