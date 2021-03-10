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
 * The translation resolver is used to map the given translation 
 * to a storage facility. How to set the translation resolver 
 * take a look at Customweb_I18n_Translation.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_I18n_ITranslationResolver {
	
	/**
	 * This method returns the translation given by the message ($string) 
	 * and the arguments ($args) for this message.
	 * 
	 * @param string $string The string to translate.
	 * @return string The translated string.
	 */
	public function getTranslation($string);
	
}