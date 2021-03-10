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

require_once 'Customweb/Form/IElementGroup.php';
require_once 'Customweb/Core/Util/Rand.php';


/**
 * Represents a group containing form elements.
 *
 * @see Customweb_Form_IElementGroup
 */
class Customweb_Form_ElementGroup implements Customweb_Form_IElementGroup
{
	/**
	 * @var string
	 */
	private $id;

	/**
	 * @var string
	 */
	private $machineName;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var Customweb_Form_IElement[]
	 */
	private $elements;

	/**
	 * @param Customweb_Form_IElementGroup $elementGroup
	 */
	public function __construct(Customweb_Form_IElementGroup $elementGroup = null)
	{
		if ($elementGroup !== null) {
			$this->setId($elementGroup->getId());
			$this->setMachineName($elementGroup->getMachineName());
			$this->setTitle($elementGroup->getTitle());
			$this->setElements($elementGroup->getElements());
		} else {
			$this->setId(Customweb_Core_Util_Rand::getUuid());
		}
	}

	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 * @return Customweb_Form_ElementGroup
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
	 * @return Customweb_Form_ElementGroup
	 */
	public function setMachineName($machineName)
	{
		$this->machineName = $machineName;
		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return Customweb_Form_ElementGroup
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	public function getElements()
	{
		return $this->elements;
	}

	/**
	 * @param Customweb_Form_IElement[] $elements
	 * @return Customweb_Form_ElementGroup
	 */
	public function setElements($elements)
	{
		$this->elements = $elements;
		return $this;
	}

	/**
	 * @param Customweb_Form_IElement $element
	 * @return Customweb_Form_ElementGroup
	 */
	public function addElement(Customweb_Form_IElement $element)
	{
		$this->elements[$element->getElementId()] = $element;
		return $this;
	}

	/**
	 * @param Customweb_Form_IElement $element
	 * @return Customweb_Form_ElementGroup
	 */
	public function removeElement(Customweb_Form_IElement $element)
	{
		if (isset($this->elements[$element->getElementId()])) {
			unset($this->elements[$element->getElementId()]);
		}
		return $this;
	}

	public function render(Customweb_Form_IRenderer $renderer)
	{
		$result = $renderer->renderElementGroupPrefix($this) .
		$renderer->renderElementGroupTitle($this) .
		$renderer->renderRawElements($this->getElements()) .
		$renderer->renderElementGroupPostfix($this);
		
		return $result;
	}
}