<?php

class Customweb_Payment_Exception_ExternalCheckoutInvalidTokenException extends Exception {
	
	
	public function __construct(){
		parent::__construct("Invalid token");
	}

}