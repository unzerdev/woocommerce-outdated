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
 * This interface defines the factory to create an 
 * authorization adapter.
 * 
 * @author hunziker
 *
 */
interface Customweb_Payment_Authorization_IAdapterFactory {
	
	/**
	 * Creates an authorization adpater depending on the given
	 * order context.
	 * 
	 * @param Customweb_Payment_Authorization_IOrderContext $orderContext
	 * @return Customweb_Payment_Authorization_IAdapter
	 */
	public function getAuthorizationAdapterByContext(Customweb_Payment_Authorization_IOrderContext $orderContext);
	
	/**
	 * Creates an authorization adpaterr depending on the given authorization method name.
	 * 
	 * @param string $authorizationMethodName
	 * @return Customweb_Payment_Authorization_IAdapter
	 */
	public function getAuthorizationAdapterByName($authorizationMethodName);
	
}