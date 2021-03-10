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

require_once 'Customweb/Form/Control/AbstractEditable.php';
require_once 'Customweb/Form/Control/Abstract.php';


/**
 * This class provides the default implementation for a input 
 * field. The type of the input field must be provided in the 
 * subclasses.
 * 
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_Form_Control_AbstractInputField extends Customweb_Form_Control_AbstractEditable {
	
	private $defaultValue = '';
	
	private $autocomplete = true;
	
	/**
	 * The constructor.
	 * 
	 * @param string $controlName Name of the control
	 * @param string $defaultValue The default value set
	 */
	public function __construct($controlName, $defaultValue = '') {
		parent::__construct($controlName);
		$this->defaultValue = $defaultValue;
	}
	
	/**
	 * The default (preset) value of the input field.
	 *
	 * @return string Default Value
	 */
	public function getDefaultValue() {
		return $this->defaultValue;
	}
	
	/**
	 * This method returns if the field has active auto complete or not.
	 * 
	 * @return boolean True, when the autocomplete feature of the browser
	 *                 is active for this field.
	 */
	public function isAutocomplete() {
		return $this->autocomplete;
	}
	
	/**
	 * This method sets whether the autocomplete feature is active
	 * for this control or not.
	 * 
	 * @param boolean $autocomplete
	 * @return Customweb_Form_Control_AbstractInputField
	 */
	public function setAutocomplete($autocomplete) {
		$this->autocomplete = $autocomplete;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_Control_Abstract::renderContent()
	 */
	public function renderContent(Customweb_Form_IRenderer $renderer) {
		$autocomplete = '';
		if (!$this->isAutocomplete()) {
			$autocomplete = ' autocomplete="off" ';
		}
		$value = str_replace('"', '&quot;', $this->getDefaultValue());
		
		return '<input type="' . $this->getInputType() . '" ' . $autocomplete . ' name="'. $this->getControlName() . '" id="'. $this->getControlId() . '" value="' . $value . '" class="' . $this->getCssClass() . '" />';
	}
	
	/**
	 * This method has to return the type of the input field.
	 * 
	 * @return string Type of the input field.
	 */
	abstract public function getInputType();
	
}