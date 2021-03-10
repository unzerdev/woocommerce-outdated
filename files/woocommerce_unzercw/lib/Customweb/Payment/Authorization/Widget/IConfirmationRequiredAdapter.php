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

require_once 'Customweb/Payment/Authorization/Widget/IAdapter.php';



/**
 * This adapter should be implemented by any widget authorization adapter in which the html generated can cause an automatic redirect.
 * Some shop systems may display the widget before showing a confirmation button. In this case, the widget must not be automatically submitted.
 * Any class implementing this interface should ensure that the HTML returned by the method getWidgetConfirmationHTML requires user
 * interaction to proceed.
 *
 * Example:
 * Shop system shows alias manager on the same page as the widget, without a confirmation button. The widget automatically submits itself with the
 * preseleceted alias.
 * The customer has now never confirmed the payment, and was unable to select the alias.
 * Due to this, there should be user interaction required to confirm the payment in the given widget html.
 *
 * @author sebastian
 */
interface Customweb_Payment_Authorization_Widget_IConfirmationRequiredAdapter extends Customweb_Payment_Authorization_Widget_IAdapter {

	/**
	 * This method returns the HTML shown to the customer.
	 *
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @param array $formData
	 * @return string HTML content which should be shown to the customer to complete the payment.
	 */
	public function getWidgetConfirmationHTML(Customweb_Payment_Authorization_ITransaction $transaction, array $formData);
}