<?php 

require_once 'Customweb/Database/Entity/Meta/IColumn.php';

class Customweb_Database_Entity_Meta_Column implements Customweb_Database_Entity_Meta_IColumn {
	
	private $columnName = null;
	
	private $columnType = null;
	
	private $default = null;
	
	private $entityMethodName = null;
	
	private $entityPropertyName = null;
	
	private $size = null;
	
	public function __construct() {
	}

	public function setColumnName($columnName){
		$this->columnName = $columnName;
		return $this;
	}

	public function setColumnType(Customweb_Database_Entity_Meta_IColumnType $columnType){
		$this->columnType = $columnType;
		return $this;
	}

	public function setDefault($default){
		$this->default = $default;
		return $this;
	}
	
	public function setSize($size) {
		$this->size = $size;
		return $this;
	}
	
	public function getSize() {
		return $this->size;
	}

	public function getColumnName(){
		return $this->columnName;
	}

	public function getColumnType(){
		return $this->columnType;
	}

	public function getDefault(){
		return $this->default;
	}
	
	public function getEntityMethodName() {
		return $this->entityMethodName;
	}
	
	public function getEntityPropertyName() {
		return $this->entityPropertyName;
	}

	public function setEntityMethodName($entityMethodName){
		$this->entityMethodName = $entityMethodName;
		return $this;
	}

	public function setEntityPropertyName($entityProperyName){
		$this->entityPropertyName = $entityProperyName;
		return $this;
	}
	
	

}