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
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Unzer/Util/String.php';
require_once 'Customweb/Core/Http/Authorization/Basic.php';
require_once 'Customweb/Unzer/Adapter.php';
require_once 'Customweb/Core/Http/IRequest.php';
require_once 'Customweb/Core/Http/Request.php';


/**
 *
 * @author Sebastian Bossert
 */
abstract class Customweb_Unzer_Communication_AbstractRequestBuilder extends Customweb_Unzer_Adapter {
	const CONTENT_TYPE_JSON = 'application/json';
	const CONTENT_TYPE_FORM = 'application/x-www-form-urlencoded';
	protected $key;

	/**
	 *
	 * @param Customweb_DependencyInjection_IContainer $container
	 * @param string $key public key for create / post requests, private key for retrieve / get requests.
	 */
	public function __construct(Customweb_DependencyInjection_IContainer $container, $key){
		parent::__construct($container);
		$this->key = $key;
	}

	public function getUrl(){
		$url = $this->getContainer()->getConfiguration()->getApiUrl($this->getUrlPath());
		if ($this->isUseQuery()) {
			$payload = $this->getPayload();
			if (!empty($payload)) {
				$url = Customweb_Core_Url::_($url)->appendQueryParameters($payload)->toString();
			}
		}
		return $url;
	}

	protected abstract function getMethod();

	protected abstract function getPayload();

	protected abstract function getUrlPath();

	protected function getOptionalParameter($name, $value, $maxLength = null){
		if (!empty($value)) {
			if ($maxLength) {
				$value = Customweb_Unzer_Util_String::substr($value, $maxLength);
			}
			return array(
				$name => $value
			);
		}
		return array();
	}

	protected function getMandatoryParameter($name, $value, $maxLength = null){
		if (empty($value)) {
			throw new Exception(Customweb_I18n_Translation::__("Value for '@name' must be set.", array(
				'@name' => $name
			)));
		}
		if ($maxLength) {
			$value = Customweb_Unzer_Util_String::substr($value, $maxLength);
		}
		return array(
			$name => $value
		);
	}

	protected function getContentType(){
		return self::CONTENT_TYPE_JSON;
	}

	protected function isUseBody(){
		return in_array($this->getMethod(), array(
			Customweb_Core_Http_IRequest::METHOD_POST,
			Customweb_Core_Http_IRequest::METHOD_PUT
		));
	}

	protected function isUseQuery(){
		return $this->getMethod() === Customweb_Core_Http_IRequest::METHOD_GET;
	}

	protected final function isJson(){
		return $this->getContentType() === self::CONTENT_TYPE_JSON;
	}

	/**
	 * Builds the full request.
	 * Should not usually be overwritten, instead the abstract functions should be implemented.
	 *
	 * @return Customweb_Core_Http_IRequest
	 */
	public function buildRequest(){
		$request = new Customweb_Core_Http_Request();
		$request->setUrl($this->getUrl());
		$request->setAuthorization($this->getAuthorization());
		$request->setMethod($this->getMethod());
		$request->setContentType($this->getContentType());
		if ($this->isUseBody()) {
			$this->setBody($request);
		}
		$this->addHeaders($request);
		return $request;
	}

	protected function addHeaders(Customweb_Core_Http_Request $request){
		$request->appendHeader($this->getPhpVersionHeader());
		$request->appendHeader($this->getSdkTypeHeader());
		$request->appendHeader($this->getSdkVersionHeader());
	}

	protected function setBody(Customweb_Core_Http_Request $request){
		$payload = $this->getPayload();
		if ($this->isJson() && !empty($payload)) {
			$payload = json_encode($payload);
		}
		$request->setBody($payload);
	}

	/**
	 * Creates the merchant http authorization.
	 *
	 * @return Customweb_Core_Http_Authorization_Basic
	 */
	protected function getAuthorization(){
		$authorization = new Customweb_Core_Http_Authorization_Basic();
		$authorization->setUsername($this->key);
		return $authorization;
	}

	private function getPhpVersionHeader(){
		return "PHP-VERSION: " . phpversion();
	}

	private function getSdkVersionHeader(){
		return "SDK-VERSION: 1.0.85";
	}

	private function getSdkTypeHeader(){
		return "SDK-TYPE: customweb/sellxed";
	}
}