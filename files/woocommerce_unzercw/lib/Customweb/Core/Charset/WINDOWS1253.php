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

class Customweb_Core_Charset_WINDOWS1253 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\x80" => "\xe2\x82\xac",
		"\x82" => "\xe2\x80\x9a",
		"\x83" => "\xc6\x92",
		"\x84" => "\xe2\x80\x9e",
		"\x85" => "\xe2\x80\xa6",
		"\x86" => "\xe2\x80\xa0",
		"\x87" => "\xe2\x80\xa1",
		"\x89" => "\xe2\x80\xb0",
		"\x8B" => "\xe2\x80\xb9",
		"\x91" => "\xe2\x80\x98",
		"\x92" => "\xe2\x80\x99",
		"\x93" => "\xe2\x80\x9c",
		"\x94" => "\xe2\x80\x9d",
		"\x95" => "\xe2\x80\xa2",
		"\x96" => "\xe2\x80\x93",
		"\x97" => "\xe2\x80\x94",
		"\x99" => "\xe2\x84\xa2",
		"\x9B" => "\xe2\x80\xba",
		"\xA0" => "\xc2\xa0",
		"\xA1" => "\xce\x85",
		"\xA2" => "\xce\x86",
		"\xA3" => "\xc2\xa3",
		"\xA4" => "\xc2\xa4",
		"\xA5" => "\xc2\xa5",
		"\xA6" => "\xc2\xa6",
		"\xA7" => "\xc2\xa7",
		"\xA8" => "\xc2\xa8",
		"\xA9" => "\xc2\xa9",
		"\xAB" => "\xc2\xab",
		"\xAC" => "\xc2\xac",
		"\xAD" => "\xc2\xad",
		"\xAE" => "\xc2\xae",
		"\xAF" => "\xe2\x80\x95",
		"\xB0" => "\xc2\xb0",
		"\xB1" => "\xc2\xb1",
		"\xB2" => "\xc2\xb2",
		"\xB3" => "\xc2\xb3",
		"\xB4" => "\xce\x84",
		"\xB5" => "\xc2\xb5",
		"\xB6" => "\xc2\xb6",
		"\xB7" => "\xc2\xb7",
		"\xB8" => "\xce\x88",
		"\xB9" => "\xce\x89",
		"\xBA" => "\xce\x8a",
		"\xBB" => "\xc2\xbb",
		"\xBC" => "\xce\x8c",
		"\xBD" => "\xc2\xbd",
		"\xBE" => "\xce\x8e",
		"\xBF" => "\xce\x8f",
		"\xC0" => "\xce\x90",
		"\xC1" => "\xce\x91",
		"\xC2" => "\xce\x92",
		"\xC3" => "\xce\x93",
		"\xC4" => "\xce\x94",
		"\xC5" => "\xce\x95",
		"\xC6" => "\xce\x96",
		"\xC7" => "\xce\x97",
		"\xC8" => "\xce\x98",
		"\xC9" => "\xce\x99",
		"\xCA" => "\xce\x9a",
		"\xCB" => "\xce\x9b",
		"\xCC" => "\xce\x9c",
		"\xCD" => "\xce\x9d",
		"\xCE" => "\xce\x9e",
		"\xCF" => "\xce\x9f",
		"\xD0" => "\xce\xa0",
		"\xD1" => "\xce\xa1",
		"\xD3" => "\xce\xa3",
		"\xD4" => "\xce\xa4",
		"\xD5" => "\xce\xa5",
		"\xD6" => "\xce\xa6",
		"\xD7" => "\xce\xa7",
		"\xD8" => "\xce\xa8",
		"\xD9" => "\xce\xa9",
		"\xDA" => "\xce\xaa",
		"\xDB" => "\xce\xab",
		"\xDC" => "\xce\xac",
		"\xDD" => "\xce\xad",
		"\xDE" => "\xce\xae",
		"\xDF" => "\xce\xaf",
		"\xE0" => "\xce\xb0",
		"\xE1" => "\xce\xb1",
		"\xE2" => "\xce\xb2",
		"\xE3" => "\xce\xb3",
		"\xE4" => "\xce\xb4",
		"\xE5" => "\xce\xb5",
		"\xE6" => "\xce\xb6",
		"\xE7" => "\xce\xb7",
		"\xE8" => "\xce\xb8",
		"\xE9" => "\xce\xb9",
		"\xEA" => "\xce\xba",
		"\xEB" => "\xce\xbb",
		"\xEC" => "\xce\xbc",
		"\xED" => "\xce\xbd",
		"\xEE" => "\xce\xbe",
		"\xEF" => "\xce\xbf",
		"\xF0" => "\xcf\x80",
		"\xF1" => "\xcf\x81",
		"\xF2" => "\xcf\x82",
		"\xF3" => "\xcf\x83",
		"\xF4" => "\xcf\x84",
		"\xF5" => "\xcf\x85",
		"\xF6" => "\xcf\x86",
		"\xF7" => "\xcf\x87",
		"\xF8" => "\xcf\x88",
		"\xF9" => "\xcf\x89",
		"\xFA" => "\xcf\x8a",
		"\xFB" => "\xcf\x8b",
		"\xFC" => "\xcf\x8c",
		"\xFD" => "\xcf\x8d",
		"\xFE" => "\xcf\x8e",
	);
	
	private static $aliases = array(
		'cp5349',
		'cp1253',
		
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
		return 'WINDOWS-1253';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}