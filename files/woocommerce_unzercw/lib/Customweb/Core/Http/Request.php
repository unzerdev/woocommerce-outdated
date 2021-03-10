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

require_once 'Customweb/Core/Http/ICookie.php';
require_once 'Customweb/Core/Url.php';
require_once 'Customweb/Core/Http/AbstractMessage.php';
require_once 'Customweb/Core/Http/IAuthorization.php';
require_once 'Customweb/Core/Util/Class.php';
require_once 'Customweb/Core/Http/IRequest.php';
require_once 'Customweb/Core/Http/Cookie.php';
require_once 'Customweb/Core/Http/Request.php';


/**
 * This is a default implementation of the Customweb_Core_Http_IResponse interface. It provide read
 * and write method including the handling of cookies.
 * 
 * @author Thomas Hunziker
 *
 */
final class Customweb_Core_Http_Request extends Customweb_Core_Http_AbstractMessage implements Customweb_Core_Http_IRequest {
	
	/**
	 * Header key for 'user-agent' header.
	 * 
	 * @var string
	 */
	const HEADER_KEY_USER_AGENT = 'user-agent';
	
	/**
	 * Header key for 'content-type' header.
	 *
	 * @var string
	 */
	const HEADER_KEY_HOST = 'host';

	/**
	 * Header key for 'cookie' header.
	 *
	 * @var string
	 */
	const HEADER_KEY_COOKIE = 'cookie';
	
	/**
	 * Header key for 'authorization' header.
	 * 
	 * @var string
	 */
	const HEADER_KEY_AUTHORIZATION = 'authorization';
	
	private static $authorizations = array(
		'basic' => 'Customweb_Core_Http_Authorization_Basic',
	);
		
	/**
	 * @var Customweb_Core_Url
	 */
	private $url = null;
	
	/**
	 * @var string
	 */
	private $method = self::METHOD_GET;
	
	/**
	 * @var string
	 */
	private $remoteAddress = null;
	
	/**
	 * @var string[]
	 */
	private $cookies = array();
	
	/**
	 * @var string
	 */
	private $userAgent = null;
	
	/**
	 * @var Customweb_Core_Http_IAuthorization
	 */
	private $authorization = null;
	
	/**
	 * 
	 * @param Customweb_Core_Url | Customweb_Core_Http_IRequest | string $input
	 */
	public function __construct($input = null) {
		$this->url = new Customweb_Core_Url();
		if ($input !== null) {
			if (is_string($input) && (strpos(strtolower($input), 'http://') === 0 || strpos(strtolower($input), 'https://') === 0)) {
				$input = new Customweb_Core_Url($input);
			}
			
			if ($input instanceof Customweb_Core_Url) {
				parent::__construct();
				$this->setUserAgent('Customweb HTTP Client/2');
				$this->setUrl($input);
			}
			else if($input instanceof Customweb_Core_Http_Request) {
				parent::__construct($input);
				$this->url = $input->url;
				$this->method = $input->method;
				$this->remoteAddress = $input->remoteAddress;
				$this->cookies = $input->cookies;
				$this->userAgent = $input->userAgent;
			}
			else if ($input instanceof Customweb_Core_Http_IRequest) {
				$this->setBody($input->getBody());
				$this->setHeaders($input->getHeaders());
				$this->parseStatusLine($input->getStatusLine());
				$this->setRemoteAddress($input->getRemoteAddress());
				$this->setPort($input->getPort());
				$this->setUrl($input->getUrl());
				$this->setProtocol($input->getProtocol());
			}
			else {
				parent::__construct((string)$input);
			}
		}
		else {
			parent::__construct();
			$this->setUserAgent('Customweb HTTP Client/2');
		}
	}

	public function getStatusLine() {
		return strtoupper($this->getMethod()) . ' ' . $this->getPath() . ' ' . 'HTTP/' . $this->getProtocolVersion(); 
	}
	
	/**
	 * This method converts the request into a sendable string representation of the request. This is required when the request is sent through a proxy.
	 * 
	 * @param boolean $fullUri if the full URI should be included in the header.
	 */
	public function toSendableString($fullUri) {
		$path = $this->getPath();
		if ($fullUri) {
			$path = $this->url->toString();
		}
		$output = strtoupper($this->getMethod()) . ' ' . $path . ' ' . 'HTTP/' . $this->getProtocolVersion() . "\r\n"; 
		foreach ($this->getHeaders() as $header) {
			$output .= $header . "\r\n";
		}
		$output .= "\r\n";
		$output .= $this->getBody();
		return $output;
	}
	
	protected function parseStatusLine($line) {
		if (empty($line)) {
			throw new Exception("Empty status line provided.");
		}
		preg_match('/([^[:space:]]+)[[:space:]]+([^[:space:]]+)[[:space:]]+HTTP\/([0-9]+\.[0-9]+)/i', $line, $result);
		$this->setProtocolVersion($result[3]);
		$this->setMethod($result[1]);
		$this->url->updateUrl($result[2]);
	}

	public function getMethod(){
		return $this->method;
	}
	
	/**
	 * Sets the request method (e.g. GET, POST).
	 * 
	 * @param string $requestMethod
	 * @return Customweb_Core_Http_Request
	 */
	public function setMethod($method){
		$this->method = strtoupper($method);
		return $this;
	}
	
	public function getPath() {
		return $this->url->getFullPath();
	}
	
	public function getUrl(){
		return (string)$this->url;
	}
	
	/**
	 * Returns the URL of the request. Changes on the URL object
	 * has no effect of the request. Use instead the setter methods
	 * of this class to change the URL.
	 * 
	 * @return Customweb_Core_Url
	 */
	public function getUrlObject() {
		return new Customweb_Core_Url($this->url);
	}
	
	/**
	 * Sets the URL of the request.
	 * 
	 * @param string | Customweb_Core_Url $url
	 * @throws Exception
	 * @return Customweb_Core_Http_Request
	 */
	public function setUrl($url){
		$url = new Customweb_Core_Url($url);
	
		$scheme = strtolower($url->getScheme());
		if ($scheme != 'http' && $scheme != 'https') {
			throw new Exception("You can either use HTTP or HTTPS in the URL. Other protocols are not supported.");
		}
		$this->url = $url;
		
		// Make sure the host header is updated.
		$this->setHost($url->getHost());
	
		return $this;
	}
	
	public function getProtocol() {
		return strtoupper($this->url->getScheme());
	}
	
	/**
	 * Returns true when the connection is secure.
	 * 
	 * @return boolean
	 */
	public function isSecureConnection() {
		if (strtolower($this->getProtocol()) == 'https') {
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * Set the request protocol (https / http).
	 * 
	 * @param string $protocol
	 * @throws Exception
	 * @return Customweb_Core_Http_Request
	 */
	public function setProtocol($protocol) {
		$protocol = strtolower($protocol);
		if ($protocol != 'http' && $protocol != 'https') {
			throw new Exception("You can either use HTTP or HTTPS in the URL. Other protocols are not supported.");
		}
		$this->url->setScheme($protocol);
		return $this;
	}
	
	public function getHost() {
		return $this->url->getHost();
	}
	
	/**
	 * Sets the host of request.
	 * 
	 * @param string $host
	 * @return Customweb_Core_Http_Request
	 */
	public function setHost($host) {
		$this->removeHeadersWithKey(self::HEADER_KEY_HOST);
		$this->appendHeader(self::HEADER_KEY_HOST . ': ' . $host);
		return $this;
	}
	
	public function getPort() {
		return $this->url->getPort();
	}
	
	/**
	 * Set the port on which the request.
	 * 
	 * @param int $port
	 * @return Customweb_Core_Http_Request
	 */
	public function setPort($port) {
		$this->url->setPort($port);
		return $this;
	}
	
	public function getParsedQuery() {
		return $this->url->getQueryAsArray();
	}
	
	public function getQuery() {
		return $this->url->getQuery();
	}
	
	public function getRemoteAddress(){
		$host = $this->url->getHost();
		// In case no remote address is set, we try to resolve the remote IP Address.
		if ($this->remoteAddress === null && !empty($host)) {
			$ip = gethostbyname($host);
			if ($ip !== $host) {
				$this->remoteAddress = $ip;
			}
		}
		
		return $this->remoteAddress;
	}
	
	/**
	 * Sets the remote address.
	 * 
	 * @param string $remoteAddress
	 * @return Customweb_Core_Http_Request
	 */
	public function setRemoteAddress($remoteAddress){
		$this->remoteAddress = $remoteAddress;
		return $this;
	}
	
	public function getCookies(){
		return $this->cookies;
	}
	
	/**
	 * Sets the cookies of the request. It can be either a list 
	 * of key / value map or objects of Customweb_Core_Http_ICookie. 
	 * 
	 * @param array $cookies
	 * @return Customweb_Core_Http_Request
	 */
	public function setCookies(array $cookies){
		$this->removeHeadersWithKey(self::HEADER_KEY_COOKIE);
		
		$normalized = array();
		foreach ($cookies as $key => $cookie) {
			if (!($cookie instanceof Customweb_Core_Http_ICookie)) {
				$cookieObject = new Customweb_Core_Http_Cookie();
				$cookieObject->setName($key)->setValue($cookie);
				$cookie = $cookieObject;
			}
			$normalized[$cookie->getName()] = $cookie;
		}
		$this->appendHeader(self::HEADER_KEY_COOKIE . ': ' . self::getCookiesAsString($normalized));
		
		return $this;
	}
	
	
	public function getParameters() {
		$parameters = $this->getParsedQuery();
		if (strtolower($this->getMethod()) != self::METHOD_GET) {
			$parameters = array_merge($parameters, $this->getParsedBody());
		}
		return $parameters;
	}
	
	/**
	 * Returns the user agent header.
	 * 
	 * @return string
	 */
	public function getUserAgent(){
		return $this->userAgent;
	}
	
	/**
	 * Sets the user agent header.
	 * 
	 * @param string $userAgent
	 * @return Customweb_Core_Http_Request
	 */
	public function setUserAgent($userAgent){
		$this->removeHeadersWithKey(self::HEADER_KEY_USER_AGENT);
		$this->appendHeader(self::HEADER_KEY_USER_AGENT . ': ' . $userAgent);
		return $this;
	}
	
	/**
	 * Returns the authorization header.
	 * 
	 * @return Customweb_Core_Http_IAuthorization
	 */
	public function getAuthorization(){
		return $this->authorization;
	}
	
	/**
	 * Sets the header authorization header.
	 * 
	 * @param Customweb_Core_Http_IAuthorization $authorization
	 * @return Customweb_Core_Http_Request
	 */
	public function setAuthorization(Customweb_Core_Http_IAuthorization $authorization){
		$this->removeHeadersWithKey(self::HEADER_KEY_AUTHORIZATION);
		$name = strtolower($authorization->getName());
		self::$authorizations[$name] = get_class($authorization);
		$this->appendHeader(self::HEADER_KEY_AUTHORIZATION . ': ' . $authorization->getHeaderFieldValue());
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::setBody()
	 * @return Customweb_Core_Http_Request
	 */
	public function setBody($body) {
		return parent::setBody($body);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::appendBody()
	 * @return Customweb_Core_Http_Request
	 */
	public function appendBody($string) {
		return parent::appendBody($string);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::prependBody()
	 * @return Customweb_Core_Http_Request
	 */
	public function prependBody($string) {
		return parent::prependBody($string);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::setHeaders()
	 * @return Customweb_Core_Http_Request
	 */
	public function setHeaders(array $headers){
		parent::setHeaders($headers);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::appendHeader()
	 * @return Customweb_Core_Http_Request
	 */
	public function appendHeader($header) {
		return parent::appendHeader($header);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::prependHeader()
	 * @return Customweb_Core_Http_Request
	 */
	public function prependHeader($header) {
		return parent::prependHeader($header);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::setProtocolVersion()
	 * @return Customweb_Core_Http_Request
	 */
	public function setProtocolVersion($protocolVersion) {
		return parent::setProtocolVersion($protocolVersion);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::setContentType()
	 * @return Customweb_Core_Http_Request
	 */
	public function setContentType($contentType) {
		return parent::setContentType($contentType);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::setContentEncoding()
	 * @return Customweb_Core_Http_Request
	 */
	public function setContentEncoding($contentEncoding) {
		return parent::setContentEncoding($contentEncoding);
	}
	
	
	protected function processKeyedHeader($headerKey, $headerValue) {
		parent::processKeyedHeader($headerKey, $headerValue);
		if ($headerKey == self::HEADER_KEY_COOKIE) {
			$this->processCookieHeader($headerValue);
		}
		else if ($headerKey == self::HEADER_KEY_HOST) {
			$this->url->setHost($headerValue);
		}
		else if ($headerKey == self::HEADER_KEY_USER_AGENT) {
			$this->userAgent = $headerValue;
		}
		else if ($headerKey == self::HEADER_KEY_AUTHORIZATION) {
			$authorizationName = strtolower(trim(substr($headerValue, 0, strpos($headerValue, ' '))));
			if (isset(self::$authorizations[$authorizationName])) {
				$className = self::$authorizations[$authorizationName];
				Customweb_Core_Util_Class::loadLibraryClassByName($className);
				$object = new $className();
				if (!($object instanceof Customweb_Core_Http_IAuthorization)) {
					throw new Exception("The given authorization class does not implement the authorization interface.");
				}
				$object->parseHeaderFieldValue($headerValue);
				$this->authorization = $object;
			}
		}
	}
	
	/**
	 * Parse the cookie header and set the internal cookies.
	 * 
	 * @param string $header
	 */
	protected function processCookieHeader($header) {
		$items = explode(';' , $header);
		$cookies = array();
		foreach ($items as $cookieString) {
			$parts = explode('=', trim($cookieString), 2);
			$cookie = new Customweb_Core_Http_Cookie();
			$cookie->setRawName($parts[0])->setRawValue($parts[1]);
			$cookies[$cookie->getName()] = $cookie->getValue();
		}
		$this->cookies = $cookies;
	}
	
	protected function resetHeaders() {
		parent::resetHeaders();
		$this->cookies = array();
		$this->authorization = null;
		$this->method = 'GET';
		$this->url = new Customweb_Core_Url();
		$this->remoteAddress = null;
		$this->userAgent = null;
	}
	
	########## Util methods ##############
	
	/**
	 * Generate a string from a given cookies array. The string
	 * correspons to the header to set for the cookies.
	 * 
	 * @return string
	 */
	protected static function getCookiesAsString(array $cookies) {
		$items = array();
		foreach ($cookies as $cookie) {
			if (!($cookie instanceof Customweb_Core_Http_ICookie)) {
				$items[] = $cookie->getRawName() . '=' . $cookie->getRawValue();
			}
		}
		
		return implode(';', $items);
	}
	
}
