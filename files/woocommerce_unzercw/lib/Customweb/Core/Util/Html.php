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
 * This util provides basic methods for handling HTML.
 * 
 * 
 * @author Thomas Hunziker
 *
 */
final class Customweb_Core_Util_Html {
	
	private function __construct() {
		
	}
	
	/**
	 * Converts the given HTML to plain text.
	 * 
	 * @param string $html
	 * @return string
	 */
	public static function toText($html) {
		
		// TODO: provide better conversion methods.
		
		$html = str_replace('<br />', "\n", $html);
		$html = str_replace('<br>', "\n", $html);
		$html = str_replace('<br/>', "\n", $html);
		//Replace the a tag with the href information for plain text
		$html = preg_replace("/<a .*href=['\"]{1}([^'\"]*)['\"]{1}.*?<\/a>/", '$1', $html);
		return strip_tags($html);
	}
	
}
	