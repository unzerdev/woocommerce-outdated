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

require_once 'Customweb/Form/Validator/IValidator.php';
require_once 'Customweb/I18n/Translation.php';


/**
 * Validator which checks required form fields are filled.
 *  
 * @author bossert
 */
class Customweb_Unzer_Form_B2BValidator implements Customweb_Form_Validator_IValidator {
	private $control;
	private $registerNumberControlId;

	public function __construct(Customweb_Form_Control_IControl $control, $registerNumberControlId){
		$this->control = $control;
		$this->registerNumberControlId = $registerNumberControlId;
	}

	public function getCallbackJs(){
		$error = Customweb_I18n_Translation::__("Please check your inputs to ensure all company required fields are present.")->toString();
		return "function(resultCallback, element) {
	var registerNumberField = document.getElementById('{$this->registerNumberControlId}');
	if(registerNumberField.value) {
		resultCallback(true);
		return;
	}
	var currentField = document.getElementById('{$this->control->getControlId()}');
	if(currentField.value) {
		resultCallback(true);
		return;
	}
	resultCallback(false, '$error');
}";
	}

	public function getControl(){
		return $this->control;
	}
}
