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

require_once 'Customweb/Unzer/Container.php';
require_once 'Customweb/Core/Logger/Factory.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Adapter {
	private $container;
	private $logger;

	public function __construct(Customweb_DependencyInjection_IContainer $container){
		$this->container = Customweb_Unzer_Container::get($container);
	}

	/**
	 *
	 * @return Customweb_Core_ILogger
	 */
	protected function getLogger(){
		if ($this->logger === null) {
			$this->logger = Customweb_Core_Logger_Factory::getLogger(get_class());
		}
		return $this->logger;
	}

	protected function getContainer(){
		return $this->container;
	}

	protected function getPaymentMethodByTransaction(Customweb_Unzer_Authorization_Transaction $transaction){
		return $this->getContainer()->getPaymentMethodByTransaction($transaction);
	}
}