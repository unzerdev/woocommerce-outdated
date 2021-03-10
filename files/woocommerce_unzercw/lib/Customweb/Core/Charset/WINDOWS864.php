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

class Customweb_Core_Charset_WINDOWS864 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xc2\xb0",
		"\x81" => "\xc2\xb7",
		"\x82" => "\xe2\x88\x99",
		"\x83" => "\xe2\x88\x9a",
		"\x84" => "\xe2\x96\x92",
		"\x85" => "\xe2\x94\x80",
		"\x86" => "\xe2\x94\x82",
		"\x87" => "\xe2\x94\xbc",
		"\x88" => "\xe2\x94\xa4",
		"\x89" => "\xe2\x94\xac",
		"\x8a" => "\xe2\x94\x9c",
		"\x8b" => "\xe2\x94\xb4",
		"\x8c" => "\xe2\x94\x90",
		"\x8d" => "\xe2\x94\x8c",
		"\x8e" => "\xe2\x94\x94",
		"\x8f" => "\xe2\x94\x98",
		"\x90" => "\xce\xb2",
		"\x91" => "\xe2\x88\x9e",
		"\x92" => "\xcf\x86",
		"\x93" => "\xc2\xb1",
		"\x94" => "\xc2\xbd",
		"\x95" => "\xc2\xbc",
		"\x96" => "\xe2\x89\x88",
		"\x97" => "\xc2\xab",
		"\x98" => "\xc2\xbb",
		"\x99" => "\xef\xbb\xb7",
		"\x9a" => "\xef\xbb\xb8",
		"\x9d" => "\xef\xbb\xbb",
		"\x9e" => "\xef\xbb\xbc",
		"\xa0" => "\xc2\xa0",
		"\xa1" => "\xc2\xad",
		"\xa2" => "\xef\xba\x82",
		"\xa3" => "\xc2\xa3",
		"\xa4" => "\xc2\xa4",
		"\xa5" => "\xef\xba\x84",
		"\xa8" => "\xef\xba\x8e",
		"\xa9" => "\xef\xba\x8f",
		"\xaa" => "\xef\xba\x95",
		"\xab" => "\xef\xba\x99",
		"\xac" => "\xd8\x8c",
		"\xad" => "\xef\xba\x9d",
		"\xae" => "\xef\xba\xa1",
		"\xaf" => "\xef\xba\xa5",
		"\xb0" => "\xd9\xa0",
		"\xb1" => "\xd9\xa1",
		"\xb2" => "\xd9\xa2",
		"\xb3" => "\xd9\xa3",
		"\xb4" => "\xd9\xa4",
		"\xb5" => "\xd9\xa5",
		"\xb6" => "\xd9\xa6",
		"\xb7" => "\xd9\xa7",
		"\xb8" => "\xd9\xa8",
		"\xb9" => "\xd9\xa9",
		"\xba" => "\xef\xbb\x91",
		"\xbb" => "\xd8\x9b",
		"\xbc" => "\xef\xba\xb1",
		"\xbd" => "\xef\xba\xb5",
		"\xbe" => "\xef\xba\xb9",
		"\xbf" => "\xd8\x9f",
		"\xc0" => "\xc2\xa2",
		"\xc1" => "\xef\xba\x80",
		"\xc2" => "\xef\xba\x81",
		"\xc3" => "\xef\xba\x83",
		"\xc4" => "\xef\xba\x85",
		"\xc5" => "\xef\xbb\x8a",
		"\xc6" => "\xef\xba\x8b",
		"\xc7" => "\xef\xba\x8d",
		"\xc8" => "\xef\xba\x91",
		"\xc9" => "\xef\xba\x93",
		"\xca" => "\xef\xba\x97",
		"\xcb" => "\xef\xba\x9b",
		"\xcc" => "\xef\xba\x9f",
		"\xcd" => "\xef\xba\xa3",
		"\xce" => "\xef\xba\xa7",
		"\xcf" => "\xef\xba\xa9",
		"\xd0" => "\xef\xba\xab",
		"\xd1" => "\xef\xba\xad",
		"\xd2" => "\xef\xba\xaf",
		"\xd3" => "\xef\xba\xb3",
		"\xd4" => "\xef\xba\xb7",
		"\xd5" => "\xef\xba\xbb",
		"\xd6" => "\xef\xba\xbf",
		"\xd7" => "\xef\xbb\x81",
		"\xd8" => "\xef\xbb\x85",
		"\xd9" => "\xef\xbb\x8b",
		"\xda" => "\xef\xbb\x8f",
		"\xdb" => "\xc2\xa6",
		"\xdc" => "\xc2\xac",
		"\xdd" => "\xc3\xb7",
		"\xde" => "\xc3\x97",
		"\xdf" => "\xef\xbb\x89",
		"\xe0" => "\xd9\x80",
		"\xe1" => "\xef\xbb\x93",
		"\xe2" => "\xef\xbb\x97",
		"\xe3" => "\xef\xbb\x9b",
		"\xe4" => "\xef\xbb\x9f",
		"\xe5" => "\xef\xbb\xa3",
		"\xe6" => "\xef\xbb\xa7",
		"\xe7" => "\xef\xbb\xab",
		"\xe8" => "\xef\xbb\xad",
		"\xe9" => "\xef\xbb\xaf",
		"\xea" => "\xef\xbb\xb3",
		"\xeb" => "\xef\xba\xbd",
		"\xec" => "\xef\xbb\x8c",
		"\xed" => "\xef\xbb\x8e",
		"\xee" => "\xef\xbb\x8d",
		"\xef" => "\xef\xbb\xa1",
		"\xf0" => "\xef\xb9\xbd",
		"\xf1" => "\xd9\x91",
		"\xf2" => "\xef\xbb\xa5",
		"\xf3" => "\xef\xbb\xa9",
		"\xf4" => "\xef\xbb\xac",
		"\xf5" => "\xef\xbb\xb0",
		"\xf6" => "\xef\xbb\xb2",
		"\xf7" => "\xef\xbb\x90",
		"\xf8" => "\xef\xbb\x95",
		"\xf9" => "\xef\xbb\xb5",
		"\xfa" => "\xef\xbb\xb6",
		"\xfb" => "\xef\xbb\x9d",
		"\xfc" => "\xef\xbb\x99",
		"\xfd" => "\xef\xbb\xb1",
		"\xfe" => "\xe2\x96\xa0",
	);
	
	private static $aliases = array(
		'IBM864',
		'csIBM864',
		'ibm864',
		'864',
		'cp864',
		'ibm-864',
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
		return 'WINDOWS-864';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
}