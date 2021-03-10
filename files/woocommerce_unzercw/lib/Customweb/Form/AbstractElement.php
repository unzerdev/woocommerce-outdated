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

require_once 'Customweb/Form/Intention/Factory.php';
require_once 'Customweb/Form/Control/IEditableControl.php';
require_once 'Customweb/Form/IElement.php';


/**
 * This element implementation provides the default methods for the
 * interface Customweb_Form_IElement.
 *
 * @see Customweb_Form_IElement
 */
abstract class Customweb_Form_AbstractElement implements Customweb_Form_IElement
{
	/**
	 * @var Customweb_Form_Control_IControl
	 */
	private $control;

	/**
	 * @var string
	 */
	private $elementId;

	/**
	 * @var string
	 */
	private $description = '';

	/**
	 * @var boolean
	 */
	private $required = true;

	/**
	 * @var Customweb_Form_Intention_IIntention
	 */
	private $intention = null;

	/**
	 * @var string
	 */
	private $errorMessage = null;

	/**
	 * @var string
	 */
	private $javaScript = '';

	/**
	 * @var boolean
	 */
	private $globalScope = true;

	/**
	 * @var boolean
	 */
	private $inherited = false;

	/**
	 * @param string $label
	 *        	The label of the element
	 * @param Customweb_Form_Control_IControl $control
	 *        	The control of the element.
	 * @param string $description
	 *        	[optional] The description of the elment.
	 * @param boolean $globalScope
	 *        	[optional] Can the value be set per store?
	 * @param boolean $inherited
	 *        	[optional] Are values inherited?
	 */
	public function __construct(Customweb_Form_Control_IControl $control, $description = '', $globalScope = true, $inherited = false)
	{
		$this->control = $control;
		$this->elementId = $control->getControlId() . '-element';
		$this->description = $description;
		$this->intention = Customweb_Form_Intention_Factory::getNullIntention();
		if (! ($control instanceof Customweb_Form_Control_IEditableControl)) {
			$this->globalScope = false;
		} else {
			$this->globalScope = (boolean) $globalScope;
		}
		$this->inherited = (boolean) $inherited;
	}

	public function getControl()
	{
		return $this->control;
	}
	
	public function getElementId()
	{
		return $this->elementId;
	}
	
	public function getDescription()
	{
		return $this->description;
	}
	
	/**
	 * Sets the element description
	 *
	 * @param string $description
	 * @return Customweb_Form_Element
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}
	
	public function isRequired()
	{
		return $this->required;
	}
	
	/**
	 * This method sets if the user must enter some data or not.
	 *
	 * @param boolean $required
	 */
	public function setRequired($required)
	{
		$this->required = $required;
		if ($this->getControl() !== NULL) {
			$this->getControl()->setRequired($required);
		}
	
		return $this;
	}

	public function getElementIntention()
	{
		return $this->intention;
	}

	/**
	 * This method sets the element's intention.
	 *
	 * @param Customweb_Form_Intention_IIntention $intention        	
	 * @return Customweb_Form_Element
	 */
	public function setElementIntention(Customweb_Form_Intention_IIntention $intention)
	{
		$this->intention = $intention;
		return $this;
	}

	public function getErrorMessage()
	{
		return $this->errorMessage;
	}
	
	/**
	 * This method sets the error message for this element.
	 *
	 * @param string $message
	 * @return Customweb_Form_Element
	 */
	public function setErrorMessage($message)
	{
		$this->errorMessage = $message;
		return $this;
	}
	
	public function getJavaScript()
	{
		return $this->javaScript;
	}
	
	/**
	 * Sets the JavaScript code for this element.
	 *
	 * @param string $script
	 * @return Customweb_Form_Element
	 */
	public function setJavaScript($script)
	{
		$this->javaScript = $script;
		return $this;
	}
	
	/**
	 * This method appends the given $script to the other JavaScript code.
	 *
	 * @param string $script
	 * @return Customweb_Form_Element
	 */
	public function appendJavaScript($script)
	{
		$this->javaScript .= $script;
		return $this;
	}
	
	public function isGlobalScope()
	{
		return $this->globalScope;
	}
	
	public function isInherited()
	{
		return $this->inherited;
	}
	
	public function getValidators()
	{
		return $this->getControl()->getValidators();
	}

	public function applyControlCssResolver(Customweb_Form_IControlCssClassResolver $resolver)
	{
		$this->getControl()->applyCssResolver($resolver, $this);
	}

	public function applyNamespacePrefix($prefix)
	{
		$this->getControl()->applyNamespacePrefix($prefix);
	}
	
	public function render(Customweb_Form_IRenderer $renderer)
	{
		$result = $renderer->renderElementPrefix($this) .
			$renderer->renderControl($this->getControl()) .
			$renderer->renderElementAdditional($this) .
			$renderer->renderElementPostfix($this);
	
		return $result;
	}
}