<?php

require_once 'Customweb/Core/Util/Class.php';
require_once 'Customweb/Core/Util/String.php';


final class Customweb_Database_Entity_Util {

	private function __construct() {

	}

	public static function loadClass($className) {
		if (!is_string($className) && empty($className)) {
			throw new Exception("The given class name is invalid.");
		}
		Customweb_Core_Util_Class::loadLibraryClassByName($className);
	}

	public static function readColumnValue($entity, Customweb_Database_Entity_Meta_IColumn $column) {
		if ($column->getEntityMethodName() !== null) {
			$methodName = 'get' . Customweb_Core_Util_String::ucFirst($column->getEntityMethodName());
			if (method_exists($entity, $methodName)) {
				return $entity->$methodName();
			}
			$methodName = 'is' . Customweb_Core_Util_String::ucFirst($column->getEntityMethodName());
			if (method_exists($entity, $methodName)) {
				return $entity->$methodName();
			}
			throw new Exception("Getter method for column '" . $column->getEntityMethodName() . "' is not defined on entity '" . get_class($entity) . "'.");
		}
		else if ($column->getEntityPropertyName() !== null) {
			$propertyName = $column->getEntityPropertyName();
			if (isset($entity->{$propertyName})) {
				return $entity->{$propertyName};
			}
			else {
				return null;
			}
		}
		else {
			throw new Exception("No entity access defined for column '" . $column->getColumnName() . "' on entity '" . get_class($entity) . "'.");
		}
	}

	public static function writeColumnValue($entity, Customweb_Database_Entity_Meta_IColumn $column, $value) {
		if ($column->getEntityMethodName() !== null) {
			$methodName = 'set' . Customweb_Core_Util_String::ucFirst($column->getEntityMethodName());
			$entity->$methodName($value);
		}
		else if ($column->getEntityPropertyName() !== null) {
			$propertyName = $column->getEntityPropertyName();

			$entity->{$propertyName} = $value;
		}
		else {
			throw new Exception("No entity access defined for column '" . $column->getColumnName() . "' on entity '" . get_class($entity) . "'.");
		}
	}

}