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
interface Customweb_Payment_Authorization_ITransactionContext {
	
	/**
	 * Direct capturing means that the payment is directly charged.
	 *
	 * @var string
	 */
	const CAPTURING_MODE_DIRECT = 'direct';
	
	/**
	 * Deferred means that the payment is not charged directly.
	 * It is chared later
	 * by a manual action or by a automatic action.
	 *
	 * @var string
	 */
	const CAPTURING_MODE_DEFERRED = 'deferred';

	/**
	 * This method returns the order context.
	 *
	 * 
	 *
	 * @return Customweb_Payment_Authorization_IOrderContext OrderContext
	 */
	public function getOrderContext();

	/**
	 * The id used for this transaction.
	 * The transaction id must be unique and number. Hence only 0-9 
	 * chars can be used for generating the transaction id.
	 *
	 * @return int The transaction identifier of the transaction.
	 */
	public function getTransactionId();

	/**
	 * Returns the order id for this transaction.
	 * This value may be null, when no order id can be provided
	 * in the stage of creation of the transaction context.
	 *
	 * @return string Order ID (can contain alphanumeric chars)
	 */
	public function getOrderId();

	/**
	 * Returns true, when the order id is unique.
	 * Means each new transaction will cause a new order.
	 *
	 * @return boolean
	 */
	public function isOrderIdUnique();

	/**
	 * This method returns if the payment should be captured or deferred (only a reservation on the card)
	 * processed.
	 * This value overrides setting of the payment method. In case the default value of
	 * the payment method should be used, this method must return null.
	 *
	 * @return string Either CAPTURING_MODE_DIRECT, CAPTURING_MODE_DEFERRED or null.
	 */
	public function getCapturingMode();

	/**
	 * This method returns string, which identifies the alias to use for the transaction.
	 * If this method
	 * returns 'new' a new alias should be created by the API.
	 *
	 * If the payment method does not support Alias and this method returns 'new' or a Alias value, then
	 * the processed transaction object contains no Alias. Hence the determination if a payment method
	 * supports alias or not is determine after the payment is authorized.
	 *
	 * If this method returns NULL the API will treat this as deactivation of the alias manager.
	 *
	 * @return Customweb_Payment_Authorization_ITransaction The alias identification for this transaction
	 */
	public function getAlias();

	/**
	 * This flag indicates that a new alias for a recurring payment should be created.
	 *
	 *
	 * @return boolean Create an alias for recurring payments
	 */
	public function createRecurringAlias();

	/**
	 * Define list of key/value pairs returned by this method are added to the transaction.
	 * The result URLs
	 * (success, error etc.) are not allowed to contain any dynamic parameters. They must be provided through
	 * this method. Some PSP requires to set some of the result URLs in a static fashion, which prevents setting
	 * parameters on that URLs.
	 *
	 * @return array List of key/value pairs of additional parameters added to the transaction.
	 */
	public function getCustomParameters();

	/**
	 * This method returns the payment customer context.
	 *
	 * @see Customweb_Payment_Authorization_IPaymentCustomerContext
	 *
	 * @return Customweb_Payment_Authorization_IPaymentCustomerContext
	 */
	public function getPaymentCustomerContext();
}