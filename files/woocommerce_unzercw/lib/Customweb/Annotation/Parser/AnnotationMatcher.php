<?php

require_once 'Customweb/Annotation/Parser/RegexMatcher.php';
require_once 'Customweb/Annotation/Parser/AnnotationParametersMatcher.php';
require_once 'Customweb/Annotation/Parser/SerialMatcher.php';


class Customweb_Annotation_Parser_AnnotationMatcher extends Customweb_Annotation_Parser_SerialMatcher {

	protected function build(){
		$this->add(new Customweb_Annotation_Parser_RegexMatcher('@'));
		$this->add(new Customweb_Annotation_Parser_RegexMatcher('[A-Z][a-zA-Z0-9_\\\]*'));
		$this->add(new Customweb_Annotation_Parser_AnnotationParametersMatcher());
	}

	protected function process($results){
		return array(
			$results[1],
			$results[2] 
		);
	}
}
