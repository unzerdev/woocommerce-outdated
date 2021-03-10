<?php 


class Customweb_Database_Entity_Exception_OptimisticLockingException extends Exception {
	
	private $entityClassName;
	
	private $primaryKey;
	
	public function __construct($entityClassName, $primaryKey) {
		$this->entityClassName = $entityClassName;
		$this->primaryKey = $primaryKey;
		parent::__construct("Optimistic locking failed for class name '" . $entityClassName . "' and primary key '" . $primaryKey . "'.");
	}

	public function getEntityClassName(){
		return $this->entityClassName;
	}

	public function getPrimaryKey(){
		return $this->primaryKey;
	}
	
}