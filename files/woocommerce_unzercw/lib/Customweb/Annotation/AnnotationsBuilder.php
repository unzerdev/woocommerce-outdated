<?php

require_once 'Customweb/Annotation/AnnotationsCollection.php';
require_once 'Customweb/Annotation/Util.php';
require_once 'Customweb/Core/String.php';
require_once 'Customweb/Core/Util/Class.php';
require_once 'Customweb/Annotation/Cache/Reader.php';
require_once 'Customweb/Annotation/Cache/Annotation.php';


class Customweb_Annotation_AnnotationsBuilder {
	private static $cache = array();

	public function build($targetReflection){
		$data = $this->parse($targetReflection);
		$annotations = array();
		foreach ($data as $cacheInstance) {
			$annotation = $this->instantiateAnnotation($cacheInstance, $targetReflection);
			if ($annotation !== false) {
				$annotations[get_class($annotation)][] = $annotation;
			}
		}
		
		return new Customweb_Annotation_AnnotationsCollection($annotations);
	}
	
	private function instanciateNestedAnnotations($parameters) {
		$rs = array();
		
		foreach ($parameters as $key => $value) {
			if ($value instanceof Customweb_Annotation_Cache_Annotation) {
				$rs[$key] = $this->instantiateAnnotation($value);
			}
			else if (is_array($value)) {
				$rs[$key] = $this->instanciateNestedAnnotations($value);
			}
			else {
				$rs[$key] = $value;
			}
		}
		
		return $rs;
	}
	
	public function handleInstanciationErrors($errno, $errstr, $errfile, $errline) {
		throw new Exception($errstr);
	}
	
	public function instantiateAnnotation(Customweb_Annotation_Cache_Annotation $cacheInstance, $targetReflection = false){
		
		$class = Customweb_Annotation_Util::resolveClassName($cacheInstance->getName());
		$parameters = $this->instanciateNestedAnnotations($cacheInstance->getParameters());
		if (Customweb_Core_Util_Class::isClassLoaded($class) && ! Customweb_Annotation_Util::ignores($class)) {
			$annotationReflection = new ReflectionClass($class);
			$instance = $annotationReflection->newInstance();
				
			if (method_exists($instance, 'setData')) {
				$instance->setData($parameters);
			} else {
				set_error_handler( array( $this, 'handleInstanciationErrors' ) );
				try {
					foreach ($parameters as $propertyName => $propertyValue) {
						$methodName = 'set' . $propertyName;
						if (method_exists($instance, $methodName)) {
							$instance->$methodName($propertyValue);
						} elseif (property_exists($instance, $propertyName)) {
							$instance->{$propertyName} = $propertyValue;
						} else {
							throw new Exception(Customweb_Core_String::_("Property @property could not be set on annotation class @class")->format(array('@class' => $class, '@property' => $propertyName)));
						}
					}
				} catch (Exception $e) {
					restore_error_handler();
					throw $e;
				}
				restore_error_handler();
			}
				
			if (method_exists($instance, 'checkConstraints')) {
				$instance->checkConstraints($targetReflection);
			}
				
			return $instance;
		}
		return false;
	}
	
	
	/**
	 * 
	 * @param Reflector $reflection
	 * @return Customweb_Annotation_Cache_Annotation[]
	 */
	private function parse(Reflector $reflection){
		$key = Customweb_Annotation_Util::createName($reflection);
		
		if (! isset(self::$cache[$key])) {
			$data = Customweb_Annotation_Cache_Reader::getAnnotationsByTarget($reflection);
			self::$cache[$key] = $data;
		}
		
		return self::$cache[$key];
	}

	protected function getDocComment($reflection){
		return Customweb_Annotation_Util::getDocComment($reflection);
	}

	public static function clearCache(){
		self::$cache = array();
	}
}
