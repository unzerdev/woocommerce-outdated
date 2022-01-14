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
require_once 'Customweb/Unzer/Communication/Type/Instalment/UpdateResponseProcessor.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Unzer/Communication/Processor/InstallmentProcessor.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Unzer/Method/Default.php';
require_once 'Customweb/Unzer/Communication/Type/Instalment/UpdateRequestBuilder.php';


/**
 *
 * @author Sebastian Bossert
 * @Method(paymentMethods={'UnzerInstallment'})
 */
class Customweb_Unzer_Method_FlexipayInstallment extends Customweb_Unzer_Method_Default {
	
	public function capture(Customweb_Unzer_Authorization_Transaction $transaction, array $items, $close){
		$this->updateDueDate($transaction);
		parent::capture($transaction, $items, $close);
	}
	
	protected function updateDueDate(Customweb_Unzer_Authorization_Transaction $transaction) {
		$requestBuilder = new Customweb_Unzer_Communication_Type_Instalment_UpdateRequestBuilder($transaction, $this->getContainer());
		$responseProcessor = new Customweb_Unzer_Communication_Type_Instalment_UpdateResponseProcessor($this->getContainer());
		$processor = new Customweb_Unzer_Communication_Processor_DefaultProcessor($requestBuilder, $responseProcessor, $this->getContainer());
		$processor->process();
	}
	
	/**
	 * Create a processor used to process a payment.
	 * May return a processor including either authorize, directcharge or recurring / register.
	 *
	 * @param Customweb_Unzer_Authorization_Transaction $transaction
	 * @return Customweb_Unzer_Communication_Operation_PaymentProcessor
	 */
	public function getPaymentProcessor(Customweb_Unzer_Authorization_Transaction $transaction){
		return new Customweb_Unzer_Communication_Processor_InstallmentProcessor($transaction->getExternalTransactionId(),
				$this->getPaymentRequestBuilder($transaction), $this->getContainer(), $transaction->getUnzTypeId()); //TODO cleaner
	}
	
	public function getRequiredPlaceholders(){
		return array(
			'hire-purchase' => Customweb_I18n_Translation::__("Select plan")
		);
	}
	
	protected function getJavascriptCallbackPreError(Customweb_Payment_Authorization_ITransaction $transaction) {
		return <<<JAVASCRIPT
(function(){
	if(typeof document.{$this->getJsPrefix()}Error !== undefined) {
		return document.{$this->getJsPrefix()}Error;
	}
	return null;
})();
JAVASCRIPT;
	}
	
	/**
	 *
	 * @param array $placeholders
	 * @param boolean $useWide
	 * @return string
	 */
	public function getInitializePlaceholdersJavascript(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext, array $placeholders){
		$prefix = $this->getJsPrefix();
		$creator = "document.{$prefix}Instance.create";
		$script = "";
		foreach ($placeholders as $name => $id) {
			$encodedOptions = json_encode([
				'containerId' => $id,
				'onlyIframe'=>  !$this->isUseWidePlaceholders(),
				'amount' => Customweb_Util_Currency::formatAmount($orderContext->getOrderAmountInDecimals(), $orderContext->getCurrencyCode()),
				'currency' => $orderContext->getCurrencyCode(),
				'effectiveInterest' => $this->getEffectiveInterestRate(),
				'orderDate' => date('Y-m-d')
			], JSON_FORCE_OBJECT);
			$script .= <<<JAVASCRIPT
{$creator}({$encodedOptions}).catch(function(error){
	document.getElementById('{$id}').innerText = error.message;
	document.{$this->getJsPrefix()}Error = error;
});
JAVASCRIPT;
		}
		// effective interest from selected plan
		// amount & currency & orderDate from order context
		return $script;
	}
	
	public function getAdditionalAuthorizeParameters(Customweb_Unzer_Authorization_Transaction $transaction) {
		return array(
			'effectiveInterestRate' => $this->getEffectiveInterestRate()
		);
	}
	
	private function getEffectiveInterestRate() {
		$value = $this->getPaymentMethodConfigurationValue('effective_interest_rate');
		if(empty($value)) {
			$value = 5.99;
		}
		return $value;
	}
}