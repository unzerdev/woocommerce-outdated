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
 * This interface defines a browser cookie. A browser cookie is 
 * sent along with the HTTP requests in the header. This allows
 * the stateless HTTP protocol to become a state.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Core_Http_ICookie {
	
	const KEY_DOMAIN = 'domain';
	
	const KEY_PATH = 'path';
	
	const KEY_SECURE = 'secure';
	
	const KEY_HTTP_ONLY = 'httponly';
	
	const KEY_EXPIRY_DATE = 'expires';
	
	/**
	 * Returns the time stamp when the cookie expires.
	 * 
	 * @return int
	 */
	public function getExpiryDate();
	
	/**
	 * Returns the name of the cookie.
	 * 
	 * @return string
	 */
	public function getName();
	
	/**
	 * Returns the raw name of the cookie. The set of chars accepted 
	 * by the browsers are limited. Hence the getName() returns a decoded
	 * version of the name. This method returns the encoded version of 
	 * the name.
	 * 
	 * @return string
	 */
	public function getRawName();
	
	/**
	 * Returns the value of the cookie.
	 * 
	 * @return string
	 */
	public function getValue();
	
	/**
	 * Returns the raw value of the cookie. The set of chars accepted 
	 * by the browsers are limited. Hence the getValue() returns a decoded
	 * version of the value. This method returns the encoded version of 
	 * the value.
	 * 
	 * @return string
	 */
	public function getRawValue();
	
	/**
	 * Returns the domain on which the cookie is valid.
	 * 
	 * @return string
	 */
	public function getDomain();
	
	/**
	 * Returns the path on which the cookie is valid.
	 * 
	 * @return string
	 */
	public function getPath();
	
	/**
	 * Indicates if the cookie requires a secure connection. It is only returned
	 * to the server when a secure connection is used.
	 * 
	 * @return boolean
	 */
	public function isSecure();
	
	/**
	 * Indicates if the cookie should only be used with HTTP and not with HTTPS.
	 * 
	 * @return boolean
	 */
	public function isHttpOnly();
	
}