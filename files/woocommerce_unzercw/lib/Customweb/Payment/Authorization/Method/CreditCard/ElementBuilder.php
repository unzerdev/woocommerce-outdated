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

require_once 'Customweb/Util/Rand.php';
require_once 'Customweb/Core/Util/Xml.php';
require_once 'Customweb/Form/Intention/Factory.php';
require_once 'Customweb/Form/Control/Html.php';
require_once 'Customweb/Payment/Authorization/Method/CreditCard/CreditCardValidator.php';
require_once 'Customweb/Payment/Authorization/Method/CreditCard/ElementBuilder.php';
require_once 'Customweb/Util/JavaScript.php';
require_once 'Customweb/Payment/Authorization/Method/CreditCard/CardHandler.php';
require_once 'Customweb/Form/Control/MultiControl.php';
require_once 'Customweb/Form/Element.php';
require_once 'Customweb/Form/Validator/NotEmpty.php';
require_once 'Customweb/Form/Control/HiddenInput.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Form/Control/Select.php';
require_once 'Customweb/Payment/Authorization/Method/CreditCard/CvcValidator.php';
require_once 'Customweb/Core/Util/Class.php';
require_once 'Customweb/Form/Control/TextInput.php';
require_once 'Customweb/Payment/Authorization/Method/CreditCard/CardInformation.php';


/**
 * This class allows to build a set of elements for collecting credit card information. It handels the following:
 * - Creation of fields for: credit card number, card holder name, CVC and expiry date.
 * - Validation of the above fields (card number, CVC etc.)
 * - Showing the card logos
 * - Selecting the card depending on user input
 *
 *
 *
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder {

	/**
	 * @var boolean
	 */
	private $autoBrandSelectionActive = true;

	/**
	 * @var boolean
	 */
	private $autoBrandLogoSelectionActive = true;

	/**
	 * @var string
	 */
	private $brandFieldName = null;

	/**
	 * @var boolean
	 */
	private $imageBrandSelectionActive = true;

	/**
	 * @var boolean
	 */
	private $brandSelectionActive = true;

	/**
	 * @var string
	 */
	private $selectedBrand = null;

	/**
	 * @var string
	 */
	private $cardNumberFieldName = 'card_number';

	/**
	 * @var string
	 */
	private $cardHolderFieldName = null;

	/**
	 * @var string
	 */
	private $cvcFieldName = null;

	/**
	 * @var string
	 */
	private $expiryMonthFieldName = 'expiry_month';

	/**
	 * @var string
	 */
	private $expiryYearFieldName = 'expiry_year';

	/**
	 * @var string
	 */
	private $expiryFieldName = null;

	/**
	 * @var string
	 */
	private $expiryFieldFormat = "mm/YY";

	/**
	 * @var int
	 */
	private $expiryYearNumberOfDigits = 4;

	/**
	 * @var int
	 */
	private $selectedExpiryMonth = null;

	/**
	 * @var int
	 */
	private $selectedExpiryYear = null;

	/**
	 * @var string
	 */
	private $cardHolderName = null;

	/**
	 * @var boolean
	 */
	private $enhanceWithJavaScript = true;

	/**
	 * @var Customweb_Payment_Authorization_Method_CreditCard_CardHandler
	 */
	private $cardHandler = null;

	/**
	 * @var boolean
	 */
	private $inactiveJavaScriptWarningOn = false;

	/**
	 * @var string
	 */
	private $maskedCreditCardNumber = null;

	/**
	 * @var string
	 */
	private $hiddenAliasFieldName = null;

	/**
	 * @var string
	 */
	private $hiddenAliasFieldValue = '';

	/**
	 * @var string
	 */
	private $expiryElementErrorMessage = null;

	/**
	 * @var string
	 */
	private $cvcElementErrorMessage = null;

	/**
	 * @var string
	 */
	private $cardHolderElementErrorMessage = null;

	/**
	 * @var string
	 */
	private $cardNumberElementErrorMessage = null;

	/**
	 * @var Customweb_Form_Element
	 */
	protected $cardNumberElement = null;

	/**
	 * @var Customweb_Form_Element
	 */
	protected $cardHolderElement = null;

	/**
	 * @var Customweb_Form_Element
	 */
	protected $expiryElement = null;

	/**
	 * @var Customweb_Form_Element
	 */
	protected $cvcElement = null;

	/**
	 * @var Customweb_Form_Control_Html
	 */
	protected $leadingHtmlControl = null;

	/**
	 * @var Customweb_Form_Control_TextInput
	 */
	protected $cardNumberControl = null;

	/**
	 * @var Customweb_Form_Control_TextInput
	 */
	protected $cardHolderControl = null;

	/**
	 * @var Customweb_Form_Control_Select
	 */
	protected $expiryMonthControl = null;

	/**
	 * @var Customweb_Form_Control_Select
	 */
	protected $expiryYearControl = null;

	/**
	 * @var Customweb_Form_Control_TextInput
	 */
	protected $expiryControl = null;

	/**
	 * @var Customweb_Form_Control_TextInput
	 */
	protected $cvcControl = null;

	/**
	 * @var Customweb_Form_Control_Select
	 */
	protected $brandDropDownControl = null;

	/**
	 * @var Customweb_Form_Control_Html
	 */
	protected $brandImageControl = null;

	/**
	 * @var Customweb_Form_Control_Html
	 */
	protected $hiddenBrandControl = null;

	/**
	 * @var string
	 */
	private $jqueryVariableName = null;

	/**
	 * @var string
	 */
	private $cardHandlerJavaScriptNameSpace = null;

	/**
	 * @var boolean
	 */
	private $fixedBrandActive = false;

	/**
	 * @var boolean
	 */
	private $fixedCardHolderActive = false;

	/**
	 * @var boolean
	 */
	private $fixedCardExpiryActive = false;

	/**
	 * @var boolean
	 */
	private $forceCvcOptional = false;

	/**
	 * @var string
	 */
	private $javaScript = '';

	/**
	 * @param Customweb_Payment_Authorization_Method_CreditCard_CardHandler $cardHandler
	 */
	public function __construct($cardHandler = null) {
		$this->cardHandler = $cardHandler;
	}

	/**
	 * Returns a list of all months including a 'none' option.
	 *
	 * @return array
	 */
	private static function getMonthArray() {
		return array(
			'none' => Customweb_I18n_Translation::__('Month'),
			'01' => '01', '02' => '02', '03' => '03', '04' => '04',
			'05' => '05', '06' => '06', '07' => '07', '08' => '08',
			'09' => '09', '10' => '10', '11' => '11', '12' => '12',
		);
	}

	/**
	 * This method generates depending on the settings the elements. In
	 * case the settings are changed, this method can be called again and the resulting
	 * elements are changed depending on the settings.
	 *
	 * @return Customweb_Form_IElement[]
	 */
	public function build() {

		// Setup Elements and Controls
		$this->buildCardHolderElement();
		$this->buildCardNumberElement();
		$this->buildExpiryElements();
		$this->buildCVCElement();

		$javaScript = $this->generateJavaScript();

		$elements = $this->collectElements();

		if (count($elements) <= 0) {
			throw new Exception("At least on element must be added.");
		}

		$lastElement = end($elements);

		$lastElement->setJavaScript($javaScript);

		return $elements;
	}

	/**
	 * This method collects the single elements created during the build process.
	 *
	 * @return Customweb_Form_IElement[]
	 */
	protected function collectElements() {
		$elements = array();

		if ($this->cardHolderElement !== null) {
			$elements[] = $this->cardHolderElement;
		}

		if ($this->cardNumberElement !== null) {
			$elements[] = $this->cardNumberElement;
		}

		if ($this->expiryElement !== null) {
			$elements[] = $this->expiryElement;
		}

		if ($this->cvcElement !== null) {
			$elements[] = $this->cvcElement;
		}

		return $elements;
	}

	/**
	 * This method generates the card holder element and controls.
	 *
	 * @return void
	 */
	protected function buildCardHolderElement() {

		if ($this->getCardHolderFieldName() !== null) {

			if ($this->isFixedCardHolderActive()) {
				$this->cardHolderControl = new Customweb_Form_Control_Html($this->getCardHolderFieldName(), Customweb_Core_Util_Xml::escape($this->getCardHolderName()));
			}
			else {
				$this->cardHolderControl = new Customweb_Form_Control_TextInput($this->getCardHolderFieldName(), Customweb_Core_Util_Xml::escape($this->getCardHolderName()));
				$this->cardHolderControl->addValidator(new Customweb_Form_Validator_NotEmpty($this->cardHolderControl, Customweb_I18n_Translation::__("You have to enter the card holder name on the card.")));
				$this->cardHolderControl->setAutocomplete(false);
			}

			$this->cardHolderElement = new Customweb_Form_Element(
				Customweb_I18n_Translation::__('Card Holder Name'),
				$this->cardHolderControl,
				Customweb_I18n_Translation::__('Please enter here the card holder name on the card.')
			);
			$this->cardHolderElement->setElementIntention(Customweb_Form_Intention_Factory::getCardHolderNameIntention())
			->setErrorMessage($this->getCardHolderElementErrorMessage());
		}
	}

	/**
	 * This method generates the card number elements and controls.
	 *
	 * @return void
	 */
	protected function buildCardNumberElement() {

		$this->createLeadingHtmlControl();
		$this->createCardNumberControl();
		$this->createBrandSelectionControl();

		// Combine the different controls into one control
		$controls = array();

		// TODO: Leading HTML: How to handle this? (in case no card number should be added?

		if ($this->brandDropDownControl !== null) {
			$controls[] = $this->brandDropDownControl;
		}

		$controls[] = $this->cardNumberControl;

		if ($this->brandImageControl !== null) {
			$controls[] = $this->brandImageControl;
		}

		$control = new Customweb_Form_Control_MultiControl("card_number_multi_control", $controls);

		$this->cardNumberElement = new Customweb_Form_Element(
			Customweb_I18n_Translation::__('Card Number'),
			$control,
			Customweb_I18n_Translation::__('Please enter here the number on your card.')
		);
		$this->cardNumberElement->setElementIntention(Customweb_Form_Intention_Factory::getCardNumberIntention())
		->setErrorMessage($this->getCardNumberElementErrorMessage());

	}

	/**
	 * Creates the leading HTML control
	 *
	 * @return void
	 */
	protected function createLeadingHtmlControl() {
		$html = '';
		if ($this->isInactiveJavaScriptWarningOn()) {
			$html .= '<noscript><div class="warning">' .
				Customweb_I18n_Translation::__('Your browser does not allow the execution of JavaScript. Please activate JavaScript in your browser and reload this page.') .
				'</div></noscript>';
			$this->leadingHtmlControl = new Customweb_Form_Control_Html("leading_html_control", $html);
		}

	}

	/**
	 * Creates the card number control
	 *
	 * @return void
	 */
	protected function createCardNumberControl() {
		if ($this->hasMaskedCreditCardNumber()) {
			$this->cardNumberControl = new Customweb_Form_Control_Html($this->getCardNumberFieldName(), $this->getMaskedCreditCardNumber());
		}
		else {
			$this->cardNumberControl = new Customweb_Form_Control_TextInput($this->getCardNumberFieldName());
			$this->cardNumberControl->addValidator(new Customweb_Form_Validator_NotEmpty($this->cardNumberControl, Customweb_I18n_Translation::__("You have to enter a card number.")));
			$this->cardNumberControl->setAutocomplete(false);

			$validator = new Customweb_Payment_Authorization_Method_CreditCard_CreditCardValidator(
				$this->cardNumberControl,
				Customweb_I18n_Translation::__("Please check the entered credit card number."),
				$this->getCardHandlerJavaScriptNameSpace()
			);
			$this->cardNumberControl->addValidator($validator);
		}
	}

	/**
	 * Creates the brand selection controls. Maybe multiple are created
	 * depending on the settings.
	 *
	 * @return void
	 */
	protected function createBrandSelectionControl() {
		if (($this->isBrandSelectionActive() || $this->isFixedBrandActive()) && ($this->getBrandFieldName() !== null || !$this->isImageBrandSelectionActive())) {
			$this->createBrandDropDownControl();
		}

		if ($this->isBrandSelectionActive() && $this->isImageBrandSelectionActive()) {
			$this->createImageBrandSelectionControl();
		}
	}

	/**
	 * Create a the brand dropdown control. This is only created,
	 * when a brand field name is given.
	 *
	 * @return void
	 */
	protected function createBrandDropDownControl() {
		if ($this->hasMaskedCreditCardNumber() || $this->isFixedBrandActive()) {
			$mappedBrand = $this->getCardHandler()->mapBrandNameToExternalName($this->getSelectedBrand());
			$this->brandDropDownControl = new Customweb_Form_Control_HiddenInput($this->getBrandFieldName(), $mappedBrand);
		}
		else {
			$fieldName = '';
			if ($this->getBrandFieldName() !== null) {
				$fieldName = $this->getBrandFieldName();
			}

			$options = array(
				'none' => Customweb_I18n_Translation::__('Select Brand')
			);

			foreach ($this->getCardHandler()->getCardInformationObjects() as $object) {
				/* @var $object Customweb_Payment_Authorization_Method_CreditCard_CardInformation */
				$mappedBrand = $this->getCardHandler()->mapBrandNameToExternalName($object->getBrandKey());
				$options[$mappedBrand] = $object->getBrandName();
			}

			$this->brandDropDownControl = new Customweb_Form_Control_Select($fieldName, $options, $this->getSelectedBrand());
		}
	}

	/**
	 * Creates a hidden data for the image brand selection. This is only visible
	 * when JS is active. (JavaScript makes it visible.)
	 *
	 * @return void
	 */
	protected function createImageBrandSelectionControl() {
		$this->brandImageControl = new Customweb_Form_Control_Html("image-selection", '');

		$html = '<div class="card-brand-image-selection" style="display:none;" id="' . $this->brandImageControl->getControlId() . '">';
		foreach ($this->getCardHandler()->getCardInformationObjects() as $object) {
			/* @var $object Customweb_Payment_Authorization_Method_CreditCard_CardInformation */
			$mappedBrand = $this->getCardHandler()->mapBrandNameToExternalName($object->getBrandKey());
			$html .= '<div class="card-brand-image-box card-brand-image-' . $object->getBrandKey() . '-box" data-brand="' . $object->getBrandKey() . '" data-mapped-brand="' . $mappedBrand . '"><img class="card-brand-image-color brand-is-selected" src="' . $object->getColorImageUrl() . '" alt="' . $object->getBrandName() . '" />';
			$html .= '<img class="card-brand-image-grey brand-is-selected" src="' . $object->getGreyImageUrl() . '" alt="' . $object->getBrandName() . '" /></div>';
		}
		$html .= '</div>';

		$this->brandImageControl->setContent($html);
	}

	/**
	 * Creates the CVC element and control.
	 *
	 * @return void
	 */
	protected function buildCVCElement() {
		if ($this->getCvcFieldName() !== null && $this->isCvcElementShown()) {
			$this->createCVCControl();

			$this->cvcElement = new Customweb_Form_Element(
				Customweb_I18n_Translation::__('CVC Code'),
				$this->cvcControl,
				Customweb_I18n_Translation::__('Please enter here the CVC code from your card. You find the code on the back of the card.')
			);

			$this->cvcElement
			->setRequired($this->isCvcElementRequired())
			->setElementIntention(Customweb_Form_Intention_Factory::getCvcIntention())
			->setErrorMessage($this->getCvcElementErrorMessage());
		}
	}

	/**
	 * Creates the CVC control and adds the basic not empty validator, if required.
	 *
	 * @return void
	 */
	protected function createCVCControl() {
		$this->cvcControl = new Customweb_Form_Control_TextInput($this->getCvcFieldName());
		$this->cvcControl->setAutocomplete(false);
		if ($this->isCvcElementRequired()) {
			$this->cvcControl->addValidator(new Customweb_Form_Validator_NotEmpty($this->cvcControl, Customweb_I18n_Translation::__("You have to enter the CVC code from your card.")));
		}

		$validator = new Customweb_Payment_Authorization_Method_CreditCard_CvcValidator(
			$this->cvcControl,
			Customweb_I18n_Translation::__("Please check the entered CVC number."),
			$this->getCardHandlerJavaScriptNameSpace()
		);
		$this->cvcControl->addValidator($validator);
	}

	/**
	 * This builds the expiry element including the
	 * year and month control.
	 *
	 * @return void
	 */
	protected function buildExpiryElements() {

		if ($this->isFixedCardExpiryActive()) {
			$expiryData = "<span class='fixed-expriy-month'>" . Customweb_Core_Util_Xml::escape($this->getSelectedExpiryMonth()) . '</span>';
			$expiryData .= "/<span class='fixed-expriy-year'>" . Customweb_Core_Util_Xml::escape($this->getSelectedExpiryYear()) . '</span>';

			$control = new Customweb_Form_Control_Html('expiry date', $expiryData);
			$this->expiryElement = new Customweb_Form_Element(
				Customweb_I18n_Translation::__('Card Expiration'),
				$control
			);
		}
		else if ($this->getExpiryFieldName() !== null) {
			$this->buildSingleExpiryElement();
		}
		else {
			$this->createExpiryMonthControl();
			$this->createExpiryYearControl();

			$control = new Customweb_Form_Control_MultiControl('expiration', array(
				$this->expiryMonthControl,
				$this->expiryYearControl,
			));
			$this->expiryElement = new Customweb_Form_Element(
				Customweb_I18n_Translation::__('Card Expiration'),
				$control,
				Customweb_I18n_Translation::__('Select the date on which your card expires.')
			);
			$this->expiryElement
				->setElementIntention(Customweb_Form_Intention_Factory::getExpirationDateIntention())
				->setErrorMessage($this->getExpiryElementErrorMessage());
		}
	}


	protected function buildSingleExpiryElement() {
		$this->createExpiryMonthControl();
		$this->createExpiryYearControl();

		$this->expiryMonthControl->setCssClass("hidden-control");
		$this->expiryYearControl->setCssClass("hidden-control");

		$month = $this->getSelectedExpiryMonth();
		$year = $this->getSelectedExpiryYear();

		$defaultValue = '';
		if ($month !== null && $year !== null) {
			$defaultValue = str_replace('YY', $year, $this->getExpiryFieldFormat());
			$defaultValue = str_replace('MM', $month, $defaultValue);
		}
		$this->expiryControl = new Customweb_Form_Control_TextInput($this->getExpiryFieldName(), $defaultValue);

		$control = new Customweb_Form_Control_MultiControl('expiration', array(
			$this->expiryControl,
			$this->expiryMonthControl,
			$this->expiryYearControl,
		));

		$this->expiryElement = new Customweb_Form_Element(
				Customweb_I18n_Translation::__('Card Expiration'),
				$control,
				Customweb_I18n_Translation::__('Enter the date on which your card expires.') .
				"<span class='card-expiry-format-note'>" .
					Customweb_I18n_Translation::__("The expected format is '!format' where the 'MM' means the month number and 'YY' the year number.",
						array('!format' => $this->getExpiryFieldFormat())) .
				"</span>"
		);
		$this->expiryElement
			->setElementIntention(Customweb_Form_Intention_Factory::getExpirationDateIntention())
			->setErrorMessage($this->getExpiryElementErrorMessage());

	}



	/**
	 * This method creats the expiry month control.
	 *
	 * @return void
	 */
	protected function createExpiryMonthControl() {
		$this->expiryMonthControl = new Customweb_Form_Control_Select($this->getExpiryMonthFieldName(), self::getMonthArray(), $this->getSelectedExpiryMonth());
		$this->expiryMonthControl->addValidator(new Customweb_Form_Validator_NotEmpty($this->expiryMonthControl, Customweb_I18n_Translation::__("Please select the expiry month on your card.")));
	}

	/**
	 * This method creates the expiry year control.
	 *
	 * @return void
	 */
	protected function createExpiryYearControl() {
		$defaultYear = $this->getSelectedExpiryYear();
		if (strlen($defaultYear) == 2 && $this->getExpiryYearNumberOfDigits() == 4) {
			// Add the leading year numbers in case it is only 2 chars long
			$defaultYear = '20' . $defaultYear;
		}

		$this->expiryYearControl = new Customweb_Form_Control_Select($this->getexpiryYearFieldName(), $this->getExpiryYearOptions(), $defaultYear);
		$this->expiryYearControl->addValidator(new Customweb_Form_Validator_NotEmpty($this->expiryYearControl, Customweb_I18n_Translation::__("Please select the expiry year on your card.")));
	}

	/**
	 * This methdo returns the options list for the select control for
	 * the year control.
	 *
	 * @return array
	 * @throws Exception
	 */
	protected function getExpiryYearOptions() {
		$years = array('none' => Customweb_I18n_Translation::__('Year'));
		$current = intval(date('Y'));
		for($i = 0; $i < 15; $i++) {
			if ($this->getExpiryYearNumberOfDigits() == 4) {
				$years[$current] = $current;
			}
			else if ($this->getExpiryYearNumberOfDigits() == 2) {
				$years[substr($current, 2, 2)] = $current;
			}
			else {
				throw new Exception("Invalid number of digits defined for the expiration element.");
			}
			$current++;
		}

		return $years;
	}

	/**
	 * This method generates all the JavaScript required to
	 * handle the user input as configured.
	 *
	 * Subclasses may override this method, but should call this method in first place.
	 * The additional JS can be added by invoking the method self::appendJavaScript().
	 *
	 * @return string
	 */
	protected function generateJavaScript() {
		$js = Customweb_Core_Util_Class::readResource('Customweb_Payment_Authorization_Method_CreditCard', 'CardHandler.js');

		$filteredData = array();
		foreach($this->getCardHandler()->getCardInformationObjects() as $object) {
			$key = strtolower($object->getBrandKey());
			$filteredData[$key] = array();
			$filteredData[$key]['validators'] = $object->getValidators();
			$filteredData[$key]['lengths'] = $object->getCardNumberLengths();
			if ($object->isCvvPresentOnCard()) {
				$filteredData[$key]['cvv_length'] = $object->getCvvLength();
				$filteredData[$key]['cvv_required'] = $object->isCvvRequired();
			}
		}

		$selectedBrand = $this->getSelectedBrand();
		if ($selectedBrand === null) {
			$selectedBrand = 'null';
		}

		$brandMapping = $this->getCardHandler()->getExternalBrandMap();
		if ($brandMapping === null) {
			$brandMapping = array();
		}

		$variables = array(
			'jQueryNameSpace' => $this->getJQueryVariableName(),
			'imageBrandControlId' => self::getControlId($this->brandImageControl),
			'brandDropDownControlId' => self::getControlId($this->brandDropDownControl),
			'creditCardControlId' => self::getControlId($this->cardNumberControl),
			'cvcControlId' => self::getControlId($this->cvcControl),
			'expiryMonthControlId' => self::getControlId($this->expiryMonthControl),
			'expiryYearControlId' => self::getControlId($this->expiryYearControl),
			'cardHandlerNameSpace' => $this->getCardHandlerJavaScriptNameSpace(),
			'brandMapping' => Customweb_Util_JavaScript::toJavaScript($brandMapping),
			'cardInformation' => Customweb_Util_JavaScript::toJavaScript($filteredData),
			'cardNumberPrefixMap' => Customweb_Util_JavaScript::toJavaScript($this->getCardHandler()->getCardNumberPrefixMap()),
			'imageBrandSelectionActive' => self::handleBoolean($this->isImageBrandSelectionActive()),
			'autoBrandSelectionActive' => self::handleBoolean($this->isAutoBrandSelectionActive()),
			'brandSelectionActive' => self::handleBoolean($this->isBrandSelectionActive()),
			'enhancedWithJavaScript' => $this->isEnhancedWithJavaScript(),
			'selectedBrand' => $selectedBrand,
			'forceCvcOptional' => self::handleBoolean($this->isForceCvcOptional()),
			'expiryFieldFormat' => $this->getExpiryFieldFormat(),
			'expiryControlId' => self::getControlId($this->expiryControl),
		);

		foreach ($variables as $variableName => $value) {
			$js = str_replace('____' . $variableName . '____', $value, $js);
		}

		$this->appendJavaScript($js . "\n");

		// Add jQuery
		$this->appendJavaScript(
			Customweb_Util_JavaScript::getLoadJQueryCode('1.10.2', $this->getJQueryVariableName(), 'function() { ' . $this->getCardHandlerJavaScriptNameSpace() . '.init(); }')
		);

		return $this->getJavaScript();
	}

	/**
	 * This method appends the given JavaScript to the output.
	 *
	 * @param string $js
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	protected final function appendJavaScript($js) {
		$this->javaScript .= $js;
		return $this;
	}

	protected final function getJavaScript() {
		return $this->javaScript;
	}

	/**
	 * This method converts a boolean value into a JS boolean.
	 *
	 * @param boolean $boolean
	 * @return string
	 */
	protected final static function handleBoolean($boolean) {
		if ($boolean) {
			return 'true';
		}
		else {
			return 'false';
		}
	}

	/**
	 * This method returns the control id or an empty string.
	 *
	 * @param Customweb_Form_Control_IControl $control
	 * @return string
	 */
	protected static function getControlId($control) {
		if ($control === null) {
			return '';
		}
		else {
			return $control->getControlId();
		}
	}

	/**
	 * The auto brand selection selects the brand for the card
	 * depending on the entered card number.
	 *
	 * @param boolean $active
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setAutoBrandSelectionActive($active = true) {
		$this->autoBrandLogoSelectionActive = $active;
		return $this;
	}

	/**
	 * True, when the brand is selected depending on the entered card number.
	 *
	 * @return boolean
	 */
	public function isAutoBrandSelectionActive() {
		// If a fixed brand is set, the auto selection is always inactive.
		if ($this->isFixedBrandActive()) {
			return false;
		}

		return $this->autoBrandLogoSelectionActive;
	}

	/**
	 * Sets the brand selection active. If this is set to false, the brand selection is
	 * removed independent on any other setting.
	 *
	 * @param boolean $active
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setBrandSelectionActive($active = true) {
		$this->brandSelectionActive = $active;
		return $this;
	}

	/**
	 * Returns true, when the brand selection is active or not.
	 *
	 * @return boolean
	 */
	public function isBrandSelectionActive() {
		// If a fixed brand is set, the brand selection is always inactive.
		if ($this->isFixedBrandActive()) {
			return false;
		}

		return $this->brandSelectionActive;
	}

	/**
	 * The brand field name can be either null or a string. In case a string is defined
	 * a field is added which holds the brand name. It is either a dropdown box or a hidden
	 * field. It is a hidden input field only when the image brand selection is active
	 * and the browser supports JavaScript.
	 *
	 * If the brand field is null, no value will be returned to the form target.
	 *
	 * @param string $name The field name.
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setBrandFieldName($name) {
		$this->brandFieldName = $name;
		return $this;
	}

	/**
	 * Returns the brand field name.
	 *
	 * @return string|null
	 */
	public function getBrandFieldName() {
		return $this->brandFieldName;
	}

	/**
	 * Sets the pre-selected brand name.
	 *
	 * @param string $brand
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setSelectedBrand($brand) {
		$this->selectedBrand = strtolower($brand);
		return $this;
	}

	/**
	 * Returns the pre-selected brand.
	 *
	 * @return string
	 */
	public function getSelectedBrand() {
		return $this->selectedBrand;
	}

	/**
	 * The brand of the credit card can be either selected over
	 * a dropdown or a list of images. In case the auto selection
	 * is active the corresponding images or dropdown entry is selected
	 * automatically. Otherwise the user can select the entries.
	 * In case no brand field is provided, but the image brand selection
	 * and the image brand selection is active. A list of images is shown
	 * and the user sees which card brand he / she enters.
	 *
	 * @param boolean $active
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setImageBrandSelectionActive($active = true) {
		$this->imageBrandSelectionActive = $active;
		return $this;
	}

	/**
	 * Returns if the brand selection is active or not.
	 *
	 * @return boolean
	 */
	public function isImageBrandSelectionActive() {
		return $this->imageBrandSelectionActive;
	}

	/**
	 * Sets the field name of the credit card field.
	 *
	 * @param string $name Field name
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setCardNumberFieldName($name) {
		$this->cardNumberFieldName = $name;
		return $this;
	}

	/**
	 * This method returns the credit card number field name.
	 *
	 * @return string
	 */
	public function getCardNumberFieldName() {
		return $this->cardNumberFieldName;
	}

	/**
	 * Sets the card holder field name. If this is set to null, then
	 * no field is shown.
	 *
	 * @param string $name Field name of the card holder.
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setCardHolderFieldName($name) {
		$this->cardHolderFieldName = $name;
		return $this;
	}

	/**
	 * Retruns the field name of the card holder field.
	 *
	 * @return string
	 */
	public function getCardHolderFieldName() {
		return $this->cardHolderFieldName;
	}

	/**
	 * Sets the Card Verification Code (CVC) field name.
	 *
	 * @param string $name CVC field name
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setCvcFieldName($name) {
		$this->cvcFieldName = $name;
		return $this;
	}

	/**
	 * Returns the CVC field name
	 *
	 * @return string field name
	 */
	public function getCvcFieldName() {
		return $this->cvcFieldName;
	}

	/**
	 * This method sets the field name of the month expiry dropdown.
	 *
	 * @param string $name Field name of month expiry dropdown.
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setExpiryMonthFieldName($name) {
		$this->expiryMonthFieldName = $name;
		return $this;
	}

	/**
	 * Returns the expiry month field name.
	 *
	 * @return string Expiry month field name.
	 */
	public function getExpiryMonthFieldName() {
		return $this->expiryMonthFieldName;
	}

	/**
	 * This method sets the expiry field name. In case this method is used instead of
	 * setExpiryYearFieldName() and setExpiryMonthFieldName() only one field with merged
	 * year and month is generated in the given format.
	 * In case the user has activate JavaScript the single field is replaced with two dropdowns.
	 * In case the user no JavaScript active a single field is shown with a indication of the format.
	 * However a check of the format is not possible.
	 *
	 * The format must contain 'YY' and 'MM'. Where 'YY' is replaced with the year value of the dropdown.
	 * The year may be either two digits or four digits long. This depends on the value set with
	 * setExpiryYearNumberOfDigits(). The 'MM' is replaced with the month number.
	 *
	 * @param string $fieldName
	 * @param string $format
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setExpiryField($fieldName, $format) {

		if (strstr($format, 'MM') === false) {
			throw new Exception("The format of the expiry field must contain the string 'MM'.");
		}
		if (strstr($format, 'YY') === false) {
			throw new Exception("The format of the expiry field must contain the string 'YY'.");
		}

		$this->expiryFieldName = $fieldName;
		$this->expiryFieldFormat = $format;
		return $this;
	}

	/**
	 * Returns the expiry field name. This method returns null in case two
	 * fields are used.
	 *
	 * @return string
	 */
	public function getExpiryFieldName() {
		return $this->expiryFieldName;
	}

	/**
	 * Returns the format used for the single expiry form field.
	 *
	 * @return string
	 */
	public function getExpiryFieldFormat() {
		return $this->expiryFieldFormat;
	}

	/**
	 * Sets the expiry year field name.
	 *
	 * @param string $name
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setExpiryYearFieldName($name) {
		$this->expiryYearFieldName = $name;
		return $this;
	}

	/**
	 * Returns the expiry field name.
	 *
	 * @return string
	 */
	public function getexpiryYearFieldName() {
		return $this->expiryYearFieldName;
	}

	/**
	 * Sets the expiry year number format. It can be either 2 digits orr 4 digits.
	 *
	 * @param int $digits
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setExpiryYearNumberOfDigits($digits) {
		$this->expiryYearNumberOfDigits = (int)$digits;
		return $this;
	}

	/**
	 * Returns the number of digits used for the expiry year field.
	 *
	 * @return int
	 */
	public function getExpiryYearNumberOfDigits() {
		return $this->expiryYearNumberOfDigits;
	}

	/**
	 * Sets the pre-selected month for the expiry date. The provided
	 * number must have 2 digits. If no one is selected, the 'none' option
	 * is selected.
	 *
	 * @param string $month
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setSelectedExpiryMonth($month) {
		$this->selectedExpiryMonth = $month;
		return $this;
	}

	/**
	 * Returns the pre-selected expriy month.
	 *
	 * @return string
	 */
	public function getSelectedExpiryMonth() {
		return $this->selectedExpiryMonth;
	}

	/**
	 * Sets the pre-selected year of the expiry year. The year number should
	 * either have 2 or 4 digits.
	 *
	 * @param string $year
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setSelectedExpiryYear($year) {
		$this->selectedExpiryYear = $year;
		return $this;
	}

	/**
	 * Returns the pre-selected expiry year.
	 *
	 * @return string
	 */
	public function getSelectedExpiryYear() {
		return $this->selectedExpiryYear;
	}

	/**
	 * Sets the pre filled card holder name.
	 *
	 * @param string $name
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setCardHolderName($name) {
		$this->cardHolderName = $name;
		return $this;
	}

	/**
	 * Returns the pre-filled card holder name.
	 *
	 * @return string
	 */
	public function getCardHolderName() {
		return $this->cardHolderName;
	}

	/**
	 * The credit card number field can be enhanced with a
	 * observer, which checks the card number directly, when the user
	 * enters it. Depending on the result a special CSS class is set
	 * on the credit card input field.
	 *
	 * By activating the enhancements with JavaScript these additional
	 * features are activating.
	 *
	 * @param boolean $enhance
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setEnhanceWithJavaScript($enhance = true) {
		$this->enhanceWithJavaScript = $enhance;
		return $this;
	}

	/**
	 * Returns true, when the input forms are enhanced with additional
	 * UI features to provide better feedback to the user.
	 *
	 * @return true
	 */
	public function isEnhancedWithJavaScript() {
		return $this->enhanceWithJavaScript;
	}

	/**
	 * In case the inactive JavaScript warning is on, then the a warning is shown
	 * to the user, that the payment will not work, if he / she does not activate
	 * JavaScript in the browser.
	 *
	 * @param boolean $on
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setInactiveJavaScriptWarningOn($on = true) {
		$this->inactiveJavaScriptWarningOn = $on;
		return $this;
	}

	/**
	 * Returns if a warning message is shown to the user, when the user has no
	 * JavaScript active in the browser.
	 *
	 * @return boolean
	 */
	public function isInactiveJavaScriptWarningOn() {
		return $this->inactiveJavaScriptWarningOn;
	}

	/**
	 * By setting a masked credit card number the credit card number field will be replaced
	 * with this masked card number. May be a hidden field with the alis information should
	 * be added in this case.
	 *
	 * This method does also activates the fixed brand, hence the customer cannot change the
	 * brand of the card.
	 *
	 * @param string $maskedCreditCardNumber
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setMaskedCreditCardNumber($maskedCreditCardNumber) {
		$this->maskedCreditCardNumber = $maskedCreditCardNumber;
		$this->setFixedBrand(true);
		return $this;
	}

	/**
	 * Return the masked credit card number.
	 *
	 * @return null | string
	 */
	public function getMaskedCreditCardNumber() {
		return $this->maskedCreditCardNumber;
	}

	/**
	 * Returns true, when a masked credit card is set.
	 *
	 * @return boolean
	 */
	public function hasMaskedCreditCardNumber() {
		$alias = $this->getMaskedCreditCardNumber();
		return !empty($alias);
	}

	/**
	 * This method sets the hidden alias field name and field value. This can be used
	 * to set an alias sent to the form target.
	 *
	 * @param string $fieldName The field name of the alias field.
	 * @param string $fieldValue The value of the hidden field.
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setHiddenAliasField($fieldName, $fieldValue) {
		$this->hiddenAliasFieldName = $fieldName;
		$this->hiddenAliasFieldValue = $fieldValue;
		return $this;
	}

	/**
	 * Returns the alias field name.
	 *
	 * @return string
	 */
	public function getHiddenAliasFieldName() {
		return $this->hiddenAliasFieldName;
	}

	/**
	 * Returns the alias field value.
	 *
	 * @return string
	 */
	public function getHiddenAliasFieldValue() {
		return $this->hiddenAliasFieldValue;
	}

	/**
	 * This set card expiry element error message. The error message is added
	 * to the corresponding element.
	 *
	 * @param string $message
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setExpiryElementErrorMessage($message) {
		$this->expiryElementErrorMessage = $message;
		return $this;
	}

	/**
	 * Returns the error message for the card expiry element.
	 *
	 * @return Customweb_I18n_LocalizableString
	 */
	public function getExpiryElementErrorMessage() {
		return $this->expiryElementErrorMessage;
	}

	/**
	 * This method sets the CVC element error message.
	 *
	 * @param Customweb_I18n_LocalizableString $message
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setCvcElementErrorMessage($message) {
		$this->cvcElementErrorMessage = $message;
		return $this;
	}

	/**
	 * Returns the error message displayed on the CVC element.
	 *
	 * @return Customweb_I18n_LocalizableString
	 */
	public function getCvcElementErrorMessage() {
		return $this->cvcElementErrorMessage;
	}

	/**
	 * Sets the card holder name element error message.
	 *
	 * @param Customweb_I18n_LocalizableString $message
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setCardHolderElementErrorMessage($message) {
		$this->cardHolderElementErrorMessage = $message;
		return $this;
	}

	/**
	 * Returns the card holder name element error message.
	 *
	 * @return Customweb_I18n_LocalizableString
	 */
	public function getCardHolderElementErrorMessage() {
		return $this->cardHolderElementErrorMessage;
	}

	/**
	 * This method sets the card number error message on the element.
	 *
	 * @param Customweb_I18n_LocalizableString $message
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setCardNumberElementErrorMessage($message) {
		$this->cardNumberElementErrorMessage = $message;
		return $this;
	}

	/**
	 * This method returns the card number element error message.
	 *
	 * @return Customweb_I18n_LocalizableString
	 */
	public function getCardNumberElementErrorMessage() {
		return $this->cardNumberElementErrorMessage;
	}

	/**
	 * When the brand is fixed, then only the selected brand can be used.
	 *
	 * @param boolean $fixed
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setFixedBrand($fixed = true) {
		$this->fixedBrandActive = $fixed;
		return $this;
	}

	/**
	 * Returns true, when the fixed brand is active.
	 *
	 * @see Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder::setFixedBrand()
	 * @return boolean
	 */
	public function isFixedBrandActive() {
		return $this->fixedBrandActive;
	}

	/**
	 * By forcing the CVC to be optional no CVC must be given to pass the validation.
	 *
	 * @param boolean $optional
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setForceCvcOptional($optional = true) {
		$this->forceCvcOptional = $optional;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isForceCvcOptional() {
		return $this->forceCvcOptional;
	}

	/**
	 * @return Customweb_Payment_Authorization_Method_CreditCard_CardHandler
	 */
	public function getCardHandler() {
		return $this->cardHandler;
	}


	/**
	 * This method sets the card handler by the given brand information and by a list of accepted brands.
	 *
	 * @param array $brandInformationMap
	 * @param array|string $acceptedBrands A list of brands or a single brand name.
	 * @param string $parameterKeyForMappedBrand The key name for the parameter to map the brands to.
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setCardHandlerByBrandInformationMap($brandInformationMap, $acceptedBrands = null, $parameterKeyForMappedBrand = null) {
		$informationMap = Customweb_Payment_Authorization_Method_CreditCard_CardInformation::getCardInformationObjects($brandInformationMap, $acceptedBrands, $parameterKeyForMappedBrand);
		$this->cardHandler = new Customweb_Payment_Authorization_Method_CreditCard_CardHandler($informationMap);
		return $this;
	}

	/**
	 * Sets the card handler for this builder.
	 *
	 * @param Customweb_Payment_Authorization_Method_CreditCard_CardHandler $handler
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setCardHandler(Customweb_Payment_Authorization_Method_CreditCard_CardHandler $handler) {
		$this->cardHandler = $handler;
		return $this;
	}

	/**
	 * Sets whether the card holder fields should be fixed and not changable by the customer.
	 *
	 * @param boolean $active
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setFixedCardHolderActive($active = true) {
		$this->fixedCardHolderActive = $active;
		return $this;
	}

	/**
	 * Returns true, when the card holder fields is fixed.
	 *
	 * @return boolean
	 */
	public function isFixedCardHolderActive() {
		return $this->fixedCardHolderActive;
	}

	/**
	 * Sets whether the card expiry is changable by the customer or not.
	 *
	 * @param boolean $active
	 * @return Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder
	 */
	public function setFixedCardExpiryActive($active = true) {
		$this->fixedCardExpiryActive = $active;
		return $this;
	}

	/**
	 * Returns true, when the expiry date of the card is not changable by
	 * the customer.
	 *
	 * @return boolean
	 */
	public function isFixedCardExpiryActive() {
		return $this->fixedCardExpiryActive;
	}

	/**
	 * Returns true, when any accepted card may have a CVC.
	 *
	 * @return boolean
	 */
	protected function isCvcElementShown() {
		return $this->getCardHandler()->isCvcPresentOnAnyBrand();
	}

	/**
	 * Returns true, when the CVC is a required input.
	 *
	 * @return boolean
	 */
	protected function isCvcElementRequired() {
		if ($this->isForceCvcOptional()) {
			return false;
		}
		return $this->getCardHandler()->isCvcRequiredForAnyBrand();

	}

	protected function getJQueryVariableName() {

		if ($this->jqueryVariableName === null ){
			$this->jqueryVariableName = 'j' . Customweb_Util_Rand::getRandomString(30);
		}

		return $this->jqueryVariableName;
	}

	protected function getCardHandlerJavaScriptNameSpace() {
		if ($this->cardHandlerJavaScriptNameSpace === null ){
			$this->cardHandlerJavaScriptNameSpace = 'c' . Customweb_Util_Rand::getRandomString(30);
		}

		return $this->cardHandlerJavaScriptNameSpace;
	}



}
