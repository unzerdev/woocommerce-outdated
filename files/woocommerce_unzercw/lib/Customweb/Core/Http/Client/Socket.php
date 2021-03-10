<?php

/**
 *  * You are allowed to use this API in your web application.
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

require_once 'Customweb/Core/Http/Client/ConnectionException.php';
require_once 'Customweb/Core/String.php';
require_once 'Customweb/Core/Http/Client/ConnectionTimeoutException.php';
require_once 'Customweb/Core/Util/Error.php';
require_once 'Customweb/Core/Http/Request.php';
require_once 'Customweb/Core/Http/Response.php';
require_once 'Customweb/Core/Logger/Factory.php';
require_once 'Customweb/Core/Http/Client/Abstract.php';


/**
 * HTTP Client implementation with PHP sockets.
 * The client requires a minimal set of
 * extensions persent (only the function stream_socket_client() and for SSL OpenSSL).
 *
 * @author Thomas Hunziker
 *
 */
class Customweb_Core_Http_Client_Socket extends Customweb_Core_Http_Client_Abstract {
	private $startTime;
	/**
	 *
	 * @var Customweb_Core_ILogger
	 */
	private $logger;

	public function __construct(){
		if (!function_exists('stream_socket_client')) {
			throw new Customweb_Core_Http_Client_ConnectionException("The HTTP client requires to activate the stream_socket_client() function.");
		}
		$this->logger = Customweb_Core_Logger_Factory::getLogger(get_class($this));
	}

	public function send(Customweb_Core_Http_IRequest $request){
		$redirectLimit = $this->getNumberOfRedirectsToFollow();
		$request = new Customweb_Core_Http_Request($request);
		$this->logger->logDebug("HTTP Client request", (string)$request);
		$response = null;
		do {
			$this->resetStartTime();
			if ($response !== null && $response->getLocation() !== null) {
				$url = $request->getUrlObject()->updateUrl($response->getLocation());
				$request->setUrl($url);
			}

			$socket = $this->sendInternal($request);
			$responseMessage = $this->readFromSocket($socket);
			fclose($socket);

			if (empty($responseMessage)) {
				throw new Customweb_Core_Http_Client_ConnectionException(
						"The server response with an empty response (no HTTP header and no HTTP body).");
			}

			$response = new Customweb_Core_Http_Response($responseMessage);
			$redirectLimit--;
		}
		while ($response->getLocation() !== null && $redirectLimit > 0);
		$this->logger->logDebug("HTTP Client respons", (string)$response);

		return $response;
	}

	public function sendAsynchronous(Customweb_Core_Http_IRequest $request){
		$socket = $this->sendInternal($request);
		fclose($socket);
	}

	/**
	 * This method reads from the given socket.
	 * Depending on the given header the read process
	 * may be halted after reading the last chunk. This method is required, because some servers
	 * do not close the connection in chunked tranfer. Hence the timeout of the connection must be
	 * reached, before the connection is closed. By tracking the chunks the connection can be closed
	 * earlier after the last chunk.
	 *
	 * @param resource $socket
	 * @return string
	 */
	final protected function readFromSocket($socket){
		$inBody = false;
		$responseMessage = '';
		$chunked = false;
		$chunkLength = false;
		Customweb_Core_Util_Error::startErrorHandling();
		$maxTime = $this->getStartTime() + $this->getConnectionTimeout();
		$contentLength = -1;
		$endReached = false;
		while ($maxTime > time() && !feof($socket) && !$endReached) {
			if ($inBody === false) {
				$line = $this->readLineFromSocket($socket, 2048);
				if ($line == "\r\n") {
					$inBody = true;
				}
				else {
					$parts = explode(':', $line, 2);
					if (count($parts) == 2) {
						$headerName = trim(strtolower($parts[0]));
						$headerValue = trim(strtolower($parts[1]));
						if ($headerName === 'transfer-encoding' && $headerValue == 'chunked') {
							$chunked = true;
						}
						if ($headerName === 'content-length') {
							$contentLength = (int) $headerValue;
						}
					}
				}
				$responseMessage .= $line;
			}
			else {
				// Check if we can read without chunks
				if (!$chunked) {
					$readBytes = 4096;
					if ($contentLength > 0) {
						$readBytes = $contentLength;
					}
					$tmp = $this->readContentFromSocket($socket, $readBytes);
					$responseMessage .= $tmp;
					if (strlen($tmp) == $readBytes) {
						$endReached = true;
						break;
					}
				}

				// Since we have not set any content length we assume that we need to read in chunks.
				else {

					// We have to read the next line to get the chunk length.
					if ($chunkLength === false) {
						$line = trim(fgets($socket, 128));
						$chunkLength = hexdec($line);
					}

					// We have to read the chunk, when it is greater than zero. The last one is always 0.
					else if ($chunkLength > 0) {
						$responseMessage .= $this->readContentFromSocket($socket, $chunkLength);

						// We skip the next line break.
						fseek($socket, 2, SEEK_CUR);
						$chunkLength = false;
					}

					// The chunk length must be zero. Hence we are finished and we can stop.
					else {
						$endReached = true;
						break;
					}
				}
			}
		}

		Customweb_Core_Util_Error::endErrorHandling();
		if (feof($socket) || $endReached) {
			return $responseMessage;
		}
		else {
			throw new Customweb_Core_Http_Client_ConnectionTimeoutException(
					"The remote server does not response within '" . $this->getConnectionTimeout() . "' seconds.");
		}
	}

	/**
	 * This method reads in blocking fashion from the socket.
	 *
	 * We need this method because neither fread nor stream_get_contents does respect timeouts.
	 *
	 * @param resource $socket The socket from which should be read.
	 * @param int $maxNumberOfBytes the number of bytes to read.
	 * @return string the read string.
	 */
	protected function readContentFromSocket($socket, $maxNumberOfBytes){
		stream_set_blocking($socket, false);
		$maxTime = $this->getStartTime() + $this->getConnectionTimeout();
		$numberOfBytesRead = 0;
		$result = '';
		while ($maxTime >= time() && $numberOfBytesRead < $maxNumberOfBytes && !feof($socket)) {
			$nextChunkSize = min(128, $maxNumberOfBytes - $numberOfBytesRead);
			$tmp = stream_get_contents($socket, $nextChunkSize);
			if ($tmp !== false && strlen($tmp) > 0) {
				$result .= $tmp;
				$numberOfBytesRead += strlen($tmp);
			}
			else {
				// Wait 100 milliseconds
				usleep(100 * 1000);
			}
		}
		stream_set_blocking($socket, true);

		if (feof($socket) || $numberOfBytesRead >= $maxNumberOfBytes) {
			return $result;
		}
		else {
			throw new Customweb_Core_Http_Client_ConnectionTimeoutException(
					"The remote server does not response within '" . $this->getConnectionTimeout() . "' seconds.");
		}
	}

	/**
	 * This method reads a single line in blocking fashion from the socket. However
	 * the method does respect the timeout configured.
	 *
	 * @param resource $socket The socket from which should be read.
	 * @param int $maxNumberOfBytes the number of bytes to read.
	 * @return string the read string.
	 */
	protected function readLineFromSocket($socket, $maxNumberOfBytes){
		stream_set_blocking($socket, false);
		$maxTime = $this->getStartTime() + $this->getConnectionTimeout();
		$result = false;
		while ($maxTime >= time() && $result === false && !feof($socket)) {
			$tmp = fgets($socket, $maxNumberOfBytes);
			if ($tmp !== false && strlen($tmp) > 0) {
				$result = $tmp;
			}
			else {
				// Wait 100 milliseconds
				usleep(100 * 1000);
			}
		}
		stream_set_blocking($socket, true);

		if ($result !== false) {
			return $result;
		}
		else {

			// When the max time was not used and we see that the function openssl_error_string() holds an error it will show the underlying issue with
			// the connection.
			if ($maxTime >= time() && function_exists('openssl_error_string') && openssl_error_string() !== false) {
				throw new Customweb_Core_Http_Client_ConnectionException(
						"The HTTP client was not able to establish a secure connection because of the following openssl error: " . openssl_error_string());
			}

			throw new Customweb_Core_Http_Client_ConnectionTimeoutException(
					"The remote server does not response within '" . $this->getConnectionTimeout() . "' seconds.");
		}
	}

	/**
	 * Returns the number of redirects to follow.
	 *
	 * @return number
	 */
	protected function getNumberOfRedirectsToFollow(){
		$redirectLimit = $this->getRedirectionFollowLimit();
		if ($redirectLimit === 0) {
			return (int) PHP_INT_MAX;
		}
		else if ($redirectLimit === Null) {
			return 0;
		}
		else {
			return $redirectLimit;
		}
	}

	/**
	 * Creates a socket and send the request to the remote host.
	 * As result
	 * a stream socket is returned. Which can be used to read the response.
	 *
	 * @param Customweb_Core_Http_IRequest $request
	 * @throws Customweb_Core_Http_Client_ConnectionException
	 * @return resource
	 */
	protected final function sendInternal(Customweb_Core_Http_IRequest $request){
		$request = new Customweb_Core_Http_Request($request);
		$this->configureRequest($request);

		$message = $request->toSendableString($this->isProxyActive());
		$socket = $this->createSocketStream($request);

		Customweb_Core_Util_Error::startErrorHandling();
		$rs = fwrite($socket, $message);
		Customweb_Core_Util_Error::endErrorHandling();
		if ($rs == false) {
			throw new Customweb_Core_Http_Client_ConnectionException('Could not send the message to the server.');
		}

		return $socket;
	}

	/**
	 * This method modifies the request so it can be sent.
	 * Sub classes may
	 * override this method to apply further modifications.
	 *
	 * @param Customweb_Core_Http_Request $request
	 */
	protected function configureRequest(Customweb_Core_Http_Request $request){
		if ($this->isProxyActive()) {
			$proxyUrl = $this->getProxyUrl();
			if ($proxyUrl->getUser() !== NULL) {
				$auth = $proxyUrl->getUser();
				if ($proxyUrl->getPass() !== NULL) {
					$auth .= ':' . $proxyUrl->getPass();
				}
				$auth = base64_encode($auth);
				$request->appendHeader('proxy-authorization : Basic ' . $auth);
			}
		}
	}

	/**
	 * This method creates a stream socket to the server.
	 *
	 * @throws Customweb_Core_Http_Client_ConnectionException
	 * @return resource
	 */
	protected function createSocketStream(Customweb_Core_Http_Request $request){
		if ($request->isSecureConnection()) {
			if (!extension_loaded('openssl')) {
				throw new Customweb_Core_Http_Client_ConnectionException("You have to enable OpenSSL.");
			}
		}
		if ($this->isProxyActive()) {
			$host = $this->getProxyUrl()->getHost();
			$port = $this->getProxyUrl()->getPort();
		}
		else {
			// Change host if ssl is used:
			if ($request->isSecureConnection()) {
				$host = $this->getSslProtocol() . '://' . $request->getHost();
			}
			else {
				$host = $request->getHost();
			}
			$port = $request->getPort();
		}

		$socket = $host . ':' . $port;

		Customweb_Core_Util_Error::startErrorHandling();
		$fp = stream_socket_client($socket, $errno, $errstr, $this->getConnectionTimeout(), STREAM_CLIENT_CONNECT,
				$this->createStreamContext($request));
		Customweb_Core_Util_Error::endErrorHandling();

		if ($fp === false) {
			$errorMessage = 'Could not connect to the server. Host: ' . $socket . ' ';
			$errorMessage .= '(Error: ' . $errno . ', Error Message: ' . $errstr . ')';
			throw new Customweb_Core_Http_Client_ConnectionException($errorMessage);
		}

		if (!(get_resource_type($fp) == 'stream')) {
			$errorMessage = 'Could not connect to the server. The returned socket was not a stream. Host: ' . $socket . ' ';
			throw new Customweb_Core_Http_Client_ConnectionException($errorMessage);
		}

		return $fp;
	}

	/**
	 * Returns the protocol to use in case of an SSL connection.
	 *
	 * @return string
	 */
	protected function getSslProtocol(){
		$version = $this->getForcedSslVersion();
		$rs = null;
		switch ($version) {
			case self::SSL_VERSION_TLSV11:
				$rs = 'tlsv1.1';
				break;
			case self::SSL_VERSION_TLSV12:
				$rs = 'tlsv1.2';
				break;
			case self::SSL_VERSION_TLSV13:
				$rs = 'tlsv1.3';
				break;
			default:
				$rs = 'ssl';
		}
		if ($rs === null) {
			throw new Exception("Invalid state.");
		}

		$possibleTransportProtocols = stream_get_transports();
		if (!in_array($rs, $possibleTransportProtocols)) {
			throw new Exception(
					Customweb_Core_String::_(
							"The enforced SSL protocol is '@actual'. But this protocol is not supported by the web server. Supported stream protocols by the web server are @supported.")->format(
							array(
								'@actual' => $rs,
								'@supported' => implode(',', $possibleTransportProtocols)
							))->toString());
		}

		return $rs;
	}

	protected final function createStreamContext(Customweb_Core_Http_Request $request){
		return stream_context_create($this->buildStreamContextOptions($request));
	}

	/**
	 * Generates an option array for creating the stream context.
	 * Sub classes may override
	 * this method to provide different options to the constructor of the stream_context_create()
	 *
	 * @param Customweb_Core_Http_Request $request
	 * @return array
	 */
	protected function buildStreamContextOptions(Customweb_Core_Http_Request $request){
		$options = array(
			'http' => array(),
			'ssl' => array()
		);

		if ($request->isSecureConnection()) {
			$options['ssl']['verify_host'] = true;
			$options['ssl']['allow_self_signed'] = false;
			$options['ssl']['verify_peer'] = false;

			if ($this->isCertificateAuthorityCheckEnabled()) {
				$options['ssl']['verify_peer'] = true;
				$options['ssl']['cafile'] = $this->getCertificateAuthorityFilePath();
			}
			if ($this->getClientCertificate() !== null) {
				$options['ssl']['local_cert'] = $this->getClientCertificateLocalFilePath();
				$passphrase = $this->getClientCertificatePassphrase();
				if (!empty($passphrase)) {
					$options['ssl']['passphrase'] = $passphrase;
				}
			}
		}
		$ipVersion = $this->getForcedInternetProtocolAddressVersion();
		if ($ipVersion !== null) {
			if ($ipVersion == self::IP_ADDRESS_VERSION_V4) {
				$options['socket'] = array(
					'bindto' => '0.0.0.0:0'
				);
			}
			elseif ($ipVersion == self::IP_ADDRESS_VERSION_V6) {
				$options['socket'] = array(
					'bindto' => '[::]:0'
				);
			}
		}

		if ($this->isProxyActive()) {
			$options['http']['proxy'] = $this->getProxyUrl()->toString();
			$options['http']['request_fulluri'] = true;
		}

		return $options;
	}

	protected function resetStartTime(){
		$this->startTime = time();
	}

	protected function getStartTime(){
		return $this->startTime;
	}
}
