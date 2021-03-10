<?php

require_once 'Customweb/Database/Entity/SchemaGenerator.php';
require_once 'Customweb/Database/Entity/IManager.php';
require_once 'Customweb/Database/Entity/ManagedEntity.php';
require_once 'Customweb/Database/Entity/Exception/EntityNotFoundException.php';
require_once 'Customweb/Database/Entity/Exception/OptimisticLockingException.php';
require_once 'Customweb/Database/Entity/Util.php';
require_once 'Customweb/Core/Util/Class.php';
require_once 'Customweb/Database/Entity/Scanner.php';


// TODO: How to handle relations.

/**
 *
 * @author hunziker
 * @Bean
 *
 */
class Customweb_Database_Entity_Manager implements  Customweb_Database_Entity_IManager {

	private $cache;

	private $localCache = array();

	private $managedEntities = array();

	private $driver;

	private $columnTypeClasses = array();

	public function __construct(Customweb_Database_IDriver $driver, Customweb_Cache_IBackend $cache) {
		$this->cache = $cache;
		$this->driver = $driver;
		$this->setup();
	}

	protected function setup() {
		// Load all annotation classes
		Customweb_Core_Util_Class::loadAllClassesOfPackage("Customweb_Database_Entity_Annotation");
	}

	public function persist($entity, $updateOnlyRequiredFields = true) {
		if (!is_object($entity)) {
			throw new InvalidArgumentException("Parameter value of entity is not an object.");
		}

		$primaryKey = $this->getPrimaryKey($entity);
		$entityMetaData = $this->getMetaEntityByClassName(get_class($entity));

		$this->callBeforeSave($entity);
		if (empty($primaryKey)) {
			$databaseValues = $this->getDatabaseValuesFromEntity($entity);
			if($this->isVersioned($entity)) {
				$databaseValues[$this->getVersionColumn($entity)->getColumnName()] = 1;
			}
			$primaryKey = $this->getDatabaseDriver()->insert($entityMetaData->getTableName(), $databaseValues);
			$this->setPrimaryKey($entity, $primaryKey);
			$this->manageEntity($entity);
		}
		else {
			$fieldsToStore = $this->getDatabaseValuesFromEntity($entity);
			
			// Remove the fields, which are not changed since the entiy was loaded.
			if ($updateOnlyRequiredFields) {
				$managedEntity = $this->getManagedEntity(get_class($entity), $primaryKey);
				if ($managedEntity !== null) {
					$managedValues = $managedEntity->getEntityValues();
					foreach ($fieldsToStore as $key => $value) {
						if (isset($managedValues[$key]) && $managedValues[$key] === $value) {
							unset($fieldsToStore[$key]);
						}
					}
				}
			}
			
			if (!empty($fieldsToStore)) {
				$primaryKeyColumn = $this->getPrimaryKeyColumn($entity);
				$whereClause = array($primaryKeyColumn->getColumnName() => $primaryKey);
				$nextVersion = null;
				if($this->isVersioned($entity)) {
					$currentVersion = $this->getVersion($entity);
					$versionColumName = $this->getVersionColumn($entity)->getColumnName();
					
					if($currentVersion !== null){
						$whereClause[$versionColumName] = $currentVersion;
						$nextVersion = $currentVersion + 1;
					}
					else {
						$nextVersion = 1;
					}
					$fieldsToStore[$versionColumName] = $nextVersion;
				}
				
				$rowAffected = $this->getDatabaseDriver()->update($entityMetaData->getTableName(), $fieldsToStore, $whereClause);
				
				if($this->isVersioned($entity)) {
					if($rowAffected == 0) {
						throw new Customweb_Database_Entity_Exception_OptimisticLockingException(get_class($entity), $primaryKey);
					}		
					
					$this->setVersion($entity, $nextVersion);
				}
				
			}
			$this->manageEntity($entity);
		}
		$this->callAfterSave($entity);

		return $entity;
	}

	public function fetch($entityClassName, $primaryKey, $cache = true) {
		$primaryKey = (int)$primaryKey;
		if ($cache) {
			$managedEntity = $this->getManagedEntity($entityClassName, $primaryKey);
			if ($managedEntity !== null) {
				return $managedEntity->getEntity();
			}
		}
		
		$entityMetaData = $this->getMetaEntityByClassName($entityClassName);
		$columnNames = array_keys($entityMetaData->getColumns());

		$sql = 'SELECT ' . implode(',', $columnNames) . ' FROM ' . $entityMetaData->getTableName() . ' WHERE ' . $entityMetaData->getPrimaryKeyColumnName() . ' = ' . $primaryKey;
		$statement = $this->getDatabaseDriver()->query($sql);
		$values = $statement->fetch();
		if ($values === null || $values === false) {
			throw new Customweb_Database_Entity_Exception_EntityNotFoundException($entityClassName, $primaryKey);
		}
		$entity = $this->loadEntityByValues($entityClassName, $values, $cache);
		return $entity;
	}

	public function removeByPrimaryKey($entityClassName, $primaryKey) {
		$entityMetaData = $this->getMetaEntityByClassName($entityClassName);
		$sql = 'DELETE FROM ' . $entityMetaData->getTableName() . ' WHERE ' . $entityMetaData->getPrimaryKeyColumnName() . ' = !primaryKey';

		$statement = $this->getDatabaseDriver()->query($sql);
		$statement->setParameter('!primaryKey', $primaryKey);
		$rows = $statement->getRowCount();
		$this->removeManagedEntity($entityClassName, $primaryKey);
		return $rows;
	}

	public function remove($entity) {
		if (!is_object($entity)) {
			throw new InvalidArgumentException("No object provided.");
		}
		return $this->removeByPrimaryKey(get_class($entity), $this->getPrimaryKey($entity));
	}

	public function search($entityClassName, $where = '', $orderBy = '', array $parameters = array(), $cache = true) {
		$entityMetaData = $this->getMetaEntityByClassName($entityClassName);
		$sql = 'SELECT ' . implode(', ', array_keys($entityMetaData->getColumns())) . ' FROM ' . $entityMetaData->getTableName();

		if (!empty($where)) {
			$sql .= ' WHERE ' . $where;
		}

		if (!empty($orderBy)) {
			$sql .= ' ORDER BY ' . $orderBy;
		}

		$statement = $this->getDatabaseDriver()->query($sql);
		$statement->setParameters($parameters);

		$entities = array();
		while (($values = $statement->fetch()) !== false) {
			$entities[] = $this->loadEntityByValues($entityClassName, $values, $cache);
		}

		return $entities;
	}
	
	public function searchPrimaryKey($entityClassName, $where = '', $orderBy = '', array $parameters = array()) {
		$entityMetaData = $this->getMetaEntityByClassName($entityClassName);
		$sql = 'SELECT ' . $entityMetaData->getPrimaryKeyColumnName() . ' AS entityPrimaryKey FROM ' . $entityMetaData->getTableName();
		
		if (!empty($where)) {
			$sql .= ' WHERE ' . $where;
		}
		
		if (!empty($orderBy)) {
			$sql .= ' ORDER BY ' . $orderBy;
		}
		
		$statement = $this->getDatabaseDriver()->query($sql);
		$statement->setParameters($parameters);
		
		$entities = array();
		while (($values = $statement->fetch()) !== false) {
			$entities[] = $values['entityPrimaryKey'];
		}
		
		return $entities;
		
	}
	
	public function searchByFilterName($entityClassName, $filterName, array $parameters = array(), $cache = true) {
		$entityMetaData = $this->getMetaEntityByClassName($entityClassName);
		$filters = $entityMetaData->getFilters();

		if (!isset($filters[$filterName])) {
			throw new Exception("Could not find filter '" . $filterName . "' on entity '" . $entityClassName . "'.");
		}
		$filter = $filters[$filterName];
		return $this->search($entityClassName, $filter->getWhere(), $filter->getOrderBy(), $parameters, $cache);
	}
	
	public function searchPrimaryKeyByFilterName($entityClassName, $filterName, array $parameters = array()) {
		$entityMetaData = $this->getMetaEntityByClassName($entityClassName);
		$filters = $entityMetaData->getFilters();
		
		if (!isset($filters[$filterName])) {
			throw new Exception("Could not find filter '" . $filterName . "' on entity '" . $entityClassName . "'.");
		}
		$filter = $filters[$filterName];
		return $this->searchPrimaryKey($entityClassName, $filter->getWhere(), $filter->getOrderBy(), $parameters);
		
	}

	protected function loadEntityByValues($entityClassName, $values, $cache = true) {
		$entityMetaData = $this->getMetaEntityByClassName($entityClassName);
		$primaryKey = $values[$entityMetaData->getPrimaryKeyColumnName()];
		if ($cache) {
			$managedEntity = $this->getManagedEntity($entityClassName, $primaryKey);
			if ($managedEntity !== null) {
				return $managedEntity->getEntity();
			}
		}

		$entity = new $entityClassName();
		$this->assignEntityValues($entity, $values);
		$this->setPrimaryKey($entity, $primaryKey);
		$this->manageEntity($entity);
		$this->callAfterLoad($entity);
		return $entity;
	}

	public function generateEntitySchema($entity) {
		$entityClassName = null;
		if (is_object($entity)) {
			$entityClassName = get_class($entity);
		}
		else if (is_string($entity)) {
			$entityClassName = $entity;
		}
		else {
			throw new InvalidArgumentException("Invalid value provided for parameter entity.");
		}

		$schema = new Customweb_Database_Entity_SchemaGenerator($this->getMetaEntityByClassName($entityClassName));
		return $schema->generate();
	}

	protected function getDatabaseValuesFromEntity($entity) {
		$entityMetaData = $this->getMetaEntityByClassName(get_class($entity));
		$columns = $entityMetaData->getColumns();
		$primaryColumn = $this->getPrimaryKeyColumn($entity);

		$values = array();
		foreach ($columns as $column) {
			$value = Customweb_Database_Entity_Util::readColumnValue($entity, $column);

			if ($column->getColumnName() != $primaryColumn->getColumnName() || !empty($value)) {
				$databaseValue = $column->getColumnType()->pack($column, $value, $this->getDatabaseDriver());
				if ($databaseValue === null) {
					$databaseValue = 'NULL';
				}
				$values[$column->getColumnName()] = $databaseValue;
			}
		}

		return $values;
	}

	protected function callBeforeSave($entity) {
		if (method_exists($entity, 'onBeforeSave')) {
			$entity->onBeforeSave($this);
		}
	}

	protected function callAfterSave($entity) {
		if (method_exists($entity, 'onAfterSave')) {
			$entity->onAfterSave($this);
		}
	}

	protected function callAfterLoad($entity) {
		if (method_exists($entity, 'onAfterLoad')) {
			$entity->onAfterLoad($this);
		}
	}

	protected function assignEntityValues($entity, $values) {
		if (!is_array($values)) {
			return;
		}
		$entityMetaData = $this->getMetaEntityByClassName(get_class($entity));
		$columns = $entityMetaData->getColumns();
		foreach ($values as $columnName => $value) {
			$column = $columns[$columnName];
			if ($value === null) {
				$unpackedValue = null;
			} else {
				$unpackedValue = $column->getColumnType()->unpack($column, $value, $this->getDatabaseDriver());
			}
			Customweb_Database_Entity_Util::writeColumnValue($entity, $column, $unpackedValue);
		}
	}

	protected function getPrimaryKey($entity) {
		$primaryKeyColumn = $this->getPrimaryKeyColumn($entity);
		return Customweb_Database_Entity_Util::readColumnValue($entity, $primaryKeyColumn);
	}

	protected function setPrimaryKey($entity, $primaryKey) {
		$primaryKeyColumn = $this->getPrimaryKeyColumn($entity);
		return Customweb_Database_Entity_Util::writeColumnValue($entity, $primaryKeyColumn, $primaryKey);
	}

	/**
	 * @param object $entity
	 * @throws Exception
	 * @return Customweb_Database_Entity_Meta_IColumn
	 */
	protected function getPrimaryKeyColumn($entity) {
		if (is_object($entity)) {
			$entityClassName = get_class($entity);
		}
		else {
			$entityClassName = $entity;
		}

		$entityMetaData = $this->getMetaEntityByClassName($entityClassName);

		$primaryKeyColumnName = $entityMetaData->getPrimaryKeyColumnName();
		$columns = $entityMetaData->getColumns();
		if (!isset($columns[$primaryKeyColumnName])) {
			throw new Exception("The meta entity class does not contain a primary key column definition.");
		}
		$primaryKeyColumn = $columns[$primaryKeyColumnName];

		return $primaryKeyColumn;
	}
	
	protected function getVersion($entity) {
		$versionColumn = $this->getVersionColumn($entity);
		return Customweb_Database_Entity_Util::readColumnValue($entity, $versionColumn);
	}

	protected function setVersion($entity, $version) {
		$versionColumn = $this->getVersionColumn($entity);
		return Customweb_Database_Entity_Util::writeColumnValue($entity, $versionColumn, $version);
	}
	
	protected function getVersionColumn($entity) {
		if(is_object($entity)) {
			$entityClassName = get_class($entity);
		}
		else {
			$entityClassName = $entity;
		}
		$entityMetaData = $this->getMetaEntityByClassName($entityClassName);
		$versionColumnName = $entityMetaData->getVersionColumnName();
	
		$columns = $entityMetaData->getColumns();
		if (!isset($columns[$versionColumnName])) {
			throw new Exception("The meta entity class does not contain a version column definition.");
		}
		$versionColumn = $columns[$versionColumnName];
		
		return $versionColumn;
	}
	
	protected function isVersioned($entity) {
		if(is_object($entity)) {
			$entityClassName = get_class($entity);
		}
		else {
			$entityClassName = $entity;
		}
		$entityMetaData = $this->getMetaEntityByClassName($entityClassName);
		$versionColumnName = $entityMetaData->getVersionColumnName();
		if($versionColumnName !== null) {
			return true;
		}
		return false;
	}
	
	/**
	 * Add the entity to the internal entity manager. By adding the entity only
	 * the changes applied to the entity are stored.
	 *
	 * @param object $entity
	 * @return Customweb_Database_Entity_ManagedEntity
	 */
	protected function manageEntity($entity) {
		$primaryKey = $this->getPrimaryKey($entity);
		$key = $this->getEntityKey(get_class($entity), $primaryKey);

		if (isset($this->managedEntities[$key])) {
			$managedEntity = $this->managedEntities[$key];
		}
		else {
			$managedEntity = new Customweb_Database_Entity_ManagedEntity();
			$this->managedEntities[$key] = $managedEntity;
		}

		$managedEntity->setEntity($entity)->setEntityPrimaryKey($primaryKey)->setEntityValues($this->getDatabaseValuesFromEntity($entity));
		return $managedEntity;
	}

	protected function removeManagedEntity($entityClassName, $primaryKey) {
		$key = $this->getEntityKey($entityClassName, $primaryKey);
		unset($this->managedEntities[$key]);
	}

	/**
	 *
	 * @param string $entityClassName
	 * @param integer $primaryKey
	 * @return Customweb_Database_Entity_ManagedEntity|null
	 */
	protected function getManagedEntity($entityClassName, $primaryKey) {
		$key = $this->getEntityKey($entityClassName, $primaryKey);
		if (isset($this->managedEntities[$key])) {
			return $this->managedEntities[$key];
		}
		else {
			return null;
		}
	}


	final protected function getEntityKey($entityClassName, $primaryKey) {
		return $entityClassName . '___' . $primaryKey;
	}


	/**
	 * @param string $entityClassName
	 * @return Customweb_Database_Entity_Meta_IEntity
	 */
	protected function getMetaEntityByClassName($entityClassName) {
		$key = strtolower($entityClassName);

		if (!isset($this->localCache[$key])) {
			if ($this->cache->keyExists($key)) {
				$this->localCache[$key] = $this->cache->get($key);
			}
			else {
				$entity = $this->getMetaEntityByClassNameNoCache($entityClassName);
				$this->cache->put($key, $entity);
				$this->localCache[$key] = $entity;
			}
		}

		return $this->localCache[$key];
	}
	
	/**
	 * @param string $entityClassName
	 * @return Customweb_Database_Entity_Meta_IEntity
	 */
	protected function getMetaEntityByClassNameNoCache($entityClassName) {
		$scanner = new Customweb_Database_Entity_Scanner($entityClassName);
		$entity = $scanner->scan();
		return $entity;
	}

	public function getCache(){
		return $this->cache;
	}

	/**
	 * @return Customweb_Database_IDriver
	 */
	public function getDatabaseDriver(){
		return $this->driver;
	}

	public function reset() {
		$this->managedEntities = array();
	}

}