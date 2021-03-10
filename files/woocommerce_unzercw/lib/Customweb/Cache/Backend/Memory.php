<?php 

require_once 'Customweb/Cache/IBackend.php';


class Customweb_Cache_Backend_Memory implements Customweb_Cache_IBackend {

	private static $storage = array();
	
	public function initialize() {
		
	}
	
	public function keyExists($key) {
		if (isset(self::$storage[$key])) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public function put($key, $value) {
		self::$storage[$key] = $value;
	}
	
	public function get($key) {
		if (isset(self::$storage[$key])) {
			return self::$storage[$key];
		}
		else {
			return null;
		}
	}
	
	public function clear() {
		self::$storage = array();
	}
	
}