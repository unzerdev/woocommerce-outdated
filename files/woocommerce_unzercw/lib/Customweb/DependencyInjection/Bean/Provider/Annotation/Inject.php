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

require_once 'Customweb/IAnnotation.php';


/**
 *
 * @author Thomas Hunziker
 * @Target('Method')
 *
 */
class Customweb_DependencyInjection_Bean_Provider_Annotation_Inject implements Customweb_IAnnotation {
	
	private $injects = array();
	
	public function getInjects() {
		return $this->injects;
	}
	
	public function setValue($value) {
		
		if (is_string($value)) {
			$this->injects = array($value);
		}
		elseif (is_array($value)) {
			$this->injects = $value;
		}
		else {
			throw new Exception("Invalid annotation parameter for @Inject annotation.");
		}
	}
}
