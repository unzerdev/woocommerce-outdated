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




/**
 * Can cache a given result for later use and clear it from the cache.
 *
 * @author Sebastian Bossert
 */
interface Customweb_Payment_Cache_ICacheHandler {

	/**
	 * Retrieves a result from the cache or from a live source.
	 *
	 * @param string $key The identifier which is used to identify the result in the cache
	 * @param array $parameters
	 *
	 * @return object Cached result or live result, depending on timeout state
	 */
	function getResult($key, array $parameters);

	/**
	 * Tries to retrieve the cached result without automatically calling the callback if null is found.
	 * Timed out requests also return null.
	 *
	 * @param string $key
	 *
	 * @return object Cached result or null
	 */
	function getCachedResult($key);

	/**
	 * Removes a given key from the cache.
	 *
	 * @param string $key The identifier which is used to identify the result in the cache
	 */
	public function clearResult($key);
}