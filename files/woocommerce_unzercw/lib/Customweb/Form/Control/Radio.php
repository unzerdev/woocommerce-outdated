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
 * This control implementation presents the user a set of radio buttons, from
 * which he / she can select exactly one. 
 * 
 * This implementation is simlar to the select, execpt this implemenation provides
 * radio buttons and not a select box.
 * 
 * @see Customweb_Form_Control_Select
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Form_Control_Radio extends Customweb_Form_Control_AbstractEditable {

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
		$result = '';
		
		foreach ($this->getOptions() as $key => $label) {
			$result .= $renderer->renderOptionPrefix($this, $key);
			$result .= '<input type="radio" name="' . $this->getControlName() . '" class="' . $this->getCssClass() . '" ';
			if ($this->getDefaultValue() == $key) {
				$result .= ' checked="checked" ';
			}
			$result .= ' value="' . $key . '" id="' . $this->getControlId() . '-' . $key . '" />';
			
			$result .= '<label for="' . $this->getControlId() . '-' . $key . '">' . $label . '</label>';
			$result .= $renderer->renderOptionPostfix($this, $key);
		}
		return $result;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_Control_Abstract::getControlTypeCssClass()
	 */
	public function getControlTypeCssClass() {
		return 'radio-field';
	}
	
}