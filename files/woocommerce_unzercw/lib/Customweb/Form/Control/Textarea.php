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
 * This control implements a textarea.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Form_Control_Textarea extends Customweb_Form_Control_AbstractEditable {

	private $defaultValue = '';
	
	/**
	 * 
	 * @param string $controlName Control Name
	 * @param string $defaultValue Default value of the textbox
	 */
	public function __construct($controlName, $defaultValue = '') {
		parent::__construct($controlName);
		$this->defaultValue = $defaultValue;
	}
	
	/**
	 * The default (preset) value of the textarea.
	 *
	 * @return string Default Value
	 */
	public function getDefaultValue() {
		return $this->defaultValue;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_Control_Abstract::renderContent()
	 */
	public function renderContent(Customweb_Form_IRenderer $renderer) {
		return '<textarea name="'. $this->getControlName() . '" id="'. $this->getControlId() . '" class="' . $this->getCssClass() . '">' . $this->getDefaultValue() . '</textarea>';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_Control_Abstract::getControlTypeCssClass()
	 */
	public function getControlTypeCssClass() {
		return 'textarea-field';
	}

}