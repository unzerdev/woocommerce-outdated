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

/**
 * This class implements a URL representation. It is responsible to parse
 * a URL from a string into this structure. This class implements the fluent
 * interface. This means all set methods returns the object itself.
 * 
 */
final class Customweb_Core_Url {

	/**
	 * The scheme is the protocol (https, http etc.)
	 * @var string
	 */
	private $scheme = null;

	/**
	 * The port number of the URL.
	 * @var int
	 */
	private $port = null;

	/**
	 * Host of the URL
	 * @var string
	 */
	private $host = null;

	/**
	 * Username of the URL
	 * @var string
	 */
	private $user = null;

	/**
	 * Password of the URL
	 * @var string
	 */
	private $pass = null;

	/**
	 * Path of the URL.
	 * @var string
	 */
	private $path = '';

	/**
	 * Query part of the URL.
	 * @var string
	 */
	private $query = '';

	/**
	 * The query part of the URL as an array.
	 * @var array
	 */
	private $queryAsArray = [];

	/**
	 * Fragment part of the URL.
	 * @var string
	 */
	private $fragment = '';

	/**
	 * Constructor. Builds the URL from the given URL.
	 *
	 * @param string|Customweb_Http_Url|Customweb_Core_Url $url
	 * @throws InvalidArgumentException
	 * @return Customweb_Core_Url
	 */
	public function __construct($url = null) {
		if ($url instanceof Customweb_Http_Url || $url instanceof Customweb_Core_Url) {
			$this->setScheme($url->getScheme());
			$this->setPort($url->getPort());
			$this->setHost($url->getHost());
			$this->setUser($url->getUser());
			$this->setPass($url->getPass());
			$this->setPath($url->getPath());
			$this->setQuery($url->getQuery());
			$this->setFragment($url->getFragment());
		}
		else if(is_string($url)) {
			$this->setUrlFromString($url);
		}

		return $this;
	}

	/**
	 * Static constructor.
	 * 
	 * @param string|Customweb_Core_Url $url
	 * @return Customweb_Core_Url
	 */
	public static function _($url) {
		return new Customweb_Core_Url($url);
	}
	
	/**
	 * This method parse a given string into this URL structur. If no port is
	 * set, this method will set a default port by the given protocol.
	 *
	 * @param string $url
	 * @throws InvalidArgumentException
	 * @return Customweb_Core_Url
	 */
	public function setUrlFromString($url) {
		$data = [];
		if (is_string($url)) {
			// Parse the given URL.
			$data = parse_url($url);
		}
		else {
			throw new InvalidArgumentException("Parameter $url is not string.");
		}

		foreach ($data as $name => $value) {
			$this->{$name} = $value;
		}

		// Ensures that the parameters are parsed, even if the query is set as string.
		$this->setQuery($this->query);

		if (!isset($this->port)) {
			// We need always a port. Since parse_url does not
			// always set a port, we do it here depending on the
			// protocol:
			switch (strtolower($this->scheme)) {
				case 'https':
				case 'ssl':
					$this->port = 443;
					break;

				case 'ftp':
					$this->port = 21;
					break;
				case 'sftp':
				case 'ssh':
					$this->port = 22;
					break;

				case 'http':
				default:
					$this->port = 80;
					break;
			}
		}

		return $this;
	}

	/**
	 * This method updates the current URL with the given string.
	 *
	 * @param string $url
	 * @return Customweb_Core_Url
	 */
	public function updateUrl($urlString) {
		$url = new Customweb_Core_Url($urlString);

		// some fields shuld only be updated, in case it is a full qualified URL
		if (strstr($urlString, '://')) {
			if (!is_null($url->getHost())) {
				$this->setHost($url->getHost());
			}
			if (!is_null($url->getPort())) {
				$this->setPort($url->getPort());
			}
			if (!is_null($url->getPass())) {
				$this->setPass($url->getPass());
			}
			if (!is_null($url->getScheme())) {
				$this->setScheme($url->getScheme());
			}
			if (!is_null($url->getUser() )) {
				$this->setUser($url->getUser());
			}
		}
		
		if (!is_null($url->getFragment() )) {
			$this->setFragment($url->getFragment());
		}
		if (!is_null($url->getPath())) {
			$this->setPath($url->getPath());
		}
		if (!is_null($url->getQuery())) {
			$this->setQuery($url->getQuery());
		}
		
		return $this;
	}

	/**
	 * Returns this structure as string.
	 *
	 * @return string URL as string
	 */
	public function __toString() {
		return $this->getUrlAsString();
	}

	/**
	 * Returns this structure as string.
	 *
	 * @return string URL as string
	 */
	public function toString() {
		return $this->__toString();
	}

	/**
	 * Returns this structure as string.
	 *
	 * @return string URL as string
	 */
	public function getUrlAsString() {
		$url = $this->getBaseUrl();
		$url .= $this->getFullPath();
		return $url;
	}

	/**
	 * This method returns the path on the server. (everything after the domain)
	 *
	 * @return string Path
	 */
	public function getFullPath() {
		$path = $this->path;
		if (!empty($this->query)) {
			$path .= '?' . $this->query;
		}

		if (!empty($this->fragment)) {
			$path .= '#' . $this->fragment;
		}

		return $path;
	}

	/**
	 * Get URL with out path, query and fragment
	 */
	public function getBaseUrl() {
		$url = $this->scheme . '://';
		if (isset($this->user) && isset($this->pass)) {
			$url .= $this->user . ':' . $this->pass . '@';
		}
		elseif (isset($this->user)) {
			$url .= $this->user . '@';
		}
		$url .= $this->host;
		
		$scheme = strtolower($this->scheme);

		// do not add ports number for 443, and 80 with schemes http or https
		if (!(in_array($scheme, ['http', 'https']) && in_array($this->port, ['443', '80']))) {
			$url .= ':' . $this->port;
		}
		
		return $url;
	}

	/**
	 * Returns the port number.
	 *
	 * @return int Port Number
	 */
	public function getPort() {
		return $this->port;
	}

	/**
	 * Sets the port number
	 *
	 * @param int $port
	 * @throws InvalidArgumentException
	 * @return Customweb_Core_Url
	 */
	public function setPort($port) {
		if (!is_int($port)) {
			throw new InvalidArgumentException("The given port $port is not an integer.");
		}
		$this->port = $port;
		return $this;
	}

	/**
	 * Returns the scheme (protocol) of the URL.
	 *
	 * @return string Scheme
	 */
	public function getScheme() {
		return $this->scheme;
	}

	/**
	 * Sets the scheme of this URL.
	 *
	 * @param string $scheme
	 * @throws InvalidArgumentException
	 * @return Customweb_Core_Url
	 */
	public function setScheme($scheme) {
		if (!is_string($scheme)) {
			throw new InvalidArgumentException("The given scheme is not a string.");
		}
		$this->scheme = $scheme;
		return $this;
	}

	/**
	 * Returns the host part of the URL.
	 *
	 * @return string Host
	 */
	public function getHost() {
		return $this->host;
	}

	/**
	 * Sets the host of this URL.
	 *
	 * @param string $host
	 * @throws InvalidArgumentException
	 * @return Customweb_Core_Url
	 */
	public function setHost($host) {
		if (!is_string($host)) {
			throw new InvalidArgumentException("The given host is not a string.");
		}
		return $this->host = $host;
	}

	/**
	 * This method returns the username. The URL can contain the credential to
	 * access the given URL.
	 *
	 * @return string Username
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Sets the user. The URL can contain the credential to access the given URL.
	 *
	 * @param string $user
	 * @throws InvalidArgumentException
	 * @return Customweb_Core_Url
	 */
	public function setUser($user) {
		if ($user !== null && !is_string($user)) {
			throw new InvalidArgumentException("The given username is not a string.");
		}
		$this->user = $user;
		return $this;
	}

	/**
	 * Returns the password of the this URL. The URL can contain the credential to
	 * access the given URL.
	 *
	 * @return string Password
	 */
	public function getPass() {
		return $this->pass;
	}

	/**
	 * Sets the password of the this URL. The URL can contain the credential to
	 * access the given URL.
	 *
	 * @param string $pass
	 * @throws InvalidArgumentException
	 * @return Customweb_Core_Url
	 */
	public function setPass($pass) {
		if ($pass !== null && !is_string($pass)) {
			throw new InvalidArgumentException("The given password is not a string.");
		}
		$this->pass = $pass;
		return $this;
	}

	/**
	 * This method returns the path of the URL.
	 *
	 * @return string Path
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * Sets the path of the URL.
	 *
	 * @param string $path
	 * @throws InvalidArgumentException
	 * @return Customweb_Core_Url
	 */
	public function setPath($path) {
		if (!is_string($path)) {
			throw new InvalidArgumentException("The given path is not a string.");
		}

		$this->path = $path;
		return $this;
	}

	/**
	 * This method returns the part of the URL after the '?' sign as a array.
	 *
	 * @return array;
	 */
	public function getQueryAsArray() {
		return $this->queryAsArray;
	}

	/**
	 * This method returns the part of the URL after the '?' sign as a string.
	 *
	 * @return string;
	 */
	public function getQuery() {
		return $this->query;
	}

	/**
	 * Sets the query part of the URL (part after '?'). It can be an array or
	 * a string. The string must be of the format 'key=value&key2=value2'. The
	 * array must be keyed with key and the associated value.
	 *
	 * @param string|array $query
	 * @return Customweb_Core_Url
	 */
	public function setQuery($query) {
		if (is_array($query)) {
			$this->query = self::parseArrayToString($query);
			$this->queryAsArray = $query;
		}
		else if(is_string($query)) {
			$this->query = $query;
			parse_str($this->query, $output);
			$this->queryAsArray = $output;
		}
		else {
			throw new InvalidArgumentException('The given parameter \'query\' must be either an array or a string. You give another type.');
		}

		return $this;
	}

	/**
	 * This method adds a single parameter to the query part of the URL.
	 *
	 * @param string $key Parameter Name
	 * @param string|array $value Parameter Value
	 */
	public function appendQueryParameter($key, $value) {
		$query = $this->getQueryAsArray();
		$query[$key] = $value;
		$this->setQuery($query);
		return $this;
	}
	
	/**
	 * Appends a list of parameters to the URL.
	 * 
	 * @param array $parameters
	 * @return Customweb_Core_Url
	 */
	public function appendQueryParameters(array $parameters) {
		$query = $this->getQueryAsArray();
		foreach ($parameters as $key => $value) {
			$query[$key] = $value;
		}
		$this->setQuery($query);
		return $this;
	}

	/**
	 * This method returns the fragment part (part after the '#' sign).
	 *
	 * @return string Fragment
	 */
	public function getFragment() {
		return $this->fragment;
	}

	/**
	 * Sets the fragment part of the URL (part after the '#' sign).
	 *
	 * @param string $fragment
	 * @return Customweb_Core_Url
	 */
	public function setFragment($fragment) {
		$this->fragment = $fragment;
		return $this;
	}

	/**
	 * This method compares two URLs and check if they are equal.
	 *
	 * @param Customweb_Core_Url $url
	 * @return boolean Equal or not
	 */
	public function equals($url) {
		
		if (!($url instanceof Customweb_Core_Url || $url instanceof Customweb_Http_Url)) {
			throw new InvalidArgumentException("Expects that the parameter for equals must be of type 'Customweb_Core_Url'.");
		}
		
		return $this->__toString() == $url->__toString();
	}

	/**
	 * This method parse a given array into a query string.
	 *
	 * @param array $array
	 * @return string Query
	 */
	public static function parseArrayToString($array, $urlencode = true) {
		if(is_array($array)) {
			$string = '';
			$parts = self::toUrlQuery($array, '', $urlencode);
			return implode('&', $parts);
		}
		else {
			return $array;
		}
	}
	
	private static function toUrlQuery(array $array, $prefix, $urlencode) {
		$parts = array();
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				
				$subparts = self::toUrlQuery($value, self::applyPrefixOnKey($key, $prefix), $urlencode);
				
				$parts = array_merge($parts, $subparts);
			}
			else {
				if ($urlencode) {
					$parts[] = self::applyPrefixOnKey($key, $prefix) . '=' . urlencode($value);
				}
				else {
					$parts[] = self::applyPrefixOnKey($key, $prefix) . '=' . $value;
				}
			}
		}
		return $parts;
	}

	private static function applyPrefixOnKey($key, $prefix) {
		if (!empty($prefix)) {
			return $prefix . '[' . $key . ']';
		}
		else {
			return $key;
		}
	}
	
	/**
	 * This method converts all relative and absolute URLs to absolute URLs.
	 *
	 * @param string $href
	 * @param Customweb_Core_Url $baseUrl
	 * @return Customweb_Core_Url
	 */
	public static function toAbsoluteUrl($href, Customweb_Core_Url $baseUrl) {
		if ($href instanceof Customweb_Core_Url) {
			return $href;
		}

		$href = (string)$href;
		$href = trim($href);

		// If the URL string contains :// then the protocol etc. defined.
		if (strstr($href, '://')) {
			return new Customweb_Core_Url($href);
		}
		else {
			// Append a slash at the begin, when there is no one. This
			// insures that we get always a valid URL.
			if (substr($href, 0, 1) !== '/') {
				$href = '/' . $href;
			}
			return new Customweb_Core_Url($baseUrl->getBaseUrl() . $href);
		}
	}
}
