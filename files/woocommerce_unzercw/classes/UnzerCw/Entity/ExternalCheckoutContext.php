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

require_once 'UnzerCw/Util.php';
require_once 'Customweb/Util/Url.php';
require_once 'Customweb/Payment/ExternalCheckout/IContext.php';
require_once 'Customweb/Payment/ExternalCheckout/AbstractContext.php';
require_once 'UnzerCw/CartUtil.php';
require_once 'UnzerCw/ConfigurationAdapter.php';
require_once 'UnzerCw/Entity/ExternalCheckoutContext.php';


/**
 * @Entity(tableName = 'woocommerce_unzercw_ecc')
 * @Filter(name = 'loadContextCookie', where = 'contextId = >contextId AND cookieKey = >cookieKey', orderBy = 'contextId')
 */
class UnzerCw_Entity_ExternalCheckoutContext extends Customweb_Payment_ExternalCheckout_AbstractContext {
	
	
	private $cookieKey;
	
	private $selectedShippingMethods;
	
	private $verificationHash;
	
	private $additionalValues;
	
	protected function loadPaymentMethodByMachineName($machineName){
		$paymentMethods = UnzerCw_Util::getPaymentMethods(true);
		foreach($paymentMethods as $method) {
			$instance = UnzerCw_Util::getPaymentMehtodInstance($method);
			if(strtolower($instance->getPaymentMethodName()) == strtolower($machineName)){
				return $instance;
			}
		}
	}
	
	
	/**
	 * @param int $id
	 * @param boolean $loadFromCache
	 * @return UnzerCw_Entity_ExternalCheckoutContext
	 */
	public static function getContextById($id, $loadFromCache = true) {
		return UnzerCw_Util::getEntityManager()->fetch('UnzerCw_Entity_ExternalCheckoutContext', $id, $loadFromCache);
	}
	
	
	/**
	 *
	 * @param boolean $loadFromCache
	 * @return UnzerCw_Entity_ExternalCheckoutContext
	 */
	public static function getReusableContextFromCookie($loadFromCache = true) {
		if (isset($_COOKIE['unzercw-woocommerce-context-id']) && isset($_COOKIE['unzercw-woocommerce-context-key'])) {
			try {
				$result = UnzerCw_Util::getEntityManager()->searchByFilterName('UnzerCw_Entity_ExternalCheckoutContext', 'loadContextCookie', array('>contextId' => $_COOKIE['unzercw-woocommerce-context-id'], '>cookieKey' => $_COOKIE['unzercw-woocommerce-context-key']), $loadFromCache);
				if (count($result) > 0) {
					$context = current($result);
					if ($context instanceof UnzerCw_Entity_ExternalCheckoutContext && $context->getState() == Customweb_Payment_ExternalCheckout_IContext::STATE_PENDING) {
						return $context;
					}
				}
			}
			catch(Customweb_Database_Entity_Exception_EntityNotFoundException $e) {
			}
		}
		return null;
	}
	
	public function updateFromCart($cart) {
		$id = $this->getContextId();
		if (empty($id)) {
			throw new Exception("Before the context can be updated with cart, the context must be stored in the database.");
		}
		$language = get_bloginfo('language');
		$this->setLanguageCode($language);
		$currencyCode = get_woocommerce_currency();
		$this->setCurrencyCode($currencyCode);
		$checkoutUrl = wc_get_checkout_url();
		$cartUrl = wc_get_cart_url();
		
		if(UnzerCw_ConfigurationAdapter::getExternalCheckoutPlacement() == 'checkout') {
			$this->setCartUrl(Customweb_Util_Url::appendParameters($checkoutUrl, array('old-context-id' => $this->getContextId(), 'verifyKey' => $this->getCookieKey())));
		}
		else {
			$this->setCartUrl(Customweb_Util_Url::appendParameters($cartUrl, array('old-context-id' => $this->getContextId(), 'verifyKey' => $this->getCookieKey())));
		}		
		
		$this->setDefaultCheckoutUrl($checkoutUrl);
		
		if($this->getPaymentMethod() != null) {
			WC()->session->set( 'chosen_payment_method', $this->getPaymentMethod()->class_name);
		}
		$GLOBALS['cwExternalCheckoutOrderTotal'] = true;
		$cart->calculate_totals();
						
		$this->setInvoiceItems(UnzerCw_CartUtil::getInoviceItemsFromCart($cart));
		
		$GLOBALS['cwExternalCheckoutOrderTotal'] = false;
		return $this;
	}
		
	
	/**
	 * @Column(type = 'varchar')
	 */
	public function getCookieKey() {
		return $this->cookieKey;
	}
	
	
	public function setCookieKey($key) {
		$this->cookieKey = $key;
		return $this;
	}
	
	/**
	 * @Column(type = 'varchar')
	 */
	public function getVerificationHash(){
		return $this->verificationHash;
	}
	
	public function setVerificationHash($hash){
		$this->verificationHash = $hash;
		return $this;
	}
	
	/**
	 * @Column(type = 'object')
	 */
	public function getSelectedShippingMethods() {
		return $this->selectedShippingMethods;
	}
	
	
	public function setSelectedShippingMethods($selectedShippingMethods) {
		$this->selectedShippingMethods = $selectedShippingMethods;
		return $this;
	}

	
	public static function computeVerificationHash(array $lineItems, $total, $currency){
		$stringToHash ='';
		foreach($lineItems as $item) {
			/**
			 * @var $item Customweb_Payment_Authorization_DefaultInvoiceItem
			 */
			$stringToHash .= $item->getName();
		}
		$stringToHash .= $total.$currency;
		return hash('sha256', $stringToHash);
	}
	
	/**
	 * @Column(type = 'object')
	 */
	public function getAdditionalValues(){
		return $this->additionalValues;
	}
	
	public function setAdditionalValues($additionalValues){
		$this->additionalValues = $additionalValues;
		return $this;
	}
	
}