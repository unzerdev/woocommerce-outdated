<?php

class Customweb_Payment_Exception_ExternalCheckoutTokenExpiredException extends Exception {
	
	public function __construct(){
		parent::__construct(Customweb_I18n_Translation::__("The token has expired")->toString());
	}

}