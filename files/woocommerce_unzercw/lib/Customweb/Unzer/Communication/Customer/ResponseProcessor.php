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

require_once 'Customweb/Unzer/Communication/AbstractTransactionProcessor.php';
require_once 'Customweb/Unzer/Communication/Customer/CreateRequestBuilder.php';
require_once 'Customweb/Core/Http/Client/Factory.php';
require_once 'Customweb/Unzer/Communication/Customer/UpdateRequestBuilder.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Customer_ResponseProcessor extends Customweb_Unzer_Communication_AbstractTransactionProcessor {
	public function process(Customweb_Core_Http_IResponse $response){
		parent::process($response);
		
		if($this->isError()) {
			if($this->hasCustomerDeletedError()) {
				$this->createCustomer();
			}
			else if($this->hasCustomerExistsError()) {
				$this->updateCustomer();
			}
		}
		else {
			$this->transaction->setUnzCustomerId($this->data['id'], $this->getPaymentMethodByTransaction($this->transaction)->getPublicKey());
		}
	}
	
	protected function createCustomer() {
		$key = $this->getPaymentMethodByTransaction($this->transaction)->getPublicKey();
		$this->transaction->setUnzCustomerId($this->transaction->getTransactionContext()->getOrderContext()->getCustomerId(), $key); // overwrite with shop id
		$updateBuilder = new Customweb_Unzer_Communication_Customer_CreateRequestBuilder($this->transaction, $this->getContainer());
		$response = Customweb_Core_Http_Client_Factory::createClient()->send($updateBuilder->buildRequest()); // separate processor maybe?
		parent::process($response);
		$this->transaction->setUnzCustomerId($this->data['id'], $key);
	}
	
	protected function updateCustomer() {
		$key = $this->getPaymentMethodByTransaction($this->transaction)->getPublicKey();
		// can update using our customerId, processing afterwards is the same, can use this one
		$this->transaction->setUnzCustomerId($this->transaction->getTransactionContext()->getOrderContext()->getCustomerId(), $key);
		$updateBuilder = new Customweb_Unzer_Communication_Customer_UpdateRequestBuilder($this->transaction, $this->getContainer());
		$response = Customweb_Core_Http_Client_Factory::createClient()->send($updateBuilder->buildRequest()); // separate processor maybe?
		parent::process($response);
		$this->transaction->setUnzCustomerId($this->data['id'], $key);
	}
	
	protected function processError(){
		if($this->hasCustomerExistsError() || $this->hasCustomerDeletedError()){
			return;
		}
		parent::processError();
	}
	
	private function hasCustomerDeletedError(){
		if(array_key_exists('errors', $this->data)){
			foreach($this->data['errors'] as $error) {
				if($error['code'] == 'API.410.100.100') {
					return true;
				}
			}
		}
		return false;
	}
	
	private function hasCustomerExistsError(){
		if(array_key_exists('errors', $this->data)){
			foreach($this->data['errors'] as $error) {
				if($error['code'] == 'API.410.200.010') {
					return true;
				}
			}
		}
		return false;
	}
	
	protected function getValidResponseCodes(){
		return array(
			200, // for update
			201 // for create
		);
	}
}