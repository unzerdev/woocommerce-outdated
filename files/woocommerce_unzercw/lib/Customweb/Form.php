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
require_once 'Customweb/Form/ElementGroup.php';
require_once 'Customweb/IForm.php';


/**
 * This is a default implementation of a form.
 */
class Customweb_Form implements Customweb_IForm
{
	/**
	 * @var string
	 */
	private $id = null;

	/**
	 * @var string
	 */
	private $targetUrl = null;

	/**
	 * @var string
	 */
	private $targetWindow = self::TARGET_WINDOW_SAME;

	/**
	 * @var string
	 */
	private $requestMethod = self::REQUEST_METHOD_POST;

	/**
	 * @var string
	 */
	private $title = null;

	/**
	 * @var Customweb_Form_IElementGroup[]
	 */
	private $elementGroups = array();

	/**
	 * @var Customweb_Form_IButton[]
	 */
	private $buttons = array();

	/**
	 * @var string
	 */
	private $machineName = null;

	/**
	 * @param Customweb_IForm $form
	 */
	public function __construct(Customweb_IForm $form = null)
	{
		if ($form !== null) {
			$this->setButtons($form->getButtons())
				->setElementGroups($form->getElementGroups())
				->setId($form->getId())
				->setMachineName($form->getMachineName())
				->setRequestMethod($form->getRequestMethod())
				->setTargetUrl($form->getTargetUrl())
				->setTargetWindow($form->getTargetWindow())
				->setTitle($form->getTitle());
		} else {
			$this->id = Customweb_Util_Rand::getUuid();
		}
	}

	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @param string $id
	 * @return Customweb_Form
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	
	public function getMachineName()
	{
		return $this->machineName;
	}
	
	/**
	 * @param string $machineName
	 * @return Customweb_Form
	 */
	public function setMachineName($machineName)
	{
		$this->machineName = $machineName;
		return $this;
	}

	public function getTargetUrl()
	{
		return $this->targetUrl;
	}

	/**
	 * @param string $targetUrl
	 * @return Customweb_Form
	 */
	public function setTargetUrl($targetUrl)
	{
		$this->targetUrl = $targetUrl;
		return $this;
	}

	public function getTargetWindow()
	{
		return $this->targetWindow;
	}

	/**
	 * @param string $targetWindow
	 * @return Customweb_Form
	 */
	public function setTargetWindow($targetWindow)
	{
		$this->targetWindow = $targetWindow;
		return $this;
	}

	public function getRequestMethod()
	{
		return $this->requestMethod;
	}

	/**
	 * @param string $requestMethod
	 * @return Customweb_Form
	 */
	public function setRequestMethod($requestMethod)
	{
		$this->requestMethod = $requestMethod;
		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return Customweb_Form
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	public function getElementGroups()
	{
		return $this->elementGroups;
	}

	/**
	 * @param Customweb_Form_ElementGroup[] $elementGroups
	 * @return Customweb_Form
	 */
	public function setElementGroups($elementGroups)
	{
		$this->elementGroups = $elementGroups;
		return $this;
	}

	/**
	 * @param Customweb_Form_IElementGroup $elementGroup
	 * @return Customweb_Form
	 */
	public function addElementGroup(Customweb_Form_IElementGroup $elementGroup)
	{
		$this->elementGroups[$elementGroup->getId()] = $elementGroup;
		return $this;
	}

	/**
	 * @param Customweb_Form_IElementGroup $elementGroup
	 * @return Customweb_Form
	 */
	public function removeElementGroup(Customweb_Form_IElementGroup $elementGroup)
	{
		if (isset($this->elementGroups[$elementGroup->getId()])) {
			unset($this->elementGroups[$elementGroup->getId()]);
		}
		return $this;
	}

	public function getElements()
	{
		$elements = array();
		foreach ($this->elementGroups as $elementGroup) {
			foreach ($elementGroup->getElements() as $element) {
				$elements[$element->getElementId()] = $element;
			}
		}
		return $elements;
	}

	/**
	 * @param Customweb_Form_IElement $element
	 * @return Customweb_Form
	 */
	public function addElement(Customweb_Form_IElement $element)
	{
		if (empty($this->elementGroups)) {
			$this->addElementGroup(new Customweb_Form_ElementGroup());
		}
		$elementGroup = end($this->elementGroups);
		if (method_exists($elementGroup, 'addElement')) {
			$elementGroup->addElement($element);
		}
		return $this;
	}

	/**
	 * @param Customweb_Form_IElement $element
	 * @return Customweb_Form
	 */
	public function removeElement(Customweb_Form_IElement $element)
	{
		foreach ($this->elementGroups as $elementGroup) {
			if (method_exists($elementGroup, 'removeElement')) {
				$elementGroup->removeElement($element);
			}
		}
		return $this;
	}

	public function getButtons()
	{
		return $this->buttons;
	}

	/**
	 * @param Customweb_Form_IButton[] $buttons
	 * @return Customweb_Form
	 */
	public function setButtons(array $buttons)
	{
		$this->buttons = $buttons;
		return $this;
	}

	/**
	 * @param Customweb_Form_IButton $button
	 * @return Customweb_Form
	 */
	public function addButton(Customweb_Form_IButton $button)
	{
		$this->buttons[] = $button;
		return $this;
	}
}