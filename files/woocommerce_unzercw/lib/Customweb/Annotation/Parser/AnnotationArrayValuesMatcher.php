<?php

require_once 'Customweb/Annotation/Parser/AnnotationMoreValuesMatcher.php';
require_once 'Customweb/Annotation/Parser/ParallelMatcher.php';
require_once 'Customweb/Annotation/Parser/AnnotationArrayValueMatcher.php';


class Customweb_Annotation_Parser_AnnotationArrayValuesMatcher extends Customweb_Annotation_Parser_ParallelMatcher {

	protected function build(){
		$this->add(new Customweb_Annotation_Parser_AnnotationArrayValueMatcher());
		$this->add(new Customweb_Annotation_Parser_AnnotationMoreValuesMatcher());
	}
}
