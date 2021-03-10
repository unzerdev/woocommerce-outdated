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

require_once 'Customweb/Licensing/UnzerCw/IShopAdapter.php';





final class UnzerCw_LicenseAdapter implements Customweb_Licensing_UnzerCw_IShopAdapter {

	public static function store($data) {
		try {
			update_site_option('woocommerce_unzercw_licensing_response', $data);
		} catch (Exception $e) {}
	}

	public static function load() {
		try {
			return get_site_option('woocommerce_unzercw_licensing_response');
		} catch(Exception $e) {}
	}

	public static function getDomain() {
		return get_site_url();
	}

}
