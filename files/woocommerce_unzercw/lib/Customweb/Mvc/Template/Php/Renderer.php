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

require_once 'Customweb/Core/String.php';
require_once 'Customweb/Core/Stream/Input/File.php';
require_once 'Customweb/Mvc/Template/Filter/Translate.php';
require_once 'Customweb/Mvc/Template/Renderer.php';
require_once 'Customweb/Mvc/Template/IFilter.php';


/**
 * @author Simon Schurter
 * @Bean
 */
class Customweb_Mvc_Template_Php_Renderer extends Customweb_Mvc_Template_Renderer
{
	private $plugins = array();
	
	public function __construct(Customweb_Asset_IResolver $assetResolver, Customweb_DependencyInjection_IContainer $container)
	{
		parent::__construct($assetResolver, $container);
		
		$this->initPlugins();
	}
	
	public function render(Customweb_Mvc_Template_IRenderContext $context)
	{
		$stream = $this->getAssetResolver()->resolveAssetStream($context->getTemplate() . '.phtml');
		
		if ($stream instanceof Customweb_Core_Stream_Input_File) {
			return $this->renderInclude($stream->getFilePath(), $context->getVariables());
		} else {
			return $this->renderEval($stream->read(), $context->getVariables());
		}
	}

	private function renderInclude($template, array $variables)
	{
		extract($variables, EXTR_SKIP);
		
		ob_start();
		include $template;
		$html = ob_get_clean();
		
		return $html;
	}

	private function renderEval($template, array $variables)
	{
		extract($variables, EXTR_SKIP);
		
		ob_start();
		eval($template);
		$html = ob_get_clean();
		
		return $html;
	}
	
	public function __call($name, $arguments)
	{
		if (isset($this->plugins[$name])) {
			$plugin = $this->plugins[$name];
			if ($plugin instanceof Customweb_Mvc_Template_IFilter) {
				return $this->plugins[$name]->filter(current($arguments));
			}
		}
		throw new Exception(Customweb_Core_String::_("The plugin '!plugin' has not been found.")->format(array('!plugin' => $name)));
	}
	
	private function initPlugins()
	{
		$this->addFilter(new Customweb_Mvc_Template_Filter_Translate());
	}
	
	private function addFilter(Customweb_Mvc_Template_IFilter $filter)
	{
		$this->plugins[$filter->getName()] = $filter;
	}
}