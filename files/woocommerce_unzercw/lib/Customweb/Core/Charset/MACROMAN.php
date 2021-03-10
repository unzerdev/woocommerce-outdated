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

class Customweb_Core_Charset_MACROMAN extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xc3\x84",
		"\x81" => "\xc3\x85",
		"\x82" => "\xc3\x87",
		"\x83" => "\xc3\x89",
		"\x84" => "\xc3\x91",
		"\x85" => "\xc3\x96",
		"\x86" => "\xc3\x9c",
		"\x87" => "\xc3\xa1",
		"\x88" => "\xc3\xa0",
		"\x89" => "\xc3\xa2",
		"\x8A" => "\xc3\xa4",
		"\x8B" => "\xc3\xa3",
		"\x8C" => "\xc3\xa5",
		"\x8D" => "\xc3\xa7",
		"\x8E" => "\xc3\xa9",
		"\x8F" => "\xc3\xa8",
		"\x90" => "\xc3\xaa",
		"\x91" => "\xc3\xab",
		"\x92" => "\xc3\xad",
		"\x93" => "\xc3\xac",
		"\x94" => "\xc3\xae",
		"\x95" => "\xc3\xaf",
		"\x96" => "\xc3\xb1",
		"\x97" => "\xc3\xb3",
		"\x98" => "\xc3\xb2",
		"\x99" => "\xc3\xb4",
		"\x9A" => "\xc3\xb6",
		"\x9B" => "\xc3\xb5",
		"\x9C" => "\xc3\xba",
		"\x9D" => "\xc3\xb9",
		"\x9E" => "\xc3\xbb",
		"\x9F" => "\xc3\xbc",
		"\xA0" => "\xe2\x80\xa0",
		"\xA1" => "\xc2\xb0",
		"\xA2" => "\xc2\xa2",
		"\xA3" => "\xc2\xa3",
		"\xA4" => "\xc2\xa7",
		"\xA5" => "\xe2\x80\xa2",
		"\xA6" => "\xc2\xb6",
		"\xA7" => "\xc3\x9f",
		"\xA8" => "\xc2\xae",
		"\xA9" => "\xc2\xa9",
		"\xAA" => "\xe2\x84\xa2",
		"\xAB" => "\xc2\xb4",
		"\xAC" => "\xc2\xa8",
		"\xAD" => "\xe2\x89\xa0",
		"\xAE" => "\xc3\x86",
		"\xAF" => "\xc3\x98",
		"\xB0" => "\xe2\x88\x9e",
		"\xB1" => "\xc2\xb1",
		"\xB2" => "\xe2\x89\xa4",
		"\xB3" => "\xe2\x89\xa5",
		"\xB4" => "\xc2\xa5",
		"\xB5" => "\xc2\xb5",
		"\xB6" => "\xe2\x88\x82",
		"\xB7" => "\xe2\x88\x91",
		"\xB8" => "\xe2\x88\x8f",
		"\xB9" => "\xcf\x80",
		"\xBA" => "\xe2\x88\xab",
		"\xBB" => "\xc2\xaa",
		"\xBC" => "\xc2\xba",
		"\xBD" => "\xe2\x84\xa6",
		"\xBE" => "\xc3\xa6",
		"\xBF" => "\xc3\xb8",
		"\xC0" => "\xc2\xbf",
		"\xC1" => "\xc2\xa1",
		"\xC2" => "\xc2\xac",
		"\xC3" => "\xe2\x88\x9a",
		"\xC4" => "\xc6\x92",
		"\xC5" => "\xe2\x89\x88",
		"\xC6" => "\xe2\x88\x86",
		"\xC7" => "\xc2\xab",
		"\xC8" => "\xc2\xbb",
		"\xC9" => "\xe2\x80\xa6",
		"\xCA" => "\xc2\xa0",
		"\xCB" => "\xc3\x80",
		"\xCC" => "\xc3\x83",
		"\xCD" => "\xc3\x95",
		"\xCE" => "\xc5\x92",
		"\xCF" => "\xc5\x93",
		"\xD0" => "\xe2\x80\x93",
		"\xD1" => "\xe2\x80\x94",
		"\xD2" => "\xe2\x80\x9c",
		"\xD3" => "\xe2\x80\x9d",
		"\xD4" => "\xe2\x80\x98",
		"\xD5" => "\xe2\x80\x99",
		"\xD6" => "\xc3\xb7",
		"\xD7" => "\xe2\x97\x8a",
		"\xD8" => "\xc3\xbf",
		"\xD9" => "\xc5\xb8",
		"\xDA" => "\xe2\x81\x84",
		"\xDB" => "\xc2\xa4",
		"\xDC" => "\xe2\x80\xb9",
		"\xDD" => "\xe2\x80\xba",
		"\xDE" => "\xef\xac\x81",
		"\xDF" => "\xef\xac\x82",
		"\xE0" => "\xe2\x80\xa1",
		"\xE1" => "\xc2\xb7",
		"\xE2" => "\xe2\x80\x9a",
		"\xE3" => "\xe2\x80\x9e",
		"\xE4" => "\xe2\x80\xb0",
		"\xE5" => "\xc3\x82",
		"\xE6" => "\xc3\x8a",
		"\xE7" => "\xc3\x81",
		"\xE8" => "\xc3\x8b",
		"\xE9" => "\xc3\x88",
		"\xEA" => "\xc3\x8d",
		"\xEB" => "\xc3\x8e",
		"\xEC" => "\xc3\x8f",
		"\xED" => "\xc3\x8c",
		"\xEE" => "\xc3\x93",
		"\xEF" => "\xc3\x94",
		"\xF1" => "\xc3\x92",
		"\xF2" => "\xc3\x9a",
		"\xF3" => "\xc3\x9b",
		"\xF4" => "\xc3\x99",
		"\xF5" => "\xc4\xb1",
		"\xF6" => "\xcb\x86",
		"\xF7" => "\xcb\x9c",
		"\xF8" => "\xc2\xaf",
		"\xF9" => "\xcb\x98",
		"\xFA" => "\xcb\x99",
		"\xFB" => "\xcb\x9a",
		"\xFC" => "\xc2\xb8",
		"\xFD" => "\xcb\x9d",
		"\xFE" => "\xcb\x9b",
		"\xFF" => "\xcb\x87",
	);
	
	private static $aliases = array(
		'cp10000',
		'x-MacRoman',
		'MacRoman',
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
		return 'MAC-ROMAN';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}