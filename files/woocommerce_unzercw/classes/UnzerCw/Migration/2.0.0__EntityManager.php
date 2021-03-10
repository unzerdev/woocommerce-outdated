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

require_once 'UnzerCw/Util.php';
require_once 'Customweb/Database/Migration/IScript.php';

class UnzerCw_Migration_2_0_0 implements Customweb_Database_Migration_IScript {

	public function execute(Customweb_Database_IDriver $driver){
		global $wpdb;
		
		$tableName = $wpdb->prefix . 'unzercw_transactions';
		
		$driver->query("ALTER TABLE `" . $tableName . "` ENGINE = INNODB")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` CHANGE  `transaction_id`  `transactionId` BIGINT( 20 ) NOT NULL AUTO_INCREMENT")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` CHANGE  `transaction_number` `transactionExternalId` VARCHAR( 255 )")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` CHANGE  `order_id`  `orderId` VARCHAR( 127 )")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` CHANGE  `alias_for_display`  `aliasForDisplay` VARCHAR( 255 )")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` CHANGE  `alias_active`  `aliasActive` CHAR( 1 )")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` CHANGE  `payment_method`  `paymentMachineName` VARCHAR( 127 )")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` CHANGE  `payment_class`  `paymentClass` VARCHAR( 255 )")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` CHANGE  `transaction_object`  `transactionObject` LONGTEXT")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` CHANGE  `authorization_type`  `authorizationType` VARCHAR( 63 )")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` CHANGE  `user_id`  `customerId` VARCHAR( 255 )")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` CHANGE  `updated_on`  `updatedOn` DATETIME")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` CHANGE  `created_on`  `createdOn` DATETIME")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` CHANGE  `payment_id`  `paymentId` VARCHAR( 255 )")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` CHANGE  `updatable`  `updatable` CHAR( 1 )")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` ADD COLUMN  `executeUpdateOn` DATETIME DEFAULT NULL")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` ADD COLUMN  `authorizationAmount` DECIMAL(20, 5) DEFAULT NULL")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` ADD COLUMN  `authorizationStatus` VARCHAR(31) DEFAULT NULL")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` ADD COLUMN  `paid` CHAR(1) DEFAULT NULL")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` ADD COLUMN  `currency` VARCHAR(15) DEFAULT NULL")->execute();
		$driver->query("ALTER TABLE `" . $tableName . "` ADD COLUMN  `lastSetOrderStatusSettingKey` VARCHAR(31) DEFAULT NULL")->execute();
		
		$entityManager = UnzerCw_Util::getEntityManager();
		
		$tableNameNew = $entityManager->getTableNameForEntityByClassName('UnzerCw_Entity_Transaction');
		
		$driver->query("RENAME TABLE `" . $tableName . "` TO `" . $tableNameNew . "`")->execute();
		
		$driver->query(
				"CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "woocommerce_unzercw_cc` ( 
				contextId bigint(20) NOT NULL AUTO_INCREMENT, 
				customerId varchar (255) , 
				context_values LONGTEXT , 
				UNIQUE KEY customerId (customerId), 
				PRIMARY KEY (contextId) ) 
				DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB;")->execute();
		
		return true;
	}
}