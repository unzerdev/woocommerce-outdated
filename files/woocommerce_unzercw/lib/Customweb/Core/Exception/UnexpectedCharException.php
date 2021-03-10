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
require_once 'Customweb/Core/String.php';

class Customweb_Core_Exception_UnexpectedCharException extends Exception {
	private $codeNumber = null;
	
	private $charAsUtf8 = null;

	public function __construct($codeNumber, $utf8Representation){
		$this->codeNumber = $codeNumber;
		$this->charAsUtf8 = $utf8Representation;
		parent::__construct(Customweb_Core_String::_("The char '@char' (code: '@codeNumber') was not found in conversion table.")->format(array(
			'@codeNumber' => (string)$this->codeNumber,
			'@char' => (string)$utf8Representation,
		)));
	}

	public function getCharCode(){
		return $this->codeNumber;
	}

	public function getCharAsUtf8(){
		return $this->charAsUtf8;
	}
}