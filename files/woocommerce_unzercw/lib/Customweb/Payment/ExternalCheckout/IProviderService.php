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
 * This interface defines a provider of checkouts.
 *
 * <p>
 * This interface is implemented by the payment processor. The 
 * implementation must be added to the container.
 *
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_ExternalCheckout_IProviderService {

	/**
	 * Name of the authorization method when using checkout API.
	 */
	const AUTHORIZATION_METHOD_NAME = 'ExternalCheckout';
	
	/**
	 * Returns a list of checkouts provided by this provider.
	 * Each checkout may
	 * have a different process.
	 *
	 * @return Customweb_Payment_ExternalCheckout_ICheckout[]
	 */
	public function getCheckouts(Customweb_Payment_ExternalCheckout_IContext $context);

	/**
	 * Returns a HTML snippet which is used to provide a UI component for the 
	 * customer to choose the checkout. By clicking on the checkout the checkout
	 * process with this checkout starts.
	 * 
	 * @param Customweb_Payment_ExternalCheckout_ICheckout $checkout
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @return string HTML
	 */
	public function getWidgetHtml(Customweb_Payment_ExternalCheckout_ICheckout $checkout, Customweb_Payment_ExternalCheckout_IContext $context);
	
	/**
	 * Creates a new transaction based on the given transaction context.
	 * 
	 * @param Customweb_Payment_Authorization_ITransactionContext $transactionContext
	 * @return Customweb_Payment_Authorization_ITransaction
	 */
	public function createTransaction(Customweb_Payment_Authorization_ITransactionContext $transactionContext, Customweb_Payment_ExternalCheckout_IContext $context);
}