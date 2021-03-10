<?php

require_once 'Customweb/Database/Entity/Meta/ColumnType/Boolean.php';
require_once 'Customweb/Database/Entity/Meta/ColumnType/Object.php';
require_once 'Customweb/Database/Entity/Meta/ColumnType/Text.php';
require_once 'Customweb/Database/Entity/Meta/ColumnType/Decimal.php';
require_once 'Customweb/Database/Entity/Meta/ColumnType/Varchar.php';
require_once 'Customweb/Database/Entity/Meta/ColumnType/DateTime.php';
require_once 'Customweb/Database/Entity/Meta/ColumnType/BinaryObject.php';
require_once 'Customweb/Database/Entity/Meta/ColumnType/Integer.php';
require_once 'Customweb/Database/Entity/Annotation/AbstractColumn.php';


/**
 *
 * @author Thomas Hunziker
 * @Target({'Method', 'Property'})
 *
 */
class Customweb_Database_Entity_Annotation_Column extends Customweb_Database_Entity_Annotation_AbstractColumn {

	public $type = null;

	public $default = null;
	
	public $size = null;

	private $columnTypes = array();

	public function __construct() {
		$this->registerColumnType(new Customweb_Database_Entity_Meta_ColumnType_DateTime());
		$this->registerColumnType(new Customweb_Database_Entity_Meta_ColumnType_Decimal());
		$this->registerColumnType(new Customweb_Database_Entity_Meta_ColumnType_Integer());
		$this->registerColumnType(new Customweb_Database_Entity_Meta_ColumnType_Object());
		$this->registerColumnType(new Customweb_Database_Entity_Meta_ColumnType_Text());
		$this->registerColumnType(new Customweb_Database_Entity_Meta_ColumnType_Varchar());
		$this->registerColumnType(new Customweb_Database_Entity_Meta_ColumnType_Boolean());
		$this->registerColumnType(new Customweb_Database_Entity_Meta_ColumnType_BinaryObject());
	}

	public function registerColumnType(Customweb_Database_Entity_Meta_IColumnType $type) {
		$this->columnTypes[strtolower($type->getName())] = $type;
		return $this;
	}

	protected function getColumnType(Customweb_Database_Entity_Meta_IEntity $entity, Reflector $reflector) {
		return $this->columnTypes[strtolower($this->type)];
	}

	public function process(Customweb_Database_Entity_Meta_IEntity $entity, Reflector $reflector) {
		if (!isset($this->columnTypes[strtolower($this->type)])) {
			throw new Exception("No type implementation found for type '" . $this->type . "'.");
		}

		parent::process($entity, $reflector);

		$column = $this->getColumn();
		$column->setDefault($this->default);
		$column->setSize($this->size);
	}

	public function reset(){
		parent::reset();
		$this->type = null;
		$this->default = null;
	}
}