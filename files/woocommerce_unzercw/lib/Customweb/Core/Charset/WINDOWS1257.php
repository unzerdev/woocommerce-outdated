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

class Customweb_Core_Charset_WINDOWS1257 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xe2\x82\xac",
		"\x82" => "\xe2\x80\x9a",
		"\x84" => "\xe2\x80\x9e",
		"\x85" => "\xe2\x80\xa6",
		"\x86" => "\xe2\x80\xa0",
		"\x87" => "\xe2\x80\xa1",
		"\x89" => "\xe2\x80\xb0",
		"\x8B" => "\xe2\x80\xb9",
		"\x8D" => "\xc2\xa8",
		"\x8E" => "\xcb\x87",
		"\x8F" => "\xc2\xb8",
		"\x91" => "\xe2\x80\x98",
		"\x92" => "\xe2\x80\x99",
		"\x93" => "\xe2\x80\x9c",
		"\x94" => "\xe2\x80\x9d",
		"\x95" => "\xe2\x80\xa2",
		"\x96" => "\xe2\x80\x93",
		"\x97" => "\xe2\x80\x94",
		"\x99" => "\xe2\x84\xa2",
		"\x9B" => "\xe2\x80\xba",
		"\x9D" => "\xc2\xaf",
		"\x9E" => "\xcb\x9b",
		"\xA0" => "\xc2\xa0",
		"\xA2" => "\xc2\xa2",
		"\xA3" => "\xc2\xa3",
		"\xA4" => "\xc2\xa4",
		"\xA6" => "\xc2\xa6",
		"\xA7" => "\xc2\xa7",
		"\xA8" => "\xc3\x98",
		"\xA9" => "\xc2\xa9",
		"\xAA" => "\xc5\x96",
		"\xAB" => "\xc2\xab",
		"\xAC" => "\xc2\xac",
		"\xAD" => "\xc2\xad",
		"\xAE" => "\xc2\xae",
		"\xAF" => "\xc3\x86",
		"\xB0" => "\xc2\xb0",
		"\xB1" => "\xc2\xb1",
		"\xB2" => "\xc2\xb2",
		"\xB3" => "\xc2\xb3",
		"\xB4" => "\xc2\xb4",
		"\xB5" => "\xc2\xb5",
		"\xB6" => "\xc2\xb6",
		"\xB7" => "\xc2\xb7",
		"\xB8" => "\xc3\xb8",
		"\xB9" => "\xc2\xb9",
		"\xBA" => "\xc5\x97",
		"\xBB" => "\xc2\xbb",
		"\xBC" => "\xc2\xbc",
		"\xBD" => "\xc2\xbd",
		"\xBE" => "\xc2\xbe",
		"\xBF" => "\xc3\xa6",
		"\xC0" => "\xc4\x84",
		"\xC1" => "\xc4\xae",
		"\xC2" => "\xc4\x80",
		"\xC3" => "\xc4\x86",
		"\xC4" => "\xc3\x84",
		"\xC5" => "\xc3\x85",
		"\xC6" => "\xc4\x98",
		"\xC7" => "\xc4\x92",
		"\xC8" => "\xc4\x8c",
		"\xC9" => "\xc3\x89",
		"\xCA" => "\xc5\xb9",
		"\xCB" => "\xc4\x96",
		"\xCC" => "\xc4\xa2",
		"\xCD" => "\xc4\xb6",
		"\xCE" => "\xc4\xaa",
		"\xCF" => "\xc4\xbb",
		"\xD0" => "\xc5\xa0",
		"\xD1" => "\xc5\x83",
		"\xD2" => "\xc5\x85",
		"\xD3" => "\xc3\x93",
		"\xD4" => "\xc5\x8c",
		"\xD5" => "\xc3\x95",
		"\xD6" => "\xc3\x96",
		"\xD7" => "\xc3\x97",
		"\xD8" => "\xc5\xb2",
		"\xD9" => "\xc5\x81",
		"\xDA" => "\xc5\x9a",
		"\xDB" => "\xc5\xaa",
		"\xDC" => "\xc3\x9c",
		"\xDD" => "\xc5\xbb",
		"\xDE" => "\xc5\xbd",
		"\xDF" => "\xc3\x9f",
		"\xE0" => "\xc4\x85",
		"\xE1" => "\xc4\xaf",
		"\xE2" => "\xc4\x81",
		"\xE3" => "\xc4\x87",
		"\xE4" => "\xc3\xa4",
		"\xE5" => "\xc3\xa5",
		"\xE6" => "\xc4\x99",
		"\xE7" => "\xc4\x93",
		"\xE8" => "\xc4\x8d",
		"\xE9" => "\xc3\xa9",
		"\xEA" => "\xc5\xba",
		"\xEB" => "\xc4\x97",
		"\xEC" => "\xc4\xa3",
		"\xED" => "\xc4\xb7",
		"\xEE" => "\xc4\xab",
		"\xEF" => "\xc4\xbc",
		"\xF0" => "\xc5\xa1",
		"\xF1" => "\xc5\x84",
		"\xF2" => "\xc5\x86",
		"\xF3" => "\xc3\xb3",
		"\xF4" => "\xc5\x8d",
		"\xF5" => "\xc3\xb5",
		"\xF6" => "\xc3\xb6",
		"\xF7" => "\xc3\xb7",
		"\xF8" => "\xc5\xb3",
		"\xF9" => "\xc5\x82",
		"\xFA" => "\xc5\x9b",
		"\xFB" => "\xc5\xab",
		"\xFC" => "\xc3\xbc",
		"\xFD" => "\xc5\xbc",
		"\xFE" => "\xc5\xbe",
		"\xFF" => "\xcb\x99",
	);
	
	private static $aliases = array(
		'cp1257', 
		'cp5353', 
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
		return 'WINDOWS-1257';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
	
}