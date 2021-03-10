<?php

require_once 'Customweb/Core/Http/ContextRequest.php';
require_once 'Customweb/Core/Http/IRequest.php';


class UnzerCw_ContextRequest implements Customweb_Core_Http_IRequest {
	private static $post = array();
	private static $get = array();
	private static $request;
	private static $instance;

	/**
	 *
	 * @return Customweb_Core_Http_ContextRequest
	 */
	public static function getInstance(){
		if (self::$instance === null) {
			self::$instance = new UnzerCw_ContextRequest();
			self::$request = Customweb_Core_Http_ContextRequest::getInstance();
			self::$post = $_POST;
			self::$get = $_GET;
		}
		return self::$instance;
	}

	public function getParsedBody(){
		return self::$post;
	}
	
	public function getParsedQuery(){
		return self::$get;
	}

	public function getParameters(){
		return array_merge(self::$get, self::$post);
	}

	public function getUrl(){
		return self::$request->getUrl();
	}

	public function getMethod(){
		return self::$request->getMethod();
	}

	public function getProtocol(){
		return self::$request->getProtocol();
	}

	public function getHost(){
		return self::$request->getHost();
	}

	public function getPort(){
		return self::$request->getPort();
	}

	public function getPath(){
		return self::$request->getPath();
	}



	public function getQuery(){
		return self::$request->getQuery();
	}

	public function getRemoteAddress(){
		return self::$request->getRemoteAddress();
	}

	public function getCookies(){
		return self::$request->getCookies();
	}

	public function getStatusLine(){
		return self::$request->getStatusLine();
	}

	Public function getProtocolVersion(){
		return self::$request->getProtocolVersion();
	}

	public function getHeaders(){
		return self::$request->getHeaders();
	}

	public function getParsedHeaders(){
		return self::$request->getParsedHeaders();
	}

	public function getBody(){
		return self::$request->getBody();
	}
	
	/**
	 * Returns the message as a string.
	 *
	 * @return string
	 */
	public function toString() {
		return self::$request->toString();
	}
	
	public function toSendableString($fullUri) {
		return self::$request->toSendableString($fullUri);
	}
	
	/**
	 * Returns the message as a string.
	 *
	 * @return string
	 */
	public function __toString() {
		return self::$request->__toString();
	}
}