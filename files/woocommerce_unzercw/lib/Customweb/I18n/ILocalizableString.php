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



/**
 * This interface represents a string which can be localized.
 * 
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_I18n_ILocalizableString {
	
	/**
	 * Returns the untranslated string. Which can be used as the key for the translation.
	 * 
	 * @return string
	 */
	public function getUntranslatedString();
	
	/**
	 * 
	 * @return array
	 */
	public function getArguments();
	
	/**
	 * Returns the translated string.
	 * 
	 * @return Translated String
	 */
	public function __toString();
	
}