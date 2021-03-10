<?php

require_once 'Customweb/Annotation/Parser/ParallelMatcher.php';
require_once 'Customweb/Annotation/Parser/AnnotationMorePairsMatcher.php';
require_once 'Customweb/Annotation/Parser/AnnotationPairMatcher.php';


class Customweb_Annotation_Parser_AnnotationHashMatcher extends Customweb_Annotation_Parser_ParallelMatcher {

	protected function build(){
		$this->add(new Customweb_Annotation_Parser_AnnotationPairMatcher());
		$this->add(new Customweb_Annotation_Parser_AnnotationMorePairsMatcher());
	}
}