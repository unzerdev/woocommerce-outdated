<?php 



interface Customweb_Database_Entity_Meta_IColumnType {
	
	/**
	 * The name which identifies the type.
	 *
	 * @return string
	 */
	public function getName();
	
	/**
	 * This method returns the column definition used to create the column
	 * schema.
	 * 
	 * @return string
	 */
	public function getColumnSchema(Customweb_Database_Entity_Meta_IColumn $column);
	
	/**
	 * This method unpacks the given $value from the database to assign to the
	 * entity.
	 * 
	 * @param Customweb_Database_Entity_Meta_Column $column
	 * @param unknown $value
	 */
	public function unpack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver);
	
	/**
	 * This method packs the given $value for the given column to write it to 
	 * the datebase.
	 * 
	 * @param Customweb_Database_Entity_Meta_Column $column
	 * @param mixed $value
	 */
	public function pack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver);
	
	
	
}