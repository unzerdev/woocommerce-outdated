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

require_once 'Customweb/Core/String.php';


final class Customweb_Core_MimeType {
	
	private static $mimeTypes = array(
		'txt' => 'text/plain',
		'htm' => 'text/html',
		'html' => 'text/html',
		'php' => 'text/html',
		'css' => 'text/css',
		'js' => 'application/javascript',
		'json' => 'application/json',
		'xml' => 'application/xml',
		'swf' => 'application/x-shockwave-flash',
		'flv' => 'video/x-flv',
	
		// images
		'png' => 'image/png',
		'jpe' => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'jpg' => 'image/jpeg',
		'gif' => 'image/gif',
		'bmp' => 'image/bmp',
		'ico' => 'image/vnd.microsoft.icon',
		'tiff' => 'image/tiff',
		'tif' => 'image/tiff',
		'svg' => 'image/svg+xml',
		'svgz' => 'image/svg+xml',
	
		// archives
		'zip' => 'application/zip',
		'rar' => 'application/x-rar-compressed',
		'exe' => 'application/x-msdownload',
		'msi' => 'application/x-msdownload',
		'cab' => 'application/vnd.ms-cab-compressed',
	
		// audio/video
		'mp3' => 'audio/mpeg',
		'qt' => 'video/quicktime',
		'mov' => 'video/quicktime',
	
		// adobe
		'pdf' => 'application/pdf',
		'psd' => 'image/vnd.adobe.photoshop',
		'ai' => 'application/postscript',
		'eps' => 'application/postscript',
		'ps' => 'application/postscript',
	
		// ms office
		'doc' => 'application/msword',
		'rtf' => 'application/rtf',
		'xls' => 'application/vnd.ms-excel',
		'ppt' => 'application/vnd.ms-powerpoint',
	
		// open office
		'odt' => 'application/vnd.oasis.opendocument.text',
		'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
			
		// template
		'tpl' => 'application/x-smarty',
		'twig' => 'application/x-twig',
		'phtml' => 'application/x-phtml',
	);
	
	private static $inversion = null;
	
	
	private function __construct() {
		
	}
	
	public static function getMimeType($fileExtension) {
		$rs = self::getMimeTypes($fileExtension);
		reset($rs);
		return current($rs);
	}
	
	public static function getMimeTypes($fileExtension) {
		$key = strtolower($fileExtension);
		if (isset(self::$mimeTypes[$key])) {
			$rs = self::$mimeTypes[$key];
			if (is_array($rs)) {
				return $rs;
			}
			else{
				return array(
					$rs,
				);
			}
		}
		else {
			throw new Exception(Customweb_Core_String::_("No mime type found for file extension '@extension'.")->format(array('@extension' => $fileExtension)));
		}
	}
	
	public static function getFileExtension($mimeType) {
		$rs = self::getFileExtensions($mimeType);
		reset($rs);
		return current($rs);
	}
	
	public static function getFileExtensions($mimeType) {
		$key = strtolower($mimeType);
		$inversion = self::getInversionMap();
		if (isset($inversion[$key])) {
			return $inversion[$key];
		}
		else {
			throw new Exception(Customweb_Core_String::_("No file extension found for mime type '@mime'.")->format(array('@mime' => $mimeType)));
		}
	}
	
	private static function getInversionMap() {
		if (self::$inversion === null) {
			self::$inversion = array();
			foreach (self::$mimeTypes as $extension => $mimes) {
				foreach ($mimes as $mime) {
					if (!isset(self::$inversion[$mime])) {
						self::$inversion[$mime] = array();
					}
					self::$inversion[$mime][] = $extension;
				}
			}
		}
		
		return self::$inversion;
	}
	
	
}