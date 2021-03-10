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
final class Customweb_Util_Address {

	private function __construct(){}

	/**
	 * Code from
	 * https://github.com/VIISON/AddressSplitting
	 *
	 * @author andrewisplinghoff
	 *
	 * @param string $street
	 * @param string $countryIsoCode
	 * @param string $zipCode
	 * @return array()
	 */
	public static function splitStreet($street, $countryIsoCode, $zipCode){
		$address = $street;
		$matches = array();
		
		$regex = '
           /\A\s*
           (?: #########################################################################
               # Option A: [<Addition to address 1>] <House number> <Street name>      #
               # [<Addition to address 2>]                                             #
               #########################################################################
               (?:(?P<A_Addition_to_address_1>.*?),\s*)? # Addition to address 1
           (?:No\.\s*)?
               (?P<A_House_number>\pN+[a-zA-Z]?(?:\s*[-\/\pP]\s*\pN+[a-zA-Z]?)*) # House number
           \s*,?\s*
               (?P<A_Street_name>(?:[a-zA-Z]\s*|\pN\pL{2,}\s\pL)\S[^,#]*?(?<!\s)) # Street name
           \s*(?:(?:[,\/]|(?=\#))\s*(?!\s*No\.)
               (?P<A_Addition_to_address_2>(?!\s).*?))? # Addition to address 2
           |   #########################################################################
               # Option B: [<Addition to address 1>] <Street name> <House number>      #
               # [<Addition to address 2>]                                             #
               #########################################################################
               (?:(?P<B_Addition_to_address_1>.*?),\s*(?=.*[,\/]))? # Addition to address 1
               (?!\s*No\.)(?P<B_Street_name>[^0-9# ]\s*\S(?:[^,#](?!\b\pN+\s))*?(?<!\s)) # Street name
           \s*[\/,]?\s*(?:\sNo\.)?\s*
               (?P<B_House_number>\pN+\s*-?[a-zA-Z]?(?:\s*[-\/\pP]?\s*\pN+(?:\s*[\-a-zA-Z])?)*|
               [IVXLCDM]+(?!.*\b\pN+\b))(?<!\s) # House number
           \s*(?:(?:[,\/]|(?=\#)|\s)\s*(?!\s*No\.)\s*
               (?P<B_Addition_to_address_2>(?!\s).*?))? # Addition to address 2
           )
           \s*\Z/xu';
		$result = preg_match($regex, $address, $matches);
		if ($result === 0 || $result === false) {
			return array(
				'street-addition-1' => "",
				'street' => $street,
				'street-number' => "",
				'street-addition-2' => "" 
			);
		}
		if (!empty($matches['A_Street_name'])) {
			return array(
				'street-addition-1' => $matches['A_Addition_to_address_1'],
				'street' => $matches['A_Street_name'],
				'street-number' => $matches['A_House_number'],
				'street-addition-2' => (isset($matches['A_Addition_to_address_2'])) ? $matches['A_Addition_to_address_2'] : '' 
			);
		}
		else {
			return array(
				'street-addition-1' => $matches['B_Addition_to_address_1'],
				'street' => $matches['B_Street_name'],
				'street-number' => $matches['B_House_number'],
				'street-addition-2' => isset($matches['B_Addition_to_address_2']) ? $matches['B_Addition_to_address_2'] : '' 
			);
		}
	}

	/**
	 * This method takes two order context addresses and compares them.
	 * The method returns true, when they match.
	 *
	 * @param Customweb_Payment_Authorization_OrderContext_IAddress $address1
	 * @param Customweb_Payment_Authorization_OrderContext_IAddress $address2
	 * @return boolean
	 */
	public static function compareAddresses(Customweb_Payment_Authorization_OrderContext_IAddress $address1, Customweb_Payment_Authorization_OrderContext_IAddress $address2){
		if ($address1->getCity() != $address2->getCity()) {
			return false;
		}
		if ($address1->getCompanyName() != $address2->getCompanyName()) {
			return false;
		}
		if ($address1->getCountryIsoCode() != $address2->getCountryIsoCode()) {
			return false;
		}
		if ($address1->getFirstName() != $address2->getFirstName()) {
			return false;
		}
		if ($address1->getLastName() != $address2->getLastName()) {
			return false;
		}
		if ($address1->getPostCode() != $address2->getPostCode()) {
			return false;
		}
		if ($address1->getStreet() != $address2->getStreet()) {
			return false;
		}
		
		return true;
	}

	/**
	 * This method takes the two order contexts and compare their shipping addresses.
	 * The method returns true, when they equal.
	 *
	 * @param Customweb_Payment_Authorization_IOrderContext $orderContext1
	 * @param Customweb_Payment_Authorization_IOrderContext $orderContext2
	 * @return boolean
	 */
	public static function compareShippingAddresses(Customweb_Payment_Authorization_IOrderContext $orderContext1, Customweb_Payment_Authorization_IOrderContext $orderContext2){
		return self::compareAddresses($orderContext1->getShippingAddress(), $orderContext2->getShippingAddress());
	}
}