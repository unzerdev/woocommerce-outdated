<?php

require_once 'Customweb/Annotation/Parser/ParallelMatcher.php';

class Customweb_Annotation_Parser_AnnotationValueMatcher extends Customweb_Annotation_Parser_ParallelMatcher {

	protected function build(){
		require_once 'Customweb/Annotation/Parser/AnnotationStaticConstantMatcher.php';
		require_once 'Customweb/Annotation/Parser/AnnotationArrayMatcher.php';
		require_once 'Customweb/Annotation/Parser/AnnotationNumberMatcher.php';
		require_once 'Customweb/Annotation/Parser/AnnotationStringMatcher.php';
		require_once 'Customweb/Annotation/Parser/ConstantMatcher.php';
		require_once 'Customweb/Annotation/Parser/NestedAnnotationMatcher.php';
		
		$this->add(new Customweb_Annotation_Parser_ConstantMatcher('true', true));
		$this->add(new Customweb_Annotation_Parser_ConstantMatcher('false', false));
		$this->add(new Customweb_Annotation_Parser_ConstantMatcher('TRUE', true));
		$this->add(new Customweb_Annotation_Parser_ConstantMatcher('FALSE', false));
		$this->add(new Customweb_Annotation_Parser_ConstantMatcher('NULL', null));
		$this->add(new Customweb_Annotation_Parser_ConstantMatcher('null', null));
		$this->add(new Customweb_Annotation_Parser_AnnotationStringMatcher());
		$this->add(new Customweb_Annotation_Parser_AnnotationNumberMatcher());
		$this->add(new Customweb_Annotation_Parser_AnnotationArrayMatcher());
		$this->add(new Customweb_Annotation_Parser_AnnotationStaticConstantMatcher());
		$this->add(new Customweb_Annotation_Parser_NestedAnnotationMatcher());
	}
}