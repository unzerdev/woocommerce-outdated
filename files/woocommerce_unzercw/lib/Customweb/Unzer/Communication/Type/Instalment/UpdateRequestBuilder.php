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

require_once 'Customweb/Core/DateTime.php';
require_once 'Customweb/Unzer/Communication/AbstractTransactionRequestBuilder.php';
require_once 'Customweb/Core/Http/IRequest.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Type_Instalment_UpdateRequestBuilder extends Customweb_Unzer_Communication_AbstractTransactionRequestBuilder {
	const DAYS_TO_PAY = 14;
	
	protected function getMethod(){
		return Customweb_Core_Http_IRequest::METHOD_PUT;
	}

	protected function getPayload(){
		$created = Customweb_Core_DateTime::_()->format('Y-m-d');
		$due = Customweb_Core_DateTime::_()->addHours(24 * self::DAYS_TO_PAY)->format('Y-m-d');
		return array(
			'invoiceDate' => $created,
			'invoiceDueDate' => $due
		);
	}

	protected function getUrlPath(){
		return $this->getPaymentMethodByTransaction($this->getTransaction())->getPaymentMethodParameter('path') . '/' .
				$this->getTransaction()->getUnzTypeId();
	}
}