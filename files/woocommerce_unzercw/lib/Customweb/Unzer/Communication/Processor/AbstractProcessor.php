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

require_once 'Customweb/Core/Http/Client/Factory.php';
require_once 'Customweb/Unzer/Adapter.php';


/**
 * abstract processor to send request and process the response.
 *
 * @author sebastian
 *
 */
abstract class Customweb_Unzer_Communication_Processor_AbstractProcessor extends Customweb_Unzer_Adapter {
	protected $response;
	
	function process(){
		$this->sendRequest();
		return $this->processResponse();
	}
	
	protected function sendRequest(){
		if (!$this->cacheResponse() || $this->response === null) {
			$request = $this->getRequestBuilder()->buildRequest();
			$this->response = Customweb_Core_Http_Client_Factory::createClient()->send($request);
		}
		return $this->response;
	}
	
	protected function processResponse() {
		if($this->response === null) {
			throw new Exception("Cannot process null response.");
		}
		return $this->getResponseProcessor()->process($this->response);
	}
	
	protected function cacheResponse(){
		return true;
	}
	
	/**
	 * @return Customweb_Unzer_Communication_AbstractResponseProcessor
	 */
	protected abstract function getResponseProcessor();
	
	/**
	 * @return Customweb_Unzer_Communication_AbstractRequestBuilder
	 */
	protected abstract function getRequestBuilder();
}