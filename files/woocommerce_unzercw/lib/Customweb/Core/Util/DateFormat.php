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

require_once 'Customweb/Core/Language.php';
require_once 'Customweb/Core/Util/DateFormat.php';


/**
 * Utility class which helps to localize the date format. 
 * 
 * @author Thomas Hunziker
 *
 */
final class Customweb_Core_Util_DateFormat {
	
	private static $formats = array(
		'de_DE' => array('day', 'month', 'year'),
		'de_CH' => array('day', 'month', 'year'),
		'de_AT' => array('day', 'month', 'year'),
		'it_IT' => array('day', 'month', 'year'),
		'it_CH' => array('day', 'month', 'year'),
		'nl_NL' => array('day', 'month', 'year'),
		'es_ES' => array('day', 'month', 'year'),
		'fr_FR' => array('day', 'month', 'year'),
		'en_GB' => array('day', 'month', 'year'),
		'en_US' => array('year', 'month', 'day'),
	);
	
	private $format;
	
	private function __construct(array $format) {
		$this->format = $format;
	}
	
	public static function byLanguage(Customweb_Core_Language $language) {
		
		if (isset(self::$formats[$language->getIetfCode()])) {
			return new Customweb_Core_Util_DateFormat(self::$formats[$language->getIetfCode()]);
		}
		
		// Fall back to the default region.
		$language = new Customweb_Core_Language($language->getIso2LetterCode());
		if (isset(self::$formats[$language->getIetfCode()])) {
			return new Customweb_Core_Util_DateFormat(self::$formats[$language->getIetfCode()]);
		}
		
		// If we do not have a specific format we use en_US
		return new Customweb_Core_Util_DateFormat(self::$formats['en_US']);
	}
	
	
	public function getFormat() {
		return $this->format;
	}
	
	
}