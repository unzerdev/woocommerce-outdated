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

require_once 'Customweb/Core/Stream/IInput.php';
require_once 'Customweb/Core/Http/Client/Socket.php';
require_once 'Customweb/Core/Util/Error.php';


/**
 * Implementation of a input stream which reads on a remote file.
 *
 * @author Thomas Hunziker
 *        
 */
class Customweb_Core_Stream_Input_Http extends Customweb_Core_Http_Client_Socket implements Customweb_Core_Stream_IInput
{

	/**
	 * 
	 * @var Customweb_Core_Http_IRequest
	 */
	private $request = null;

	/**
	 * 
	 * @var string
	 */
	private $mimeType = null;

	/**
	 * 
	 * @var resource
	 */
	private $socket = null;

	/**
	 * 
	 * @var boolean
	 */
	private $open = false;
	
	/**
	 * 
	 * @var integer
	 */
	private $statusCode;
	
	/**
	 * 
	 * @var string
	 */
	private $header;
	
	/**
	 * 
	 * @param Customweb_Core_Http_IRequest $request
	 */
	public function __construct(Customweb_Core_Http_IRequest $request)
	{
		$this->request = $request;
	}

	public function close()
	{
		if ($this->isOpen()) {
			$this->open = false;
			fclose($this->getSocket());
		}
	}

	public function isReady()
	{
		return true;
	}

	public function read($length = 0)
	{
		if ($length === 0) {
			$output = '';
			Customweb_Core_Util_Error::startErrorHandling();
			while (!$this->isEndOfStream()) {
				$output .= stream_get_contents($this->getSocket(), 8192);
			}
			Customweb_Core_Util_Error::endErrorHandling();
			return $output;
		} else {
			return stream_get_contents($this->getSocket(), $length);
		}
	}

	public function isEndOfStream()
	{
		return feof($this->getSocket());
	}

	public function skip($length)
	{
		Customweb_Core_Util_Error::startErrorHandling();
		fgets($this->getSocket(), $length);
		Customweb_Core_Util_Error::endErrorHandling();
	}

	public function getMimeType()
	{
		if ($this->mimeType == null) {
			$matches = array();
			if (preg_match('/Content-Type:(.+)[; ]?/iu', $this->getHeaders(), $matches)) {
				$this->mimeType = trim($matches[1]);
			}
		}
		return $this->mimeType;
	}

	public function getSystemIdentifier()
	{
		return sha1($this->getFilePath());
	}
	
	/**
	 *
	 * @return resource
	 */
	private function getSocket()
	{
		if ($this->socket == null) {
			$this->socket = $this->sendInternal($this->getRequest());
			$this->readHeaders();
			$this->open = true;
		}
		return $this->socket;
	}
	
	private function readHeaders()
	{
		$header = '';
		while(!$this->isEndOfStream()) {
			$line = fgets($this->getSocket());
			if ($line == "\r\n") {
				break;
			} else {
				$header .= $line;
			}
		}
		$this->header = $header;
	}

	/**
	 *
	 * @var Customweb_Core_Http_IRequest
	 */
	private function getRequest()
	{
		return $this->request;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getHeaders()
	{
		if (!$this->isOpen()) {
			$this->getSocket();
		}
		return $this->header;
	}

	/**
	 * 
	 * @return boolean
	 */
	public function isOpen()
	{
		return $this->open;
	}
	
	/**
	 * 
	 * @return integer
	 */
	public function getStatusCode()
	{
		if ($this->statusCode == null) {
			$matches = array();
			preg_match('/\d{3}/', $this->getHeaders(), $matches);
			$this->statusCode = $matches[0];
		}
		return $this->statusCode;
	}
}