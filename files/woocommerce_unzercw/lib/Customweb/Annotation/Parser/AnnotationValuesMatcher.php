<?php

require_once 'Customweb/Annotation/Parser/AnnotationHashMatcher.php';
require_once 'Customweb/Annotation/Parser/ParallelMatcher.php';
require_once 'Customweb/Annotation/Parser/AnnotationTopValueMatcher.php';


class Customweb_Annotation_Parser_AnnotationValuesMatcher extends Customweb_Annotation_Parser_ParallelMatcher {

	protected function build(){
		$this->add(new Customweb_Annotation_Parser_AnnotationTopValueMatcher());
		$this->add(new Customweb_Annotation_Parser_AnnotationHashMatcher());
	}
}