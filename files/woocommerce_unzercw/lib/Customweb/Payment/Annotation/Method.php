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
 * Classes annotated with this annotation can be used as payment methods. 
 * Depending on the set properties a payment method may be selected
 * in a certain situation.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_Annotation_Method implements Customweb_IAnnotation{
	
	private $supportedMethods = array();
	
	private $supportedAuthorizationMethods = array();
	
	private $supportedProcessors = array();
	
	public function setPaymentMethods($value) {
		if (is_array($value)) {
			$this->supportedMethods = $value;
		}
		else {
			$this->supportedMethods = array($value);
		}
		$this->supportedMethods = array_map('strtolower', $this->supportedMethods);
	}
	
	public function setAuthorizationMethods($value) {
		if (is_array($value)) {
			$this->supportedAuthorizationMethods = $value;
		}
		else {
			$this->supportedAuthorizationMethods = array($value);
		}
		$this->supportedAuthorizationMethods = array_map('strtolower', $this->supportedAuthorizationMethods);
	}

	public function setProcessors($value) {
		if (is_array($value)) {
			$this->supportedProcessors = $value;
		}
		else {
			$this->supportedProcessors = array($value);
		}
		$this->supportedProcessors = array_map('strtolower', $this->supportedProcessors);
	}
	
	
	public function getPaymentMethods() {
		return $this->supportedMethods;
	}

	public function getAuthorizationMethods() {
		return $this->supportedAuthorizationMethods;
	}
	
	public function getProcessors() {
		return $this->supportedProcessors;
	}

}