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

class UnzerCw_Migration_2_2_0 implements Customweb_Database_Migration_IScript {

	public function execute(Customweb_Database_IDriver $driver){

		global $wpdb;

		$entityManager = UnzerCw_Util::getEntityManager();

		$tableNameTransaction = $entityManager->getTableNameForEntityByClassName('UnzerCw_Entity_Transaction');

		$result = $driver->query("SHOW COLUMNS FROM `" . $tableNameTransaction . "` LIKE 'versionNumber'");
		if ($result->getRowCount() <= 0) {
			$driver->query("ALTER TABLE `" . $tableNameTransaction . "` ADD COLUMN  `versionNumber` int NOT NULL")->execute();
		}
		$result = $driver->query("SHOW COLUMNS FROM `" . $tableNameTransaction . "` LIKE 'liveTransaction'");
		if ($result->getRowCount() <= 0) {
			$driver->query("ALTER TABLE `" . $tableNameTransaction . "` ADD COLUMN  `liveTransaction` char(1)")->execute();
		}

		$tableNameECC = $entityManager->getTableNameForEntityByClassName('UnzerCw_Entity_ExternalCheckoutContext');
		$result = $driver->query("SHOW COLUMNS FROM `" . $tableNameECC. "` LIKE 'versionNumber'");
		if ($result->getRowCount() <= 0) {
			$driver->query("ALTER TABLE `" . $tableNameECC. "` ADD COLUMN  `versionNumber` int NOT NULL")->execute();
		}

		// Before we can add the version number we need eventually to rename the table.
		$tableName = $wpdb->prefix . 'woocommerce_unzercw_customer_contexts';
		$tableNameNew = $wpdb->prefix . 'woocommerce_unzercw_cc';
		$query = "SHOW TABLES IN `".DB_NAME."` LIKE  '".$tableName."';";
		$select = $driver->query($query)->fetch();

		if(is_array($select) && count($select) > 0) {
			$driver->query("RENAME TABLE `" . $tableName . "` TO `" . $tableNameNew . "`")->execute();
		}

		$tableNamePCC = $entityManager->getTableNameForEntityByClassName('UnzerCw_Entity_PaymentCustomerContext');
		$result = $driver->query("SHOW COLUMNS FROM `" . $tableNamePCC. "` LIKE 'versionNumber'");
		if ($result->getRowCount() <= 0) {
			$driver->query("ALTER TABLE `" . $tableNamePCC . "` ADD COLUMN  `versionNumber` int NOT NULL")->execute();
		}

		return true;
	}
}