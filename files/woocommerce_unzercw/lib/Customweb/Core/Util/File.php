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
 * Collection of Util method to handle files and directories.
 *
 * @author Thomas Hunziker
 */
final class Customweb_Core_Util_File {

	private function __construct(){}

	/**
	 * This method removes a given folder recursively.
	 * 
	 * @param string $dir Path to the dir.
	 * @return boolean
	 */
	public static function removeDirectoryRecursively($dir){
		if (!is_dir($dir) || is_link($dir)) {
			return unlink($dir);
		}
		foreach (scandir($dir) as $file) {
			if ($file == '.' || $file == '..')
				continue;
			if (!self::removeDirectoryRecursively($dir . DIRECTORY_SEPARATOR . $file)) {
				chmod($dir . DIRECTORY_SEPARATOR . $file, 0777);
				if (!self::removeDirectoryRecursively($dir . DIRECTORY_SEPARATOR . $file)) {
					return false;
				}
			}
		}
		return rmdir($dir);
	}
}