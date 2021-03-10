<?php 



interface Customweb_Database_Entity_Meta_IColumn {
	
	/**
	 * @return string
	 */
	public function getColumnName();
	
	/**
	 * @return string
	 */
	public function getDefault();
	
	/**
	 * @return Customweb_Database_Entity_Meta_IColumnType
	 */
	public function getColumnType();
	
	/**
	 * @return string
	 */
	public function getSize();
	
	/**
	 * In case getter and setter method are used to access the 
	 * column value on the entity this method returns the name of 
	 * the method without 'set' and 'get'.
	 * 
	 * @return string | null
	 */
	public function getEntityMethodName();
	
	/**
	 * In case a property is used to access the value on the entity,
	 * this method returns the property name.
	 *
	 * @return string | null
	 */
	public function getEntityPropertyName();
	
}