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

require_once 'Customweb/Payment/BackendOperation/Form/AbstractAbout.php';



/**
 * @BackendForm(-100)
 */
class Customweb_Unzer_BackendOperation_Form_About extends Customweb_Payment_BackendOperation_Form_AbstractAbout {

	protected function getVersion(){
		return '1.0.93';
	}

	protected function getReleaseDate(){
		return 'Mon, 14 Mar 2022 14:31:34 +0100';
	}

	protected function getOrderNumber(){
		return '____orderIncrementId____';
	}
}