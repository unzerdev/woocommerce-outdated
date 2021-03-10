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

require_once 'Customweb/Form/Validator/IValidator.php';

/**
 * This implements a default set of methods for providing a implementation 
 * for the Customweb_Form_Validator_IValidator interface.
 * 
 * The sub class has only to provide a JS expression which evaluates to true or 
 * false. If the expression evalutes to true the input is valid and no 
 * error message is presented to the user.
 * 
 * If the expression evalutes to false the user is preseneted with the error
 * message defined for this validator.
 * 
 * @see Customweb_Form_Validator_IValidator
 * 
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_Form_Validator_Abstract implements Customweb_Form_Validator_IValidator {
	
	private $control;
	private $errorMessage;
	
	/**
	 * 
	 * @param Customweb_Form_Control_IControl $control
	 * @param string $errorMessage The error message presented to the user, in case the input is not valid
	 */
	public function __construct(Customweb_Form_Control_IControl $control, $errorMessage) {
		$this->control = $control;
		$this->errorMessage = $errorMessage;
	}
	
	/**
	 * The control to which this validator is assigned to.
	 * 
	 * @return Customweb_Form_Control_IControl
	 */
	public function getControl() {
		return $this->control;
	}
	
	/**
	 * This method sets the control on which the validation is executed.
	 * 
	 * @param Customweb_Form_Control_IControl $control
	 * @return Customweb_Form_Validator_Abstract
	 */
	public function setControl(Customweb_Form_Control_IControl $control) {
		$this->control = $control;
		return $this;
	}
	
	/**
	 * The error message presented to the user in case the user input
	 * is not valid.
	 * 
	 * @return string
	 */
	public function getErrorMessage() {
		return $this->errorMessage;
	}
	
	/**
	 * Sets the error message.
	 * 
	 * @param string $errorMessage Error message
	 * @return Customweb_Form_Validator_Abstract
	 */
	public function setErrorMessage($errorMessage) {
		$this->errorMessage = $errorMessage;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_Validator_IValidator::getCallbackJs()
	 */
	public function getCallbackJs() {
		$js = 'function (resultCallback, element) {
				 if (!(' . 
			$this->getValidationCondition() . 
		')) { resultCallback(false, "' . str_replace('"', '\"', $this->getErrorMessage()) . 
		'"); }else{resultCallback(true)} };';
		return $js;
	}
	
	/**
	 * This JS expression validates the user input. If the expression evaluates
	 * to true the error messages is not displayed otherwise it is displayed.
	 * 
	 * @return string JS boolean expression
	 */
	abstract public function getValidationCondition();
	
}