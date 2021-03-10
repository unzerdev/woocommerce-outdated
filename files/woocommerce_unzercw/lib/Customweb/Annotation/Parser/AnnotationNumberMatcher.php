<?php

require_once 'Customweb/Annotation/Parser/RegexMatcher.php';


class Customweb_Annotation_Parser_AnnotationNumberMatcher extends Customweb_Annotation_Parser_RegexMatcher {

	public function __construct(){
		parent::__construct("-?[0-9]*\.?[0-9]*");
	}

	protected function process($matches){
		$isFloat = strpos($matches[0], '.') !== false;
		
		return $isFloat ? (float) $matches[0] : (int) $matches[0];
	}
}