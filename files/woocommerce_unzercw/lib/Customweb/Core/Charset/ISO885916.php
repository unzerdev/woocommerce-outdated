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

class Customweb_Core_Charset_ISO885916 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\xA0" => "\xc2\xa0",
		"\xA1" => "\xc4\x84",
		"\xA2" => "\xc4\x85",
		"\xA3" => "\xc5\x81",
		"\xA4" => "\xe2\x82\xac",
		"\xA5" => "\xe2\x80\x9e",
		"\xA6" => "\xc5\xa0",
		"\xA7" => "\xc2\xa7",
		"\xA8" => "\xc5\xa1",
		"\xA9" => "\xc2\xa9",
		"\xAA" => "\xc8\x98",
		"\xAB" => "\xc2\xab",
		"\xAC" => "\xc5\xb9",
		"\xAD" => "\xc2\xad",
		"\xAE" => "\xc5\xba",
		"\xAF" => "\xc5\xbb",
		"\xB0" => "\xc2\xb0",
		"\xB1" => "\xc2\xb1",
		"\xB2" => "\xc4\x8c",
		"\xB3" => "\xc5\x82",
		"\xB4" => "\xc5\xbd",
		"\xB5" => "\xe2\x80\x9d",
		"\xB6" => "\xc2\xb6",
		"\xB7" => "\xc2\xb7",
		"\xB8" => "\xc5\xbe",
		"\xB9" => "\xc4\x8d",
		"\xBA" => "\xc8\x99",
		"\xBB" => "\xc2\xbb",
		"\xBC" => "\xc5\x92",
		"\xBD" => "\xc5\x93",
		"\xBE" => "\xc5\xb8",
		"\xBF" => "\xc5\xbc",
		"\xC0" => "\xc3\x80",
		"\xC1" => "\xc3\x81",
		"\xC2" => "\xc3\x82",
		"\xC3" => "\xc4\x82",
		"\xC4" => "\xc3\x84",
		"\xC5" => "\xc4\x86",
		"\xC6" => "\xc3\x86",
		"\xC7" => "\xc3\x87",
		"\xC8" => "\xc3\x88",
		"\xC9" => "\xc3\x89",
		"\xCA" => "\xc3\x8a",
		"\xCB" => "\xc3\x8b",
		"\xCC" => "\xc3\x8c",
		"\xCD" => "\xc3\x8d",
		"\xCE" => "\xc3\x8e",
		"\xCF" => "\xc3\x8f",
		"\xD0" => "\xc4\x90",
		"\xD1" => "\xc5\x83",
		"\xD2" => "\xc3\x92",
		"\xD3" => "\xc3\x93",
		"\xD4" => "\xc3\x94",
		"\xD5" => "\xc5\x90",
		"\xD6" => "\xc3\x96",
		"\xD7" => "\xc5\x9a",
		"\xD8" => "\xc5\xb0",
		"\xD9" => "\xc3\x99",
		"\xDA" => "\xc3\x9a",
		"\xDB" => "\xc3\x9b",
		"\xDC" => "\xc3\x9c",
		"\xDD" => "\xc4\x98",
		"\xDE" => "\xc8\x9a",
		"\xDF" => "\xc3\x9f",
		"\xE0" => "\xc3\xa0",
		"\xE1" => "\xc3\xa1",
		"\xE2" => "\xc3\xa2",
		"\xE3" => "\xc4\x83",
		"\xE4" => "\xc3\xa4",
		"\xE5" => "\xc4\x87",
		"\xE6" => "\xc3\xa6",
		"\xE7" => "\xc3\xa7",
		"\xE8" => "\xc3\xa8",
		"\xE9" => "\xc3\xa9",
		"\xEA" => "\xc3\xaa",
		"\xEB" => "\xc3\xab",
		"\xEC" => "\xc3\xac",
		"\xED" => "\xc3\xad",
		"\xEE" => "\xc3\xae",
		"\xEF" => "\xc3\xaf",
		"\xF0" => "\xc4\x91",
		"\xF1" => "\xc5\x84",
		"\xF2" => "\xc3\xb2",
		"\xF3" => "\xc3\xb3",
		"\xF4" => "\xc3\xb4",
		"\xF5" => "\xc5\x91",
		"\xF6" => "\xc3\xb6",
		"\xF7" => "\xc5\x9b",
		"\xF8" => "\xc5\xb1",
		"\xF9" => "\xc3\xb9",
		"\xFA" => "\xc3\xba",
		"\xFB" => "\xc3\xbb",
		"\xFC" => "\xc3\xbc",
		"\xFD" => "\xc4\x99",
		"\xFE" => "\xc8\x9b",
		"\xFF" => "\xc3\xbf",
	);
	
	private static $aliases = array(
		
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
		return 'ISO-8859-16';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
	
}