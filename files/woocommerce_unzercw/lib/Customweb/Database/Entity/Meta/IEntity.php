<?php 



interface Customweb_Database_Entity_Meta_IEntity {

	/**
	 * @return Customweb_Database_Entity_Meta_IColumn[]
	 */
	public function getColumns();

	public function setColumns(array $columns);
	
	public function addColumn(Customweb_Database_Entity_Meta_IColumn $column);

	public function getTableName();

	public function setTableName($tableName);

	/**
	 * @return Customweb_Database_Entity_Meta_IIndex[]
	 */
	public function getIndices();

	public function setIndices(array $indices);
	
	public function addIndex(Customweb_Database_Entity_Meta_IIndex $index);
	
	public function getPrimaryKeyColumnName();
		
	public function setPrimaryKeyColumnName($primaryKeyColumnName);
	
	public function getVersionColumnName();
	
	public function setVersionColumnName($versionColumnName);
	
	/**
	 * @return Customweb_Database_Entity_Meta_IFilter[]
	 */
	public function getFilters();
	
	public function addFilter(Customweb_Database_Entity_Meta_IFilter $filter);
	
	public function setFilters(array $filters);
	
}