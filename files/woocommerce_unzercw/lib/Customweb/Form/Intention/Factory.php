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

require_once 'Customweb/Form/Intention/Intention.php';
require_once 'Customweb/Form/Intention/NullIntention.php';

final class Customweb_Form_Intention_Factory {
	private static $null = null;
	private static $cardHolder = null;
	private static $cvc = null;
	private static $cardNumber = null;
	private static $expirationDate = null;
	private static $bankCode = null;
	private static $accountNumber = null;
	private static $accountOwnerName = null;
	private static $dateOfBirth = null;
	private static $ibanNumber = null;
	private static $bankLocation = null;
	private static $bankName = null;
	
	private function __construct() {}
	
	/**
	 * This method returns the card holder name element intention.
	 * 
	 * @return Customweb_Form_Intention_Intention
	 */
	public static function getCardHolderNameIntention() {
		if (self::$cardHolder === null) {
			self::$cardHolder = new Customweb_Form_Intention_Intention('card-holder-name');
		}
		return self::$cardHolder;
	}
	
	/**
	 * This method returns the account owner name element intention.
	 *
	 * @return Customweb_Form_Intention_Intention
	 */
	public static function getAccountOwnerNameIntention() {
		if (self::$accountOwnerName === null) {
			self::$accountOwnerName = new Customweb_Form_Intention_Intention('account-owner-name');
		}
		return self::$accountOwnerName;
	}
	
	/**
	 * This method returns the CVC element intention.
	 * 
	 * @return Customweb_Form_Intention_Intention
	 */
	public static function getCvcIntention() {
		if (self::$cvc === null) {
			self::$cvc = new Customweb_Form_Intention_Intention('card-cvc');
		}
		return self::$cvc;
	}
	
	/**
	 * This method returns the card number element intention.
	 * 
	 * @return Customweb_Form_Intention_Intention
	 */
	public static function getCardNumberIntention() {
		if (self::$cardNumber === null) {
			self::$cardNumber = new Customweb_Form_Intention_Intention('card-number');
		}
		return self::$cardNumber;
	}
	
	/**
	 * This method returns the expiration date element intention.
	 * 
	 * @return Customweb_Form_Intention_Intention
	 */
	public static function getExpirationDateIntention() {
		if (self::$expirationDate === null) {
			self::$expirationDate = new Customweb_Form_Intention_Intention('expiration-date');
		}
		return self::$expirationDate;
	}
	
	/**
	 * This method returns the null element intention.
	 * 
	 * @return Customweb_Form_Intention_NullIntention
	 */
	public static function getNullIntention() {
		if (self::$null === null) {
			self::$null = new Customweb_Form_Intention_NullIntention();
		}
		return self::$null;
	}
	
	/**
	 * This method returns the bank code element intention.
	 * 
	 * @return Customweb_Form_Intention_Intention
	 */
	public static function getBankCodeIntention(){
		if(self::$bankCode === null){
			self::$bankCode = new Customweb_Form_Intention_Intention('bank-code');
		}
		return self::$bankCode;
	}
	
	/**
	 * This method returns the account number element intention.
	 * 
	 * @return Customweb_Form_Intention_Intention
	 */
	public static function getAccountNumberIntention(){
		if(self::$accountNumber === null){
			self::$accountNumber = new Customweb_Form_Intention_Intention('bank-account-number');
		}
		return self::$accountNumber;
	}
	
	/**
	 * This method returns the date of birth element intention.
	 *
	 * @return Customweb_Form_Intention_Intention
	 */
	public static function getDateOfBirthIntention(){
		if(self::$dateOfBirth === null){
			self::$dateOfBirth = new Customweb_Form_Intention_Intention('date-of-birth');
		}
		return self::$dateOfBirth;
	}
	
	/**
	 * This method returns the iban number element intention.
	 * 
	 * @return Customweb_Form_Intention_Intention
	 */
	public static function getIbanNumberIntention(){
		if(self::$ibanNumber === null) {
			self::$ibanNumber = new Customweb_Form_Intention_Intention('iban-number');
		}
		return self::$ibanNumber;
	}
	
	/**
	 * This method returns the bank location element intention.
	 *
	 * @return Customweb_Form_Intention_Intention
	 */
	public static function getBankLocationIntention(){
		if(self::$bankLocation === null) {
			self::$bankLocation = new Customweb_Form_Intention_Intention('bank-location');
		}
		return self::$bankLocation;
	}
	
	/**
	 * This method returns the bank name element intention.
	 *
	 * @return Customweb_Form_Intention_Intention
	 */
	public static function getBankNameIntention(){
		if(self::$bankName === null) {
			self::$bankName = new Customweb_Form_Intention_Intention('bank-name');
		}
		return self::$bankName;
	}
	
}