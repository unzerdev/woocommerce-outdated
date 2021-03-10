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
 * This interface defines the option to build a form for the user 
 * in the backend which allows to execute arbitrary actions without
 * any transaction involved.
 * 
 * This can be used by the API to handle administrative operations or 
 * installation issues. 
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_BackendOperation_Form_IAdapter {
	
	/**
	 * This method returns a list of forms presented to the 
	 * user.
	 * 
	 * @return Customweb_Payment_BackendOperation_IForm[]
	 */
	public function getForms();
	
	/**
	 * This method is invoked when the form is processed. The implementor can 
	 * use this method to process the user input and may store some information
	 * or take some action.
	 * 
	 * @param Customweb_Payment_BackendOperation_IForm $form The form to process
	 * @param Customweb_Form_IButton $pressedButton The 
	 * @param array $formData
	 */
	public function processForm(Customweb_Payment_BackendOperation_IForm $form, Customweb_Form_IButton $pressedButton, array $formData);
	
}