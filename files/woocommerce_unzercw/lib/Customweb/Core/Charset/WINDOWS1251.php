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

class Customweb_Core_Charset_WINDOWS1251 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xd0\x82",
		"\x81" => "\xd0\x83",
		"\x82" => "\xe2\x80\x9a",
		"\x83" => "\xd1\x93",
		"\x84" => "\xe2\x80\x9e",
		"\x85" => "\xe2\x80\xa6",
		"\x86" => "\xe2\x80\xa0",
		"\x87" => "\xe2\x80\xa1",
		"\x88" => "\xe2\x82\xac",
		"\x89" => "\xe2\x80\xb0",
		"\x8A" => "\xd0\x89",
		"\x8B" => "\xe2\x80\xb9",
		"\x8C" => "\xd0\x8a",
		"\x8D" => "\xd0\x8c",
		"\x8E" => "\xd0\x8b",
		"\x8F" => "\xd0\x8f",
		"\x90" => "\xd1\x92",
		"\x91" => "\xe2\x80\x98",
		"\x92" => "\xe2\x80\x99",
		"\x93" => "\xe2\x80\x9c",
		"\x94" => "\xe2\x80\x9d",
		"\x95" => "\xe2\x80\xa2",
		"\x96" => "\xe2\x80\x93",
		"\x97" => "\xe2\x80\x94",
		"\x99" => "\xe2\x84\xa2",
		"\x9A" => "\xd1\x99",
		"\x9B" => "\xe2\x80\xba",
		"\x9C" => "\xd1\x9a",
		"\x9D" => "\xd1\x9c",
		"\x9E" => "\xd1\x9b",
		"\x9F" => "\xd1\x9f",
		"\xA0" => "\xc2\xa0",
		"\xA1" => "\xd0\x8e",
		"\xA2" => "\xd1\x9e",
		"\xA3" => "\xd0\x88",
		"\xA4" => "\xc2\xa4",
		"\xA5" => "\xd2\x90",
		"\xA6" => "\xc2\xa6",
		"\xA7" => "\xc2\xa7",
		"\xA8" => "\xd0\x81",
		"\xA9" => "\xc2\xa9",
		"\xAA" => "\xd0\x84",
		"\xAB" => "\xc2\xab",
		"\xAC" => "\xc2\xac",
		"\xAD" => "\xc2\xad",
		"\xAE" => "\xc2\xae",
		"\xAF" => "\xd0\x87",
		"\xB0" => "\xc2\xb0",
		"\xB1" => "\xc2\xb1",
		"\xB2" => "\xd0\x86",
		"\xB3" => "\xd1\x96",
		"\xB4" => "\xd2\x91",
		"\xB5" => "\xc2\xb5",
		"\xB6" => "\xc2\xb6",
		"\xB7" => "\xc2\xb7",
		"\xB8" => "\xd1\x91",
		"\xB9" => "\xe2\x84\x96",
		"\xBA" => "\xd1\x94",
		"\xBB" => "\xc2\xbb",
		"\xBC" => "\xd1\x98",
		"\xBD" => "\xd0\x85",
		"\xBE" => "\xd1\x95",
		"\xBF" => "\xd1\x97",
		"\xC0" => "\xd0\x90",
		"\xC1" => "\xd0\x91",
		"\xC2" => "\xd0\x92",
		"\xC3" => "\xd0\x93",
		"\xC4" => "\xd0\x94",
		"\xC5" => "\xd0\x95",
		"\xC6" => "\xd0\x96",
		"\xC7" => "\xd0\x97",
		"\xC8" => "\xd0\x98",
		"\xC9" => "\xd0\x99",
		"\xCA" => "\xd0\x9a",
		"\xCB" => "\xd0\x9b",
		"\xCC" => "\xd0\x9c",
		"\xCD" => "\xd0\x9d",
		"\xCE" => "\xd0\x9e",
		"\xCF" => "\xd0\x9f",
		"\xD0" => "\xd0\xa0",
		"\xD1" => "\xd0\xa1",
		"\xD2" => "\xd0\xa2",
		"\xD3" => "\xd0\xa3",
		"\xD4" => "\xd0\xa4",
		"\xD5" => "\xd0\xa5",
		"\xD6" => "\xd0\xa6",
		"\xD7" => "\xd0\xa7",
		"\xD8" => "\xd0\xa8",
		"\xD9" => "\xd0\xa9",
		"\xDA" => "\xd0\xaa",
		"\xDB" => "\xd0\xab",
		"\xDC" => "\xd0\xac",
		"\xDD" => "\xd0\xad",
		"\xDE" => "\xd0\xae",
		"\xDF" => "\xd0\xaf",
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
		"\xFF" => "\xd1\x8f",
	);
	
	private static $aliases = array(
		'ansi-1251',
		'cp5347',
		'cp1251',
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
		return 'WINDOWS-1251';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}