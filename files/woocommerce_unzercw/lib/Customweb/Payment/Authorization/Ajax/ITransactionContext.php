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

require_once 'Customweb/Payment/Authorization/ITransactionContext.php';
require_once 'Customweb/Payment/Authorization/IFrontendTransactionContext.php';


interface Customweb_Payment_Authorization_Ajax_ITransactionContext extends 
Customweb_Payment_Authorization_ITransactionContext, 
Customweb_Payment_Authorization_IFrontendTransactionContext  {
	
	/**
	 * This method returns a function or function name, which must be invoked
	 * when the payment was successful.
	 * 
	 * Callback function:
	 * 
	 * function (redirectUrl) {
	 * 		// Do some action in success case
	 * 		window.location = redirectUrl
	 * }
	 * 
	 * 
	 * @return String Callback Function
	 */
	public function getJavaScriptSuccessCallbackFunction();
	
	/**
	 * This method returns a function or function name, which must be invoked
	 * when the payment was failed it expects one parameter with the error
	 * message. 
	 * 
	 * 	function (redirectUrl) {
	 * 		// Do some action in error case
	 * 		window.location = redirectUrl
	 * }
	 * 
	 * @return String Callback Function
	 */
	public function getJavaScriptFailedCallbackFunction();
	
}