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

require_once dirname(dirname(__FILE__)) . '/classes/UnzerCw/PaymentMethod.php'; 

class UnzerCw_Przelewy24 extends UnzerCw_PaymentMethod
{
	public $machineName = 'przelewy24';
	public $admin_title = 'Przelewy24';
	public $title = 'Przelewy24';
	
	protected function getMethodSettings(){
		return array(
			'status_authorized' => array(
				'title' => __("Authorized Status", 'woocommerce_unzercw'),
 				'default' => 'wc-processing',
 				'description' => __("This status is set, when the payment was successfull and it is authorized.", 'woocommerce_unzercw'),
 				'cwType' => 'orderstatusselect',
 				'type' => 'select',
 				'options' => array(
					'use-default' => __("Use WooCommerce rules", 'woocommerce_unzercw'),
 				),
 				'is_order_status' => true,
 			),
 			'status_uncertain' => array(
				'title' => __("Uncertain Status", 'woocommerce_unzercw'),
 				'default' => 'wc-on-hold',
 				'description' => __("You can specify the order status for new orders that have an uncertain authorisation status.", 'woocommerce_unzercw'),
 				'cwType' => 'orderstatusselect',
 				'type' => 'select',
 				'options' => array(
				),
 				'is_order_status' => true,
 			),
 			'status_cancelled' => array(
				'title' => __("Cancelled Status", 'woocommerce_unzercw'),
 				'default' => 'wc-cancelled',
 				'description' => __("You can specify the order status when an order is cancelled.", 'woocommerce_unzercw'),
 				'cwType' => 'orderstatusselect',
 				'type' => 'select',
 				'options' => array(
					'no_status_change' => __("Don't change order status", 'woocommerce_unzercw'),
 				),
 				'is_order_status' => true,
 			),
 			'status_captured' => array(
				'title' => __("Captured Status", 'woocommerce_unzercw'),
 				'default' => 'no_status_change',
 				'description' => __("You can specify the order status for orders that are captured either directly after the order or manually in the backend.", 'woocommerce_unzercw'),
 				'cwType' => 'orderstatusselect',
 				'type' => 'select',
 				'options' => array(
					'no_status_change' => __("Don't change order status", 'woocommerce_unzercw'),
 				),
 				'is_order_status' => true,
 			),
 			'send_basket' => array(
				'title' => __("Send Basket", 'woocommerce_unzercw'),
 				'default' => 'no',
 				'description' => __("Should the invoice items be transmitted to Unzer? This slightly increases the processing time due to an additional request, and may cause issues for certain quantity / price combinations.", 'woocommerce_unzercw'),
 				'cwType' => 'select',
 				'type' => 'select',
 				'options' => array(
					'no' => __("Do not send", 'woocommerce_unzercw'),
 					'yes' => __("Send Basket", 'woocommerce_unzercw'),
 				),
 			),
 			'send_customer' => array(
				'title' => __("Send Customer", 'woocommerce_unzercw'),
 				'default' => 'no',
 				'description' => __("Should customer data be transmitted to Unzer? This slightly increases the processing time due to an additional request, but may allow e.g. saving the payment method to the customer.", 'woocommerce_unzercw'),
 				'cwType' => 'select',
 				'type' => 'select',
 				'options' => array(
					'no' => __("Do not send", 'woocommerce_unzercw'),
 					'yes' => __("Send Customer", 'woocommerce_unzercw'),
 				),
 			),
 			'authorizationMethod' => array(
				'title' => __("Authorization Method", 'woocommerce_unzercw'),
 				'default' => 'AjaxAuthorization',
 				'description' => __("Select the authorization method to use for processing this payment method.", 'woocommerce_unzercw'),
 				'cwType' => 'select',
 				'type' => 'select',
 				'options' => array(
					'AjaxAuthorization' => __("Ajax Authorization", 'woocommerce_unzercw'),
 				),
 			),
 		); 
	}
	
	public function __construct() {
		$this->icon = apply_filters(
			'woocommerce_unzercw_przelewy24_icon', 
			UnzerCw_Util::getResourcesUrl('icons/przelewy24.png')
		);
		parent::__construct();
	}
	
	public function createMethodFormFields() {
		$formFields = parent::createMethodFormFields();
		
		return array_merge(
			$formFields,
			$this->getMethodSettings()
		);
	}

}