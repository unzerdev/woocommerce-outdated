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

class Customweb_Core_Charset_ISO88591 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\xA0" => "\xc2\xa0",
		"\xA1" => "\xc2\xa1",
		"\xA2" => "\xc2\xa2",
		"\xA3" => "\xc2\xa3",
		"\xA4" => "\xc2\xa4",
		"\xA5" => "\xc2\xa5",
		"\xA6" => "\xc2\xa6",
		"\xA7" => "\xc2\xa7",
		"\xA8" => "\xc2\xa8",
		"\xA9" => "\xc2\xa9",
		"\xAA" => "\xc2\xaa",
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
		"\xBA" => "\xc2\xba",
		"\xBB" => "\xc2\xbb",
		"\xBC" => "\xc2\xbc",
		"\xBD" => "\xc2\xbd",
		"\xBE" => "\xc2\xbe",
		"\xBF" => "\xc2\xbf",
		"\xC0" => "\xc3\x80",
		"\xC1" => "\xc3\x81",
		"\xC2" => "\xc3\x82",
		"\xC3" => "\xc3\x83",
		"\xC4" => "\xc3\x84",
		"\xC5" => "\xc3\x85",
		"\xC6" => "\xc3\x86",
		"\xC7" => "\xc3\x87",
		"\xC8" => "\xc3\x88",
		"\xC9" => "\xc3\x89",
		"\xCA" => "\xc3\x8a",
		"\xCB" => "\xc3\x8b",
		"\xCC" => "\xc3\x8c",
		"\xCD" => "\xc3\x8d",
		"\xCE" => "\xc3\x8e",
		"\xCF" => "\xc3\x8f",
		"\xD0" => "\xc3\x90",
		"\xD1" => "\xc3\x91",
		"\xD2" => "\xc3\x92",
		"\xD3" => "\xc3\x93",
		"\xD4" => "\xc3\x94",
		"\xD5" => "\xc3\x95",
		"\xD6" => "\xc3\x96",
		"\xD7" => "\xc3\x97",
		"\xD8" => "\xc3\x98",
		"\xD9" => "\xc3\x99",
		"\xDA" => "\xc3\x9a",
		"\xDB" => "\xc3\x9b",
		"\xDC" => "\xc3\x9c",
		"\xDD" => "\xc3\x9d",
		"\xDE" => "\xc3\x9e",
		"\xDF" => "\xc3\x9f",
		"\xE0" => "\xc3\xa0",
		"\xE1" => "\xc3\xa1",
		"\xE2" => "\xc3\xa2",
		"\xE3" => "\xc3\xa3",
		"\xE4" => "\xc3\xa4",
		"\xE5" => "\xc3\xa5",
		"\xE6" => "\xc3\xa6",
		"\xE7" => "\xc3\xa7",
		"\xE8" => "\xc3\xa8",
		"\xE9" => "\xc3\xa9",
		"\xEA" => "\xc3\xaa",
		"\xEB" => "\xc3\xab",
		"\xEC" => "\xc3\xac",
		"\xED" => "\xc3\xad",
		"\xEE" => "\xc3\xae",
		"\xEF" => "\xc3\xaf",
		"\xF0" => "\xc3\xb0",
		"\xF1" => "\xc3\xb1",
		"\xF2" => "\xc3\xb2",
		"\xF3" => "\xc3\xb3",
		"\xF4" => "\xc3\xb4",
		"\xF5" => "\xc3\xb5",
		"\xF6" => "\xc3\xb6",
		"\xF7" => "\xc3\xb7",
		"\xF8" => "\xc3\xb8",
		"\xF9" => "\xc3\xb9",
		"\xFA" => "\xc3\xba",
		"\xFB" => "\xc3\xbb",
		"\xFC" => "\xc3\xbc",
		"\xFD" => "\xc3\xbd",
		"\xFE" => "\xc3\xbe",
		"\xFF" => "\xc3\xbf",
	);
	
	private static $aliases = array(
		'CSISOLATIN1', 
		'LATIN1', 
		'IBM-819', 
		'ISO-IR-100', 
		'8859-1', 
		'ISO-8859-1:1987', 
		'ISO-8859-1', 
		'819', 
		'L1', 
		'ISO8859-1', 
		'IBM819', 
		'ISO-8859_1', 
		'ISO8859-1', 
		'CP819'
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
		return 'ISO-8859-1';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
		
}