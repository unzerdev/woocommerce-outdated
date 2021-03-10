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

class Customweb_Core_Charset_WINDOWS775 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xc4\x86",
		"\x81" => "\xc3\xbc",
		"\x82" => "\xc3\xa9",
		"\x83" => "\xc4\x81",
		"\x84" => "\xc3\xa4",
		"\x85" => "\xc4\xa3",
		"\x86" => "\xc3\xa5",
		"\x87" => "\xc4\x87",
		"\x88" => "\xc5\x82",
		"\x89" => "\xc4\x93",
		"\x8a" => "\xc5\x96",
		"\x8b" => "\xc5\x97",
		"\x8c" => "\xc4\xab",
		"\x8d" => "\xc5\xb9",
		"\x8e" => "\xc3\x84",
		"\x8f" => "\xc3\x85",
		"\x90" => "\xc3\x89",
		"\x91" => "\xc3\xa6",
		"\x92" => "\xc3\x86",
		"\x93" => "\xc5\x8d",
		"\x94" => "\xc3\xb6",
		"\x95" => "\xc4\xa2",
		"\x96" => "\xc2\xa2",
		"\x97" => "\xc5\x9a",
		"\x98" => "\xc5\x9b",
		"\x99" => "\xc3\x96",
		"\x9a" => "\xc3\x9c",
		"\x9b" => "\xc3\xb8",
		"\x9c" => "\xc2\xa3",
		"\x9d" => "\xc3\x98",
		"\x9e" => "\xc3\x97",
		"\x9f" => "\xc2\xa4",
		"\xa0" => "\xc4\x80",
		"\xa1" => "\xc4\xaa",
		"\xa2" => "\xc3\xb3",
		"\xa3" => "\xc5\xbb",
		"\xa4" => "\xc5\xbc",
		"\xa5" => "\xc5\xba",
		"\xa6" => "\xe2\x80\x9d",
		"\xa7" => "\xc2\xa6",
		"\xa8" => "\xc2\xa9",
		"\xa9" => "\xc2\xae",
		"\xaa" => "\xc2\xac",
		"\xab" => "\xc2\xbd",
		"\xac" => "\xc2\xbc",
		"\xad" => "\xc5\x81",
		"\xae" => "\xc2\xab",
		"\xaf" => "\xc2\xbb",
		"\xb0" => "\xe2\x96\x91",
		"\xb1" => "\xe2\x96\x92",
		"\xb2" => "\xe2\x96\x93",
		"\xb3" => "\xe2\x94\x82",
		"\xb4" => "\xe2\x94\xa4",
		"\xb5" => "\xc4\x84",
		"\xb6" => "\xc4\x8c",
		"\xb7" => "\xc4\x98",
		"\xb8" => "\xc4\x96",
		"\xb9" => "\xe2\x95\xa3",
		"\xba" => "\xe2\x95\x91",
		"\xbb" => "\xe2\x95\x97",
		"\xbc" => "\xe2\x95\x9d",
		"\xbd" => "\xc4\xae",
		"\xbe" => "\xc5\xa0",
		"\xbf" => "\xe2\x94\x90",
		"\xc0" => "\xe2\x94\x94",
		"\xc1" => "\xe2\x94\xb4",
		"\xc2" => "\xe2\x94\xac",
		"\xc3" => "\xe2\x94\x9c",
		"\xc4" => "\xe2\x94\x80",
		"\xc5" => "\xe2\x94\xbc",
		"\xc6" => "\xc5\xb2",
		"\xc7" => "\xc5\xaa",
		"\xc8" => "\xe2\x95\x9a",
		"\xc9" => "\xe2\x95\x94",
		"\xca" => "\xe2\x95\xa9",
		"\xcb" => "\xe2\x95\xa6",
		"\xcc" => "\xe2\x95\xa0",
		"\xcd" => "\xe2\x95\x90",
		"\xce" => "\xe2\x95\xac",
		"\xcf" => "\xc5\xbd",
		"\xd0" => "\xc4\x85",
		"\xd1" => "\xc4\x8d",
		"\xd2" => "\xc4\x99",
		"\xd3" => "\xc4\x97",
		"\xd4" => "\xc4\xaf",
		"\xd5" => "\xc5\xa1",
		"\xd6" => "\xc5\xb3",
		"\xd7" => "\xc5\xab",
		"\xd8" => "\xc5\xbe",
		"\xd9" => "\xe2\x94\x98",
		"\xda" => "\xe2\x94\x8c",
		"\xdb" => "\xe2\x96\x88",
		"\xdc" => "\xe2\x96\x84",
		"\xdd" => "\xe2\x96\x8c",
		"\xde" => "\xe2\x96\x90",
		"\xdf" => "\xe2\x96\x80",
		"\xe0" => "\xc3\x93",
		"\xe1" => "\xc3\x9f",
		"\xe2" => "\xc5\x8c",
		"\xe3" => "\xc5\x83",
		"\xe4" => "\xc3\xb5",
		"\xe5" => "\xc3\x95",
		"\xe6" => "\xc2\xb5",
		"\xe7" => "\xc5\x84",
		"\xe8" => "\xc4\xb6",
		"\xe9" => "\xc4\xb7",
		"\xea" => "\xc4\xbb",
		"\xeb" => "\xc4\xbc",
		"\xec" => "\xc5\x86",
		"\xed" => "\xc4\x92",
		"\xee" => "\xc5\x85",
		"\xef" => "\xe2\x80\x99",
		"\xf0" => "\xc2\xad",
		"\xf1" => "\xc2\xb1",
		"\xf2" => "\xe2\x80\x9c",
		"\xf3" => "\xc2\xbe",
		"\xf4" => "\xc2\xb6",
		"\xf5" => "\xc2\xa7",
		"\xf6" => "\xc3\xb7",
		"\xf7" => "\xe2\x80\x9e",
		"\xf8" => "\xc2\xb0",
		"\xf9" => "\xe2\x88\x99",
		"\xfa" => "\xc2\xb7",
		"\xfb" => "\xc2\xb9",
		"\xfc" => "\xc2\xb3",
		"\xfd" => "\xc2\xb2",
		"\xfe" => "\xe2\x96\xa0",
		"\xff" => "\xc2\xa0",
	);
	
	private static $aliases = array(
		'IBM775',
		'ibm-775',
		'775',
		'cp775',
		'ibm775',
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
		return 'WINDOWS-775';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}