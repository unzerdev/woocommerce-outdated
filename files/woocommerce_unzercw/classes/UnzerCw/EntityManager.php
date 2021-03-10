<?php
/**
 *  * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2018 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 */
require_once 'Customweb/Database/Entity/Manager.php';
require_once 'Customweb/Database/Entity/Scanner.php';


class UnzerCw_EntityManager extends Customweb_Database_Entity_Manager {

	/**
	 *
	 * @param string $entityClassName
	 * @return Customweb_Database_Entity_Meta_IEntity
	 */
	protected function getMetaEntityByClassNameNoCache($entityClassName){
		global $wpdb;
		$scanner = new Customweb_Database_Entity_Scanner($entityClassName);
		$entity = $scanner->scan();
		$entity->setTableName($wpdb->prefix . $entity->getTableName());
		return $entity;
	}

	public function getTableNameForEntityByClassName($entityClassName){
		$entity = $this->getMetaEntityByClassName($entityClassName);
		return $entity->getTableName();
	}
}