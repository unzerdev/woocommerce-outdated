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

require_once 'Customweb/Payment/BackendOperation/Form/Abstract.php';
require_once 'Customweb/Form/Element.php';
require_once 'Customweb/Form/ElementGroup.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Form/Control/Html.php';


abstract class Customweb_Payment_BackendOperation_Form_AbstractAbout extends Customweb_Payment_BackendOperation_Form_Abstract {

	abstract protected function getVersion();
	
	abstract protected function getReleaseDate();
	
	abstract protected function getOrderNumber();
	
	public function getTitle() {
		return Customweb_I18n_Translation::__("About");
	}
	
	public function getElementGroups() {
		return array(
			$this->getElementGroup(),
		);
	}
	
	private function getElementGroup() {
		$group = new Customweb_Form_ElementGroup();
		$group
			->addElement($this->getAuthorElement())
			->addElement($this->getVersionNumberElement())
			->addElement($this->getReleaseDateElement())
			->addElement($this->getOrderIncrementIdElement())
			->addElement($this->getSupportElement());
		return $group;
	}

	private function getAuthorElement() {
		$control = new Customweb_Form_Control_Html('author', Customweb_I18n_Translation::__("customweb ltd"));
		$element = new Customweb_Form_Element(Customweb_I18n_Translation::__("Author"), $control);
		$element->setRequired(false);
		return $element;
	}

	private function getVersionNumberElement() {
		$control = new Customweb_Form_Control_Html('version', $this->getVersion());
		$element = new Customweb_Form_Element(Customweb_I18n_Translation::__("Version"), $control);
		$element->setRequired(false);
		return $element;
	}

	private function getReleaseDateElement() {
		$control = new Customweb_Form_Control_Html('releaseDate', $this->getReleaseDate());
		$element = new Customweb_Form_Element(Customweb_I18n_Translation::__("Release Date"), $control);
		$element->setRequired(false);
		return $element;
	}
	
	private function getOrderIncrementIdElement() {
		$control = new Customweb_Form_Control_Html('orderIncrementId', $this->getOrderNumber());
		$element = new Customweb_Form_Element(Customweb_I18n_Translation::__("Order #"), $control);
		$element->setRequired(false);
		return $element;
	}
	
	private function getSupportElement() {
		$control = new Customweb_Form_Control_Html('supportText', Customweb_I18n_Translation::__(
			"If you have any issues with the module please feel free to contact us. See our <a href='https://www.sellxed.com/en/support' target='_blank'>support page</a> for more information."
		));
		$element = new Customweb_Form_Element(Customweb_I18n_Translation::__("Support"), $control);
		$element->setRequired(false);
		return $element;
	}
	
}