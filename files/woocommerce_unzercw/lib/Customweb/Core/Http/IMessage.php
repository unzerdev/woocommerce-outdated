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
 * This interface a HTTP message.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Core_Http_IMessage {
	
	/**
	 * Return the first lien of the HTTP message.
	 * 
	 */
	public function getStatusLine();
	
	/**
	 * Returns the protocol version of the response (1.0 or 1.1). 
	 * 
	 * @return string
	 */
	public function getProtocolVersion();
	
	/**
	 * This method returns a list of string, which represents HTTP
	 * headers.
	 * 
	 * @return string[]
	 */
	public function getHeaders();
	
	/**
	 * Returns a key/value map of the headers. The order of the items is not 
	 * preserved. The key is always lower case.
	 *
	 * Sample output:
	 * array(
	 *   'content-type' => array('text/html'),
	 *   'content-length' => array('345'),
	 * )
	 *
	 * @return array
	 */
	public function getParsedHeaders();
	
	/**
	 * Returns the HTTP body.
	 * 
	 * @return string
	 */
	public function getBody();
	
}