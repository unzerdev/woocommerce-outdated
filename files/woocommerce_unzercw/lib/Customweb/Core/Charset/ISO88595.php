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

class Customweb_Core_Charset_ISO88595 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\xA0" => "\xc2\xa0",
		"\xA1" => "\xd0\x81",
		"\xA2" => "\xd0\x82",
		"\xA3" => "\xd0\x83",
		"\xA4" => "\xd0\x84",
		"\xA5" => "\xd0\x85",
		"\xA6" => "\xd0\x86",
		"\xA7" => "\xd0\x87",
		"\xA8" => "\xd0\x88",
		"\xA9" => "\xd0\x89",
		"\xAA" => "\xd0\x8a",
		"\xAB" => "\xd0\x8b",
		"\xAC" => "\xd0\x8c",
		"\xAD" => "\xc2\xad",
		"\xAE" => "\xd0\x8e",
		"\xAF" => "\xd0\x8f",
		"\xB0" => "\xd0\x90",
		"\xB1" => "\xd0\x91",
		"\xB2" => "\xd0\x92",
		"\xB3" => "\xd0\x93",
		"\xB4" => "\xd0\x94",
		"\xB5" => "\xd0\x95",
		"\xB6" => "\xd0\x96",
		"\xB7" => "\xd0\x97",
		"\xB8" => "\xd0\x98",
		"\xB9" => "\xd0\x99",
		"\xBA" => "\xd0\x9a",
		"\xBB" => "\xd0\x9b",
		"\xBC" => "\xd0\x9c",
		"\xBD" => "\xd0\x9d",
		"\xBE" => "\xd0\x9e",
		"\xBF" => "\xd0\x9f",
		"\xC0" => "\xd0\xa0",
		"\xC1" => "\xd0\xa1",
		"\xC2" => "\xd0\xa2",
		"\xC3" => "\xd0\xa3",
		"\xC4" => "\xd0\xa4",
		"\xC5" => "\xd0\xa5",
		"\xC6" => "\xd0\xa6",
		"\xC7" => "\xd0\xa7",
		"\xC8" => "\xd0\xa8",
		"\xC9" => "\xd0\xa9",
		"\xCA" => "\xd0\xaa",
		"\xCB" => "\xd0\xab",
		"\xCC" => "\xd0\xac",
		"\xCD" => "\xd0\xad",
		"\xCE" => "\xd0\xae",
		"\xCF" => "\xd0\xaf",
		"\xD0" => "\xd0\xb0",
		"\xD1" => "\xd0\xb1",
		"\xD2" => "\xd0\xb2",
		"\xD3" => "\xd0\xb3",
		"\xD4" => "\xd0\xb4",
		"\xD5" => "\xd0\xb5",
		"\xD6" => "\xd0\xb6",
		"\xD7" => "\xd0\xb7",
		"\xD8" => "\xd0\xb8",
		"\xD9" => "\xd0\xb9",
		"\xDA" => "\xd0\xba",
		"\xDB" => "\xd0\xbb",
		"\xDC" => "\xd0\xbc",
		"\xDD" => "\xd0\xbd",
		"\xDE" => "\xd0\xbe",
		"\xDF" => "\xd0\xbf",
		"\xE0" => "\xd1\x80",
		"\xE1" => "\xd1\x81",
		"\xE2" => "\xd1\x82",
		"\xE3" => "\xd1\x83",
		"\xE4" => "\xd1\x84",
		"\xE5" => "\xd1\x85",
		"\xE6" => "\xd1\x86",
		"\xE7" => "\xd1\x87",
		"\xE8" => "\xd1\x88",
		"\xE9" => "\xd1\x89",
		"\xEA" => "\xd1\x8a",
		"\xEB" => "\xd1\x8b",
		"\xEC" => "\xd1\x8c",
		"\xED" => "\xd1\x8d",
		"\xEE" => "\xd1\x8e",
		"\xEF" => "\xd1\x8f",
		"\xF0" => "\xe2\x84\x96",
		"\xF1" => "\xd1\x91",
		"\xF2" => "\xd1\x92",
		"\xF3" => "\xd1\x93",
		"\xF4" => "\xd1\x94",
		"\xF5" => "\xd1\x95",
		"\xF6" => "\xd1\x96",
		"\xF7" => "\xd1\x97",
		"\xF8" => "\xd1\x98",
		"\xF9" => "\xd1\x99",
		"\xFA" => "\xd1\x9a",
		"\xFB" => "\xd1\x9b",
		"\xFC" => "\xd1\x9c",
		"\xFD" => "\xc2\xa7",
		"\xFE" => "\xd1\x9e",
		"\xFF" => "\xd1\x9f",
	);
	
	private static $aliases = array(
		'cp915',
		'ISO8859-5',
		'ibm915',
		'ISO_8859-5:1988',
		'ibm-915',
		'8859_5',
		'915',
		'cyrillic',
		'iso8859_5',
		'ISO_8859-5',
		'iso-ir-144',
		'csISOLatinCyrillic',
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
		return 'ISO-8859-5';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}