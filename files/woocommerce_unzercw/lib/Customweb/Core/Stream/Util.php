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

require_once 'Customweb/Core/Stream/Input/File.php';
require_once 'Customweb/Core/Util/System.php';
require_once 'Customweb/Core/Stream/Output/File.php';



/**
 * Provides some method to handle streams.
 *
 * @author Thomas Hunziker
 *
 */
final class Customweb_Core_Stream_Util {
	const TEMP_PATH_PREFIX = 'tmp_stream_files';

	/**
	 * This method converts a given input stream into a local file if required and return the
	 * path to the local file.
	 *
	 * @param Customweb_Core_Stream_IInput $inputStream
	 */
	public static function getLocalFilePath(Customweb_Core_Stream_IInput $inputStream){
		// In case we get a file input stream, we can simply return the path of the
		// file.
		if ($inputStream instanceof Customweb_Core_Stream_Input_File) {
			return $inputStream->getFilePath();
		}
		
		// We need to append the current file location as sha1 of this file, otherwise eventually the same folder is 
		// used by multiple users on the same server, which eventually leads to some problems with the file permissions.
		$tempDir = Customweb_Core_Util_System::getTemporaryDirPath() . self::TEMP_PATH_PREFIX . sha1(__FILE__);
		if (!file_exists($tempDir)) {
			mkdir($tempDir, 0770, true);
		}
		
		// Make sure we get a identifier which does not cause any issues on file system:
		$fileName = sha1($inputStream->getSystemIdentifier());
		if (preg_match('/^[0-9]/i', $fileName)) {
			$fileName = 'd' . $fileName;
		}
		
		
		$output = new Customweb_Core_Stream_Output_File($tempDir . DIRECTORY_SEPARATOR . $fileName);
		$output->writeStream($inputStream);
		
		return $output->getFilePath();
	}
}