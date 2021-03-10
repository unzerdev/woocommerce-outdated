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

class Customweb_Core_Charset_ISO88596 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\xA0" => "\xc2\xa0",
		"\xA4" => "\xc2\xa4",
		"\xAC" => "\xd8\x8c",
		"\xAD" => "\xc2\xad",
		"\xBB" => "\xd8\x9b",
		"\xBF" => "\xd8\x9f",
		"\xC1" => "\xd8\xa1",
		"\xC2" => "\xd8\xa2",
		"\xC3" => "\xd8\xa3",
		"\xC4" => "\xd8\xa4",
		"\xC5" => "\xd8\xa5",
		"\xC6" => "\xd8\xa6",
		"\xC7" => "\xd8\xa7",
		"\xC8" => "\xd8\xa8",
		"\xC9" => "\xd8\xa9",
		"\xCA" => "\xd8\xaa",
		"\xCB" => "\xd8\xab",
		"\xCC" => "\xd8\xac",
		"\xCD" => "\xd8\xad",
		"\xCE" => "\xd8\xae",
		"\xCF" => "\xd8\xaf",
		"\xD0" => "\xd8\xb0",
		"\xD1" => "\xd8\xb1",
		"\xD2" => "\xd8\xb2",
		"\xD3" => "\xd8\xb3",
		"\xD4" => "\xd8\xb4",
		"\xD5" => "\xd8\xb5",
		"\xD6" => "\xd8\xb6",
		"\xD7" => "\xd8\xb7",
		"\xD8" => "\xd8\xb8",
		"\xD9" => "\xd8\xb9",
		"\xDA" => "\xd8\xba",
		"\xE0" => "\xd9\x80",
		"\xE1" => "\xd9\x81",
		"\xE2" => "\xd9\x82",
		"\xE3" => "\xd9\x83",
		"\xE4" => "\xd9\x84",
		"\xE5" => "\xd9\x85",
		"\xE6" => "\xd9\x86",
		"\xE7" => "\xd9\x87",
		"\xE8" => "\xd9\x88",
		"\xE9" => "\xd9\x89",
		"\xEA" => "\xd9\x8a",
		"\xEB" => "\xd9\x8b",
		"\xEC" => "\xd9\x8c",
		"\xED" => "\xd9\x8d",
		"\xEE" => "\xd9\x8e",
		"\xEF" => "\xd9\x8f",
		"\xF0" => "\xd9\x90",
		"\xF1" => "\xd9\x91",
		"\xF2" => "\xd9\x92",
	);
	
	private static $aliases = array(
		'arabic',
		'ibm1089',
		'iso8859_6',
		'iso-ir-127',
		'8859_6',
		'cp1089',
		'ECMA-114',
		'ISO_8859-6',
		'csISOLatinArabic',
		'1089',
		'ibm-1089',
		'ISO8859-6',
		'ASMO-708',
		'ISO_8859-6:1987',
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
		return 'ISO-8859-6';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}