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

require_once 'Customweb/Core/Stream/IOException.php';
require_once 'Customweb/Core/Stream/Output/Abstract.php';
require_once 'Customweb/Core/MimeType.php';
require_once 'Customweb/Core/Util/Error.php';


/**
 * Implementation which writes the output into the given file.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Core_Stream_Output_File extends Customweb_Core_Stream_Output_Abstract {

	private $filePath = null;
	
	private $append = true;
	
	private $fileHandler = null;
	
	private $open = false;
	
	private $mimeType = null;

	private $fileExtension = null;
	
	/**
	 * Constructor
	 * 
	 * The file path is the path to the file to which the data is 
	 * written to. The append flag indicates if the file already exists
	 * if the content should be append or the file should be replaced 
	 * with the new content.
	 * 
	 * @param string $filePath
	 * @param boolean $append
	 */
	public function __construct($filePath, $append = false) {
		$this->filePath = $filePath;
		$this->append = $append;
		$this->fileExtension = pathinfo($this->filePath, PATHINFO_EXTENSION);
	}
	
	public function close() {
		if ($this->isOpen()) {
			try {
				Customweb_Core_Util_Error::startErrorHandling();
				fclose($this->fileHandler);
				Customweb_Core_Util_Error::endErrorHandling();
				$this->open = false;
			}
			catch(Exception $e) {
				throw new Customweb_Core_Stream_IOException($e->getMessage());
			}
		}
	}

	public function isReady() {
		return true;		
	}

	public function write($data) {
		try {
			Customweb_Core_Util_Error::startErrorHandling();
			fwrite($this->getFileHandler(), (string)$data);
			Customweb_Core_Util_Error::endErrorHandling();
			$this->open = false;
		}
		catch(Exception $e) {
			throw new Customweb_Core_Stream_IOException($e->getMessage());
		}
	}

	public function flush() {}
	

	public function getMimeType() {
		if ($this->mimeType === null) {
			$this->mimeType = Customweb_Core_MimeType::getMimeType($this->getFileExtension());
		}
		return $this->mimeType;
	}

	public function getFileExtension(){
		return $this->fileExtension;
	}
	
	public function getFilePath() {
		return $this->filePath;
	}
	
	public function isOpen() {
		return $this->open;
	}
	
	/**
	 * Returns true, if file appending is enabled.
	 * 
	 * @return boolean
	 */
	public function isAppendingEnabled() {
		return $this->append;
	}
	
	protected function getFileHandler() {
		if ($this->fileHandler === null) {
			$mode = 'w';
			if ($this->isAppendingEnabled()) {
				$mode = 'a';
			}
			try {
				Customweb_Core_Util_Error::startErrorHandling();
				$this->fileHandler = fopen($this->filePath, $mode);
				Customweb_Core_Util_Error::endErrorHandling();
				$this->open = true;
			}
			catch(Exception $e) {
				throw new Customweb_Core_Stream_IOException($e->getMessage());
			}
		}
		return $this->fileHandler;
	}
	
	
}