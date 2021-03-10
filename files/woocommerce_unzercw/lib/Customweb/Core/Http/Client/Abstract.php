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

require_once 'Customweb/Core/Url.php';
require_once 'Customweb/Core/Http/IClient.php';
require_once 'Customweb/Core/Stream/Util.php';

abstract class Customweb_Core_Http_Client_Abstract implements Customweb_Core_Http_IClient {
	
	/**
	 *
	 * @var int
	 */
	private $redirectionFollowLimit = NULL;
	
	/**
	 *
	 * @var boolean
	 */
	private $enableCertificateAuthorityCheck = true;
	
	/**
	 *
	 * @var Customweb_Core_Stream_IInput
	 */
	private $clientCertificate = null;
	
	/**
	 *
	 * @var string
	 */
	private $clientCertificatePassphrase = null;
	
	/**
	 *
	 * @var int
	 */
	private $connectionTimeout = 20;
	
	/**
	 *
	 * @var string
	 */
	private $forcedSslVersion = null;
	
	/**
	 *
	 * @var Customweb_Core_Url
	 */
	private $proxyUrl = null;
	
	/**
	 *
	 * @var Customweb_Core_Url
	 */
	private $environmentProxyUrl = null;
	
	/**
	 *
	 * @var string
	 */
	private $forcedInternetProtocolAddressVersion = null;
	
	/**
	 *
	 * @var Customweb_Core_Stream_IInput
	 */
	private $certificateAuthority = null;

	public function getRedirectionFollowLimit(){
		return $this->redirectionFollowLimit;
	}

	public function setRedirectionFollowLimit($limit){
		if ($limit !== null && !is_int($limit)) {
			$limit = (int) $limit;
		}
		$this->redirectionFollowLimit = $limit;
		return $this;
	}

	public function enableCertificateAuthorityCheck(){
		$this->enableCertificateAuthorityCheck = true;
		return $this;
	}

	public function disableCertificateAuthorityCheck(){
		$this->enableCertificateAuthorityCheck = false;
		return $this;
	}

	public function isCertificateAuthorityCheckEnabled(){
		return $this->enableCertificateAuthorityCheck;
	}

	public function setClientCertificate(Customweb_Core_Stream_IInput $input){
		$this->clientCertificate = $input;
		return $this;
	}

	public function getClientCertificate(){
		return $this->clientCertificate;
	}

	public function getClientCertificatePassphrase(){
		return $this->clientCertificatePassphrase;
	}

	public function setClientCertificatePassphrase($clientCertificatePassphrase){
		$this->clientCertificatePassphrase = $clientCertificatePassphrase;
		return $this;
	}

	public function getCertificateAuthority(){
		return $this->certificateAuthority;
	}

	public function setCertificateAuthority(Customweb_Core_Stream_IInput $certificateAuthorityInputStream){
		$this->certificateAuthority = $certificateAuthorityInputStream;
		return $this;
	}

	public function getConnectionTimeout(){
		return $this->connectionTimeout;
	}

	public function setConnectionTimeout($timeout){
		if (!is_int($timeout)) {
			$timeout = (int) $timeout;
		}
		$this->connectionTimeout = $timeout;
		return $this;
	}

	public function setForcedSslVersion($version){
		if ($version !== null && !is_string($version)) {
			$version = (string) $version;
		}
		$this->forcedSslVersion = $version;
		return $this;
	}

	public function getForcedSslVersion(){
		if ($this->forcedSslVersion !== null) {
			return $this->forcedSslVersion;
		}
		
		$environmentVersion = $this->readEnvironmentVariable(self::ENVIRONMENT_VARIABLE_SSL_VERSION);
		if ($environmentVersion !== null) {
			return $environmentVersion;
		}
		
		return null;
	}

	public function getForcedInternetProtocolAddressVersion(){
		if ($this->forcedInternetProtocolAddressVersion !== null) {
			return $this->forcedInternetProtocolAddressVersion;
		}
		
		$environmentVersion = $this->readEnvironmentVariable(self::ENVIRONMENT_VARIABLE_IP_ADDRESS_VERSION);
		if ($environmentVersion !== null) {
			return $environmentVersion;
		}
		
		return null;
	}

	public function setForcedInternetProtocolAddressVersion($version){
		$this->forcedInternetProtocolAddressVersion = $version;
		return $this;
	}

	public function setProxyUrl(Customweb_Core_Url $url){
		$this->proxyUrl = $url;
		return $this;
	}

	public function getProxyUrl(){
		if ($this->proxyUrl !== null) {
			return $this->proxyUrl;
		}
		
		if ($this->environmentProxyUrl !== null) {
			return $this->environmentProxyUrl;
		}

		$proxyUrl = $this->readEnvironmentVariable(self::ENVIRONMENT_VARIABLE_PROXY_URL);
		if ($proxyUrl !== null) {
			$this->environmentProxyUrl = new Customweb_Core_Url($proxyUrl);
			return $this->environmentProxyUrl;
		}

		$proxyUrl = $this->readEnvironmentVariable(self::ENVIRONMENT_VARIABLE_PROXY_URL_LEGACY);
		if ($proxyUrl !== null) {
			$this->environmentProxyUrl = new Customweb_Core_Url($proxyUrl);
			return $this->environmentProxyUrl;
		}
		
		return null;
	}

	/**
	 * Returns true, when a HTTP proxy should be used.
	 *
	 * @return boolean
	 */
	protected function isProxyActive(){
		if ($this->getProxyUrl() !== NULL) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * This method writes the certificate InputStream to a local file and returns
	 * the path to this file.
	 *
	 * We need the a local file path to the client certificate because OpenSSL is
	 * not able to read certificates from memory.
	 *
	 * @return string Path to local file which contains the client certificate.
	 */
	protected function getClientCertificateLocalFilePath(){
		$inputStream = $this->getClientCertificate();
		
		if ($inputStream === null) {
			return null;
		}
		
		return Customweb_Core_Stream_Util::getLocalFilePath($inputStream);
	}

	/**
	 * Reads the environment variable indicated by the name.
	 * Returns null
	 * when the variable is not defined.
	 *
	 * @param string $name
	 * @return string
	 */
	protected function readEnvironmentVariable($name){
		if (isset($_SERVER[$name])) {
			return $_SERVER[$name];
		}
		else if (isset($_SERVER[strtolower($name)])) {
			return $_SERVER[strtolower($name)];
		}
		else {
			return null;
		}
	}

	/**
	 * Returns the path to the certificate authority file.
	 * The file contains
	 * all root certificates. This is used to verify the certification chain.
	 *
	 * @throws Exception
	 * @return string
	 */
	protected final function getCertificateAuthorityFilePath(){
		$inputStream = $this->getCertificateAuthority();
		if ($inputStream !== null) {
			return Customweb_Core_Stream_Util::getLocalFilePath($inputStream);
		}
		
		$caFileName = 'ca-bundle.crt.php';
		
		$baseFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . $caFileName;
		if (file_exists($baseFile)) {
			return $baseFile;
		}
		
		$classPath = '/Customweb/Core/Http/Client';
		
		$include_path = explode(PATH_SEPARATOR, get_include_path());
		foreach ($include_path as $path) {
			$potentialFileLocation = $path . $classPath . DIRECTORY_SEPARATOR . $caFileName;
			if (file_exists($potentialFileLocation)) {
				return $potentialFileLocation;
			}
		}
		throw new Exception("Could not find the Certificate Authority file 'ca-bundle.crt.php'.");
	}
}