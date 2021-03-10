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

require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Annotation/Scanner.php';
require_once 'Customweb/Payment/Authorization/Method/PaymentMethodResolutionException.php';
require_once 'Customweb/DependencyInjection/Bean/Object.php';
require_once 'Customweb/Payment/Annotation/Method.php';
require_once 'Customweb/DependencyInjection/Bean/Provider/Annotation/Util.php';
require_once 'Customweb/DependencyInjection/Container/Extendable.php';


/**
 * Abstract implementation of a payment method factory. The factory can be used to get depending
 * on the given payment definition the right payment method wrapper implementation.
 * 
 * Any class which should be found by this factory must be annotated with the 
 * annotation 'Customweb_Payment_Annotation_Method'.
 * 
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_Payment_Authorization_Method_AbstractFactory {
	
	/**
	 * @var array
	 */
	private $methodAnnotations = null;
	
	/**
	 * @var array
	 */
	private $classMap = null;
	
	/**
	 * @var array
	 */
	private $paymentMethodInstances = array();
	
	/**
	 * @var Customweb_DependencyInjection_IContainer
	 */
	private $container = null;
	
	/**
	 * This method returns the default processor name for the given payment method. Per default
	 * this method returns null. In this case the first method is used which match the criteria.
	 * However in certain situations a specific processor should be used. Then this method can 
	 * be used, when no processor setting is present, but a specific processor should be used. 
	 * 
	 * @param Customweb_Payment_Authorization_IPaymentMethod $method
	 * @param string $authorizationMethodName Authorization method name
	 * @return string Processor Machine Name
	 */
	protected function getDefaultOperator(Customweb_Payment_Authorization_IPaymentMethod $method, $authorizationMethodName) {
		return null;
	}

	/**
	 * Returns the package name which should be scanned for payment method classes.
	 *
	 * @return string[] Package names with the method classes.
	 */
	abstract protected function getMethodPackages();
	
	/**
	 * Set the dependency injection container.
	 * 
	 * @param Customweb_DependencyInjection_IContainer $container
	 * @Inject
	 * @return Customweb_Payment_Authorization_Method_AbstractFactory
	 */
	final public function setContainer(Customweb_DependencyInjection_IContainer $container) {
		$this->container = $container;
		return $this;
	}
	
	/**
	 * @return Customweb_DependencyInjection_IContainer
	 */
	final public function getContainer() {
		return $this->container;
	}
	
	/**
	 * This method returns the payment method wrapper object. 
	 * 
	 * @param Customweb_Payment_Authorization_IPaymentMethod $method
	 * @return object
	 */
	public function getPaymentMethod(Customweb_Payment_Authorization_IPaymentMethod $method, $authorizationMethodName) {
		$keys = $this->getKeys($method, $authorizationMethodName);
		$className = $this->resolveClassName($this->getClassMap(), $keys);
		
		if ($className === false) {
			throw new Customweb_Payment_Authorization_Method_PaymentMethodResolutionException($method->getPaymentMethodName(), $authorizationMethodName);
		}
		
		$instanceKey = implode('_', $keys);
		if (!isset($this->paymentMethodInstances[$instanceKey][$className])) {
			// We inject the given class as regular bean, but we do not store it back into the container. However,
			// we have to inject any required dependency.
			$bean = Customweb_DependencyInjection_Bean_Provider_Annotation_Util::createBeanInstance($className, $className);
			$container = new Customweb_DependencyInjection_Container_Extendable($this->getContainer());
			$container->addBean(new Customweb_DependencyInjection_Bean_Object($method));
			if (!isset($this->paymentMethodInstances[$instanceKey])) {
				$this->paymentMethodInstances[$instanceKey] = array();
			}
			$this->paymentMethodInstances[$instanceKey][$className] = $bean->getInstance($container);
		}
		
		return $this->paymentMethodInstances[$instanceKey][$className];
	}
	
	/**
	 * This method resolves based on the given keys and the map the correct
	 * class name. In case the method returns false no suitable class was 
	 * found.
	 * 
	 * @param array $map
	 * @param array $keys
	 * @return boolean|array|string
	 */
	final protected function resolveClassName($map, $keys) {
		if (is_array($map)) {
			$key = reset($keys);
			$nextMap = array();
			if (isset($map[$key])) {
				$nextMap = $map[$key];
			}
			elseif (isset($map['*'])) {
				$nextMap = $map['*'];
			}
			else {
				return false;
			}
			array_shift($keys);
			return $this->resolveClassName($nextMap, $keys);
		}
		else {
			return $map;
		}
	}
	
	/**
	 * This method returns the keys for accessing the map with the classes.
	 * 
	 * @param Customweb_Payment_Authorization_IPaymentMethod $method
	 * @param string $authorizationMethodName
	 * @return string[]
	 */
	final protected function getKeys(Customweb_Payment_Authorization_IPaymentMethod $method, $authorizationMethodName) {
		$paymentMethodKey = strtolower($method->getPaymentMethodName());
			
		if ($authorizationMethodName === null) {
			$authorizationMethodName = '*';
		}
		$authorizationMethodNameKey = strtolower($authorizationMethodName);
		
		$processorKey = null;
		if ($method->existsPaymentMethodConfigurationValue('processor')) {
			$processorKey = $method->getPaymentMethodConfigurationValue('processor');
		}
		if ($processorKey === null) {
			$processorKey = $this->getDefaultOperator($method, $authorizationMethodName);
		}
		
		if ($processorKey === null) {
			$processorKey = '*';
		}
		
		$processorKey = strtolower($processorKey);
		
		return array(
			'paymentMethodKey' => $paymentMethodKey,
			'authorizationMethodNameKey' => $authorizationMethodNameKey,
			'processorKey' => $processorKey,
		);
		
	}
	
	/**
	 * This method maps all annotations into a map with three dimensions. For the 
	 * default fallback a key '*' is added. 
	 * 
	 * The first dimension is the payment method name. The second dimension is the
	 * authorization method. The third dimension is the processor.
	 * 
	 * @return array
	 */
	final protected function getClassMap() {
		
		if ($this->classMap === null) {
			$this->classMap = array();
			$annotations = $this->getAnnotationMap();
			
			foreach ($annotations as $className => $annotation) {
				
				if (!($annotation instanceof Customweb_Payment_Annotation_Method)) {
					throw new Customweb_Core_Exception_CastException('Customweb_Payment_Annotation_Method');
				}
				
				$paymentMethods = array('*');
				if (is_array($annotation->getPaymentMethods()) && count($annotation->getPaymentMethods()) > 0) {
					$paymentMethods = $annotation->getPaymentMethods();
				}

				$authorizationMethods = array('*');
				if (is_array($annotation->getAuthorizationMethods()) && count($annotation->getAuthorizationMethods()) > 0) {
					$authorizationMethods = $annotation->getAuthorizationMethods();
				}

				$processors = array('*');
				if (is_array($annotation->getProcessors()) && count($annotation->getProcessors()) > 0) {
					$processors = $annotation->getProcessors();
				}
				
				foreach ($paymentMethods as $paymentMethod) {
					foreach ($authorizationMethods as $authorizationMethod) {
						foreach ($processors as $processor) {
							if (!isset($this->classMap[$paymentMethod]) || !is_array($this->classMap[$paymentMethod])) {
								$this->classMap[$paymentMethod] = array();
							}
							if (!isset($this->classMap[$paymentMethod][$authorizationMethod]) || !is_array($this->classMap[$paymentMethod][$authorizationMethod])) {
								$this->classMap[$paymentMethod][$authorizationMethod] = array();
							}
							$this->classMap[$paymentMethod][$authorizationMethod][$processor] = $className;
						}
					}
				}
			}
		}
		
		return $this->classMap;
	}
	
	/**
	 * Returns a list of payment methods found in the packages.
	 * 
	 * @return Customweb_Payment_Annotation_Method[]
	 */
	final protected function getAnnotationMap() {
		if ($this->methodAnnotations === null) {
			$this->methodAnnotations = array();
			$scanner = new Customweb_Annotation_Scanner();
			
			$packages = $this->getMethodPackages();
			if (!is_array($packages)) {
				$packages = array($packages);
			}
			
			$annotations = $scanner->find(
					'Customweb_Payment_Annotation_Method',
					$packages
			);
				
			foreach ($annotations as $className => $annotation) {
				if ($annotation instanceof Customweb_Payment_Annotation_Method) {
					$this->methodAnnotations[$className] = $annotation;
				}
			}
		}
		return $this->methodAnnotations;
	}
	
	
}