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

require_once 'Customweb/Mvc/Controller/IAdapter.php';


/**
 * This interface defines the methods required to access configurations 
 * required to access the controllers.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_Endpoint_IAdapter extends Customweb_Mvc_Controller_IAdapter {
	
	/**
	 * Returns a renderer for form. 
	 * 
	 * @return Customweb_Form_IRenderer
	 */
	public function getFormRenderer();	
	
}