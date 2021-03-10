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

require_once 'Customweb/Util/Rand.php';
require_once 'Customweb/Form/Control/IControl.php';


/**
 * This class implements the common used methods of a control interface. It provides 
 * render methods for rendering the prefix of a control, the management of the control id 
 * and name as well for the validators. 
 * 
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_Form_Control_Abstract implements Customweb_Form_Control_IControl {
	
	private $controlName;
	
	private $controlId;
	
	private $cssClass = ''; 

	private $namespacePrefix = null;
	
	/**
	 * @var Customweb_Form_Validator_IValidator[]
	 */
	private $validators = array();
	
	private $required = true;
	
	/**
	 * Constructor of the class
	 * 
	 * @param string $controlName The name of the control / field name.
	 */
	public function __construct($controlName) {
		$this->controlName = $controlName;
		$this->controlId = Customweb_Util_Rand::getUuid();
	}
	
	/**
	 * Return the unedited name of the control.
	 * 
	 * @return string
	 */
	public function getRawControlName() {
		return $this->controlName;
	}
	
	/**
	 * Returns the name of the control.
	 * 
	 * @return string Control Name
	 */
	public function getControlName() {
		$controlName = $this->controlName;

		$prefix = $this->namespacePrefix;
		if ($prefix == null) {
			return $controlName;
		}
		
		// Check if there is already a structured name used
		if (strstr($controlName, '[')) {
			$firstStartTag = strpos($controlName, '[');
			$lastTag = substr($controlName, 0, $firstStartTag);
			$remaining = substr($controlName, $firstStartTag);
			$controlName = '[' . $lastTag . ']' . $remaining;
			return $prefix . $controlName;
		}
		else {
			return $prefix . '[' . $controlName . ']';
		}
	}
	
	public function getControlNameAsArray() {
		$controlName = $this->getControlName();
		
		if (strstr($controlName, '[')) {
			$nameParts = array();
			foreach (explode('[', $controlName) as $part) {
				if (strstr($part, ']')) {
					$part = substr($part, 0, -1);
				}
				$nameParts[] = $part;
			}
			return $nameParts;
		} else {
			return array($controlName);
		}
	}
	
	public function setControlName($name) {
		$this->controlName = $name;
		return $this;
	}
	
	public function getControlId() {
		return $this->controlId;
	}
	
	public function render(Customweb_Form_IRenderer $renderer) {
		return $renderer->renderControlPrefix($this, $this->getControlTypeCssClass()) .
			$this->renderContent($renderer) .
			$renderer->renderControlPostfix($this, $this->getControlTypeCssClass());
	}
	
	public function getValidators() {
		return $this->validators;
	}
	
	/**
	 * This method adds a validtor to the set of validators of this 
	 * control.
	 * 
	 * @param Customweb_Form_Validator_IValidator $validator The validator to add
	 * @return Customweb_Form_Control_Abstract The current control
	 */
	public function addValidator(Customweb_Form_Validator_IValidator $validator) {
		
		if ($validator->getControl() === null) {
			throw new Exception("Could not add validator, because no control was set.");
		}
		
		$this->validators[] = $validator;
		return $this;
	}
	
	/**
	 * Sets the validators set.
	 * 
	 * @param array $validators The set of validators.
	 * @return Customweb_Form_Control_Abstract
	 */
	public function setValidators(array $validators) {
		$this->validators = $validators;
		return $this;
	}
	
	public function isRequired() {
		return $this->required;
	}
	
	/**
	 * Sets wheter this element is required or not.
	 * 
	 * @param boolean $required
	 * @return Customweb_Form_Control_Abstract
	 */
	public function setRequired($required) {
		$this->required = $required;
		return $this;
	}
	
	public function setCssClass($cssClass) {
		$this->cssClass = $cssClass;
		return $this;
	}
	
	public function getCssClass() {
		return $this->cssClass;
	}
	
	public function applyCssResolver(Customweb_Form_IControlCssClassResolver $resolver, Customweb_Form_IElement $element) {
		$this->setCssClass($resolver->resolveClass($this, $element));
	}
	
	public function applyNamespacePrefix($prefix) {
		$this->namespacePrefix = $prefix;
	}
	
	/**
	 * This method renders the main control (excluding the prefix and postfix of the 
	 * control).
	 * 
	 * @param Customweb_Form_IRenderer $renderer
	 * @return string HTML rendered
	 */
	abstract public function renderContent(Customweb_Form_IRenderer $renderer);
	
	/**
	 * This method returns the CSS class set on the prefix of the control.
	 * 
	 * @return string CSS class for this control
	 */
	abstract public function getControlTypeCssClass();
	
}