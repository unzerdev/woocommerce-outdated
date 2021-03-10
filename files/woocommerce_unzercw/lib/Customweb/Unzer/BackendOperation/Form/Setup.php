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

require_once 'Customweb/Payment/BackendOperation/Form/Abstract.php';
require_once 'Customweb/Form/ElementGroup.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Form/Control/Html.php';
require_once 'Customweb/Form/WideElement.php';


/**
 *
 * @BackendForm
 */
class Customweb_Unzer_BackendOperation_Form_Setup extends Customweb_Payment_BackendOperation_Form_Abstract {

	public function getTitle(){
		return Customweb_I18n_Translation::__("Setup");
	}

	public function getElementGroups(){
		return array(
			$this->getSetupGroup()
		);
	}

	private function getSetupGroup(){
		$group = new Customweb_Form_ElementGroup();
		$group->setTitle(Customweb_I18n_Translation::__("Short Installation Instructions:"));

		$control = new Customweb_Form_Control_Html('description',
				Customweb_I18n_Translation::__(
						'This is a brief installation instruction of the main and most important installation steps. It is important that you strictly follow the check-list. Only by doing so, the secure usage in correspondence with all security regulations can be guaranteed.'));
		$element = new Customweb_Form_WideElement($control);
		$group->addElement($element);

		$control = new Customweb_Form_Control_Html('steps', $this->createOrderedList($this->getSteps()));

		$element = new Customweb_Form_WideElement($control);
		$group->addElement($element);
		return $group;
	}

	private function getSteps(){
		return array(
			Customweb_I18n_Translation::__("Enter the public and private key received from Unzer."),
			Customweb_I18n_Translation::__('Activate the payment methods you would like to offer.'),
			Customweb_I18n_Translation::__(
					'In some cases payment methods may use separate keys. If this is the case, add the keys found in the Unzer backend to the payment method configuration in your store.')
		);
	}

	private function createOrderedList(array $steps){
		$list = '<ol>';
		foreach ($steps as $step) {
			$list .= "<li>$step</li>";
		}
		$list .= '</ol>';
		return $list;
	}
}