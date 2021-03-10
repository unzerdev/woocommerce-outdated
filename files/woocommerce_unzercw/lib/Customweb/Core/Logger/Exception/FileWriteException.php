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



class Customweb_Core_Logger_Exception_FileWriteException extends Exception {
	/**
	 * @var string
	 */
	private $fileName;
	
	public function __construct($fileName = null, $message=null, $code=null, $previous=null){
		$message = $this->getCustomMessage($fileName, $message);
		parent::__construct($message,$code,$previous);
	}
	
	public function getFileName(){
		return $this->fileName;
	}
	
	private function getCustomMessage($fileName, $message){
		$isFileNameSet = isset($fileName) && $fileName != '';
		if($message===null){
			if($isFileNameSet){
				$message = "Couldn't write to file: $fileName";
			} else {
				$message = "No file name given!";
			}
		} else {
			if($isFileNameSet && strpos($message, $fileName)===false){
				$message .= "\n File: $fileName \n";
			}
		}
		return $message;
	}
	
}