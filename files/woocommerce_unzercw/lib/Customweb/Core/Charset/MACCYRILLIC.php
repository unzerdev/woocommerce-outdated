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

class Customweb_Core_Charset_MACCYRILLIC extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xd0\x90",
		"\x81" => "\xd0\x91",
		"\x82" => "\xd0\x92",
		"\x83" => "\xd0\x93",
		"\x84" => "\xd0\x94",
		"\x85" => "\xd0\x95",
		"\x86" => "\xd0\x96",
		"\x87" => "\xd0\x97",
		"\x88" => "\xd0\x98",
		"\x89" => "\xd0\x99",
		"\x8A" => "\xd0\x9a",
		"\x8B" => "\xd0\x9b",
		"\x8C" => "\xd0\x9c",
		"\x8D" => "\xd0\x9d",
		"\x8E" => "\xd0\x9e",
		"\x8F" => "\xd0\x9f",
		"\x90" => "\xd0\xa0",
		"\x91" => "\xd0\xa1",
		"\x92" => "\xd0\xa2",
		"\x93" => "\xd0\xa3",
		"\x94" => "\xd0\xa4",
		"\x95" => "\xd0\xa5",
		"\x96" => "\xd0\xa6",
		"\x97" => "\xd0\xa7",
		"\x98" => "\xd0\xa8",
		"\x99" => "\xd0\xa9",
		"\x9A" => "\xd0\xaa",
		"\x9B" => "\xd0\xab",
		"\x9C" => "\xd0\xac",
		"\x9D" => "\xd0\xad",
		"\x9E" => "\xd0\xae",
		"\x9F" => "\xd0\xaf",
		"\xA0" => "\xe2\x80\xa0",
		"\xA1" => "\xc2\xb0",
		"\xA2" => "\xc2\xa2",
		"\xA3" => "\xc2\xa3",
		"\xA4" => "\xc2\xa7",
		"\xA5" => "\xe2\x80\xa2",
		"\xA6" => "\xc2\xb6",
		"\xA7" => "\xd0\x86",
		"\xA8" => "\xc2\xae",
		"\xA9" => "\xc2\xa9",
		"\xAA" => "\xe2\x84\xa2",
		"\xAB" => "\xd0\x82",
		"\xAC" => "\xd1\x92",
		"\xAD" => "\xe2\x89\xa0",
		"\xAE" => "\xd0\x83",
		"\xAF" => "\xd1\x93",
		"\xB0" => "\xe2\x88\x9e",
		"\xB1" => "\xc2\xb1",
		"\xB2" => "\xe2\x89\xa4",
		"\xB3" => "\xe2\x89\xa5",
		"\xB4" => "\xd1\x96",
		"\xB5" => "\xc2\xb5",
		"\xB6" => "\xe2\x88\x82",
		"\xB7" => "\xd0\x88",
		"\xB8" => "\xd0\x84",
		"\xB9" => "\xd1\x94",
		"\xBA" => "\xd0\x87",
		"\xBB" => "\xd1\x97",
		"\xBC" => "\xd0\x89",
		"\xBD" => "\xd1\x99",
		"\xBE" => "\xd0\x8a",
		"\xBF" => "\xd1\x9a",
		"\xC0" => "\xd1\x98",
		"\xC1" => "\xd0\x85",
		"\xC2" => "\xc2\xac",
		"\xC3" => "\xe2\x88\x9a",
		"\xC4" => "\xc6\x92",
		"\xC5" => "\xe2\x89\x88",
		"\xC6" => "\xe2\x88\x86",
		"\xC7" => "\xc2\xab",
		"\xC8" => "\xc2\xbb",
		"\xC9" => "\xe2\x80\xa6",
		"\xCA" => "\xc2\xa0",
		"\xCB" => "\xd0\x8b",
		"\xCC" => "\xd1\x9b",
		"\xCD" => "\xd0\x8c",
		"\xCE" => "\xd1\x9c",
		"\xCF" => "\xd1\x95",
		"\xD0" => "\xe2\x80\x93",
		"\xD1" => "\xe2\x80\x94",
		"\xD2" => "\xe2\x80\x9c",
		"\xD3" => "\xe2\x80\x9d",
		"\xD4" => "\xe2\x80\x98",
		"\xD5" => "\xe2\x80\x99",
		"\xD6" => "\xc3\xb7",
		"\xD7" => "\xe2\x80\x9e",
		"\xD8" => "\xd0\x8e",
		"\xD9" => "\xd1\x9e",
		"\xDA" => "\xd0\x8f",
		"\xDB" => "\xd1\x9f",
		"\xDC" => "\xe2\x84\x96",
		"\xDD" => "\xd0\x81",
		"\xDE" => "\xd1\x91",
		"\xDF" => "\xd1\x8f",
		"\xE0" => "\xd0\xb0",
		"\xE1" => "\xd0\xb1",
		"\xE2" => "\xd0\xb2",
		"\xE3" => "\xd0\xb3",
		"\xE4" => "\xd0\xb4",
		"\xE5" => "\xd0\xb5",
		"\xE6" => "\xd0\xb6",
		"\xE7" => "\xd0\xb7",
		"\xE8" => "\xd0\xb8",
		"\xE9" => "\xd0\xb9",
		"\xEA" => "\xd0\xba",
		"\xEB" => "\xd0\xbb",
		"\xEC" => "\xd0\xbc",
		"\xED" => "\xd0\xbd",
		"\xEE" => "\xd0\xbe",
		"\xEF" => "\xd0\xbf",
		"\xF0" => "\xd1\x80",
		"\xF1" => "\xd1\x81",
		"\xF2" => "\xd1\x82",
		"\xF3" => "\xd1\x83",
		"\xF4" => "\xd1\x84",
		"\xF5" => "\xd1\x85",
		"\xF6" => "\xd1\x86",
		"\xF7" => "\xd1\x87",
		"\xF8" => "\xd1\x88",
		"\xF9" => "\xd1\x89",
		"\xFA" => "\xd1\x8a",
		"\xFB" => "\xd1\x8b",
		"\xFC" => "\xd1\x8c",
		"\xFD" => "\xd1\x8d",
		"\xFE" => "\xd1\x8e",
		"\xFF" => "\xc2\xa4",
	);
	
	private static $aliases = array(
		'cp10007',
		'x-MacCyrillic',
		'MacCyrillic',
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
		return 'MAC-CYRILLIC';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}