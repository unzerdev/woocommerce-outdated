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

require_once 'Customweb/Core/Stream/Input/File.php';
require_once 'Customweb/Core/Url.php';
require_once 'Customweb/Asset/IResolver.php';
require_once 'Customweb/Asset/Exception/UnresolvableAssetException.php';
require_once 'Customweb/Asset/Exception/NonPublicAssetException.php';
require_once 'Customweb/Core/MimeType.php';


class Customweb_Asset_Resolver_Simple implements Customweb_Asset_IResolver {
	
	private $pathPrefix = null;
	
	private $urlPrefix = null;
	
	private $mimeTypes = array();
	
	/**
	 * Constructor
	 * 
	 * @param string $pathPrefix The path prefix to create a file input stream.
	 * @param string $urlPrefix (Optional) The URL prefix to create a URL. If null, the assets are private.
	 * @param array $types (Optional) The mime types supported by this resolver. If non given 
	 */
	public function __construct($pathPrefix, $urlPrefix = null, array $mimeTypes = array()) {
		if (empty($pathPrefix)) {
			throw new Exception("The given path prefix is empty.");
		}
		
		$this->pathPrefix = rtrim($pathPrefix, '/') . '/';
		$this->urlPrefix = $urlPrefix;
		$this->mimeTypes = $mimeTypes;
	}
	
	public function resolveAssetStream($identifier) {
		$filePath = $this->pathPrefix . ltrim($identifier, '/');
		if ($this->isSupportedMimeType($identifier)) {
			if (file_exists($filePath)) {
				return new Customweb_Core_Stream_Input_File($filePath);
			}
		}
		throw new Customweb_Asset_Exception_UnresolvableAssetException($identifier);
	}
	
	protected function isSupportedMimeType($identifier) {
		if (count($this->mimeTypes) <= 0) {
			return true;
		}
		$fileExtension = pathinfo($identifier, PATHINFO_EXTENSION);
		$mimeType = Customweb_Core_MimeType::getMimeType($fileExtension);
		if (in_array($mimeType, $this->mimeTypes)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public function resolveAssetUrl($identifier) {
		$this->resolveAssetStream($identifier);
		if ($this->urlPrefix === null) {
			throw new Customweb_Asset_Exception_NonPublicAssetException($identifier);
		}		
		return new Customweb_Core_Url($this->urlPrefix . $identifier);
	}
	
}