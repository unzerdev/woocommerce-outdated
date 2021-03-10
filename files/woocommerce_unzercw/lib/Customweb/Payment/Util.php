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
require_once 'Customweb/Core/Util/Language.php';
require_once 'Customweb/Util/String.php';
require_once 'Customweb/Payment/Util.php';


/**
 * This util class some basic functions for Unzer.
 *
 * @author Thomas Hunziker
 *
 */
final class Customweb_Payment_Util {

	private function __construct(){
		// prevent any instantiation of this class	
	}

	/**
	 * This method extracts the expiry date (month, year) from a single string.
	 * 
	 *
	 * @param string $expriyDate
	 * @return array
	 */
	public static function extractExpiryDate($expriyDate){
		$month = null;
		$year = null;
		if (strlen($expriyDate) == 4) {
			$month = substr($expriyDate, 0, 2);
			$year = substr($expriyDate, 2, 2);
		}
		else if (strlen($expriyDate) == 6) {
			$month = substr($expriyDate, 0, 2);
			$year = substr($expriyDate, 2, 4);
		}
		
		return array(
			'month' => $month,
			'year' => $year 
		);
	}

	/**
	 * This method checks if two given amounts equals.
	 *
	 *
	 * @param double $amount1
	 * @param double $amount2
	 * @param int $decimalPlaces
	 * @return boolean
	 */
	public static function amountEqual($amount1, $amount2, $decimalPlaces = 2){
		$amount1String = number_format($amount1, $decimalPlaces);
		$amount2String = number_format($amount2, $decimalPlaces);
		
		if ($amount1String == $amount2String) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * This function is deprecated use Customweb_Payment_Util::applyOrderSchemaImproved($orderSchema, $transactionId, $maxLength) instead
	 * 
	 * @deprecated
	 *
	 * @param string $orderSchema
	 * @param string|int $transactionId
	 * @param int $maxLength
	 * @return string
	 */
	public static function applyOrderSchema($orderSchema, $transactionId, $maxLength){
		$id = (string) $transactionId;
		
		if (!empty($orderSchema)) {
			$totalLength = strlen($id) + strlen($orderSchema);
			
			// In case the {id} is present, we have to substract 4 chars, 
			// because they will be replaced later.
			if (stristr($orderSchema, '{id}')) {
				$totalLength = $totalLength - 4;
			}
			
			if ($totalLength > $maxLength) {
				$lengthToReduce = ($totalLength - $maxLength);
				$orderSchema = Customweb_Util_String::substrUtf8($orderSchema, min($lengthToReduce, strlen($orderSchema)), strlen($orderSchema));
			}
			
			if (strstr($orderSchema, '{id}')) {
				$id = str_replace('{id}', $id, $orderSchema);
			}
			else if (strstr($orderSchema, '{ID}')) {
				$id = str_replace('{ID}', $id, $orderSchema);
			}
			else {
				$id = $orderSchema . $id;
			}
		}
		return Customweb_Util_String::substrUtf8($id, 0, $maxLength);
	}

	/**
	 * This function replaces the {id} string in the $orderSchema with the $transactionId
	 * It also reduces the length to max length and ensures the $transactionId is always present in the
	 * resulting string
	 *
	 * @param string $orderSchema
	 * @param string | int $transactionId
	 * @param int $maxLength
	 * @return string
	 */
	public static function applyOrderSchemaImproved($orderSchema, $transactionId, $maxLength){
		$id = Customweb_Core_String::_($transactionId);
		$schema = Customweb_Core_String::_($orderSchema);
		if (!$schema->isEmpty()) {
			
			$totalLength = $id->getLength() + $schema->getLength();
			if ($totalLength > $maxLength) {
				$maxSchemaLength = $maxLength - $id->getLength();
				$reducedSchema = $schema->substring(0, $maxSchemaLength);
				if ($reducedSchema->contains('{id}') || $reducedSchema->contains('{ID}')) {
					//The recuded schema contains the id tag, so it will be replaced and the schema could acutally be 4 chars longer
					$schema = $schema->substring(0, $maxSchemaLength + 4);
				}
				else {
					$schema = $reducedSchema;
				}
			}
			if ($schema->contains('{id}')) {
				$id = $schema->replace('{id}', $id);
			}
			elseif ($schema->contains('{ID}')) {
				$id = $schema->replace('{ID}', $id);
			}
			else {
				$id = Customweb_Core_String::_($schema . $id);
			}
		}
		return $id->substring(0, $maxLength)->toString();
	}
	
	
	/**
	 * Replaces the tags in the string provided.
	 * The tags are the keys and the replacement values are the values in the array $tagValues
	 *  
	 * @param string $string The original string
	 * @param array $tagValues map of tag => replacement
	 * @return string the modified String
	 */
	public static function replaceTagsInString($string, array $tagValues) {
		$modified = Customweb_Core_String::_($string);
		foreach($tagValues as $tag => $value) {
			$modified = $modified->replace($tag, $value); 
		}
		return $modified->toString();
	} 

	/**
	 *
	 * @param string $lang
	 * @param string $supportedLanguages
	 * @deprecated Use instead Customweb_Core_Util_Language::getCleanLanguageCode()
	 */
	public static function getCleanLanguageCode($lang, $supportedLanguages){
		$lang = (string) $lang;
		return Customweb_Core_Util_Language::getCleanLanguageCode($lang, $supportedLanguages);
	}
}
	