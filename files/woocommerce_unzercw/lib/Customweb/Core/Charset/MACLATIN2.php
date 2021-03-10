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

class Customweb_Core_Charset_MACLATIN2 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xc3\x84",
		"\x81" => "\xc4\x80",
		"\x82" => "\xc4\x81",
		"\x83" => "\xc3\x89",
		"\x84" => "\xc4\x84",
		"\x85" => "\xc3\x96",
		"\x86" => "\xc3\x9c",
		"\x87" => "\xc3\xa1",
		"\x88" => "\xc4\x85",
		"\x89" => "\xc4\x8c",
		"\x8A" => "\xc3\xa4",
		"\x8B" => "\xc4\x8d",
		"\x8C" => "\xc4\x86",
		"\x8D" => "\xc4\x87",
		"\x8E" => "\xc3\xa9",
		"\x8F" => "\xc5\xb9",
		"\x90" => "\xc5\xba",
		"\x91" => "\xc4\x8e",
		"\x92" => "\xc3\xad",
		"\x93" => "\xc4\x8f",
		"\x94" => "\xc4\x92",
		"\x95" => "\xc4\x93",
		"\x96" => "\xc4\x96",
		"\x97" => "\xc3\xb3",
		"\x98" => "\xc4\x97",
		"\x99" => "\xc3\xb4",
		"\x9A" => "\xc3\xb6",
		"\x9B" => "\xc3\xb5",
		"\x9C" => "\xc3\xba",
		"\x9D" => "\xc4\x9a",
		"\x9E" => "\xc4\x9b",
		"\x9F" => "\xc3\xbc",
		"\xA0" => "\xe2\x80\xa0",
		"\xA1" => "\xc2\xb0",
		"\xA2" => "\xc4\x98",
		"\xA3" => "\xc2\xa3",
		"\xA4" => "\xc2\xa7",
		"\xA5" => "\xe2\x80\xa2",
		"\xA6" => "\xc2\xb6",
		"\xA7" => "\xc3\x9f",
		"\xA8" => "\xc2\xae",
		"\xA9" => "\xc2\xa9",
		"\xAA" => "\xe2\x84\xa2",
		"\xAB" => "\xc4\x99",
		"\xAC" => "\xc2\xa8",
		"\xAD" => "\xe2\x89\xa0",
		"\xAE" => "\xc4\xa3",
		"\xAF" => "\xc4\xae",
		"\xB0" => "\xc4\xaf",
		"\xB1" => "\xc4\xaa",
		"\xB2" => "\xe2\x89\xa4",
		"\xB3" => "\xe2\x89\xa5",
		"\xB4" => "\xc4\xab",
		"\xB5" => "\xc4\xb6",
		"\xB6" => "\xe2\x88\x82",
		"\xB7" => "\xe2\x88\x91",
		"\xB8" => "\xc5\x82",
		"\xB9" => "\xc4\xbb",
		"\xBA" => "\xc4\xbc",
		"\xBB" => "\xc4\xbd",
		"\xBC" => "\xc4\xbe",
		"\xBD" => "\xc4\xb9",
		"\xBE" => "\xc4\xba",
		"\xBF" => "\xc5\x85",
		"\xC0" => "\xc5\x86",
		"\xC1" => "\xc5\x83",
		"\xC2" => "\xc2\xac",
		"\xC3" => "\xe2\x88\x9a",
		"\xC4" => "\xc5\x84",
		"\xC5" => "\xc5\x87",
		"\xC6" => "\xe2\x88\x86",
		"\xC7" => "\xc2\xab",
		"\xC8" => "\xc2\xbb",
		"\xC9" => "\xe2\x80\xa6",
		"\xCA" => "\xc2\xa0",
		"\xCB" => "\xc5\x88",
		"\xCC" => "\xc5\x90",
		"\xCD" => "\xc3\x95",
		"\xCE" => "\xc5\x91",
		"\xCF" => "\xc5\x8c",
		"\xD0" => "\xe2\x80\x93",
		"\xD1" => "\xe2\x80\x94",
		"\xD2" => "\xe2\x80\x9c",
		"\xD3" => "\xe2\x80\x9d",
		"\xD4" => "\xe2\x80\x98",
		"\xD5" => "\xe2\x80\x99",
		"\xD6" => "\xc3\xb7",
		"\xD7" => "\xe2\x97\x8a",
		"\xD8" => "\xc5\x8d",
		"\xD9" => "\xc5\x94",
		"\xDA" => "\xc5\x95",
		"\xDB" => "\xc5\x98",
		"\xDC" => "\xe2\x80\xb9",
		"\xDD" => "\xe2\x80\xba",
		"\xDE" => "\xc5\x99",
		"\xDF" => "\xc5\x96",
		"\xE0" => "\xc5\x97",
		"\xE1" => "\xc5\xa0",
		"\xE2" => "\xe2\x80\x9a",
		"\xE3" => "\xe2\x80\x9e",
		"\xE4" => "\xc5\xa1",
		"\xE5" => "\xc5\x9a",
		"\xE6" => "\xc5\x9b",
		"\xE7" => "\xc3\x81",
		"\xE8" => "\xc5\xa4",
		"\xE9" => "\xc5\xa5",
		"\xEA" => "\xc3\x8d",
		"\xEB" => "\xc5\xbd",
		"\xEC" => "\xc5\xbe",
		"\xED" => "\xc5\xaa",
		"\xEE" => "\xc3\x93",
		"\xEF" => "\xc3\x94",
		"\xF0" => "\xc5\xab",
		"\xF1" => "\xc5\xae",
		"\xF2" => "\xc3\x9a",
		"\xF3" => "\xc5\xaf",
		"\xF4" => "\xc5\xb0",
		"\xF5" => "\xc5\xb1",
		"\xF6" => "\xc5\xb2",
		"\xF7" => "\xc5\xb3",
		"\xF8" => "\xc3\x9d",
		"\xF9" => "\xc3\xbd",
		"\xFA" => "\xc4\xb7",
		"\xFB" => "\xc5\xbb",
		"\xFC" => "\xc5\x81",
		"\xFD" => "\xc5\xbc",
		"\xFE" => "\xc4\xa2",
		"\xFF" => "\xcb\x87",
	);
	
	private static $aliases = array(
		'cp10029',
		'MacLatin2',
		'X-MacLatin2',
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
		return 'MAC-LATIN2';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}