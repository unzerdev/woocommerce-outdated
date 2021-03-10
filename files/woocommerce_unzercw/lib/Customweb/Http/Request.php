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

require_once 'Customweb/Http/Url.php';
require_once 'Customweb/Http/Response.php';
require_once 'Customweb/Http/ConnectionException.php';

/**
 * This class implements the HTTP request. It is responsible for building
 * the headers, the body and the message of the request.
 *
 * It does also handle over the response from the server to the response
 * class.
 *
 * All set methods and the constructor implements the fluent API
 * interface.
 *
 * @deprecated Use instead the core implementation
 */
class Customweb_Http_Request {

	/**
	 * The HTTP client used when we do some requests on the server.
	 * @var string
	 */
	const USER_AGENT = 'Customweb HTTP Client';

	/**
	 * The URL on which we send the request.
	 * @var Customweb_Http_Url
	 */
	private $url = NULL;

	/**
	 * The response handler of this request.
	 * @var Customweb_Http_Response
	 */
	private $responseHandler = NULL;

	/**
	 * The request HTTP method.
	 * @var string
	 */
	private $method = 'GET';

	/**
	 * The request headers.
	 * @var array
	 */
	private $headers = array();

	/**
	 * The custom headers of this request.
	 * @var array
	 */
	private $customHeaders = array();

	/**
	 * The body part of this request.
	 * @var string
	 */
	private $body = '';

	/**
	 * The whole message send to the server.
	 * @var string
	 */
	private $message = '';

	/**
	 * This flag indicates if the certificate authority should be
	 * checked or not. Its recommended to activate this always.
	 *
	 * @var boolean
	 */
	private $isCertificateAuthorityCheckRequired = true;

	/**
	 * The number of http header redirects to follow. If it is 0 (zero), then a unlimited
	 * number of redirects are handled. If it is NULL, then no redirections are handled.
	 *
	 * @var int
	 */
	private $redirectionFollowLimit = NULL;

	/**
	 * The currently executed number of redirects.
	 *
	 * @var int
	 */
	private $currentNumberOfRedirects = 0;

	/**
	 * @var Customweb_Http_Url
	 */
	private $proxyUrl;


	/**
	 * The path to the client certificate. The certificate is one X.509 Certificate in PEM format containing both the Certificate itself and the corresponding private key
	 *
	 * @var String
	 */
	private $clientCertificatePath = NULL;


	/**
	 * The optional passphrase to the client certificate
	 *
	 * @var String
	 */
	private $clientCertificatePassPhrase = NULL;

	/**
	 * The connection timeout in seconds.
	 *
	 * @var int
	 */
	private $timeout = 10;
	
	/**
	 * Whether to send the request asynchronously.
	 * If set to true, the request will not wait for an answer from the server.
	 * 
	 * @var boolean
	 */
	private $asynchronous = false;

	/**
	 * This method init the request class.
	 *
	 * @param string|Customweb_Http_Url $url
	 * @return Customweb_Http_Request
	 * @throws InvalidArgumentException
	 */
	public function __construct($url) {
		if ($url instanceof Customweb_Http_Url) {
			$this->setUrl($url);
		}
		elseif (is_string($url)) {
			$this->setUrl(new Customweb_Http_Url($url));
		}
		else {
			throw new InvalidArgumentException('The argument $url is not valid.');
		}

		$this->setResponseHandler(new Customweb_Http_Response());
		return $this;
	}


	/**
	 * Send a request to the server
	 *
	 * @param string $body Body
	 * @return Customweb_Http_Response Response
	 */
	public function send($body = NULL) {
		if ($body !== NULL) {
			if (is_array($body)) {
				$body = Customweb_Http_Url::parseArrayToString($body);
			}
			$this->setBody($body);
		}

		$this->sendMessageBySocket();

		if (!$this->isAsynchronous()) {
			$handler = $this->getResponseHandler();
			$handler->process($this);
		}

		return $this->handleHttpRedirections();
	}

	/**
	 * This method handles the case, when the response contains any HTTP
	 * redirection in the header.
	 *
	 * @return Customweb_Http_Response Response
	 */
	protected function handleHttpRedirections() {
		$limit = $this->getRedirectionFollowLimit();
		if ($limit !== NULL) {
			if ($limit > $this->currentNumberOfRedirects || $limit === 0) {
				$headers = $this->getResponseHandler()->getHeaders();
				if (isset($headers['location'])) {
					$url = trim($headers['location']);
					if (!empty($url)) {
						$this->getUrl()->updateUrl($url);
						$this->buildMessage();
						$this->getResponseHandler()->reset();
						$this->currentNumberOfRedirects++;
						return $this->send();
					}
				}
			}
		}
		return $this->getResponseHandler();
	}

	/**
	 * This method sets the user agent of the request. Per default the user agent set in
	 * Customweb_Http_Request::USER_AGENT is used.
	 *
	 * @param unknown_type $userAgent The user agent name to use.
	 * @return Customweb_Http_Request
	 */
	public function setUserAgent($userAgent) {
		$this->appendCustomHeaders(array('user-agent' => $userAgent));
		return $this;
	}

	/**
	 * This method returns the user agent used for this request.
	 *
	 * @return string User Agent
	 */
	public function getUserAgent() {
		$headers = $this->getCustomHeaders();
		if (isset($headers['user-agent'])) {
			return $headers['user-agent'];
		}
		else {
			return self::USER_AGENT;
		}
	}

	/**
	 * This method sets the cookie used for this request. The cookie parameter accepts either a string of
	 * cookie parameters or a string, that is set as the cookie in the HTTP header.
	 *
	 * @param string|array $cookies
	 * @throws InvalidArgumentException
	 * @return Customweb_Http_Request
	 */
	public function setCookies($cookies) {

		$cookiesString = '';
		if (is_array($cookies)) {
			foreach($cookies as $key => $value) {
				$cookiesString .= $key . '=' . $value . '; ';
			}
		}
		else if(is_string($cookies)) {
			$cookiesString = $cookies;
		}
		else {
			throw new InvalidArgumentException('You can cookies only either by a string or an array of parameters. ' .
				'The given $cookies is not a string and not an array.');
		}

		$this->appendCustomHeaders(array('cookie' => $cookiesString));

		return $this;
	}

	/**
	 * This method sends the message to the server with a socket connection.
	 *
	 * @param string $host
	 * @param string $port
	 * @param string $message
	 * @throws Customweb_Http_ConnectionException
	 */
	protected function sendMessageBySocket() {
		$message = $this->getMessage();

		$fp = $this->createSocketStream();

		if (!@fwrite($fp, $message)) {
			throw new Customweb_Http_ConnectionException('Could not send the message to the server.');
		}

		if (!$this->isAsynchronous()) {
			$handler = $this->getResponseHandler();
			while (!feof($fp)) {
				$handler->addPart(fgets($fp, 8192));
			}
		}
		fclose($fp);
	}

	/**
	 * This method creates a stream socket to the server.
	 *
	 * @throws Customweb_Http_ConnectionException
	 * @return stream resource
	 */
	protected function createSocketStream() {

		if (!function_exists('stream_socket_client')) {
			throw new Customweb_Http_ConnectionException("The HTTP client requires to activate the stream_socket_client() function.");
		}
		if (!extension_loaded('openssl')) {
			throw new Customweb_Http_ConnectionException("You have to enable OpenSSL.");
		}

		if ($this->isProxyActive()) {
			$host = $this->getProxyUrl()->getHost();
			$port = $this->getProxyUrl()->getPort();
		}
		else {
			// Change host if ssl is used:
			if($this->isSSLConnection()) {
				$version = $this->getSSLVersion();
				if ($version !== null) {
					$host = "sslv" . $version . "://".$this->getUrl()->getHost();
				}
				else {
					$host = "ssl://".$this->getUrl()->getHost();
				}
			}
			else {
				$host = $this->getUrl()->getHost();
			}
			$port = $this->getUrl()->getPort();
		}

		$socket = $host . ':' . $port;

		// We wrap the socket creation with a custom error handle, to make an exception
		// instead of warrnings.
		set_error_handler( array( $this, 'handleSocketErrors' ) );
		try {
			$fp = stream_socket_client($socket, $errno, $errstr, $this->getConnectionTimeout(), STREAM_CLIENT_CONNECT, $this->createStreamContext());
		} catch (Exception $e) {
			restore_error_handler();
			throw $e;
		}
		restore_error_handler();

		if ($fp === false) {
			$errorMessage = 'Could not connect to the server. Host: ' . $socket . ' ';
			$errorMessage .= '(Error: ' . $errno . ', Error Message: ' . $errstr . ')';
			throw new Customweb_Http_ConnectionException($errorMessage);
		}

		if (!(get_resource_type($fp) == 'stream')) {
			$errorMessage = 'Could not connect to the server. The returned socket was not a stream. Host: ' . $socket . ' ';
			throw new Customweb_Http_ConnectionException($errorMessage);
		}

		return $fp;
	}

	protected function isProxyActive() {
		if ($this->getProxyUrl() !== NULL) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * @return Customweb_Http_Url
	 */
	protected function getProxyUrl() {
		if ($this->proxyUrl === NULL) {
			$proxy = NULL;
			if (!empty($_SERVER['PHP_STREAM_PROXY_SERVER'])){
				$proxy = $_SERVER['PHP_STREAM_PROXY_SERVER'];
			}
			if (!empty($_SERVER['php_stream_proxy_server'])){
				$proxy = $_SERVER['php_stream_proxy_server'];
			}
			
			if (!empty($_SERVER['PHP_HTTP_CLIENT_PROXY_URL'])){
				$proxy = $_SERVER['PHP_HTTP_CLIENT_PROXY_URL'];
			}
			if (!empty($_SERVER['php_http_client_proxy_url'])){
				$proxy = $_SERVER['php_http_client_proxy_url'];
			}
			
			if ($proxy !== NULL) {
				$this->proxyUrl = new Customweb_Http_Url($proxy);
			}
			else {
				$this->proxyUrl = false;
			}
		}

		if ($this->proxyUrl === false) {
			return NULL;
		}
		else {
			return $this->proxyUrl;
		}
	}
	
	protected function getSSLVersion() {
		if (!empty($_SERVER['PHP_STREAM_SSL_VERSION'])){
			return (int)$_SERVER['PHP_STREAM_SSL_VERSION'];
		}
		else if (!empty($_SERVER['php_stream_ssl_version'])){
			return (int)$_SERVER['php_stream_ssl_version'];
		}
		
		return null;
	}
	
	protected function getForcedIPVersion() {
		if (!empty($_SERVER['FORCED_IP_VERSION'])) {
			return (int) $_SERVER['FORCED_IP_VERSION'];
		}
		else if(!empty($_SERVER['forced_ip_version'])) {
			return (int) $_SERVER['forced_ip_version'];
		}
		return null;
	}

	protected function createStreamContext() {
		$options = array(
			'http' => array(),
			'ssl' => array(),
		);

		if ($this->isSSLConnection()) {
			$options['ssl']['verify_host'] = true;
			$options['ssl']['allow_self_signed'] = false;
			$options['ssl']['verify_peer'] = false;

			if ($this->isCertificateAuthorityCheckRequired()) {
				$options['ssl']['verify_peer'] = true;
				$options['ssl']['cafile'] = $this->findAuthorityFile();
			}
			if($this->clientCertificatePath != null) {
				if(!file_exists($this->clientCertificatePath)){
					throw new Exception('Could not find the Client Certificate: '.$this->clientCertificatePath);
				}
				$options['ssl']['local_cert'] = $this->clientCertificatePath;
				if($this->clientCertificatePassPhrase != null){
					$options['ssl']['passphrase'] = $this->clientCertificatePassPhrase;
				}
			}
		}
		if ($this->getForcedIPVersion() !== null) {
			if($this->getForcedIPVersion() == 4){
				$options['socket'] = array('bindto' => '0.0.0.0:0');
			}
			elseif ($this->getForcedIPVersion() == 6) {
				$options['socket'] = array( 'bindto' => '[::]:0');
			}
		}
		
		if ($this->isProxyActive()) {
			$options['http']['proxy'] = $this->getProxyUrl()->toString();
			$options['http']['request_fulluri'] = true;
		}
		
		return stream_context_create($options);
	}

	protected function findAuthorityFile() {
		// We need to thead the ca file as a PHP file to be copied always with the other files.
		$caFileName = 'ca-bundle.crt.php';

		$baseFile = dirname(__FILE__) . '/'. $caFileName;
		if (file_exists($baseFile)) {
			return $baseFile;
		}

		$classPath = '/Customweb/Http';

		$include_path = explode(PATH_SEPARATOR, get_include_path());
		foreach($include_path as $path) {
			$potentialFileLocation = $path . $classPath . '/' . $caFileName;
			if(file_exists($potentialFileLocation)) {
				return $potentialFileLocation;
			}
		}
		throw new Exception("Could not find the Certificate Authority file 'ca-bundle.crt'.");
	}

	/**
	 * This method is used to capture the warrnings produced by the stream_socket_client
	 * function.
	 *
	 * @param int $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param int $errline
	 * @throws Customweb_Http_ConnectionException
	 */
	public function handleSocketErrors($errno, $errstr, $errfile, $errline) {
		$message = str_replace('stream_socket_client(): ', '', $errstr);
		$message .= "; Try to connect to: " . $this->getUrl()->toString();

		throw new Customweb_Http_ConnectionException($message);
	}

	/**
	 * Checks if the current URL is a secured URL or not.
	 *
	 * @return boolean
	 */
	private function isSSLConnection() {
		if($this->getUrl()->getPort() == 443 || $this->getUrl()->getScheme() == 'https') {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * This method builds the whole message to send to the
	 * server.
	 *
	 * @return string Message
	 */
	protected function buildMessage() {
		$this->buildHeader();
		$this->message = '';


		foreach ($this->headers as $name => $value) {
			if (is_string($name)) {
				$this->message .= $name . ': ' . $value . "\r\n";
			}
			else {
				$this->message .= $value . "\r\n";
			}
		}

		$this->message = substr($this->message, 0, -2);
		$body = $this->getBody();
		$this->message .= "\r\n\r\n";
		if (!empty($body)) {
			$this->message .= $body;
		}
		return $this->message;
	}

	/**
	 * This method builds all headers of this request.
	 *
	 * @return array Headers
	 */
	protected function buildHeader() {
		$this->headers = array();

		$path = $this->getUrl()->getFullPath();
		if ($this->isProxyActive()) {
			$path = $this->getUrl()->toString();
		}

		$this->headers[] = $this->getMethod() . ' ' . $path . ' HTTP/1.1';
		$this->headers['host'] = $this->getUrl()->getHost();

		$this->headers['user-agent'] = self::USER_AGENT;

		$user = $this->getUrl()->getUser();
		$pass = $this->getUrl()->getPass();
		if (!empty($user)) {
			$this->headers['authorization'] = 'Basic ' . base64_encode($user . ':' . $pass);
		}

		foreach ($this->customHeaders as $key => $header) {
			if (is_string($key)) {
				$this->headers[strtolower($key)] = $header;
			}
			else {
				$this->headers[] = $header;
			}
		}

		$body = $this->getBody();
		$this->headers['content-length'] = strlen($body);

		// Append proxy headers
		if ($this->isProxyActive()) {
			$proxyUrl = $this->getProxyUrl();
			// Set proxy authorization
			if ($proxyUrl->getUser() !== NULL) {
				$auth = $proxyUrl->getUser();
				if ($proxyUrl->getPass() !== NULL) {
					$auth .= ':' . $proxyUrl->getPass();
				}
				$auth = base64_encode($auth);
				$this->headers['proxy-authorization'] = "Basic {$auth}";
			}
		}

		$this->headers['connection'] = 'close';

		return $this->headers;
	}

	/**
	 * This method sets the response handler of this request. The response
	 * handler takes the incoming message and does some custom handling on it.
	 *
	 * @param Customweb_Http_Response $handler
	 * @return Customweb_Http_Request
	 */
	public function setResponseHandler(Customweb_Http_Response $handler) {
		$this->responseHandler = $handler;
		return $this;
	}

	/**
	 * This method returns the current set response handler.
	 *
	 * @return Customweb_Http_Response
	 */
	public function getResponseHandler() {
		return $this->responseHandler;
	}

	/**
	 * This method returns the HTTP request method.
	 *
	 * @return string Method
	 */
	public function getMethod() {
		return $this->method;
	}

	/**
	 * This method sets the HTTP method to use for
	 * this request.
	 *
	 * @param string $method
	 */
	public function setMethod($method) {
		$method = strtoupper($method);
		if ($method == 'POST') {
			$this->appendCustomHeaders(array('Content-Type' => 'application/x-www-form-urlencoded'));
		}
		$this->method = $method;
		return $this;
	}

	/**
	 * This method appends addtional headers to the existing headers.
	 *
	 * @param array $headers Headers to append to the existing one.
	 * @return Customweb_Http_Request
	 */
	public function appendCustomHeaders(array $headers) {

		$customHeaders = $this->getCustomHeaders();
		foreach ($headers as $key => $header) {
			if (is_string($key)) {
				$customHeaders[strtolower($key)] = $header;
			}
			else {
				$customHeaders[] = $header;
			}
		}
		$this->setCustomHeaders($customHeaders);

		return $this;
	}

	/**
	 * This method sets all custom headers.
	 *
	 * @param array $headers
	 * @return Customweb_Http_Request
	 */
	public function setCustomHeaders(array $headers) {
		$this->customHeaders = $headers;
		return $this;
	}

	/**
	 * This method returns all custom hearders.
	 * @return array Headers
	 */
	public function getCustomHeaders() {
		return $this->customHeaders;
	}

	/**
	 * This method returns all headers of this
	 * request.
	 *
	 * @return array Headers
	 */
	public function getHeader() {
		if (count($this->headers) == 0) {
			$this->buildHeader();
		}
		return $this->headers;
	}

	/**
	 * This method returns the HTTP message of
	 * this request.
	 *
	 * @return string Message
	 */
	public function getMessage() {
		if (strlen($this->message) == 0) {
			$this->buildMessage();
		}
		return $this->message;
	}

	/**
	 * This method returns the body of the request. If there is no bodyin case
	 * of for example on a GET request, then this method returns NULL.
	 *
	 * @return string Body
	 */
	public function getBody() {
		return $this->body;
	}

	/**
	 * This method sets the message body. If you want to send no body, then
	 * you can set the body to NULL with this method.
	 *
	 * @param string|array $body Body
	 * @return Customweb_Http_Request
	 */
	public function setBody($body) {

		if (is_array($body)) {
			$this->body = Customweb_Http_Url::parseArrayToString($body, true);
		}
		else {
			$this->body = $body;
		}

		return $this;
	}

	/**
	 * This method returns the URL on which we send the request.
	 *
	 * @return Customweb_Http_Url
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * This method sets the URL on which we send the request.
	 *
	 * @param Customweb_Http_Url $url
	 * @return Customweb_Http_Request
	 */
	public function setUrl(Customweb_Http_Url $url) {
		$this->url = $url;
		return $this;
	}

	/**
	 * This method activates the check of the certificate authority.
	 *
	 * @see isCertificateAuthorityCheckRequired()
	 * @return Customweb_Http_Request
	 */
	public function activateCertificateAuthorityCheck() {
		$this->isCertificateAuthorityCheckRequired = true;
		return $this;
	}

	/**
	 * This method deactivate the check of the certificate authority.
	 *
	 * @see isCertificateAuthorityCheckRequired()
	 * @return Customweb_Http_Request
	 */
	public function deactivateCertifcateAuthorityCheck() {
		$this->isCertificateAuthorityCheckRequired = false;
		return $this;
	}

	/**
	 * This method returns if the certificate authority is
	 * checked during the call or not.
	 *
	 * The certificate authority (CA) check does validate the certificate
	 * provided by the remote server. Therefore a list of CA's is used
	 * to check if the given certificate is in the certificate chain.
	 *
	 * @return boolean
	 */
	public function isCertificateAuthorityCheckRequired() {
		return $this->isCertificateAuthorityCheckRequired;
	}

	/**
	 * The number of http header redirects to follow. If it is 0 (zero), then a unlimited
	 * number of redirects are handled. If it is NULL, then no redirections are handled.
	 *
	 * The default value is NULL.
	 *
	 * @return int
	 */
	public function getRedirectionFollowLimit() {
		return $this->redirectionFollowLimit;
	}

	/**
	 * The number of http header redirects to follow. If it is 0 (zero), then a unlimited
	 * number of redirects are handled. If it is NULL, then no redirections are handled.
	 *
	 * @param int $limit The maximal number of redirects done automatically.
	 * @return Customweb_Http_Request
	 */
	public function setRedirectionFollowLimit($limit) {
		$this->redirectionFollowLimit = $limit;
		return $this;
	}

	/**
	 * This method sets the path to a client certificate used to connect to
	 * the remote server. The format of the certificate must be PEM.
	 *
	 * @param string $path
	 * @return Customweb_Http_Request
	 */
	public function setClientCertificatePath($path) {
		$this->clientCertificatePath = $path;
		return $this;
	}

	/**
	 * Returns the path to the client certificate.
	 *
	 * @return string
	 */
	public function getClientCertificatePath() {
		return $this->clientCertificatePath;
	}

	/**
	 * This method sets the pass phrase for the client certificate.
	 *
	 * @param string $passPhrase
	 * @return Customweb_Http_Request
	 */
	public function setClientCertificatePassPhrase($passPhrase) {
		$this->clientCertificatePassPhrase = $passPhrase;
		return $this;
	}

	/**
	 * Returns the connection timeout in seconds.
	 *
	 * @return int Timeout in seconds.
	 */
	public function getConnectionTimeout() {
		return $this->timeout;
	}

	/**
	 * This method sets the connection timeout in seconds. Per default the
	 * timeout is set to 10 seconds.
	 *
	 * @param int $timeout
	 * @return Customweb_Http_Request
	 */
	public function setConnectionTimeout($timeout) {
		$this->timeout = $timeout;
		return $this;
	}

	public function isAsynchronous()
	{
		return $this->asynchronous;
	}

	public function setAsynchronous($asynchronous = true)
	{
		$this->asynchronous = (boolean) $asynchronous;
		return $this;
	}

}
