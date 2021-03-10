<?php

require_once 'Customweb/Annotation/Parser/RegexMatcher.php';


class Customweb_Annotation_Parser_ConstantMatcher extends Customweb_Annotation_Parser_RegexMatcher {
	private $constant;

	public function __construct($regex, $constant){
		parent::__construct($regex);
		
		$this->constant = $constant;
	}

	protected function process($matches){
		return $this->constant;
	}
}