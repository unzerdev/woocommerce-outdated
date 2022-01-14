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

require_once 'Customweb/I18n/Translation.php';


/**
 *
 * @author Sebastian Bossert
 * @Bean
 */
class Customweb_Unzer_Configuration {

	/**
	 *
	 * @var Customweb_Payment_IConfigurationAdapter
	 */
	private $configurationAdapter = null;

	public function __construct(Customweb_Payment_IConfigurationAdapter $configurationAdapter){
		$this->configurationAdapter = $configurationAdapter;
	}

	public function getApiUrl($path){
		return str_replace(array(
			"{version}",
			"{path}"
		), array(
			"v1",
			$path
		), "https://api.unzer.com/{version}/{path}");
	}

	public function getPublicKey(){
		return $this->getSwitchableConfigurationValue('public_key', Customweb_I18n_Translation::__("Public Key"));
	}

	public function getPrivateKey(){
		return $this->getSwitchableConfigurationValue('private_key', Customweb_I18n_Translation::__("Private Key"));
	}

	public function getPaymentReferenceSchema(){
		return $this->getConfigurationValue('payment_reference_schema');
	}

	public function getOrderIdSchema(){
		$schema = $this->getConfigurationValue('order_id_schema');
		if(empty($schema)) {
			$schema = '{id}';
		}
		return $schema;
	}

	public function getInvoiceIdSchema(){
		return $this->getConfigurationValue('invoice_id_schema');
	}

	/**
	 * Returns whether the gateway is in test mode or in live mode.
	 *
	 * @return boolean True if the system is in test mode. Else return false.
	 */
	public function isTestMode(){
		return $this->configurationAdapter->getConfigurationValue('operating_mode') != 'live';
	}

	private function getSwitchableConfigurationValue($key, $label = null, $language = null){
		if ($this->isTestMode()) {
			$key .= '_test';
			if ($label) {
				$label = Customweb_I18n_Translation::__("!label (Test)", array(
					'!label' => $label
				));
			}
		}
		else {
			$key .= '_live';
			if ($label) {
				$label = Customweb_I18n_Translation::__("!label (Live)", array(
					'!label' => $label
				));
			}
		}
		return $this->getConfigurationValue($key, $label, $language);
	}

	/**
	 * Retrieves a configuration value based on the supplied key.
	 * If the setting is a string surrounding whitespaces will be removed.
	 * If label is set, we check if the value is not empty, and throw an exception if it is.
	 *
	 * @param string $key
	 * @param string $label
	 * @param string $language
	 * @throws Exception
	 * @return mixed
	 */
	private function getConfigurationValue($key, $label = null, $language = null){
		$value = $this->configurationAdapter->getConfigurationValue($key, $language);
		if (is_string($value)) {
			$value = trim($value);
		}
		if (empty($value) && !empty($label)) {
			throw new Exception(
					Customweb_I18n_Translation::__("The value for '@label' must be set in the configuration.", array(
						"@label" => $label
					)));
		}
		return $value;
	}
}