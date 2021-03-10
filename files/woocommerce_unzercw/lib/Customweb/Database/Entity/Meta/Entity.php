<?php 

require_once 'Customweb/Database/Entity/Meta/IEntity.php';


class Customweb_Database_Entity_Meta_Entity implements Customweb_Database_Entity_Meta_IEntity {
	
	private $columns = array();
	
	private $primaryKeyColumnName = null;
	
	private $versionColumnName = null;
	
	private $tableName = null;
	
	private $indices = array();
	
	private $filters = array();
	
	public function __construct() {
	}

	public function getColumns(){
		return $this->columns;
	}

	public function setColumns(array $columns){
		$this->columns = $columns;
		return $this;
	}

	public function getTableName(){
		return $this->tableName;
	}

	public function setTableName($tableName){
		$this->tableName = $tableName;
		return $this;
	}

	public function getIndices(){
		return $this->indices;
	}

	public function setIndices(array $indices){
		$this->indices = $indices;
		return $this;
	}
	
	public function addColumn(Customweb_Database_Entity_Meta_IColumn $column) {
		$this->columns[$column->getColumnName()] = $column;
		return $this;
	}

	public function addIndex(Customweb_Database_Entity_Meta_IIndex $index) {
		$this->indices[$index->getName()] = $index;
		return $this;
	}

	public function getPrimaryKeyColumnName(){
		return $this->primaryKeyColumnName;
	}

	public function setPrimaryKeyColumnName($primaryKeyColumnName){
		$this->primaryKeyColumnName = $primaryKeyColumnName;
		return $this;
	}

	public function getVersionColumnName() {
		return $this->versionColumnName;
	}
	
	public function setVersionColumnName($versionColumnName){
		$this->versionColumnName = $versionColumnName;
		return $this;
	}
	
	public function getFilters(){
		return $this->filters;
	}
	
	public function addFilter(Customweb_Database_Entity_Meta_IFilter $filter) {
		$this->filters[$filter->getName()] = $filter;
		return $this;
	}

	public function setFilters(array $filters){
		$this->filters = $filters;
		return $this;
	}
	
	
	
	

}