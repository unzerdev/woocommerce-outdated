<?php

require_once 'Customweb/Annotation/Parser/AnnotationSingleQuotedStringMatcher.php';
require_once 'Customweb/Annotation/Parser/AnnotationDoubleQuotedStringMatcher.php';
require_once 'Customweb/Annotation/Parser/ParallelMatcher.php';


class Customweb_Annotation_Parser_AnnotationStringMatcher extends Customweb_Annotation_Parser_ParallelMatcher {

	protected function build(){
		$this->add(new Customweb_Annotation_Parser_AnnotationSingleQuotedStringMatcher());
		$this->add(new Customweb_Annotation_Parser_AnnotationDoubleQuotedStringMatcher());
	}
}