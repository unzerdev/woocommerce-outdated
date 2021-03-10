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



/**
 *
 * @author Thomas Hunziker
 *        
 */
interface Customweb_DependencyInjection_Bean_Generic_IDependency {

	/**
	 * This method returns the name to set the bean, which should be assigned by this
	 * dependency.
	 *
	 * @return string
	 */
	public function getAccessMethodName();

	/**
	 * Returns the name of the class or the id of the bean to inject.
	 *
	 * @return string[]
	 */
	public function getInjects();
	
	/**
	 * This method is invoked to create the instance to be injected by the container. The method
	 * may use the container to resolve the dependency or create the instance by itself.
	 * 
	 * @param Customweb_DependencyInjection_IContainer $container
	 * @param string $inject
	 */
	public function getInstanceByInject(Customweb_DependencyInjection_IContainer $container, $inject);

}