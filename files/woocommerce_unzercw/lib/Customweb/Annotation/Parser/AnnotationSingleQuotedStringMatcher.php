<?php

require_once 'Customweb/Annotation/Parser/RegexMatcher.php';


class Customweb_Annotation_Parser_AnnotationSingleQuotedStringMatcher extends Customweb_Annotation_Parser_RegexMatcher {

	public function __construct(){
		parent::__construct("'([^']*)'");
	}

	protected function process($matches){
		return $matches[1];
	}
}