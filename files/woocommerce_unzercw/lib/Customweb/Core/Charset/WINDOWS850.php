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

class Customweb_Core_Charset_WINDOWS850 extends Customweb_Core_Charset_TableBasedCharset{
	
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
		"\x8b" => "\xc3\xaf",
		"\x8c" => "\xc3\xae",
		"\x8d" => "\xc3\xac",
		"\x8e" => "\xc3\x84",
		"\x8f" => "\xc3\x85",
		"\x90" => "\xc3\x89",
		"\x91" => "\xc3\xa6",
		"\x92" => "\xc3\x86",
		"\x93" => "\xc3\xb4",
		"\x94" => "\xc3\xb6",
		"\x95" => "\xc3\xb2",
		"\x96" => "\xc3\xbb",
		"\x97" => "\xc3\xb9",
		"\x98" => "\xc3\xbf",
		"\x99" => "\xc3\x96",
		"\x9a" => "\xc3\x9c",
		"\x9b" => "\xc3\xb8",
		"\x9c" => "\xc2\xa3",
		"\x9d" => "\xc3\x98",
		"\x9e" => "\xc3\x97",
		"\x9f" => "\xc6\x92",
		"\xa0" => "\xc3\xa1",
		"\xa1" => "\xc3\xad",
		"\xa2" => "\xc3\xb3",
		"\xa3" => "\xc3\xba",
		"\xa4" => "\xc3\xb1",
		"\xa5" => "\xc3\x91",
		"\xa6" => "\xc2\xaa",
		"\xa7" => "\xc2\xba",
		"\xa8" => "\xc2\xbf",
		"\xa9" => "\xc2\xae",
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
		"\xb5" => "\xc3\x81",
		"\xb6" => "\xc3\x82",
		"\xb7" => "\xc3\x80",
		"\xb8" => "\xc2\xa9",
		"\xb9" => "\xe2\x95\xa3",
		"\xba" => "\xe2\x95\x91",
		"\xbb" => "\xe2\x95\x97",
		"\xbc" => "\xe2\x95\x9d",
		"\xbd" => "\xc2\xa2",
		"\xbe" => "\xc2\xa5",
		"\xbf" => "\xe2\x94\x90",
		"\xc0" => "\xe2\x94\x94",
		"\xc1" => "\xe2\x94\xb4",
		"\xc2" => "\xe2\x94\xac",
		"\xc3" => "\xe2\x94\x9c",
		"\xc4" => "\xe2\x94\x80",
		"\xc5" => "\xe2\x94\xbc",
		"\xc6" => "\xc3\xa3",
		"\xc7" => "\xc3\x83",
		"\xc8" => "\xe2\x95\x9a",
		"\xc9" => "\xe2\x95\x94",
		"\xca" => "\xe2\x95\xa9",
		"\xcb" => "\xe2\x95\xa6",
		"\xcc" => "\xe2\x95\xa0",
		"\xcd" => "\xe2\x95\x90",
		"\xce" => "\xe2\x95\xac",
		"\xcf" => "\xc2\xa4",
		"\xd0" => "\xc3\xb0",
		"\xd1" => "\xc3\x90",
		"\xd2" => "\xc3\x8a",
		"\xd3" => "\xc3\x8b",
		"\xd4" => "\xc3\x88",
		"\xd5" => "\xc4\xb1",
		"\xd6" => "\xc3\x8d",
		"\xd7" => "\xc3\x8e",
		"\xd8" => "\xc3\x8f",
		"\xd9" => "\xe2\x94\x98",
		"\xda" => "\xe2\x94\x8c",
		"\xdb" => "\xe2\x96\x88",
		"\xdc" => "\xe2\x96\x84",
		"\xdd" => "\xc2\xa6",
		"\xde" => "\xc3\x8c",
		"\xdf" => "\xe2\x96\x80",
		"\xe0" => "\xc3\x93",
		"\xe1" => "\xc3\x9f",
		"\xe2" => "\xc3\x94",
		"\xe3" => "\xc3\x92",
		"\xe4" => "\xc3\xb5",
		"\xe5" => "\xc3\x95",
		"\xe6" => "\xc2\xb5",
		"\xe7" => "\xc3\xbe",
		"\xe8" => "\xc3\x9e",
		"\xe9" => "\xc3\x9a",
		"\xea" => "\xc3\x9b",
		"\xeb" => "\xc3\x99",
		"\xec" => "\xc3\xbd",
		"\xed" => "\xc3\x9d",
		"\xee" => "\xc2\xaf",
		"\xef" => "\xc2\xb4",
		"\xf0" => "\xc2\xad",
		"\xf1" => "\xc2\xb1",
		"\xf2" => "\xe2\x80\x97",
		"\xf3" => "\xc2\xbe",
		"\xf4" => "\xc2\xb6",
		"\xf5" => "\xc2\xa7",
		"\xf6" => "\xc3\xb7",
		"\xf7" => "\xc2\xb8",
		"\xf8" => "\xc2\xb0",
		"\xf9" => "\xc2\xa8",
		"\xfa" => "\xc2\xb7",
		"\xfb" => "\xc2\xb9",
		"\xfc" => "\xc2\xb3",
		"\xfd" => "\xc2\xb2",
		"\xfe" => "\xe2\x96\xa0",
		"\xff" => "\xc2\xa0",
	);
	
	private static $aliases = array(
		'IBM850',
		'ibm-850',
		'cp850',
		'850',
		'cspc850multilingual',
		'ibm850',
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
		return 'WINDOWS-850';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}