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
 * Represents a group containing form elements.
 */
interface Customweb_Form_IElementGroup {
	
	/**
	 * The ID of the element group. It should be globally unique.
	 * 
	 * @return string
	 */
	public function getId();
	
	/**
	 * The name of the element group. The ID should be unique 
	 * per form. This is used as the identifier of the
	 * element group.
	 * 
	 * @return string
	 */
	public function getMachineName();
	
	/**
	 * Returns the translated title of the element group. The title is 
	 * visible for the user.
	 * 
	 * @return Customweb_I18n_LocalizableString
	 */
	public function getTitle();
	
	/**
	 * Returns the elements in this element group.
	 * 
	 * @return Customweb_Form_IElement[]
	 */
	public function getElements();
	
	/**
	 * This method renders the given element group to HTML.
	 *
	 * @param Customweb_Form_IRenderer $renderer The renderer to use.
	 * @return string HTML
	 */
	public function render(Customweb_Form_IRenderer $renderer);
	
}