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

require_once 'Customweb/I18n/LocalizableString.php';

/**
 * This class provides an interface to translate messages to the language
 * of the user. To translate something the static method __() can be used.
 * 
 * Example:
 *   Customweb_I18n_Translation::__(
 *   	"My message with some parameter !parameter", 
 *   	array('!parameter' => 'My Parameter')
 *   );
 * 
 * In this example the !parameter is replaced with the string 'My Parameter'. 
 * The leading bang char indicates that the parameter is replaced as given. 
 * If you want to escape any html tag you can use a leading @ char. 
 * 
 * To integrate the translation service into your application you can implement
 * a Customweb_I18n_ITranslationResolver.
 * 
 * The implemenation can be set by invoking Customweb_I18n_Translation->getInstance()->setResolvers();
 * 
 * 
 * @author Thomas Hunziker
 *
 */
final class Customweb_I18n_Translation {
	
	/**
	 * @var Customweb_I18n_Translation
	 */
	private static $instance;
	
	/**
	 * @var Customweb_I18n_ITranslationResolver[]
	 */
	private $resolvers = array();
	
	/**
	 * Returns a translation of a string. The returned object can be casted to
	 * a string. The result is then translated.
	 * 
	 * @param string $string
	 * @param array $args
	 * @return Customweb_I18n_LocalizableString
	 */
	public static function __($string, $args = array()) {
		return new Customweb_I18n_LocalizableString($string, $args);
	}
	
	/**
	 * @return Customweb_I18n_Translation
	 */
	public static function getInstance() {
		
		if (self::$instance == null) {
			self::$instance = new Customweb_I18n_Translation();
		}
		
		return self::$instance;
	}
	
	public function addResolver(Customweb_I18n_ITranslationResolver $resolver) {
		$this->resolvers[] = $resolver;
		return $this;
	}
	
	public function getResolvers() {
		return $this->resolver;
	}
	
	public function translate($string, $args = array()) {
		$resolvers = array_reverse($this->resolvers);
		
		$rs = null;
		foreach ($resolvers as $resolver) {
			$rs = $resolver->getTranslation($string, $args);
			if ($rs !== null && $rs !== $string) {
				break;
			}
		}
		
		if ($rs === null) {
			$rs = $string;
		}
		
		return self::formatString($rs, $args);
	}

	public static function formatString($string, $args) {
		$cleanedArgs = array();
		foreach ($args as $key => $value) {
			switch ($key[0]) {
				case '!':
					$cleanedArgs[$key] = $value;
					break;
						
				case '@':
					$cleanedArgs[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
					break;
	
			}
		}
	
		return strtr($string, $cleanedArgs);
	}
	
}