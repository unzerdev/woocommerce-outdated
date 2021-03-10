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

require_once 'Customweb/Core/Http/IMessage.php';

/**
 * This interface represents a HTTP request. 
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Core_Http_IRequest extends Customweb_Core_Http_IMessage {
	
	const METHOD_POST = 'post';
	const METHOD_GET = 'get';
	const METHOD_PUT = 'put';
	const METHOD_DELETE = 'delete';
	
	/**
	 * Returns the full qualified URL on which the request is executed.
	 * 
	 * @return string
	 */
	public function getUrl();
	
	/**
	 * Returns the request method (typically GET or POST).
	 * 
	 * @return string
	 */
	public function getMethod();
	
	/**
	 * Returns the HTTP protocol used (typically HTTPS or HTTP).
	 * 
	 * @return string
	 */
	public function getProtocol();
	
	/**
	 * Returns the host on which the request was executed.
	 * 
	 * @return string
	 */
	public function getHost();
	
	/**
	 * Returns the port number of the request.
	 * 
	 * @return int
	 */
	public function getPort();
	
	/**
	 * Returns the path part of the request including the query and fragment..
	 * 
	 * @return string
	 */
	public function getPath();
	
	/**
	 * Returns the query parsed as key/value pairs.
	 * 
	 * @return array
	 */
	public function getParsedQuery();
	
	/**
	 * Returns the query part of the request as string.
	 * 
	 * @return string
	 */
	public function getQuery();

	/**
	 * Returns the body parsed as key/value pairs. In case the body
	 * is empty this method returns an empty array.
	 * 
	 * @return array
	 */
	public function getParsedBody();
	
	/**
	 * Returns the IP address of the remote client.
	 * 
	 * @return string
	 */
	public function getRemoteAddress();
	
	/**
	 * This method returns all parameters (POST and GET) as array.
	 * 
	 * @return array
	 */
	public function getParameters();
	
	/**
	 * Returns a list of cookies. The key of the list is the name of 
	 * the cookie. The value is the value of the cookie.
	 * 
	 * @return array
	 */
	public function getCookies();
	
	/**
	 * This method converts the request into a sendable string representation of the request. This is required when the request is sent through a proxy.
	 *
	 * @param boolean $fullUri if the full URI should be included in the header.
	 */
	public function toSendableString($fullUri);
	
}