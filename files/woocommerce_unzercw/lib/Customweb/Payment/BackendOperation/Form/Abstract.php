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

require_once 'Customweb/Payment/BackendOperation/IForm.php';
require_once 'Customweb/Util/Rand.php';
require_once 'Customweb/Payment/BackendOperation/Form/IProcessable.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Form/IButton.php';
require_once 'Customweb/Form/Button.php';

abstract class Customweb_Payment_BackendOperation_Form_Abstract implements Customweb_Payment_BackendOperation_IForm, 
		Customweb_Payment_BackendOperation_Form_IProcessable {
	private $container = null;
	private $id = null;
	private $saveButton = null;

	public function __construct(Customweb_DependencyInjection_IContainer $container){
		$this->container = $container;
		$this->id = Customweb_Util_Rand::getUuid();
	}

	public function isProcessable(){
		return false;
	}

	public final function getId(){
		return $this->id;
	}

	public function getMachineName(){
		return strtolower(get_class($this));
	}

	public function getTargetUrl(){
		return '#';
	}

	public function getTargetWindow(){
		return self::TARGET_WINDOW_SAME;
	}

	public function getRequestMethod(){
		return self::REQUEST_METHOD_POST;
	}

	public function getElementGroups(){
		return array();
	}

	public function getElements(){
		$elements = array();
		foreach ($this->getElementGroups() as $elementGroup) {
			foreach ($elementGroup->getElements() as $element) {
				$elements[$element->getElementId()] = $element;
			}
		}
		return $elements;
	}

	public function getButtons(){
		return array();
	}

	protected function getSaveButton(){
		if ($this->saveButton === null) {
			$this->saveButton = new Customweb_Form_Button();
			$this->saveButton->setMachineName("save")->setTitle(Customweb_I18n_Translation::__("Save"))->setType(Customweb_Form_IButton::TYPE_SUCCESS);
		}
		return $this->saveButton;
	}

	/**
	 *
	 * @return Customweb_DependencyInjection_IContainer
	 */
	protected final function getContainer(){
		return $this->container;
	}

	public function process(Customweb_Form_IButton $pressedButton, array $formData){
		if ($pressedButton->getMachineName() === 'save') {
			$this->getSettingHandler()->processForm($this, $formData);
		}
	}

	protected final function getSettingValue($key){
		return $this->getSettingHandler()->getSettingValue($key);
	}

	protected final function setSettingValue($key, $value){
		$this->getSettingHandler()->setSettingValue($key, $value);
	}

	/**
	 *
	 * @return Customweb_Payment_SettingHandler
	 */
	protected final function getSettingHandler(){
		return $this->getContainer()->getBean('Customweb_Payment_SettingHandler');
	}

	/**
	 *
	 * @return Customweb_Payment_Endpoint_IAdapter
	 */
	protected final function getEndpointAdapter(){
		return $this->getContainer()->getBean('Customweb_Payment_Endpoint_IAdapter');
	}
}