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
require_once 'UnzerCw/AbstractConfigurationAdapter.php';


/**
 * @Bean
 */
class UnzerCw_ConfigurationAdapter extends UnzerCw_AbstractConfigurationAdapter {

	public static function isReviewFormInputActive(){
		$value = get_option('woocommerce_unzercw_review_input_form', 'active');
		return $value == 'active';
	}
	
	public static function getExternalCheckoutPlacement(){
		return get_option('woocommerce_unzercw_external_checkout_placement', 'both');
	}
	
	public static function getExternalCheckoutAccountCreation(){
		return get_option('woocommerce_unzercw_external_checkout_account_creation', 'skip_selection');
	}
	
	public static function getOrderNumberIdentifier(){
		return get_option('woocommerce_unzercw_order_identifier', 'ordernumber');
	}
	
	public static function getLoggingLevel(){
		return get_option('woocommerce_unzercw_log_level', 'error');
	}

	public function getLanguages($currentLanguages = false){
		return null;
	}

	public function getStoreHierarchy(){
		return null;
	}

	public function useDefaultValue(Customweb_Form_IElement $element, array $formData){
		return false;
	}

	public function getOrderStatus(){
		return wc_get_order_statuses();
	}
}