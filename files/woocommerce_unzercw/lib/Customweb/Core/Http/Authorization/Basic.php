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
class Customweb_Core_Http_Authorization_Basic implements Customweb_Core_Http_IAuthorization {
	
	const NAME = 'Basic';
	
	/**
	 * @var string
	 */
	private $username = null;
	
	/**
	 * @var string
	 */
	private $password = null;
	
	public function __construct($username = null, $password = null) {
		if ($username !== null) {
			$this->setUsername($username);
		}
		if ($password !== null) {
			$this->setPassword($password);
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
		list($username, $password) = explode(':', base64_decode($headerFieldValue), 2);
		$this->username = $username;
		$this->password = $password;
	}

	public function getHeaderFieldValue() {
		return self::NAME . ' ' . base64_encode($this->getUsername() . ':' . $this->getPassword());
	}

	public function getUsername(){
		return $this->username;
	}

	public function setUsername($username){
		$this->username = $username;
		if (strpos($username, ':') !== false) {
			throw new Exception("The username can not contain a colon (':').");
		}
		
		return $this;
	}

	public function getPassword(){
		return $this->password;
	}

	public function setPassword($password){
		$this->password = $password;
		return $this;
	}

}