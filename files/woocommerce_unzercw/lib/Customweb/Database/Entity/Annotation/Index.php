<?php

require_once 'Customweb/Database/Entity/Annotation/IProcessable.php';
require_once 'Customweb/Database/Entity/Meta/Index.php';
require_once 'Customweb/IAnnotation.php';


/**
 *
 * @author Thomas Hunziker
 * @Target({'Class'})
 *
 */
class Customweb_Database_Entity_Annotation_Index implements Customweb_IAnnotation, Customweb_Database_Entity_Annotation_IProcessable {
	public $name;
	public $columnNames = array();
	public $unique = false;

	public function process(Customweb_Database_Entity_Meta_IEntity $entity, Reflector $reflector){

		if (!is_array($this->columnNames)) {
			throw new Exception("No array given for the column names in the index annoation.");
		}

		if (count($this->columnNames) <= 0) {
			throw new Exception("To few column names given in the index annoation.");
		}

		$name = $this->name;
		if (empty($name)) {
			$name = implode('_', $this->columnNames);
		}

		$index = new Customweb_Database_Entity_Meta_Index();
		$index->setColumnNames($this->columnNames);
		$index->setName($name);
		$index->setUnique($this->unique);
		$entity->addIndex($index);
	}

	public function reset()
	{
		$this->name = null;
		$this->columnNames = array();
		$this->unique = false;
	}
}