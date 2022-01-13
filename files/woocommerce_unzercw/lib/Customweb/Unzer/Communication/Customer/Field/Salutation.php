<?php

class Customweb_Unzer_Communication_Customer_Field_Salutation {

	/**
	 * Possible values of this enum
	 */
	const MR = 'mr';
	const MRS = 'mrs';
	const UNKNOWN = 'unknown';

	/**
	 * Gets allowable values of the enum
	 * @return string[]
	 */
	public static function getAllowableEnumValues()
	{
		return [
			self::MR,
			self::MRS,
			self::UNKNOWN
		];
	}
}
