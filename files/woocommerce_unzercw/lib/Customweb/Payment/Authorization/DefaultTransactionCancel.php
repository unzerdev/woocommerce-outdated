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

require_once 'Customweb/Payment/Authorization/ITransactionCancel.php';
require_once 'Customweb/Util/Invoice.php';
require_once 'Customweb/Date/DateTime.php';

class Customweb_Payment_Authorization_DefaultTransactionCancel implements Customweb_Payment_Authorization_ITransactionCancel {

	private $cancelId;
	private $cancelDate;
	private $status;
	private $lineItems = null;

	public function __construct($cancelId, $status = NULL) {
		$this->setCancelId($cancelId);
		$this->cancelDate = new Customweb_Date_DateTime();
		$this->status = $status;
		if ($this->status === NULL) {
			$this->status = self::STATUS_SUCCEED;
		}
	}

	public function getCancelId() {
		return $this->cancelId;
	}

	public function setCancelId($cancelId) {
		$this->cancelId = $cancelId;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransactionCancel::getCancelDate()
	 */
	public function getCancelDate() {
		return $this->cancelDate;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransactionCancel::getStatus()
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
	 * @see Customweb_Payment_Authorization_ITransactionCancel::getCancelLabels()
	 */
	public function getCancelLabels() {
		return array_merge(
			$this->getBasicLabels(),
			$this->getTransactionSpecificLables()
		);
	}

	/**
	 * Generates basic labels from the transaction properties.
	 *
	 * @return array
	 */
	protected function getBasicLabels(){
		$labels = array();

		$labels['cancel_id'] = array(
				'label' => Customweb_I18n_Translation::__('Cancel ID'),
				'value' =>	$this->getCancelId()
		);

		$labels['cancel_date'] = array(
				'label' => Customweb_I18n_Translation::__('Date'),
				'value' =>	$this->getCancelDate()->format('Y-m-d H:i:s')
		);

		$labels['cancel_status'] = array(
				'label' => Customweb_I18n_Translation::__('Cancel status'),
				'description' => Customweb_I18n_Translation::__("If the status is 'Pending' it is unclear whether the transaction will be cancelled successfully.")
		);

		if($this->getStatus() == self::STATUS_SUCCEED){
			$labels['cancel_status']['value'] = Customweb_I18n_Translation::__('Success');
		}
		elseif($this->getStatus() == self::STATUS_PENDING){
			$labels['cancel_status']['value'] = Customweb_I18n_Translation::__('Pending');
		}
		else{
			$labels['cancel_status']['value'] = Customweb_I18n_Translation::__('Failed');
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
