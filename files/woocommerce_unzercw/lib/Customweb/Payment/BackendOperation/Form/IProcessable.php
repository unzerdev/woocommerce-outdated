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
 * Indicates if the given form is processable and has a method 
 * process. If a form implements the interface it can be called 
 * automatically when the form is processed.
 * 
 * @author Thomas Hunziker
 */
interface Customweb_Payment_BackendOperation_Form_IProcessable {
	
	
	public function process(Customweb_Form_IButton $pressedButton, array $formData);

}