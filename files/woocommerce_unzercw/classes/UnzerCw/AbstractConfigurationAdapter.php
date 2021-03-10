<?php
/**
 * * You are allowed to use this API in your web application.
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

require_once 'Customweb/Core/Stream/Input/File.php';
require_once 'Customweb/Payment/IConfigurationAdapter.php';


/**
 *
 */
abstract class UnzerCw_AbstractConfigurationAdapter implements Customweb_Payment_IConfigurationAdapter
{
	
	protected $settingsMap=array(
		'operating_mode' => array(
			'id' => 'unzer-operating-mode-setting',
 			'machineName' => 'operating_mode',
 			'type' => 'select',
 			'label' => 'Operation Mode',
 			'description' => 'Operation mode of the shop.',
 			'defaultValue' => 'test',
 			'allowedFileExtensions' => array(
			),
 		),
 		'public_key_live' => array(
			'id' => 'unzer-public-key-live-setting',
 			'machineName' => 'public_key_live',
 			'type' => 'textfield',
 			'label' => 'Public Key (Live)',
 			'description' => 'Public Key for live requests, provided by Unzer.',
 			'defaultValue' => '',
 			'allowedFileExtensions' => array(
			),
 		),
 		'private_key_live' => array(
			'id' => 'unzer-private-key-live-setting',
 			'machineName' => 'private_key_live',
 			'type' => 'textfield',
 			'label' => 'Private Key (Live)',
 			'description' => 'Private Key for live requests, provided by Unzer.',
 			'defaultValue' => '',
 			'allowedFileExtensions' => array(
			),
 		),
 		'public_key_test' => array(
			'id' => 'unzer-public-key-test-setting',
 			'machineName' => 'public_key_test',
 			'type' => 'textfield',
 			'label' => 'Public Key (Test)',
 			'description' => 'Public Key for test requests, provided by Unzer.',
 			'defaultValue' => '',
 			'allowedFileExtensions' => array(
			),
 		),
 		'private_key_test' => array(
			'id' => 'unzer-private-key-test-setting',
 			'machineName' => 'private_key_test',
 			'type' => 'textfield',
 			'label' => 'Private Key (Test)',
 			'description' => 'Private Key for test requests, provided by Unzer.',
 			'defaultValue' => '',
 			'allowedFileExtensions' => array(
			),
 		),
 		'order_id_schema' => array(
			'id' => 'unzer-order-id-schema-setting',
 			'machineName' => 'order_id_schema',
 			'type' => 'textfield',
 			'label' => 'OrderId Schema',
 			'description' => 'Here you can set a schema for the orderId parameter transmitted to identify the payment. If left empty it is not transmitted. The following placeholders can be used: {oid} for the order id, which may not be unique or set; {tid} for the sellxed transaction id which is a unique number, or {id} which contains the order id and is guaranteed to be unique.',
 			'defaultValue' => '{id}',
 			'allowedFileExtensions' => array(
			),
 		),
 		'payment_reference_schema' => array(
			'id' => 'unzer-payment-reference-schema-setting',
 			'machineName' => 'payment_reference_schema',
 			'type' => 'textfield',
 			'label' => 'PaymentReference Schema',
 			'description' => 'Here you can set a schema for the paymentReference parameter transmitted to identify the payment. If left empty it is not transmitted. The following placeholders can be used: {oid} for the order id, which may not be unique or set; {tid} for the sellxed transaction id which is a unique number, or {id} which contains the order id and is guaranteed to be unique.',
 			'defaultValue' => '{id}',
 			'allowedFileExtensions' => array(
			),
 		),
 		'invoice_id_schema' => array(
			'id' => 'unzer-invoice-id-schema-setting',
 			'machineName' => 'invoice_id_schema',
 			'type' => 'textfield',
 			'label' => 'InvoiceID Schema',
 			'description' => 'Here you can set a schema for the invoiceId parameter transmitted to identify the payment. If left empty it is not transmitted. The following placeholders can be used: {oid} for the order id, which may not be unique or set; {tid} for the sellxed transaction id which is a unique number, or {id} which contains the order id and is guaranteed to be unique.',
 			'defaultValue' => '{id}',
 			'allowedFileExtensions' => array(
			),
 		),
 		'review_input_form' => array(
			'id' => 'woocommerce-input-form-in-review-pane-setting',
 			'machineName' => 'review_input_form',
 			'type' => 'select',
 			'label' => 'Review Input Form',
 			'description' => 'Should the input form for credit card data rendered in the review pane? To work the user must have JavaScript activated. In case the browser does not support JavaScript a fallback is provided. This feature is not supported by all payment methods.',
 			'defaultValue' => 'active',
 			'allowedFileExtensions' => array(
			),
 		),
 		'order_identifier' => array(
			'id' => 'woocommerce-order-number-setting',
 			'machineName' => 'order_identifier',
 			'type' => 'select',
 			'label' => 'Order Identifier',
 			'description' => 'Set which identifier should be sent to the payment service provider. If a plugin modifies the order number and can not guarantee it\'s uniqueness, select Post Id.',
 			'defaultValue' => 'ordernumber',
 			'allowedFileExtensions' => array(
			),
 		),
 		'log_level' => array(
			'id' => '',
 			'machineName' => 'log_level',
 			'type' => 'select',
 			'label' => 'Log Level',
 			'description' => 'Messages of this or a higher level will be logged.',
 			'defaultValue' => 'error',
 			'allowedFileExtensions' => array(
			),
 		),
 	);

	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_IConfigurationAdapter::getConfigurationValue()
	 */
	public function getConfigurationValue($key, $languageCode = null) {
	    if (!isset($this->settingsMap[$key])) {
	        return null;
	    }
		$setting = $this->settingsMap[$key];
		$value =  get_option('woocommerce_unzercw_' . $key, $setting['defaultValue']);
		
		if($setting['type'] == 'file') {
			if(isset($value['path']) && file_exists($value['path'])) {
				return new Customweb_Core_Stream_Input_File($value['path']);
			}
			else {
				$resolver = UnzerCw_Util::getAssetResolver();
				return $resolver->resolveAssetStream($setting['defaultValue']);
			}
		}
		else if($setting['type'] == 'multiselect') {
			if(empty($value)){
				return array();
			}
		}
		return $value;
	}
		
	public function existsConfiguration($key, $languageCode = null) {
	    if (!isset($this->settingsMap[$key])) {
	        return false;
	    }
		if ($languageCode !== null) {
			$languageCode = (string)$languageCode;
		}
		$value = get_option('woocommerce_unzercw_' . $key, null);
		if ($value === null) {
			return false;
		}
		else {
			return true;
		}
	}
	
	
}