<?php 

require_once 'Customweb/Database/Entity/Meta/IColumnType.php';


class Customweb_Database_Entity_Meta_ColumnType_DateTime implements Customweb_Database_Entity_Meta_IColumnType {
	
	public function getName() {
		return 'datetime';
	}
	
	public function getColumnSchema(Customweb_Database_Entity_Meta_IColumn $column) {
		return $column->getColumnName() . ' datetime ' . $column->getDefault();
	}

	public function unpack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		return new DateTime($value);
	}

	public function pack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		if ($value instanceof DateTime) {
			return $driver->quote($value->format('Y-m-d H:i:s'));
		}
		else {
			return $value;
		}
	}
}