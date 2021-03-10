<?php 


interface Customweb_Annotation_IAnnotationReflector {

	/**
	 * Returns true, when the given annotation (the class name of the annotation) exists on
	 * the given reflection item.
	 * 
	 * @param string $class
	 * @return true
	 */
	public function hasAnnotation($class);
	
	/**
	 * Returns the annotation instance of the given annotation class name for the current
	 * reflection item.
	 * 
	 * @param string $annotation
	 * @return Customweb_IAnnotation
	 */
	public function getAnnotation($annotation);
	
	/**
	 * Returns all annotations present on the given reflection item.
	 * 
	 * @return Customweb_IAnnotation[]
	 */
	public function getAnnotations();
	
	/**
	 * Returns all annotations present on the given reflection item
	 * restricted by the given restriction.
	 *
	 * @return Customweb_IAnnotation[]
	 */
	public function getAllAnnotations($restriction = false);
	
	
}