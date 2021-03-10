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

class Customweb_Core_Charset_WINDOWS866 extends Customweb_Core_Charset_TableBasedCharset{
	
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
		"\x8a" => "\xd0\x9a",
		"\x8b" => "\xd0\x9b",
		"\x8c" => "\xd0\x9c",
		"\x8d" => "\xd0\x9d",
		"\x8e" => "\xd0\x9e",
		"\x8f" => "\xd0\x9f",
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
		"\x9a" => "\xd0\xaa",
		"\x9b" => "\xd0\xab",
		"\x9c" => "\xd0\xac",
		"\x9d" => "\xd0\xad",
		"\x9e" => "\xd0\xae",
		"\x9f" => "\xd0\xaf",
		"\xa0" => "\xd0\xb0",
		"\xa1" => "\xd0\xb1",
		"\xa2" => "\xd0\xb2",
		"\xa3" => "\xd0\xb3",
		"\xa4" => "\xd0\xb4",
		"\xa5" => "\xd0\xb5",
		"\xa6" => "\xd0\xb6",
		"\xa7" => "\xd0\xb7",
		"\xa8" => "\xd0\xb8",
		"\xa9" => "\xd0\xb9",
		"\xaa" => "\xd0\xba",
		"\xab" => "\xd0\xbb",
		"\xac" => "\xd0\xbc",
		"\xad" => "\xd0\xbd",
		"\xae" => "\xd0\xbe",
		"\xaf" => "\xd0\xbf",
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
		"\xe0" => "\xd1\x80",
		"\xe1" => "\xd1\x81",
		"\xe2" => "\xd1\x82",
		"\xe3" => "\xd1\x83",
		"\xe4" => "\xd1\x84",
		"\xe5" => "\xd1\x85",
		"\xe6" => "\xd1\x86",
		"\xe7" => "\xd1\x87",
		"\xe8" => "\xd1\x88",
		"\xe9" => "\xd1\x89",
		"\xea" => "\xd1\x8a",
		"\xeb" => "\xd1\x8b",
		"\xec" => "\xd1\x8c",
		"\xed" => "\xd1\x8d",
		"\xee" => "\xd1\x8e",
		"\xef" => "\xd1\x8f",
		"\xf0" => "\xd0\x81",
		"\xf1" => "\xd1\x91",
		"\xf2" => "\xd0\x84",
		"\xf3" => "\xd1\x94",
		"\xf4" => "\xd0\x87",
		"\xf5" => "\xd1\x97",
		"\xf6" => "\xd0\x8e",
		"\xf7" => "\xd1\x9e",
		"\xf8" => "\xc2\xb0",
		"\xf9" => "\xe2\x88\x99",
		"\xfa" => "\xc2\xb7",
		"\xfb" => "\xe2\x88\x9a",
		"\xfc" => "\xe2\x84\x96",
		"\xfd" => "\xc2\xa4",
		"\xfe" => "\xe2\x96\xa0",
		"\xff" => "\xc2\xa0",
	);
	
	private static $aliases = array(
		'IBM866',
		'866',
		'ibm-866',
		'ibm866',
		'csIBM866',
		'cp866',
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
		return 'WINDOWS-866';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}