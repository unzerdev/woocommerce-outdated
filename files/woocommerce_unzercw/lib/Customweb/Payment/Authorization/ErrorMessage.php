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

require_once 'Customweb/Payment/Authorization/IErrorMessage.php';

/**
 * This is a default implemenation of the IErrorMessage interface.
 * 
 * @author Thomas Hunziker
 *
 */
// TODO: Refactor this to fit the new way to handle the translations.
class Customweb_Payment_Authorization_ErrorMessage implements Customweb_Payment_Authorization_IErrorMessage {
	
	private $userMessage = null;
	private $backendMessage = null;
	
	/**
	 * @param Customweb_I18n_LocalizableString $userMessage
	 * @param Customweb_I18n_LocalizableString $backendMessage
	 */
	public function __construct($userMessage, $backendMessage = null) {
		if (is_string($userMessage)) {
			$this->userMessage = new Customweb_I18n_LocalizableString($userMessage);
		}
		else if ($userMessage instanceof Customweb_I18n_ILocalizableString) {
			$this->userMessage = $userMessage;
		}
		else {
			throw new InvalidArgumentException("The given user message argument is invalid.");
		}
		
		if (is_string($backendMessage)) {
			$this->backendMessage = new Customweb_I18n_LocalizableString($backendMessage);
		}
		else if ($backendMessage instanceof Customweb_I18n_ILocalizableString) {
			$this->backendMessage = $backendMessage;
		}
		else {
			$this->backendMessage = $this->userMessage;
		}
	}
	
	public function getBackendMessage() {
		return $this->backendMessage;
	}
	
	public function getUserMessage() {
		return $this->userMessage;
	}
	
	public function __toString() {
		return $this->getUserMessage()->toString();
	}
	
	public function toString() {
		return $this->__toString();
	}
}
