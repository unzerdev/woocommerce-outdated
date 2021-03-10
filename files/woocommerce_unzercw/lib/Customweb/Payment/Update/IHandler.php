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



// TODO: Rewrite this interface according to Customweb_Payment_ITransactionHandler
interface Customweb_Payment_Update_IHandler {

	const LOG_TYPE_INFO = 'info';
	
	const LOG_TYPE_ERROR = 'error';
	
	/**
	 * @return Customweb_DependencyInjection_IContainer
	 */
	public function getContainer();
	
	/**
	 * @param string $message
	 * @param string $type
	 * @return void
	 */
	public function log($message, $type);
	
	/**
	 * @return array
	 */
	public function getScheduledTransactionIds();

}
