<?php

require_once 'Customweb/Annotation/ReflectionAnnotatedClass.php';
require_once 'Customweb/Database/Entity/Annotation/IProcessable.php';
require_once 'Customweb/Database/Entity/Meta/Entity.php';
require_once 'Customweb/Database/Entity/Util.php';

require_once 'Customweb/Database/Entity/Annotation/Entity.php';


class Customweb_Database_Entity_Scanner {
	private $entityClassName = null;

	/**
	 * @var Customweb_Database_Entity_Meta_Entity
	 */
	private $metaEntity = null;
	private $columnTypeClasses = array();


	public function __construct($entityClassName){
		$this->entityClassName = $entityClassName;
		$this->metaEntity = new Customweb_Database_Entity_Meta_Entity();
	}

	/**
	 * @return Customweb_Database_Entity_Meta_Entity
	 */
	public function scan(){
		Customweb_Database_Entity_Util::loadClass($this->getEntityClassName());

		$entityClassReflection = new Customweb_Annotation_ReflectionAnnotatedClass($this->getEntityClassName());
		$this->scanClass($entityClassReflection);

		$tableName = $this->metaEntity->getTableName();
		if (empty($tableName)) {
			throw new Exception("No table name defined on entity '" . $this->getEntityClassName() . "'.");
		}

		$primaryKeyColumnName = $this->metaEntity->getPrimaryKeyColumnName();
		if (empty($primaryKeyColumnName)) {
			throw new Exception("No primary key set for entity '" . $this->getEntityClassName() . "'.");
		}

		return $this->metaEntity;
	}

	protected function scanClass(Customweb_Annotation_ReflectionAnnotatedClass $reflectionClass) {
		$parentClass = $reflectionClass->getParentClass();
		if (is_object($parentClass)) {
			$this->scanClass($parentClass);
		}
		$this->processAnnotations($reflectionClass->getAllAnnotations(), $reflectionClass);

		// Scan properties
		foreach ($reflectionClass->getProperties() as $property) {
			$this->processAnnotations($property->getAnnotations(), $property);
		}

		// Scan methods
		foreach ($reflectionClass->getMethods() as $method) {
			$this->processAnnotations($method->getAnnotations(), $method);
		}


	}

	protected function processAnnotations(array $annotations, Reflector $reflector) {
		foreach ($annotations as $annotation) {
			if ($annotation instanceof Customweb_Database_Entity_Annotation_IProcessable) {
				$annotation->process($this->metaEntity, $reflector);
			}
		}
	}


	final protected function getEntityClassName(){
		return $this->entityClassName;
	}

	public function getMetaEntity() {
		return $this->metaEntity;
	}

}