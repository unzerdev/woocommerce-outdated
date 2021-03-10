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
 * This class handles a HTTP response. It is responsible for the spliting and
 * parsing of the HTTP headers and for unchunking the message body.
 *  
 * @deprecated Use instead the core implementation
 */
class Customweb_Http_Response {
	
	/**
	 * @var string
	 */
	protected $rawResponse = '';
	
	/**
	 * @var array
	 */
	private $httpRawHeaders = array();
	
	/**
	 * @var array
	 */
	private $httpHeaders = array();
	
	/**
	 * @var string
	 */
	protected $httpBody = '';
	
	/**
	 * @var int
	 */
	private $statusCode = NULL;
	
	/**
	 * @var string
	 */
	private $statusMessage = NULL;
	
	/**
	 * @var string
	 */
	private $httpVersion = NULL;
	
	/**
	 * This method resets the inner state of the response object, to the state any
	 * data is written to the object.
	 * 
	 * @return void
	 */
	public function reset() {
		$this->rawResponse = '';
		$this->httpRawHeaders = '';
		$this->httpHeaders = array();
		$this->httpBody = '';
		$this->statusCode = NULL;
		$this->statusMessage = NULL;
		$this->httpVersion = NULL;
	}
	
	/**
	 * This method adds a partial message to the raw response.
	 * 
	 * @param string $part
	 * @return void
	 */
	public function addPart($part) {
		$this->rawResponse .= $part;
	}
	
	/**
	 * This method process the response and build a logical response. This 
	 * means we unchunk the response and split the answer into a body and 
	 * a list of headers.
	 * 
	 * @return void
	 */
	public function process(Customweb_Http_Request $request) {
		$posStartContent = strpos($this->rawResponse, "\r\n\r\n");
		
		$headerData = substr($this->rawResponse, 0, $posStartContent);
		$this->httpBody = substr($this->rawResponse, $posStartContent + 4);
	
		$this->httpRawHeaders = explode("\r\n", $headerData);
		
		// Extract the Status Code
		$result = array();
		$statusLine = reset($this->httpRawHeaders);
		preg_match('/HTTP\/([^[:space:]])+[[:space:]]+([0-9]*)(.*)/i', $statusLine, $result);
		$this->httpVersion = (int)$result[1];
		$this->statusCode = (int)$result[2];
		$this->statusMessage = $result[3];
		
		$headers = $this->httpRawHeaders;
		unset($headers[0]);
		foreach ($headers as $head) {
			preg_match('/([^:]+):(.*)/', $head, $rs);
			$key = strtolower($rs[1]);
			$value = $rs[2];
			if (isset($this->httpHeaders[$key])) {
				$this->httpHeaders[$key] .= ',' . $value;
			}
			else {
				$this->httpHeaders[$key] = $value;
			}
		}
		
		if (strpos(strtolower($headerData), "transfer-encoding: chunked")) {
			self::unchunk();
		}		
	}
	
	/**
	 * This method returns the status code of the response.
	 * 
	 * @return int Status Code
	 */
	public function getStatusCode() {
		return $this->statusCode;
	}
	
	/**
	 * This method returns the status message of the response.
	 * 
	 * @return string Status Message
	 */
	public function getStatusMessage() {
		return $this->statusMessage;
	}
	
	/**
	 * This method returns the HTTP version of the response.
	 * 
	 * @return int HTTP Version
	 */
	public function getHttpVersion() {
		return $this->httpVersion;
	}
	
	/**
	 * This method returns the list of headers of the response.
	 * 
	 * @return array List of Headers
	 */
	public function getRawHeaders() {
		return $this->httpRawHeaders;
	}
	
	/**
	 * This method returns the list of headers of the response.
	 * 
	 * @return array List Of Headers
	 */
	public function getHeaders() {
		return $this->httpHeaders;
	}
	
	/**
	 * This method returns the body of the HTTP response. 
	 * 
	 * @return string Body
	 */
	public function getBody() {
		return $this->httpBody;
	}
	
	/**
	 * This method unchuncks a chuncked message body.
	 * 
	 * @return string Unchunked body
	 */
	protected function unchunk() {
		$fp = 0;
		$outData = "";
		while ($fp < strlen($this->httpBody)) {
			$rawnum = substr($this->httpBody, $fp, strpos(substr($this->httpBody, $fp), "\r\n") + 2);
			$num = hexdec(trim($rawnum));
			$fp += strlen($rawnum);
			$chunk = substr($this->httpBody, $fp, $num);
			$outData .= $chunk;
			$fp += strlen($chunk);
		}
		$this->httpBody = $outData;
		return $this->httpBody;
	}
	
	/**
	 * This method returns the raw response without any part parsed.
	 * 
	 * @return string Raw Response
	 */
	public function getRawResponse() {
		return $this->rawResponse;
	}
}