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
 * The payment customer context describs the customer object during the 
 * payment.
 * 
 * This interface is used to store data about the customer during the checkout
 * by the payment API.
 * 
 * Example user cases:
 * - Collected data during the checkout (e.g. birthdate)
 * - Validation results (e.g. solvency scoring)
 * 
 * The data is stored on the customer object by the shop system. This object
 * is detachable from the database transaction. Therefore all write operations
 * on the objects are recorded and applied later, when the object is writen
 * to the database.
 * 
 * The data object is stored per customer. It is not stored per payment method.
 * Hence also data between payment methods can be shared. But it is alos important
 * to make sure that there are no name clashes.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_Authorization_IPaymentCustomerContext {
	
	/**
	 * This method returns a key / value map of the values stored for
	 * the current customer. Modifications on this map will be lost. They
	 * are not persisted to the database.
	 * 
	 * @return array Key / Value Map.
	 */
	public function getMap();
	
	/**
	 * This function updates the entire map with the map provided by 
	 * $update. The $update map is merged with the existing map in the 
	 * database. Therefore the function array_replace_recursive is used.
	 * 
	 * If multiple updates provided, they are get applied in the same order
	 * on the customer object.
	 * 
	 * @param array $update The updates to apply on the entire map.
	 * @return Customweb_Payment_Authorization_IPaymentCustomerContext
	 */
	public function updateMap(array $update);
	
}