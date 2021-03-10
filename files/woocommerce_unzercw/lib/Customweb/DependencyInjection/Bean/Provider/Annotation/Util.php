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

require_once 'Customweb/DependencyInjection/Bean/Generic/DefaultDependency.php';
require_once 'Customweb/Annotation/ReflectionAnnotatedClass.php';
require_once 'Customweb/Core/Util/Class.php';
require_once 'Customweb/DependencyInjection/Bean/Generic.php';



final class Customweb_DependencyInjection_Bean_Provider_Annotation_Util {
	
	private function __construct() {
		
	}
	
	/**
	 * Creates a bean object. This object can be used to create an instance of the 
	 * class defined with this bean. 
	 * 
	 * @param string $beanId
	 * @param string $className
	 * @throws Exception
	 * @return Customweb_DependencyInjection_Bean_Generic
	 */
	public static function createBeanInstance($beanId, $className) {
		
		if (empty($beanId)) {
			$beanId = $className;
		}
		
		Customweb_Core_Util_Class::loadLibraryClassByName('Customweb_DependencyInjection_Bean_Provider_Annotation_Inject');
	
		$dependencies = array();
	
		Customweb_Core_Util_Class::loadLibraryClassByName($className);
		$reflector = new Customweb_Annotation_ReflectionAnnotatedClass($className);
	
		foreach ($reflector->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
			$annotations = $method->getAllAnnotations();
			if ($method->isConstructor() || $method->hasAnnotation('Customweb_DependencyInjection_Bean_Provider_Annotation_Inject')) {
	
				if ($method->isConstructor() && !$method->hasAnnotation('Customweb_DependencyInjection_Bean_Provider_Annotation_Inject')) {
					$injects = self::getInjectsFromMethod($method);
				}
				else {
					$annotation = $method->getAnnotation('Customweb_DependencyInjection_Bean_Provider_Annotation_Inject');
					/* @var $annotation Customweb_DependencyInjection_Bean_Provider_Annotation_Inject */
					$injects = $annotation->getInjects();
					if (!is_array($injects) || count($injects) <= 0) {
						$injects = self::getInjectsFromMethod($method);
					}
					elseif (count($injects) !== $method->getNumberOfParameters()) {
						throw new Exception("Invalid annotation 'Inject' on method '" . $method->getName() . "' on class '" . $className . "'. The number of inject arguments do not match the number of arguments.");
					}
				}
					
				$dependencies[] = new Customweb_DependencyInjection_Bean_Generic_DefaultDependency($method->getName(), $injects);
			}
				
		}
	
		return new Customweb_DependencyInjection_Bean_Generic($beanId, $className, $dependencies);
	}
	
	private static function getInjectsFromMethod(ReflectionMethod $method) {
		$injects = array();
		foreach ($method->getParameters() as $parameter) {
			/* @var $parameter ReflectionParameter */
			$parameterType = self::getClassName($parameter);
			if ($parameterType === null) {
				throw new Exception("You need to define the type of parameter '" . $parameter->getName() . "' on method '" . $method->getName() . "'.");
			}
			$injects[] = $parameterType;
		}
	
		return $injects;
	}
	
	private static function getClassName(ReflectionParameter $param) {
		preg_match('/\[\s\<\w+?>\s([\w]+)/s', $param->__toString(), $matches);
		return isset($matches[1]) ? $matches[1] : null;
	}
	
}