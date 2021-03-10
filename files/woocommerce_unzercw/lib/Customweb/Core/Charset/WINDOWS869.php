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

class Customweb_Core_Charset_WINDOWS869 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x86" => "\xce\x86",
		"\x88" => "\xc2\xb7",
		"\x89" => "\xc2\xac",
		"\x8a" => "\xc2\xa6",
		"\x8b" => "\xe2\x80\x98",
		"\x8c" => "\xe2\x80\x99",
		"\x8d" => "\xce\x88",
		"\x8e" => "\xe2\x80\x95",
		"\x8f" => "\xce\x89",
		"\x90" => "\xce\x8a",
		"\x91" => "\xce\xaa",
		"\x92" => "\xce\x8c",
		"\x95" => "\xce\x8e",
		"\x96" => "\xce\xab",
		"\x97" => "\xc2\xa9",
		"\x98" => "\xce\x8f",
		"\x99" => "\xc2\xb2",
		"\x9a" => "\xc2\xb3",
		"\x9b" => "\xce\xac",
		"\x9c" => "\xc2\xa3",
		"\x9d" => "\xce\xad",
		"\x9e" => "\xce\xae",
		"\x9f" => "\xce\xaf",
		"\xa0" => "\xcf\x8a",
		"\xa1" => "\xce\x90",
		"\xa2" => "\xcf\x8c",
		"\xa3" => "\xcf\x8d",
		"\xa4" => "\xce\x91",
		"\xa5" => "\xce\x92",
		"\xa6" => "\xce\x93",
		"\xa7" => "\xce\x94",
		"\xa8" => "\xce\x95",
		"\xa9" => "\xce\x96",
		"\xaa" => "\xce\x97",
		"\xab" => "\xc2\xbd",
		"\xac" => "\xce\x98",
		"\xad" => "\xce\x99",
		"\xae" => "\xc2\xab",
		"\xaf" => "\xc2\xbb",
		"\xb0" => "\xe2\x96\x91",
		"\xb1" => "\xe2\x96\x92",
		"\xb2" => "\xe2\x96\x93",
		"\xb3" => "\xe2\x94\x82",
		"\xb4" => "\xe2\x94\xa4",
		"\xb5" => "\xce\x9a",
		"\xb6" => "\xce\x9b",
		"\xb7" => "\xce\x9c",
		"\xb8" => "\xce\x9d",
		"\xb9" => "\xe2\x95\xa3",
		"\xba" => "\xe2\x95\x91",
		"\xbb" => "\xe2\x95\x97",
		"\xbc" => "\xe2\x95\x9d",
		"\xbd" => "\xce\x9e",
		"\xbe" => "\xce\x9f",
		"\xbf" => "\xe2\x94\x90",
		"\xc0" => "\xe2\x94\x94",
		"\xc1" => "\xe2\x94\xb4",
		"\xc2" => "\xe2\x94\xac",
		"\xc3" => "\xe2\x94\x9c",
		"\xc4" => "\xe2\x94\x80",
		"\xc5" => "\xe2\x94\xbc",
		"\xc6" => "\xce\xa0",
		"\xc7" => "\xce\xa1",
		"\xc8" => "\xe2\x95\x9a",
		"\xc9" => "\xe2\x95\x94",
		"\xca" => "\xe2\x95\xa9",
		"\xcb" => "\xe2\x95\xa6",
		"\xcc" => "\xe2\x95\xa0",
		"\xcd" => "\xe2\x95\x90",
		"\xce" => "\xe2\x95\xac",
		"\xcf" => "\xce\xa3",
		"\xd0" => "\xce\xa4",
		"\xd1" => "\xce\xa5",
		"\xd2" => "\xce\xa6",
		"\xd3" => "\xce\xa7",
		"\xd4" => "\xce\xa8",
		"\xd5" => "\xce\xa9",
		"\xd6" => "\xce\xb1",
		"\xd7" => "\xce\xb2",
		"\xd8" => "\xce\xb3",
		"\xd9" => "\xe2\x94\x98",
		"\xda" => "\xe2\x94\x8c",
		"\xdb" => "\xe2\x96\x88",
		"\xdc" => "\xe2\x96\x84",
		"\xdd" => "\xce\xb4",
		"\xde" => "\xce\xb5",
		"\xdf" => "\xe2\x96\x80",
		"\xe0" => "\xce\xb6",
		"\xe1" => "\xce\xb7",
		"\xe2" => "\xce\xb8",
		"\xe3" => "\xce\xb9",
		"\xe4" => "\xce\xba",
		"\xe5" => "\xce\xbb",
		"\xe6" => "\xce\xbc",
		"\xe7" => "\xce\xbd",
		"\xe8" => "\xce\xbe",
		"\xe9" => "\xce\xbf",
		"\xea" => "\xcf\x80",
		"\xeb" => "\xcf\x81",
		"\xec" => "\xcf\x83",
		"\xed" => "\xcf\x82",
		"\xee" => "\xcf\x84",
		"\xef" => "\xce\x84",
		"\xf0" => "\xc2\xad",
		"\xf1" => "\xc2\xb1",
		"\xf2" => "\xcf\x85",
		"\xf3" => "\xcf\x86",
		"\xf4" => "\xcf\x87",
		"\xf5" => "\xc2\xa7",
		"\xf6" => "\xcf\x88",
		"\xf7" => "\xce\x85",
		"\xf8" => "\xc2\xb0",
		"\xf9" => "\xc2\xa8",
		"\xfa" => "\xcf\x89",
		"\xfb" => "\xcf\x8b",
		"\xfc" => "\xce\xb0",
		"\xfd" => "\xcf\x8e",
		"\xfe" => "\xe2\x96\xa0",
		"\xff" => "\xc2\xa0",
	);
	
	private static $aliases = array(
		'IBM869',
		'869',
		'ibm-869',
		'cp869',
		'csIBM869',
		'cp-gr',
		'ibm869',
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
		return 'WINDOWS-869';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}