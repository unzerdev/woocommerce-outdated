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

require_once 'Customweb/Core/Stream/Input/File.php';
require_once 'Customweb/Mvc/Template/Filter/Translate.php';
require_once 'Customweb/Mvc/Template/Renderer.php';



/**
 *
 * @author Nico Eigenmann
 * @Bean
 *
 */
class Customweb_Mvc_Template_Smarty_Renderer extends Customweb_Mvc_Template_Renderer {
	private static $pluginsInit = false;
	private $smarty = null;

	public function __construct(Customweb_Asset_IResolver $assetResolver, Customweb_DependencyInjection_IContainer $container, Customweb_Mvc_Template_Smarty_ContainerBean $smarty){
		parent::__construct($assetResolver, $container);
		$this->smarty = $smarty->getSmartyInstance();
		
		$this->initPlugins();
	}

	/**
	 * This method enables the security policy for Smarty.
	 * Per default the security policy is not activated.
	 */
	public function enableSecurityPolicy(){
		// Not all version of smarty support security policies
		if (class_exists('Smarty_Security')) {
			$policy = new Smarty_Security($this->smarty);
			
			$policy->php_handling = Smarty::PHP_REMOVE;
			$policy->php_functions = array(
				'isset',
				'empty',
				'count',
				'sizeof',
				'in_array',
				'is_array',
				'time',
				'nl2br' 
			);
			$policy->php_modifiers = array(
				'capitalize',
				'cat',
				'count_characters',
				'count_paragraphs',
				'count_sentences',
				'count_words',
				'date_format',
				'default',
				'escape',
				'indent',
				'lower',
				'nl2br',
				'regex_replace',
				'replace',
				'spacify',
				'string_format',
				'strip',
				'strip_tags',
				'truncate',
				'upper',
				'wordwrap',
				
				// Custom modifiers
				'translate' 
			);
			
			$policy->static_classes = array();
			$policy->allow_constants = false;
			$policy->allow_super_globals = false;
			$policy->allow_php_tag = false;
			$this->smarty->enableSecurity($policy);
		}
	}

	public function render(Customweb_Mvc_Template_IRenderContext $context){
		foreach ($context->getVariables() as $key => $value) {
			$this->smarty->assign($key, $value);
		}
		$stream = $this->getAssetResolver()->resolveAssetStream($context->getTemplate() . '.tpl');
		
		if ($stream instanceof Customweb_Core_Stream_Input_File) {
			return $this->smarty->fetch($stream->getFilePath());
		}
		else {
			return $this->smarty->fetch('string:' . $stream->read());
		}
	}

	protected function initPlugins(){
		if (!self::$pluginsInit) {
			$this->registerCustomModifier(new Customweb_Mvc_Template_Filter_Translate());
			self::$pluginsInit = true;
		}
	}

	protected function registerCustomModifier(Customweb_Mvc_Template_IFilter $filter){
		if (method_exists($this->smarty, 'registerPlugin')) {
			$this->smarty->registerPlugin('modifier', $filter->getName(), array(
				$filter,
				'filter' 
			));
		}
		else {
			$this->smarty->register_modifier($filter->getName(), array(
				$filter,
				'filter' 
			));
		}
	}
}