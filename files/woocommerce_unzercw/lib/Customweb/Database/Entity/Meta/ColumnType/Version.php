<?php 

require_once 'Customweb/Database/Entity/Meta/IColumnType.php';


class Customweb_Database_Entity_Meta_ColumnType_Version implements Customweb_Database_Entity_Meta_IColumnType {

	public function getName() {
		return 'version';
	}
	
	public function getColumnSchema(Customweb_Database_Entity_Meta_IColumn $column) {
		return $column->getColumnName() . ' int NOT NULL';
	}

	public function unpack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		return $value;
	}

	public function pack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		return $value;
	}
}