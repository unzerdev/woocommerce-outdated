<?php

class Customweb_Payment_Exception_OptimisticLockingException extends Exception {
	private $primaryKey;

	public function __construct($primaryKey){
		$this->primaryKey = $primaryKey;
		parent::__construct('Optimistic locking failed for transaction ' . $primaryKey . '.');
	}

	public function getPrimaryKey(){
		return $this->primaryKey;
	}
}