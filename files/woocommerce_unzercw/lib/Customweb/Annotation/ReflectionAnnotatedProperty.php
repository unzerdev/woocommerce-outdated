<?php

require_once 'Customweb/Annotation/IAnnotationReflector.php';
require_once 'Customweb/Annotation/AnnotationsBuilder.php';
require_once 'Customweb/Annotation/ReflectionAnnotatedClass.php';


class Customweb_Annotation_ReflectionAnnotatedProperty extends ReflectionProperty implements Customweb_Annotation_IAnnotationReflector
{
    private
        $annotations;

    public function __construct($class, $name)
    {
        parent::__construct($class, $name);
        
        $this->annotations = $this->createAnnotationBuilder()->build($this);
    }

    public function hasAnnotation($class)
    {
        return $this->annotations->hasAnnotation($class);
    }

    public function getAnnotation($annotation)
    {
        return $this->annotations->getAnnotation($annotation);
    }

    public function getAnnotations()
    {
        return $this->annotations->getAnnotations();
    }

    public function getAllAnnotations($restriction = false)
    {
        return $this->annotations->getAllAnnotations($restriction);
    }

    public function getDeclaringClass()
    {
        $class = parent::getDeclaringClass();
        
        return new Customweb_Annotation_ReflectionAnnotatedClass($class->getName());
    }

    public function getDeclaringClassName() {
    	return parent::getDeclaringClass()->getName();
    }
    
    protected function createAnnotationBuilder()
    {
        return new Customweb_Annotation_AnnotationsBuilder();
    }
}