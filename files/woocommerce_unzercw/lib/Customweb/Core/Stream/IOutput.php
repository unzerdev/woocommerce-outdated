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
 * An ouput stream allows to write data. The data may be written
 * to different targets (file, network, standard output etc). 
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Core_Stream_IOutput {
	
	/**
	 * Closes the stream for further write operations.
	 * 
	 * @throws Customweb_Core_Stream_IOException
	 * @return void
	 */
	public function close();
	
	/**
	 * Indicates if the stream is ready to write to.
	 * 
	 * @return boolean
	 */
	public function isReady();
	
	/**
	 * Write data to the stream. 
	 * 
	 * @param string $data
	 * @throws Customweb_Core_Stream_IOException
	 */
	public function write($data);
	
	/**
	 * Writes the given input stream to the output stream.
	 * 
	 * @param Customweb_Core_Stream_IInput $inputStream
	 * @throws Customweb_Core_Stream_IOException
	 */
	public function writeStream(Customweb_Core_Stream_IInput $inputStream);

	/**
	 * Writes any data in the buffer.
	 * 
	 * @throws Customweb_Core_Stream_IOException
	 */
	public function flush();

	/**
	 * Returns the mime type of the input stream.
	 *
	 * @return string
	 */
	public function getMimeType();
}