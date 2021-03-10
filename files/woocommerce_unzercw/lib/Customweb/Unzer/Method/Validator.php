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
require_once 'Customweb/Unzer/Util/Spinner.php';


/**
 * Validator which creates a resource (causes validation), and sets the result in a globally available result object (PaymentMethod->getJsPrefix() + Result)
 * 
 * @author bossert
 */
class Customweb_Unzer_Method_Validator implements Customweb_Form_Validator_IValidator {
	private $jsPrefix;
	private $control;

	public function __construct($jsPrefix, Customweb_Form_Control_IControl $control){
		$this->control = $control;
		$this->jsPrefix = $jsPrefix;
	}

	public function getCallbackJs(){
		$showOverlayScript = Customweb_Unzer_Util_Spinner::getLoadOverlayScript();
		$removeOverlayScript = Customweb_Unzer_Util_Spinner::getRemoveOverlayScript();
		
		return "function(resultCallback, element) {
	if(typeof document.{$this->jsPrefix}Error !== 'undefined') {
		resultCallback(false, document.{$this->jsPrefix}Error.message);
		return;
	}
	else if(typeof document.{$this->jsPrefix}Result == 'undefined') {
		$showOverlayScript
		document.{$this->jsPrefix}Instance.createResource().then(function(data) {
			document.{$this->jsPrefix}Result = data;
			resultCallback(true);
			$removeOverlayScript
		}).catch(function(error) {
			document.{$this->jsPrefix}Error = error;
			var msg = JSON.stringify(error);
			if(error.msg) {
				msg = error.msg;
			}
			if(error.message) {
				msg = error.message;
			}
			resultCallback(false, msg);
			$removeOverlayScript
		});
	} else {
		$removeOverlayScript
		resultCallback(true);
	}
}";
	}

	public function getControl(){
		return $this->control;
	}
}
