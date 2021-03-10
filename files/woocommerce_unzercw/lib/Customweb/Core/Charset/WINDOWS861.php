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

class Customweb_Core_Charset_WINDOWS861 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xc3\x87",
		"\x81" => "\xc3\xbc",
		"\x82" => "\xc3\xa9",
		"\x83" => "\xc3\xa2",
		"\x84" => "\xc3\xa4",
		"\x85" => "\xc3\xa0",
		"\x86" => "\xc3\xa5",
		"\x87" => "\xc3\xa7",
		"\x88" => "\xc3\xaa",
		"\x89" => "\xc3\xab",
		"\x8a" => "\xc3\xa8",
		"\x8b" => "\xc3\x90",
		"\x8c" => "\xc3\xb0",
		"\x8d" => "\xc3\x9e",
		"\x8e" => "\xc3\x84",
		"\x8f" => "\xc3\x85",
		"\x90" => "\xc3\x89",
		"\x91" => "\xc3\xa6",
		"\x92" => "\xc3\x86",
		"\x93" => "\xc3\xb4",
		"\x94" => "\xc3\xb6",
		"\x95" => "\xc3\xbe",
		"\x96" => "\xc3\xbb",
		"\x97" => "\xc3\x9d",
		"\x98" => "\xc3\xbd",
		"\x99" => "\xc3\x96",
		"\x9a" => "\xc3\x9c",
		"\x9b" => "\xc3\xb8",
		"\x9c" => "\xc2\xa3",
		"\x9d" => "\xc3\x98",
		"\x9e" => "\xe2\x82\xa7",
		"\x9f" => "\xc6\x92",
		"\xa0" => "\xc3\xa1",
		"\xa1" => "\xc3\xad",
		"\xa2" => "\xc3\xb3",
		"\xa3" => "\xc3\xba",
		"\xa4" => "\xc3\x81",
		"\xa5" => "\xc3\x8d",
		"\xa6" => "\xc3\x93",
		"\xa7" => "\xc3\x9a",
		"\xa8" => "\xc2\xbf",
		"\xa9" => "\xe2\x8c\x90",
		"\xaa" => "\xc2\xac",
		"\xab" => "\xc2\xbd",
		"\xac" => "\xc2\xbc",
		"\xad" => "\xc2\xa1",
		"\xae" => "\xc2\xab",
		"\xaf" => "\xc2\xbb",
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
		"\xe0" => "\xce\xb1",
		"\xe1" => "\xc3\x9f",
		"\xe2" => "\xce\x93",
		"\xe3" => "\xcf\x80",
		"\xe4" => "\xce\xa3",
		"\xe5" => "\xcf\x83",
		"\xe6" => "\xc2\xb5",
		"\xe7" => "\xcf\x84",
		"\xe8" => "\xce\xa6",
		"\xe9" => "\xce\x98",
		"\xea" => "\xce\xa9",
		"\xeb" => "\xce\xb4",
		"\xec" => "\xe2\x88\x9e",
		"\xed" => "\xcf\x86",
		"\xee" => "\xce\xb5",
		"\xef" => "\xe2\x88\xa9",
		"\xf0" => "\xe2\x89\xa1",
		"\xf1" => "\xc2\xb1",
		"\xf2" => "\xe2\x89\xa5",
		"\xf3" => "\xe2\x89\xa4",
		"\xf4" => "\xe2\x8c\xa0",
		"\xf5" => "\xe2\x8c\xa1",
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
		'IBM861',
		'861',
		'cp-is',
		'ibm-861',
		'cp861',
		'csIBM861',
		'ibm861',
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
		return 'WINDOWS-861';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}