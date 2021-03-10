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
 * This file can be used to include all required files. This is only
 * required if you do not setup a autoloader which loads automatically
 * the classes depending on their names.
 */
$pathToLib = realpath(dirname(__FILE__));
set_include_path(implode(PATH_SEPARATOR, array(
	get_include_path(),
	$pathToLib,
)));

// Some server configuration disallow the changing of the include path. We have 
// to provide here a better error message, than simply wait until a require fails.
if (strpos(get_include_path(), $pathToLib) === false) {
	die("The include path could not be changed. Please change the server configuration to allow changing the include path by using the function 'set_include_path'.");
}

if (!function_exists("library_load_class_by_name")) {

	require_once 'Customweb/Core/Util/Class.php';

	/**
	 * This function loads a class from the library. It resolves the path and
	 * checks if the given class does not already exists in the program
	 * space.
	 *
	 * @param string $className The name of the class
	 * @throws Exception When the given class could not be resolved to a file.
	 * @return boolean True if the class was loaded newly. False if the class
	 * already exists.
	 * @deprecated Use Instead Customweb_Core_Util_Class
	 */
	function library_load_class_by_name($className) {
		return Customweb_Core_Util_Class::loadLibraryClassByName($className);
	}

	/**
	 * This function checks if a given file exists in the include path or not.
	 *
	 * @param string $fileName
	 * @return boolean True if the file exists. False if the file does not exists.
	 * @deprecated Use Instead Customweb_Core_Util_Class
	 */
	function library_load_check_if_file_exists_on_include_path($fileName) {
		return Customweb_Core_Util_Class::isLibraryClassFileExisting($fileName);
	}
}
