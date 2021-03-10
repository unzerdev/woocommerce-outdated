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

require_once 'Customweb/Core/String.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/I18n/ILocalizableString.php';


/**
 * This class
 * 
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_I18n_LocalizableString implements Customweb_I18n_ILocalizableString {
	
	private $string = null;
	private $arguments = array();
	
	public function __construct($string, $args = array()) {
		if ($string instanceof Customweb_I18n_ILocalizableString) {
			$this->string = $string->getUntranslatedString();
			$this->arguments = $string->getArguments();
		}
		else {
			
			
			$this->string = $string;
			$this->arguments = $args;
		}
	}
	
	public function getUntranslatedString() {
		return $this->string;
	}
	
	public function getArguments() {
		return $this->arguments;
	}
	
	public function __toString() {
		return $this->toString();
	}
	
	public function toString() {
		return Customweb_I18n_Translation::getInstance()->translate($this->string, $this->arguments);
	}
	
	
}