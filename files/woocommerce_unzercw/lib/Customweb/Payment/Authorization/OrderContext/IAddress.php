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




/**
 * This interface represents an address of a customer including all the details of 
 * the address (birthday etc.)
 * 
 * @author Thomas Hunziker / Nico Eigenmann
 *
 */
interface Customweb_Payment_Authorization_OrderContext_IAddress {
	
	/**
	 * The email address of the  address.
	 *
	 * @return null | string The e-mail address of the  address.
	 */
	public function getEMailAddress();
	
	/**
	 * The gender for the  address.
	 *
	 * @return null | String 'male' | 'female' | 'company'
	*/
	public function getGender();
	
	/**
	 * The salutation for the  address.
	 *
	 * If the salutation is not available to the implementer, null may be returned. The
	 * API will make sure that the salutation is entered by the user if needed.
	 *
	 * @return null | string
	*/
	public function getSalutation();
	
	/**
	 * The  address first name.
	 *
	 * @return String The first name of the  address.
	*/
	public function getFirstName();
	
	/**
	 * The  address last name.
	 *
	 * @return String The last name of the  address.
	*/
	public function getLastName();
	
	/**
	 * The  address street.
	 *
	 * @return String The first name of the street.
	*/
	public function getStreet();
	
	/**
	 * The  address city.
	 *
	 * @return String The city of the  address.
	*/
	public function getCity();
	
	/**
	 * The address post code (ZIP).
	 *
	 * @return String The post code of the  address.
	*/
	public function getPostCode();
	
	/**
	 * The  address state in ISO format (2-3 letters).
	 *
	 * @return null | String The state code of the  address.
	*/
	public function getState();
	
	/**
	 * The  address country code in ISO format (2 letters).
	 *
	 * @return String The country code of the  address.
	*/
	public function getCountryIsoCode();
	
	/**
	 * This method returns a phone number of the person.
	 *
	 * @return null | string
	*/
	public function getPhoneNumber();
	
	/**
	 * This method returns a mobile phone number of the person.
	 * The method should only return mobile phone numbers, not others.
	 *
	 * @return null | string
	*/
	public function getMobilePhoneNumber();
	
	/**
	 * The date of of birth of the person.
	 *
	 * If the date of of birth is not available to the implementer, null may be returned.
	 * The API will make sure that the date of of birth is entered by the user if needed.
	 *
	 * @return null | DateTime
	*/
	public function getDateOfBirth();
	
	/**
	 * The commercial register number of the company.
	 *
	 * If the commercial register number is not available to the implementer, null
	 * may be returned. The API will make sure that the commercial register number
	 * is entered by the user if needed.
	 *
	 * @return null | string The commercial register number as a string.
	*/
	public function getCommercialRegisterNumber();
	
	/**
	 * The name of the company of the address.
	 *
	 * If the name of the company is not available to the implementer, null
	 * may be returned. The API will make sure that the name of the company
	 * is entered by the user if needed.
	 *
	 * @return null | string Compay name.
	*/
	public function getCompanyName();
	
	/**
	 * The sales tax number of the  address.
	 *
	 * If the sales tax number is not available to the implementer, null
	 * may be returned. The API will make sure that the sales tax number
	 * is entered by the user if needed.
	 *
	 * @return null | string The sales tax number
	*/
	public function getSalesTaxNumber();
	
	/**
	 * The social security number of the person.
	 *
	 * If the SSN is not available to the implementer, null
	 * may be returned. The API will make sure that the SSN
	 * is entered by the user if needed.
	 *
	 * @return null | string Social security number.
	*/
	public function getSocialSecurityNumber();
	
	
}