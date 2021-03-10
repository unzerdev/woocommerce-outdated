<?php

require_once 'Customweb/Annotation/Parser/AnnotationArrayValuesMatcher.php';
require_once 'Customweb/Annotation/Parser/RegexMatcher.php';
require_once 'Customweb/Annotation/Parser/SimpleSerialMatcher.php';
require_once 'Customweb/Annotation/Parser/AnnotationArrayValueMatcher.php';


class Customweb_Annotation_Parser_AnnotationMoreValuesMatcher extends Customweb_Annotation_Parser_SimpleSerialMatcher {

	protected function build(){
		$this->add(new Customweb_Annotation_Parser_AnnotationArrayValueMatcher());
		$this->add(new Customweb_Annotation_Parser_RegexMatcher('\s*,\s*'));
		$this->add(new Customweb_Annotation_Parser_AnnotationArrayValuesMatcher());
	}

	protected function match($string, &$value){
		$result = parent::match($string, $value);
		
		return $result;
	}

	public function process($parts){
		return array_merge($parts[0], $parts[2]);
	}
}