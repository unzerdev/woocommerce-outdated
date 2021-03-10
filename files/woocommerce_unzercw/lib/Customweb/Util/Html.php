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
 *
 */
final class Customweb_Util_Html {
	
	private $baseUrl = NULL;
	private $baseDomain = NULL;
	
	private function __construct() {}
	
	public static function buildHiddenInputFields(array $data) {
		$output = '';
	
		foreach ($data as $key => $value) {
			
			if (is_array($value)) {
				foreach ($value as $item) {
					$output .= '<input type="hidden" name="' . self::escapeXml($key) . '[]" value="' . self::escapeXml($item) . '" />';
				}
			}
			else {
				$output .= '<input type="hidden" name="' . self::escapeXml($key) . '" value="' . self::escapeXml($value) . '" />';
			}
		}
	
		return $output;
	}
	
	public static function convertSpecialCharacterToEntities($output) {
		if (version_compare(PHP_VERSION, '5.2.3') >= 0) {
			if (stristr($output, 'charset=iso-8859-15') || stristr($output, 'charset=iso-8859-1')) {
				$tmp = htmlentities(utf8_encode($output), ENT_NOQUOTES, 'UTF-8', false);
			}
			else {
				$tmp = htmlentities($output, ENT_NOQUOTES, 'UTF-8', false);
			}
		}
		else {
			if (stristr($output, 'charset=iso-8859-15') || stristr($output, 'charset=iso-8859-1')) {
				$tmp = htmlentities(utf8_encode($output), ENT_NOQUOTES, 'UTF-8');
			}
			else {
				$tmp = htmlentities($output, ENT_NOQUOTES, 'UTF-8');
			}
		}
		if (!empty($tmp)) {
			$output = $tmp;
		}
		$output = str_replace(array('&amp;', '&lt;','&gt;'),array('&', '<','>'), $output);
		return $output;
	}
	
	public static function escapeXml($content) {
		return str_replace(array('&', '<','>', '"', "'"), array('&amp;', '&lt;','&gt;', '&quot;', '&#39;'), $content);
	}
	
	public static function unescapeXml($content) {
		return str_replace(array('&amp;', '&lt;','&gt;', '&quot;', '&#39;'), array('&', '<','>', '"', "'"), $content);
	}
	
	public static function removeBaseHrefTag($content) {
	
		$patterns = array(
			'/(<base[[:space:]]+href[[:space:]]*=[[:space:]]*"[^"]+"[^>]*>)/',
			"/(<base[[:space:]]+href[[:space:]]*=[[:space:]]*'[^']+'[^>]*>)/",
		);
	
		foreach ($patterns as $pattern) {
			if (preg_match($pattern, $content)) {
				$content = preg_replace($pattern, '', $content);
			}
		}
	
		return $content;
	}
	
	
	public static function replaceRelativeUrls($content, $baseUrl) {
		$baseUrl = trim($baseUrl, '/ ');
		$baseUrl .= '/';
		
		$object = new Customweb_Util_Html();
		$url = new Customweb_Http_Url($baseUrl);
		$object->baseUrl = $baseUrl;
		$object->baseDomain = $url->getBaseUrl();
	
		$patterns = array(
			'/(href=")([^"]*)(")/',
			'/(href=\')([^\']*)(\')/',
			'/(src=")([^"]*)(")/',
			'/(src=\')([^\']*)(\')/',
			'/(srcset=")([^"]*)(")/',
			'/(srcset=\')([^\']*)(\')/',
		);
		
		foreach($patterns as $pattern) {
			$content = preg_replace_callback($pattern, array($object, 'replaceRelativeUrl'), $content);
		}
		
		return $content;
	}
	
	private function replaceRelativeUrl($matches) {
		$url = $matches[2];
	
		// If the URL does not contain a ':' it is not a fully qualified URL.
		if (!empty($url) && strstr($url, ':') === false && substr($url, 0, 2) != '//' && substr($url, 0, 5) != 'data:') {
			if (substr($url, 0, 1) == '/') {
				$url = $this->baseDomain . $url;
			}
			else {
				$url = $this->baseUrl . $url;
			}
		}
	
		return $matches[1] . $url . $matches[3];
	}
	
	
	
	
}