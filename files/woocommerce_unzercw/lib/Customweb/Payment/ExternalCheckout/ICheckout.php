<?php 

/**
 *  * You are allowed to use this API in your web application.
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
 * Defines a checkout object. 
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_ExternalCheckout_ICheckout {
	
	/**
	 * Return a machine name of the checkout.
	 * The name should only consists of ASCII chars. The should
	 * be unique per provider.
	 * 
	 * @return string Machine Name.
	 */
	public function getMachineName();
	
	/**
	 * Returns the name of the checkout. This name may be shown to
	 * the user.
	 *
	 * @return Customweb_I18n_ILocalizableString Name of the checkout
	 */
	public function getName();
	
	/**
	 * Returns an integer which indicates the sort order of the checkout. The returned number
	 * is used to determine the total order between all checkouts over all providers.
	 * 
	 * <p>
	 * The implementor may use some setting to allow the merchant to change this
	 * value.
	 * 
	 * @return int Sort order
	 */
	public function getSortOrder();
	
}