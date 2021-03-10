<?php

class Customweb_Unzer_Form_PlaceholderControl extends Customweb_Form_Control_Html {
	public function __construct($controlName){
		parent::__construct($controlName, null);
	}

	public function renderContent(Customweb_Form_IRenderer $renderer){
		return "<div id='{$this->getControlId()}' class='unzer-placeholder'></div>";
	}
}