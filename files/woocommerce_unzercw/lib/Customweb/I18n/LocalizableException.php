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

require_once 'Customweb/I18n/LocalizableString.php';

/**
 * This is a simple exception which accepts a localizable string. 
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_I18n_LocalizableException extends Exception {
	
	/**
	 * @var Customweb_I18n_ILocalizableString
	 */
	private $localizableMessage;
	
	public function __construct(Customweb_I18n_ILocalizableString $message) {
		parent::__construct($message->__toString());
		$this->localizableMessage = $message;
	}
	
	/**
	 * @return Customweb_I18n_ILocalizableString
	 */
	public function getLocalizableString() {
		return $this->localizableMessage;
	}
	
}