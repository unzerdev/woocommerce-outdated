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
require_once 'Customweb/Form/IElement.php';


/**
 * This element implementation provides the hidden element.
 *
 * @see Customweb_Form_IElement
 */
class Customweb_Form_HiddenElement implements Customweb_Form_IElement
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
	 * @var Customweb_Form_Intention_IIntention
	 */
	private $intention = null;

	/**
	 * @var string
	 */
	private $javaScript = '';

	/**
	 * @param Customweb_Form_Control_IControl $control
	 *        	The control of the element.
	 */
	public function __construct(Customweb_Form_Control_IControl $control)
	{
		$this->control = $control;
		$this->elementId = $control->getControlId() . '-element';
		$this->intention = Customweb_Form_Intention_Factory::getNullIntention();
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
		return '';
	}
	
	public function isRequired()
	{
		return false;
	}

	public function getElementIntention()
	{
		return $this->intention;
	}

	public function getErrorMessage()
	{
		return '';
	}

	public function getJavaScript()
	{
		return $this->javaScript;
	}
	
	public function setJavaScript($script)
	{
		$this->javaScript = $script;
		return $this;
	}
		
	public function isGlobalScope() {
		return false;
	}
	
	public function isInherited() {
		return false;
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
			$renderer->renderElementPostfix($this);
	
		return $result;
	}
}