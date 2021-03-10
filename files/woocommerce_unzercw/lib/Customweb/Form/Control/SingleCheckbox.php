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


/**
 * This control implements a single checkbox. The user can check the box or not.
 * This control is usable for boolean (yes / no) user inputs.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Form_Control_SingleCheckbox extends Customweb_Form_Control_AbstractEditable {

	private $value = 'on';
	private $label = '';
	
	private $checked = false;

	/**
	 * 
	 * @param string $controlName Control name
	 * @param string $value The value to send, when the user check the box
	 * @param string $label The label of the box.
	 * @param boolean $checked The checkbox is pre-checked or not.
	 */
	public function __construct($controlName, $value, $label, $checked = false) {
		parent::__construct($controlName);
		$this->checked = $checked;
		$this->value = $value;
		$this->label = $label;
	}

	/**
	 * Checks whether the checkbox should be pre-selected or not.
	 * 
	 * @return boolean True, when the checkbox should be pre-selected. 
	 */
	public function isChecked() {
		return $this->checked;
	}
	
	/**
	 * The value submitted to the target URL, when the user checked
	 * this control.
	 * 
	 * @return string Value of the input field
	 */
	public function getValue() {
		return $this->value;
	}
	
	/**
	 * The label of the checkbox.
	 * 
	 * @return string Label of the checkbox
	 */
	public function getLabel() {
		return $this->label;
	}

	public function renderContent(Customweb_Form_IRenderer $renderer) {
		$result = $renderer->renderOptionPrefix($this, $this->getValue());
		$result .= '<input type="checkbox" name="' . $this->getControlName() . '" class="' . $this->getCssClass() . '" ';
		if ($this->isChecked()) {
			$result .= ' checked="checked" ';
		}
		$result .= ' value="' . $this->getValue() . '" id="' . $this->getControlId() . '" /> ';
		$result .= '<label for="' . $this->getControlId() . '">' . $this->getLabel() . '</label>';
		$result .= $renderer->renderOptionPostfix($this, $this->getValue());
		
		return $result;
	}
	
	public function getControlTypeCssClass() {
		return 'single-checkbox-field';
	}
	
}