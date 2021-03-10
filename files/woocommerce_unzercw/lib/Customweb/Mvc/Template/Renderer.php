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

require_once 'Customweb/Mvc/Template/IRenderer.php';


/**
 * @author Simon Schurter
 * @Bean
 */
abstract class Customweb_Mvc_Template_Renderer implements Customweb_Mvc_Template_IRenderer
{
	/**
	 * @var Customweb_Asset_IResolver
	 */
	private $assetResolver = null;

	/**
	 * @var Customweb_Cache_IBackend
	 */
	private $cacheBackend = null;

	/**
	 * @param Customweb_Asset_IResolver $assetResolver        	
	 * @param Customweb_DependencyInjection_IContainer $container        	
	 */
	public function __construct(Customweb_Asset_IResolver $assetResolver, Customweb_DependencyInjection_IContainer $container)
	{
		$this->assetResolver = $assetResolver;
		if ($container->hasBean('Customweb_Cache_IBackend')) {
			$this->cacheBackend = $container->getBean('Customweb_Cache_IBackend');
		}
	}

	/**
	 * @return Customweb_Asset_IResolver
	 */
	public function getAssetResolver()
	{
		return $this->assetResolver;
	}

	/**
	 * @return Customweb_Cache_IBackend
	 */
	public function getCacheBackend()
	{
		return $this->cacheBackend;
	}
}