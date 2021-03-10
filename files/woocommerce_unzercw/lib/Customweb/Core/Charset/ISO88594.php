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

class Customweb_Core_Charset_ISO88594 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\xA0" => "\xc2\xa0",
		"\xA1" => "\xc4\x84",
		"\xA2" => "\xc4\xb8",
		"\xA3" => "\xc5\x96",
		"\xA4" => "\xc2\xa4",
		"\xA5" => "\xc4\xa8",
		"\xA6" => "\xc4\xbb",
		"\xA7" => "\xc2\xa7",
		"\xA8" => "\xc2\xa8",
		"\xA9" => "\xc5\xa0",
		"\xAA" => "\xc4\x92",
		"\xAB" => "\xc4\xa2",
		"\xAC" => "\xc5\xa6",
		"\xAD" => "\xc2\xad",
		"\xAE" => "\xc5\xbd",
		"\xAF" => "\xc2\xaf",
		"\xB0" => "\xc2\xb0",
		"\xB1" => "\xc4\x85",
		"\xB2" => "\xcb\x9b",
		"\xB3" => "\xc5\x97",
		"\xB4" => "\xc2\xb4",
		"\xB5" => "\xc4\xa9",
		"\xB6" => "\xc4\xbc",
		"\xB7" => "\xcb\x87",
		"\xB8" => "\xc2\xb8",
		"\xB9" => "\xc5\xa1",
		"\xBA" => "\xc4\x93",
		"\xBB" => "\xc4\xa3",
		"\xBC" => "\xc5\xa7",
		"\xBD" => "\xc5\x8a",
		"\xBE" => "\xc5\xbe",
		"\xBF" => "\xc5\x8b",
		"\xC0" => "\xc4\x80",
		"\xC1" => "\xc3\x81",
		"\xC2" => "\xc3\x82",
		"\xC3" => "\xc3\x83",
		"\xC4" => "\xc3\x84",
		"\xC5" => "\xc3\x85",
		"\xC6" => "\xc3\x86",
		"\xC7" => "\xc4\xae",
		"\xC8" => "\xc4\x8c",
		"\xC9" => "\xc3\x89",
		"\xCA" => "\xc4\x98",
		"\xCB" => "\xc3\x8b",
		"\xCC" => "\xc4\x96",
		"\xCD" => "\xc3\x8d",
		"\xCE" => "\xc3\x8e",
		"\xCF" => "\xc4\xaa",
		"\xD0" => "\xc4\x90",
		"\xD1" => "\xc5\x85",
		"\xD2" => "\xc5\x8c",
		"\xD3" => "\xc4\xb6",
		"\xD4" => "\xc3\x94",
		"\xD5" => "\xc3\x95",
		"\xD6" => "\xc3\x96",
		"\xD7" => "\xc3\x97",
		"\xD8" => "\xc3\x98",
		"\xD9" => "\xc5\xb2",
		"\xDA" => "\xc3\x9a",
		"\xDB" => "\xc3\x9b",
		"\xDC" => "\xc3\x9c",
		"\xDD" => "\xc5\xa8",
		"\xDE" => "\xc5\xaa",
		"\xDF" => "\xc3\x9f",
		"\xE0" => "\xc4\x81",
		"\xE1" => "\xc3\xa1",
		"\xE2" => "\xc3\xa2",
		"\xE3" => "\xc3\xa3",
		"\xE4" => "\xc3\xa4",
		"\xE5" => "\xc3\xa5",
		"\xE6" => "\xc3\xa6",
		"\xE7" => "\xc4\xaf",
		"\xE8" => "\xc4\x8d",
		"\xE9" => "\xc3\xa9",
		"\xEA" => "\xc4\x99",
		"\xEB" => "\xc3\xab",
		"\xEC" => "\xc4\x97",
		"\xED" => "\xc3\xad",
		"\xEE" => "\xc3\xae",
		"\xEF" => "\xc4\xab",
		"\xF0" => "\xc4\x91",
		"\xF1" => "\xc5\x86",
		"\xF2" => "\xc5\x8d",
		"\xF3" => "\xc4\xb7",
		"\xF4" => "\xc3\xb4",
		"\xF5" => "\xc3\xb5",
		"\xF6" => "\xc3\xb6",
		"\xF7" => "\xc3\xb7",
		"\xF8" => "\xc3\xb8",
		"\xF9" => "\xc5\xb3",
		"\xFA" => "\xc3\xba",
		"\xFB" => "\xc3\xbb",
		"\xFC" => "\xc3\xbc",
		"\xFD" => "\xc5\xa9",
		"\xFE" => "\xc5\xab",
		"\xFF" => "\xcb\x99",
	);
	
	private static $aliases = array(
		'iso-ir-110',
		'iso8859-4',
		'ibm914',
		'ibm-914',
		'csISOLatin4',
		'l4',
		'914',
		'8859_4',
		'latin4',
		'ISO_8859-4',
		'ISO_8859-4:1988',
		'iso8859_4',
		'cp914',
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
		return 'ISO-8859-4';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}