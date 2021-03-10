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

require_once 'Customweb/Util/Rand.php';
require_once 'Customweb/I18n/Translation.php';


/**
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_Authorization_Method_Sepa_Mandate {
	
	const CUSTOMER_CONTEXT_KEY = 'sepa_mandate_id';
	
	public static function generateMandateId($schema) {
		
		$variables = array(
			'{day}' => date('d'),
			'{month}' => date('m'),
			'{year}' => date('Y'),
			'{random}' => strtoupper(Customweb_Util_Rand::getRandomString('20')),
		);
		
		$result = $schema;
		foreach ($variables as $variableName => $variableValue) {
			if (strstr($schema, $variableName) === false) {
				throw new Exception(Customweb_I18n_Translation::__(
					"The SEPA mandate schema does not contain the tag '!tag'. This tag is required.",
					array(
						'!tag' => $variableName,
				)));
			}
			$result = str_replace($variableName, $variableValue, $result);
		}
		
		// Remove unallowed chars, cut of to accepted length
		return self::sanitizeMandateId($result);
	}
	
	public static function sanitizeMandateId($id) {
		$id = str_replace('_', '-', $id);
		$id = preg_replace("#[^A-Za-z0-9[:space:]/\-\?\:()\.\,'\+]+#", '', $id);
		return substr($id, 0, 35);
	}
	
	/**
	 * This method returns mandate id set currently on the customer context.
	 * 
	 * @param Customweb_Payment_Authorization_IPaymentCustomerContext $context
	 * @throws Exception No mandate id was set on the customer context.
	 * @return string
	 */
	public static function getMandateIdFromCustomerContext(Customweb_Payment_Authorization_IPaymentCustomerContext $context, Customweb_Payment_Authorization_IPaymentMethod $paymentMethod) {
		$map = $context->getMap();
		$methodKey = strtolower($paymentMethod->getPaymentMethodName());
		if (isset($map[self::CUSTOMER_CONTEXT_KEY][$methodKey]) && !empty($map[self::CUSTOMER_CONTEXT_KEY][$methodKey])) {
			return $map[self::CUSTOMER_CONTEXT_KEY][$methodKey];
		}
		else {
			throw new Exception("No mandate id found in customer context.");
		}
	}
	
	/**
	 * Sets the mandate id on the customer context.
	 * 
	 * @param Customweb_Payment_Authorization_IPaymentCustomerContext $context
	 * @param string $id
	 * @return void
	 */
	public static function setMandateIdIntoCustomerContext(Customweb_Payment_Authorization_IPaymentCustomerContext $context, $id, Customweb_Payment_Authorization_IPaymentMethod $paymentMethod) {
		$methodKey = strtolower($paymentMethod->getPaymentMethodName());
		$map = array(
			self::CUSTOMER_CONTEXT_KEY => array(
				$methodKey => $id
			),
		);
		$context->updateMap($map);
	}
	
	/**
	 * Resets the mandate id in the customer context.
	 * 
	 * @param Customweb_Payment_Authorization_IPaymentCustomerContext $context
	 */
	public static function resetMandateId(Customweb_Payment_Authorization_IPaymentCustomerContext $context, Customweb_Payment_Authorization_IPaymentMethod $paymentMethod) {
		self::setMandateIdIntoCustomerContext($context, null, $paymentMethod);
	}
	
}