<?php 



interface Customweb_Cache_IBackend {

	public function initialize();
	
	public function keyExists($key);
	
	public function put($key, $value);
	
	public function get($key);
	
	public function clear();
	
}