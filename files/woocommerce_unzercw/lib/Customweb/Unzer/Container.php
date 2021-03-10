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

require_once 'Customweb/Payment/AbstractContainer.php';
require_once 'Customweb/Core/Url.php';
require_once 'Customweb/Unzer/Helper/TransactionLoader.php';
require_once 'Customweb/Unzer/Endpoint/Process.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Container extends Customweb_Payment_AbstractContainer {
	private $transactionLoader;
	private $storageHelper;

	/**
	 * Util wrapper to create instance of self based on given container.
	 *
	 * @param Customweb_DependencyInjection_IContainer $container
	 * @return Customweb_Unzer_Container
	 */
	public static function get(Customweb_DependencyInjection_IContainer $container){
		if (!($container instanceof self)) {
			$container = new self($container);
		}
		return $container;
	}

	/**
	 *
	 * @return Customweb_Unzer_Helper_Storage
	 */
	public function getStorageHelper(){
		if ($this->storageHelper === null) {
			$this->storageHelper = $this->getBean('Customweb_Unzer_Helper_Storage');
		}
		return $this->storageHelper;
	}

	/**
	 *
	 * @return Customweb_Unzer_Configuration
	 */
	public function getConfiguration(){
		return $this->getBean('Customweb_Unzer_Configuration');
	}

	/**
	 *
	 * @param Customweb_Payment_Authorization_IPaymentMethod $paymentMethod
	 * @param String $authorizationMethod
	 * @return Customweb_Unzer_Method_Default
	 */
	public function getPaymentMethod(Customweb_Payment_Authorization_IPaymentMethod $paymentMethod, $authorizationMethod){
		return $this->getPaymentMethodFactory()->getPaymentMethod($paymentMethod, $authorizationMethod);
	}

	/**
	 *
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @return Customweb_Unzer_Method_Default
	 */
	public function getPaymentMethodByTransaction(Customweb_Payment_Authorization_ITransaction $transaction){
		return $this->getPaymentMethod($transaction->getPaymentMethod(), $transaction->getAuthorizationMethod());
	}

	/**
	 *
	 * @return Customweb_Payment_Endpoint_IAdapter
	 */
	public function getEndpointAdapter(){
		return $this->getBean('Customweb_Payment_Endpoint_IAdapter');
	}

	/**
	 *
	 * @return Customweb_Asset_IResolver
	 */
	public function getAssetResolver(){
		return $this->getBean('Customweb_Asset_IResolver');
	}

	/**
	 *
	 * @return Customweb_Core_Http_IRequest
	 */
	public function getHttpRequest(){
		return $this->getBean('Customweb_Core_Http_IRequest');
	}

	/**
	 *
	 * @return Customweb_Storage_IBackend
	 */
	public function getStorage(){
		return $this->getBean("Customweb_Storage_IBackend");
	}

	public function getTransactionLoader(){
		if ($this->transactionLoader === null) {
			$this->transactionLoader = new Customweb_Unzer_Helper_TransactionLoader($this->getTransactionHandler(),
					$this->getStorageHelper());
		}
		return $this->transactionLoader;
	}

	/**
	 *
	 * @return Customweb_Unzer_Method_Factory
	 */
	private function getPaymentMethodFactory(){
		return $this->getBean('Customweb_Unzer_Method_Factory');
	}

	public function createSecuredEndpointUrl($controller, $action, Customweb_Unzer_Authorization_Transaction $transaction){
		$url = new Customweb_Core_Url(
				$this->getEndpointAdapter()->getUrl($controller, $action,
						array(
							Customweb_Unzer_Endpoint_Process::HASH_PARAMETER => $transaction->getSecuritySignature("$controller$action"),
							'cw_transaction_id' => $transaction->getExternalTransactionId()
						)));
		return $url->toString();
	}

	public function createUnsecuredEndpointUrl($controller, $action, Customweb_Unzer_Authorization_Transaction $transaction){
		$url = new Customweb_Core_Url(
				$this->getEndpointAdapter()->getUrl($controller, $action, array(
					'cw_transaction_id' => $transaction->getExternalTransactionId()
				)));
		return $url->toString();
	}
	
	public function getPendingUrl(Customweb_Unzer_Authorization_Transaction $transaction){
		return $this->createSecuredEndpointUrl('pending', 'index', $transaction);
	}
}