<?php 



class Customweb_Cache_Handler {
	
	private $backend;
	
	public function __construct(Customweb_Cache_IBackend $backend) {
		$this->backend = $backend;
		$backend->initialize();
	}
	
	public function put($key, $value) {
		return $this->getBackend()->put($key, $value);
	}
	
	public function get($key) {
		return $this->getBackend()->get($key);
	}

	public function clear() {
		return $this->getBackend()->clear();
	}
	
	/**
	 * @return Customweb_Cache_IBackend
	 */
	protected function getBackend(){
		return $this->backend;
	}
	
}