<?php

require_once 'Customweb/Annotation/Parser/RegexMatcher.php';


class Customweb_Annotation_Parser_AnnotationStaticConstantMatcher extends Customweb_Annotation_Parser_RegexMatcher {

	public function __construct(){
		parent::__construct('(\w+::\w+)');
	}

	protected function process($matches){
		$name = $matches[1];
		
		if (! defined($name)) {
			throw new Exception("Constant '$name' used in annotation was not defined.");
		}
		
		return constant($name);
	}
}