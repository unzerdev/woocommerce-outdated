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

/**
 * This interface is implemented by the shopping system to allow access to the
 * configuraiton.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_IConfigurationAdapter {

	/**
	 * This method returns the configuration value by the given key. The language 
	 * must be the same as the one given by the shop system in the 
	 * IOrderContext::getLanguage().
	 * 
	 * In case the configuration is a file type type the response must be
	 * a Customweb_Core_Stream_IInput.
	 *
	 * @param string $key The configuraiton key.
	 * @param string $languageCode [optional] The language of the configuraiton value. Only required for 
	 *                             language dependend configuration values.
	 * @return mixed Configuration Value
	 */
	public function getConfigurationValue($key, $language = null);
	
	/**
	 * This method allows to check whether a configuration exists or not.
	 * 
	 * @param string $key The configuraiton key.
	 * @param string $language [optional] The language of the configuraiton value. Only required for 
	 *                         language dependend configuration values.
	 * @return boolean Either true when it exists or false, when it does not exists.
	 */
	public function existsConfiguration($key, $language = null);
	
	/**
	 * Returns a list of languages supported by the system. In case 
	 * the flag $currentStore is set to true, the method should only
	 * return the active languages for the current store. If the store
	 * is language neutral the method should return null.
	 * 
	 * @param boolean $currentStore
	 * @return Customweb_Core_Language[]
	 */
	public function getLanguages($currentStore = false);
	
	/**
	 * Returns the current store hierarchy path. The path
	 * indicates the inheritance of the settings inside
	 * the store. 
	 * 
	 * The hierarchy is expressed as a list of edges on the 
	 * current path. The keys of the entries have to be unique
	 * throughout the system.
	 * 
	 * e.g. array(
	 *    'default' => 'Name of Default', 
	 *    'website1' => 'Website Name',
	 *    'store1' => 'Store Name',
	 * );
	 * 
	 * In case the system is not a multi store environment this 
	 * method should return null. The path must be determined by
	 * the current context.
	 * 
	 * @return array
	 */
	public function getStoreHierarchy();
	
	/**
	 * Returns whether the default value should be used.
	 * 
	 * @param Customweb_Form_IElement $element
	 * @param array $formData
	 * @return boolean
	 */
	public function useDefaultValue(Customweb_Form_IElement $element, array $formData);
	
	/**
	 * Returns a map of order status present in the
	 * system. The key is the status id and the value of the
	 * map is the name of the status. The name should be translated
	 * to the current user language.
	 * 
	 * e.g. array(
	 *   'statusId1' => 'Status Name',
	 *   'statusId2' => 'Status Other Name',
	 * );
	 * 
	 * @return array
	 */
	public function getOrderStatus();
	

}