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

require_once 'Customweb/Payment/Authorization/ErrorMessage.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Payment/Exception/PaymentErrorException.php';


/**
 * Simple class which allows the interacting with BICs. 
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_Authorization_Method_Sepa_Bic {
	
	
	/**
	 * Checks if the given BIC is valid.
	 * 
	 * @param string $iban
	 * @throws Exception
	 * @return boolean
	 */
	public function validate($bic) {
		
		if (strlen($bic) < 8) {
			throw new Customweb_Payment_Exception_PaymentErrorException(
				new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__("The BIC is too short.")));
		}
		
		if (!preg_match('/^[a-z0-9]{4}[a-z]{2}[a-z0-9]{2}([a-z0-9]{3})?$/i', $bic)) {
			throw new Customweb_Payment_Exception_PaymentErrorException(
				new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__("The BIC has a invalid format.")));
		}
		
		return true;
	}
	
	/**
	 * Removes any obvious non valid char.
	 * 
	 * @param string $bic
	 * @return string
	 */
	public function sanitize($bic) {
		return strip_tags(str_replace(' ', '', $bic));
	}
	
	
}