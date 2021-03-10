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

require_once 'Customweb/Core/Charset/TableBasedCharset.php';

/**
 * This char set which allows only numeric values (0-9).
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Core_Charset_Numeric extends Customweb_Core_Charset_TableBasedCharset {
	
	private static $conversionTable = array(
		// Non required
	);
	
	protected function getReplacementTable() {
		return array();
	}

	protected function getConversionTable() {
		return self::$conversionTable;
	}
	
	protected function getNoChangesRanges() {
		return array(
			array(
				'start' => 0x30,
				'end' => 0x39,
			),
		);
	}
	
	public function getName() {
		return 'Numeric';
	}
	
	public function getAliases() {
		return array();
	}	
	
}