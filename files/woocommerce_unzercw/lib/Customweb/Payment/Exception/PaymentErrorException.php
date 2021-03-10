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
 * Exception implementation which is able to handle Customweb_Payment_Authorization_IErrorMessage messages.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_Exception_PaymentErrorException extends Exception{
	
	/**
	 * @var Customweb_Payment_Authorization_IErrorMessage
	 */
	private $internalMessage = null;
	
	public function __construct(Customweb_Payment_Authorization_IErrorMessage $message) {
		// We use the backend message, because it contains typically more information and in 
		// case we do not thread the exception specially, we like to have more information logged.
		parent::__construct($message->getBackendMessage());
		$this->internalMessage = $message;
	}
	
	/**
	 * @return Customweb_Payment_Authorization_IErrorMessage
	 */
	final public function getErrorMessage() {
		return $this->internalMessage;
	}
	
}