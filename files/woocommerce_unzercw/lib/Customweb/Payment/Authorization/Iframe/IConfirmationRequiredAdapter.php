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

require_once 'Customweb/Payment/Authorization/Iframe/IAdapter.php';



/**
 * This adapter should be implemented by any iframe authorization adapter which can automatically redirect the iframe.
 * Some shop systems may display the iframe before showing a confirmation button. In this case, the iframe must not be automatically submitted.
 * Any class implementing this interface should ensure that the page on the url returned by the method getConfirmationUrl requires user
 * interaction to proceed.
 *
 * Example:
 * Shop system shows alias manager on the same page as the iframe, without a confirmation button. The iframe automatically submits itself with the
 * preseleceted alias.
 * The customer has now never confirmed the payment, and was unable to select the alias.
 * Due to this, there should be user interaction required to confirm the payment in the given frame.
 *
 * @author sebastian
 *
 */
interface Customweb_Payment_Authorization_Iframe_IConfirmationRequiredAdapter extends Customweb_Payment_Authorization_Iframe_IAdapter {

	/**
	 * This method returns the URL to be set as the src for the Iframe.
	 *
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 */
	public function getIframeConfirmationUrl(Customweb_Payment_Authorization_ITransaction $transaction, array $formData);
}