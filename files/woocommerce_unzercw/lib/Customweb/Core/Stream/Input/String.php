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

require_once 'Customweb/Core/Stream/IInput.php';
require_once 'Customweb/Core/String.php';
require_once 'Customweb/Core/Util/Error.php';



/**
 * Implementation of a input stream which reads a string.
 *
 * @author Sebastian Bossert
 *
 */
class Customweb_Core_Stream_Input_String implements Customweb_Core_Stream_IInput {
	/**
	 *
	 * @var string
	 */
	private $string = '';
	/**
	 *
	 * @var integer
	 */
	private $position = 0;
	/**
	 * 
	 * @var string
	 */
	private $mimeType;
	
	/**
	 * 
	 * @param string $string The string the stream is based on
	 * @param string $mimeType Mime type of input
	 */
	public function __construct($string, $mimeType){
		if ($string instanceof Customweb_Core_String) {
			$this->string = $string->toString();
		}
		else if (is_string($string)) {
			$this->string = $string;
		}
		else {
			$this->string = (string) $string;
		}
		$this->mimeType = $mimeType;
	}

	public function close(){}

	public function isReady(){
		return true;
	}

	public function read($length = 0){
		if ($length === 0) {
			$returnVal = $this->string;
			$this->position = strlen($this->string);
		}
		else if ($length > 0) {
			Customweb_Core_Util_Error::startErrorHandling();
			$returnVal = substr($this->string, $this->position, $length);
			Customweb_Core_Util_Error::endErrorHandling();
			$this->position += $length;
		}
		else {
			// taken from file input stream implementation
			$returnVal = false;
		}
		return $returnVal;
	}

	public function isEndOfStream(){
		return $this->position >= strlen($this->string);
	}

	public function skip($length){
		$this->position += $length;
	}

	public function getMimeType(){
		return $this->mimeType;
	}

	public function getSystemIdentifier(){
		return sha1($this->string);
	}
}