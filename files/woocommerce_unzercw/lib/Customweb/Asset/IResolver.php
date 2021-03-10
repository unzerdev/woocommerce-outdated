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




interface Customweb_Asset_IResolver {
	
	
	/**
	 * Returns a input stream of the asset.
	 * 
	 * @param string $identifier
	 * @throws Customweb_Asset_Exception_UnresolvableAssetException
	 * @return Customweb_Core_Stream_IInput
	 */
	public function resolveAssetStream($identifier);
	
	/**
	 * Returns a URL to the asset. In case th
	 * 
	 * @param string $identifier
	 * @return Customweb_Core_Url
	 * @throws Customweb_Asset_Exception_UnresolvableAssetException
	 * @throws Customweb_Asset_Exception_NonPublicAssetException
	 */
	public function resolveAssetUrl($identifier);
	
	
}