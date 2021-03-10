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

require_once 'Customweb/Core/Charset/TableBasedCharset.php';

/**
 * This char set which allows only numeric values (0-9) and alphabetical chars (a-z and A-Z).
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Core_Charset_AlphaNumeric extends Customweb_Core_Charset_TableBasedCharset {
	
	private $replacementTable = null;
	
	private static $conversionTable = array(
		// Non required
	);
	
	protected function getReplacementTable() {
		if ($this->replacementTable === null) {
			$this->replacementTable = parent::getReplacementTable();
			foreach ($this->replacementTable as $key => $value) {
				if (!preg_match('/[0-9a-zA-Z]+/', $value)) {
					unset($this->replacementTable[$key]);
				}
			}
		}
		return $this->replacementTable;
	}

	protected function getConversionTable() {
		return self::$conversionTable;
	}
	
	protected function getNoChangesRanges() {
		return array(
			array(
				'start' => 0x30,
				'end' => 0x39,
			),
			array(
				'start' => 0x41,
				'end' => 0x5A,
			),
			array(
				'start' => 0x61,
				'end' => 0x7A,
			),
		);
	}
	
	public function getName() {
		return 'AlphaNumeric';
	}
	
	public function getAliases() {
		return array();
	}	
	
}