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

require_once 'Customweb/Payment/Authorization/IAdapter.php';

abstract class Customweb_Payment_Authorization_AbstractAdapterWrapper implements Customweb_Payment_Authorization_IAdapter {

	/**
	 * @var Customweb_Payment_Authorization_IAdapter
	 */
	private $adapter;

	public function __construct($adapter) {
		$this->adapter = $adapter;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IAdapter::isAuthorizationMethodSupported()
	 */
	public function isAuthorizationMethodSupported(Customweb_Payment_Authorization_IOrderContext $orderContext) {
		return $this->adapter->isAuthorizationMethodSupported($orderContext);
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IAdapter::validate()
	 */
	public function validate(Customweb_Payment_Authorization_IOrderContext $orderContext,
			Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext, array $formData) {
		return $this->adapter->validate($orderContext, $paymentContext);
	}

	public function isDeferredCapturingSupported(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext) {
		return $this->adapter->isDeferredCapturingSupported($orderContext, $paymentContext);
	}

	/**
	 * (non-PHPdoc) 
	 * @see Customweb_Payment_Authorization_IAdapter::processAuthorization()
	 */
	public function processAuthorization(Customweb_Payment_Authorization_ITransaction $transaction, array $parameters) {
		return $this->adapter->processAuthorization($transaction, $parameters);
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IAdapter::finalizeAuthorizationRequest()
	 */
	public function finalizeAuthorizationRequest(Customweb_Payment_Authorization_ITransaction $transaction) {
		return $this->adapter->finalizeAuthorizationRequest($transaction);
	}


}