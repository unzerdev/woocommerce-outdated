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

require_once 'Customweb/Form/Element.php';
require_once 'Customweb/Form/Control/HiddenInput.php';
require_once 'Customweb/Form/HiddenElement.php';
require_once 'Customweb/Form/AbstractElement.php';
require_once 'Customweb/Unzer/Form/Validator.php';
require_once 'Customweb/Form/Control/Abstract.php';
require_once 'Customweb/Unzer/Adapter.php';
require_once 'Customweb/Form/WideElement.php';
require_once 'Customweb/Unzer/Form/PlaceholderControl.php';


/**
 * Adapter used to create and interact with form elements to be rendered during checkout.
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Form_Adapter extends Customweb_Unzer_Adapter {
	private $orderContext;
	private $paymentCustomerContext;
	private $paymentMethod;
	private $aliasTransaction;

	/**
	 *
	 * @return Customweb_Payment_Authorization_IOrderContext
	 */
	protected function getOrderContext(){
		return $this->orderContext;
	}

	/**
	 *
	 * @return Customweb_Payment_Authorization_IPaymentCustomerContext
	 */
	protected function getPaymentCustomerContext(){
		return $this->paymentCustomerContext;
	}

	/**
	 *
	 * @return Customweb_Unzer_Method_Default
	 */
	protected function getPaymentMethod(){
		return $this->paymentMethod;
	}

	/**
	 * Map of name => control id, populated while creating placeholders.
	 *
	 * @var array
	 */
	private $placeholders = array();

	public function __construct(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext, $aliasTransaction, Customweb_Unzer_Method_Default $paymentMethod, Customweb_DependencyInjection_IContainer $container){
		parent::__construct($container);
		$this->orderContext = $orderContext;
		$this->paymentCustomerContext = $paymentCustomerContext;
		$this->paymentMethod = $paymentMethod;
		$this->aliasTransaction = $aliasTransaction;
	}

	public function getFormElements(){
		$elements = $this->getPaymentMethod()->getRequiredInputFields($this->orderContext, $this->paymentCustomerContext, $this->aliasTransaction);
		foreach ($this->getPaymentMethod()->getRequiredPlaceholders() as $name => $label) {
			$elements[] = $this->createPlaceholderElement($label, $name);
		}
		if (empty($elements)) {
			$elements[] = $this->getPseudoElement(); // ensure can attach JS
		}
		$lastElement = end($elements);

		$this->addJavascript($lastElement);
		$control = $lastElement->getControl();
		if ($control instanceof Customweb_Form_Control_Abstract) {
			$validator = new Customweb_Unzer_Form_Validator($this->paymentMethod->getJsPrefix(), $control);
			$control->addValidator($validator);
		}
		else {
			throw new Exception("Unsupported form control type supplied, please contact support.");
		}
		return $elements;
	}

	private function getPseudoElement(){
		$control = new Customweb_Form_Control_HiddenInput('unzer-script');
		$control->setRequired(false);
		return new Customweb_Form_HiddenElement($control);
	}

	protected function addJavascript(&$element){
		$script = $this->getAddResourcesJavascript();

		$afterLoadScript = $this->getInitializeUnzerJavascript();
		$afterLoadScript .= $this->getInitializeCreatorJavascript();
		$afterLoadScript .= $this->getInitializePlaceholdersJavascript();

		$script .= $this->getUnzerLoadedScript($afterLoadScript);

		if ($element instanceof Customweb_Form_AbstractElement) {
			$element->appendJavaScript($script);
		}
		else if ($element instanceof Customweb_Form_HiddenElement) {
			$element->setJavaScript($script);
		}
	}

	protected function getUnzerLoadedScript($innerScript){
		$prefix = $this->getPaymentMethod()->getJsPrefix();
		return <<<JAVASCRIPT
function {$prefix}CheckLoaded(){
	if(typeof unzer !== 'undefined') {
		document.unzer = unzer;
	}
	if(typeof document.unzer === 'undefined') {
		setTimeout({$prefix}CheckLoaded, 500);
	}
	else {
		{$innerScript}
	}
}
{$prefix}CheckLoaded();
JAVASCRIPT;
	}

	protected function getAddResourcesJavascript(){
		return <<<JAVASCRIPT
if(typeof document.unzerIncluded === 'undefined') {
	document.unzerIncluded = true;
	var body = document.getElementsByTagName('body')[0];
	if(typeof require === 'function') {
		require(['{$this->getJavascriptUrl()}'], function(arg) {
			document.unzer = arg;
		});
	}
	else {
		const scriptSrc = document.createElement('script');
		scriptSrc.type = 'text/javascript';
		scriptSrc.src = '{$this->getJavascriptUrl()}';
		body.appendChild(scriptSrc);
	}
	const extCssSrc = document.createElement('link');
	extCssSrc.rel = 'stylesheet';
	extCssSrc.href = '{$this->getCssUrl()}';
	const intCssSrc = document.createElement('link');
	intCssSrc.rel = 'stylesheet';
	intCssSrc.href = '{$this->getModuleCssUrl()}';
	body.appendChild(intCssSrc);
	body.appendChild(extCssSrc);
}
JAVASCRIPT;
	}
	
	protected function getModuleCssUrl() {
		return (string)$this->getContainer()->getAssetResolver()->resolveAssetUrl('unzer.css');
	}

	protected function getInitializeUnzerJavascript(){
		$locale = $this->mapSupportedLocale($this->getOrderContext()->getLanguage());
		return <<<JAVASCRIPT
if(typeof document.unzerInstance === 'undefined') {
	document.unzerInstance = new document.unzer('{$this->getContainer()->getConfiguration()->getPublicKey()}', {locale: '$locale'});
}
JAVASCRIPT;
	}

	protected function getInitializeCreatorJavascript(){
		$constructor = $this->getPaymentMethod()->getJsConstructor();
		$prefix = $this->getPaymentMethod()->getJsPrefix();
		return <<<JAVASCRIPT
document.{$prefix}Instance = document.unzerInstance.{$constructor}();
JAVASCRIPT;
	}

	/**
	 * Initializes all placeholders.
	 * Must be called after creating form control so placeholders are populated
	 *
	 * @return string
	 */
	protected function getInitializePlaceholdersJavascript(){
		return $this->getPaymentMethod()->getInitializePlaceholdersJavascript($this->getOrderContext(), $this->getPaymentCustomerContext(),
				$this->placeholders);
	}

	/**
	 * Toggle if wide elements should be used => should labels be rendered via shop or via unzer?
	 *
	 * @return boolean
	 */
	protected function isUseWidePlaceholders(){
		return $this->getPaymentMethod()->isUseWidePlaceholders();
	}

	protected function createPlaceholderElement($label, $name){
		$control = $this->createPlaceholderControl($name);
		if ($this->isUseWidePlaceholders()) {
			return new Customweb_Form_WideElement($control);
		}
		else {
			return new Customweb_Form_Element($label, $control);
		}
	}

	protected function createPlaceholderControl($name){
		$control = new Customweb_Unzer_Form_PlaceholderControl($name);
		$this->placeholders[$name] = $control->getControlId();
		return $control;
	}

	protected function getCssUrl(){
		return $this->getAssetUrl("unzer.css");
	}

	protected function getJavascriptUrl(){
		return $this->getAssetUrl("unzer.js");
	}

	protected function getAssetUrl($assetFile){
		return str_replace(array(
			"{assetVersion}",
			"{assetFile}"
		), array(
			"v1",
			$assetFile
		), "https://static.unzer.com/{assetVersion}/{assetFile}");
	}

	private function mapSupportedLocale(Customweb_Core_Language $language){
		$supported = $this->getSupportedLocales();
		if (in_array($language->getIetfCode(), $supported)) {
			return $language->getIetfCode();
		}
		return 'auto';
	}

	private function getSupportedLocales(){
		$locales = $this->getPaymentMethod()->getPaymentMethodParameter('locales');
		return explode(',', $locales);
	}
}