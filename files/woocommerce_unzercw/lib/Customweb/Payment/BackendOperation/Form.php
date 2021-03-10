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

require_once 'Customweb/Payment/BackendOperation/IForm.php';
require_once 'Customweb/Form.php';


/**
 * @author Thomas Hunziker
 * @Bean
 */
class Customweb_Payment_BackendOperation_Form extends Customweb_Form implements Customweb_Payment_BackendOperation_IForm {

	private $processable = true;
	
	public function __construct(Customweb_Payment_BackendOperation_IForm $form = null) {
		parent::__construct($form);
		if ($form !== null) {
			$this->setProcessable($form->isProcessable());
		}
	}
	
	public function isProcessable() {
		return $this->processable;
	}
	
	public function setProcessable($processable = true) {
		$this->processable = $processable;
		return $this;
	}
	
	
}