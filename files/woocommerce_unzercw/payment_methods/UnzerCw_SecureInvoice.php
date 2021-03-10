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

class UnzerCw_SecureInvoice extends UnzerCw_PaymentMethod
{
	public $machineName = 'secureinvoice';
	public $admin_title = 'Secure Invoice';
	public $title = 'Secure Invoice';
	
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
			'woocommerce_unzercw_secureinvoice_icon', 
			UnzerCw_Util::getResourcesUrl('icons/secureinvoice.png')
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