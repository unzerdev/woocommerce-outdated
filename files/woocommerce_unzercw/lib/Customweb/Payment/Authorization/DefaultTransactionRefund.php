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

require_once 'Customweb/Payment/Authorization/ITransactionRefund.php';
require_once 'Customweb/Date/DateTime.php';

class Customweb_Payment_Authorization_DefaultTransactionRefund implements Customweb_Payment_Authorization_ITransactionRefund {

	private $refundId;
	private $amount;
	private $refundDate;
	private $status;
	private $lineItems = null;
	
	public function __construct($refundId, $amount, $status = NULL) {
		$this->refundId = $refundId;
		$this->amount = $amount;
		$this->refundDate = new Customweb_Date_DateTime();
		$this->status = $status;
		if ($this->status === NULL) {
			$this->status = self::STATUS_SUCCEED;
		}
	}
	
	public function getRefundId(){
		return $this->refundId;
	}
	
	public function setRefundId($refundId){
		$this->refundId = $refundId;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransactionRefund::getAmount()
	 */
	public function getAmount() {
		return $this->amount;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransactionRefund::getRefundedDate()
	 */
	public function getRefundedDate() {
		return $this->refundDate;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransactionRefund::getStatus()
	 */
	public function getStatus() {
		return $this->status;
	}
	
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransactionRefund::getRefundLabels()
	 */
	public function getRefundLabels() {
		return array_merge(
			$this->getBasicLabels(),
			$this->getTransactionSpecificLables()
		);
	}
	
	public function getRefundItems() {
		return $this->lineItems;
	}
	
	public function setRefundItems($items) {
		$this->lineItems = $items;
		return $this;
	}
	
	/**
	 * Generates basic labels from the transaction properties.
	 * 
	 * @return array
	 */
	protected function getBasicLabels(){
		$labels = array();
		
		$labels['refund_id'] = array(
				'label' => Customweb_I18n_Translation::__('Refund ID'),
				'value' =>	$this->getRefundId()
		);
		
		$labels['refund_amount'] = array(
				'label' => Customweb_I18n_Translation::__('Refund amount'),
				'value' =>	$this->getAmount()
		);
		
		$labels['refund_date'] = array(
				'label' => Customweb_I18n_Translation::__('Date'),
				'value' =>	$this->getRefundedDate()->format('Y-m-d H:i:s')
		);
		
		$labels['refund_status'] = array(
				'label' => Customweb_I18n_Translation::__('Refund status'),
				'description' => Customweb_I18n_Translation::__("If the status is 'Pending' it is unclear whether the transaction will be refunded successfully.")
		);
		
		if($this->getStatus() == self::STATUS_SUCCEED){
			$labels['refund_status']['value'] = Customweb_I18n_Translation::__('Success');
		}
		elseif($this->getStatus() == self::STATUS_PENDING){
			$labels['refund_status']['value'] = Customweb_I18n_Translation::__('Pending');
		}
		else{
			$labels['refund_status']['value'] = Customweb_I18n_Translation::__('Failed');
		}
		
		return $labels;
	}
	
	/**
	 * This method is intended for overriding by a subclass. It provides
	 * the opportunity for the subclass to provide own labels.
	 *
	 * @return array(
	 * 	  array(
	 * 	     'label' => 'Translated label',
	 *       'value' => 'Value to display',
	 *       'description' => 'Description of the labell' (optional)
	 *    )
	 * )
	 */
	protected function getTransactionSpecificLables()
	{
		return array();
	}
	
}