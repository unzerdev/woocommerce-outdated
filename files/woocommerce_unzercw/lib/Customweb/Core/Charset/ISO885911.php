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

class Customweb_Core_Charset_ISO885911 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\xA0" => "\xc2\xa0",
		"\xA1" => "\xe0\xb8\x81",
		"\xA2" => "\xe0\xb8\x82",
		"\xA3" => "\xe0\xb8\x83",
		"\xA4" => "\xe0\xb8\x84",
		"\xA5" => "\xe0\xb8\x85",
		"\xA6" => "\xe0\xb8\x86",
		"\xA7" => "\xe0\xb8\x87",
		"\xA8" => "\xe0\xb8\x88",
		"\xA9" => "\xe0\xb8\x89",
		"\xAA" => "\xe0\xb8\x8a",
		"\xAB" => "\xe0\xb8\x8b",
		"\xAC" => "\xe0\xb8\x8c",
		"\xAD" => "\xe0\xb8\x8d",
		"\xAE" => "\xe0\xb8\x8e",
		"\xAF" => "\xe0\xb8\x8f",
		"\xB0" => "\xe0\xb8\x90",
		"\xB1" => "\xe0\xb8\x91",
		"\xB2" => "\xe0\xb8\x92",
		"\xB3" => "\xe0\xb8\x93",
		"\xB4" => "\xe0\xb8\x94",
		"\xB5" => "\xe0\xb8\x95",
		"\xB6" => "\xe0\xb8\x96",
		"\xB7" => "\xe0\xb8\x97",
		"\xB8" => "\xe0\xb8\x98",
		"\xB9" => "\xe0\xb8\x99",
		"\xBA" => "\xe0\xb8\x9a",
		"\xBB" => "\xe0\xb8\x9b",
		"\xBC" => "\xe0\xb8\x9c",
		"\xBD" => "\xe0\xb8\x9d",
		"\xBE" => "\xe0\xb8\x9e",
		"\xBF" => "\xe0\xb8\x9f",
		"\xC0" => "\xe0\xb8\xa0",
		"\xC1" => "\xe0\xb8\xa1",
		"\xC2" => "\xe0\xb8\xa2",
		"\xC3" => "\xe0\xb8\xa3",
		"\xC4" => "\xe0\xb8\xa4",
		"\xC5" => "\xe0\xb8\xa5",
		"\xC6" => "\xe0\xb8\xa6",
		"\xC7" => "\xe0\xb8\xa7",
		"\xC8" => "\xe0\xb8\xa8",
		"\xC9" => "\xe0\xb8\xa9",
		"\xCA" => "\xe0\xb8\xaa",
		"\xCB" => "\xe0\xb8\xab",
		"\xCC" => "\xe0\xb8\xac",
		"\xCD" => "\xe0\xb8\xad",
		"\xCE" => "\xe0\xb8\xae",
		"\xCF" => "\xe0\xb8\xaf",
		"\xD0" => "\xe0\xb8\xb0",
		"\xD1" => "\xe0\xb8\xb1",
		"\xD2" => "\xe0\xb8\xb2",
		"\xD3" => "\xe0\xb8\xb3",
		"\xD4" => "\xe0\xb8\xb4",
		"\xD5" => "\xe0\xb8\xb5",
		"\xD6" => "\xe0\xb8\xb6",
		"\xD7" => "\xe0\xb8\xb7",
		"\xD8" => "\xe0\xb8\xb8",
		"\xD9" => "\xe0\xb8\xb9",
		"\xDA" => "\xe0\xb8\xba",
		"\xDF" => "\xe0\xb8\xbf",
		"\xE0" => "\xe0\xb9\x80",
		"\xE1" => "\xe0\xb9\x81",
		"\xE2" => "\xe0\xb9\x82",
		"\xE3" => "\xe0\xb9\x83",
		"\xE4" => "\xe0\xb9\x84",
		"\xE5" => "\xe0\xb9\x85",
		"\xE6" => "\xe0\xb9\x86",
		"\xE7" => "\xe0\xb9\x87",
		"\xE8" => "\xe0\xb9\x88",
		"\xE9" => "\xe0\xb9\x89",
		"\xEA" => "\xe0\xb9\x8a",
		"\xEB" => "\xe0\xb9\x8b",
		"\xEC" => "\xe0\xb9\x8c",
		"\xED" => "\xe0\xb9\x8d",
		"\xEE" => "\xe0\xb9\x8e",
		"\xEF" => "\xe0\xb9\x8f",
		"\xF0" => "\xe0\xb9\x90",
		"\xF1" => "\xe0\xb9\x91",
		"\xF2" => "\xe0\xb9\x92",
		"\xF3" => "\xe0\xb9\x93",
		"\xF4" => "\xe0\xb9\x94",
		"\xF5" => "\xe0\xb9\x95",
		"\xF6" => "\xe0\xb9\x96",
		"\xF7" => "\xe0\xb9\x97",
		"\xF8" => "\xe0\xb9\x98",
		"\xF9" => "\xe0\xb9\x99",
		"\xFA" => "\xe0\xb9\x9a",
		"\xFB" => "\xe0\xb9\x9b",
	);
	
	
	private static $aliases = array(
		'iso8859_11',
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
		return 'ISO-8859-11';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
		
}