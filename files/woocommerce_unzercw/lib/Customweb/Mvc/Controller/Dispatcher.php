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

require_once 'Customweb/Core/Http/IResponse.php';
require_once 'Customweb/Mvc/Controller/Annotation/Controller.php';
require_once 'Customweb/DependencyInjection/Container/Extendable.php';
require_once 'Customweb/Mvc/Controller/IDispatcher.php';
require_once 'Customweb/Core/Http/Response.php';
require_once 'Customweb/Mvc/Controller/Exception/ActionNotFoundException.php';
require_once 'Customweb/Core/String.php';
require_once 'Customweb/Annotation/Scanner.php';
require_once 'Customweb/Annotation/ReflectionAnnotatedClass.php';
require_once 'Customweb/Mvc/Controller/Annotation/Action.php';
require_once 'Customweb/Mvc/Controller/Exception/ActionArgumentScalarException.php';
require_once 'Customweb/DependencyInjection/Bean/Object.php';
require_once 'Customweb/Mvc/Controller/Exception/ActionArgumentNotResolvableException.php';
require_once 'Customweb/Mvc/Controller/Exception/ControllerNotFoundException.php';
require_once 'Customweb/DependencyInjection/Bean/Provider/Annotation/Util.php';
require_once 'Customweb/Core/Util/Class.php';
require_once 'Customweb/Core/Logger/Factory.php';


/**
 * This class handles a given request and dispatch the reqeust to the
 * corresponding controller.
 *
 * @author Thomas Hunziker
 *
 */
class Customweb_Mvc_Controller_Dispatcher implements Customweb_Mvc_Controller_IDispatcher
{

	/**
	 * @var Customweb_Core_ILogger
	 */
	private $logger;

	private static $showStackTrace = false;

	private $adapter = null;

	private $container = null;

	private $controllerPackages = null;

	private $controllers = null;

	private $actions = array();

	private $controllerInstances = array();

	public function __construct(Customweb_Mvc_Controller_IAdapter $adapter, Customweb_DependencyInjection_IContainer $container, array $controllerScanPackages) {
		$this->adapter = $adapter;
		$this->container = $container;
		$this->controllerPackages = $controllerScanPackages;
		$this->logger = Customweb_Core_Logger_Factory::getLogger(get_class());
	}

	public function dispatch(Customweb_Core_Http_IRequest $request) {
		try {
			$this->logger->logDebug("Dispatching message.", $request->toSendableString(false));
			$actionName = $this->getAdapter()->extractActionName($request);
			$controllerName = $this->getAdapter()->extractControllerName($request);
			return $this->invokeControllerAction($request, $controllerName, $actionName);
		}
		catch(Exception $e) {
			$this->logger->logException($e, $request);
			return $this->handleException($e);
		}
	}

	public function invokeControllerAction(Customweb_Core_Http_IRequest $request, $controllerName, $actionName) {
		$className = $this->getControllerClassName($controllerName);
		$methodName = $this->getActionMethodName($actionName, $className);

		$controllerObject = $this->instantiateController($className);

		$reflection = new ReflectionClass($className);
		$method = $reflection->getMethod($methodName);

		$container = $this->createActionInvocationContainer($request, $method, $controllerObject);
		$invocationArguments = $this->resolveInvocationArguements($method, $container);
		$result = $method->invokeArgs($controllerObject, $invocationArguments);
		$this->postProcessActionInvocation($controllerObject, $method, $invocationArguments, $container);
		return $this->handleActionResult($result, $controllerName, $actionName, $request);
	}

	/**
	 * This method process the action response.
	 *
	 * @param mixed $result
	 * @param string $controllerName
	 * @param string $actionName
	 * @throws Exception
	 */
	protected function handleActionResult($result, $controllerName, $actionName, Customweb_Core_Http_IRequest $request) {
		if ($result === null) {
			throw new Exception(Customweb_Core_String::_("Action '@action' on controller '@controller' does not return any result.")
					->format(array('@controller' => $controllerName, '@action' => $actionName)));
		}
		if (is_array($result)) {
			if (isset($result['controller'])) {
				$controllerName = $result['controller'];
			}
			if (!isset($result['action'])) {
				throw new Exception("If you provide a array as response of a action, you have to provde a 'action' key, which indicates the action to which the request is forwarded to.");
			}

			$actionName = $result['action'];
			return $this->invokeControllerAction($request, $controllerName, $actionName);
		}
		else if (is_string($result) && strpos($result, 'redirect:') === 0) {
			$result = $result;
			$url = substr($result, strlen('redirect:'));
			$response = new Customweb_Core_Http_Response();
			$response->appendHeader('Location: '. $url);
			return $response;
		}
		else if (is_string($result)) {
			$response = new Customweb_Core_Http_Response();
			$response->setBody($result);
			return $response;
		}
		else if ($result instanceof Customweb_Core_Http_IResponse) {
			return $result;
		}
		else {
			throw new Exception(Customweb_Core_String::_("Action '@action' on controller '@controller' does not return a valid result.")
					->format(array('@controller' => $controllerName, '@action' => $actionName)));
		}
	}

	/**
	 * Post process an action invocation. Sub classes may override this method to
	 * execute some actions after an action was invoked.
	 *
	 * @param object $controllerObject
	 * @param ReflectionMethod $method
	 * @param array $arguements
	 * @param Customweb_DependencyInjection_IContainer $container
	 */
	protected function postProcessActionInvocation($controllerObject, ReflectionMethod $method, array $arguements, Customweb_DependencyInjection_IContainer $container) {

	}

	protected function createActionInvocationContainer(Customweb_Core_Http_IRequest $request, ReflectionMethod $method, $controllerObject) {
		$container = new Customweb_DependencyInjection_Container_Extendable($this->getContainer());
		$container->addBean(new Customweb_DependencyInjection_Bean_Object($this->getAdapter()));
		$container->addBean(new Customweb_DependencyInjection_Bean_Object($request));
		$container->addBean(new Customweb_DependencyInjection_Bean_Object($this));
		return $container;
	}

	protected function handleException(Exception $e) {
		$response = new Customweb_Core_Http_Response();
		$response
			->appendBody($e->getMessage());
		if(self::$showStackTrace) {
			$response
				->appendBody('<br />')
				->appendBody('<pre>')
				->appendBody($e->getTraceAsString())
				->appendBody('</pre>');
		}
		return $response->setStatusCode(500)->setStatusMessage('Application Exception');
	}

	protected function resolveInvocationArguements(ReflectionMethod $method, Customweb_DependencyInjection_IContainer $container) {
		$args = array();

		foreach ($method->getParameters() as $parameter) {
			$type = self::getParameterType($parameter);
			if ($type === null) {
				throw new Customweb_Mvc_Controller_Exception_ActionArgumentScalarException($method->getName());
			}
			try {
				$args[] = $container->getBean($type);
			}
			catch(Customweb_DependencyInjection_Exception_BeanNotFoundException $e) {
				throw new Customweb_Mvc_Controller_Exception_ActionArgumentNotResolvableException($method->getName(), $type);
			}
		}

		return $args;
	}

	protected function instantiateController($className) {
		$key = strtolower($className);
		if (!isset($this->controllerInstances[$key])) {
			$container = new Customweb_DependencyInjection_Container_Extendable($this->getContainer());
			$bean = Customweb_DependencyInjection_Bean_Provider_Annotation_Util::createBeanInstance($className, $className);
			$container->addBean(new Customweb_DependencyInjection_Bean_Object($this->getAdapter()));
			$container->addBean(new Customweb_DependencyInjection_Bean_Object($this));
			$this->controllerInstances[$key] = $bean->getInstance($container);
		}

		return $this->controllerInstances[$key];
	}

	/**
	 * Resolves the class name for the given request object.
	 *
	 * @param Customweb_Core_Http_IRequest $request
	 * @throws Customweb_Mvc_Controller_Exception_ControllerNotFoundException
	 * @return string
	 */
	protected function getControllerClassName($controllerName) {
		$controllerName = strtolower($controllerName);
		$controllers = $this->getControllers();

		if (!isset($controllers[$controllerName])) {
			throw new Customweb_Mvc_Controller_Exception_ControllerNotFoundException($controllerName);
		}

		return $controllers[$controllerName];
	}

	/**
	 * Resolves the action method for the given request and controller class name.
	 *
	 * @param Customweb_Core_Http_IRequest $request
	 * @param string $controllerClassName
	 * @throws Customweb_Mvc_Controller_Exception_ActionNotFoundException
	 * @return string
	 */
	protected function getActionMethodName($actionName, $controllerClassName) {
		if ($actionName === null) {
			$actionName = 'index';
		}
		$actions = $this->getActions($controllerClassName);
		$actionName = strtolower($actionName);
		if (!isset($actions[$actionName])) {
			throw new Customweb_Mvc_Controller_Exception_ActionNotFoundException($actionName);
		}

		return $actions[$actionName];
	}

	/**
	 * Search the given package list for controllers. The method returns a map
	 * with the controller names as key and the class name as the value.
	 *
	 * @return array
	 */
	protected function getControllers() {
		if ($this->controllers === null) {
			$scanner = new Customweb_Annotation_Scanner();
			$annotations = $scanner->find('Customweb_Mvc_Controller_Annotation_Controller', $this->getControllerPackages());
			foreach ($annotations as $className => $annotation) {
				if ($annotation instanceof Customweb_Mvc_Controller_Annotation_Controller) {
					$controllerName = $annotation->getName();
					if (empty($controllerName)) {
						throw new Exception(Customweb_Core_String::_(
								"The class '@className' is annotated with Customweb_Mvc_Controller_Annotation_Controller. However it does not provide a controller name."
						)->format(array('@className' => $className)));
					}
					$this->controllers[strtolower($controllerName)] = $className;
				}
			}
		}

		return $this->controllers;
	}

	/**
	 * This method returns a map of actions on the given class. The key is the action name and
	 * the value is the method.
	 *
	 * @param string $controllerClassName Controller class name
	 * @return array
	 */
	protected function getActions($controllerClassName) {
		Customweb_Core_Util_Class::loadLibraryClassByName('Customweb_Mvc_Controller_Annotation_Action');
		$key = strtolower($controllerClassName);
		if (!isset($this->actions[$key])) {
			$this->actions[$key] = array();
			$reflector = new Customweb_Annotation_ReflectionAnnotatedClass($controllerClassName);
			foreach ($reflector->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
				if ($method->hasAnnotation('Customweb_Mvc_Controller_Annotation_Action')) {
					$annotation = $method->getAnnotation('Customweb_Mvc_Controller_Annotation_Action');
					if ($annotation instanceof Customweb_Mvc_Controller_Annotation_Action) {
						$actionName = $annotation->getName();
						if (empty($actionName)) {
							$actionName = $method->getName();
						}
						$this->actions[$key][$actionName] = $method->getName();
					}
				}
			}
		}
		return $this->actions[$key];
	}

	protected function getContainer(){
		return $this->container;
	}

	/**
	 * @return Customweb_Mvc_Controller_IAdapter
	 */
	protected function getAdapter() {
		return $this->adapter;
	}

	public function getControllerPackages(){
		return $this->controllerPackages;
	}

	public final static function getParameterType(ReflectionParameter $param) {
		preg_match('/\[\s\<\w+?>\s([\w]+)/s', $param->__toString(), $matches);
		return isset($matches[1]) ? $matches[1] : null;
	}
}