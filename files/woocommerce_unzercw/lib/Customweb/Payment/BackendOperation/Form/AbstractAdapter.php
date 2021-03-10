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

require_once 'Customweb/Payment/BackendOperation/IForm.php';
require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Payment/BackendOperation/Form/IAdapter.php';
require_once 'Customweb/Annotation/Scanner.php';
require_once 'Customweb/Payment/BackendOperation/Form/IProcessable.php';
require_once 'Customweb/DependencyInjection/Bean/Provider/Annotation/Util.php';
require_once 'Customweb/Payment/BackendOperation/Form/Annotation/BackendForm.php';


/**
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_BackendOperation_Form_AbstractAdapter implements Customweb_Payment_BackendOperation_Form_IAdapter {

	/**
	 * @var Customweb_DependencyInjection_IContainer
	 */
	private $container;
	
	private $forms = null;
	
	public function __construct(Customweb_DependencyInjection_IContainer $container) {
		$this->container = $container;
	}
	
	public function getForms() {
		if ($this->forms === null) {
			$this->forms = array();
			$scanner = new Customweb_Annotation_Scanner();
			$formAnnotations = $scanner->find('Customweb_Payment_BackendOperation_Form_Annotation_BackendForm', $this->getFormPackages());
			
			foreach ($formAnnotations as $className => $annotation) {
				$bean = Customweb_DependencyInjection_Bean_Provider_Annotation_Util::createBeanInstance($className, $className);
				$form = $bean->getInstance($this->getContainer());
				
				if (!($annotation instanceof Customweb_Payment_BackendOperation_Form_Annotation_BackendForm)) {
					throw new Customweb_Core_Exception_CastException('Customweb_Payment_BackendOperation_Form_Annotation_BackendForm');
				}
					
				if (!($form instanceof Customweb_Payment_BackendOperation_IForm)) {
					throw new Customweb_Core_Exception_CastException('Customweb_Payment_BackendOperation_IForm');
				}
				$key = self::findNextBiggerKey($this->forms, $annotation->getSortOrder());
				$this->forms[$key] = $form;
			}
			ksort($this->forms);
		}
		
		return $this->forms;
	}

	protected function getFormPackages() {
		return array(
			'Customweb_Payment_BackendOperation_Form',
		);
	}
	
	public function processForm(Customweb_Payment_BackendOperation_IForm $form, Customweb_Form_IButton $pressedButton, array $formData) {
		$forms = $this->getForms();
		foreach ($forms as $formItem) {
			if ($formItem->getMachineName() === $form->getMachineName()) {
				if ($form->isProcessable() && $form instanceof Customweb_Payment_BackendOperation_Form_IProcessable) {
					$form->process($pressedButton, $formData);
					return;
				}
			}
		}
	}
	
	/**
	 * @return Customweb_DependencyInjection_IContainer
	 */
	protected function getContainer() {
		return $this->container;
	}
	

	private static function findNextBiggerKey($array, $key) {
		if (isset($array[$key])) {
			return self::findNextBiggerKey($array, $key + 1);
		}
		else {
			return $key;
		}
	}
	

}