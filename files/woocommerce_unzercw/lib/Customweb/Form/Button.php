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

require_once 'Customweb/Form/IButton.php';
require_once 'Customweb/Core/Util/Rand.php';


/**
 * Represents a button inside of a form.
 */
class Customweb_Form_Button implements Customweb_Form_IButton
{
	/**
	 * @var string
	 */
	private $id = null;
	
	/**
	 * @var string
	 */
	private $machineName = null;
	
	/**
	 * @var string
	 */
	private $title = null;

	/**
	 * @var string
	 */
	private $type = null;
	
	/**
	 * @var boolean
	 */
	private $jsValidationExecuted;

	/**
	 * @param Customweb_Form_IButton $button
	 */
	public function __construct(Customweb_Form_IButton $button = null)
	{
		if ($button !== null) {
			$this->setId($button->getId());
			$this->setMachineName($button->getMachineName());
			$this->setTitle($button->getTitle());
			$this->setType($button->getType());
			$this->setJSValidationExecuted($button->isJSValidationExecuted());
		} else {
			$this->setId(Customweb_Core_Util_Rand::getUuid());
			$this->setType(self::TYPE_DEFAULT);
			$this->setJSValidationExecuted(true);
		}
	}

	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $id        	
	 * @return Customweb_Form_Button
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
	 * @return Customweb_Form_Button
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
	 * @return Customweb_Form_Button
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 * @return Customweb_Form_Button
	 */
	public function setType($type)
	{
		$this->type = $type;
		return $this;
	}
	
	public function isJSValidationExecuted(){
		return $this->jsValidationExecuted;
	}
	
	/**
	 * 
	 * @param boolean $bool
	 * @return Customweb_Form_Button
	 */
	public function setJSValidationExecuted($bool){
		$this->jsValidationExecuted = $bool;
		return $this;
	}
}