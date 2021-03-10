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

require_once 'Customweb/Mvc/Template/IRenderContext.php';


class Customweb_Mvc_Template_RenderContext implements Customweb_Mvc_Template_IRenderContext
{
	private $securityPolicy = null;

	private $variables = array();

	private $template = null;

	public function getSecurityPolicy()
	{
		return $this->securityPolicy;
	}

	public function setSecurityPolicy(Customweb_Mvc_Template_ISecurityPolicy $policy)
	{
		$this->securityPolicy = $policy;
		return $this;
	}

	public function getVariables()
	{
		return $this->variables;
	}

	public function addVariable($name, $value)
	{
		$this->variables[$name] = $value;
		return $this;
	}

	public function addVariables($variables)
	{
		foreach ($variables as $name => $value) {
			$this->addVariable($name, $value);
		}
		return $this;
	}

	public function getTemplate()
	{
		if ($this->template === null) {
			throw new Exception("No template provided. Before calling the getTemplate() a template must be set.");
		}
		return $this->template;
	}

	public function setTemplate($template)
	{
		if (! is_string($template)) {
			$template = (string) $template;
		}
		
		$this->template = $template;
		
		return $this;
	}
}