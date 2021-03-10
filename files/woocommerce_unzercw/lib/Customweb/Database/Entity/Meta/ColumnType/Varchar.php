<?php 

require_once 'Customweb/Database/Entity/Meta/IColumnType.php';


class Customweb_Database_Entity_Meta_ColumnType_Varchar implements Customweb_Database_Entity_Meta_IColumnType {
	
	public function getName() {
		return 'varchar';
	}
	
	public function getColumnSchema(Customweb_Database_Entity_Meta_IColumn $column) {
		
		$size = 255;
		if ($column->getSize() !== null && $column->getSize() > 0) {
			$size = $column->getSize();
		}
		
		return $column->getColumnName() . ' varchar (' . $size . ') ' . $column->getDefault();
	}

	public function unpack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		return $value;
	}

	public function pack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		return $driver->quote($value);
	}
}