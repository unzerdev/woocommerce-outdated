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
 * This util produces random strings.
 *
 * @author Thomas Hunziker
 */
final class Customweb_Core_Util_Rand {

	private function __construct() {
	}

	private static $listOfChars = array(
		'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M',
		'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
		'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l',
		'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x',
		'y', 'z', '1', '2', '3', '4', '5', '6', '7', '8', '9'
	);

	/**
	 * This method generates a random string. The $length indicates
	 * the length of the resulting string. The $charsToExclude indicates
	 * which of the elements are not used. By default 'l', 'i' and '1' are
	 * not used.
	 *
	 * @param integer $length
	 * @param string $charsToExclude
	 * @return string Random string
	 */
	public static function getRandomString($length, $charsToExclude = 'li1' ) {
		$characters = array();
		foreach (self::$listOfChars as $char) {
			if (!strstr($charsToExclude, $char)) {
				$characters[] = $char;
			}
		}

		$numberOfCharacters = count($characters);
		$code = '';
		for ($c = 0; $c < $length; $c++) {
			$randIndex = mt_rand(0, $numberOfCharacters-1);
			$code .= $characters[$randIndex];
		}

		return $code;
	}

	public static function getUuid() {
		mt_srand(self::generateSeed());
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
			mt_rand( 0, 0x0fff ) | 0x4000,
			mt_rand( 0, 0x3fff ) | 0x8000,
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ) );
	}

	/**
	 * Generate seed.
	 *
	 * @return integer
	 */
	private static function generateSeed(){

		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			if (function_exists('mcrypt_create_iv') && function_exists('class_alias')) {
				$in = @mcrypt_create_iv(16);
		   		return current(unpack('L', $in));
			}
			if (function_exists('openssl_random_pseudo_bytes') && version_compare(PHP_VERSION, '5.3.4', '>=')) {
				return current(unpack('L', openssl_random_pseudo_bytes(16)));
			}
		}
		else {
			// method 1. the fastest
			if (function_exists('openssl_random_pseudo_bytes')) {
				return current(unpack('L', openssl_random_pseudo_bytes(16)));
			}
			// method 2
			static $fp = true;
				if ($fp === true) {
					// warning's will be output unles the error suppression operator is used. errors such as
					// "open_basedir restriction in effect", "Permission denied", "No such file or directory", etc.
					$fp = @fopen('/dev/urandom', 'rb');
				}
				if ($fp !== true && $fp !== false) { // surprisingly faster than !is_bool() or is_resource()
					return current(unpack('L', fread($fp, 16)));
				}
			// method 3. pretty much does the same thing as method 2 per the following url:
			// https://github.com/php/php-src/blob/7014a0eb6d1611151a286c0ff4f2238f92c120d6/ext/mcrypt/mcrypt.c#L1391
			// surprisingly slower than method 2. maybe that's because mcrypt_create_iv does a bunch of error checking that we're
			// not doing. regardless, this'll only be called if this PHP script couldn't open /dev/urandom due to open_basedir
			// restrictions or some such
			if (function_exists('mcrypt_create_iv')) {
				return current(unpack('L', mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)));
			}
		}

		// save old session data
		$old_session_id = session_id();
		$old_use_cookies = ini_get('session.use_cookies');
		$old_session_cache_limiter = session_cache_limiter();

		// In some environments the session_save_path is not working. Hence we can't use it.
		$session_save_path = session_save_path();
		if (@file_exists($session_save_path) && @is_writable($session_save_path)) {

			$_OLD_SESSION = isset($_SESSION) ? $_SESSION : false;
			if ($old_session_id != '') {
				session_write_close();
			}

			session_id(1);
			ini_set('session.use_cookies', 0);
			session_cache_limiter('');
			session_start();

            $seed = $_SESSION['seed'] = pack('H*',
                sha1(
                    microtime(true) .
                    (isset($_SERVER) ? self::safe_serialize($_SERVER) : '') .
                    (isset($_POST) ? self::safe_serialize($_POST) : '') .
                    (isset($_GET) ? self::safe_serialize($_GET) : '') .
                    (isset($_COOKIE) ? self::safe_serialize($_COOKIE) : '') .
                    self::safe_serialize($GLOBALS) .
                    self::safe_serialize($_SESSION) .
                    self::safe_serialize($_OLD_SESSION))
            );
			if (!isset($_SESSION['count'])) {
				$_SESSION['count'] = 0;
			}
			$_SESSION['count']++;

			session_write_close();

			// restore old session data
			if ($old_session_id != '') {
				session_id($old_session_id);
				session_start();
				ini_set('session.use_cookies', $old_use_cookies);
				session_cache_limiter($old_session_cache_limiter);
			}
			else {
				if ($_OLD_SESSION !== false) {
					$_SESSION = $_OLD_SESSION;
					unset($_OLD_SESSION);
				}
				else {
					unset($_SESSION);
				}
			}
			return current(unpack('L', $seed));
		}
		else {

			$seed = $_SESSION['seed'] = pack('H*',
                sha1(
                    microtime(true) .
                    (isset($_SERVER) ? self::safe_serialize($_SERVER) : '') .
                    (isset($_POST) ? self::safe_serialize($_POST) : '') .
                    (isset($_GET) ? self::safe_serialize($_GET) : '') .
                    (isset($_COOKIE) ? self::safe_serialize($_COOKIE) : '') .
                    self::safe_serialize($GLOBALS) .
                    self::safe_serialize($_SESSION))
            );
			return current(unpack('L', $seed));
		}
	}

    /**
     * Safely serialize variables
     *
     * If a class has a private __sleep() it'll emit a warning
     * @return mixed
     * @param mixed $value
     */
    private static function safe_serialize(&$value)
    {
        try {
            if (is_object($value)) {
                return '';
            }
            if (!is_array($value)) {
                return serialize($value);
            }
            // prevent circular array recursion
            if (isset($value['__php_array_marker'])) {
                return '';
            }
            $safe_array                  = array();
            $value['__php_array_marker'] = true;
            foreach (array_keys($value) as $key) {
                // do not recurse on the '__php_array_marker' key itself, for smaller memory usage
                if ($key !== '__php_array_marker') {
                    $safe_array[$key] = self::safe_serialize($value[$key]);
                }
            }
            unset($value['__php_array_marker']);
            return serialize($safe_array);
        } catch (\Exception $e){

        }
        return '';
    }


}