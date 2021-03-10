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
 * This adapter can be used to update a given alias or recurring transaction. 
 *
 * @author Thomas Hunziker
 * @Bean
 */
interface Customweb_Payment_Alias_IUpdateAdapter {

	/**
	 * This method checks whether the given transaction supports updates of aliases or not.
	 * 
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @return boolean True, when its possible to update the given alias.
	 */
	public function isUpdateSupported(Customweb_Payment_Authorization_ITransaction $transaction);
	
	/**
	 * This methdo returns a list of form elements which can be used to update the alias.
	 * 
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @return Customweb_Form_IElement[] List of form elements
	 */
	public function getFormElements(Customweb_Payment_Authorization_ITransaction $transaction);
	
	/**
	 * This method updates the given alias transaction with the given form data.
	 *
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @param array $formData
	 * @return void
	 * @throws Exception
	 */
	public function update(Customweb_Payment_Authorization_ITransaction $transaction, array $formData);
}
