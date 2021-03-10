<?php

require_once 'Customweb/Database/Entity/Meta/IColumnType.php';
require_once 'Customweb/Core/Util/Serialization.php';


class Customweb_Database_Entity_Meta_ColumnType_Object implements Customweb_Database_Entity_Meta_IColumnType {

	public function getName() {
		return 'object';
	}

	public function getColumnSchema(Customweb_Database_Entity_Meta_IColumn $column) {
		return $column->getColumnName() . ' LONGTEXT ' . $column->getDefault();
	}

	public function unpack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		return Customweb_Core_Util_Serialization::unserialize($value);
	}

	public function pack(Customweb_Database_Entity_Meta_IColumn $column, $value, Customweb_Database_IDriver $driver) {
		return $driver->quote(Customweb_Core_Util_Serialization::serialize($value));
	}

}