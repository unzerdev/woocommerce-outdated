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

class Customweb_Core_Charset_WINDOWS855 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xd1\x92",
		"\x81" => "\xd0\x82",
		"\x82" => "\xd1\x93",
		"\x83" => "\xd0\x83",
		"\x84" => "\xd1\x91",
		"\x85" => "\xd0\x81",
		"\x86" => "\xd1\x94",
		"\x87" => "\xd0\x84",
		"\x88" => "\xd1\x95",
		"\x89" => "\xd0\x85",
		"\x8a" => "\xd1\x96",
		"\x8b" => "\xd0\x86",
		"\x8c" => "\xd1\x97",
		"\x8d" => "\xd0\x87",
		"\x8e" => "\xd1\x98",
		"\x8f" => "\xd0\x88",
		"\x90" => "\xd1\x99",
		"\x91" => "\xd0\x89",
		"\x92" => "\xd1\x9a",
		"\x93" => "\xd0\x8a",
		"\x94" => "\xd1\x9b",
		"\x95" => "\xd0\x8b",
		"\x96" => "\xd1\x9c",
		"\x97" => "\xd0\x8c",
		"\x98" => "\xd1\x9e",
		"\x99" => "\xd0\x8e",
		"\x9a" => "\xd1\x9f",
		"\x9b" => "\xd0\x8f",
		"\x9c" => "\xd1\x8e",
		"\x9d" => "\xd0\xae",
		"\x9e" => "\xd1\x8a",
		"\x9f" => "\xd0\xaa",
		"\xa0" => "\xd0\xb0",
		"\xa1" => "\xd0\x90",
		"\xa2" => "\xd0\xb1",
		"\xa3" => "\xd0\x91",
		"\xa4" => "\xd1\x86",
		"\xa5" => "\xd0\xa6",
		"\xa6" => "\xd0\xb4",
		"\xa7" => "\xd0\x94",
		"\xa8" => "\xd0\xb5",
		"\xa9" => "\xd0\x95",
		"\xaa" => "\xd1\x84",
		"\xab" => "\xd0\xa4",
		"\xac" => "\xd0\xb3",
		"\xad" => "\xd0\x93",
		"\xae" => "\xc2\xab",
		"\xaf" => "\xc2\xbb",
		"\xb0" => "\xe2\x96\x91",
		"\xb1" => "\xe2\x96\x92",
		"\xb2" => "\xe2\x96\x93",
		"\xb3" => "\xe2\x94\x82",
		"\xb4" => "\xe2\x94\xa4",
		"\xb5" => "\xd1\x85",
		"\xb6" => "\xd0\xa5",
		"\xb7" => "\xd0\xb8",
		"\xb8" => "\xd0\x98",
		"\xb9" => "\xe2\x95\xa3",
		"\xba" => "\xe2\x95\x91",
		"\xbb" => "\xe2\x95\x97",
		"\xbc" => "\xe2\x95\x9d",
		"\xbd" => "\xd0\xb9",
		"\xbe" => "\xd0\x99",
		"\xbf" => "\xe2\x94\x90",
		"\xc0" => "\xe2\x94\x94",
		"\xc1" => "\xe2\x94\xb4",
		"\xc2" => "\xe2\x94\xac",
		"\xc3" => "\xe2\x94\x9c",
		"\xc4" => "\xe2\x94\x80",
		"\xc5" => "\xe2\x94\xbc",
		"\xc6" => "\xd0\xba",
		"\xc7" => "\xd0\x9a",
		"\xc8" => "\xe2\x95\x9a",
		"\xc9" => "\xe2\x95\x94",
		"\xca" => "\xe2\x95\xa9",
		"\xcb" => "\xe2\x95\xa6",
		"\xcc" => "\xe2\x95\xa0",
		"\xcd" => "\xe2\x95\x90",
		"\xce" => "\xe2\x95\xac",
		"\xcf" => "\xc2\xa4",
		"\xd0" => "\xd0\xbb",
		"\xd1" => "\xd0\x9b",
		"\xd2" => "\xd0\xbc",
		"\xd3" => "\xd0\x9c",
		"\xd4" => "\xd0\xbd",
		"\xd5" => "\xd0\x9d",
		"\xd6" => "\xd0\xbe",
		"\xd7" => "\xd0\x9e",
		"\xd8" => "\xd0\xbf",
		"\xd9" => "\xe2\x94\x98",
		"\xda" => "\xe2\x94\x8c",
		"\xdb" => "\xe2\x96\x88",
		"\xdc" => "\xe2\x96\x84",
		"\xdd" => "\xd0\x9f",
		"\xde" => "\xd1\x8f",
		"\xdf" => "\xe2\x96\x80",
		"\xe0" => "\xd0\xaf",
		"\xe1" => "\xd1\x80",
		"\xe2" => "\xd0\xa0",
		"\xe3" => "\xd1\x81",
		"\xe4" => "\xd0\xa1",
		"\xe5" => "\xd1\x82",
		"\xe6" => "\xd0\xa2",
		"\xe7" => "\xd1\x83",
		"\xe8" => "\xd0\xa3",
		"\xe9" => "\xd0\xb6",
		"\xea" => "\xd0\x96",
		"\xeb" => "\xd0\xb2",
		"\xec" => "\xd0\x92",
		"\xed" => "\xd1\x8c",
		"\xee" => "\xd0\xac",
		"\xef" => "\xe2\x84\x96",
		"\xf0" => "\xc2\xad",
		"\xf1" => "\xd1\x8b",
		"\xf2" => "\xd0\xab",
		"\xf3" => "\xd0\xb7",
		"\xf4" => "\xd0\x97",
		"\xf5" => "\xd1\x88",
		"\xf6" => "\xd0\xa8",
		"\xf7" => "\xd1\x8d",
		"\xf8" => "\xd0\xad",
		"\xf9" => "\xd1\x89",
		"\xfa" => "\xd0\xa9",
		"\xfb" => "\xd1\x87",
		"\xfc" => "\xd0\xa7",
		"\xfd" => "\xc2\xa7",
		"\xfe" => "\xe2\x96\xa0",
		"\xff" => "\xc2\xa0",
	);
	
	private static $aliases = array(
		'IBM855',
		'cspcp855',
		'855',
		'ibm855',
		'ibm-855',
		'cp855',
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
		return 'WINDOWS-855';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}