<?php

require_once 'Customweb/Annotation/Parser/RegexMatcher.php';


class Customweb_Annotation_Parser_AnnotationIntegerMatcher extends Customweb_Annotation_Parser_RegexMatcher {

	public function __construct(){
		parent::__construct("-?[0-9]*");
	}

	protected function process($matches){
		return (int) $matches[0];
	}
}