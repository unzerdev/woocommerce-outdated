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
 * This interface defines a input stream. A inputt stream can be used to
 * read in data. Different implementation may use different sources from
 * which the data is read from.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Core_Stream_IInput {

	/**
	 * Closes the stream.
	 * 
	 * @return void
	 */
	public function close();
	
	/**
	 * Indicates wether the stream is ready to read or not.
	 * 
	 * @return boolean
	 */
	public function isReady();
	
	/**
	 * Reads the number bytes indicated by length. In case 
	 * this is 0 the whole stream is read.
	 * 
	 * @param int $length
	 * @return string
	 */
	public function read($length = 0);
	
	/**
	 * Returns true, when the end of the stream is reached.
	 * 
	 * @return boolean
	 */
	public function isEndOfStream();
	
	/**
	 * Move the internal pointer by the number of bytes indicated
	 * by $length.
	 * 
	 * @param int $length
	 */
	public function skip($length);
	
	/**
	 * Returns the mime type of the input stream.
	 * 
	 * @return string
	 */
	public function getMimeType();
	
	/**
	 * Returns a identifier which is unique for the stream. In case the 
	 * content changes the identifier must be changed to. 
	 * 
	 * The primary usage is to allow caching of the stream.
	 * 
	 * @return string
	 */
	public function getSystemIdentifier();
	
}