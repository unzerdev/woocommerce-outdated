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



/**
 * This interface defines a control. A control is a item for which the user may 
 * enter some information. Example of a control is a dropdown (selct) or a simple
 * textbox. 
 * 
 * Multiple controls can be grouped together by using the MultiControl control.
 * 
 * The control is the basic item of a form. Each element can have one control,
 * where by the control can also be a MultiControl.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Form_Control_IControl {
	
	/**
	 * This method returns the HTML id of this control. This
	 * id is used to refer to this element by JavaScript.
	 * 
	 * @return string HTML id of the control
	 */
	public function getControlId();
	
	/**
	 * Returns the name of the control.
	 *
	 * @return string Control Name
	 */
	public function getControlName();
	
	/**
	 * Returns the control name as array (namespaces).
	 * 
	 * @return array Control Name
	 */
	public function getControlNameAsArray();
	
	/**
	 * This method renders the control to HTML.
	 * 
	 * @param Customweb_Form_IRenderer $renderer Renderer to use for rendering
	 */
	public function render(Customweb_Form_IRenderer $renderer);
	
	/**
	 * This method returns a set of validators. A validator checks on 
	 * form submit if the user input matches with the requested input. 
	 * The check is done by JavaScript. Hence the validation is limited and
	 * the validation must be also made somewhere server side.
	 * 
	 * @return Customweb_Form_Validator_IValidator[] List of validators
	 */
	public function getValidators();
	
	/**
	 * Returns if a input for the given control is required or not.
	 * 
	 * @return boolean Required or not
	 */
	public function isRequired();
	
	/**
	 * Sets wheter this element is required or not.
	 * 
	 * @param boolean $required
	 * @return Customweb_Form_Control_IControl
	 */
	public function setRequired($required);
	
	/**
	 * This method sets the CSS class of the control HTML element.
	 * @param string $cssClass CSS Class
	 * @return Customweb_Form_Control_IControl
	 */
	public function setCssClass($cssClass);
	
	/**
	 * This method returns the CSS class of the control HTML element.
	 * 
	 * @return string CSS Class
	 */
	public function getCssClass();
	
	/**
	 * This method applies the given css class resolver on this control.
	 *
	 * @param Customweb_Form_IControlCssClassResolver $resolver
	 * @param Customweb_Form_IElement $element
	 * @return void
	 */
	public function applyCssResolver(Customweb_Form_IControlCssClassResolver $resolver, Customweb_Form_IElement $element);
	
	/**
	 * This method applies the given namespace prefix on the control.
	 *
	 * @param string $prefix
	 * @return void
	 */
	public function applyNamespacePrefix($prefix);
	
}