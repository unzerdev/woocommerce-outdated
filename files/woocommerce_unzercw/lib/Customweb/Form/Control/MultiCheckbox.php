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
 * This class implements a control, which provides multiple checkboxes from which
 * the user can select multiple.
 * 
 * The data in the $_POST is not standardized by browsers for such elements, hence 
 * this element should be used carefully. It should only be used, if the form 
 * target is controlled. 
 * 
 * @see Customweb_Form_Control_MultiSelect
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Form_Control_MultiCheckbox extends Customweb_Form_Control_AbstractEditable {

	private $defaultValues = array();
	
	private $options = array();

	/**
	 * 
	 * @param string $controlName The control name
	 * @param array $options Options which has the user. This is a key / value map. Where the value is the label of the checkbox.
	 * @param array $defaultValues The pre-selected options.
	 */
	public function __construct($controlName, array $options, $defaultValues = array()) {
		parent::__construct($controlName);
		$this->setDefaultValues($defaultValues);
		$this->options = $options;
	}
	
	protected function setDefaultValues($defaultValues) {
		if ($defaultValues == null) {
			$this->defaultValues = array();
		} elseif (!is_array($defaultValues)) {
			$this->defaultValues = array($defaultValues);
		} else {
			$this->defaultValues = $defaultValues;
		}
	}

	/**
	 * A list of options pre-selected.
	 * 
	 * @return array The pre-selected options.
	 */
	public function getDefaultValues() {
		return $this->defaultValues;
	}
	
	/**
	 * The options array is a key / value map. The key is the key of the option
	 * and the value is the label of the option.
	 * 
	 * @return array Options to shown to the user.
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
			$result .= '<input type="checkbox" name="' . $this->getControlName() . '[' . $key . ']" class="' . $this->getCssClass() . '" ';
			if (in_array($key, $this->getDefaultValues())) {
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
		return 'multi-checkbox-field';
	}
	
}