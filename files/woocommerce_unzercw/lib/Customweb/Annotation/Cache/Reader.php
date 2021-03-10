<?php

require_once 'Customweb/Annotation/Parser/AnnotationsMatcher.php';
require_once 'Customweb/Annotation/Util.php';
require_once 'Customweb/Annotation/Cache/Reader.php';

require_once 'Customweb/Annotation/Cache/Annotation.php';

class Customweb_Annotation_Cache_Reader {
	private static $data = null;
	private static $sortByTarget = null;
	private static $scannedIncludePath = null;
	private static $skipCache = false;

	private function __construct(){}

	public static function getAnnotationsByTarget($target){
		$key = Customweb_Annotation_Util::createName($target);
		$data = self::read();
		if (isset($data[$key])) {
			return $data[$key];
		}
		else {
			return array();
		}
	}

	public static function getTargetsByAnnotationName($annotationName){
		$data = self::read();
		if (self::$sortByTarget === null) {
			self::$sortByTarget = array();
			
			foreach ($data as $targetName => $annotations) {
				foreach ($annotations as $annotation) {
					$key = strtolower($annotation->getName());
					if (!isset(self::$sortByTarget[$key])) {
						self::$sortByTarget[$key] = array();
					}
					self::$sortByTarget[$key][] = $targetName;
				}
			}
		}
		
		$key = strtolower($annotationName);
		if (isset(self::$sortByTarget[$key])) {
			return self::$sortByTarget[$key];
		}
		else {
			return array();
		}
	}

	private static function read(){
		if (self::$skipCache) {
			return self::parse();
		}
		else {
			return self::readFromCache();
		}
	}

	private static function readFromCache(){
		if (self::$data === null || self::$scannedIncludePath !== get_include_path()) {
			$reader = new Customweb_Annotation_Cache_Reader();
			self::$data = $reader->loadData();
			self::$sortByTarget = null;
			self::$scannedIncludePath = get_include_path();
		}
		
		return self::$data;
	}

	private static function parse(){
		if (self::$data === null || self::$scannedIncludePath !== get_include_path()) {
			$include_path = explode(PATH_SEPARATOR, get_include_path());
			$files = array();
			foreach ($include_path as $path) {
				if (!file_exists($path)) {
					continue;
				}
				foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $filename) {
					if (substr_compare($filename->getRealPath(), ".php", -4) === 0) {
						$files[$filename->getRealPath()] = $filename->getRealPath();
					}
				}
			}
			self::$data = array();
			$annotations = null;
			foreach ($files as $file) {
				$matcher = new Customweb_Annotation_Parser_AnnotationsMatcher();
				$tokens = token_get_all(file_get_contents($file));
				$max = count($tokens);
				$i = 0;
				while ($i < $max) {
					$token = $tokens[$i];
					if (is_array($token)) {
						list($code, $value) = $token;
						switch ($code) {
							case T_DOC_COMMENT:
								$comment = $value;
								break;
							
							case T_CLASS:
							case T_INTERFACE:
								$class = self::getString($tokens, $i, $max);
								if ($comment !== false) {
									$matcher->matches($comment, $annotations);
									foreach ($annotations as $key => $annotation) {
										self::$data[$class][] = $annotation;
									}
									$comment = false;
								}
								break;
							
							case T_VARIABLE:
								if ($comment !== false) {
									$field = substr($token[1], 1);
									$matcher->matches($comment, $annotations);
									foreach ($annotations as $key => $annotation) {
										self::$data[$class . '::$' . $field][] = $annotation;
									}
									$comment = false;
								}
								break;
							
							case T_FUNCTION:
								if ($comment !== false) {
									$function = self::getString($tokens, $i, $max);
									$matcher->matches($comment, $annotations);
									foreach ($annotations as $key => $annotation) {
										self::$data[$class . '::' . $function][] = $annotation;
									}
									$comment = false;
								}
								break;
							// ignore
							case T_WHITESPACE:
							case T_PUBLIC:
							case T_PROTECTED:
							case T_PRIVATE:
							case T_ABSTRACT:
							case T_FINAL:
							case T_VAR:
							case T_COMMENT:
								break;
							
							default:
								$comment = false;
								break;
						}
					}
					else {
						$comment = false;
					}
					$i++;
				}
			}
			self::$sortByTarget = null;
			self::$scannedIncludePath = get_include_path();
		}
		return self::$data;
		
	}

	private static function getString($tokens, &$i, $max){
		do {
			$token = $tokens[$i];
			$i++;
			if (is_array($token)) {
				if ($token[0] == T_STRING) {
					return $token[1];
				}
			}
		}
		while ($i <= $max);
		
		return false;
	}

	private function loadData(){
		$data = array();
		$files = $this->findAllCacheFiles();
		
		foreach ($files as $file) {
			
			//We ignore any file which we can not unserialize. 
			$unserialized = unserialize(file_get_contents($file));
			if($unserialized === false){
				continue;
			}			
			$data = array_merge($data, $unserialized);
		}
		return $data;
	}

	/**
	 * Searches for all possible cache files.
	 *
	 * @return string[]
	 */
	private function findAllCacheFiles(){
		$folderName = 'Customweb/Annotation/Cache/data/';
		$folderNames = array();
		$include_path = explode(PATH_SEPARATOR, get_include_path());
		foreach ($include_path as $path) {
			$file = realpath($path . '/' . $folderName);
			if (@file_exists($file) && @is_dir($file)) {
				$folderNames[] = $file;
			}
		}
		$files = array();
		foreach ($folderNames as $folderName) {
			if ($handle = opendir($folderName)) {
				while (false !== ($file = readdir($handle))) {
					if (strstr($file, '.php') !== false) {
						$files[] = $folderName . '/' . $file;
					}
				}
				closedir($handle);
			}
		}
		return $files;
	}
	
	public static function skipAnnotationCache($bool = true) {
		self::$skipCache = $bool;
		self::$data = null;
	}
}