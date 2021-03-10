<?php 

require_once 'Customweb/Database/Entity/Meta/IColumnType.php';


class Customweb_Database_Entity_Meta_ColumnType_Integer implements Customweb_Database_Entity_Meta_IColumnType {

	public function getName() {
		return 'integer';
	}
	
	public function getColumnSchema(Customweb_Database_Entity_Meta_IColumn $column) {

		$size = 11;
		if ($column->getSize() !== null && $column->getSize() > 0) {
			$size = $column->getSize();
		}
		
		$type = 'int';
		if ($size > 11) {
			$type = 'bigint';
		}
		
		return $column->getColumnName() . ' ' . $type .' (' . $size . ') ' . $column->getDefault();
	}

	public function unpack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		return intval($value);
	}

	public function pack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		return $value;
	}
}