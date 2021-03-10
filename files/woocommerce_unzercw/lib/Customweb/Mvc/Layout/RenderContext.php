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

require_once 'Customweb/Mvc/Layout/IRenderContext.php';


class Customweb_Mvc_Layout_RenderContext implements Customweb_Mvc_Layout_IRenderContext
{
	private $mainContent = '';

	private $title = '';

	private $javascriptFiles = array();

	private $cssFiles = array();

	public function getMainContent()
	{
		return $this->mainContent;
	}

	public function setMainContent($mainContent)
	{
		$this->mainContent = $mainContent;
		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	public function getJavaScriptFiles()
	{
		return $this->javascriptFiles;
	}

	public function addJavascriptFile($javascriptFile)
	{
		if (! in_array($javascriptFile, $this->javascriptFiles)) {
			$this->javascriptFiles[] = $javascriptFile;
		}
		return $this;
	}

	public function addJavascriptFiles($javascriptFiles)
	{
		foreach ($javascriptFiles as $javascriptFile) {
			$this->addJavascriptFile($javascriptFile);
		}
		return $this;
	}

	public function getCssFiles()
	{
		return $this->cssFiles;
	}

	public function addCssFile($cssFile)
	{
		if (! in_array($cssFile, $this->cssFiles)) {
			$this->cssFiles[] = $cssFile;
		}
		return $this;
	}

	public function addCssFiles($cssFiles)
	{
		foreach ($cssFiles as $cssFile) {
			$this->addCssFile($cssFile);
		}
		return $this;
	}
}