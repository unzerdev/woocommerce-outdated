<?php 



// TODO: How to handle relations. --> No Lacy Loading, does not require any proxys

interface Customweb_Database_Entity_IManager {
	
	
	/**
	 * Stores the given entity to the database. In case the entity
	 * does not exists in the database, it will be created and the 
	 * primary key is assigned to the entity. In case the primary
	 * key is not set, it is assumed that the entity does not exists
	 * in the database.
	 * 
	 * By default only the changed fields are persisted to the database. However
	 * it is possible to by pass this behavior by setting $updateOnlyRequiredFields 
	 * to false.
	 * 
	 * @param object The entity to store.
	 * @param boolean $updateOnlyRequiredFields
	 * @throws Exception
	 * @return object The entity as stored in the database.
	 */
	public function persist($entity, $updateOnlyRequiredFields = true);
	
	/**
	 * Loads the given entity. In case the cache flag is set to false, any internal
	 * cache is by passed.
	 * 
	 * @param integer $primaryKey
	 * @return object
	 */
	public function fetch($entityClassName, $primaryKey, $cache = true);
	
	/**
	 * Removes the given entity from the database.
	 * 
	 * @param object $entity The entity object to remove
	 * @throws Exception
	 * @return void
	 */
	public function remove($entity);
	
	public function removeByPrimaryKey($entityClassName, $primaryKey);
	
	/**
	 * Search a set of entity given by the where clause. If the cache flag is set to false, any internal
	 * cache is by passed. Otherwise may be a reference of an existing object is returned.
	 * 
	 * @param stirng $entityClassName
	 * @param string $where
	 * @param string $orderBy
	 * @param array $parameters
	 * @param string $cache
	 * @return object[] List of entities
	 */
	public function search($entityClassName, $where = '', $orderBy = '', array $parameters = array(), $cache = true);
	

	/**
	 * Search a set of primary keys given by the where clause and entity class name.
	 *
	 * @param stirng $entityClassName
	 * @param string $where
	 * @param string $orderBy
	 * @param array $parameters
	 * @return object[] List of primary keys
	 */
	public function searchPrimaryKey($entityClassName, $where = '', $orderBy = '', array $parameters = array());
	
	/**
	 * Entities can be annotated by a filter annotation. This method can be used to query the database 
	 * with the defined filter.
	 * 
	 * @param string $entityClassName
	 * @param string $filterName
	 * @param array $parameters
	 * @param string $cache
	 * @return object[] List of entities
	 */
	public function searchByFilterName($entityClassName, $filterName, array $parameters = array(), $cache = true);
	
	/**
	 * Entities can be annotated by a filter annotation. This method can be used to query the database 
	 * with the defined filter. The method returns only the primary keys.
	 * 
	 * @param string $entityClassName
	 * @param string $filterName
	 * @param array $parameters
	 * @return object[] List of primary keys
	 */
	public function searchPrimaryKeyByFilterName($entityClassName, $filterName, array $parameters = array());
	
	/**
	 * Generats the SQL statement to create the entity table.
	 * 
	 * @param object|string $entity Either an instance of the entity or the class name of the entity.
	 * @return string SQL Schema
	 */
	public function generateEntitySchema($entity);
	
	/**
	 * This method removes all managed entities.
	 * 
	 * @return void
	 */
	public function reset();
	
}