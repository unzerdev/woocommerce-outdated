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
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Payment/Exception/RecurringPaymentErrorException.php';
require_once 'Customweb/Unzer/Util/Message.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Operation_Authorize_ResponseProcessor extends Customweb_Unzer_Communication_AbstractTransactionProcessor {

	public function process(Customweb_Core_Http_IResponse $response){
		$this->getLogger()->logDebug(__METHOD__);
		try {
			parent::process($response);
			$this->transaction->setAuthorizationParameters($this->data);
			$this->processResourceIds($this->getResourcesData());
			$this->processProcessingIds($this->getProcessingData());
		}
		catch (Exception $e) {
			if ($this->transaction->isRecurring()) {
				throw new Customweb_Payment_Exception_RecurringPaymentErrorException(
						"Recurring failed {$this->transaction->getExternalTransactionId()}", 0, $e);
			}
			$this->getLogger()->logException($e);
			$this->transaction->setAuthorizationFailed($e->getMessage());
			return $this->transaction->getFailedUrl();
		}

		$this->setPaymentId($this->data);
		
		if ($this->data['isSuccess']) {
			return $this->processSuccess();
		}
		else if ($this->data['isPending']) {
			return $this->processPending();
		}

		return $this->getPendingUrl();
	}

	protected function processSuccess(){
		if (!$this->transaction->isAuthorized()) {
			$this->transaction->authorize(Customweb_Unzer_Util_Message::getCustomerMessage($this->data), $this->getPaymentMethodByTransaction($this->transaction)->isAuthorizePaid());
		}
		return $this->transaction->getSuccessUrl();
	}

	protected function processPending(){
		$paymentMethod = $this->getPaymentMethodByTransaction($this->transaction);
		if (isset($this->data['redirectUrl'])) {
			$this->transaction->setRedirectUrl($this->data['redirectUrl']);
			return $this->data['redirectUrl'];
		}
		else if ($paymentMethod->isPendingAuthorization()) {
			if (!$this->transaction->isAuthorized()) {
				$this->transaction->authorize(Customweb_I18n_Translation::__("The transaction is pending."), $paymentMethod->isPendingAuthorizePaid());
			}
			if ($paymentMethod->isPendingUncertain()) {
				$this->transaction->setAuthorizationUncertain(true);
			}
			return $this->transaction->getSuccessUrl();
		}
		return $this->getPendingUrl();
	}

	protected function setPaymentId(array $data){
		$this->transaction->setUnzAuthorizationId($data['id']);
		if (!$this->transaction->getPaymentId()) {
			$this->transaction->setPaymentId($data['id']); // must be set to something.. is changed after charge is made.
		}
	}

	private function getResourcesData(){
		return (isset($this->data['resources'])) ? $this->data['resources'] : array();
	}

	private function getProcessingData(){
		return (isset($this->data['processing'])) ? $this->data['processing'] : array();
	}

	private function getPendingUrl(){
		return $this->getContainer()->createSecuredEndpointUrl('pending', 'index', $this->transaction);
	}

	protected function getValidResponseCodes(){
		return array(
			200, // webhook
			201 // response
		);
	}
}