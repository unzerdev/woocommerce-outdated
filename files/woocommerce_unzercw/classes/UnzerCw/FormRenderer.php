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
require_once 'Customweb/Form/Renderer.php';


class UnzerCw_FormRenderer extends Customweb_Form_Renderer {
	
	
	public function renderElementGroupPrefix(Customweb_Form_IElementGroup $elementGroup)
	{
		return '<table class="form-table"><tbody>';
	}
	
	public function renderElementGroupPostfix(Customweb_Form_IElementGroup $elementGroup)
	{
		return '</tbody></table>';
	}
	
	public function renderElementGroupTitle(Customweb_Form_IElementGroup $elementGroup)
	{
		$output = '';
		$title = $elementGroup->getTitle();
		if (! empty($title)) {
			$output .= '<h3>' . $title . '</h3>';
		}

		return $output;
	}
	
	public function renderElementPrefix(Customweb_Form_IElement $element)
	{	
		return '<tr>';
		
	}
	
	public function renderElementPostfix(Customweb_Form_IElement $element)
	{
		return '</td></tr>';
	}
	
	public function renderElementLabel(Customweb_Form_IElement $element)
	{
		$for = '';
		if ($element->getControl() != null && $element->getControl()->getControlId() !== null && $element->getControl()->getControlId() != '') {
			$for = $element->getControl()->getControlId();
		}
		$cssClasses = '';
		$label = $element->getLabel();
		if ($element->isRequired()) {
			$label .= $this->renderRequiredTag($element);
			$cssClasses .= ' required';
		}
	
		return '<th scope="row">'.$this->renderLabel($for, $label, $cssClasses).'</th><td>';
	}
	
	/**
	 * @param Customweb_Form_IElement $element
	 * @return string
	 */
	protected function renderRequiredTag(Customweb_Form_IElement $element)
	{
		return '<em>*</em>';
	}

	
	protected function renderElementScopeControl(Customweb_Form_IElement $element) {
		return '';
	}
	
	protected function renderElementScope(Customweb_Form_IElement $element) {
		return '';
	}

	protected function renderElementDescription(Customweb_Form_IElement $element)
	{
		return '<p class="description">' . $element->getDescription() . '</p>';
	}
	
	
	public function renderControlPrefix(Customweb_Form_Control_IControl $control, $controlTypeClass)
	{
		return '';
	}
	
	public function renderControlPostfix(Customweb_Form_Control_IControl $control, $controlTypeClass)
	{
		return '';
	}
	
}