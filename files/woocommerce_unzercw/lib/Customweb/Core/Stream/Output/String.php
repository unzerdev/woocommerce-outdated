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

require_once 'Customweb/Core/Stream/Output/Abstract.php';


/**
 * Implementation which writes the output into the given file.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Core_Stream_Output_String extends Customweb_Core_Stream_Output_Abstract  {

	private $string = '';
	
	private $mimeType;
	
	public function __construct($mimeType) {
		$this->mimeType = $mimeType;
	}
	
	public function close() {
	}

	public function isReady() {
		return true;		
	}

	public function write($data) {
		$this->string .= $data;
	}

	public function flush() {}
	
	/**
	 * This method returns the string written.
	 * 
	 * @return string
	 */
	public function getString() {
		return $this->string;
	}
	
	public function __toString() {
		return $this->string;
	}
	
	public function getMimeType() {
		return $this->mimeType;
	}

}