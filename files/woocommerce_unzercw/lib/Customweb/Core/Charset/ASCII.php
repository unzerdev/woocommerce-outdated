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

class Customweb_Core_Charset_ASCII extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		// Non required
	);
	
	private static $aliases = array(
		'cp367',
		'ascii7',
		'ISO646-US',
		'646',
		'csASCII',
		'us',
		'iso_646.irv:1983',
		'ISO_646.irv:1991',
		'IBM367',
		'ASCII',
		'default',
		'ANSI_X3.4-1986',
		'ANSI_X3.4-1968',
		'iso-ir-6',
	);
	
	protected function getConversionTable() {
		return self::$conversionTable;
	}
	
	protected function getNoChangesRanges() {
		return array(
			array(
				'start' => 0x20,
				'end' => 0x7E,
			),
		);
	}
	
	public function getName() {
		return 'ASCII';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}