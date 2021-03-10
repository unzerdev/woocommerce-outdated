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
require_once 'Customweb/Core/Http/IMessage.php';
require_once 'Customweb/Core/Url.php';
require_once 'Customweb/Core/Http/AbstractMessage.php';


/**
 * Abstract impementation of a HTTP message. The class provides
 * basic facilities to handle HTTP message. 
 * 
 * Sub classes must implement a copy constructor.
 * 
 * @author hunziker
 *
 */
abstract class Customweb_Core_Http_AbstractMessage implements Customweb_Core_Http_IMessage{

	/**
	 * Header key for 'content-type' header.
	 * 
	 * @var string
	 */
	const HEADER_KEY_CONTENT_TYPE = 'content-type';
	
	/**
	 * Header key for 'content-encoding' header.
	 *
	 * @var string
	 */
	const HEADER_KEY_CONTENT_ENCODING = 'content-encoding';
	
	/**
	 * Header key for 'content-length' header.
	 *
	 * @var string
	 */
	const HEADER_KEY_CONTENT_LENGTH = 'content-length';

	/**
	 * @var string
	 */
	private $statusLine = null;
	
	/**
	 * @var array
	 */
	private $headers = array();
	
	/**
	 * @var array
	 */
	private $parsedHeaders = array();
	
	/**
	 * @var string
	 */
	private $protocolVersion = '1.1';

	/**
	 * @var string
	 */
	private $body = '';
	
	/**
	 * @var array
	 */
	private $parsedBody = null;
	
	/**
	 * @var int
	 */
	private $contentLength = 0;
	
	/**
	 * @var string
	 */
	private $contentType = null;
	
	/**
	 * @var string
	 */
	private $contentEncoding = null;
	
	public function __construct($message = null) {
		if ($message !== null) {
			if ($message instanceof Customweb_Core_Http_AbstractMessage) {
				$this->body = $message->body;
				$this->headers = $message->headers;
				$this->parsedBody = $message->parsedBody;
				$this->protocolVersion = $message->protocolVersion;
				$this->parsedHeaders = $message->parsedHeaders;
				$this->contentLength = $message->contentLength;
				$this->contentType = $message->contentType;
				$this->contentEncoding = $message->contentEncoding;
			}
			else {
				$message = (string)$message;
				$this->parseRawMessage($message);
			}
		}
		else {
			$this->setHeaders(
				array(
					'connection: close',
				)
			);
		}
	}
	
	/**
	 * Parses the status line.
	 * 
	 * @param string $line
	 * @return void
	 */
	protected abstract function parseStatusLine($line);

	/**
	 * Returns the body of the message.
	 * 
	 * @return string
	 */
	public function getBody(){
		return $this->body;
	}

	/**
	 * Tries to parse the body string as a query string into an array. In 
	 * case the body of the message is not a query string this method may
	 * lead to strange results.
	 * 
	 * @return array
	 */
	public function getParsedBody() {
		if ($this->parsedBody === null) {
			$this->parsedBody = self::parseBodyToArray($this->body);
		}
		return $this->parsedBody;
	}
	
	/**
	 * Sets the body of the message. Either a string or array can be 
	 * provided. In case it is an array the body is treated as a query
	 * string. 
	 *
	 * 
	 * @param string|array $body
	 * @return Customweb_Core_Http_AbstractMessage
	 */
	public function setBody($body) {
		if (is_array($body)) {
			$this->body = Customweb_Core_Url::parseArrayToString($body);
			$this->parsedBody = $body;
		}
		else {
			$this->body = (string)$body;
		}
		$this->removeHeadersWithKey(self::HEADER_KEY_CONTENT_LENGTH);
		$length = strlen($this->body);
		if ($length > 0) {
			$this->appendHeader(self::HEADER_KEY_CONTENT_LENGTH . ': ' . $length);			
		}
		return $this;
	}
	
	/**
	 * This method appends the given string to the body of the message. 
	 * 
	 * @param string $string The string to append
	 * @return Customweb_Core_Http_AbstractMessage
	 */
	public function appendBody($string) {
		$string = (string)$string;
		$body = $this->getBody();
		$this->setBody($body . $string);
		return $this;
	}
	
	/**
	 * This method prepends the given string to the body of the
	 * message.
	 * 
	 * @param string $string The string to prepend.
	 * @return Customweb_Core_Http_AbstractMessage
	 */
	public function prependBody($string) {
		$string = (string)$string;
		$body = $this->getBody();
		$this->setBody($string . $body);
		return $this;
	}
		
	/**
	 * Returns all headers of the message as a list. The key is a numeric
	 * one.
	 * 
	 * @return array
	 */
	public function getHeaders(){
		return $this->headers;
	}

	/**
	 * Returns a key/value map of the headers which are key/value pairs. The 
	 * order of the items is not preserved. The key is always lower case.
	 * 
	 * Sample output:
	 * array(
	 *   'content-type' => array('text/html'),
	 *   'content-length' => array('345'),
	 * )
	 * 
	 * @return array
	 */
	public function getParsedHeaders() {
		return $this->parsedHeaders;
	}
	
	/**
	 * This method sets all headers of the message. The headers are parsed an
	 * the internal state of the message may be changed. If only a single header
	 * should be changed either the dedicated method for the operation should be 
	 * used or then the appendHeader method should be used.
	 * 
	 * @param array $headers
	 * @return Customweb_Core_Http_AbstractMessage
	 */
	public function setHeaders(array $headers){
		$this->resetHeaders();
		foreach ($headers as $header) {
			$this->appendHeader($header);
		}
		return $this;
	}
	
	/**
	 * This method adds the given header at the end of the list.
	 * 
	 * @param string $header
	 * @return Customweb_Core_Http_AbstractMessage
	 */
	public function appendHeader($header) {
		$this->parseHeader($header);
		$this->headers[] = $header;
		return $this;
	}
	
	/**
	 * Returns the protocol version of the message.
	 * 
	 * @return string
	 */
	public function getProtocolVersion(){
		return $this->protocolVersion;
	}
	
	/**
	 * This method sets the protocol version 
	 * 
	 * @param string $protocolVersion
	 * @return Customweb_Core_Http_AbstractMessage
	 */
	public function setProtocolVersion($protocolVersion){
		if (!is_string($protocolVersion)) {
			$protocolVersion = (string)$protocolVersion;
		}
		$this->protocolVersion = $protocolVersion;
		return $this;
	}
	
	/**
	 * Returns the content type of the message. This may be null. If no content
	 * type was defined.
	 * 
	 * @return string
	 */
	public function getContentType(){
		return $this->contentType;
	}
	
	/**
	 * Sets the content type header.
	 * 
	 * @param string $contentType
	 * @return Customweb_Core_Http_AbstractMessage
	 */
	public function setContentType($contentType){
		$this->removeHeadersWithKey(self::HEADER_KEY_CONTENT_TYPE);
		if ($contentType !== null) {
			$this->appendHeader(self::HEADER_KEY_CONTENT_TYPE . ': ' . $contentType);
		}
		return $this;
	}
	
	/**
	 * Returns the content encoding of the request. This may be null.
	 * 
	 * @return string
	 */
	public function getContentEncoding(){
		return $this->contentEncoding;
	}
	
	/**
	 * Sets the conent encoding (e.g. gzip, deflate etc.). If this is
	 * changed the body must be manually changed.
	 * 
	 * @param string $contentEncoding
	 * @return Customweb_Core_Http_AbstractMessage
	 */
	public function setContentEncoding($contentEncoding){
		$this->removeHeadersWithKey(self::HEADER_KEY_CONTENT_ENCODING);
		if ($contentEncoding !== null) {
			$this->appendHeader(self::HEADER_KEY_CONTENT_ENCODING . ': ' . $contentEncoding);
		}
		return $this;
	}
	
	/**
	 * Returns the content length header.
	 * 
	 * @return number
	 */
	public function getContentLength() {
		return $this->contentLength;
	}
	
	/**
	 * Returns the message as a string.
	 *
	 * @return string
	 */
	public function toString() {
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
	public function __toString() {
		return $this->toString();
	}
	
	############ Methods for sup types ###############
	
	/**
	 * This method parses the given header. In case the header is a key / value 
	 * pair the header is written to the list of parsed headers.
	 * 
	 * @param string $header
	 * @throws Exception
	 */
	protected final function parseHeader($header) {
		if (!is_string($header)) {
			throw new Exception("The given header is not a string.");
		}
		
		if (preg_match('/([^:]+):(.*)/', $header, $rs)) {
			$key = strtolower($rs[1]);
			$value = trim($rs[2]);
			$key = strtolower($key);
			if (!isset($this->parsedHeaders[$key])) {
				$this->parsedHeaders[$key] = array();
			}
			$this->parsedHeaders[$key][] = $value;
			$this->processKeyedHeader($key, $value);
		}
		else {
			throw new Exception(Customweb_Core_String::_("Invalid format of the header '@header'. It must contain a ':' char.")->format(array('@header' => $header)));
		}
	}
	
	/**
	 * This method is called when a keyed header is parsed. This method 
	 * should be overriden by sup classes to update the internal state.
	 * The key is always in lowercase.
	 * 
	 * @param string $headerKey
	 * @param string $headerValue
	 */
	protected function processKeyedHeader($headerKey, $headerValue) {
		if ($headerKey == self::HEADER_KEY_CONTENT_LENGTH) {
			$this->contentLength = (int)$headerValue;
		}
		else if ($headerKey == self::HEADER_KEY_CONTENT_TYPE) {
			$this->contentType = $headerValue;
		}
		else if ($headerKey == self::HEADER_KEY_CONTENT_ENCODING) {
			$this->contentEncoding = $headerValue;
		}
	}

	/**
	 * Resets the whole state regarding header. Sub classes should override 
	 * this method to make sure their state is also reseted.
	 * 
	 * @return void
	 */
	protected function resetHeaders() {
		$this->headers = array();
		$this->parsedHeaders = array();
		$this->protocolVersion = '1.1';
	}
	
	/**
	 * This method removes all headers with the given key.
	 * 
	 * @param string $key The key of the header
	 */
	public function removeHeadersWithKey($key) {
		$prefix = $key . ':';
		foreach ($this->headers as $k => $value) {
			if (strpos(strtolower($value), strtolower($prefix)) === 0) {
				unset($this->headers[$k]);
				unset($this->parsedHeaders[$key]);
			}
		}
	}

	/**
	 * Parse the given HTTP message.
	 *
	 * @param string $message
	 * @return void
	 */
	protected function parseRawMessage($message) {
		$positionStartBody = strpos($message, "\r\n\r\n");
		
		$startPositionOffset = 4;
		if ($positionStartBody === false) {
			$positionStartBody = strpos($message, "\n\n");
			$startPositionOffset = 2;
			if ($positionStartBody === false) {
				throw new Exception("Invalid HTTP message provided. It does not contain a header part.");
			}
		}
		
		$headerString = str_replace("\r\n", "\n", trim(substr($message, 0, $positionStartBody), "\r\n"));
		$content = substr($message, $positionStartBody + $startPositionOffset);
	
		$headers = explode("\n", $headerString);
		$statusLine = current($headers);
		array_shift($headers);
		$this->setHeaders($headers);
		$this->parseStatusLine($statusLine);
		$this->setBody($content);
	}
	

	################# Utils methods ##################
	
	protected static function parseBodyToArray($input) {
		$output = array();
		// We expect that that at least a '=' char must be present, otherwise
		// it is not a valid input.
		if (strstr($input, '=')) {
			parse_str($input, $output);
		}
		return $output;
	}
	
}