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

require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Payment/BackendOperation/Form/Abstract.php';
require_once 'Customweb/Form/Element.php';
require_once 'Customweb/Form/ElementGroup.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Form/Control/SingleCheckbox.php';
require_once 'Customweb/Payment/ExternalCheckout/AbstractProviderService.php';
require_once 'Customweb/Form/Control/TextInput.php';

abstract class Customweb_Payment_ExternalCheckout_AbstractBackendForm extends Customweb_Payment_BackendOperation_Form_Abstract {

	public function isProcessable(){
		return true;
	}

	public function getTitle(){
		return Customweb_I18n_Translation::__("External Checkout");
	}

	public function getElementGroups(){
		$settingHandler = $this->getSettingHandler();
		
		$formGroups = array();
		foreach ($this->getCheckouts() as $checkout) {
			$checkoutGroup = new Customweb_Form_ElementGroup();
			$checkoutGroup->setTitle($checkout->getName());
			$checkoutGroup->setMachineName($checkout->getMachineName());
			
			// Single Checkbox
			// @formatter:off
			$element = new Customweb_Form_Element('Active',
				new Customweb_Form_Control_SingleCheckbox(
					$checkout->getMachineName() . '[active]', 
					'yes', 
					'Active',
					$checkout->isActive()
				), 
				null, 
				false,
				!$settingHandler->hasCurrentStoreSetting($checkout->getMachineName() . '_active')
			);
			$element->setDescription(Customweb_I18n_Translation::__("Check to activate the external checkout."));
			$checkoutGroup->addElement($element);
			
			// Input Field
			$element = new Customweb_Form_Element('Sort Order',
				new Customweb_Form_Control_TextInput(
					$checkout->getMachineName() . '[sort_order]', 
					$checkout->getSortOrder()
				), 
				null, 
				false,
				!$settingHandler->hasCurrentStoreSetting($checkout->getMachineName() . '_sort_order')
			);
			$element->setDescription(Customweb_I18n_Translation::__("Set the sort order to show the external checkouts."));
			$checkoutGroup->addElement($element);
			
			// Minimal Order Total
			$element = new Customweb_Form_Element('Minimal Order Total',
				new Customweb_Form_Control_TextInput(
					$checkout->getMachineName() . '[minimal_order_total]',
					$checkout->getMinimalOrderTotal()
				),
				null,
				false,
				!$settingHandler->hasCurrentStoreSetting($checkout->getMachineName() . '_minimal_order_total')
			);
			$element->setDescription(Customweb_I18n_Translation::__("Define a minimal order total for this checkout to be available."));
			$checkoutGroup->addElement($element);
			
			// Maximal Order Total
			$element = new Customweb_Form_Element('Maximal Order Total',
					new Customweb_Form_Control_TextInput(
							$checkout->getMachineName() . '[maximal_order_total]',
							$checkout->getMaximalOrderTotal()
					),
					null,
					false,
					!$settingHandler->hasCurrentStoreSetting($checkout->getMachineName() . '_maximal_order_total')
			);
			$element->setDescription(Customweb_I18n_Translation::__("Define a maximal order total for this checkout to be available."));
			$checkoutGroup->addElement($element);
			// @formatter:on
			
			$formGroups[] = $checkoutGroup;
		}
		
		return $formGroups;
	}

	public function getButtons(){
		return array(
			$this->getSaveButton() 
		);
	}

	/**
	 *
	 * @throws Customweb_Core_Exception_CastException
	 * @return Customweb_Payment_ExternalCheckout_AbstractCheckout
	 */
	protected function getCheckouts(){
		$provider = $this->getContainer()->getBean('Customweb_Payment_ExternalCheckout_AbstractProviderService');
		if (!($provider instanceof Customweb_Payment_ExternalCheckout_AbstractProviderService)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Payment_ExternalCheckout_AbstractProviderService');
		}
		return $provider->getCheckoutsUnfiltered();
	}
}