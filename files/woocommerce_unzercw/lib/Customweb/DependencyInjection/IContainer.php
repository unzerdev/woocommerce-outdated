<?php 
/**
  * You are allowed to use this API in your web application.
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



interface Customweb_DependencyInjection_IContainer {
	
	/**
	 * Retrieves the bean identified by the given identifier. The identifier can
	 * be either the ID of the bean or the class / interface of the bean. In the identifier
	 * can not be identified as an ID, the method tries to find the best suited bean which has
	 * the class indicated with the identifier.
	 * 
	 * @param string $identifier
	 * @throws Customweb_DependencyInjection_Exception_BeanNotFoundException
	 * @return object Bean instance
	 */
	public function getBean($identifier);
	
	/**
	 * This method returns a set of beans, which implements a given type. A type can be 
	 * class, abstract class or an interface.
	 * 
	 * @param string $type
	 * @return array List of bean objects
	 */
	public function getBeansByType($type);
	
	/**
	 * Checks whether a bean with the given identifier can be returned. See getBean() for more 
	 * details about the resolution of the identifier.
	 * 
	 * 
	 * @param string $identifier
	 * @return boolean
	 */
	public function hasBean($identifier);
	
	
	
}