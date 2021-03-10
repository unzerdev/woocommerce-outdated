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
 * 
 * This control implementation presents the user a dropdown box. The user can 
 * select exactly one option from out of the dropdown. 
 * 
 * This is simlar to the Customweb_Form_Control_Radio implementation execept that
 * the user has not a list of radio buttons.
 * 
 * @see Customweb_Form_Control_Radio
 * 
 * @author hunziker
 *
 */
class Customweb_Form_Control_Select extends Customweb_Form_Control_AbstractEditable {

	private $options = array();
	
	private $defaultValue = '';

	/**
	 * Constructor
	 * 
	 * @param string $controlName Control Name
	 * @param array $options A key / value map. Where the key is the submitted value and the value is the label of the option.
	 * @param string $defaultValue The preselected option
	 */
	public function __construct($controlName, $options, $defaultValue = '') {
		parent::__construct($controlName);
		$this->defaultValue = $defaultValue;
		$this->options = $options;
	}
	
	/**
	 * This method returns the pre-selected option.
	 *
	 * @return string Pre-selected Option
	 */
	public function getDefaultValue() {
		return $this->defaultValue;
	}
	
	/**
	 * This method returns a key / value map of the options available to the 
	 * user. The key is the value submitted and the value is the label of the 
	 * option.
	 * 
	 * @return array Key / Value map of the options
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_Control_Abstract::renderContent()
	 */
	public function renderContent(Customweb_Form_IRenderer $renderer) {
		$result = '<select name="'. $this->getControlName() . '" id="'. $this->getControlId() . '" class="' . $this->getCssClass() . '">';
		
		foreach ($this->getOptions() as $key => $label) {
			$result .= '<option value="' . $key . '"';
			if ($this->getDefaultValue() == $key) {
				$result .= ' selected="selected" ';
			}
			$result .= '>' . $label . '</option>';
		}
		$result .= '</select>';
		return $result;
	}
	
	/**
	 * This method returns the JS code to validate this field.
	 * 
	 * @return string JS string
	 */
	public function getNotEmptyJsCondition() {
		return 'element.options[element.selectedIndex].value != "none"';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_Control_Abstract::getControlTypeCssClass()
	 */
	public function getControlTypeCssClass() {
		return 'select-field';
	}
	
}