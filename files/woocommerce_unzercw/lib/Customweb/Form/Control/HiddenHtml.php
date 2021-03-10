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

require_once 'Customweb/Form/Control/Abstract.php';


/**
 * This class provides a control, which does simply output the given
 * HTML string. The intention of this control is to allow to output not 
 * visible HTML. This can be used to include custom JS for example.
 * 
 * This should not be used anymore. In case JavaScript must be attached to the 
 * controls or elements, then should the JavaScript attached to the element.
 * 
 * @author Thomas Hunziker
 * @deprecated
 *
 */
class Customweb_Form_Control_HiddenHtml extends Customweb_Form_Control_Abstract {

	/**
	 * @var String
	 */
	private $htmlContent = '';

	/**
	 * Constructor.
	 * 
	 * @param string $controlName Name of the control
	 * @param string $htmlContent HTML content to show
	 */
	public function __construct($controlName, $htmlContent) {
		parent::__construct($controlName);
		$this->htmlContent = $htmlContent;
	}

	/**
	 * Returns the HTML content to show.
	 * 
	 * @return string HTML content
	 */
	public function getContent() {
		return $this->htmlContent;
	}
	
	/**
	 * This method sets the HTML content of the element.
	 * 
	 * @param string $content
	 * @return Customweb_Form_Control_HiddenHtml
	 */
	public function setContent($content) {
		$this->htmlContent = $content;
		return $this;
	}
	
	
	/**
	 * Adds the $content to the HTML content of this control.
	 *
	 * @param string $content
	 * @return Customweb_Form_Control_HiddenHtml
	 */
	public function appendContent($content) {
		$this->htmlContent .= $content;
		return $this;
	}
	
	public function renderContent(Customweb_Form_IRenderer $renderer) {
		return $this->getContent();
	}
	
	public function getControlTypeCssClass() {
		return 'html-field';
	}
	
	public function getFormDataValue(array $formData) {
		return null;
	}
	
}