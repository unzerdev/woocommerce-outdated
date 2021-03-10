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
require_once 'Customweb/Payment/ExternalCheckout/AbstractContextCleanUpBean.php';

/**
 * 
 * @author nicoeigenmann
 */
class UnzerCw_ContextCleanUpBean extends Customweb_Payment_ExternalCheckout_AbstractContextCleanUpBean {
	
	public function __construct(Customweb_Database_Entity_IManager $entityManager) {
		parent::__construct($entityManager, 'UnzerCw_Entity_ExternalCheckoutContext');
	}
	
	/**
	 * @Cron()
	 */
	public function cleanUp() {
		return parent::cleanUp();
	}
	
}