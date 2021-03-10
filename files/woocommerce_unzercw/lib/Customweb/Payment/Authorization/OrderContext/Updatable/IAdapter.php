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
 * This interface allows the adapter to provide updates on the order context. 
 * 
 * These means the implementing adapter may change the order context and reflect
 * the changes back to the e-commerce system. This allows the PSP to use for example
 * a address database to correct the address of the customer.
 * 
 * @author Nico Eigenmann / Thomas Hunziker
 *
 */
interface Customweb_Payment_Authorization_OrderContext_Updatable_IAdapter {
	
	/**
	 * This method returns a list of fields that should be updated in the 
	 * shopping cart system.
	 * 
	 * @param Customweb_Payment_Authorization_IOrderContext $orderContext
	 * @param array $formFields
	 * @return Customweb_Payment_Authorization_OrderContext_Updatable_IField[]
	 */
	public function getUpdatedOrderContextFields(Customweb_Payment_Authorization_IOrderContext $orderContext, array $formFields);
	
}