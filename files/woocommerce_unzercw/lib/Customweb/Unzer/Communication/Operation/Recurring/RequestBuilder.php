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

require_once 'Customweb/Unzer/Communication/AbstractTransactionRequestBuilder.php';
require_once 'Customweb/Core/Http/IRequest.php';


/**
 * Send a register request to create a recurring zero transaction
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Operation_Recurring_RequestBuilder extends Customweb_Unzer_Communication_AbstractTransactionRequestBuilder {

	protected function getMethod(){
		return Customweb_Core_Http_IRequest::METHOD_POST;
	}

	protected function getUrlPath(){
		return str_replace(array(
			'{typeId}'
		), array(
			$this->getTransaction()->getUnzTypeId()
		), 'types/{typeId}/recurring');
	}

	protected function getPayload(){
		return array(
			'returnUrl' => $this->getReturnUrl(),
			'resources' => array(
				'customerId' => $this->transaction->getUnzCustomerId()
			)
		);
	}

	protected function getReturnUrl(){
		return $this->getContainer()->createUnsecuredEndpointUrl('process', 'returntostore', $this->getTransaction());
	}
}