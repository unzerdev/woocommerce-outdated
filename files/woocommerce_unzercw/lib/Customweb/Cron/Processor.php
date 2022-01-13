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

require_once 'Customweb/Cron/Annotation/Cron.php';
require_once 'Customweb/Util/System.php';
require_once 'Customweb/Core/String.php';
require_once 'Customweb/Annotation/Scanner.php';
require_once 'Customweb/Core/Util/Reflection.php';
require_once 'Customweb/DependencyInjection/Bean/Provider/Annotation/Util.php';
require_once 'Customweb/DependencyInjection/Container/Extendable.php';


/**
 * Implementation of a processor for cron annotations. 
 * 
 * The methods annotated with the cron annotation. The object is either
 * called statically or as an bean from the container.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Cron_Processor {
	
	private $container;
	
	/**
	 * @var array
	 */
	private $packages = array();
	
	private $startTime = null;
	
	public function __construct(Customweb_DependencyInjection_IContainer $container, $packages = array()) {
		$this->container = new Customweb_DependencyInjection_Container_Extendable($container);
		$this->packages = $packages;
	}
	
	/**
	 * Execute all cron jobs.
	 * 
	 * @throws Exception In case something went wrong.
	 */
	public function run() {
		$scanner = new Customweb_Annotation_Scanner();
		$annotations = $scanner->find('Customweb_Cron_Annotation_Cron', $this->packages);
		
		$approxFinalizeTime = 4;
		$maxExecutionTime = Customweb_Util_System::getMaxExecutionTime() - $approxFinalizeTime;
		$start = $this->getStartTime();
		$endTime = $start + $maxExecutionTime;
		
		foreach ($annotations as $identifier => $annotation) {
			if ($endTime < time()) {
				break;
			}
			if ($annotation instanceof Customweb_Cron_Annotation_Cron) {
				$parts = explode('::', $identifier, 2);
				$className = $parts[0];
				$methodName = $parts[1];
				$this->invoke($className, $methodName, $annotation);
			}
		}
	}
	
	protected function invoke($className, $methodName, Customweb_Cron_Annotation_Cron $annotation) {
		$reflector = new ReflectionClass($className);
		$method = $reflector->getMethod($methodName);
		
		$object = null;
		if (!$method->isStatic()) {
			$bean = Customweb_DependencyInjection_Bean_Provider_Annotation_Util::createBeanInstance($className, $className);
			$object = $bean->getInstance($this->getContainer());
		}
		$args = $this->resolveInvocationArguements($method);
		$method->invoke($object, $args);
	}
	
	protected function resolveInvocationArguements(ReflectionMethod $method) {
		$args = array();
	
		foreach ($method->getParameters() as $parameter) {
			$type = Customweb_Core_Util_Reflection::getParameterType($parameter);
			if ($type === null) {
				throw new Exception(Customweb_Core_String::_("Unable to invoke method @method because it contain a primitive type.")->format(array('@method' => $method->getName())));
			}
			$args[] = $this->getContainer()->getBean($type);
		}
	
		return $args;
	}
	
	protected function getContainer() {
		return $this->container;
	}
	
	/**
	 * Returns the start time of the PHP process.
	 *
	 * @return int
	 */
	protected function getStartTime() {
		if ($this->startTime === null) {
			if (isset($_SERVER['REQUEST_TIME'])) {
				$this->startTime =($_SERVER['REQUEST_TIME'] < time()) ? time() : $_SERVER['REQUEST_TIME'];
			}
			else {
				$this->startTime = time();
			}
		}
	
		return $this->startTime;
	}
	
}
