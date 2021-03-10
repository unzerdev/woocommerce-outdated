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
 * This interface defines the methods required for implementing a
 * payment method as required by the transaction and the invocation
 * data.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_Authorization_IPaymentMethod {
	
	/**
	 * The machine readable name of the payment method.
	 * 
	 * @return string The machine readable name of the payment method.
	 */
	public function getPaymentMethodName();
	
	/**
	 * The human readable name of the payment method.
	 * 
	 * @return string Human readable payment method name.
	 */
	public function getPaymentMethodDisplayName();
	
	/**
	 * This method returns the configuration value for the given $key of this payment method.
	 * 
	 * @param string $key
	 * @return string Value, which corresponds to the $key.
	 */
	public function getPaymentMethodConfigurationValue($key, $languageCode = null);
	
	/**
	 * This method checks whether a given method has a given configuration key or not.
	 * 
	 * @param string $key
	 * @param string $languageCode
	 * @return boolean True, in case the configuration key exists and false otherwise.
	 */
	public function existsPaymentMethodConfigurationValue($key, $languageCode = null);
	
}