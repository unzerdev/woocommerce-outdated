<?php
/**
 *  * You are allowed to use this API in your web application.
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



interface Customweb_Mvc_Template_IRenderContext
{
	/**
	 * This method returns the security policy which must enforced by the renderer.
	 *
	 * @return Customweb_Template_Sandbox_ISecurityPolicy
	 */
	public function getSecurityPolicy();

	/**
	 * This method returns a map for the variables used in the template.
	 * The key in the map represents the variable's name
	 *
	 * @return array
	 */
	public function getVariables();

	/**
	 * This method returns the template identifier.
	 * The template identifier
	 * is the asset identifier without any file extension.
	 *
	 * @return string
	 */
	public function getTemplate();
}