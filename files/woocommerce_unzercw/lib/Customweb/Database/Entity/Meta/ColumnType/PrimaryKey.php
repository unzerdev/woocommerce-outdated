<?php 

require_once 'Customweb/Database/Entity/Meta/IColumnType.php';


class Customweb_Database_Entity_Meta_ColumnType_PrimaryKey implements Customweb_Database_Entity_Meta_IColumnType {

	public function getName() {
		return 'primaryKey';
	}
	
	public function getColumnSchema(Customweb_Database_Entity_Meta_IColumn $column) {
		return $column->getColumnName() . ' bigint(20) NOT NULL AUTO_INCREMENT';
	}

	public function unpack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		return $value;
	}

	public function pack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		return $value;
	}
}