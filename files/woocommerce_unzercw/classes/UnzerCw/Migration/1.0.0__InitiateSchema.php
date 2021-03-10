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

require_once 'Customweb/Database/Migration/IScript.php';

class UnzerCw_Migration_1_0_0 implements Customweb_Database_Migration_IScript {

	public function execute(Customweb_Database_IDriver $driver){
		global $wpdb;
		$driver->query(
				"CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "unzercw_transactions` (
			  `transaction_id` bigint(20) NOT NULL AUTO_INCREMENT,
			  `transaction_number` varchar(255) DEFAULT NULL,
			  `order_id` bigint(20) NOT NULL,
			  `alias_for_display` varchar(255) DEFAULT NULL,
			  `alias_active` char(1) DEFAULT 'y',
			  `payment_method` varchar(255) NOT NULL,
			  `payment_class` varchar(255) NOT NULL,
			  `transaction_object` text DEFAULT NULL,
			  `authorization_type` varchar(255) NOT NULL,
			  `user_id` varchar(255) DEFAULT NULL,
			  `updated_on` datetime NOT NULL,
			  `created_on` datetime NOT NULL,
			  `payment_id` varchar(255) NOT NULL,
			  `updatable` char(1) DEFAULT 'n',
			  PRIMARY KEY (`transaction_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1")->execute();
		
		return true;
	}
}