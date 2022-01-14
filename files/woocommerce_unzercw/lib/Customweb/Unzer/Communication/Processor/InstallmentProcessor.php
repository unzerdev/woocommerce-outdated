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

require_once 'Customweb/Unzer/Communication/Processor/DefaultProcessor.php';
require_once 'Customweb/Unzer/Communication/Processor/ManualDirectChargeProcessor.php';
require_once 'Customweb/Unzer/Communication/Operation/PaymentProcessor.php';


/**
 * Processor to process authorize request followed immediately by a charge request (for instalments)
 *
 * @author sebastian
 *
 */
class Customweb_Unzer_Communication_Processor_InstallmentProcessor extends Customweb_Unzer_Communication_Operation_PaymentProcessor {

	public function process(){
		$result = parent::process();
		if($this->getTransaction()->isAuthorized()) {
			$processor = new Customweb_Unzer_Communication_Processor_ManualDirectChargeProcessor($this->getTransaction(), $this->getContainer());
			$result = $processor->process();
			$this->getLogger()->logDebug("Processed charge for {$this->getTransaction()->getUnzChargeId()}");
			return $result;
		}
		else {
			return $result;
		}
	}

	/**
	 * Must always recreate due to database transactions
	 *
	 * {@inheritdoc}
	 * @see Customweb_Unzer_Communication_Processor_DefaultProcessor::getResponseProcessor()
	 */
	protected function getResponseProcessor(){
		return $this->getContainer()->getPaymentMethodByTransaction($this->getTransaction())->getPaymentResponseProcessor($this->getTransaction());
	}
}