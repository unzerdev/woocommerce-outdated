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
 * This interface defines the error message. An error message may have different
 * messages for the backend and frontend user.
 *
 * @author Thomas Hunzik
 *
 */
interface Customweb_Payment_Authorization_IErrorMessage {

	/**
	 * This method returns the message which is intended for the application 
	 * administrator and not for the end user.
	 * 
	 * @return Customweb_I18n_LocalizableString
	 */
	public function getBackendMessage();

	/**
	 * This method returns the message for the end user. Which may not contain technical 
	 * details about the error.
	 * 
	 * @return Customweb_I18n_LocalizableString
	 */
	public function getUserMessage();

	/**
	 * This method must be implemented to make sure that the the error message can be used as
	 * a string. This method should return the default message. This is the most cases
	 * the user message.
	 * 
	 * @return string
	 */
	public function __toString();
}
