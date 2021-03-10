<?php

require_once 'Customweb/Annotation/Parser/AnnotationValueMatcher.php';
require_once 'Customweb/Annotation/Parser/RegexMatcher.php';
require_once 'Customweb/Annotation/Parser/SerialMatcher.php';
require_once 'Customweb/Annotation/Parser/AnnotationKeyMatcher.php';


class Customweb_Annotation_Parser_AnnotationPairMatcher extends Customweb_Annotation_Parser_SerialMatcher {

	protected function build(){
		$this->add(new Customweb_Annotation_Parser_AnnotationKeyMatcher());
		$this->add(new Customweb_Annotation_Parser_RegexMatcher('\s*=\s*'));
		$this->add(new Customweb_Annotation_Parser_AnnotationValueMatcher());
	}

	protected function process($parts){
		return array(
			$parts[0] => $parts[2] 
		);
	}
}