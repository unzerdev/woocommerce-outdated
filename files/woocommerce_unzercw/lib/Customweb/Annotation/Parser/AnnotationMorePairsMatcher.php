<?php

require_once 'Customweb/Annotation/Parser/AnnotationHashMatcher.php';
require_once 'Customweb/Annotation/Parser/RegexMatcher.php';
require_once 'Customweb/Annotation/Parser/SerialMatcher.php';
require_once 'Customweb/Annotation/Parser/AnnotationPairMatcher.php';


class Customweb_Annotation_Parser_AnnotationMorePairsMatcher extends Customweb_Annotation_Parser_SerialMatcher {

	protected function build(){
		$this->add(new Customweb_Annotation_Parser_AnnotationPairMatcher());
		$this->add(new Customweb_Annotation_Parser_RegexMatcher('\s*,\s*'));
		$this->add(new Customweb_Annotation_Parser_AnnotationHashMatcher());
	}

	protected function match($string, &$value){
		$result = parent::match($string, $value);
		
		return $result;
	}

	public function process($parts){
		return array_merge($parts[0], $parts[2]);
	}
}