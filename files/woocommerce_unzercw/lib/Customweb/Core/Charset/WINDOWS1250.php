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

class Customweb_Core_Charset_WINDOWS1250 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xe2\x82\xac",
		"\x82" => "\xe2\x80\x9a",
		"\x84" => "\xe2\x80\x9e",
		"\x85" => "\xe2\x80\xa6",
		"\x86" => "\xe2\x80\xa0",
		"\x87" => "\xe2\x80\xa1",
		"\x89" => "\xe2\x80\xb0",
		"\x8A" => "\xc5\xa0",
		"\x8B" => "\xe2\x80\xb9",
		"\x8C" => "\xc5\x9a",
		"\x8D" => "\xc5\xa4",
		"\x8E" => "\xc5\xbd",
		"\x8F" => "\xc5\xb9",
		"\x91" => "\xe2\x80\x98",
		"\x92" => "\xe2\x80\x99",
		"\x93" => "\xe2\x80\x9c",
		"\x94" => "\xe2\x80\x9d",
		"\x95" => "\xe2\x80\xa2",
		"\x96" => "\xe2\x80\x93",
		"\x97" => "\xe2\x80\x94",
		"\x99" => "\xe2\x84\xa2",
		"\x9A" => "\xc5\xa1",
		"\x9B" => "\xe2\x80\xba",
		"\x9C" => "\xc5\x9b",
		"\x9D" => "\xc5\xa5",
		"\x9E" => "\xc5\xbe",
		"\x9F" => "\xc5\xba",
		"\xA0" => "\xc2\xa0",
		"\xA1" => "\xcb\x87",
		"\xA2" => "\xcb\x98",
		"\xA3" => "\xc5\x81",
		"\xA4" => "\xc2\xa4",
		"\xA5" => "\xc4\x84",
		"\xA6" => "\xc2\xa6",
		"\xA7" => "\xc2\xa7",
		"\xA8" => "\xc2\xa8",
		"\xA9" => "\xc2\xa9",
		"\xAA" => "\xc5\x9e",
		"\xAB" => "\xc2\xab",
		"\xAC" => "\xc2\xac",
		"\xAD" => "\xc2\xad",
		"\xAE" => "\xc2\xae",
		"\xAF" => "\xc5\xbb",
		"\xB0" => "\xc2\xb0",
		"\xB1" => "\xc2\xb1",
		"\xB2" => "\xcb\x9b",
		"\xB3" => "\xc5\x82",
		"\xB4" => "\xc2\xb4",
		"\xB5" => "\xc2\xb5",
		"\xB6" => "\xc2\xb6",
		"\xB7" => "\xc2\xb7",
		"\xB8" => "\xc2\xb8",
		"\xB9" => "\xc4\x85",
		"\xBA" => "\xc5\x9f",
		"\xBB" => "\xc2\xbb",
		"\xBC" => "\xc4\xbd",
		"\xBD" => "\xcb\x9d",
		"\xBE" => "\xc4\xbe",
		"\xBF" => "\xc5\xbc",
		"\xC0" => "\xc5\x94",
		"\xC1" => "\xc3\x81",
		"\xC2" => "\xc3\x82",
		"\xC3" => "\xc4\x82",
		"\xC4" => "\xc3\x84",
		"\xC5" => "\xc4\xb9",
		"\xC6" => "\xc4\x86",
		"\xC7" => "\xc3\x87",
		"\xC8" => "\xc4\x8c",
		"\xC9" => "\xc3\x89",
		"\xCA" => "\xc4\x98",
		"\xCB" => "\xc3\x8b",
		"\xCC" => "\xc4\x9a",
		"\xCD" => "\xc3\x8d",
		"\xCE" => "\xc3\x8e",
		"\xCF" => "\xc4\x8e",
		"\xD0" => "\xc4\x90",
		"\xD1" => "\xc5\x83",
		"\xD2" => "\xc5\x87",
		"\xD3" => "\xc3\x93",
		"\xD4" => "\xc3\x94",
		"\xD5" => "\xc5\x90",
		"\xD6" => "\xc3\x96",
		"\xD7" => "\xc3\x97",
		"\xD8" => "\xc5\x98",
		"\xD9" => "\xc5\xae",
		"\xDA" => "\xc3\x9a",
		"\xDB" => "\xc5\xb0",
		"\xDC" => "\xc3\x9c",
		"\xDD" => "\xc3\x9d",
		"\xDE" => "\xc5\xa2",
		"\xDF" => "\xc3\x9f",
		"\xE0" => "\xc5\x95",
		"\xE1" => "\xc3\xa1",
		"\xE2" => "\xc3\xa2",
		"\xE3" => "\xc4\x83",
		"\xE4" => "\xc3\xa4",
		"\xE5" => "\xc4\xba",
		"\xE6" => "\xc4\x87",
		"\xE7" => "\xc3\xa7",
		"\xE8" => "\xc4\x8d",
		"\xE9" => "\xc3\xa9",
		"\xEA" => "\xc4\x99",
		"\xEB" => "\xc3\xab",
		"\xEC" => "\xc4\x9b",
		"\xED" => "\xc3\xad",
		"\xEE" => "\xc3\xae",
		"\xEF" => "\xc4\x8f",
		"\xF0" => "\xc4\x91",
		"\xF1" => "\xc5\x84",
		"\xF2" => "\xc5\x88",
		"\xF3" => "\xc3\xb3",
		"\xF4" => "\xc3\xb4",
		"\xF5" => "\xc5\x91",
		"\xF6" => "\xc3\xb6",
		"\xF7" => "\xc3\xb7",
		"\xF8" => "\xc5\x99",
		"\xF9" => "\xc5\xaf",
		"\xFA" => "\xc3\xba",
		"\xFB" => "\xc5\xb1",
		"\xFC" => "\xc3\xbc",
		"\xFD" => "\xc3\xbd",
		"\xFE" => "\xc5\xa3",
		"\xFF" => "\xcb\x99",
				
	);
	
	private static $aliases = array(
		'cp1250',
		'cp5346',
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
		return 'WINDOWS-1250';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}