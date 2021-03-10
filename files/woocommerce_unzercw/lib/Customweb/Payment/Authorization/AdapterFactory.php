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
require_once 'Customweb/Payment/Authorization/IAdapterFactory.php';

/**
 * 
 * 
 * @Bean
 *
 */
class Customweb_Payment_Authorization_AdapterFactory implements Customweb_Payment_Authorization_IAdapterFactory {

	/**
	 * @var Customweb_Payment_Authorization_IAdapter[]
	 */
	private $adapters = null;
	
	private $adaptersByName = array();
	
	/**
	 * @var Customweb_DependencyInjection_IContainer
	 */
	private $container = null;
	
	public function __construct(Customweb_DependencyInjection_IContainer $container) {
		$this->container = $container;
	}
	
	public function getAuthorizationAdapterByContext(Customweb_Payment_Authorization_IOrderContext $orderContext) {
		$configuredAuthorizationMethod = $orderContext->getPaymentMethod()->getPaymentMethodConfigurationValue('authorizationMethod');
		
		$possibleAdapters = array();
		foreach ($this->getAuthorizationAdapters() as $adapter) {
			$possibleAdapters[] = $adapter->getAuthorizationMethodName();
		}
		
		return $this->getAdapterByOrderContextInner($configuredAuthorizationMethod, $possibleAdapters, $orderContext);
	}
	
	public function getAuthorizationAdapterByName($authorizationMethodName) {
		$instances = $this->getAuthorizationAdapters();
		$key = strtolower($authorizationMethodName);
		
		if (isset($instances[$key])) {
			return $instances[$key];
		}
		else {
			throw new Exception(Customweb_I18n_Translation::__(
					"The authorization method '!method' is not supported.",
					array('!method' => $authorizationMethodName)
			));
		}
	}

	
	/**
	 * This method tries to instanciated an adapter for the given authorization method. If the authorization method
	 * is not supported for the given context the next one in the stack is tried.
	 *
	 * @param string $currentMethod
	 * @param array $supportedMethod
	 * @param Customweb_Payment_Authorization_IOrderContext $context
	 * @throws Exception In case no adapter matches the given parameters.
	 */
	private function getAdapterByOrderContextInner($currentMethod, array $supportedMethod, Customweb_Payment_Authorization_IOrderContext $context) {
		if (count($supportedMethod) <= 0) {
			throw new Exception(
					Customweb_I18n_Translation::__(
							"No authorization method found for payment method !method.",
							array('!method' => $context->getPaymentMethod()->getPaymentMethodName())
					)
			);
		}
	
		$adapter = $this->getAuthorizationAdapterByName($currentMethod);
		if ($adapter->isAuthorizationMethodSupported($context)) {
			return $adapter;
		}
		else {
			$applicableMethods = array();
			foreach ($supportedMethod as $methodName) {
				if ($methodName == $currentMethod) {
					break;
				}
				$applicableMethods[] = $methodName;
			}
			return $this->getAdapterByOrderContextInner(end($applicableMethods), $applicableMethods, $context);
		}
	}
	
	/**
	 * @return Customweb_Payment_Authorization_IAdapter[]
	 */
	protected function getAuthorizationAdapters() {
		if ($this->adapters === null) {
			$adapters = $this->container->getBeansByType('Customweb_Payment_Authorization_IAdapter');
			$this->adapters = array();
			foreach ($adapters as $adapter) {
				/* @var $adapter Customweb_Payment_Authorization_IAdapter */
				$key = self::findNextBiggerKey($this->adapters, $adapter->getAdapterPriority());
				$this->adapters[$key] = $adapter;
			}
			ksort($this->adapters);
			
			foreach ($this->adapters as $adapter) {
				$key = strtolower($adapter->getAuthorizationMethodName());
				$this->adaptersByName[$key] = $adapter;
			}
		}
		
		return $this->adaptersByName;
	}
	
	private static function findNextBiggerKey($array, $key) {
		if (isset($array[$key])) {
			return self::findNextBiggerKey($array, $key + 1);
		}
		else {
			return $key;
		}
	}
}