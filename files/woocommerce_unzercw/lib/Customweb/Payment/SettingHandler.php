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

require_once 'Customweb/Form/Control/IEditableControl.php';


/**
 * In case additional settings should be stored, which can not be handled by the default 
 * settings infrastructure this class allows the storage of the setting into a 
 * storage backend.
 * 
 * @author Thomas Hunziker
 * @Bean
 */
class Customweb_Payment_SettingHandler {
	
	const STORAGE_SPACE_KEY = 'additional_settings';
	
	/**
	 * @var Customweb_Payment_IConfigurationAdapter
	 */
	private $configuration = null;
	
	/**
	 * @var Customweb_Storage_IBackend
	 */
	private $storage = null;
	
	public function __construct(Customweb_Payment_IConfigurationAdapter $configuration, Customweb_Storage_IBackend $storage) {
		$this->configuration = $configuration;
		$this->storage = $storage;
	}
	
	/**
	 * This method returns the setting value for the given setting key. This method consider the 
	 * current store and use the most specific to the store hierarchy.
	 * 
	 * @param string $key
	 * @return object|NULL
	 */
	public function getSettingValue($key) {
		foreach ($this->getStoreHierarchySettingKeys($key) as $possibleKey) {
			$rs = $this->getStorage()->read(self::STORAGE_SPACE_KEY, $possibleKey);
			if ($rs !== null) {
				return $rs;
			}
		}
		return null;
	}
	
	public function hasCurrentStoreSetting($key) {
		return $this->getCurrentStoreSettingValue($key) !== null;
	}
	
	/**
	 * This method does return setting value for the current store. The method
	 * does not consider the store hierarchy. This method is in most cases not 
	 * suitable.
	 * 
	 * @param string $key
	 * @return object
	 */
	public function getCurrentStoreSettingValue($key) {
		$storageKeyName = $this->getCurrentStoreHierarchySettingKey($key);
		return $this->getStorage()->read(self::STORAGE_SPACE_KEY, $storageKeyName);
	}
	
	public function setSettingValue($key, $value = null) {
		$storageKeyName = $this->getCurrentStoreHierarchySettingKey($key);
		if ($value == null) {
			$this->getStorage()->remove(self::STORAGE_SPACE_KEY, $storageKeyName);
		} else {
			$this->getStorage()->write(self::STORAGE_SPACE_KEY, $storageKeyName, $value);
		}
	}
	
	/**
	 * This method stores the form data into the storage backend with the right
	 * keys according to the current store hierarchy.
	 * 
	 * @param Customweb_IForm $form
	 * @param array $formData
	 * @return void
	 */
	public function processForm(Customweb_IForm $form, array $formData) {
		foreach ($form->getElements() as $element) {
			if ($element->getControl() instanceof Customweb_Form_Control_IEditableControl) {
				$key = implode('_', $element->getControl()->getControlNameAsArray());
				if ($element->isGlobalScope()) {
					$value = $element->getControl()->getFormDataValue($formData);
					if($value === null) {
						$this->getStorage()->remove(self::STORAGE_SPACE_KEY, $key);
					}
					else {
						$this->getStorage()->write(self::STORAGE_SPACE_KEY, $key, $value);
					}
				} else {
					$storageKeyName = $this->getCurrentStoreHierarchySettingKey($key);
					if ($this->getConfiguration()->useDefaultValue($element, $formData)) {
						$this->getStorage()->remove(self::STORAGE_SPACE_KEY, $storageKeyName);
					} else {
						$value = $element->getControl()->getFormDataValue($formData);
						if($value === null) {
							$this->getStorage()->remove(self::STORAGE_SPACE_KEY, $storageKeyName);
						}
						else {
							$this->getStorage()->write(self::STORAGE_SPACE_KEY, $storageKeyName, $value);
						}
						
					}
				}
			}
		}
	}
	
	protected function getCurrentStoreHierarchySettingKey($key) {
		$keys = $this->getStoreHierarchySettingKeys($key);
		return $keys[0];
	}
	
	/**
	 * Returns a set of keys which may contain the configuration 
	 * value searched for.
	 * 
	 * Possible response:
	 * 	array(
	 * 		'default_en_{key}',
	 * 		'default_{key}',
	 * 		'{key}'
	 * 	)
	 * 
	 * @param string $key
	 * @return multitype:string
	 */
	protected function getStoreHierarchySettingKeys($key) {
		$storeHierarchy = $this->getConfiguration()->getStoreHierarchy();
		if ($storeHierarchy === null) {
			return array($key);
		}
		else {
			$keys = array($key);
			foreach (array_reverse($storeHierarchy, true) as $storeId => $storeName) {
				foreach ($keys as $id => $value) {
					$keys[$id] = $storeId . '_' . $value;
				}
				$keys[] = $key;
			}
			
			return $keys;
		}
	}

	protected function getConfiguration(){
		return $this->configuration;
	}

	protected function getStorage(){
		return $this->storage;
	}
	
}