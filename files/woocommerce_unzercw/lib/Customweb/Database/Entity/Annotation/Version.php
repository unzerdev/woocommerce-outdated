<?php

require_once 'Customweb/Database/Entity/Meta/ColumnType/Version.php';
require_once 'Customweb/Database/Entity/Annotation/AbstractColumn.php';


/**
 * 
 * @author Thomas Hunziker
 * @Target({'Method', 'Property'})
 *
 */
class Customweb_Database_Entity_Annotation_Version extends Customweb_Database_Entity_Annotation_AbstractColumn {

	private $versionColumnType = null;

	public function __construct() {
		$this->versionColumnType = new Customweb_Database_Entity_Meta_ColumnType_Version();
	}

	protected function getColumnType(Customweb_Database_Entity_Meta_IEntity $entity, Reflector $reflector) {
		return $this->versionColumnType;
	}

	public function process(Customweb_Database_Entity_Meta_IEntity $entity, Reflector $reflector) {
		parent::process($entity, $reflector);
		$column = $this->getColumn();
		$entity->setVersionColumnName($column->getColumnName());
	}
}