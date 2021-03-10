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
 * The renderer interface allows the controling of the rendering process
 * of a elment.
 * The different classes and prefix and postfixes can
 * be set through the renderer.
 *
 * @see Customweb_Form_Renderer
 */
interface Customweb_Form_IRenderer
{
	/**
	 * @param Customweb_IForm $form        	
	 * @return string Resulting HTML
	 */
	public function renderForm(Customweb_IForm $form);
	
	/**
	 * @param array $elementGroups
	 * @return string Resulting HTML
	 */
	public function renderElementGroups(array $elementGroups);
	
	/**
	 * @param Customweb_Form_IElementGroup $elementGroup
	 * @return string Resulting HTML
	 */
	public function renderElementGroupPrefix(Customweb_Form_IElementGroup $elementGroup);
	
	/**
	 * @param Customweb_Form_IElementGroup $elementGroup
	 * @return string Resulting HTML
	 */
	public function renderElementGroupPostfix(Customweb_Form_IElementGroup $elementGroup);
	
	/**
	 * @param Customweb_Form_IElementGroup $elementGroup
	 * @return string Resulting HTML
	 */
	public function renderElementGroupTitle(Customweb_Form_IElementGroup $elementGroup);
	
	/**
	 * This method renders the elements and produce HTML.
	 * The JavaScript
	 * for the elments is embedded directly into the HTML. The elements may be
	 * modified by this method, hence multiple runs may lead to different
	 * results.
	 *
	 * @param Customweb_Form_IElement[] $elements
	 * @param string  [a-zA-Z_0-9] javascript function postfix
	 * @return string Resulting HTML
	 */
	public function renderElements(array $elements, $jsFunctionPostfix = '');
	
	/**
	 * This method renders the elements without embed the JavaScript
	 * associated with the elements.
	 * The elements may be modified by
	 * this method, hence multiple runs may lead to different results.
	 *
	 * @param Customweb_Form_IElement[] $elements
	 * @return string Resulting HTML without JavaScript
	 */
	public function renderElementsWithoutJavaScript(array $elements);
	
	/**
	 * This method renders the elements and produce HTML.
	 * 
	 * The javascript functions are not included.
	 * 
	 * @param array $elements
	 * @return string Resulting HTML without JavaScript
	 */
	public function renderRawElements(array $elements);
	
	/**
	 * This method renders the JavaScript without the HTML.
	 * The JavaScript is does not
	 * contain the <script></script> Tags. Hence if you like to run it in a ordinary
	 * HTML document you need to add them.
	 *
	 * In case you run this method, you should run the renderElementsWithoutJavaScript
	 * first, because this method may modify the $elements. This changes may
	 * also affect the JavaScript part.
	 *
	 * In case you want to use the JavaScript separate to the HTML part. Then you must
	 * make sure, that the JavaScript is generated on the same elements, as for generating
	 * the HTML.
	 *
	 * @param Customweb_Form_IElement[] $elements
 	 * @param string  [a-zA-Z_] javascript function postfix
	 * @return string Resulting JavaScript for the given $elements
	 */
	public function renderElementsJavaScript(array $elements, $jsFunctionPostfix = '');
	
	/**
	 * @param Customweb_Form_IElement $element
	 * @return string Resulting HTML
	 */
	public function renderElementPrefix(Customweb_Form_IElement $element);
	
	/**
	 * @param Customweb_Form_IElement $element
	 * @return string Resulting HTML
	 */
	public function renderElementPostfix(Customweb_Form_IElement $element);

	/**
	 * @param Customweb_Form_IElement $element        	
	 * @return string Resulting HTML
	 */
	public function renderElementLabel(Customweb_Form_IElement $element);
	
	/**
	 * @param Customweb_Form_IElement $element
	 * @return string Resulting HTML
	 */
	public function renderElementAdditional(Customweb_Form_IElement $element);

	/**
	 * @param Customweb_Form_Control_IControl $control        	
	 * @return string Resulting HTML
	 */
	public function renderControl(Customweb_Form_Control_IControl $control);

	/**
	 * @param Customweb_Form_Control_IControl $control        	
	 * @return string Resulting HTML
	 */
	public function renderControlPrefix(Customweb_Form_Control_IControl $control, $controlTypeClass);

	/**
	 * @param Customweb_Form_Control_IControl $control        	
	 * @return string Resulting HTML
	 */
	public function renderControlPostfix(Customweb_Form_Control_IControl $control, $controlTypeClass);

	/**
	 * @param Customweb_Form_IElement $element        	
	 * @return string Resulting HTML
	 */
	public function renderOptionPrefix(Customweb_Form_Control_IControl $control, $optionKey);

	/**
	 * @param Customweb_Form_IElement $element        	
	 * @return string Resulting HTML
	 */
	public function renderOptionPostfix(Customweb_Form_Control_IControl $control, $optionKey);

	/**
	 * This method renders a submit button.
	 *
	 * @param Customweb_Form_IButton $button
	 *        	The button to render.
	 * @param string  [a-zA-Z_] javascript function postfix
	 * @return string Resulting HTML
	 */
	public function renderButton(Customweb_Form_IButton $button, $jsFunctionPostfix = '');
}