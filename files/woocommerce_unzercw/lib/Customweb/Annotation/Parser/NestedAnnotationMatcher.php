<?php

require_once 'Customweb/Annotation/Parser/AnnotationMatcher.php';
require_once 'Customweb/Annotation/Cache/Annotation.php';


class Customweb_Annotation_Parser_NestedAnnotationMatcher extends Customweb_Annotation_Parser_AnnotationMatcher {

	protected function process($result){
		return new Customweb_Annotation_Cache_Annotation($result[1], $result[2]);

	}
}