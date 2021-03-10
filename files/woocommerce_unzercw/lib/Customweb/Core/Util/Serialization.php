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

require_once 'Customweb/Core/Util/Class.php';

/**
 * This Util class allows a convient way to serialize and unserialize of
 * objects.
 *
 * In case of unserializing the class checks if any class must be loaded. In
 * case a class is not loaded the method tries to load it with the library
 * class loader. In case this does not work, the registred callbacks are called.
 *
 * @author Thomas Hunziker / Simon Schurter
 *
 */
final class Customweb_Core_Util_Serialization {

	private function __construct() {}

	/**
	 * Serializes a object into a string representation.
	 *
	 * @param object $object
	 * @return string
	 */
	public static function serialize($object) {
		return base64_encode(serialize($object));
	}

	/**
	 * Unserializes a object from a string representation produced by
	 * Serialization::serialize().
	 *
	 * @param string $data
	 * @return mixed
	 * @throws Customweb_Core_Exception_ClassNotFoundException
	 */
	public static function unserialize($data) {
		$serializedString = base64_decode($data);
		self::preloadClasses($serializedString);
		return unserialize($serializedString);
	}

	/**
	 * Serializes a object into a binary representation using gzcompress.
	 *
	 * @param object $object
	 * @return String (binary)
	 */
	public static function serializeBinary($object){
		return gzcompress(serialize($object));
	}

	/**
	 * Unserializes a object from a binary representation produced by
	 * Serialization::serializeBinary().
	 *
	 * @param String $data (binary)
	 * @return mixed
	 * @throws Customweb_Core_Exception_ClassNotFoundException
	 */
	public static function unserializeBinary($data) {
		Customweb_Core_Util_Error::startErrorHandling();
		$serializedString = gzuncompress($data);
		Customweb_Core_Util_Error::endErrorHandling();
		self::preloadClasses($serializedString);
		return unserialize($serializedString);
	}

	/**
	 * @param string $serializedString
	 * @throws Customweb_Core_Exception_ClassNotFoundException
	 */
	private static function preloadClasses($serializedString) {
		$matches = array();
		preg_match_all('/O:[0-9]+:\"(.+?)\":/', self::cleanStringPartsOut($serializedString), $matches);
		if (isset($matches[1])) {
			foreach ($matches[1] as $match) {
				$className = $match;
				if (!Customweb_Core_Util_Class::isClassLoaded($className)) {
					try {
						Customweb_Core_Util_Class::loadLibraryClassByName($className);
					}
					catch(Customweb_Core_Exception_ClassNotFoundException $e) {
						if (!class_exists($className)) {
							throw $e;
						}
					}
				}
			}
		}
	}

	/**
	 * This method removes all string parts within the serialized string (i.e. all string properties). This is required because the
	 * serialized string may contain an object which has a string property which contains again serialized
	 * data. In this situation we would search for classes in the string which may never required, because
	 * during the deserialization the class is never instantiated and as such we may load a class which is
	 * not required.
	 *
	 * @param string $serializedString
	 * @throws Exception thrown when the provided serialized string is invalid.
	 * @return string the cleaned string.
	 */
	private static function cleanStringPartsOut($serializedString) {
		$cleaner = new Customweb_Core_Util_SerializationCleaner($serializedString);
		return $cleaner->clean();
	}

}



/**
 * This class is only used for the serializer.
 *
 * The class iterates over the serialized data and removes all content of the serialized strings. We do this so that the regex for getting the class names work properly.
 *
 * @author Thomas Hunziker
 *
 */
final class Customweb_Core_Util_SerializationCleaner {

	private $string;
	private $index = 0;
	private $length;
	private $result = '';

	public function __construct($string) {
		$this->string = $string;
		$this->length = strlen($string);
	}

	public function clean() {
		while ($this->index < $this->length) {
			if ($this->moveForwardToNext("s:")) {
				$numberOfNumericChars = $this->moveForwardUntilNonNummeric();
				if ($numberOfNumericChars === false) {
					throw new Exception("The provided serialized string is invalid. There is indicated a string sequence, however the length is not specified.");
				}
				$lengthOfTheString = substr($this->string, $this->index - $numberOfNumericChars, $numberOfNumericChars);

				// There is always also a colon and two quotes and as such we need to add 3 chars additionally.
				$this->index = $this->index + $lengthOfTheString + 3;
				if ($this->index > $this->length) {
					throw new Exception("The serialized string ends unexpected. Has the serialized string eventually be truncated unintentionally?");
				}
			}
			$this->moveIndex();
		}

		return $this->result;
	}

	private function moveForwardUntilNonNummeric() {
		$length = 0;
		while ($this->index < $this->length) {
			$asciiChar = ord($this->string[$this->index]);
			if ($asciiChar < 48 || $asciiChar > 57) {
				return $length;
			}
			$this->moveIndex();
			$length++;
		}
		return false;
	}


	private function moveForwardToNext($needle) {
		$matchedIndex = 0;
		$endIndex = strlen($needle) ;
		while ($this->index < $this->length) {
			$char = $this->string[$this->index];
			if ($char === $needle[$matchedIndex]) {
				$matchedIndex++;
			}
			else {
				if ($matchedIndex > 0) {
					$matchedIndex = 0;
					continue;
				}
			}
			$this->moveIndex();

			if ($matchedIndex === $endIndex) {
				return true;
			}
		}
		return false;
	}

	private function moveIndex() {
		if ($this->index < $this->length) {
			$this->result .= $this->string[$this->index];
		}
		$this->index++;
	}

}

