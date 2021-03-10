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

class Customweb_Core_Charset_WINDOWS852 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xc3\x87",
		"\x81" => "\xc3\xbc",
		"\x82" => "\xc3\xa9",
		"\x83" => "\xc3\xa2",
		"\x84" => "\xc3\xa4",
		"\x85" => "\xc5\xaf",
		"\x86" => "\xc4\x87",
		"\x87" => "\xc3\xa7",
		"\x88" => "\xc5\x82",
		"\x89" => "\xc3\xab",
		"\x8a" => "\xc5\x90",
		"\x8b" => "\xc5\x91",
		"\x8c" => "\xc3\xae",
		"\x8d" => "\xc5\xb9",
		"\x8e" => "\xc3\x84",
		"\x8f" => "\xc4\x86",
		"\x90" => "\xc3\x89",
		"\x91" => "\xc4\xb9",
		"\x92" => "\xc4\xba",
		"\x93" => "\xc3\xb4",
		"\x94" => "\xc3\xb6",
		"\x95" => "\xc4\xbd",
		"\x96" => "\xc4\xbe",
		"\x97" => "\xc5\x9a",
		"\x98" => "\xc5\x9b",
		"\x99" => "\xc3\x96",
		"\x9a" => "\xc3\x9c",
		"\x9b" => "\xc5\xa4",
		"\x9c" => "\xc5\xa5",
		"\x9d" => "\xc5\x81",
		"\x9e" => "\xc3\x97",
		"\x9f" => "\xc4\x8d",
		"\xa0" => "\xc3\xa1",
		"\xa1" => "\xc3\xad",
		"\xa2" => "\xc3\xb3",
		"\xa3" => "\xc3\xba",
		"\xa4" => "\xc4\x84",
		"\xa5" => "\xc4\x85",
		"\xa6" => "\xc5\xbd",
		"\xa7" => "\xc5\xbe",
		"\xa8" => "\xc4\x98",
		"\xa9" => "\xc4\x99",
		"\xaa" => "\xc2\xac",
		"\xab" => "\xc5\xba",
		"\xac" => "\xc4\x8c",
		"\xad" => "\xc5\x9f",
		"\xae" => "\xc2\xab",
		"\xaf" => "\xc2\xbb",
		"\xb0" => "\xe2\x96\x91",
		"\xb1" => "\xe2\x96\x92",
		"\xb2" => "\xe2\x96\x93",
		"\xb3" => "\xe2\x94\x82",
		"\xb4" => "\xe2\x94\xa4",
		"\xb5" => "\xc3\x81",
		"\xb6" => "\xc3\x82",
		"\xb7" => "\xc4\x9a",
		"\xb8" => "\xc5\x9e",
		"\xb9" => "\xe2\x95\xa3",
		"\xba" => "\xe2\x95\x91",
		"\xbb" => "\xe2\x95\x97",
		"\xbc" => "\xe2\x95\x9d",
		"\xbd" => "\xc5\xbb",
		"\xbe" => "\xc5\xbc",
		"\xbf" => "\xe2\x94\x90",
		"\xc0" => "\xe2\x94\x94",
		"\xc1" => "\xe2\x94\xb4",
		"\xc2" => "\xe2\x94\xac",
		"\xc3" => "\xe2\x94\x9c",
		"\xc4" => "\xe2\x94\x80",
		"\xc5" => "\xe2\x94\xbc",
		"\xc6" => "\xc4\x82",
		"\xc7" => "\xc4\x83",
		"\xc8" => "\xe2\x95\x9a",
		"\xc9" => "\xe2\x95\x94",
		"\xca" => "\xe2\x95\xa9",
		"\xcb" => "\xe2\x95\xa6",
		"\xcc" => "\xe2\x95\xa0",
		"\xcd" => "\xe2\x95\x90",
		"\xce" => "\xe2\x95\xac",
		"\xcf" => "\xc2\xa4",
		"\xd0" => "\xc4\x91",
		"\xd1" => "\xc4\x90",
		"\xd2" => "\xc4\x8e",
		"\xd3" => "\xc3\x8b",
		"\xd4" => "\xc4\x8f",
		"\xd5" => "\xc5\x87",
		"\xd6" => "\xc3\x8d",
		"\xd7" => "\xc3\x8e",
		"\xd8" => "\xc4\x9b",
		"\xd9" => "\xe2\x94\x98",
		"\xda" => "\xe2\x94\x8c",
		"\xdb" => "\xe2\x96\x88",
		"\xdc" => "\xe2\x96\x84",
		"\xdd" => "\xc5\xa2",
		"\xde" => "\xc5\xae",
		"\xdf" => "\xe2\x96\x80",
		"\xe0" => "\xc3\x93",
		"\xe1" => "\xc3\x9f",
		"\xe2" => "\xc3\x94",
		"\xe3" => "\xc5\x83",
		"\xe4" => "\xc5\x84",
		"\xe5" => "\xc5\x88",
		"\xe6" => "\xc5\xa0",
		"\xe7" => "\xc5\xa1",
		"\xe8" => "\xc5\x94",
		"\xe9" => "\xc3\x9a",
		"\xea" => "\xc5\x95",
		"\xeb" => "\xc5\xb0",
		"\xec" => "\xc3\xbd",
		"\xed" => "\xc3\x9d",
		"\xee" => "\xc5\xa3",
		"\xef" => "\xc2\xb4",
		"\xf0" => "\xc2\xad",
		"\xf1" => "\xcb\x9d",
		"\xf2" => "\xcb\x9b",
		"\xf3" => "\xcb\x87",
		"\xf4" => "\xcb\x98",
		"\xf5" => "\xc2\xa7",
		"\xf6" => "\xc3\xb7",
		"\xf7" => "\xc2\xb8",
		"\xf8" => "\xc2\xb0",
		"\xf9" => "\xc2\xa8",
		"\xfa" => "\xcb\x99",
		"\xfb" => "\xc5\xb1",
		"\xfc" => "\xc5\x98",
		"\xfd" => "\xc5\x99",
		"\xfe" => "\xe2\x96\xa0",
		"\xff" => "\xc2\xa0",
	);
	
	private static $aliases = array(
		'IBM852',
		'ibm852',
		'csPCp852',
		'852',
		'ibm-852',
		'cp852',
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
		return 'WINDOWS-852';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}