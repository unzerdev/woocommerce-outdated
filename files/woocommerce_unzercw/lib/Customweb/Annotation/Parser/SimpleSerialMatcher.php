<?php

require_once 'Customweb/Annotation/Parser/SerialMatcher.php';


class Customweb_Annotation_Parser_SimpleSerialMatcher extends Customweb_Annotation_Parser_SerialMatcher {
	private $return_part_index;

	public function __construct($return_part_index = 0){
		$this->return_part_index = $return_part_index;
	}

	public function process($parts){
		return $parts[$this->return_part_index];
	}
}