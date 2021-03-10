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

require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Unzer/Util/String.php';
require_once 'Customweb/Unzer/Communication/AbstractTransactionRequestBuilder.php';
require_once 'Customweb/Core/Http/IRequest.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Operation_Authorize_RequestBuilder extends Customweb_Unzer_Communication_AbstractTransactionRequestBuilder {

	protected function getMethod(){
		return Customweb_Core_Http_IRequest::METHOD_POST;
	}

	protected function getPayload(){
		// @formatter:off
		return array_merge(
				$this->getMandatoryParameter('amount', Customweb_Util_Currency::formatAmount($this->getTransaction()->getAuthorizationAmount(), $this->getTransaction()->getCurrencyCode())),
				$this->getMandatoryParameter('currency', $this->getTransaction()->getCurrencyCode()),
				$this->getOptionalParameter('returnUrl', $this->getPaymentMethod()->getAuthorizeReturnUrl($this->getTransaction())),
				$this->getOptionalParameter('orderId', $this->getOrderId()),
				$this->getOptionalParameter('invoiceId', $this->getInvoiceId()),
				$this->getOptionalParameter('paymentReference', $this->getPaymentReference()),
				$this->getResourcesParameter(),
				$this->getPaymentMethod()->getAdditionalAuthorizeParameters($this->getTransaction())
		);
		// @formatter:on
	}

	protected function getInvoiceId(){
		return Customweb_Unzer_Util_String::applySchema($this->getContainer()->getConfiguration()->getInvoiceIdSchema(),
				$this->getTransaction());
	}

	protected function getPaymentReference(){
		return Customweb_Unzer_Util_String::applySchema($this->getContainer()->getConfiguration()->getPaymentReferenceSchema(),
				$this->getTransaction());
	}

	protected function getResourcesParameter(){
		$this->getLogger()->logDebug("Creating resources param w/ customer?: {$this->getTransaction()->getUnzCustomerId()}");
		// @formatter:off
		return array(
			'resources' => array_merge(
				$this->getMandatoryParameter('typeId', $this->getTransaction()->getUnzTypeId()),
				$this->getOptionalParameter('basketId', $this->getTransaction()->getUnzBasketId()),
				$this->getOptionalParameter('customerId', $this->getTransaction()->getUnzCustomerId()),
				$this->getOptionalParameter('metadataId', $this->getTransaction()->getUnzMetadataId())
			)
		);
		// @formatter:on
	}
	
	protected function getUrlPath(){
		return "payments/authorize";
	}
	
	protected function getPaymentMethod() {
		return $this->getPaymentMethodByTransaction($this->getTransaction());
	}
}