<?php

require_once 'Customweb/Annotation/Parser/ConstantMatcher.php';
require_once 'Customweb/Annotation/Parser/RegexMatcher.php';
require_once 'Customweb/Annotation/Parser/SimpleSerialMatcher.php';
require_once 'Customweb/Annotation/Parser/AnnotationValuesMatcher.php';
require_once 'Customweb/Annotation/Parser/ParallelMatcher.php';


class Customweb_Annotation_Parser_AnnotationParametersMatcher extends Customweb_Annotation_Parser_ParallelMatcher {

	protected function build(){
		$this->add(new Customweb_Annotation_Parser_ConstantMatcher('', array()));
		$this->add(new Customweb_Annotation_Parser_ConstantMatcher('\(\)', array()));
		$params_matcher = new Customweb_Annotation_Parser_SimpleSerialMatcher(1);
		$params_matcher->add(new Customweb_Annotation_Parser_RegexMatcher('\(\s*'));
		$params_matcher->add(new Customweb_Annotation_Parser_AnnotationValuesMatcher());
		$params_matcher->add(new Customweb_Annotation_Parser_RegexMatcher('\s*\)'));
		$this->add($params_matcher);
	}
}