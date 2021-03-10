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

class Customweb_Core_Charset_ISO88598 extends Customweb_Core_Charset_TableBasedCharset{
	
	private static $conversionTable = array(
		"\xA0" => "\xc2\xa0",
		"\xA2" => "\xc2\xa2",
		"\xA3" => "\xc2\xa3",
		"\xA4" => "\xc2\xa4",
		"\xA5" => "\xc2\xa5",
		"\xA6" => "\xc2\xa6",
		"\xA7" => "\xc2\xa7",
		"\xA8" => "\xc2\xa8",
		"\xA9" => "\xc2\xa9",
		"\xAA" => "\xc3\x97",
		"\xAB" => "\xc2\xab",
		"\xAC" => "\xc2\xac",
		"\xAD" => "\xc2\xad",
		"\xAE" => "\xc2\xae",
		"\xAF" => "\xc2\xaf",
		"\xB0" => "\xc2\xb0",
		"\xB1" => "\xc2\xb1",
		"\xB2" => "\xc2\xb2",
		"\xB3" => "\xc2\xb3",
		"\xB4" => "\xc2\xb4",
		"\xB5" => "\xc2\xb5",
		"\xB6" => "\xc2\xb6",
		"\xB7" => "\xc2\xb7",
		"\xB8" => "\xc2\xb8",
		"\xB9" => "\xc2\xb9",
		"\xBA" => "\xc3\xb7",
		"\xBB" => "\xc2\xbb",
		"\xBC" => "\xc2\xbc",
		"\xBD" => "\xc2\xbd",
		"\xBE" => "\xc2\xbe",
		"\xDF" => "\xe2\x80\x97",
		"\xE0" => "\xd7\x90",
		"\xE1" => "\xd7\x91",
		"\xE2" => "\xd7\x92",
		"\xE3" => "\xd7\x93",
		"\xE4" => "\xd7\x94",
		"\xE5" => "\xd7\x95",
		"\xE6" => "\xd7\x96",
		"\xE7" => "\xd7\x97",
		"\xE8" => "\xd7\x98",
		"\xE9" => "\xd7\x99",
		"\xEA" => "\xd7\x9a",
		"\xEB" => "\xd7\x9b",
		"\xEC" => "\xd7\x9c",
		"\xED" => "\xd7\x9d",
		"\xEE" => "\xd7\x9e",
		"\xEF" => "\xd7\x9f",
		"\xF0" => "\xd7\xa0",
		"\xF1" => "\xd7\xa1",
		"\xF2" => "\xd7\xa2",
		"\xF3" => "\xd7\xa3",
		"\xF4" => "\xd7\xa4",
		"\xF5" => "\xd7\xa5",
		"\xF6" => "\xd7\xa6",
		"\xF7" => "\xd7\xa7",
		"\xF8" => "\xd7\xa8",
		"\xF9" => "\xd7\xa9",
		"\xFA" => "\xd7\xaa",
		"\xFD" => "\xe2\x80\x8e",
		"\xFE" => "\xe2\x80\x8f",
	);
	
	private static $aliases = array(
		'ibm916',
		'cp916',
		'csISOLatinHebrew',
		'ISO_8859-8',
		'ISO8859-8',
		'ibm-916',
		'iso8859_8',
		'hebrew',
		'916',
		'iso-ir-138',
		'ISO_8859-8:1988',
		'8859_8',
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
		return 'ISO-8859-8';
	}
	
	public function getAliases() {
		return self::$aliases;
	}
	
}