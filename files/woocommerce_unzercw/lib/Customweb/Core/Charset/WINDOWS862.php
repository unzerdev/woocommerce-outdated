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

class Customweb_Core_Charset_WINDOWS862 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xd7\x90",
		"\x81" => "\xd7\x91",
		"\x82" => "\xd7\x92",
		"\x83" => "\xd7\x93",
		"\x84" => "\xd7\x94",
		"\x85" => "\xd7\x95",
		"\x86" => "\xd7\x96",
		"\x87" => "\xd7\x97",
		"\x88" => "\xd7\x98",
		"\x89" => "\xd7\x99",
		"\x8a" => "\xd7\x9a",
		"\x8b" => "\xd7\x9b",
		"\x8c" => "\xd7\x9c",
		"\x8d" => "\xd7\x9d",
		"\x8e" => "\xd7\x9e",
		"\x8f" => "\xd7\x9f",
		"\x90" => "\xd7\xa0",
		"\x91" => "\xd7\xa1",
		"\x92" => "\xd7\xa2",
		"\x93" => "\xd7\xa3",
		"\x94" => "\xd7\xa4",
		"\x95" => "\xd7\xa5",
		"\x96" => "\xd7\xa6",
		"\x97" => "\xd7\xa7",
		"\x98" => "\xd7\xa8",
		"\x99" => "\xd7\xa9",
		"\x9a" => "\xd7\xaa",
		"\x9b" => "\xc2\xa2",
		"\x9c" => "\xc2\xa3",
		"\x9d" => "\xc2\xa5",
		"\x9e" => "\xe2\x82\xa7",
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
		'IBM862',
		'ibm-862',
		'ibm862',
		'csIBM862',
		'cp862',
		'cspc862latinhebrew',
		'862',
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
		return 'WINDOWS-862';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}