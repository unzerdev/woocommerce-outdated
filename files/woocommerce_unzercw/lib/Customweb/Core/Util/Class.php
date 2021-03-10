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

require_once 'Customweb/Core/Exception/ClassNotFoundException.php';
require_once 'Customweb/Core/Exception/ResourceNotFoundException.php';
require_once 'Customweb/Core/Exception/FileNotFoundException.php';
require_once 'Customweb/Core/Util/Error.php';


/**
 * Util to handle the class inclusion. It provides also method
 * to check whether a class is loaded or not.
 *
 * @author Simon Schurter / Thomas Hunziker
 *
 */
final class Customweb_Core_Util_Class
{
	private static $classHierarchies = array();
	private static $typeHierarchies = array();

	private static $classLoaderCallbacks = array();

	private static $resourceResolverCallbacks = array();

	private function __construct() {

	}


	/**
	 * This method loads a given class over the include path.
	 *
	 * @param string $className
	 * @throws Customweb_Core_Exception_ClassNotFoundException
	 * @return boolean True, when the class was loaded newly. False, when the class was already loaded.
	 */
	public static function loadLibraryClassByName($className)
	{
		if (!self::isClassLoaded($className)) {

			foreach (self::$classLoaderCallbacks as $callback) {
				$rs = call_user_func($callback, $className);
				if ($rs === true) {
					break;
				}
			}

			if (!self::isClassLoaded($className)) {
				$fileName = str_replace('_', DIRECTORY_SEPARATOR, $className);
				$fileName .= '.php';

				// In case the class was not loadable also over the callback, then we throw an exception
				if (!self::isLibraryClassFileExisting($fileName)) {
					throw new Customweb_Core_Exception_ClassNotFoundException($className);
				}
				require_once $fileName;
			}

			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Reads a resource on the include path. The relativeClassName indicates
	 * the class related to the resource. The resourceFile is the concrete file
	 * requested.
	 *
	 * In case no resource resolver is registered all underlines in
	 * the $relativeClassName are replaced with a slash and the $resourceFile
	 * is appended.
	 *
	 * @param string $relativeClassName
	 * @param string $resourceFile
	 * @throws Customweb_Core_Exception_ResourceNotFoundException
	 * @return string
	 */
	// TODO: Add method to read resource as input stream
	public static function readResource($relativeClassName, $resourceFile) {

		$content = null;
		foreach (self::$resourceResolverCallbacks as $callback) {
			$content = call_user_func($callback, $relativeClassName, $resourceFile);
			if ($content !== false && $content !== null) {
				break;
			}
		}

		if ($content === null) {
			$includePathName = str_replace('_', '/', $relativeClassName) . '/' . $resourceFile;
			try {
				$absoluteFilePath = self::resolveFileOnIncludePath($includePathName);
				$content = file_get_contents($absoluteFilePath);
			}
			catch(Customweb_Core_Exception_FileNotFoundException $e) {
				throw new Customweb_Core_Exception_ResourceNotFoundException($relativeClassName, $resourceFile);
			}
		}

		return $content;
	}

	/**
	 * Checks whether a class is loaded or not.
	 *
	 * @param string $className
	 * @return boolean
	 */
	public static function isClassLoaded($className) {
		return class_exists($className, false) || interface_exists($className, false);
	}

	/**
	 * Searchs the include path for a given file.
	 *
	 * @param string $fileName
	 * @return boolean True, when the file can be resolved over the include path.
	 */
	public static function isLibraryClassFileExisting($fileName)
	{
		try {
			self::resolveFileOnIncludePath($fileName);
			return true;
		}
		catch(Customweb_Core_Exception_FileNotFoundException $e) {
			return false;
		}
	}

	/**
	 * This loades all classes on the include path with the given package.
	 *
	 * @param string $packageName
	 * @return string[] List of found classes
	 */
	public static function loadAllClassesOfPackage($packageName) {

		$packageName = trim($packageName, ' _');

		$packagePath = str_replace('_', DIRECTORY_SEPARATOR, $packageName);
		$include_path = explode(PATH_SEPARATOR, get_include_path());
		$classes = array();
		Customweb_Core_Util_Error::deactivateErrorMessages();
		foreach($include_path as $path) {
			$file = realpath($path . DIRECTORY_SEPARATOR . $packagePath);
			$phpFile = realpath($path . DIRECTORY_SEPARATOR . $packagePath . '.php');
			if(@file_exists($file)) {
				if (@is_dir($file)) {
					$classes = array_merge($classes, self::loadAllClassesOfDirectory($file, $packageName));
				}
			}
			else if (@file_exists($phpFile)) {
				$className = $packageName;
				if (!isset($classes[$className]) && !self::isClassLoaded($className)) {
					Customweb_Core_Util_Error::activateErrorMessages();
					require_once $phpFile;
					Customweb_Core_Util_Error::deactivateErrorMessages();
				}
				$classes[$className] = $className;
			}
		}
		Customweb_Core_Util_Error::activateErrorMessages();

		return $classes;
	}

	/**
	 * To deserialize an object the corresponding class must be loaded. This method
	 * allows the registration of a callback, which is called in case the class was
	 * not loaded and the class was not loadable over the library inclusion mechanism.
	 *
	 * The callback has to accept as the first argument the class name to be loaded. In
	 * case the callback returns true, then no other class loader is called.
	 *
	 * @param callable $callback
	 */
	public static function registerClassLoader($callback) {
		if (is_callable($callback, false)) {
			self::$classLoaderCallbacks[] = $callback;
		}
		else {
			throw new Exception("The given callback is not a valid.");
		}
	}

	/**
	 * Resources may be resolved. With this method you can register a custom
	 * handler for resolving resources on the include path.
	 *
	 * The given call may return a string which contains the resource
	 * contents. In case the resource can not be resolved the callback may
	 * return NULL.
	 *
	 * @param callable $callback
	 */
	public static function registerResourceResolver($callback) {
		if (is_callable($callback, false)) {
			self::$resourceResolverCallbacks[] = $callback;
		}
		else {
			throw new Exception("The given callback is not a valid.");
		}
	}

	private static function loadAllClassesOfDirectory($directory, $packageName) {

		// Prevent reading of SVN directories. SVN may place in each folder a sub folder
		// with PHP files in it. This can cause issues by loading classes twice.
		if (strpos($directory, '.svn') !== false) {
			return array();
		}

		$classes = array();
		if ($handle = opendir($directory)) {
			while (false !== ($file = readdir($handle))) {
				if (substr($file, -4) === '.php') {
					$className = $packageName . '_' . substr($file, 0, -4);
					if (!isset($classes[$className]) && !self::isClassLoaded($className)) {
						require_once $directory . DIRECTORY_SEPARATOR . $file;
					}
					$classes[$className] = $className;
				}
				else if ($file !== '..' && $file !== '.' && is_dir($directory . DIRECTORY_SEPARATOR . $file)) {
					$classes = array_merge($classes, self::loadAllClassesOfDirectory($directory . DIRECTORY_SEPARATOR . $file, $packageName . '_' . $file));
				}
			}
			closedir($handle);
		}

		return $classes;
	}

	/**
	 * Resolves the given file name over the include path. In case the file could not
	 * be found the method throws an exception.
	 *
	 * @param string $fileName
	 * @throws Customweb_Core_Exception_FileNotFoundException
	 * @return string The absolute path to the file.
	 */
	public static function resolveFileOnIncludePath($fileName)
	{
		if(function_exists('stream_resolve_include_path')) {
			if (($path = stream_resolve_include_path($fileName)) === false) {
				throw new Customweb_Core_Exception_FileNotFoundException($fileName);
			}
			else {
				return $path;
			}
		}
		else {
			$include_path = explode(PATH_SEPARATOR, get_include_path());
			Customweb_Core_Util_Error::deactivateErrorMessages();
			foreach($include_path as $path) {
				$file = realpath($path . DIRECTORY_SEPARATOR . $fileName);
				if(@file_exists($file)) {
					return $file;
				}
			}
			Customweb_Core_Util_Error::activateErrorMessages();
			throw new Customweb_Core_Exception_FileNotFoundException($fileName);
		}
	}

	/**
	 * This method gets all types (Parent classes and Interfaces) of a class.
	 *
	 * @param string $className
	 * @return string[] List of class names
	 */
	public static function getAllTypes($className) {

		$key = strtolower($className);
		if (!isset(self::$typeHierarchies[$key])) {
			self::loadLibraryClassByName($className);

			$types = array();
			$classes = self::getParentReflectionClasses($className);
			$classes[] = new ReflectionClass($className);

			foreach ($classes as $class) {
				$types[] = $class->getName();
				$types = array_merge($types, $class->getInterfaceNames());
			}
			self::$typeHierarchies[$key] = $types;
		}

		return self::$typeHierarchies[$key];
	}

	/**
	 * This method returns a list of class names, which are parent classes of the given
	 * class name.
	 *
	 * @param string $className
	 * @return string[]
	 */
	public static function getParentClasses($className) {
		$key = strtolower($className);
		if (!isset(self::$classHierarchies[$key])) {
			self::$classHierarchies[$key] = array();
			$parents = self::getParentReflectionClasses($className);
			foreach($parents as $parent) {
				self::$classHierarchies[$key][] = $parent->getName();
			}
		}
		return self::$classHierarchies[$key];
	}

	/**
	 * This method returns the root class name. The root class is the class which does not inherit from
	 * another class in the class hierarchy. In case the given class name is the root class this method
	 * will return the given class name.
	 *
	 * @param string $className
	 * @return string
	 */
	public static function getRootClassName($className) {
		$parentClasses = self::getParentClasses($className);
		if (count($parentClasses) > 0) {
			return end($parentClasses);
		}
		else {
			return $className;
		}
	}


	/**
	 * This method returns a list of class names, which are parent classes of the given
	 * class name.
	 *
	 * @param string $className
	 * @return ReflectionClass[]
	 */
	public static function getParentReflectionClasses($className) {
		self::loadLibraryClassByName($className);
		$reflection = new ReflectionClass($className);
		$parents = array();
		while ($parent = $reflection->getParentClass()) {
			$parents[] = $parent;
			$reflection = $parent;
		}

		return $parents;
	}


}
