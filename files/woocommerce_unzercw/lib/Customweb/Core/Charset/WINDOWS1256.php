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

class Customweb_Core_Charset_WINDOWS1256 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xe2\x82\xac",
		"\x81" => "\xd9\xbe",
		"\x82" => "\xe2\x80\x9a",
		"\x83" => "\xc6\x92",
		"\x84" => "\xe2\x80\x9e",
		"\x85" => "\xe2\x80\xa6",
		"\x86" => "\xe2\x80\xa0",
		"\x87" => "\xe2\x80\xa1",
		"\x88" => "\xcb\x86",
		"\x89" => "\xe2\x80\xb0",
		"\x8A" => "\xd9\xb9",
		"\x8B" => "\xe2\x80\xb9",
		"\x8C" => "\xc5\x92",
		"\x8D" => "\xda\x86",
		"\x8E" => "\xda\x98",
		"\x8F" => "\xda\x88",
		"\x90" => "\xda\xaf",
		"\x91" => "\xe2\x80\x98",
		"\x92" => "\xe2\x80\x99",
		"\x93" => "\xe2\x80\x9c",
		"\x94" => "\xe2\x80\x9d",
		"\x95" => "\xe2\x80\xa2",
		"\x96" => "\xe2\x80\x93",
		"\x97" => "\xe2\x80\x94",
		"\x98" => "\xda\xa9",
		"\x99" => "\xe2\x84\xa2",
		"\x9A" => "\xda\x91",
		"\x9B" => "\xe2\x80\xba",
		"\x9C" => "\xc5\x93",
		"\x9D" => "\xe2\x80\x8c",
		"\x9E" => "\xe2\x80\x8d",
		"\x9F" => "\xda\xba",
		"\xA0" => "\xc2\xa0",
		"\xA1" => "\xd8\x8c",
		"\xA2" => "\xc2\xa2",
		"\xA3" => "\xc2\xa3",
		"\xA4" => "\xc2\xa4",
		"\xA5" => "\xc2\xa5",
		"\xA6" => "\xc2\xa6",
		"\xA7" => "\xc2\xa7",
		"\xA8" => "\xc2\xa8",
		"\xA9" => "\xc2\xa9",
		"\xAA" => "\xda\xbe",
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
		"\xBA" => "\xd8\x9b",
		"\xBB" => "\xc2\xbb",
		"\xBC" => "\xc2\xbc",
		"\xBD" => "\xc2\xbd",
		"\xBE" => "\xc2\xbe",
		"\xBF" => "\xd8\x9f",
		"\xC0" => "\xdb\x81",
		"\xC1" => "\xd8\xa1",
		"\xC2" => "\xd8\xa2",
		"\xC3" => "\xd8\xa3",
		"\xC4" => "\xd8\xa4",
		"\xC5" => "\xd8\xa5",
		"\xC6" => "\xd8\xa6",
		"\xC7" => "\xd8\xa7",
		"\xC8" => "\xd8\xa8",
		"\xC9" => "\xd8\xa9",
		"\xCA" => "\xd8\xaa",
		"\xCB" => "\xd8\xab",
		"\xCC" => "\xd8\xac",
		"\xCD" => "\xd8\xad",
		"\xCE" => "\xd8\xae",
		"\xCF" => "\xd8\xaf",
		"\xD0" => "\xd8\xb0",
		"\xD1" => "\xd8\xb1",
		"\xD2" => "\xd8\xb2",
		"\xD3" => "\xd8\xb3",
		"\xD4" => "\xd8\xb4",
		"\xD5" => "\xd8\xb5",
		"\xD6" => "\xd8\xb6",
		"\xD7" => "\xc3\x97",
		"\xD8" => "\xd8\xb7",
		"\xD9" => "\xd8\xb8",
		"\xDA" => "\xd8\xb9",
		"\xDB" => "\xd8\xba",
		"\xDC" => "\xd9\x80",
		"\xDD" => "\xd9\x81",
		"\xDE" => "\xd9\x82",
		"\xDF" => "\xd9\x83",
		"\xE0" => "\xc3\xa0",
		"\xE1" => "\xd9\x84",
		"\xE2" => "\xc3\xa2",
		"\xE3" => "\xd9\x85",
		"\xE4" => "\xd9\x86",
		"\xE5" => "\xd9\x87",
		"\xE6" => "\xd9\x88",
		"\xE7" => "\xc3\xa7",
		"\xE8" => "\xc3\xa8",
		"\xE9" => "\xc3\xa9",
		"\xEA" => "\xc3\xaa",
		"\xEB" => "\xc3\xab",
		"\xEC" => "\xd9\x89",
		"\xED" => "\xd9\x8a",
		"\xEE" => "\xc3\xae",
		"\xEF" => "\xc3\xaf",
		"\xF0" => "\xd9\x8b",
		"\xF1" => "\xd9\x8c",
		"\xF2" => "\xd9\x8d",
		"\xF3" => "\xd9\x8e",
		"\xF4" => "\xc3\xb4",
		"\xF5" => "\xd9\x8f",
		"\xF6" => "\xd9\x90",
		"\xF7" => "\xc3\xb7",
		"\xF8" => "\xd9\x91",
		"\xF9" => "\xc3\xb9",
		"\xFA" => "\xd9\x92",
		"\xFB" => "\xc3\xbb",
		"\xFC" => "\xc3\xbc",
		"\xFD" => "\xe2\x80\x8e",
		"\xFE" => "\xe2\x80\x8f",
		"\xFF" => "\xdb\x92",
	);
	
	private static $aliases = array(
		'cp1256', 
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
		return 'WINDOWS-1256';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}