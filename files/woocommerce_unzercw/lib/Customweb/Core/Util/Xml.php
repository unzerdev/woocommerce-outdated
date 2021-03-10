<?php

/**
 *  * You are allowed to use this API in your web application.
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
 *
 * @author Thomas Hunziker
 *
 */
final class Customweb_Core_Util_Xml {
	
	public static function extractOwnerDocument(DOMNode $dom) {
		if ($dom instanceof DOMDocument) {
			return $dom;
		}
		else {
			if (!($dom->ownerDocument instanceof DOMDocument)) {
				throw new Exception("Unable to extract the owner document.");
			}
			return $dom->ownerDocument;
		}
	}
	

	/**
	 * Returns true, when the given DOMElement node has at least one direct child with the given 
	 * tagName. Optionally also the namespace can be enforced.
	 *
	 * @param DOMElement $node
	 * @param string $tagName
	 * @param string $namespaceUri
	 * @return boolean
	 */
	public static function hasChildElement(DOMElement $node, $tagName, $namespaceUri = null) {
		$list = self::getChildElements($node, $tagName, $namespaceUri);
		if (count($list) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns a list of direct child elements with the given tagName. Optionally also the 
	 * namespace can be enforced.
	 *
	 * @param DOMElement $node
	 * @param string $tagName
	 * @param string $namespaceUri
	 * @return DOMElement[]
	 */
	public static function getChildElements(DOMElement $node, $tagName, $namespaceUri = null) {
		$list = array();
		foreach ($node->childNodes as $child) {
			if ($child instanceof DOMElement && $child->localName == $tagName && ($namespaceUri === null || $namespaceUri = $child->namespaceURI == $namespaceUri)) {
				$list[] = $child;
			}
		}
		return $list;
	}
	
	/**
	 * Returns the first of direct child elements with the given tagName. Optionally also the
	 * namespace can be enforced. If no such child exists this method throws an exception.
	 *
	 * @param DOMElement $node
	 * @param string $tagName
	 * @param string $namespaceUri
	 * @return DOMElement
	 */
	public static function getChildElement(DOMElement $node, $tagName, $namespaceUri = null) {
		$list = self::getChildElements($node, $tagName, $namespaceUri);
		if (count($list) > 0) {
			return current($list);
		}
		else {
			throw new Exception(Customweb_Core_String::_("No element with tag name '@tag' does exists.")->format(array('@tag' => $tagName)));
		}
	}
	
	
	public static function renameDomElement(DOMElement $original, $newTagName) {
		$parent = $original->parentNode;
		$doc = self::extractOwnerDocument($original);
		
		if (!empty($original->namespaceURI)) {
			$prefix = $original->lookupPrefix($original->namespaceURI);
			$newElement = $doc->createElementNS($original->namespaceURI, $prefix . ':' . $newTagName);
		}
		else {
			$newElement = $doc->createElement($newTagName);
		}
		$parent->appendChild($newElement);
		
		if ($original->hasAttributes()) {
			foreach ($original->attributes as $attr) {
				$newElement->appendChild($attr);
			}
		}

		// Copy child elements
		if ($original->childNodes->length) {
			$children = array();
			foreach ($original->childNodes as $node) {
				if ($node instanceof DOMElement) {
					$children[] = $node;
				}
			}
			foreach ($children as $child) {
				$newElement->appendChild($child);
			}
			$parent->removeChild($original);
		}
		
		return $newElement;
	}

	/**
	 * Escape all chars which are not allowed with in an XML element or XML attribute.
	 * 
	 * @param string $content
	 * @return string
	 */
	public static function escape($content){
		return str_replace(array(
			'&',
			'<',
			'>',
			'"',
			"'" 
		), array(
			'&amp;',
			'&lt;',
			'&gt;',
			'&quot;',
			'&#39;' 
		), $content);
	}

	/**
	 * Unescapte all chars which are not allowed with in an XML element or XML attribute.
	 * 
	 * @param string $content
	 * @return string
	 */
	public static function unescape($content){
		return str_replace(array(
			'&amp;',
			'&lt;',
			'&gt;',
			'&quot;',
			'&#39;' 
		), array(
			'&',
			'<',
			'>',
			'"',
			"'" 
		), $content);
	}
	

	public static function extractNamespacePrefix($name) {
		if (strpos($name, ':') === false) {
			return NULL;
		}
		else {
			return rtrim(substr($name, 0, strpos($name, ':')), ':');
		}
	}
	
	public static function removeNamespacePrefix($name) {
		if (strpos($name, ':') === false) {
			return $name;
		}
		else {
			return ltrim(strrchr($name, ':'), ':');
		}
	}
}