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

require_once 'Customweb/Payment/BackendOperation/Form/IAdapter.php';
require_once 'Customweb/IForm.php';


/**
 * This class can be used as a mixing for the IAdapterFactory interface. The client 
 * which may use this form should not change form controll names when 
 * isProcessable() == false. Because in this case the form may be used to send
 * the user to a different site which required the fields exactly in this name.
 * 
 * @author Thomas Hunziker
 */
interface Customweb_Payment_BackendOperation_IForm extends Customweb_IForm {
	
	
	/**
	 * This method indicates that the form is processable by the client. 
	 * The client should ignore the getTargetUrl() URL and use instead a own
	 * URL to make sure that the form is processed with 
	 * Customweb_Payment_BackendOperation_Form_IAdapter::processForm().
	 * 
	 * @return boolean
	 */
	public function isProcessable();

}