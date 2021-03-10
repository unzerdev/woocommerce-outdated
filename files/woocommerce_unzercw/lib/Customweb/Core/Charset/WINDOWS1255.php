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

class Customweb_Core_Charset_WINDOWS1255 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xe2\x82\xac",
		"\x82" => "\xe2\x80\x9a",
		"\x83" => "\xc6\x92",
		"\x84" => "\xe2\x80\x9e",
		"\x85" => "\xe2\x80\xa6",
		"\x86" => "\xe2\x80\xa0",
		"\x87" => "\xe2\x80\xa1",
		"\x88" => "\xcb\x86",
		"\x89" => "\xe2\x80\xb0",
		"\x8B" => "\xe2\x80\xb9",
		"\x91" => "\xe2\x80\x98",
		"\x92" => "\xe2\x80\x99",
		"\x93" => "\xe2\x80\x9c",
		"\x94" => "\xe2\x80\x9d",
		"\x95" => "\xe2\x80\xa2",
		"\x96" => "\xe2\x80\x93",
		"\x97" => "\xe2\x80\x94",
		"\x98" => "\xcb\x9c",
		"\x99" => "\xe2\x84\xa2",
		"\x9B" => "\xe2\x80\xba",
		"\xA0" => "\xc2\xa0",
		"\xA1" => "\xc2\xa1",
		"\xA2" => "\xc2\xa2",
		"\xA3" => "\xc2\xa3",
		"\xA4" => "\xe2\x82\xaa",
		"\xA5" => "\xc2\xa5",
		"\xA6" => "\xc2\xa6",
		"\xA7" => "\xc2\xa7",
		"\xA8" => "\xc2\xa8",
		"\xA9" => "\xc2\xa9",
		"\xAA" => "\xc3\x97",
		"\xAB" => "\xc2\xab",
		"\xAC" => "\xc2\xac",
		"\xAD" => "\xc2\xad",
		"\xAE" => "\xc2\xae",
		"\xAF" => "\xc2\xaf",
		"\xB0" => "\xc2\xb0",
		"\xB1" => "\xc2\xb1",
		"\xB2" => "\xc2\xb2",
		"\xB3" => "\xc2\xb3",
		"\xB4" => "\xc2\xb4",
		"\xB5" => "\xc2\xb5",
		"\xB6" => "\xc2\xb6",
		"\xB7" => "\xc2\xb7",
		"\xB8" => "\xc2\xb8",
		"\xB9" => "\xc2\xb9",
		"\xBA" => "\xc3\xb7",
		"\xBB" => "\xc2\xbb",
		"\xBC" => "\xc2\xbc",
		"\xBD" => "\xc2\xbd",
		"\xBE" => "\xc2\xbe",
		"\xBF" => "\xc2\xbf",
		"\xC0" => "\xd6\xb0",
		"\xC1" => "\xd6\xb1",
		"\xC2" => "\xd6\xb2",
		"\xC3" => "\xd6\xb3",
		"\xC4" => "\xd6\xb4",
		"\xC5" => "\xd6\xb5",
		"\xC6" => "\xd6\xb6",
		"\xC7" => "\xd6\xb7",
		"\xC8" => "\xd6\xb8",
		"\xC9" => "\xd6\xb9",
		"\xCB" => "\xd6\xbb",
		"\xCC" => "\xd6\xbc",
		"\xCD" => "\xd6\xbd",
		"\xCE" => "\xd6\xbe",
		"\xCF" => "\xd6\xbf",
		"\xD0" => "\xd7\x80",
		"\xD1" => "\xd7\x81",
		"\xD2" => "\xd7\x82",
		"\xD3" => "\xd7\x83",
		"\xD4" => "\xd7\xb0",
		"\xD5" => "\xd7\xb1",
		"\xD6" => "\xd7\xb2",
		"\xD7" => "\xd7\xb3",
		"\xD8" => "\xd7\xb4",
		"\xE0" => "\xd7\x90",
		"\xE1" => "\xd7\x91",
		"\xE2" => "\xd7\x92",
		"\xE3" => "\xd7\x93",
		"\xE4" => "\xd7\x94",
		"\xE5" => "\xd7\x95",
		"\xE6" => "\xd7\x96",
		"\xE7" => "\xd7\x97",
		"\xE8" => "\xd7\x98",
		"\xE9" => "\xd7\x99",
		"\xEA" => "\xd7\x9a",
		"\xEB" => "\xd7\x9b",
		"\xEC" => "\xd7\x9c",
		"\xED" => "\xd7\x9d",
		"\xEE" => "\xd7\x9e",
		"\xEF" => "\xd7\x9f",
		"\xF0" => "\xd7\xa0",
		"\xF1" => "\xd7\xa1",
		"\xF2" => "\xd7\xa2",
		"\xF3" => "\xd7\xa3",
		"\xF4" => "\xd7\xa4",
		"\xF5" => "\xd7\xa5",
		"\xF6" => "\xd7\xa6",
		"\xF7" => "\xd7\xa7",
		"\xF8" => "\xd7\xa8",
		"\xF9" => "\xd7\xa9",
		"\xFA" => "\xd7\xaa",
		"\xFD" => "\xe2\x80\x8e",
		"\xFE" => "\xe2\x80\x8f",
	);
	
	private static $aliases = array(
		'cp1255',  
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
		return 'WINDOWS-1255';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}