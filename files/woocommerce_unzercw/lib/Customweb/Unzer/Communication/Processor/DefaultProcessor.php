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

require_once 'Customweb/Unzer/Communication/Processor/AbstractProcessor.php';


/**
 * Default processor to send request and process the response.
 * 
 * @author sebastian
 *
 */
class Customweb_Unzer_Communication_Processor_DefaultProcessor extends Customweb_Unzer_Communication_Processor_AbstractProcessor {
	protected $requestBuilder;
	protected $responseProcessor;
		
	public function __construct(Customweb_Unzer_Communication_AbstractRequestBuilder $requestBuilder, Customweb_Unzer_Communication_AbstractResponseProcessor $responseProcessor, Customweb_DependencyInjection_IContainer $container) {
		parent::__construct($container);
		$this->requestBuilder = $requestBuilder;
		$this->responseProcessor = $responseProcessor;
	}

	protected function getResponseProcessor() {
		return $this->responseProcessor;
	}
	
	protected function getRequestBuilder() {
		return $this->requestBuilder;
	}
}