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
 * This interface represents a refund done a transaction. On each transactin 
 * multiple refunds can be applied.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_Authorization_ITransactionRefund {
	
	const STATUS_SUCCEED = 'succeed';
	const STATUS_PENDING = 'pending';
	const STATUS_FAILED = 'failed';
	
	/**
	 * The refund id associated with this refund.
	 *
	 * @return string
	 */
	public function getRefundId();
	
	/**
	 * This method returns the amount refunded.
	 * 
	 * @return double Amount refunded
	 */
	public function getAmount();
	
	/**
	 * This method returns the date on which the amount was refunded.
	 * 
	 * @return DateTime
	 */
	public function getRefundedDate();
	
	/**
	 * This method returns the status of the refund. A refund is status
	 * 'pending' in case it is not clear if it will succeed or not.
	 * 
	 * @return string The status of the Refund.
	 */
	public function getStatus();
	
	
	/**
	 * This method returns a set of labels, which describs this
	 * refund.
	 *
	 * The structure of the map:
	 *
	 * array(
	 *    'label_key' => array(
	 *         'label' => 'Translated Title of the label',
	 *         'value' => 'The translated value of the label.',
	 *         'description' => 'An optional description of the label.',
	 *     ),
	 * )
	 *
	 * @return array
	 */
	public function getRefundLabels();
	
	/**
	 * This method returns a list of items used to refund.
	 *
	 * @return Customweb_Payment_Authorization_IInvoiceItem[]
	 */
	public function getRefundItems();
	
}