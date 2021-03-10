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
 * This interface is used to resolve the CSS class for the given control element. This 
 * can be used to provide CSS classes for the different controls, depending on their 
 * actual usage.
 * 
 * @author Thomas Hunziker
 */
interface Customweb_Form_IControlCssClassResolver
{
	
	/**
	 * This method resolves the CSS class(es) for the given $control object.
	 * 
	 * @param Customweb_Form_Control_IControl $control
	 * @param Customweb_Form_Element $element
	 * @return string CSS Class
	 */
	public function resolveClass(Customweb_Form_Control_IControl $control, Customweb_Form_IElement $element);
	
}