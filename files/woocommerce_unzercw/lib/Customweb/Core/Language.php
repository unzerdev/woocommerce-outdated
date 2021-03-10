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

require_once 'Customweb/Core/Util/Language.php';
require_once 'Customweb/Core/Assert.php';
require_once 'Customweb/Core/Language.php';


/**
 * Basic language object
 * 
 * @author Thomas Hunziker / Nico Eigenmann
 *
 */
class Customweb_Core_Language {
	
	private $ietfCode;
	private $language = null;
	
	/**
	 * Accepts any language input (IETF code, ISO Code or any other language name)
	 * 
	 * @param string $language
	 * @throws Exception
	 */
	public function __construct($language) {
		$language = (string)$language;
		Customweb_Core_Assert::hasLength($language, "The given language is empty.");
		$this->language = $language;
	}

	/**
	 * This method determines based on the provide HTTP header which language may be best match.
	 *
	 * @return Customweb_Core_Language
	 */
	public static function resolveCurrentLanguage() {
		$header = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		if (strlen($header) >= 5 && preg_match('/([a-z]{2})[-_]{1}([a-z]{2})/i', substr($header, 0, 5))) {
			return new Customweb_Core_Language(substr($header, 0, 5));
		}
		else if (strlen($_SERVER['HTTP_ACCEPT_LANGUAGE']) >= 2 && preg_match('/[a-z]{2}/i', substr($header, 0, 2))) {
			return new Customweb_Core_Language(substr($header, 0, 2));
		}
		
		// In case no approach above does work we fall back to en_US
		return new Customweb_Core_Language("en_US");
	}
	
	
	/**
	 * @return string
	 */
	public function getIetfCode() {
		return Customweb_Core_Util_Language::getIetfCode($this->language);
	}
	
	/**
	 * @return string
	 */
	public function getIso2LetterCode() {
		return Customweb_Core_Util_Language::getLanguageFromIETF(Customweb_Core_Util_Language::getIetfCode($this->language));
	}
	
	/**
	 * @return string
	 */
	public function __toString() {
		return $this->language;
	}
	
	/**
	 * This method returns the not normalized language code / name input.
	 * 
	 * @return string
	 */
	public function getOriginalLanguageInput() {
		return $this->language;
	}
	
}