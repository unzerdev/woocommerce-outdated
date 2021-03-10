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

require_once 'Customweb/Core/Http/IResponse.php';
require_once 'Customweb/Core/String.php';
require_once 'Customweb/Core/Http/ICookie.php';
require_once 'Customweb/Core/Http/AbstractMessage.php';
require_once 'Customweb/Core/Http/Response.php';
require_once 'Customweb/Core/Http/Cookie.php';


/**
 * This is a default implementation of the Customweb_Core_Http_IResponse interface. It provide read
 * and write method including the handling of cookies.
 *
 * @author Thomas Hunziker
 *
 */
class Customweb_Core_Http_Response extends Customweb_Core_Http_AbstractMessage implements Customweb_Core_Http_IResponse {

	const HEADER_KEY_COOKIE = 'set-cookie';

	const HEADER_KEY_LOCATION = 'location';

	private static $statusCodeMessageMap = array(
		100 => 'Continue',
		101 => 'Switching Protocols',
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		307 => 'Temporary Redirect',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Time-out',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Large',
		415 => 'Unsupported Media Type',
		416 => 'Requested range not satisfiable',
		417 => 'Expectation Failed',
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Time-out',
		505 => 'HTTP Version not support',
	);

	/**
	 * @var int
	 */
	private $statusCode = 200;

	/**
	 * @var string
	 */
	private $statusMessage = 'OK';

	/**
	 * @var Customweb_Core_Http_ICookie[]
	 */
	private $cookies = array();

	/**
	 * @var string
	 */
	private $location = null;

	/**
	 * Constructs a new response object. The input can be either a response object or a
	 * raw HTTP message as string.
	 *
	 * @param Customweb_Core_Http_IResponse|string $response
	 */
	public function __construct($message = null) {
		if ($message !== null) {
			if ($message instanceof Customweb_Core_Http_Response) {
				parent::__construct($message);
				$this->statusCode = $message->statusCode;
				$this->statusMessage = $message->statusMessage;
				$this->cookies = $message->cookies;
				$this->location = $message->location;
			}
			else if ($message instanceof Customweb_Core_Http_IResponse) {
				$this->setBody($message->getBody());
				$this->setHeaders($message->getHeaders());
				$this->parseStatusLine($message->getStatusLine());
			}
			else {
				$message = (string)$message;
				parent::__construct($message);
			}
		}
		else {
			parent::__construct();
			$this->setContentType('text/html; charset=utf-8');
		}
	}

	/**
	 * Creates a regular response and the given string as body.
	 *
	 * @param string Customweb_Core_Http_Response
	 */
	public static function _($body) {
		$response = new Customweb_Core_Http_Response();
		$response->setBody($body);
		return $response;
	}

	/**
	 * Creates a response with a header redirection to the given
	 * URL.
	 *
	 * @param string $url
	 * @return Customweb_Core_Http_Response
	 */
	public static function redirect($url) {
		$response = new Customweb_Core_Http_Response();
		$response->setLocation($url);
		return $response;
	}

	/**
	 * This method creates a redirect which uses the HTML head for redirection. Most
	 * HTTP client implementation will not follow this redirection.
	 *
	 * @param string $url
	 * @return Customweb_Core_Http_Response
	 */
	public static function htmRedirect($url) {
		$body =
		'<html>
			<head>
				<meta http-equiv="refresh" content="0; url=' . $url . '" />
			</head>
			<body>You will be redirected.</body>
		</html>';
		$response = new Customweb_Core_Http_Response();
		$response->setBody($body);
		return $response;
	}

	public function getStatusLine() {
		return 'HTTP/' . $this->getProtocolVersion() . ' ' . $this->getStatusCode() . ' ' . $this->getStatusMessage();
	}

	protected function parseStatusLine($line) {
		if (empty($line)) {
			throw new Exception("Empty status line provided.");
		}
		preg_match('/HTTP\/([^[:space:]])+[[:space:]]+([0-9]*)(.*)/i', $line, $result);
		$this->setProtocolVersion((int)$result[1]);
		$this->setStatusCode((int)$result[2]);
		if (strtolower($this->getStatusMessage()) != $result[3]) {
			$this->setStatusMessage($result[3]);
		}
	}


	/**
	 * Returns a list of cookies defined for this response.
	 *
	 * @return multitype:Customweb_Core_Http_ICookie
	 */
	public function getCookies() {
		return $this->cookies;
	}

	/**
	 * Returns true when a cookie is set with the given key. The key
	 * is case sensitive.
	 *
	 * @param string $cookieKey
	 * @return boolean
	 */
	public function hasCookie($cookieKey) {
		$cookies = $this->getCookies();
		if (isset($cookies[$cookieKey])) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns the value of the given cookie. The cookie key is case
	 * sensitive.
	 *
	 * @param string $cookieKey
	 * @throws Exception In case the given cookie key is not defined.
	 * @return string
	 */
	public function getCookieValue($cookieKey) {
		$cookies = $this->getCookies();
		if (isset($cookies[$cookieKey])) {
			return $cookies[$cookieKey]->getValue();
		}
		else {
			throw new Exception(Customweb_Core_String::_("No cookie for key '@key'.")->format(array('@key' => $cookieKey))->toString());
		}
	}

	/**
	 * Defines a cookie on the response. The method may override those
	 * cookies which has the same value.
	 *
	 * @param Customweb_Core_Http_ICookie $cookie
	 * @return Customweb_Core_Http_Response
	 */
	public function setCookie(Customweb_Core_Http_ICookie $cookie) {
		$tmp = new Customweb_Core_Http_Cookie($cookie);
		$this->addHeader($tmp->toHeaderString());
		return $this;
	}

	/**
	 * Removes all cookies in the request.
	 *
	 * @return Customweb_Core_Http_Response
	 */
	public function removeCookies() {
		$this->removeHeadersWithKey(self::HEADER_KEY_COOKIE);
		return $this;
	}

	public function getStatusCode(){
		return $this->statusCode;
	}

	/**
	 * Sets the status code.
	 *
	 * @param int $statusCode
	 * @throws Exception
	 * @return Customweb_Core_Http_Response
	 */
	public function setStatusCode($statusCode){
		if (!is_int($statusCode)) {
			throw new Exception("The given status code is not an integer.");
		}
		$this->statusCode = $statusCode;
		return $this;
	}

	public function getStatusMessage(){
		if ($this->statusMessage !== null) {
			return $this->statusMessage;
		}
		else if (isset(self::$statusCodeMessageMap[$this->getStatusCode()])) {
			return self::$statusCodeMessageMap[$this->getStatusCode()];
		}
		else {
			return '';
		}
	}

	/**
	 * Sets the status message. By default the status message es determine by the
	 * set status code.
	 *
	 * @param string $statusMessage
	 * @return Customweb_Core_Http_Response
	 */
	public function setStatusMessage($statusMessage){
		if (!is_string($statusMessage)) {
			$statusMessage = (string)$statusMessage;
		}
		$this->statusMessage = $statusMessage;
		return $this;
	}

	/**
	 * Returns the location header of the response. It can be null in
	 * case no location header is set.
	 *
	 * @return string
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * The location header URL.
	 *
	 * @param string $locationUrl
	 * @return Customweb_Core_Http_Response
	 */
	public function setLocation($locationUrl) {
		$locationUrl = (string)$locationUrl;
		$this->removeHeadersWithKey(self::HEADER_KEY_LOCATION);
		$this->appendHeader(self::HEADER_KEY_LOCATION . ': ' . $locationUrl);
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::setBody()
	 * @return Customweb_Core_Http_Response
	 */
	public function setBody($body) {
		return parent::setBody($body);
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::appendBody()
	 * @return Customweb_Core_Http_Response
	 */
	public function appendBody($string) {
		return parent::appendBody($string);
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::prependBody()
	 * @return Customweb_Core_Http_Response
	 */
	public function prependBody($string) {
		return parent::prependBody($string);
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::setHeaders()
	 * @return Customweb_Core_Http_Response
	 */
	public function setHeaders(array $headers){
		parent::setHeaders($headers);
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::appendHeader()
	 * @return Customweb_Core_Http_Response
	 */
	public function appendHeader($header) {
		return parent::appendHeader($header);
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::prependHeader()
	 * @return Customweb_Core_Http_Response
	 */
	public function prependHeader($header) {
		return parent::prependHeader($header);
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::setProtocolVersion()
	 * @return Customweb_Core_Http_Response
	 */
	public function setProtocolVersion($protocolVersion) {
		return parent::setProtocolVersion($protocolVersion);
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::setContentType()
	 * @return Customweb_Core_Http_Response
	 */
	public function setContentType($contentType) {
		return parent::setContentType($contentType);
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Core_Http_AbstractMessage::setContentEncoding()
	 * @return Customweb_Core_Http_Response
	 */
	public function setContentEncoding($contentEncoding) {
		return parent::setContentEncoding($contentEncoding);
	}

	/**
	 * This method sends the response as it is to the browser. Means that the
	 * headers and the body are sent with 'echo' and 'header()' to the browser
	 *
	 * @return void
	 */
	public function send() {
		// Send headers
		header($this->getStatusLine(), true, $this->getStatusCode());
		foreach ($this->getHeaders() as $header) {
			// We do not send the content length when we send the response to prevent sending a header which is wrong
			// and the webserver eventually compresses it.
			if (0 !== strpos(strtolower($header), self::HEADER_KEY_CONTENT_LENGTH)) {
				header($header);
			}
		}

		echo $this->getBody();
	}

	protected function processKeyedHeader($headerKey, $headerValue) {
		parent::processKeyedHeader($headerKey, $headerValue);
		if ($headerKey == self::HEADER_KEY_COOKIE) {
			$this->processCookieHeader($headerValue);
		}
		else if ($headerKey == self::HEADER_KEY_LOCATION) {
			$this->setStatusCode(302);
			$this->location = $headerValue;
		}
	}

	protected function resetHeaders() {
		parent::resetHeaders();
		$this->cookies = array();
		$this->location = null;
	}

	/**
	 * Parses the given header value into a set of cookies.
	 *
	 * @param string $value
	 */
	protected function processCookieHeader($value) {
		$pairs = explode(';', $value);
		$expiryDate = null;
		$domain = null;
		$path = null;
		$values = array();
		$httpOnly = false;
		$secure = false;
		foreach ($pairs as $pair) {
			$keyValues = explode('=', trim($pair), 2);
			if (count($keyValues) == 2) {
				switch (strtolower($keyValues[0])) {
					case Customweb_Core_Http_ICookie::KEY_PATH:
						$path = urldecode(trim($keyValues[1]));
						break;
					case Customweb_Core_Http_ICookie::KEY_DOMAIN:
						$domain = urldecode(trim($keyValues[1]));
						break;
					case Customweb_Core_Http_ICookie::KEY_EXPIRY_DATE:
						$expiryDate = strtotime(urldecode(trim($keyValues[1])));
						break;
					default:
						$values[trim($keyValues[0])] = trim($keyValues[1]);
				}
			}
			else if (count($keyValues) == 1) {
				switch (strtolower($keyValues[0])) {
					case Customweb_Core_Http_ICookie::KEY_HTTP_ONLY:
						$httpOnly = true;
						break;
					case Customweb_Core_Http_ICookie::KEY_SECURE:
						$secure = true;
						break;
					default:
						$values[trim($keyValues[0])] = null;
				}
			}
		}
		$cookies = array();
		foreach ($values as $key => $value) {
			$cookie = new Customweb_Core_Http_Cookie();
			$cookie->setRawName($key)->setRawValue($value)->setDomain($domain)->setPath($path)->setExpiryDate($expiryDate)->setHttpOnly($httpOnly)->setSecure($secure);
			$this->cookies[$cookie->getName()] = $cookie;
		}
	}

}