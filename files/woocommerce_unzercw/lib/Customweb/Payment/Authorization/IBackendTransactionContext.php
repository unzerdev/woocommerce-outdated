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


interface Customweb_Payment_Authorization_IBackendTransactionContext {
	
	/**
	 * The URL to the page of a successful transaction.
	 *
	 * @return String The URL of a successful transaction.
	 */
	public function getBackendSuccessUrl();
	
	/**
	 * The URL to the page of a failed transaction. A failed transaction can be
	 * a canceled by the customer, rejected by the aquire or payment service provider
	 * or any other reason.
	 *
	 * In case of an authroization the API must recover error states and redirect the
	 * user to this URL. The API should not thrown exceptions, instead it should
	 * write to the error log of the transactions
	 * (@see Customweb_Payment_Authorization_ITransaction::getErrorMessages()).
	 *
	 * @return String The URL of a failed transaction.
	 */
	public function getBackendFailedUrl();
		
}