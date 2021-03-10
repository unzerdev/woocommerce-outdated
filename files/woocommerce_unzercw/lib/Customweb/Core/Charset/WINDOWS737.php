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

class Customweb_Core_Charset_WINDOWS737 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xce\x91",
		"\x81" => "\xce\x92",
		"\x82" => "\xce\x93",
		"\x83" => "\xce\x94",
		"\x84" => "\xce\x95",
		"\x85" => "\xce\x96",
		"\x86" => "\xce\x97",
		"\x87" => "\xce\x98",
		"\x88" => "\xce\x99",
		"\x89" => "\xce\x9a",
		"\x8a" => "\xce\x9b",
		"\x8b" => "\xce\x9c",
		"\x8c" => "\xce\x9d",
		"\x8d" => "\xce\x9e",
		"\x8e" => "\xce\x9f",
		"\x8f" => "\xce\xa0",
		"\x90" => "\xce\xa1",
		"\x91" => "\xce\xa3",
		"\x92" => "\xce\xa4",
		"\x93" => "\xce\xa5",
		"\x94" => "\xce\xa6",
		"\x95" => "\xce\xa7",
		"\x96" => "\xce\xa8",
		"\x97" => "\xce\xa9",
		"\x98" => "\xce\xb1",
		"\x99" => "\xce\xb2",
		"\x9a" => "\xce\xb3",
		"\x9b" => "\xce\xb4",
		"\x9c" => "\xce\xb5",
		"\x9d" => "\xce\xb6",
		"\x9e" => "\xce\xb7",
		"\x9f" => "\xce\xb8",
		"\xa0" => "\xce\xb9",
		"\xa1" => "\xce\xba",
		"\xa2" => "\xce\xbb",
		"\xa3" => "\xce\xbc",
		"\xa4" => "\xce\xbd",
		"\xa5" => "\xce\xbe",
		"\xa6" => "\xce\xbf",
		"\xa7" => "\xcf\x80",
		"\xa8" => "\xcf\x81",
		"\xa9" => "\xcf\x83",
		"\xaa" => "\xcf\x82",
		"\xab" => "\xcf\x84",
		"\xac" => "\xcf\x85",
		"\xad" => "\xcf\x86",
		"\xae" => "\xcf\x87",
		"\xaf" => "\xcf\x88",
		"\xb0" => "\xe2\x96\x91",
		"\xb1" => "\xe2\x96\x92",
		"\xb2" => "\xe2\x96\x93",
		"\xb3" => "\xe2\x94\x82",
		"\xb4" => "\xe2\x94\xa4",
		"\xb5" => "\xe2\x95\xa1",
		"\xb6" => "\xe2\x95\xa2",
		"\xb7" => "\xe2\x95\x96",
		"\xb8" => "\xe2\x95\x95",
		"\xb9" => "\xe2\x95\xa3",
		"\xba" => "\xe2\x95\x91",
		"\xbb" => "\xe2\x95\x97",
		"\xbc" => "\xe2\x95\x9d",
		"\xbd" => "\xe2\x95\x9c",
		"\xbe" => "\xe2\x95\x9b",
		"\xbf" => "\xe2\x94\x90",
		"\xc0" => "\xe2\x94\x94",
		"\xc1" => "\xe2\x94\xb4",
		"\xc2" => "\xe2\x94\xac",
		"\xc3" => "\xe2\x94\x9c",
		"\xc4" => "\xe2\x94\x80",
		"\xc5" => "\xe2\x94\xbc",
		"\xc6" => "\xe2\x95\x9e",
		"\xc7" => "\xe2\x95\x9f",
		"\xc8" => "\xe2\x95\x9a",
		"\xc9" => "\xe2\x95\x94",
		"\xca" => "\xe2\x95\xa9",
		"\xcb" => "\xe2\x95\xa6",
		"\xcc" => "\xe2\x95\xa0",
		"\xcd" => "\xe2\x95\x90",
		"\xce" => "\xe2\x95\xac",
		"\xcf" => "\xe2\x95\xa7",
		"\xd0" => "\xe2\x95\xa8",
		"\xd1" => "\xe2\x95\xa4",
		"\xd2" => "\xe2\x95\xa5",
		"\xd3" => "\xe2\x95\x99",
		"\xd4" => "\xe2\x95\x98",
		"\xd5" => "\xe2\x95\x92",
		"\xd6" => "\xe2\x95\x93",
		"\xd7" => "\xe2\x95\xab",
		"\xd8" => "\xe2\x95\xaa",
		"\xd9" => "\xe2\x94\x98",
		"\xda" => "\xe2\x94\x8c",
		"\xdb" => "\xe2\x96\x88",
		"\xdc" => "\xe2\x96\x84",
		"\xdd" => "\xe2\x96\x8c",
		"\xde" => "\xe2\x96\x90",
		"\xdf" => "\xe2\x96\x80",
		"\xe0" => "\xcf\x89",
		"\xe1" => "\xce\xac",
		"\xe2" => "\xce\xad",
		"\xe3" => "\xce\xae",
		"\xe4" => "\xcf\x8a",
		"\xe5" => "\xce\xaf",
		"\xe6" => "\xcf\x8c",
		"\xe7" => "\xcf\x8d",
		"\xe8" => "\xcf\x8b",
		"\xe9" => "\xcf\x8e",
		"\xea" => "\xce\x86",
		"\xeb" => "\xce\x88",
		"\xec" => "\xce\x89",
		"\xed" => "\xce\x8a",
		"\xee" => "\xce\x8c",
		"\xef" => "\xce\x8e",
		"\xf0" => "\xce\x8f",
		"\xf1" => "\xc2\xb1",
		"\xf2" => "\xe2\x89\xa5",
		"\xf3" => "\xe2\x89\xa4",
		"\xf4" => "\xce\xaa",
		"\xf5" => "\xce\xab",
		"\xf6" => "\xc3\xb7",
		"\xf7" => "\xe2\x89\x88",
		"\xf8" => "\xc2\xb0",
		"\xf9" => "\xe2\x88\x99",
		"\xfa" => "\xc2\xb7",
		"\xfb" => "\xe2\x88\x9a",
		"\xfc" => "\xe2\x81\xbf",
		"\xfd" => "\xc2\xb2",
		"\xfe" => "\xe2\x96\xa0",
		"\xff" => "\xc2\xa0",
	);
	
	private static $aliases = array(
		'x-IBM737',
		'cp737',
		'ibm-737',
		'737',
		'ibm737',
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
		return 'WINDOWS-737';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}