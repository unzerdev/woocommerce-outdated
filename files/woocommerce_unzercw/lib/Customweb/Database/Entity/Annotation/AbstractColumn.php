<?php

require_once 'Customweb/Database/Entity/Meta/Column.php';
require_once 'Customweb/Database/Entity/Annotation/IProcessable.php';
require_once 'Customweb/IAnnotation.php';


/**
 *
 * @author Thomas Hunziker
 * @Target({'Method', 'Property'})
 *        
 */
abstract class Customweb_Database_Entity_Annotation_AbstractColumn implements Customweb_IAnnotation, Customweb_Database_Entity_Annotation_IProcessable {
	public $name = null;
	private $column;

	/**
	 *
	 * @param Customweb_Database_Entity_Meta_IEntity $entity        	
	 * @param Reflector $reflector        	
	 * @return Customweb_Database_Entity_Meta_IColumnType
	 */
	abstract protected function getColumnType(Customweb_Database_Entity_Meta_IEntity $entity, Reflector $reflector);

	public function process(Customweb_Database_Entity_Meta_IEntity $entity, Reflector $reflector){
		$column = new Customweb_Database_Entity_Meta_Column();
		if ($reflector instanceof ReflectionMethod) {
			$methodName = $reflector->getName();
			if (substr($methodName, 0, 3) == 'get' || substr($methodName, 0, 3) == 'set') {
				$methodName = substr($methodName, 3);
			} elseif (substr($methodName, 0, 2) == 'is') {
				$methodName = substr($methodName, 2);
			}
			$column->setColumnName($this->handleColumnName($methodName));
			$column->setEntityMethodName($methodName);
		} else if ($reflector instanceof ReflectionProperty) {
			$column->setColumnName($this->handleColumnName($reflector->getName()));
			$column->setEntityPropertyName($reflector->getName());
		} else {
			throw new Exception("Cannot read column annotation, because the column annotation is not placed on a method or property.");
		}
		
		if (! empty($this->name)) {
			$column->setColumnName(trim($this->name, ' \'"'));
		}
		
		$column->setColumnType($this->getColumnType($entity, $reflector));
		
		$entity->addColumn($column);
		$this->column = $column;
	}
	
	private function handleColumnName($name) {
		return (string)(strtolower(substr($name,0,1)).substr($name,1));
	}

	/**
	 *
	 * @return Customweb_Database_Entity_Meta_Column
	 */
	protected function getColumn(){
		return $this->column;
	}

	public function reset(){
		$this->name = null;
	}
}