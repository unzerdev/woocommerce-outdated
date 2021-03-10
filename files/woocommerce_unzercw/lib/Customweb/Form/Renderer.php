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
require_once 'Customweb/Form/Control/IEditableControl.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Form/IButton.php';
require_once 'Customweb/Form/IRenderer.php';


/**
 * This class is a default implementation of the Customweb_Form_IRenderer interface.
 * It provides options to configure the behaviour at a certain degree. If more
 * should be changed this class should be subclassed.
 *
 * @see Customweb_Form_IRenderer
 *
 * @author Thomas Hunziker
 */
class Customweb_Form_Renderer implements Customweb_Form_IRenderer
{
	const FORM_TOKEN_FIELD_NAME = 'form_security_token_field';

	/**
	 * @var string
	 */
	private $cssClassPrefix = '';

	/**
	 * @var string
	 */
	private $formClass = '';

	/**
	 * @var string
	 */
	private $elementGroupClass = '';

	/**
	 * @var string
	 */
	private $elementGroupTitleClass = '';

	/**
	 * @var string
	 */
	private $elementClass = 'control-group';

	/**
	 * @var string
	 */
	private $elementLabelClass = 'control-label';

	/**
	 * @var string
	 */
	private $elementDescriptionClass = 'help-block';

	/**
	 * @var string
	 */
	private $elementErrorClass = 'element-error';

	/**
	 * @var string
	 */
	private $elementScopeClass = 'element-scope';

	/**
	 * @var string
	 */
	private $buttonClass = 'btn';

	/**
	 * @var string
	 */
	private $controlClass = 'controls';

	/**
	 * @var string
	 */
	private $optionClass = 'option';

	/**
	 * @var string
	 */
	private $errorMessageClass = 'error';

	/**
	 * @var boolean
	 */
	private $addJs = true;

	/**
	 * @var Customweb_Form_IControlCssClassResolver
	 */
	private $controlCssClassResolver = NULL;

	/**
	 * @var string
	 */
	private $namespacePrefix = NULL;

	/**
	 * @var boolean
	 */
	private $renderOnLoadJs = true;

	public function getCssClassPrefix()
	{
		return $this->cssClassPrefix;
	}

	/**
	 * @param string $prefix
	 * @return Customweb_Form_Renderer
	 */
	public function setCssClassPrefix($prefix)
	{
		$this->cssClassPrefix = $prefix;
		return $this;
	}

	public function getFormCssClass()
	{
		return $this->formClass;
	}

	/**
	 * @param string $class
	 * @return Customweb_Form_Renderer
	 */
	public function setFormCssClass($class)
	{
		$this->formClass = $class;
		return $this;
	}

	public function getElementGroupCssClass()
	{
		return $this->elementGroupClass;
	}

	/**
	 * @param string $class
	 * @return Customweb_Form_Renderer
	 */
	public function setElementGroupCssClass($class)
	{
		$this->elementGroupClass = $class;
		return $this;
	}

	public function getElementGroupTitleCssClass()
	{
		return $this->elementGroupTitleClass;
	}

	/**
	 * @param string $class
	 * @return Customweb_Form_Renderer
	 */
	public function setElementGroupTitleCssClass($class)
	{
		$this->elementGroupTitleClass = $class;
		return $this;
	}

	public function getElementCssClass()
	{
		return $this->elementClass;
	}

	/**
	 * @param string $class
	 * @return Customweb_Form_Renderer
	 */
	public function setElementCssClass($class)
	{
		$this->elementClass = $class;
		return $this;
	}

	public function getElementLabelCssClass()
	{
		return $this->elementLabelClass;
	}

	/**
	 * @param string $class
	 * @return Customweb_Form_Renderer
	 */
	public function setElementLabelCssClass($class)
	{
		$this->elementLabelClass = $class;
		return $this;
	}

	public function getDescriptionCssClass()
	{
		return $this->elementDescriptionClass;
	}

	/**
	 * @param string $class
	 * @return Customweb_Form_Renderer
	 */
	public function setDescriptionCssClass($class)
	{
		$this->elementDescriptionClass = $class;
		return $this;
	}

	public function getElementErrorCssClass()
	{
		return $this->elementErrorClass;
	}

	/**
	 * @param string $class
	 * @return Customweb_Form_Renderer
	 */
	public function setElementErrorCssClass($class)
	{
		$this->elementErrorClass = $class;
		return $this;
	}

	public function getElementScopeCssClass()
	{
		return $this->elementScopeClass;
	}

	/**
	 * @param string $class
	 * @return Customweb_Form_Renderer
	 */
	public function setElementScopeCssClass($class)
	{
		$this->elementScopeClass = $class;
		return $this;
	}

	public function getButtonClass()
	{
		return $this->buttonClass;
	}

	/**
	 * @param string $class
	 * @return Customweb_Form_Renderer
	 */
	public function setButtonClass($class)
	{
		$this->buttonClass = $class;
		return $this;
	}

	public function getControlCssClass()
	{
		return $this->controlClass;
	}

	/**
	 * @param string $class
	 * @return Customweb_Form_Renderer
	 */
	public function setControlCssClass($class)
	{
		$this->controlClass = $class;
		return $this;
	}

	public function getOptionCssClass()
	{
		return $this->optionClass;
	}

	/**
	 * @param string $class
	 * @return Customweb_Form_Renderer
	 */
	public function setOptionCssClass($class)
	{
		$this->optionClass = $class;
		return $this;
	}

	public function getErrorMessageCssClass()
	{
		return $this->errorMessageClass;
	}

	/**
	 * @param string $class
	 * @return Customweb_Form_Renderer
	 */
	public function setErrorMessageCssClass($class)
	{
		$this->errorMessageClass = $class;
		return $this;
	}

	public function isAddJs()
	{
		return $this->addJs;
	}

	/**
	 * @param boolean $addJs
	 * @return Customweb_Form_Renderer
	 */
	public function setAddJs($addJs)
	{
		$this->addJs = (boolean) $addJs;
		return $this;
	}

	/**
	 * @return Customweb_Form_IControlCssClassResolver
	 */
	public function getControlCssClassResolver()
	{
		return $this->controlCssClassResolver;
	}

	/**
	 * @param Customweb_Form_IControlCssClassResolver $resolver
	 * @return Customweb_Form_Renderer
	 */
	public function setControlCssClassResolver(Customweb_Form_IControlCssClassResolver $resolver)
	{
		$this->controlCssClassResolver = $resolver;
		return $this;
	}

	public function getNamespacePrefix()
	{
		return $this->namespacePrefix;
	}

	/**
	 * @param string $prefix
	 * @throws Exception
	 * @return Customweb_Form_Renderer
	 */
	public function setNamespacePrefix($prefix)
	{
		$prefix = strip_tags($prefix);
		if (preg_match('/[^0-9a-zA-Z_]+/', $prefix)) {
			throw new Exception("The namespace prefix ('$prefix') can only contains A-Z, a-z, 0-9 and underscore (_) chars.");
		}
		$this->namespacePrefix = $prefix;
		return $this;
	}

	/**
	 * Should the onLoad Javascript code be rendered?.
	 * The default is
	 * true, which means that the validator callbacks are registered. Depending
	 * on the context the form renderer is used, this might not be the desired behavior.
	 * In those cases child classes migth override this method to return false.
	 */
	protected function isRenderOnLoadJs()
	{
		return $this->renderOnLoadJs;
	}

	/**

	 * @param boolean $load
	 * @return Customweb_Form_Renderer
	 */
	public function setRenderOnLoadJs($load)
	{
		$this->renderOnLoadJs = (boolean) $load;
		return $this;
	}



	public function renderForm(Customweb_IForm $form)
	{
		$output = '<form class="' . $this->getFormCssClass() . '" action="' . $form->getTargetUrl() . '" method="' . $form->getRequestMethod() . '"
				target="' . $form->getTargetWindow() . '" id="' . $form->getId() . '" name="' . $form->getMachineName() . '">';

		$output .= $this->renderElementGroups($form->getElementGroups());

		$token = $this->getFormToken($form);
		if ($token !== null) {
			$output .= '<input type="hidden" name="' . self::FORM_TOKEN_FIELD_NAME . '" value="' . $token . '" />';
		}

		$output .= $this->renderButtons($form->getButtons());
		$output .= '</form>';

		if ($this->isAddJs()) {
			$output .= '<script type="text/javascript">' . "\n";
			$output .= $this->renderElementsJavaScript($form->getElements());
			$output .= "\n</script>";
		}
		return $output;
	}

	public function renderElementGroups(array $elementGroups)
	{
		$result = '';
		foreach ($elementGroups as $elementGroup) {
			$result .= $elementGroup->render($this);
		}
		return $result;
	}

	public function renderElementGroupPrefix(Customweb_Form_IElementGroup $elementGroup)
	{
		return '<fieldset>';
	}

	public function renderElementGroupPostfix(Customweb_Form_IElementGroup $elementGroup)
	{
		return '</fieldset>';
	}

	public function renderElementGroupTitle(Customweb_Form_IElementGroup $elementGroup)
	{
		$output = '';
		$title = $elementGroup->getTitle();
		if (! empty($title)) {
			$cssClass = $this->getCssClassPrefix() . $this->getElementGroupTitleCssClass();
			$output .= '<legend class="' . $cssClass . '">' . $title . '</legend>';
		}
		return $output;
	}

	public function renderElements(array $elements, $jsFunctionPrefix = '')
	{
		$result = $this->renderRawElements($elements);

		if ($this->isAddJs()) {
			$result .= '<script type="text/javascript">' . "\n";
			$result .= $this->renderElementsJavaScript($elements, $jsFunctionPrefix);
			$result .= "\n</script>";
		}

		return $result;
	}

	public function renderElementsWithoutJavaScript(array $elements)
	{
		return $this->renderRawElements($elements);
	}

	public function renderRawElements(array $elements)
	{
		$result = '';
		foreach ($elements as $element) {
			if ($this->getNamespacePrefix() !== NULL) {
				$element->applyNamespacePrefix($this->getNamespacePrefix());
			}

			if ($this->getControlCssClassResolver() !== NULL) {
				$element->applyControlCssResolver($this->getControlCssClassResolver());
			}
			$result .= $element->render($this);
		}
		return $result;
	}

	public function renderElementsJavaScript(array $elements, $jsFunctionPostfix = '')
	{
		$js = '';

		foreach ($elements as $element) {
			$js .= $element->getJavaScript() . "\n";
		}

		$js .= "\n";
		$js .= $this->renderValidatorCallbacks($elements, $jsFunctionPostfix);
		$js .= $this->renderScopeInitialize($elements, $jsFunctionPostfix);
		$js .= $this->renderScopeToggleElements();
		$js .= $this->renderOnLoadJs(array('cwRegisterValidatorCallbacks', 'scopeInitialize'), $jsFunctionPostfix);

		return $js;
	}

	/**
	 * @param Customweb_Form_IElement[] $elements
	 * @param string  [a-zA-Z_] javascript function prefix
	 * @return string
	 */
	protected function renderValidatorCallbacks(array $elements, $jsFunctionPostfix)
	{
		$js = $this->renderStopEventJavaScript() . "\n" . $this->renderGetFormElementJavaScript() . "\n" . $this->renderAddValidatorJavaScript() . "\n";


		$postfix = $jsFunctionPostfix;
		if ($this->getNamespacePrefix() !== NULL) {
			$postfix = $this->getNamespacePrefix(). $postfix;
		}

		$js .= 'var cwValidationRequired'.$postfix.' = true;';

		$js.= 'var cwFormValidation'.$postfix.' = {
				validators: [],
				position: 0,
				successCallback: "",
				failedCallback: "",
				errors: {},
				valid: []
			};';

		$js .= 'cwClearValidatorObject'.$postfix.' = function() {
				cwFormValidation'.$postfix.'.validators = [];
				cwFormValidation'.$postfix.'.position = 0;
				cwFormValidation'.$postfix.'.successCallback = "";
				cwFormValidation'.$postfix.'.failedCallback = "";
				cwFormValidation'.$postfix.'.errors = {};
				cwFormValidation'.$postfix.'.valid = [];
			};';

		$js .= 'cwRegisterValidator'.$postfix.' = function(id, validatorFunction) {
				var validatorPair = {};
				validatorPair["id"] = id;
				validatorPair["function"] = validatorFunction;
				cwFormValidation'.$postfix.'.validators.push(validatorPair);
			};';

		$js .= 'cwCallGlobalSuccess'.$postfix.' = function(valid){
				if (typeof window.cwGlobalSuccessCallback == "function") {
				  	  window.cwGlobalSuccessCallback (valid);
					} else if (typeof window.cwGlobalSuccessCallback != "undefined"
							&& window.cwGlobalSuccessCallback.constructor === Array) {
	        			    	window.cwGlobalSuccessCallback.forEach(function(cwGlobalSuccess) {
	        					if (typeof cwGlobalSuccess == "function") {
	        					    cwGlobalSuccess(valid);
	        					}
	        				});
					}

			};';

		$js .= 'cwCallGlobalFailure'.$postfix.' = function(errors, valid){
				if (typeof window.cwGlobalFailureCallback == "function") {
				  	  window.cwGlobalFailureCallback (errors, valid);
					} else if (typeof window.cwGlobalFailureCallback != "undefined"
							&& window.cwGlobalFailureCallback.constructor === Array) {
	        			    	window.cwGlobalFailureCallback.forEach(function(cwGlobalFailure) {
	        					if (typeof cwGlobalFailure == "function") {
	        					    cwGlobalFailure(errors, valid);
	        					}
	        				});
					}

			};';

		$js .= 'cwValidateFields'.$postfix.' = function(successCallback, failedCallback) {
				if(!cwValidationRequired'.$postfix.'){
					cwCallGlobalSuccess'.$postfix.'([]);
					successCallback([]);
					return;
				}


				cwClearValidatorObject'.$postfix.'();
				cwRegisterAllValidators'.$postfix.'();
				cwFormValidation'.$postfix.'.successCallback = successCallback;
				cwFormValidation'.$postfix.'.failedCallback = failedCallback;

				if(cwFormValidation'.$postfix.'.position < cwFormValidation'.$postfix.'.validators.length){
					var validator = cwFormValidation'.$postfix.'.validators[cwFormValidation'.$postfix.'.position]["function"];
					validator(cwCheckResultAndCallNextValidator'.$postfix.');
				}
				else{
					cwCallGlobalSuccess'.$postfix.'([]);
					cwFormValidation'.$postfix.'.successCallback([]);
				}
			};';



		$js .= 'cwCheckResultAndCallNextValidator'.$postfix.' = function (result, msg){
				var elementId = cwFormValidation'.$postfix.'.validators[cwFormValidation'.$postfix.'.position]["id"];
				if(!result) {
					cwFormValidation'.$postfix.'.errors[elementId] = msg;

				}
				else {
					cwFormValidation'.$postfix.'.valid.push(elementId);
				}
				cwFormValidation'.$postfix.'.position++;
				if(cwFormValidation'.$postfix.'.position < cwFormValidation'.$postfix.'.validators.length){
					var validator = cwFormValidation'.$postfix.'.validators[cwFormValidation'.$postfix.'.position]["function"];
					validator(cwCheckResultAndCallNextValidator'.$postfix.');
				}
				else {
					if(Object.keys(cwFormValidation'.$postfix.'.errors).length <= 0) {
						cwCallGlobalSuccess'.$postfix.'(cwFormValidation'.$postfix.'.valid);
						cwFormValidation'.$postfix.'.successCallback(cwFormValidation'.$postfix.'.valid);
					}
					else {
						cwCallGlobalFailure'.$postfix.'(cwFormValidation'.$postfix.'.errors, cwFormValidation'.$postfix.'.valid);
						cwFormValidation'.$postfix.'.failedCallback(cwFormValidation'.$postfix.'.errors, cwFormValidation'.$postfix.'.valid);
					}

				}
			};';

		$validatorAdded = false;
		$js .= 'cwRegisterAllValidators'.$postfix.' = function () {';

		foreach ($elements as $element) {
			foreach ($element->getValidators() as $validator) {
				$id = $validator->getControl()->getControlId();
				$js .= 'cwRegisterValidator'.$postfix.'("'. $id .'", function (resultCallback) {

					var el = document.getElementById("' . $id . '");
					var callback = ' . $validator->getCallbackJs() . ';
					callback(resultCallback, el);
					});';
				$validatorAdded = true;

			}
		}
		$js .= '}
		var cwRegisterValidatorCallbacks'.$postfix.' = function () { ';

		// Attach the validators only in case there is at least one validator added to the form.

		if ($validatorAdded) {
			$js .= 'addValidator("' . $id . '",
					 function (e){stopEvent(e); cwValidateFields'.$postfix.'(function(){
						var element = document.getElementById("' . $id . '");
						var formObject = getFormElement(element);
						//We can not call formObject.submit(), because submit could be an element with id "submit" an not the submit function
						formObject.constructor.prototype.submit.call(formObject);
					},
					function(errors, valid){
						var msg = errors[Object.keys(errors)[0]];
						alert(msg);
					})
				}); ';
		}

		$js .= '}; ';

		return $js;
	}


	protected function renderStopEventJavaScript()
	{
		return '		function stopEvent(e) {
			if ( e.stopPropagation ) { e.stopPropagation(); }
			e.cancelBubble = true;
			if ( e.preventDefault ) { e.preventDefault(); } else { e.returnValue = false; }
			return false;
		}
	';
	}

	protected function renderGetFormElementJavaScript()
	{
		return " function getFormElement(obj) {
			var obj_parent = obj.parentNode;
			if (!obj_parent) return false;
			if (typeof obj_parent.tagName === 'undefined' || obj_parent.tagName.toLowerCase() == 'form') { return obj_parent; }
			else { return getFormElement(obj_parent); }
		} ";
	}

	protected function renderAddValidatorJavaScript()
	{
		return "function addValidator( id, fn ) {
			type = 'submit';
			var element = document.getElementById(id);
			if (element) {
				formObj = getFormElement(element);
				if ( formObj.attachEvent ) {
					formObj['e'+type+fn] = fn;
					formObj[type+fn] = function(){formObj['e'+type+fn]( window.event );}
					formObj.attachEvent( 'onsubmit', formObj[type+fn] );
				} else {
					formObj.addEventListener( 'submit', fn, false );
				}
			} else {
				setTimeout(function(){
					addValidator(id, fn);
				}, 100);
			}
		}";
	}


	protected function renderScopeInitialize(array $elements, $jsFunctionPostfix)
	{
		$postfix = $jsFunctionPostfix;
		if ($this->getNamespacePrefix() !== NULL) {
			$postfix = $this->getNamespacePrefix().$postfix;
		}

		$output = '';
		$output .= 'var scopeInitialize'.$postfix.' = function () {';
		foreach ($elements as $element) {
			if ($element->isGlobalScope()) continue;
			if ((!$element->getControl() instanceof Customweb_Form_Control_IEditableControl)) continue;
			$output .= 'scopeToggleElements(document.getElementById(\''.$element->getControl()->getControlId().'-scope\'));';
		}
		$output .= '};';
		return $output;
	}

	protected function renderScopeToggleElements()
	{
		return "function scopeToggleElements(checkbox, container, excludedElements, checked){
			if(checkbox){
				var ignoredElements = [checkbox];
				if (typeof excludedElements != 'undefined') {
					if (typeof excludedElements != 'object') {
						excludedElements = [excludedElements];
					}
					for (var i = 0; i < excludedElements.length; i++) {
						ignoredElements.push(excludedElements[i]);
					}
				}

				var elems = [];
				var tags = ['select', 'input', 'textarea', 'button'];
				var container = container || " . $this->getContainerFromCheckboxJs('checkbox') . ";
				for (var i = 0; i < tags.length; i++) {
					var children = container.getElementsByTagName(tags[i]);
					for (var j = 0; j < children.length; j++) {
						elems.push(children[j]);
					}
				}

				var isDisabled = (checked != undefined ? checked : checkbox.checked);
				for (var i = 0; i < elems.length; i++) {
					var elem = elems[i];
					var j = ignoredElements.length;
					while (j-- && elem != ignoredElements[j]);
					if (j != -1) {
						return;
					}

					elem.disabled = isDisabled;
				}
			}
		}";
	}

	protected function getContainerFromCheckboxJs($checkbox)
	{
		return $checkbox . '.parentNode.parentNode.parentNode.previousSibling';
	}

	protected function renderOnLoadJs(array $initializers, $jsFunctionPostfix)
	{
		if (!$this->isRenderOnLoadJs()) {
			return "";
		}

		$postfix = $jsFunctionPostfix;
		if ($this->getNamespacePrefix() !== NULL) {
			$postfix = $this->getNamespacePrefix(). $postfix;
		}

		$initializeFunction = 'function(){ ';
		foreach ($initializers as $initializer) {
			$initializeFunction .= $initializer . $postfix.'(); ';
		}
		$initializeFunction .= '}';

		// In case the window is already loaded
		$js = 'if (document.readyState == "complete") {	(' . $initializeFunction . ')(); } ';

		// In case the browser supports addEventListener
		$js .= ' else if (window.addEventListener) { window.addEventListener("load", ' . $initializeFunction . ', false); }';

		// In case the browse is a old IE
		$js .= ' else if (window.attachEvent) { window.attachEvent("onload", ' . $initializeFunction . '); }';

		// In case nothing else works as the window.onload method
		$js .= ' else { window.onload = ' . $initializeFunction . '; }';

		return $js;
	}

	public function renderElementPrefix(Customweb_Form_IElement $element)
	{
		$classes = $this->getCssClassPrefix() . $this->getElementCssClass();
		$classes .= ' ' . $this->getCssClassPrefix() . $element->getElementIntention()->getCssClass();

		$errorMessage = $element->getErrorMessage();
		if (! empty($errorMessage)) {
			$classes .= ' ' . $this->getCssClassPrefix() . $this->getElementErrorCssClass();
		}

		return '<div class="' . $classes . '" id="' . $element->getElementId() . '">';
	}

	public function renderElementPostfix(Customweb_Form_IElement $element)
	{
		return '</div>';
	}

	public function renderElementLabel(Customweb_Form_IElement $element)
	{
		if ($element instanceof Customweb_Form_Element) {
			$for = '';
			if ($element->getControl() != null && $element->getControl()->getControlId() !== null && $element->getControl()->getControlId() != '') {
				$for = $element->getControl()->getControlId();
			}
			$label = $element->getLabel();
			if ($element->isRequired()) {
				$label .= $this->renderRequiredTag($element);
			}

			return $this->renderLabel($for, $label, $this->getCssClassPrefix() . $this->getElementLabelCssClass());
		}
		else {
			return '';
		}
	}

	/**
	 * @param Customweb_Form_IElement $element
	 * @return string
	 */
	protected function renderRequiredTag(Customweb_Form_IElement $element)
	{
		return '<span class="' . $this->getCssClassPrefix() . 'required">*</span>';
	}

	/**
	 * @param string $referenceTo
	 * @param string $label
	 * @param string $class
	 * @return string
	 */
	protected function renderLabel($referenceTo, $label, $class)
	{
		$for = '';
		if (!empty($referenceTo)) {
			$for = ' for="' . $referenceTo . '" ';
		}
		return '<label class="' . $class . '" ' . $for . '>' . $label . '</label>';
	}

	public function renderElementAdditional(Customweb_Form_IElement $element)
	{
		$output = '';

		$errorMessage = $element->getErrorMessage();
		if (!empty($errorMessage)) {
			$output .= $this->renderElementErrorMessage($element);
		}

		if (!$element->isGlobalScope()) {
			$output .= $this->renderElementScope($element);
		}

		$description = $element->getDescription();
		if (!empty($description)) {
			$output .= $this->renderElementDescription($element);
		}

		return $output;
	}

	/**
	 * @param Customweb_Form_IElement $element
	 * @return string
	 */
	protected function renderElementDescription(Customweb_Form_IElement $element)
	{
		return '<div class="' . $this->getCssClassPrefix() . $this->getDescriptionCssClass() . '">' . $element->getDescription() . '</div>';
	}

	/**
	 * @param Customweb_Form_IElement $element
	 * @return string
	 */
	protected function renderElementErrorMessage(Customweb_Form_IElement $element)
	{
		return '<div class="' . $this->getCssClassPrefix() . $this->getErrorMessageCssClass() . '">' . strip_tags($element->getErrorMessage()) . '</div>';
	}

	/**
	 * @param Customweb_Form_IElement $element
	 * @return string
	 */
	protected function renderElementScope(Customweb_Form_IElement $element)
	{
		$output = '';
		$output .= '<div class="' . $this->getCssClassPrefix() . $this->getElementScopeCssClass() . '">';
		if ($element->getControl() instanceof Customweb_Form_Control_IEditableControl) {
			$output .= $this->renderElementScopeControl($element);
		}
		$output .= '</div>';
		return $output;
	}

	/**
	 * @param Customweb_Form_IElement $element
	 * @return string
	 */
	protected function renderElementScopeControl(Customweb_Form_IElement $element)
	{
		$scopeControlId = $element->getControl()->getControlId() . '-scope';
		$scopeControlName = implode('_', $element->getControl()->getControlNameAsArray());
		$output = '';
		$output .= '<div class="checkbox">';
		$output .= '<label for="' . $scopeControlId . '">';
		$output .= '<input type="checkbox" ' . ($element->isInherited() ? 'checked="checked"' : '') . '
			name="default[' . $scopeControlName . ']"
			id="' . $scopeControlId . '"
			value="default"
			' . ($this->isAddJs() ? 'onclick="scopeToggleElements(this)"' : '') . ' /> ';
		$output .= Customweb_I18n_Translation::__('Use Default');
		$output .= '</label>';
		$output .= '</div>';
		return $output;
	}

	public function renderControl(Customweb_Form_Control_IControl $control)
	{
		return $control->render($this);
	}

	public function renderControlPrefix(Customweb_Form_Control_IControl $control, $controlTypeClass)
	{
		return '<div class="' . $this->getCssClassPrefix() . $this->getControlCssClass() . ' ' . $this->getCssClassPrefix() . $controlTypeClass . '" id="' . $control->getControlId() . '-wrapper">';
	}

	public function renderControlPostfix(Customweb_Form_Control_IControl $control, $controlTypeClass)
	{
		return '</div>';
	}

	public function renderOptionPrefix(Customweb_Form_Control_IControl $control, $optionKey)
	{
		return '<div class="' . $this->getCssClassPrefix() . $this->getOptionCssClass() . '" id="' . $control->getControlId() . '-' . $optionKey . '-key">';
	}

	public function renderOptionPostfix(Customweb_Form_Control_IControl $control, $optionKey)
	{
		return '</div>';
	}

	public function getFormToken(Customweb_IForm $form)
	{
		return null;
	}

	public function checkFormToken(Customweb_IForm $form, array $formData)
	{
		$token = $this->getFormToken($form);
		if ($token !== null) {
			if ($token !== $formData[self::FORM_TOKEN_FIELD_NAME]) {
				return false;
			}
		}

		return true;
	}

	protected function renderButtons(array $buttons, $jsFunctionPostfix = '')
	{
		$output = '';
		foreach ($buttons as $button) {
			$output .= $this->renderButton($button, $jsFunctionPostfix);
		}

		return $output;
	}

	public function renderButton(Customweb_Form_IButton $button, $jsFunctionPostfix = '')
	{
		$postfix = $jsFunctionPostfix;
		if ($this->getNamespacePrefix() !== NULL) {
			$postfix = $this->getNamespacePrefix(). $postfix;
		}
		$output = '<input type="submit" name="button[' . $button->getMachineName() . ']" value="' . $button->getTitle() . '" class="' . $this->getButtonClasses($button) . '" id="' . $button->getId() . '" ';
		if(!$button->isJSValidationExecuted()){
			$output .= 'onclick="cwValidationRequired'.$postfix.' = false; return true;"';
		}
		else {
			$output .='onclick="cwValidationRequired'.$postfix.' = true; return true;"';
		}
		$output.= ' />';

		return $output;

	}

	/**
	 * @param Customweb_Form_IButton $button
	 * @return string
	 */
	protected function getButtonClasses(Customweb_Form_IButton $button)
	{
		$classes = array(
			$this->getButtonClass()
		);

		switch ($button->getType()) {
			case Customweb_Form_IButton::TYPE_CANCEL:
				$classes[] = 'btn-danger';
				break;
			case Customweb_Form_IButton::TYPE_DEFAULT:
				$classes[] = 'btn-default';
				break;
			case Customweb_Form_IButton::TYPE_INFO:
				$classes[] = 'btn-info';
				break;
			case Customweb_Form_IButton::TYPE_SUCCESS:
				$classes[] = 'btn-success';
				break;
		}

		return implode(' ', $classes);
	}
}