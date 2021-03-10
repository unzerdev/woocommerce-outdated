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
require_once 'Customweb/Annotation/IAnnotationReflector.php';
require_once 'Customweb/Core/String.php';
require_once 'Customweb/Annotation/ReflectionAnnotatedClass.php';
require_once 'Customweb/Annotation/ReflectionAnnotatedMethod.php';
require_once 'Customweb/Annotation/ReflectionAnnotatedProperty.php';
require_once 'Customweb/Core/Util/String.php';


/**
 * This class allows to access a property unified (over getter, setter or the property itself). This is 
 * useful when a property can be annotated on the setter, getter or the property, but the access to the 
 * property should be transparent.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Annotation_UnifiedPropertyReflector implements Customweb_Annotation_IAnnotationReflector{
	
	/**
	 * @var Customweb_Annotation_ReflectionAnnotatedMethod
	 */
	private $getMethodReflector;
	
	/**
	 * @var Customweb_Annotation_ReflectionAnnotatedMethod
	 */
	private $setMethodReflector;

	/**
	 * @var Customweb_Annotation_ReflectionAnnotatedProperty
	 */
	private $propertyReflector;
	
	/**
	 * @var string
	 */
	private $name;
	
	/**
	 * @var string
	 */
	private $className;
	
	public function __construct($className, $name) {
		$classReflector = new Customweb_Annotation_ReflectionAnnotatedClass($className);
		$this->name = $name;
		$this->className = $className;

		// TODO: Make hasMethod etc. also working with parant classes.
		
		if ($classReflector->hasMethod('get' . Customweb_Core_Util_String::ucFirst($name))) {
			$this->getMethodReflector = new Customweb_Annotation_ReflectionAnnotatedMethod($className, 'get' . Customweb_Core_Util_String::ucFirst($name));
		}

		if ($classReflector->hasMethod('set' . Customweb_Core_Util_String::ucFirst($name))) {
			$this->setMethodReflector = new Customweb_Annotation_ReflectionAnnotatedMethod($className, 'set' . Customweb_Core_Util_String::ucFirst($name));
		}

		if ($classReflector->hasProperty($name)) {
			$this->propertyReflector = new Customweb_Annotation_ReflectionAnnotatedProperty($className, $name);
		}
	}
	

	public function getValue($object) {
		if ($this->propertyReflector !== null && $this->propertyReflector->isPublic()) {
			return $object->{$this->getName()};
		}
		else if ($this->getMethodReflector !== null && $this->getMethodReflector->isPublic()) {
			return $this->getMethodReflector->invoke($object);
		}
		else {
			throw new Exception(Customweb_Core_String::_("Unable to access the property '@property' on '@class'.")->format(array('@property' => $this->getName(), '@class' => $this->getClassName())));
		}
	}
	
	public function setValue($object, $value) {
		if ($this->propertyReflector !== null && $this->propertyReflector->isPublic()) {
			$object->{$this->getName()} = $value;
		}
		else if ($this->setMethodReflector !== null && $this->setMethodReflector->isPublic()) {
			$this->setMethodReflector->invoke($object, $value);
		}
		else {
			throw new Exception(Customweb_Core_String::_("Unable to set the property '@property' on '@class'.")->format(array('@property' => $this->getName(), '@class' => $this->getClassName())));
		}
	}
	
	/**
	 * Returns the property name.
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Returns the class name of the property.
	 * 
	 * @return string
	 */
	public function getClassName() {
		return $this->className;
	}
	
	public function hasAnnotation($class) {
		if ($this->getPropertyReflector() !== null && $this->getPropertyReflector()->hasAnnotation($class)) {
			return true;
		}
		else if ($this->getGetMethodReflector() !== null && $this->getGetMethodReflector()->hasAnnotation($class)) {
			return true;
		}
		else if ($this->getSetMethodReflector() !== null && $this->getSetMethodReflector()->hasAnnotation($class)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public function getAnnotation($annotation) {
		if ($this->getPropertyReflector() !== null && $this->getPropertyReflector()->hasAnnotation($annotation)) {
			return $this->getPropertyReflector()->getAnnotation($annotation);
		}
		else if ($this->getGetMethodReflector() !== null && $this->getGetMethodReflector()->hasAnnotation($annotation)) {
			return $this->getGetMethodReflector()->getAnnotation($annotation);
		}
		else if ($this->getSetMethodReflector() !== null && $this->getSetMethodReflector()->hasAnnotation($annotation)) {
			return $this->getSetMethodReflector()->getAnnotation($annotation);
		}
		else {
			return false;
		}
	}
	
	public function getAnnotations() {
		$annotations = array();
		if ($this->getPropertyReflector() !== null) {
			$annotations = array_merge($annotations, $this->getPropertyReflector()->getAnnotations());
		}
		else if ($this->getGetMethodReflector() !== null) {
			$annotations = array_merge($annotations, $this->getGetMethodReflector()->getAnnotations());
		}
		else if ($this->getSetMethodReflector() !== null) {
			$annotations = array_merge($annotations, $this->getSetMethodReflector()->getAnnotations());
		}
		return $annotations;
	}
	
	public function getAllAnnotations($restriction = false) {
		$annotations = array();
		if ($this->getPropertyReflector() !== null) {
			$annotations = array_merge($annotations, $this->getPropertyReflector()->getAllAnnotations($restriction));
		}
		else if ($this->getGetMethodReflector() !== null) {
			$annotations = array_merge($annotations, $this->getGetMethodReflector()->getAllAnnotations($restriction));
		}
		else if ($this->getSetMethodReflector() !== null) {
			$annotations = array_merge($annotations, $this->getSetMethodReflector()->getAllAnnotations($restriction));
		}
		return $annotations;
	}
	
	protected function getGetMethodReflector(){
		return $this->getMethodReflector;
	}

	protected function getSetMethodReflector(){
		return $this->setMethodReflector;
	}

	protected function getPropertyReflector(){
		return $this->propertyReflector;
	}
}