<?php 

require_once 'Customweb/Database/Entity/Meta/IColumnType.php';


class Customweb_Database_Entity_Meta_ColumnType_Boolean implements Customweb_Database_Entity_Meta_IColumnType {
	
	public function getName() {
		return 'boolean';
	}
	
	public function getColumnSchema(Customweb_Database_Entity_Meta_IColumn $column) {
		return $column->getColumnName() . ' char (1) ' . $column->getDefault();
	}

	public function unpack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		if ($value == 'y') {
			return true;
		}
		else {
			return false;
		}
	}

	public function pack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		if ($value) {
			return $driver->quote('y');
		}
		else {
			return $driver->quote('n');
		}
	}
}