<?php

require_once 'Customweb/Database/Entity/Annotation/IProcessable.php';
require_once 'Customweb/IAnnotation.php';


/**
 *
 * @author Thomas Hunziker
 * @Target({'Class'})
 *        
 */
class Customweb_Database_Entity_Annotation_Entity implements Customweb_IAnnotation, Customweb_Database_Entity_Annotation_IProcessable {
	public $tableName;

	public function process(Customweb_Database_Entity_Meta_IEntity $entity, Reflector $reflector){
		if (empty($this->tableName)) {
			throw new Exception("The table name must be set on the Entity '" . $reflector->getName() . "'.");
		}
		$entity->setTableName($this->tableName);
	}

	public function reset(){
		$this->tableName = null;
	}
}
