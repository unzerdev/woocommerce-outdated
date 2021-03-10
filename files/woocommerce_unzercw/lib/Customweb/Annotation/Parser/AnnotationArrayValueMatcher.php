<?php

require_once 'Customweb/Annotation/Parser/AnnotationValueInArrayMatcher.php';
require_once 'Customweb/Annotation/Parser/ParallelMatcher.php';
require_once 'Customweb/Annotation/Parser/AnnotationPairMatcher.php';


class Customweb_Annotation_Parser_AnnotationArrayValueMatcher extends Customweb_Annotation_Parser_ParallelMatcher {

	protected function build(){
		$this->add(new Customweb_Annotation_Parser_AnnotationValueInArrayMatcher());
		$this->add(new Customweb_Annotation_Parser_AnnotationPairMatcher());
	}
}
