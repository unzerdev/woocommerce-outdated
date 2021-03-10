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

require_once 'Customweb/Core/String.php';
require_once 'Customweb/Core/Http/ICookie.php';


class Customweb_Core_Http_Cookie implements Customweb_Core_Http_ICookie {
	
	private $expiryDate = null;
	
	private $name = null;
	
	private $value = null;
	
	private $domain = null;
	
	private $path = null;
	
	private $secure = false;
	
	private $httpOnly = false;
	
	public function __construct(Customweb_Core_Http_ICookie $cookie = null) {
		if ($cookie !== null) {
			$this->setDomain($cookie->getDomain());
			$this->setExpiryDate($cookie->getExpiryDate());
			$this->setName($cookie->getName());
			$this->setPath($cookie->getPath());
			$this->setValue($cookie->getValue());
			$this->setSecure($cookie->isSecure());
			$this->setHttpOnly($cookie->isHttpOnly());
		}
	}
	
	public function getExpiryDate(){
		return $this->expiryDate;
	}

	public function setExpiryDate($expiryDate){
		$this->expiryDate = $expiryDate;
		return $this;
	}

	public function getName(){
		return rawurldecode($this->name);
	}
	
	public function getRawName() {
		return $this->name;
	}

	public function setName($name){
		$this->name = rawurlencode($name);
		return $this;
	}
	
	public function setRawName($name) {
		if (preg_match('/[=;,[:space:]]+/i', $name)) {
			throw new Exception("Unallowed chars in the cookie name. Not allowed are ',', ';', '=' and any space. Use instead setName.");
		}
		
		$this->name = $name;
		return $this;
	}

	public function getValue(){
		return rawurldecode($this->value);
	}
	
	public function getRawValue() {
		return $this->value;
	}

	public function setValue($value){
		$this->value = rawurlencode($value);
		return $this;
	}
	
	public function setRawValue($value) {
		if (preg_match('/[;,[:space:]]+/i', $value)) {
			throw new Exception(Customweb_Core_String::_("Unallowed chars in the cookie value. Not allowed are ',', ';' and any space. Use instead setValue. Value: @value")->format(array('@value' => $value))->toString());
		}
		$this->value = $value;
		return $this;
	}

	public function getDomain(){
		return $this->domain;
	}

	public function setDomain($domain){
		$this->domain = $domain;
		return $this;
	}

	public function getPath(){
		return $this->path;
	}

	public function setPath($path){
		$this->path = $path;
		return $this;
	}

	public function isSecure() {
		return $this->secure;
	}
	
	public function setSecure($secure = true) {
		$this->secure = $secure;
		return $this;
	}
	
	public function setHttpOnly($httpOnly = true) {
		$this->httpOnly = $httpOnly;
		return $this;
	}
	
	public function isHttpOnly() {
		return $this->httpOnly;
	}
	
	public function toHeaderString() {
		$output = 'Set-Cookie: ' . $this->getName() . '=' . $this->getValue() . '; ';
		
		if ($this->getExpiryDate() !== null) {
			$output .= self::KEY_EXPIRY_DATE . '=' . gmdate('D, d-M-Y H:i:s', $this->getExpiryDate()) . ' GMT' . '; ';
		}
		
		$path = $this->getPath();
		if (!empty($path)) {
			$output .= self::KEY_PATH . '=' . $path . '; ';
		}
		
		$domain = $this->getDomain();
		if (!empty($domain)) {
			$output .= self::KEY_DOMAIN . '=' . $domain . '; ';
		}
		
		if ($this->isHttpOnly()) {
			$output .= self::KEY_HTTP_ONLY . '; ';
		}
		
		if ($this->isSecure()) {
			$output .= self::KEY_SECURE . '; ';
		}
		
		return trim($output);
	}
	
}
	