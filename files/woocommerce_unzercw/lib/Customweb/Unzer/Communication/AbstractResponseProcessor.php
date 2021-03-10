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

require_once 'Customweb/Unzer/Communication/Exception.php';
require_once 'Customweb/Unzer/Adapter.php';


/**
 * Used to process responses from the heidelpay API.
 * Basic implementation of status code checking and error extraction.
 *
 * @author Sebastian Bossert
 */
abstract class Customweb_Unzer_Communication_AbstractResponseProcessor extends Customweb_Unzer_Adapter {
	protected $response;
	protected $data;

	public function __construct(Customweb_DependencyInjection_IContainer $container){
		parent::__construct($container);
	}

	public function process(Customweb_Core_Http_IResponse $response){
		$this->response = $response;
		$this->data = json_decode($this->response->getBody(), true);
		if ($this->isError()) {
			$this->processError();
		}
	}

	protected function processError(){
		$e = new Customweb_Unzer_Communication_Exception($this->data);
		$this->getLogger()->logError("Request failed with backend message: " . $e->getErrorMessage()->getBackendMessage(), $this->response);
		throw $e;
	}

	/**
	 * Returns an array of http status codes which indicate the request was processed successfully.
	 *
	 * @return array
	 */
	protected abstract function getValidResponseCodes();

	protected function isError(){
		return !in_array($this->response->getStatusCode(), $this->getValidResponseCodes()) || 
				(is_array($this->data) && isset($this->data['isError']) && $this->data['isError']);
	}
}