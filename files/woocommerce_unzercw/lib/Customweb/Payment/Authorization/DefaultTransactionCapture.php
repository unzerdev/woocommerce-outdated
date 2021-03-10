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

require_once 'Customweb/Payment/Authorization/ITransactionCapture.php';
require_once 'Customweb/Util/Invoice.php';
require_once 'Customweb/Date/DateTime.php';

class Customweb_Payment_Authorization_DefaultTransactionCapture implements Customweb_Payment_Authorization_ITransactionCapture {

	private $captureId;
	private $amount;
	private $captureDate;
	private $status;
	private $lineItems = null;
	
	public function __construct($captureId, $amount, $status = NULL) {
		$this->setCaptureId($captureId);
		$this->amount = $amount;
		$this->captureDate = new Customweb_Date_DateTime();
		$this->status = $status;
		if ($this->status === NULL) {
			$this->status = self::STATUS_SUCCEED;
		}
	}
	
	public function getCaptureId() {
		return $this->captureId;
	}
	
	public function setCaptureId($captureId) {
		$this->captureId = $captureId;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransactionCapture::getAmount()
	 */
	public function getAmount() {
		return $this->amount;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransactionCapture::getCaptureDate()
	 */
	public function getCaptureDate() {
		return $this->captureDate;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransactionCapture::getStatus()
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
	 * @see Customweb_Payment_Authorization_ITransactionCapture::getCaptureLabels()
	 */
	public function getCaptureLabels() {
		return array_merge(
			$this->getBasicLabels(),
			$this->getTransactionSpecificLables()
		);
	}
	
	public function getCaptureItems() {
		return $this->lineItems;
	}
	
	public function setCaptureItems($items) {
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
		
		$labels['capture_id'] = array(
				'label' => Customweb_I18n_Translation::__('Capture ID'),
				'value' =>	$this->getCaptureId()
		);
		
		$labels['capture_amount'] = array(
				'label' => Customweb_I18n_Translation::__('Capture amount'),
				'value' =>	$this->getAmount()
		);
		
		$labels['capture_date'] = array(
				'label' => Customweb_I18n_Translation::__('Date'),
				'value' =>	$this->getCaptureDate()->format('Y-m-d H:i:s')
		);
		
		$labels['capture_status'] = array(
				'label' => Customweb_I18n_Translation::__('Capture status'),
				'description' => Customweb_I18n_Translation::__("If the status is 'Pending' it is unclear whether the transaction will be captured successfully.")
		);
		
		if($this->getStatus() == self::STATUS_SUCCEED){
			$labels['capture_status']['value'] = Customweb_I18n_Translation::__('Success');
		}
		elseif($this->getStatus() == self::STATUS_PENDING){
			$labels['capture_status']['value'] = Customweb_I18n_Translation::__('Pending');
		}
		else{
			$labels['capture_status']['value'] = Customweb_I18n_Translation::__('Failed');
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