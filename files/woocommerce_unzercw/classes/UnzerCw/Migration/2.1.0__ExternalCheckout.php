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

require_once 'Customweb/Database/Migration/IScript.php';


class UnzerCw_Migration_2_1_0 implements Customweb_Database_Migration_IScript{

	public function execute(Customweb_Database_IDriver $driver) {
		global $wpdb;
		
		$driver->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "woocommerce_unzercw_ecc` (
			contextId bigint(20) NOT NULL AUTO_INCREMENT,
			state varchar (31) ,
			failedErrorMessage varchar (255) ,
			cartUrl varchar (255) ,
			defaultCheckoutUrl varchar (255) ,
			invoiceItems LONGTEXT ,
			orderAmountInDecimals decimal (20,5) ,
			currencyCode varchar (7) ,
			languageCode varchar (15) ,
			customerEmailAddress varchar (255) ,
			customerId varchar (63) ,
			transactionId int (11) ,
			shippingAddress LONGTEXT ,
			billingAddress LONGTEXT ,
			shippingMethodName varchar (127) ,
			paymentMethodMachineName varchar (255) ,
			providerData LONGTEXT ,
			createdOn datetime ,
			updatedOn datetime ,
			securityToken varchar (255) ,
			securityTokenExpiryDate datetime NULL DEFAULT NULL,
			authenticationSuccessUrl varchar(512) NULL DEFAULT NULL,
			authenticationEmailAddress varchar (255) NULL DEFAULT NULL,
			cookieKey varchar (255) ,
			additionalValues LONGTEXT ,
			selectedShippingMethods LONGTEXT ,
			verificationHash varchar (128),
			PRIMARY KEY (contextId)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB;")->execute();
		
	
	}

}