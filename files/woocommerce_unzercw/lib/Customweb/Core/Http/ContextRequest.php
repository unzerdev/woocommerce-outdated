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

require_once 'Customweb/Core/Http/ContextRequest.php';
require_once 'Customweb/Core/Http/IRequest.php';


/**
 * This class implements the Customweb_Core_Http_IRequest interface, by
 * using the default PHP context variables ($_GET, $_POST, $_SERVER etc.).
 *
 * If you are looking for an implementation which is modifieable use
 * instead Customweb_Core_Http_Request.
 *
 * @author Thomas Hunziker
 *
 */
class Customweb_Core_Http_ContextRequest implements Customweb_Core_Http_IRequest {
	private static $path = null;
	private static $body = null;
	private static $remoteIpAddress = null;
	private static $host = null;
	private static $url = null;
	private static $baseUrl = null;
	private static $protocol = null;
	private static $instance = null;

	/**
	 * @return Customweb_Core_Http_ContextRequest
	 */
	public static function getInstance(){
		if (self::$instance === null) {
			self::$instance = new Customweb_Core_Http_ContextRequest();
		}
		return self::$instance;
	}

	public function getStatusLine(){
		return strtoupper($this->getMethod()) . ' ' . $this->getPath() . ' ' . 'HTTP/' . $this->getProtocolVersion();
	}

	public function getMethod(){
		return $_SERVER['REQUEST_METHOD'];
	}

	public function getProtocolVersion(){
		return str_replace('HTTPS/', '', str_replace('HTTP/', '', $_SERVER['SERVER_PROTOCOL']));
	}

	public function getPath(){
		if (self::$path === null) {
			$request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
			$script_name = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
			$parts = array_diff_assoc($request_uri, $script_name);
			if (empty($parts)) {
				self::$path = '/';
			}
			else {
				$path = implode('/', $parts);
				self::$path = $path;
			}
		}

		return self::$path;
	}

	public function getParsedQuery(){
		$getParameters = array();
		parse_str($_SERVER['QUERY_STRING'], $getParameters);
		return $getParameters;
	}

	public function getQuery(){
		return $_SERVER['QUERY_STRING'];
	}

	public function getParsedBody(){
		return $_POST;
	}

	public function getBody(){
		if (self::$body === null) {
			self::$body = file_get_contents('php://input');
		}
		return self::$body;
	}

	public function getHeaders(){
		$headers = array();
		foreach ($this->getParsedHeaders() as $key => $value) {
			$headers[] = $key . ': ' . $value;
		}
		return $headers;
	}

	public function getRemoteAddress(){
		if (self::$remoteIpAddress === null) {
			self::$remoteIpAddress = self::getClientIp();
		}

		return self::$remoteIpAddress;
	}

	public function getUrl(){
		if (self::$url === null) {
			self::$url = $this->getBaseUrl() . $_SERVER['REQUEST_URI'];
		}

		return self::$url;
	}

	public function getBaseUrl(){
		if (self::$baseUrl === null) {
			$protocol = strtolower($this->getProtocol());
			$port = $this->getPort();
			if (($protocol === "http" && ($port == "80" || $port == '443')) || ($protocol === "https" && ($port == "80" || $port == "443"))) {
				$port = "";
			}
			else {
				$port = ":" . $port;
			}
			self::$baseUrl = $protocol . "://" . $this->getHost() . $port;
		}

		return self::$baseUrl;
	}

	public function getProtocol(){
		if (self::$protocol === null) {
			self::$protocol = 'HTTP';
			if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
				self::$protocol = 'HTTPS';
			}
			else if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https') {
				self::$protocol = 'HTTPS';
			}
		}
		return self::$protocol;
	}

	public function getHost(){
		if (self::$host === null) {
			self::$host = self::getRequestHost();
		}
		return self::$host;
	}

	public function getPort(){
		if (isset($_SERVER['HTTP_X_FORWARDED_PORT'])) {
			return intval($_SERVER['HTTP_X_FORWARDED_PORT']);
		}
		return intval($_SERVER["SERVER_PORT"]);
	}

	public function getParameters(){
		return array_merge($_GET, $_POST);
	}

	public function getCookies(){
		return $_COOKIE;
	}

	public function getParsedHeaders(){
		if (function_exists('getallheaders')) {
			return getallheaders();
		}
		else {
			$headers = array();
			foreach ($_SERVER as $name => $value) {
				if (substr($name, 0, 5) == 'HTTP_') {
					$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
				}
			}
			return $headers;
		}
	}

	public function toSendableString($fullUri){
		return $this->toString();
	}

	/**
	 * Returns the message as a string.
	 *
	 * @return string
	 */
	public function toString(){
		$output = $this->getStatusLine() . "\r\n";
		foreach ($this->getHeaders() as $header) {
			$output .= $header . "\r\n";
		}
		$output .= "\r\n";
		$output .= $this->getBody();
		return $output;
	}

	/**
	 * Returns the message as a string.
	 *
	 * @return string
	 */
	public function __toString(){
		return $this->toString();
	}

	private static function getRequestHost(){
		if (isset($_SERVER['HTTP_X_FORWARDED_HOST']) && !empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
			$host = $_SERVER['HTTP_X_FORWARDED_HOST'];
			$elements = explode(',', $host);
			$host = trim(end($elements));
		}
		else {
			if (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST'])) {
				$host = $_SERVER['HTTP_HOST'];
			}
			else {
				if (isset($_SERVER['SERVER_NAME']) && !empty($_SERVER['SERVER_NAME'])) {
					$host = $_SERVER['SERVER_NAME'];
				}
				else {
					if (isset($_SERVER['SERVER_ADDR']) && !empty($_SERVER['SERVER_ADDR'])) {
						$host = $_SERVER['SERVER_ADDR'];
					}
					else {
						$host = '';
					}
				}
			}
		}

		// Remove port number from host
		$host = preg_replace('/:\d+$/', '', $host);

		return trim($host);
	}

	/**
	 * Returns either ipv4 or ipv6 address. If neither can be identified an exception is thrown.
	 *
	 * Ideally should not be called directly, instead $request->getRemoteAddress() should be used.
	 *
	 * @throws Exception
	 * @return string
	 */
	public static function getClientIp(){
		$ip = self::getClientIpV4();
		if (empty($ip)) {
			$ip = self::getClientIpV6();
		}
		if (empty($ip)) {
			throw new Exception("Unable to retrieve client IP address.");
		}
		return $ip;
	}

	/**
	 * Returns the current ipv4 address or null if cannot be identified.
	 *
	 * @throws Exception
	 * @return string|NULL
	 */
	public static function getClientIpV4(){
		foreach (array(
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR'
		) as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					$ip = trim($ip);

					if (preg_match('/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/', $ip)) {
						return $ip;
					}
				}
			}
		}
		return null;
	}

	/**
	 * Returns the current ipv6 address or null if cannot be identified.
	 *
	 * @throws Exception
	 * @return string|NULL
	 */
	public static function getClientIpV6(){
		foreach (array(
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR'
		) as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					$ip = trim($ip);

					if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
						return $ip;
					}
				}
			}
		}
		return null;
	}

	/**
	 * This method should never be called directly. The method is public due to legacy implementation for Customweb_Core_Util_System.
	 *
	 * @deprecated Use ContextRequest::getClientIp(), or $request->getRemoteAddress()
	 * @throws Exception
	 * @return string
	 */
	public static function getClientIPAddress(){
		foreach (array(
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR'
		) as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					$ip = trim($ip);

					if (preg_match('/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/', $ip)) {
						return $ip;
					}
				}
			}
		}
		throw new Exception("Unable to retrieve the client IPv4 address.");
	}

	/**
	 * This method should never be called directly. The method is public due to legacy implementation for Customweb_Core_Util_System.
	 *
	 * The method returns the client address. It can be either v6 or v4.
	 *
	 * @deprecated Use ContextRequest::getClientIPV6() to force v6, or ContextRequest::getClientIp() to get any ip, or use $request->getRemoteAddress()
	 * @throws Exception
	 * @return string
	 */
	public static function getClientIPAddressV6(){
		foreach (array(
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR'
		) as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					$ip = trim($ip);

					if (filter_var($ip, FILTER_VALIDATE_IP)) {
						return $ip;
					}
				}
			}
		}
		throw new Exception("Unable to retrieve the client IPv6 address.");
	}
}