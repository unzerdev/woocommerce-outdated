<?php 

/**
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Database_Entity_ManagedEntity {
	
	private $entityPrimaryKey = null;
	
	private $entity;
	
	private $entityValues = array();

	public function getEntityPrimaryKey(){
		return $this->entityPrimaryKey;
	}

	public function setEntityPrimaryKey($entityPrimaryKey){
		$this->entityPrimaryKey = $entityPrimaryKey;
		return $this;
	}

	public function getEntity(){
		return $this->entity;
	}

	public function setEntity($entity){
		$this->entity = $entity;
		return $this;
	}

	public function getEntityValues(){
		return $this->entityValues;
	}

	public function setEntityValues($entityValues){
		$this->entityValues = $entityValues;
		return $this;
	}
}