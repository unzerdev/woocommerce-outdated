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

require_once 'Customweb/Annotation/ReflectionAnnotatedClass.php';
require_once 'Customweb/DependencyInjection/Bean/Object.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Payment/Endpoint/Annotation/ExtractionMethod.php';
require_once 'Customweb/Core/Util/Class.php';
require_once 'Customweb/Mvc/Controller/Dispatcher.php';


/**
 * This sub class of the controller dispatcher allows the loading and injection
 * of transactions into the action method.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_Endpoint_Dispatcher extends Customweb_Mvc_Controller_Dispatcher {
	
	/**
	 * @var Customweb_Payment_ITransactionHandler
	 */
	private $transactionHandler = null;
	
	/**
	 * Indicates whether a database transaction is currently running and 
	 * controlled by the dispatcher.
	 * 
	 * @var boolean
	 */
	private $databaseTransactionActive = false;
	
	public function __construct(Customweb_Payment_Endpoint_IAdapter $adapter, Customweb_DependencyInjection_IContainer $container, array $controllerScanPackages) {
		parent::__construct($adapter, $container, $controllerScanPackages);
		
		Customweb_Core_Util_Class::loadLibraryClassByName('Customweb_Payment_Endpoint_Annotation_ExtractionMethod');
		
		if (!$container->hasBean('Customweb_Payment_ITransactionHandler')) {
			throw new Exception("The dependency container does not contain a bean with type 'Customweb_Payment_ITransactionHandler'.");
		}
		
		$this->transactionHandler = $container->getBean('Customweb_Payment_ITransactionHandler');
	}
	
	public function invokeControllerAction(Customweb_Core_Http_IRequest $request, $controllerName, $actionName) {
		try {
			$rs = parent::invokeControllerAction($request, $controllerName, $actionName);
			if ($this->databaseTransactionActive) {
				$this->getTransactionHandler()->commitTransaction();
				$this->databaseTransactionActive = false;
			}
			return $rs;
		}
		catch(Exception $e) {
			if ($this->databaseTransactionActive) {
				$this->getTransactionHandler()->rollbackTransaction();
				$this->databaseTransactionActive = false;
			}
			throw $e;
		}
	}
	
	protected function postProcessActionInvocation($controllerObject, ReflectionMethod $method, array $arguements, Customweb_DependencyInjection_IContainer $container) {
		if ($container->hasBean('Customweb_Payment_Authorization_ITransaction')) {
			$transaction = $container->getBean('Customweb_Payment_Authorization_ITransaction');
			$this->getTransactionHandler()->persistTransactionObject($transaction);
		}
	}
		
	protected function createActionInvocationContainer(Customweb_Core_Http_IRequest $request, ReflectionMethod $method, $controllerObject) {
		$container = parent::createActionInvocationContainer($request, $method, $controllerObject);
		
		if ($this->isActionMethodContainParameterTransaction($method)) {
			$controllerReflection = new Customweb_Annotation_ReflectionAnnotatedClass($controllerObject);
			
			$ids = null;
			foreach ($controllerReflection->getMethods(ReflectionMethod::IS_PUBLIC) as $controllerMethod) {
				if ($controllerMethod->hasAnnotation('Customweb_Payment_Endpoint_Annotation_ExtractionMethod')) {
					$ids = $controllerMethod->invoke($controllerObject, $request);
					break;
				}
			}
	
			if (is_array($ids)) {
				if (!isset($ids['id'])) {
					throw new Exception("The extraction method does not return an array with an index 'id'.");
				}
				if (!isset($ids['key'])) {
					throw new Exception("The extraction method does not return an array with an index 'key'.");
				}
				
				$transaction = null;
				if ($ids['key'] == Customweb_Payment_Endpoint_Annotation_ExtractionMethod::PAYMENT_ID_KEY) {
					$this->getTransactionHandler()->beginTransaction();
					$this->databaseTransactionActive = true;
					$transaction = $this->getTransactionHandler()->findTransactionByPaymentId($ids['id']);
				}
				else if($ids['key'] == Customweb_Payment_Endpoint_Annotation_ExtractionMethod::TRANSACTION_ID_KEY) {
					$this->getTransactionHandler()->beginTransaction();
					$this->databaseTransactionActive = true;
					$transaction = $this->getTransactionHandler()->findTransactionByTransactionId($ids['id']);
				}
				else if($ids['key'] == Customweb_Payment_Endpoint_Annotation_ExtractionMethod::EXTERNAL_TRANSACTION_ID_KEY) {
					$this->getTransactionHandler()->beginTransaction();
					$this->databaseTransactionActive = true;
					$transaction = $this->getTransactionHandler()->findTransactionByTransactionExternalId($ids['id']);
				}
				else {
					throw new Exception("Invalid value for 'key' provided.");
				}
				$container->addBean(new Customweb_DependencyInjection_Bean_Object($transaction));
			}
			else {
				throw new Exception(Customweb_I18n_Translation::__(
					"The controller class '@controller' does not provide any method with annotation 'Customweb_Payment_Endpoint_Annotation_ExtractionMethod' and valid output.", 
					array('@controller' => get_class($controllerObject))
				));
			}
		}
		
		return $container;
	}
	
	
	protected function isActionMethodContainParameterTransaction(ReflectionMethod $method) {
		foreach ($method->getParameters() as $parameter) {
			$type = self::getParameterType($parameter);
			$tpyes = Customweb_Core_Util_Class::getAllTypes($type);
			if (in_array('Customweb_Payment_Authorization_ITransaction', $tpyes)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @return Customweb_Payment_ITransactionHandler
	 */
	protected function getTransactionHandler(){
		return $this->transactionHandler;
	}
	
	
	
	
}