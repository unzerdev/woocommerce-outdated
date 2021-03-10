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

require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Payment/Authorization/DefaultTransactionCapture.php';
require_once 'Customweb/Util/Invoice.php';


/**
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Authorization_Capture extends Customweb_Payment_Authorization_DefaultTransactionCapture {
	protected $chargeId = null;
	protected $lineItems;
	
	public function getRefundableLineItems($lineItemsToRefund){
		$remaining = Customweb_Util_Invoice::substractLineItems($this->lineItems, $lineItemsToRefund);
		$refundable = Customweb_Util_Invoice::substractLineItems($this->lineItems, $remaining);
		return $refundable;
	}
	
	public function refundLineItems($lineItems) {
		$this->lineItems = Customweb_Util_Invoice::substractLineItems($this->lineItems, $lineItems);
	}
	
	public function setLineItems($lineItems) {
		$this->lineItems = $lineItems;
	}

	/**
	 * @return mixed
	 */
	public function getChargeId(){
		return $this->chargeId;
	}

	/**
	 * @param mixed $chargeId
	 */
	public function setChargeId($chargeId){
		$this->chargeId = $chargeId;
	}
	
	protected function getTransactionSpecificLables(){
		return array(
			'unzid' => array(
				'label' => Customweb_I18n_Translation::__("Charge ID")->toString(),
				'value' => $this->getChargeId()
			)
		);
	}
}