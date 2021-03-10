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

require_once 'Customweb/Payment/Endpoint/Controller/Abstract.php';
require_once 'Customweb/Core/Logger/Factory.php';


/**
 * Implementation of a controller for processing payment notifications.
 *
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_Payment_Endpoint_Controller_Process extends Customweb_Payment_Endpoint_Controller_Abstract {

	/**
	 * @var Customweb_Core_ILogger
	 */
	private $logger;

	/**
	 * @param Customweb_DependencyInjection_IContainer $container
	 */
	public function __construct(Customweb_DependencyInjection_IContainer $container) {
		parent::__construct($container);
		$this->logger = Customweb_Core_Logger_Factory::getLogger(get_class($this));
	}


	/**
	 *
	 * @Action("index")
	 */
	public function process(Customweb_Payment_Authorization_ITransaction $transaction, Customweb_Core_Http_IRequest $request) {
		$this->logger->logInfo("The notification process has been started for the transaction " . $transaction->getTransactionId() . ".");
		$adapter = $this->getAdapterFactory()->getAuthorizationAdapterByName($transaction->getAuthorizationMethod());
		$parameters = $request->getParameters();
		$response = $adapter->processAuthorization($transaction, $parameters);
		$this->logger->logInfo("The notification process has been finished for the transaction " . $transaction->getTransactionId() . ".");
		return $response;
	}
}