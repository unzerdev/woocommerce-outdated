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

class Customweb_Core_Charset_ISO88593 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\xA0" => "\xc2\xa0",
		"\xA1" => "\xc4\xa6",
		"\xA2" => "\xcb\x98",
		"\xA3" => "\xc2\xa3",
		"\xA4" => "\xc2\xa4",
		"\xA6" => "\xc4\xa4",
		"\xA7" => "\xc2\xa7",
		"\xA8" => "\xc2\xa8",
		"\xA9" => "\xc4\xb0",
		"\xAA" => "\xc5\x9e",
		"\xAB" => "\xc4\x9e",
		"\xAC" => "\xc4\xb4",
		"\xAD" => "\xc2\xad",
		"\xAF" => "\xc5\xbb",
		"\xB0" => "\xc2\xb0",
		"\xB1" => "\xc4\xa7",
		"\xB2" => "\xc2\xb2",
		"\xB3" => "\xc2\xb3",
		"\xB4" => "\xc2\xb4",
		"\xB5" => "\xc2\xb5",
		"\xB6" => "\xc4\xa5",
		"\xB7" => "\xc2\xb7",
		"\xB8" => "\xc2\xb8",
		"\xB9" => "\xc4\xb1",
		"\xBA" => "\xc5\x9f",
		"\xBB" => "\xc4\x9f",
		"\xBC" => "\xc4\xb5",
		"\xBD" => "\xc2\xbd",
		"\xBF" => "\xc5\xbc",
		"\xC0" => "\xc3\x80",
		"\xC1" => "\xc3\x81",
		"\xC2" => "\xc3\x82",
		"\xC4" => "\xc3\x84",
		"\xC5" => "\xc4\x8a",
		"\xC6" => "\xc4\x88",
		"\xC7" => "\xc3\x87",
		"\xC8" => "\xc3\x88",
		"\xC9" => "\xc3\x89",
		"\xCA" => "\xc3\x8a",
		"\xCB" => "\xc3\x8b",
		"\xCC" => "\xc3\x8c",
		"\xCD" => "\xc3\x8d",
		"\xCE" => "\xc3\x8e",
		"\xCF" => "\xc3\x8f",
		"\xD1" => "\xc3\x91",
		"\xD2" => "\xc3\x92",
		"\xD3" => "\xc3\x93",
		"\xD4" => "\xc3\x94",
		"\xD5" => "\xc4\xa0",
		"\xD6" => "\xc3\x96",
		"\xD7" => "\xc3\x97",
		"\xD8" => "\xc4\x9c",
		"\xD9" => "\xc3\x99",
		"\xDA" => "\xc3\x9a",
		"\xDB" => "\xc3\x9b",
		"\xDC" => "\xc3\x9c",
		"\xDD" => "\xc5\xac",
		"\xDE" => "\xc5\x9c",
		"\xDF" => "\xc3\x9f",
		"\xE0" => "\xc3\xa0",
		"\xE1" => "\xc3\xa1",
		"\xE2" => "\xc3\xa2",
		"\xE4" => "\xc3\xa4",
		"\xE5" => "\xc4\x8b",
		"\xE6" => "\xc4\x89",
		"\xE7" => "\xc3\xa7",
		"\xE8" => "\xc3\xa8",
		"\xE9" => "\xc3\xa9",
		"\xEA" => "\xc3\xaa",
		"\xEB" => "\xc3\xab",
		"\xEC" => "\xc3\xac",
		"\xED" => "\xc3\xad",
		"\xEE" => "\xc3\xae",
		"\xEF" => "\xc3\xaf",
		"\xF1" => "\xc3\xb1",
		"\xF2" => "\xc3\xb2",
		"\xF3" => "\xc3\xb3",
		"\xF4" => "\xc3\xb4",
		"\xF5" => "\xc4\xa1",
		"\xF6" => "\xc3\xb6",
		"\xF7" => "\xc3\xb7",
		"\xF8" => "\xc4\x9d",
		"\xF9" => "\xc3\xb9",
		"\xFA" => "\xc3\xba",
		"\xFB" => "\xc3\xbb",
		"\xFC" => "\xc3\xbc",
		"\xFD" => "\xc5\xad",
		"\xFE" => "\xc5\x9d",
		"\xFF" => "\xcb\x99",
	);
	
	private static $aliases = array(
		'ibm-913', 
		'latin3', 
		'csISOLatin3', 
		'iso-ir-109', 
		'l3', 
		'iso8859_3', 
		'ISO_8859-3:1988', 
		'8859_3', 
		'ibm913', 
		'ISO8859-3', 
		'ISO_8859-3', 
		'913', 
		'cp913',
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
		return 'ISO-8859-3';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}