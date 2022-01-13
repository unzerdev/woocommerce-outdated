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

require_once 'Customweb/Form/Element.php';
require_once 'Customweb/Form/Validator/NotEmpty.php';
require_once 'Customweb/Core/Util/Xml.php';
require_once 'Customweb/Form/Intention/Factory.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Form/Control/Html.php';
require_once 'Customweb/Form/Control/Select.php';
require_once 'Customweb/Form/Control/TextInput.php';


/**
 * This class provides a simple interface to create the form elements for 
 * SEPA transactions. It provides a simple interface to create IBAN and 
 * BIC input fields. This method can be used for various payment methods:
 * - giropay
 * - direct debits
 * - iDEAL
 * 
 * SEPA:
 * The IBAN identifies the bank and the account of the bank. However until 2016 
 * the regulation requires to send also the BIC along to identify the bank. In theory
 * they are redundant information. However a direct checks between the two numbers
 * are not possible, because the structure of them are different (e.g. the country code
 * can be different.)
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_Authorization_Method_Sepa_ElementBuilder {
	
	/**
	 * @var string
	 */
	private $ibanFieldName = null;
	
	/**
	 * @var Customweb_Form_IElement
	 */
	private $ibanElement = null;
	
	/**
	 * @var string
	 */
	private $ibanErrorMessage = null;
	
	/**
	 * @var Customweb_Form_Control_IControl
	 */
	private $ibanControl = null;
	
	/**
	 * @var string
	 */
	private $bicFieldName = null;
	
	/**
	 * @var Customweb_Form_IElement
	 */
	private $bicElement = null;
	
	/**
	 * @var string
	 */
	private $bicErrorMessage = null;
	
	/**
	 * @var Customweb_Form_Control_IControl
	 */
	private $bicControl = null;

	/**
	 * @var bool
	 */
	private $bicRequired = true;

	/**
	 * @var array
	 */
	private $bicOptionList = null;
	
	/**
	 * @var string
	 */
	private $accountHolderFieldName = null;
	
	/**
	 * @var Customweb_Form_IElement
	 */
	private $accountHolderElement = null;
	
	/**
	 * @var string
	 */
	private $accountHolderName = null;
	
	/**
	 * @var Customweb_Form_Control_IControl
	 */
	private $accountHolderControl = null;
	
	/**
	 * @var string
	 */
	private $accountHolderErrorMessage = null;
	
	/**
	 * @var Customweb_Form_IElement
	 */
	private $mandateElement = null;

	/**
	 * @var Customweb_Form_Control_IControl
	 */
	private $mandateControl = null;
	
	/**
	 * @var string
	 */
	private $mandateId = null;
	
	/**
	 * @var DateTime
	 */
	private $mandateDate = null;
	
	/**
	 * @return Customweb_Form_IElement[]
	 */
	public function build() {

		// Setup Elements and Controls
		$this->buildAccountHolderElement();		
		$this->buildIbanElement();
		$this->buildBicElement();
		$this->buildMandateElement();
		
		$elements = $this->collectElements();
		
		if (count($elements) <= 0) {
			throw new Exception("At least on element must be added.");
		}
		
		return $elements;
	}
	
	protected function buildMandateElement() {
		if ($this->getMandateId() !== null) {
			$date = $this->getMandateDate();
			if ($date === null) {
				$date = new DateTime();
			}
			$mandateHtml = $this->getMandateId() . ' (' . Customweb_I18n_Translation::__('Date') . ': ' . $date->format('Y/m/d') . ')';
			$this->mandateControl = new Customweb_Form_Control_Html("mandate", $mandateHtml);
			$this->mandateElement = new Customweb_Form_Element(
					Customweb_I18n_Translation::__('SEPA Mandate ID'),
					$this->mandateControl
			);
		}
	}
	
	protected function buildAccountHolderElement() {

		if ($this->getAccountHolderFieldName() !== null) {
			$this->accountHolderControl = new Customweb_Form_Control_TextInput($this->getAccountHolderFieldName(), Customweb_Core_Util_Xml::escape($this->getAccountHolderName()));
			$this->accountHolderControl->addValidator(new Customweb_Form_Validator_NotEmpty($this->accountHolderControl, Customweb_I18n_Translation::__("You have to enter the account holder name.")));
			$this->accountHolderControl->setAutocomplete(false);
			
			$this->accountHolderElement = new Customweb_Form_Element(
					Customweb_I18n_Translation::__('Account Holder Name'),
					$this->accountHolderControl,
					Customweb_I18n_Translation::__('Please enter here the account holder name.')
			);
			$this->accountHolderElement->setElementIntention(Customweb_Form_Intention_Factory::getCardHolderNameIntention())
				->setErrorMessage($this->getAccountHolderErrorMessage());
		}
		
	}
	
	protected function buildIbanElement() {
		if ($this->getIbanFieldName() !== null) {
			$this->ibanControl = new Customweb_Form_Control_TextInput($this->getIbanFieldName());
			$this->ibanControl->addValidator(new Customweb_Form_Validator_NotEmpty($this->ibanControl, Customweb_I18n_Translation::__("You have to enter the IBAN.")));
			$this->ibanControl->setAutocomplete(false);
				
			$this->ibanElement = new Customweb_Form_Element(
					Customweb_I18n_Translation::__('IBAN'),
					$this->ibanControl,
					Customweb_I18n_Translation::__('Please enter here the International Bank Account Number (IBAN).')
			);
			$this->ibanElement->setElementIntention(Customweb_Form_Intention_Factory::getIbanNumberIntention())
				->setErrorMessage($this->getIbanErrorMessage());
		}
	}
	
	protected function buildBicElement() {
		if ($this->getBicFieldName() !== null) {
			
			if ($this->getBicOptionList() !== null) {
				$list = $this->getBicOptionList();
				asort($list);
				$this->bicControl = new Customweb_Form_Control_Select($this->getBicFieldName(), array_merge(
						array('none' => ' - ' . Customweb_I18n_Translation::__('Please select') . ' - '), $list));
				$description = Customweb_I18n_Translation::__('Please select the Bank Identifier Code (BIC) of your bank.');
			}
			else {
				$this->bicControl = new Customweb_Form_Control_TextInput($this->getBicFieldName());
				$description = Customweb_I18n_Translation::__('Please enter here the Bank Identifier Code (BIC).');
				$this->bicControl->setAutocomplete(false);
			}

			$this->bicControl->setRequired($this->bicRequired);
			if($this->bicRequired) {
				$this->bicControl->addValidator(new Customweb_Form_Validator_NotEmpty($this->bicControl, Customweb_I18n_Translation::__("You have to enter the BIC.")));
			}

			$this->bicElement = new Customweb_Form_Element(
				Customweb_I18n_Translation::__('BIC'),
				$this->bicControl,
				$description
			);
			$this->bicElement->setElementIntention(Customweb_Form_Intention_Factory::getBankCodeIntention())
				->setErrorMessage($this->getBicErrorMessage());
			$this->bicElement->setRequired($this->bicRequired);
		}
	}
	
	/**
	 * 
	 * @return multitype:NULL
	 */
	protected function collectElements() {
		$elements = array();

		if ($this->getAccountHolderElement() !== null) {
			$elements[] = $this->getAccountHolderElement();
		}

		if ($this->getMandateElement() !== null) {
			$elements[] = $this->getMandateElement();
		}

		if ($this->getIbanElement() !== null) {
			$elements[] = $this->getIbanElement();
		}

		if ($this->getBicElement() !== null) {
			$elements[] = $this->getBicElement();
		}
		
		return $elements;
	}

	/**
	 * Returns the field name for International Bank Account Number (IBAN) field.
	 * 
	 * @return string
	 */
	public function getIbanFieldName(){
		return $this->ibanFieldName;
	}

	/**
	 * Sets the field name for International Bank Account Number (IBAN) field. If the field name is set
	 * to null. No IBAN input field will be added.
	 * 
	 * @param string $ibanFieldName
	 * @return Customweb_Payment_Authorization_Method_Sepa_ElementBuilder
	 */
	public function setIbanFieldName($ibanFieldName){
		$this->ibanFieldName = $ibanFieldName;
		return $this;
	}

	/**
	 * Returns the field name of the Bank Identifier Code (BIC) field.
	 * 
	 * @return string
	 */
	public function getBicFieldName(){
		return $this->bicFieldName;
	}

	/**
	 * Sets the name of the Bank Identifier Code (BIC) field. If it is set to null,
	 * no BIC field is added.
	 * 
	 * @param string $bicFieldName
	 * @return Customweb_Payment_Authorization_Method_Sepa_ElementBuilder
	 */
	public function setBicFieldName($bicFieldName){
		$this->bicFieldName = $bicFieldName;
		return $this;
	}

	/**
	 * Returns the card holder field name.
	 * 
	 * @return string
	 */
	public function getAccountHolderFieldName(){
		return $this->accountHolderFieldName;
	}

	/**
	 * Sets the card holder field name. If the field name is set to null, no card holder 
	 * field will be added.
	 * 
	 * @param string $accountHolderFieldName
	 * @return Customweb_Payment_Authorization_Method_Sepa_ElementBuilder
	 */
	public function setAccountHolderFieldName($accountHolderFieldName){
		$this->accountHolderFieldName = $accountHolderFieldName;
		return $this;
	}
	
	/**
	 * Returns the default account holder name.
	 * 
	 * @return string
	 */
	public function getAccountHolderName(){
		return $this->accountHolderName;
	}
	
	/**
	 * Sets the default account holder name. By providing a default account holder
	 * the user may not re-enter his / her name. 
	 * 
	 * @param string $accountHolderName
	 * @return Customweb_Payment_Authorization_Method_Sepa_ElementBuilder
	 */
	public function setAccountHolderName($accountHolderName){
		$this->accountHolderName = $accountHolderName;
		return $this;
	}
	
	/**
	 * Returns the account holder error message.
	 * 
	 * @return string
	 */
	public function getAccountHolderErrorMessage(){
		return $this->accountHolderErrorMessage;
	}
	
	/**
	 * Sets the account holder error message. The message is shown as an error message
	 * on the card holder element.
	 * 
	 * @param string $accountHolderErrorMessage
	 * @return Customweb_Payment_Authorization_Method_Sepa_ElementBuilder
	 */
	public function setAccountHolderErrorMessage($accountHolderErrorMessage){
		$this->accountHolderErrorMessage = $accountHolderErrorMessage;
		return $this;
	}

	/**
	 * Returns the error message shown on the IBAN element.
	 * 
	 * @return string
	 */
	public function getIbanErrorMessage(){
		return $this->ibanErrorMessage;
	}
	
	/**
	 * Sets the IBAN element error.
	 * 
	 * @param string $ibanErrorMessage
	 * @return Customweb_Payment_Authorization_Method_Sepa_ElementBuilder
	 */
	public function setIbanErrorMessage($ibanErrorMessage){
		$this->ibanErrorMessage = $ibanErrorMessage;
		return $this;
	}
	
	/**
	 * Returns the error message shown on the BIC element.
	 * 
	 * @return string
	 */
	public function getBicErrorMessage(){
		return $this->bicErrorMessage;
	}
	
	/**
	 * Sets the BIC error message.
	 * 
	 * @param string $bicErrorMessage
	 * @return Customweb_Payment_Authorization_Method_Sepa_ElementBuilder
	 */
	public function setBicErrorMessage($bicErrorMessage){
		$this->bicErrorMessage = $bicErrorMessage;
		return $this;
	}
	
	/**
	 * Returns a list of BICs which should be shown to the customer.
	 * 
	 * @return array
	 */
	public function getBicOptionList(){
		return $this->bicOptionList;
	}
	
	/**
	 * This method allows to define a set of allowed BICs. The customer can then only
	 * select from this list. The list must be a key/value map. Where the key is 
	 * the value returned by the form and the value is the displayed name of the 
	 * BIC in the dropdown box. 
	 * 
	 * @param array $bicOptionList
	 * @return Customweb_Payment_Authorization_Method_Sepa_ElementBuilder
	 */
	public function setBicOptionList(array $bicOptionList){
		$this->bicOptionList = $bicOptionList;
		return $this;
	}
	
	/**
	 * According to the SEPA regulation the customer should see the generated mandate
	 * before he / she enters the IBAN / BIC.
	 * 
	 * The mandate ID is shown to the customer. This method returns the mandate ID.
	 * 
	 * @return string
	 */
	public function getMandateId(){
		return $this->mandateId;
	}
	
	/**
	 * According to the SEPA regulation the customer should see the generated mandate
	 * before he / she enters the IBAN / BIC.
	 * 
	 * The mandate ID is shown to the customer. This method sets the mandate id. If
	 * it is set to NULL, no mandate is shown to the customer.
	 * 
	 * @return string
	 */
	public function setMandateId($mandateId){
		$this->mandateId = $mandateId;
		return $this;
	}
	
	/**
	 * This method returns the SEPA mandate date.
	 * 
	 * @return DateTime
	 */
	public function getMandateDate(){
		return $this->mandateDate;
	}
	
	/**
	 * This sets the SEPA mandate date. If no date is given the current date is shown to 
	 * the customer.
	 * 
	 * @param DateTime $mandateDate
	 * @return Customweb_Payment_Authorization_Method_Sepa_ElementBuilder
	 */
	public function setMandateDate(DateTime $mandateDate){
		$this->mandateDate = $mandateDate;
		return $this;
	}
	
	

	/**
	 * @return Customweb_Form_IElement
	 */
	protected function getIbanElement(){
		return $this->ibanElement;
	}

	/**
	 * @param Customweb_Form_IElement $ibanElement
	 * @return Customweb_Payment_Authorization_Method_Sepa_ElementBuilder
	 */
	protected function setIbanElement(Customweb_Form_IElement $ibanElement){
		$this->ibanElement = $ibanElement;
		return $this;
	}

	/**
	 * @return Customweb_Form_IElement
	 */
	protected function getBicElement(){
		return $this->bicElement;
	}

	/**
	 * @param Customweb_Form_IElement $bicElement
	 * @return Customweb_Payment_Authorization_Method_Sepa_ElementBuilder
	 */
	protected function setBicElement(Customweb_Form_IElement $bicElement){
		$this->bicElement = $bicElement;
		return $this;
	}


	/**
	* Sets the requirement condition for Bank Identifier Code (BIC) field,
	* no BIC field is added.
	*
	* @param bool $isBicRequired
	* @return Customweb_Payment_Authorization_Method_Sepa_ElementBuilder
	*/
	public function setBicRequired($isBicRequired = true){
		$this->bicRequired = $isBicRequired;
		return $this;
	}

	/**
	 * @return Customweb_Form_IElement
	 */
	protected function getAccountHolderElement(){
		return $this->accountHolderElement;
	}

	/**
	 * @param Customweb_Form_IElement $accountHolderElement
	 * @return Customweb_Payment_Authorization_Method_Sepa_ElementBuilder
	 */
	protected function setAccountHolderElement(Customweb_Form_IElement $accountHolderElement){
		$this->accountHolderElement = $accountHolderElement;
		return $this;
	}

	/**
	 * @return Customweb_Form_Control_IControl
	 */
	protected function getAccountHolderControl(){
		return $this->accountHolderControl;
	}

	/**
	 * @param Customweb_Form_Control_IControl $accountHolderControl
	 * @return Customweb_Payment_Authorization_Method_Sepa_ElementBuilder
	 */
	protected function setAccountHolderControl(Customweb_Form_Control_IControl $accountHolderControl){
		$this->accountHolderControl = $accountHolderControl;
		return $this;
	}

	protected function getIbanControl(){
		return $this->ibanControl;
	}

	protected function setIbanControl(Customweb_Form_Control_IControl $ibanControl){
		$this->ibanControl = $ibanControl;
		return $this;
	}

	protected function getBicControl(){
		return $this->bicControl;
	}

	protected function setBicControl(Customweb_Form_Control_IControl $bicControl){
		$this->bicControl = $bicControl;
		return $this;
	}

	protected function getMandateElement(){
		return $this->mandateElement;
	}

	protected function setMandateElement(Customweb_Form_IElement $mandateElement){
		$this->mandateElement = $mandateElement;
		return $this;
	}

	protected function getMandateControl(){
		return $this->mandateControl;
	}

	protected function setMandateControl(Customweb_Form_Control_IControl $mandateControl){
		$this->mandateControl = $mandateControl;
		return $this;
	}
	

		
}