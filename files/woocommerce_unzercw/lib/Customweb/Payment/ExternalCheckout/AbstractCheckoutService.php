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

require_once 'Customweb/Core/DateTime.php';
require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Payment/ExternalCheckout/IContext.php';
require_once 'Customweb/Payment/ExternalCheckout/AbstractContext.php';
require_once 'Customweb/Core/Assert.php';
require_once 'Customweb/Payment/ExternalCheckout/ICheckoutService.php';
require_once 'Customweb/Core/Util/Rand.php';
require_once 'Customweb/Payment/Exception/ExternalCheckoutTokenExpiredException.php';
require_once 'Customweb/Payment/Exception/ExternalCheckoutInvalidTokenException.php';


/**
 * Abstract implementation of the external checkout service. It based on database entities.
 * 
 * If the implementor does not want to use the entity manager. This service should not be used.
 * 
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_Payment_ExternalCheckout_AbstractCheckoutService implements Customweb_Payment_ExternalCheckout_ICheckoutService {
	
	/**
	 * @var Customweb_Database_Entity_IManager
	 */
	private $entityManager;
	
	/**
	 * @var Customweb_DependencyInjection_IContainer
	 */
	private $container;
	
	/**
	 * @var Customweb_Payment_ExternalCheckout_IProviderService
	 */
	private $providerService;
	
	/**
	 * @var Customweb_Payment_ITransactionHandler
	 */
	private $transactionHandler;
	
	public function __construct(Customweb_DependencyInjection_IContainer $container) {
		$this->container = $container;
		$this->providerService = $container->getBean('Customweb_Payment_ExternalCheckout_IProviderService');
		$this->entityManager = $container->getBean('Customweb_Database_Entity_IManager');
		$this->transactionHandler = $container->getBean('Customweb_Payment_ITransactionHandler');
	}

	/**
	 * This method updates the inner state of the context based on the request. Typically the implementor will set the shipping
	 * method provided by the user over the $request object. The implementor should also make sure that the selection is valid
	 * in the current context.
	 *
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @param Customweb_Core_Http_IRequest $request
	 */
	abstract protected function updateShippingMethodOnContext(Customweb_Payment_ExternalCheckout_IContext $context, Customweb_Core_Http_IRequest $request);
	
	/**
	 * This method extracts from the $request object the human readable name of the shipping method.
	 *
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @param Customweb_Core_Http_IRequest $request
	 */
	abstract protected function extractShippingName(Customweb_Payment_ExternalCheckout_IContext $context, Customweb_Core_Http_IRequest $request);
	
	/**
	 * Creates a new transaction context based on the checkout context.
	 * 
	 * <p>
	 * The implementor may first create a order context, a transaction in the database 
	 * and the order object.
	 * 
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @return Customweb_Payment_Authorization_ITransactionContext
	 */
	abstract protected function createTransactionContextFromContext(Customweb_Payment_ExternalCheckout_IContext $context);
	
	/**
	 * Refreshes the context depending on the current settings.
	 * 
	 * <p>
	 * This method is called whenever a property is updated in the context. The implementor
	 * may use this method to reflect the changes in the shopping cart and update the 
	 * shipping costs etc.
	 * 
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 * @param string $action
	 */
	abstract protected function refreshContext(Customweb_Payment_ExternalCheckout_AbstractContext $context);
	
	/**
	 * This method updates the user session as defined in the context.
	 * 
	 * Essentially this method authenticate the user in the context.
	 * 
	 * @param Customweb_Payment_ExternalCheckout_AbstractContext $context
	 */
	abstract protected function updateUserSessionWithCurrentUser(Customweb_Payment_ExternalCheckout_AbstractContext $context);
	
	/**
	 * Refreshed the context after a failure occurred.
	 * 
	 * <p>
	 * This way the implementor has the option to update the session etc.
	 * 
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 */
	protected function refreshFailedContext(Customweb_Payment_ExternalCheckout_IContext $context) {
		
	}
	

	public function createSecurityToken(Customweb_Payment_ExternalCheckout_IContext $context) {
		if (!($context instanceof Customweb_Payment_ExternalCheckout_AbstractContext)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Payment_ExternalCheckout_AbstractContext');
		}
		$token = Customweb_Core_Util_Rand::getUuid();
		if($context->getSecurityToken() == null){
			$context->setSecurityToken($token);
			$context->setSecurityTokenExpiryDate(Customweb_Core_DateTime::_()->addHours(4));
			$this->entityManager->persist($context);
		}
		return $context->getSecurityToken();
	}
	
	public function checkSecurityTokenValidity(Customweb_Payment_ExternalCheckout_IContext $context, $token) {
		if (!($context instanceof Customweb_Payment_ExternalCheckout_AbstractContext)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Payment_ExternalCheckout_AbstractContext');
		}
		if ($context->getSecurityToken() === null || $context->getSecurityToken() !== $token) {
			throw new Customweb_Payment_Exception_ExternalCheckoutInvalidTokenException();	
		}
		$expiryDate = $context->getSecurityTokenExpiryDate();
		if ($expiryDate instanceof DateTime) {
			$expiryDate = new Customweb_Core_DateTime($expiryDate);
			if ($expiryDate->getTimestamp() > time()){
				return;
			}
		}
		throw new Customweb_Payment_Exception_ExternalCheckoutTokenExpiredException();
		
	}
	
	public function markContextAsFailed(Customweb_Payment_ExternalCheckout_IContext $context, $message) {
		if (!($context instanceof Customweb_Payment_ExternalCheckout_AbstractContext)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Payment_ExternalCheckout_AbstractContext');
		}
		if ($context->getState() == Customweb_Payment_ExternalCheckout_IContext::STATE_COMPLETED) {
			throw new Exception("The external checkout context cannot be set to state FAILED, while the context is already in state COMPLETED.");
		}
		$context->setState(Customweb_Payment_ExternalCheckout_IContext::STATE_FAILED);
		$context->setFailedErrorMessage($message);
		$this->refreshFailedContext($context);
		$this->entityManager->persist($context);
	}
	
	public function updateProviderData(Customweb_Payment_ExternalCheckout_IContext $context, array $data) {
		if (!($context instanceof Customweb_Payment_ExternalCheckout_AbstractContext)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Payment_ExternalCheckout_AbstractContext');
		}
		if ($context->getState() != Customweb_Payment_ExternalCheckout_IContext::STATE_PENDING) {
			throw new Exception("The external checkout context cannot updated, while the context is already in state COMPLETED or FAILED.");
		}
		$context->setProviderData($data);
		$this->refreshContext($context);
		$this->entityManager->persist($context, false);
	}

	public function updateCustomerEmailAddress(Customweb_Payment_ExternalCheckout_IContext $context, $emailAddress) {
		if (!($context instanceof Customweb_Payment_ExternalCheckout_AbstractContext)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Payment_ExternalCheckout_AbstractContext');
		}
		if ($context->getState() != Customweb_Payment_ExternalCheckout_IContext::STATE_PENDING) {
			throw new Exception("The external checkout context cannot updated, while the context is already in state COMPLETED or FAILED.");
		}
		
		$context->setCustomerEmailAddress($emailAddress);
		$this->refreshContext($context);
		$this->updateUserSessionWithCurrentUser($context);
		$this->entityManager->persist($context);
	}

	public function updateShippingAddress(Customweb_Payment_ExternalCheckout_IContext $context, Customweb_Payment_Authorization_OrderContext_IAddress $address) {
		if (!($context instanceof Customweb_Payment_ExternalCheckout_AbstractContext)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Payment_ExternalCheckout_AbstractContext');
		}
		if ($context->getState() != Customweb_Payment_ExternalCheckout_IContext::STATE_PENDING) {
			throw new Exception("The external checkout context cannot updated, while the context is already in state COMPLETED or FAILED.");
		}
		$this->checkAddress($address);
		$context->setShippingAddress($address);
		$this->refreshContext($context);
		$this->entityManager->persist($context, false);
	}

	public function updateBillingAddress(Customweb_Payment_ExternalCheckout_IContext $context, Customweb_Payment_Authorization_OrderContext_IAddress $address) {
		if (!($context instanceof Customweb_Payment_ExternalCheckout_AbstractContext)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Payment_ExternalCheckout_AbstractContext');
		}
		if ($context->getState() != Customweb_Payment_ExternalCheckout_IContext::STATE_PENDING) {
			throw new Exception("The external checkout context cannot updated, while the context is already in state COMPLETED or FAILED.");
		}
		$this->checkAddress($address);
		$context->setBillingAddress($address);
		$this->refreshContext($context);
		$this->entityManager->persist($context, false);
	}

	public function updateShippingMethod(Customweb_Payment_ExternalCheckout_IContext $context, Customweb_Core_Http_IRequest $request) {
		if (!($context instanceof Customweb_Payment_ExternalCheckout_AbstractContext)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Payment_ExternalCheckout_AbstractContext');
		}
		if ($context->getState() != Customweb_Payment_ExternalCheckout_IContext::STATE_PENDING) {
			throw new Exception("The external checkout context cannot updated, while the context is already in state COMPLETED or FAILED.");
		}
		$this->updateShippingMethodOnContext($context, $request);
		$context->setShippingMethodName($this->extractShippingName($context, $request));
		$this->refreshContext($context);
		$this->entityManager->persist($context);
	}

	public function updatePaymentMethod(Customweb_Payment_ExternalCheckout_IContext $context, Customweb_Payment_Authorization_IPaymentMethod $method) {
		if (!($context instanceof Customweb_Payment_ExternalCheckout_AbstractContext)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Payment_ExternalCheckout_AbstractContext');
		}
		if ($context->getState() != Customweb_Payment_ExternalCheckout_IContext::STATE_PENDING) {
			throw new Exception("The external checkout context cannot updated, while the context is already in state COMPLETED or FAILED.");
		}
		$context->setPaymentMethod($method);
		$this->refreshContext($context);
		$this->entityManager->persist($context);
	}
	
	public function renderAdditionalFormElements(Customweb_Payment_ExternalCheckout_IContext $context, $errorMessage) {
		return '';
	}
	
	public function processAdditionalFormElements(Customweb_Payment_ExternalCheckout_IContext $context, Customweb_Core_Http_IRequest $request) {
		// Per default we do nothing.
	}

	public function createOrder(Customweb_Payment_ExternalCheckout_IContext $context) {
		if (!($context instanceof Customweb_Payment_ExternalCheckout_AbstractContext)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Payment_ExternalCheckout_AbstractContext');
		}
		try {
			if ($context->getState() == Customweb_Payment_ExternalCheckout_IContext::STATE_COMPLETED) {
				$transcationId = $context->getTransactionId();
				if (empty($transcationId)) {
					throw new Exception("Invalid state. The context can not be in state COMPLETED without transaction id set.");
				}
				return $this->getTransactionHandler()->findTransactionByTransactionId($transcationId);
			}
			else if ($context->getState() == Customweb_Payment_ExternalCheckout_IContext::STATE_FAILED) {
				throw new Exception("A failed context cannot be completed.");
			}
			
			$this->checkContextCompleteness($context);
			$this->getTransactionHandler()->beginTransaction();
			$transactionContext = $this->createTransactionContextFromContext($context);
			$transactionObject = $this->getProviderService()->createTransaction($transactionContext, $context);
			$this->getTransactionHandler()->persistTransactionObject($transactionObject);
			$context->setTransactionId($transactionObject->getTransactionContext()->getTransactionId());
			$context->setState(Customweb_Payment_ExternalCheckout_IContext::STATE_COMPLETED);
			$this->entityManager->persist($context);
			$this->getTransactionHandler()->commitTransaction();
			return $transactionObject;
		}
		catch(Exception $e) {
			if ($this->getTransactionHandler()->isTransactionRunning()) {
				$this->getTransactionHandler()->rollbackTransaction();
			}
			throw $e;
		}
	}
	
	protected function checkContextCompleteness(Customweb_Payment_ExternalCheckout_IContext $context) {
		Customweb_Core_Assert::notNull($context->getBillingAddress(), "The context must contain a billing address, before it can be COMPLETED.");
		Customweb_Core_Assert::notNull($context->getShippingAddress(), "The context must contain a shipping address, before it can be COMPLETED. You may use the billing address when no shipping address is present.");
		Customweb_Core_Assert::hasLength($context->getShippingMethodName(), "The context must contain a shipping method name, before it can be COMPLETED.");
		Customweb_Core_Assert::notNull($context->getBillingAddress(), "The context must contain a billing address, before it can be COMPLETED.");
		Customweb_Core_Assert::hasSize($context->getInvoiceItems(), "At least one line item must be added before it can be COMPLETED.");
		Customweb_Core_Assert::hasLength($context->getCustomerEmailAddress(), "The context must contain an e-mail address before it can be COMPLETED.");
	}
	
	protected final function checkAddress(Customweb_Payment_Authorization_OrderContext_IAddress $address) {
		Customweb_Core_Assert::hasLength($address->getFirstName(), "The address must contain a firstname.");
		Customweb_Core_Assert::hasLength($address->getLastName(), "The address must contain a lastname.");
		Customweb_Core_Assert::hasLength($address->getStreet(), "The address must contain a street.");
		Customweb_Core_Assert::hasLength($address->getPostCode(), "The address must contain a post code.");
		Customweb_Core_Assert::hasLength($address->getCountryIsoCode(), "The address must contain a country.");
		Customweb_Core_Assert::hasLength($address->getCity(), "The address must contain a city.");
	}
	
	/**
	 * @return Customweb_Database_Entity_IManager
	 */
	protected function getEntityManager() {
		return $this->entityManager;
	}
	
	/**
	 * @return Customweb_Payment_ExternalCheckout_IProviderService
	 */
	protected function getProviderService() {
		return $this->providerService;
	}
	
	/**
	 * @return Customweb_Payment_ITransactionHandler
	 */
	protected function getTransactionHandler() {
		return $this->transactionHandler;
	}

}
