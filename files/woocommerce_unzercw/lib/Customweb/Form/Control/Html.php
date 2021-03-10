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

require_once 'Customweb/I18n/LocalizableString.php';
require_once 'Customweb/Form/Control/Abstract.php';


/**
 * This class provides a control, which does simply output the given
 * HTML string. This is useful if you want to provide information for
 * the user, but you do not want to collect any information. This element 
 * must not contain any JavaScript.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Form_Control_Html extends Customweb_Form_Control_Abstract {

	/**
	 * @var Customweb_Form_Control_IControl[]
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
		if (is_string($htmlContent)) {
			$this->htmlContent = new Customweb_I18n_LocalizableString($htmlContent);
		}
		elseif($htmlContent instanceof Customweb_I18n_LocalizableString) {
			$this->htmlContent = $htmlContent;
		}
		
	}

	/**
	 * Returns the HTML content to show.
	 * 
	 * @return Customweb_I18n_LocalizableString The translatable string
	 */
	public function getContent() {
		return $this->htmlContent;
	}
	
	/**
	 * This method sets the HTML content of the element.
	 *
	 * @param string $content
	 * @return Customweb_Form_Control_Html
	 */
	public function setContent($content) {
		$this->htmlContent = $content;
		return $this;
	}
	
	/**
	 * Adds the $content to the HTML content of this control.
	 * 
	 * @param string $content
	 * @return Customweb_Form_Control_Html
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

}