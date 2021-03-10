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

require_once 'Customweb/Core/Util/Class.php';
require_once 'Customweb/DependencyInjection/IBean.php';


/**
 * This bean implementation adds a object to the provider.
 * 
 * @author hunziker
 *
 */
class Customweb_DependencyInjection_Bean_Object implements Customweb_DependencyInjection_IBean{
	
	private $object;
	private $classes = array();
	private $beanId;
	
	public function __construct($object) {
		
		if (!is_object($object)) {
			throw new InvalidArgumentException("No provided object is not of type 'object'.");
		}
		
		$this->object = $object;
		$this->beanId = get_class($this->object);
		$this->classes = Customweb_Core_Util_Class::getAllTypes($this->beanId);
	}

	public function getBeanId() {
		return $this->beanId;
	}
	
	public function getInstance(Customweb_DependencyInjection_IContainer $container) {
		return $this->object;
	}

	public function getClasses() {
		return $this->classes;
	}
}