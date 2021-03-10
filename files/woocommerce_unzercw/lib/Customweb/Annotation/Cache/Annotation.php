<?php 

class Customweb_Annotation_Cache_Annotation {
	
	/**
	 * @var string
	 */
	private $name;
	
	/**
	 * @var array
	 */
	private $parameters = array();
	
	public function __construct($name, $parameters) {
		$this->name = $name;
		$this->parameters = $parameters;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getParameters() {
		return $this->parameters;
	}
	
	
}