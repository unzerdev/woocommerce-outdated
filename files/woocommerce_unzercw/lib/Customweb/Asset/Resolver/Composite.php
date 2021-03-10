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

require_once 'Customweb/Asset/IResolver.php';
require_once 'Customweb/Asset/Exception/UnresolvableAssetException.php';


class Customweb_Asset_Resolver_Composite implements Customweb_Asset_IResolver {
	
	/**
	 * @var Customweb_Asset_IResolver[]
	 */
	private $resolvers = array();
	
	public function __construct(array $resolvers) {
		$this->resolvers = $resolvers;
	}
	
	public function resolveAssetStream($identifier) {
		foreach ($this->resolvers as $resolver) {
			try {
				return $resolver->resolveAssetStream($identifier);
			}
			catch(Customweb_Asset_Exception_UnresolvableAssetException $e) {
				// ignore 
			}
		}
		throw new Customweb_Asset_Exception_UnresolvableAssetException($identifier);
	}

	public function resolveAssetUrl($identifier) {
		foreach ($this->resolvers as $resolver) {
			try {
				return $resolver->resolveAssetUrl($identifier);
			}
			catch(Customweb_Asset_Exception_UnresolvableAssetException $e) {
				// ignore
			}
		}
		throw new Customweb_Asset_Exception_UnresolvableAssetException($identifier);
	}
}