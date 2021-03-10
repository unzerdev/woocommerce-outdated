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

class Customweb_Core_Charset_MACGREEK extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xc3\x84",
		"\x81" => "\xc2\xb9",
		"\x82" => "\xc2\xb2",
		"\x83" => "\xc3\x89",
		"\x84" => "\xc2\xb3",
		"\x85" => "\xc3\x96",
		"\x86" => "\xc3\x9c",
		"\x87" => "\xce\x85",
		"\x88" => "\xc3\xa0",
		"\x89" => "\xc3\xa2",
		"\x8A" => "\xc3\xa4",
		"\x8B" => "\xce\x84",
		"\x8C" => "\xc2\xa8",
		"\x8D" => "\xc3\xa7",
		"\x8E" => "\xc3\xa9",
		"\x8F" => "\xc3\xa8",
		"\x90" => "\xc3\xaa",
		"\x91" => "\xc3\xab",
		"\x92" => "\xc2\xa3",
		"\x93" => "\xe2\x84\xa2",
		"\x94" => "\xc3\xae",
		"\x95" => "\xc3\xaf",
		"\x96" => "\xe2\x80\xa2",
		"\x97" => "\xc2\xbd",
		"\x98" => "\xe2\x80\xb0",
		"\x99" => "\xc3\xb4",
		"\x9A" => "\xc3\xb6",
		"\x9B" => "\xc2\xa6",
		"\x9C" => "\xc2\xad",
		"\x9D" => "\xc3\xb9",
		"\x9E" => "\xc3\xbb",
		"\x9F" => "\xc3\xbc",
		"\xA0" => "\xe2\x80\xa0",
		"\xA1" => "\xce\x93",
		"\xA2" => "\xce\x94",
		"\xA3" => "\xce\x98",
		"\xA4" => "\xce\x9b",
		"\xA5" => "\xce\x9e",
		"\xA6" => "\xce\xa0",
		"\xA7" => "\xc3\x9f",
		"\xA8" => "\xc2\xae",
		"\xA9" => "\xc2\xa9",
		"\xAA" => "\xce\xa3",
		"\xAB" => "\xce\xaa",
		"\xAC" => "\xc2\xa7",
		"\xAD" => "\xe2\x89\xa0",
		"\xAE" => "\xc2\xb0",
		"\xAF" => "\xce\x87",
		"\xB0" => "\xce\x91",
		"\xB1" => "\xc2\xb1",
		"\xB2" => "\xe2\x89\xa4",
		"\xB3" => "\xe2\x89\xa5",
		"\xB4" => "\xc2\xa5",
		"\xB5" => "\xce\x92",
		"\xB6" => "\xce\x95",
		"\xB7" => "\xce\x96",
		"\xB8" => "\xce\x97",
		"\xB9" => "\xce\x99",
		"\xBA" => "\xce\x9a",
		"\xBB" => "\xce\x9c",
		"\xBC" => "\xce\xa6",
		"\xBD" => "\xce\xab",
		"\xBE" => "\xce\xa8",
		"\xBF" => "\xce\xa9",
		"\xC0" => "\xce\xac",
		"\xC1" => "\xce\x9d",
		"\xC2" => "\xc2\xac",
		"\xC3" => "\xce\x9f",
		"\xC4" => "\xce\xa1",
		"\xC5" => "\xe2\x89\x88",
		"\xC6" => "\xce\xa4",
		"\xC7" => "\xc2\xab",
		"\xC8" => "\xc2\xbb",
		"\xC9" => "\xe2\x80\xa6",
		"\xCA" => "\xc2\xa0",
		"\xCB" => "\xce\xa5",
		"\xCC" => "\xce\xa7",
		"\xCD" => "\xce\x86",
		"\xCE" => "\xce\x88",
		"\xCF" => "\xc5\x93",
		"\xD0" => "\xe2\x80\x93",
		"\xD1" => "\xe2\x80\x95",
		"\xD2" => "\xe2\x80\x9c",
		"\xD3" => "\xe2\x80\x9d",
		"\xD4" => "\xe2\x80\x98",
		"\xD5" => "\xe2\x80\x99",
		"\xD6" => "\xc3\xb7",
		"\xD7" => "\xce\x89",
		"\xD8" => "\xce\x8a",
		"\xD9" => "\xce\x8c",
		"\xDA" => "\xce\x8e",
		"\xDB" => "\xce\xad",
		"\xDC" => "\xce\xae",
		"\xDD" => "\xce\xaf",
		"\xDE" => "\xcf\x8c",
		"\xDF" => "\xce\x8f",
		"\xE0" => "\xcf\x8d",
		"\xE1" => "\xce\xb1",
		"\xE2" => "\xce\xb2",
		"\xE3" => "\xcf\x88",
		"\xE4" => "\xce\xb4",
		"\xE5" => "\xce\xb5",
		"\xE6" => "\xcf\x86",
		"\xE7" => "\xce\xb3",
		"\xE8" => "\xce\xb7",
		"\xE9" => "\xce\xb9",
		"\xEA" => "\xce\xbe",
		"\xEB" => "\xce\xba",
		"\xEC" => "\xce\xbb",
		"\xED" => "\xce\xbc",
		"\xEE" => "\xce\xbd",
		"\xEF" => "\xce\xbf",
		"\xF0" => "\xcf\x80",
		"\xF1" => "\xcf\x8e",
		"\xF2" => "\xcf\x81",
		"\xF3" => "\xcf\x83",
		"\xF4" => "\xcf\x84",
		"\xF5" => "\xce\xb8",
		"\xF6" => "\xcf\x89",
		"\xF7" => "\xcf\x82",
		"\xF8" => "\xcf\x87",
		"\xF9" => "\xcf\x85",
		"\xFA" => "\xce\xb6",
		"\xFB" => "\xcf\x8a",
		"\xFC" => "\xcf\x8b",
		"\xFD" => "\xce\x90",
		"\xFE" => "\xce\xb0",
	);
	
	private static $aliases = array(
		'cp10006',
		'x-MacGreek',
		'MacGreek',
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
		return 'MAC-GREEK';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}