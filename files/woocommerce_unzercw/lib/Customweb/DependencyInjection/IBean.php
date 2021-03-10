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



interface Customweb_DependencyInjection_IBean {
	
	/**
	 * This method returns the ID of the bean. This id can be used to identify this
	 * bean somewhere else.
	 * 
	 * @return string
	 */
	public function getBeanId();
	
	/**
	 * A list of class names, which are supported by this class (the class / interface hierarchy).
	 * 
	 * @return string[]
	 */
	public function getClasses();
	
	/**
	 * This method returns the instance of the bean.
	 * 
	 * @return object
	 */
	public function getInstance(Customweb_DependencyInjection_IContainer $container);
	
}