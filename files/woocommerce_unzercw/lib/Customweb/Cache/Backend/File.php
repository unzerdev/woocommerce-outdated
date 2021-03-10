<?php 

require_once 'Customweb/Cache/IBackend.php';


class Customweb_Cache_Backend_File implements Customweb_Cache_IBackend {
	
	private $folderPath = null;
	
	public function __construct($folder) {
		$this->folderPath = rtrim($folder, ' /');
	}

	public function initialize() {
		if (!file_exists($this->folderPath . '/')) {
			throw new Exception("The folder with path '" . $this->folderPath . "' does not exists.");
		}
	}
	
	public function keyExists($key) {
		$path = $this->getPath($key);
		return file_exists($path);
	}
	
	public function put($key, $value) {
		$path = $this->getPath($key);
		$value = serialize($value);
		
		$fp = fopen($path, "w");
		
		if (flock($fp, LOCK_EX)) {
			ftruncate($fp, 0);
			fwrite($fp, $value);
			flock($fp, LOCK_UN);
			fclose($fp);
		}
		else {
			fclose($fp);
			throw new Exception("Unable to get write lock on file '" . $path . "'.");
		}
	}
	
	public function get($key) {
		$path = $this->getPath($key);
		
		if (!file_exists($path)) {
			return null;
		}
		else {
			$fp = fopen($path, "r");
			if (flock($fp, LOCK_SH)) {
				$contents = '';
				$size = filesize($path);
				while (!feof($fp)) {
					$contents .= fread($fp, $size);
				}
				$rs = unserialize($contents);
				flock($fp, LOCK_UN);
				fclose($fp);
				return $rs;
			}
			else {
				fclose($fp);
				throw new Exception("Unable to get write lock on file '" . $path . "'.");
			}
		}
	}
	
	protected function getPath($key) {
		return $this->folderPath . '/' . md5($key);
	}
	
	public function clear() {
		self::$storage = array();
	}
	
}