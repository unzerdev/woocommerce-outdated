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

require_once 'Customweb/Unzer/Form/StopValidator.php';
require_once 'Customweb/Unzer/Authorization/Transaction.php';
require_once 'Customweb/Form/Element.php';
require_once 'Customweb/Payment/Authorization/IPaymentCustomerContext.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Form/Control/Html.php';
require_once 'Customweb/Form/ElementFactory.php';
require_once 'Customweb/Unzer/Form/B2BValidator.php';
require_once 'Customweb/Form/Control/Select.php';
require_once 'Customweb/Form/Control/TextInput.php';


/**
 * Form Util methods.
 * To simplify access all permitted form data is saved to paymentCustomerContext, and should be retrieved from there.
 *
 * @author Sebastian Bossert
 */
final class Customweb_Unzer_Util_Form {
	/**
	 * Toggle the required option on all controls easily => visual indicator.
	 *
	 * @var boolean
	 */
	const FIELDS_REQUIRED = false;

	/**
	 * Fields which should be entered by the customer during checkout via getVisibleFormFields, and should besaved to paymentCustomerContext.
	 *
	 * @var array
	 */
	private static $allowedFormFields = array(
		'unzer-dob-y',
		'unzer-dob-m',
		'unzer-dob-d',
		'unzer-commercial-register-number',
		'unzer-commercial-sector',
		'unzer-salutation',
		'unzer-installments',
		'unzer-email'
	);

	private function __construct(){}

	public static function processFormData($obj, array $formData){
		$filtered = self::filterFormData($formData);
		if ($obj instanceof Customweb_Unzer_Authorization_Transaction) {
			$obj->setFormData($filtered);
			$obj->getPaymentCustomerContext()->updateMap($filtered);
		}
		else if ($obj instanceof Customweb_Payment_Authorization_IPaymentCustomerContext) {
			$obj->updateMap($filtered);
		}
	}

	/**
	 * Get a date of birth field.
	 * If used in a B2B context pass the registerNumberControlId to switch validators.
	 *
	 * @param Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext
	 * @param number $minimumAge
	 * @param string|null $registerNumberControlId
	 * @return Customweb_Form_Element
	 */
	public static function getDateOfBirthField(Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext, $minimumAge = 18, $registerNumberControlId = null){
		$map = $paymentContext->getMap();
		$element = Customweb_Form_ElementFactory::getDateOfBirthElement('unzer-dob-y', 'unzer-dob-m', 'unzer-dob-d',
				self::getDefaultValue($map, 'unzer-dob-y'), self::getDefaultValue($map, 'unzer-dob-m'),
				self::getDefaultValue($map, 'unzer-dob-d'), null, $minimumAge);
		if ($registerNumberControlId) {
			foreach ($element->getControl()->getSubControls() as $control) {
				$validator = new Customweb_Unzer_Form_B2BValidator($control, $registerNumberControlId);
				$control->setValidators(array(
					$validator
				));
				$control->setRequired(self::FIELDS_REQUIRED);
			}
		}
		$element->setRequired(self::FIELDS_REQUIRED);
		return $element;
	}

	public static function getCommercialRegisterNumberField(Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext){
		$control = new Customweb_Form_Control_TextInput('unzer-commercial-register-number',
				self::getDefaultValue($paymentCustomerContext->getMap(), 'unzer-commercial-register-number'));
		$control->addValidator(new Customweb_Unzer_Form_B2BValidator($control, $control->getControlId()));
		$control->setRequired(self::FIELDS_REQUIRED);
		$element = new Customweb_Form_Element(Customweb_I18n_Translation::__("Commercial Register Number"), $control,
				Customweb_I18n_Translation::__("Either enter your commercial register number, or all other fields which are displayed."));
		$element->setRequired(self::FIELDS_REQUIRED);
		return $element;
	}

	public static function getCommercialSectorField(Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext, $registerNumberControlId){
		$control = new Customweb_Form_Control_TextInput('unzer-commercial-sector',
				self::getDefaultValue($paymentCustomerContext->getMap(), 'unzer-commercial-sector'));
		$control->addValidator(new Customweb_Unzer_Form_B2BValidator($control, $registerNumberControlId));
		$control->setRequired(self::FIELDS_REQUIRED);
		$element = new Customweb_Form_Element(Customweb_I18n_Translation::__("Commercial Sector"), $control,
				Customweb_I18n_Translation::__("Enter the sector your company operates in, e.g. finance."));
		$element->setRequired(self::FIELDS_REQUIRED);
		return $element;
	}
	
	public static function getEmailField(Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext) {
		$control = new Customweb_Form_Control_TextInput('unzer-email', 
				self::getDefaultValue($paymentCustomerContext->getMap(), 'unzer-email'));
		$element = new Customweb_Form_Element(Customweb_I18n_Translation::__("Email"), $control,
				Customweb_I18n_Translation::__("Enter your email address."));
		return $element;
	}

	public static function getSalutationField(Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext){
		$options = array(
			'mr' => Customweb_I18n_Translation::__("Mr")->toString(),
			'mrs' => Customweb_I18n_Translation::__("Mrs")->toString()
		);
		$control = new Customweb_Form_Control_Select('unzer-salutation', $options,
				self::getDefaultValue($paymentCustomerContext->getMap(), 'unzer-salutation'));
		$element = new Customweb_Form_Element(Customweb_I18n_Translation::__("Salutation"), $control,
				Customweb_I18n_Translation::__("Enter your preferred salutation."));
		return $element;
	}

	public static function getStopElement($message){
		$validationFailed = new Customweb_Form_Control_Html('stop_element', $message);
		$validationFailed->addValidator(new Customweb_Unzer_Form_StopValidator($validationFailed));
		$element = new Customweb_Form_Element(Customweb_I18n_Translation::__('Payment Failed'), $validationFailed);
		$element->setRequired(false);
		return $element;
	}

	public static function getMappedSalutation(Customweb_Payment_Authorization_OrderContext_IAddress $address){
		$mappings = array(
			'male' => 'mr',
			'female' => 'mrs',
			'mr' => 'mr',
			'ms' => 'mrs',
			'miss' => 'mrs',
			'mz' => 'mrs',
			'mrs' => 'mrs'
		);
		$keys = array(
			strtolower($address->getSalutation()),
			strtolower($address->getGender())
		);
		foreach ($keys as $key) {
			if (isset($mappings[$key])) {
				return $mappings[$key];
			}
		}
		return 'unknown';
	}

	private static function filterFormData(array $formData){
		return array_intersect_key($formData, array_flip(self::$allowedFormFields));
	}

	private static function getDefaultValue(array $map, $key){
		if (isset($map[$key])) {
			return $map[$key];
		}
		return null;
	}
}
