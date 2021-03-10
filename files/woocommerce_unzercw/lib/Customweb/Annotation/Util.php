<?php

require_once 'Customweb/Annotation/DocComment.php';
require_once 'Customweb/Annotation/ReflectionAnnotatedMethod.php';
require_once 'Customweb/Annotation/ReflectionAnnotatedProperty.php';


class Customweb_Annotation_Util {
	private static $rawMode;
	private static $ignore;
	private static $classnames = array();
	private static $checkedClasses = array();
	private static $annotations = array();

	public static function getDocComment($reflection){
		if (self::checkRawDocCommentParsingNeeded()) {
			$docComment = new Customweb_Annotation_DocComment();
			
			return $docComment->get($reflection);
		}
		
		return $reflection->getDocComment();
	}

	public static function register($name, $className){
		self::$classnames[$name] = $className;
	}

	/**
	 * Raw mode test
	 */
	private static function checkRawDocCommentParsingNeeded(){
		if (self::$rawMode === null) {
			$reflection = new ReflectionClass('Customweb_Annotation_Util');
			$method = $reflection->getMethod('checkRawDocCommentParsingNeeded');
			self::setRawMode($method->getDocComment() === false);
		}
		
		return self::$rawMode;
	}

	public static function setRawMode($enabled = true){
		self::$rawMode = $enabled;
	}

	public static function resetIgnoredAnnotations(){
		self::$ignore = array();
	}

	public static function ignores($class){
		return isset(self::$ignore[$class]);
	}
	
	

	public static function createName($target){
		if ($target instanceof Customweb_Annotation_ReflectionAnnotatedMethod) {
			return $target->getDeclaringClassName() . '::' . $target->getName();
		} elseif ($target instanceof Customweb_Annotation_ReflectionAnnotatedProperty) {
			return $target->getDeclaringClassName() . '::$' . $target->getName();
		} elseif ($target instanceof ReflectionMethod) {
			return $target->getDeclaringClass()->getName() . '::' . $target->getName();
		} elseif ($target instanceof ReflectionProperty) {
			return $target->getDeclaringClass()->getName() . '::$' . $target->getName();
		} else {
			return $target->getName();
		}
	}
	
	
	public static function ignore(){
		foreach (func_get_args() as $class) {
			self::$ignore[$class] = true;
		}
	}

	public static function resolveClassName($class){
		if (isset(self::$classnames[$class])) {
			return self::$classnames[$class];
		}
		
		$matching = array();
		foreach (self::getDeclaredAnnotations() as $declared) {
			if ($declared == $class) {
				$matching[] = $declared;
			} else {
				$pos = strrpos($declared, "_$class");
				
				if ($pos !== false && ($pos + strlen($class) == strlen($declared) - 1)) {
					$matching[] = $declared;
				}
			}
		}
		
		$result = null;
		switch (count($matching)) {
			case 0:
				$result = $class;
				break;
			case 1:
				$result = $matching[0];
				break;
			default:
				throw new Exception("Cannot resolve class name for '$class'. Possible matches: " . join(', ', $matching));
		}
		
		self::$classnames[$class] = $result;
		
		return $result;
	}

	private static function getDeclaredAnnotations(){
		foreach (get_declared_classes() as $class) {
			if (!isset(self::$checkedClasses[$class])) {
				// We can't use 'is_subclass_of', because in certain PHP version their is a bug, which does not
				// recognise interfaces as subclasses.
				try {
					$reflectionA = new ReflectionClass($class);
				}
				catch(Exception $e) {
					self::$checkedClasses[$class] = true;
					continue;
				}
				if ($reflectionA->implementsInterface('Customweb_IAnnotation')) {
					self::$annotations[] = $class;
				}
				self::$checkedClasses[$class] = true;
			}
		}
		
		return self::$annotations;
	}
}
