<?php

require_once 'Customweb/Database/Entity/Annotation/AbstractColumn.php';
require_once 'Customweb/Database/Entity/Meta/ColumnType/PrimaryKey.php';


/**
 * 
 * @author Thomas Hunziker
 * @Target({'Method', 'Property'})
 *
 */
class Customweb_Database_Entity_Annotation_PrimaryKey extends Customweb_Database_Entity_Annotation_AbstractColumn {

	private $primaryColumnType = null;

	public function __construct() {
		$this->primaryColumnType = new Customweb_Database_Entity_Meta_ColumnType_PrimaryKey();
	}

	protected function getColumnType(Customweb_Database_Entity_Meta_IEntity $entity, Reflector $reflector) {
		return $this->primaryColumnType;
	}

	public function process(Customweb_Database_Entity_Meta_IEntity $entity, Reflector $reflector) {
		parent::process($entity, $reflector);
		$column = $this->getColumn();
		$entity->setPrimaryKeyColumnName($column->getColumnName());
	}
}