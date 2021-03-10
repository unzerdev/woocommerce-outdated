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

require_once 'Customweb/Core/String.php';



/**
 * Class to cache return values from diverse methods
 *
 * @author Sebastian Bossert
 */
final class Customweb_Payment_Cache_KeyGenerator {

	/**
	 * Creates a key based on both addresses found in the orderContext
	 *
	 * @param Customweb_Payment_Authorization_IOrderContext $orderContext
	 * @param array $additionalData Other identifiers to be added to the generated key (e.g. amount, payment type etc)
	 * @return string
	 */
	public static function generateAddressKey(Customweb_Payment_Authorization_IOrderContext $orderContext, $additionalData = array()){
		$billing = $orderContext->getBillingAddress();
		$shipping = $orderContext->getShippingAddress();
		$addressParts = array_merge(self::addressPartsToArray($billing), self::addressPartsToArray($shipping), $additionalData);
		$addressString = Customweb_Core_String::_(implode($addressParts))->toLowerCase()->toString();
		return substr(hash('SHA512', $addressString), 0, 160);
	}

	private static function addressPartsToArray(Customweb_Payment_Authorization_OrderContext_IAddress $address){
		$parts = array(
			$address->getCity(),
			$address->getCommercialRegisterNumber(),
			$address->getCompanyName(),
			$address->getCountryIsoCode(),
			$address->getEMailAddress(),
			$address->getFirstName(),
			$address->getGender(),
			$address->getLastName(),
			$address->getMobilePhoneNumber(),
			$address->getPhoneNumber(),
			$address->getPostCode(),
			$address->getSalesTaxNumber(),
			$address->getSalutation(),
			$address->getSocialSecurityNumber(),
			$address->getState(),
			$address->getStreet() 
		);
		$dob = $address->getDateOfBirth();
		if ($dob instanceof DateTime) {
			$parts[] = $dob->format('Y-m-d');
		}
		return $parts;
	}
}