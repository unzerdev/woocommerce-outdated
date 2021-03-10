<?php 


class Customweb_Database_Entity_Exception_EntityNotFoundException extends Exception {
	
	private $entityClassName;
	
	private $primaryKey;
	
	public function __construct($entityClassName, $primaryKey) {
		$this->entityClassName = $entityClassName;
		$this->primaryKey = $primaryKey;
		parent::__construct("Entity with class name '" . $entityClassName . "' and primary key '" . $primaryKey . "' was not found.");
	}

	public function getEntityClassName(){
		return $this->entityClassName;
	}

	public function getPrimaryKey(){
		return $this->primaryKey;
	}
	
}