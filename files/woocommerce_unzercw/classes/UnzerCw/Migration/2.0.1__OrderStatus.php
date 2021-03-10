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

class UnzerCw_Migration_2_0_1 implements Customweb_Database_Migration_IScript {

	public function execute(Customweb_Database_IDriver $driver){
		global $wpdb;

		$postTable = $wpdb->prefix.'posts';
		$query = 'SHOW COLUMNS FROM `'.$postTable.'` WHERE Field="post_status"';
		$select = $driver->query($query)->fetch();
		$length = preg_replace("/[^0-9]/","",$select['Type']);
		if($length <= 64) {
			$update ='ALTER TABLE `'.$postTable.'` CHANGE `post_status` `post_status` VARCHAR(64) NOT NULL DEFAULT "'.$select['Default'].'";';
			$driver->query($update)->execute();
		}
		
		return true;
	}
}