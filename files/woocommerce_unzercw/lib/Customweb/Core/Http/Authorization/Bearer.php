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

require_once 'Customweb/Core/Http/IAuthorization.php';


/**
 * This is an implementation of an authorization header with basic
 * authentication.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Core_Http_Authorization_Bearer implements Customweb_Core_Http_IAuthorization {
	
	const NAME = 'Bearer';
	
	/**
	 * @var string
	 */
	private $token = null;
	
	public function __construct($token = null) {
		if ($token !== null) {
			$this->setToken($token);
		}
	}
	
	public function getName() {
		return self::NAME;
	}

	public function parseHeaderFieldValue($headerFieldValue) {
		if (strpos($headerFieldValue, self::NAME) !== 0) {
			throw new Exception("Invalid authentication name.");
		}
		$headerFieldValue = trim(substr($headerFieldValue, strlen(self::NAME)));
		$this->token = $headerFieldValue;
	}

	public function getHeaderFieldValue() {
		return self::NAME . ' ' . $this->getToken();
	}

	public function getToken(){
		return $this->token;
	}

	public function setToken($token){
		$this->token = $token;
		return $this;
	}

}