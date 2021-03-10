<?php 

require_once 'Customweb/Database/Entity/Meta/IColumnType.php';


class Customweb_Database_Entity_Meta_ColumnType_Decimal implements Customweb_Database_Entity_Meta_IColumnType {

	public function getName() {
		return 'decimal';
	}
	
	public function getColumnSchema(Customweb_Database_Entity_Meta_IColumn $column) {
		return $column->getColumnName() . ' decimal (10,5) ' . $column->getDefault();
	}

	public function unpack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		return (float)$value;
	}

	public function pack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		return $value;
	}
}