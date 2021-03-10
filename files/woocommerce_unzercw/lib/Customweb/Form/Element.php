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

require_once 'Customweb/Form/AbstractElement.php';


/**
 * This element implementation provides the default methods for the
 * interface Customweb_Form_IElement.
 *
 * @see Customweb_Form_IElement
 */
class Customweb_Form_Element extends Customweb_Form_AbstractElement
{
	/**
	 * @var string
	 */
	private $label;
	
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
	public function __construct($label, Customweb_Form_Control_IControl $control, $description = '', $globalScope = true, $inherited = false)
	{
		$this->label = $label;
		parent::__construct($control, $description, $globalScope, $inherited);
	}

	/**
	 * The translated label of the element.
	 * It the label is null, then
	 * no label should be shown to the user.
	 *
	 * @return string
	 */
	public function getLabel()
	{
		return $this->label;
	}

	public function render(Customweb_Form_IRenderer $renderer)
	{
		$result = $renderer->renderElementPrefix($this) .
			$renderer->renderElementLabel($this) .
			$renderer->renderControl($this->getControl()) .
			$renderer->renderElementAdditional($this) .
			$renderer->renderElementPostfix($this);
	
		return $result;
	}
}