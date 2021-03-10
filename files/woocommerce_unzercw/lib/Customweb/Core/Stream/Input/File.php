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
require_once 'Customweb/Core/String.php';
require_once 'Customweb/Core/MimeType.php';
require_once 'Customweb/Core/Util/Error.php';


/**
 * Implementation of a input stream which reads on a local file.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Core_Stream_Input_File implements Customweb_Core_Stream_IInput {

	private $filePath = null;
	
	private $open = false;
	
	private $fopenHandler = null;
	
	private $fileExtension = null;
	
	private $mimeType = null;
	
	public function __construct($filePath) {
		$this->filePath = $filePath;
		$this->fileExtension = pathinfo($this->filePath, PATHINFO_EXTENSION);
	}
	
	public function close() {
		if ($this->isOpen()) {
			$this->open = false;
			fclose($this->fopenHandler);
		}
	}

	public function isReady() {
		return true;
	}

	public function read($length = 0) {
		if ($length === 0) {
			$output = '';
			Customweb_Core_Util_Error::startErrorHandling();
			while (!$this->isEndOfStream()) {
				$output .= fread($this->getFopenHandler(), 2048);
			}
			Customweb_Core_Util_Error::endErrorHandling();
			return $output;
		}
		else {
			return fread($this->getFopenHandler(), $length);
		}
	}

	public function skip($length) {
		Customweb_Core_Util_Error::startErrorHandling();
		fread($this->getFopenHandler(), $length);
		Customweb_Core_Util_Error::endErrorHandling();
	}

	public function isEndOfStream() {
		return feof($this->getFopenHandler());
	}
	
	protected function getFopenHandler() {
		if ($this->fopenHandler === null) {
			if (!file_exists($this->filePath)) {
				throw new Exception(Customweb_Core_String::_("File on path '@path' does not exists.")->format(array('@path' => $this->filePath)));
			}
			Customweb_Core_Util_Error::startErrorHandling();
			$this->fopenHandler = fopen($this->filePath, 'r');
			Customweb_Core_Util_Error::endErrorHandling();
			$this->open = true;
		}
		return $this->fopenHandler;
	}
	
	public function isOpen() {
		return $this->open;
	}
	
	public function getFilePath() {
		return $this->filePath;
	}
	
	public function getMimeType() {
		if ($this->mimeType === null) {
			$this->mimeType = Customweb_Core_MimeType::getMimeType($this->getFileExtension());
		}
		return $this->mimeType;
	}

	public function getFileExtension(){
		return $this->fileExtension;
	}
	
	public function getSystemIdentifier() {
		$modifiedTime = filemtime($this->getFilePath());
		return sha1($modifiedTime . $this->getFilePath());
	}

}