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

require_once 'Customweb/Form/Element.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Unzer/Method/Default.php';
require_once 'Customweb/Form/Control/Html.php';


/**
 *
 * @author Sebastian Bossert
 * @Method(paymentMethods={'directdebitssepa', 'securesepa'})
 */
class Customweb_Unzer_Method_Sepa extends Customweb_Unzer_Method_Default {

	public function getRequiredPlaceholders(){
		return array(
			'iban' => Customweb_I18n_Translation::__("IBAN")
		);
	}

	public function getRequiredInputFields(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext, $aliasTransaction = null){
		$fields = parent::getRequiredInputFields($orderContext, $paymentCustomerContext, $aliasTransaction);
		$fields[] = $this->getMandateElement();
		return $fields;
	}

	protected function getMandateElement(){
		$control = new Customweb_Form_Control_Html('unzer-mandate', '<div class=\'unzer-mandate\'>' . $this->getMandateText() . '</div>');
		return new Customweb_Form_Element(Customweb_I18n_Translation::__('Mandate'), $control);
	}

	protected function getMandateText(){
		return Customweb_I18n_Translation::__(
				'<p>By signing this mandate form, you authorise @merchantName to send instructions to your bank to debit your account and your bank to debit your account in accordance with the instructions from @merchantName.</p><p>Note: As part of your rights, you are entitled to a refund from your bank under the terms and conditions of your agreement with your bank. A refund must be claimed within 8 weeks starting from the date on which your account was debited. Your rights regarding this SEPA mandate are explained in a statement that you can obtain from your bank.</p><p>In case of refusal or rejection of direct debit payment I instruct my bank irrevocably to inform @merchantName or any third party upon request about my name, address and date of birth.</p>',
				array(
					'@merchantName' => $this->getMerchantName()
				));
	}

	protected function getMerchantName() {
		$name = trim($this->getPaymentMethodConfigurationValue('merchant_name'));
		if(empty($name)) {
			throw new Exception(Customweb_I18n_Translation::__('You have to configure the merchant name in the payment method configuration.'));
		}
		return $name;
	}
	
	public function isShipmentSupported() {
		return false; //TODO fix in XML, remove hardcoded
	}
}
