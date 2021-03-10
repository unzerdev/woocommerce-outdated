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



interface Customweb_Mvc_Layout_IRenderContext
{
	/**
	 * Returns the main content to embed into the layout.
	 *
	 * @return string
	 */
	public function getMainContent();

	/**
	 * Returns the title of the current page.
	 *
	 * @return string
	 */
	public function getTitle();

	/**
	 * Returns a list of absolute URL to JavaScript files to embed into
	 * the layout.
	 *
	 * @return string[]
	 */
	public function getJavaScriptFiles();

	/**
	 * Returns a list of absolute URL to CSS files to embed into the
	 * layout.
	 *
	 * @return string[]
	 */
	public function getCssFiles();
}