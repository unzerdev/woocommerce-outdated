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


/**
 * This util provides basic methods for handling languages.
 * 
 * 
 * @author hunziker
 *
 */
final class Customweb_Core_Util_Language {
	
	private function __construct() {
		
	}

	/**
	 * This method takes a language identifier and converts it to a ISO 639-1
	 * (and ISO 3166-1) code. An array of supported languages (ISO 639-1/ISO 3166-1)
	 * has to be provided, if the given language string could not be matched against
	 *  one of the patterns or if the pattern does not belong to a supported language
	 *  the method returns per default "en_US".
	 *
	 * @param string $lang An arbitrary language identifier.
	 * @param array $supportedLanguages Array of ISO 639-1 code of languages to support
	 * @return string IETF code of the given language
	 */
	public static function getCleanLanguageCode($lang, $supportedLanguages) {
		$ietfCode = self::convertToIETFCode($lang);
		
		if(in_array($ietfCode, $supportedLanguages)){
			return $ietfCode;
		}
		else {
			$language = self::getLanguageFromIETF($ietfCode);
			foreach ($supportedLanguages as $supported) {
				if ($language == self::getLanguageFromIETF($supported)) {
					return $supported;
				}
			}
			
			return "en_US";
		}
	}
	
	/**
	 * This method tries to resolve the given language (name, code etc.) to convert
	 * to the IETF language code.
	 *
	 * @param string $language
	 */
	public static function getIetfCode($language) {
		return self::convertToIETFCode($language);
	}
	
	public static function getRegionFromIETF($language) {
		return substr($language, 3, 5);
	}
	
	public static function getLanguageFromIETF($language) {
		return substr($language, 0, 2);
	}
	
	/**
	 * This method tries to find based on the given input the IETF 
	 * language tag.
	 * 
	 * The input can be either ISO-639-3, ISO-639-1, IETF tag or the 
	 * language name.
	 * 
	 * @param string $lang
	 * @return string
	 */
	private static function convertToIETFCode($lang)
	{
		// Check if the language is a IETF tag
		if (preg_match('/([a-z]{2})[-_]{1}([a-z]{2})/i', $lang, $matches)) {
			$language = $matches[1];
			$region = $matches[2];
			return strtolower($language) . '_' . strtoupper($region);
		}
	
		// It seems to be a ISO-639-3
		$lang = strtolower($lang);
		if (strlen($lang) == 3) {
			foreach (self::$languages as $langCode => $l) {
				if ($l['ISO-639-3'] == $lang) {
					return self::getIETFTagFromLanguageArray($langCode, $l);
				}
			}
		}
		
		// It seems to be a ISO-639-1
		else if (strlen($lang) == 2) {
			if (isset(self::$languages[$lang])) {
				return self::getIETFTagFromLanguageArray($lang, self::$languages[$lang]);
			}
		}
		
		// All other are names.
		else {
			foreach (self::$languages as $langCode => $l) {
				if (strtolower($l['name']) == $lang) {
					return self::getIETFTagFromLanguageArray($langCode, $l);
				}
			}
		}
		throw new Exception(Customweb_Core_String::_("No valid language found for '@lang'.")->format(array('@lang' => $lang)));
	}
	
	private static function getIETFTagFromLanguageArray($languageCode, array $lang) {
		return strtolower($languageCode) . '_' . strtoupper($lang['defaultRegion']);
	}
	
	private static $languages = array(
		'aa' => array('ISO-639-3' => 'aar', 'name' => 'Afar', 'defaultRegion' => 'ER'),
		'ab' => array('ISO-639-3' => 'abk', 'name' => 'Abkhazian', 'defaultRegion' => 'GE'),
		'af' => array('ISO-639-3' => 'afr', 'name' => 'Afrikaans', 'defaultRegion' => 'ZA'),
		'ak' => array('ISO-639-3' => 'aka', 'name' => 'Akan', 'defaultRegion' => 'GH'),
		'sq' => array('ISO-639-3' => 'sqi', 'name' => 'Albanian', 'defaultRegion' => 'AL'),
		'am' => array('ISO-639-3' => 'amh', 'name' => 'Amharic', 'defaultRegion' => 'ET'),
		'ar' => array('ISO-639-3' => 'ara', 'name' => 'Arabic', 'defaultRegion' => 'SA'),
		'an' => array('ISO-639-3' => 'arg', 'name' => 'Aragonese', 'defaultRegion' => 'ES'),
		'hy' => array('ISO-639-3' => 'hye', 'name' => 'Armenian', 'defaultRegion' => 'AM'),
		'as' => array('ISO-639-3' => 'asm', 'name' => 'Assamese', 'defaultRegion' => 'IN'),
		'av' => array('ISO-639-3' => 'ava', 'name' => 'Avaric', 'defaultRegion' => 'TR'),
		'ay' => array('ISO-639-3' => 'aym', 'name' => 'Aymara', 'defaultRegion' => 'CL'),
		'az' => array('ISO-639-3' => 'aze', 'name' => 'Azerbaijani', 'defaultRegion' => 'AZ'),
		'ba' => array('ISO-639-3' => 'bak', 'name' => 'Bashkir', 'defaultRegion' => 'RU'),
		'bm' => array('ISO-639-3' => 'bam', 'name' => 'Bambara', 'defaultRegion' => 'BF'),
		'eu' => array('ISO-639-3' => 'eus', 'name' => 'Basque', 'defaultRegion' => 'ES'),
		'be' => array('ISO-639-3' => 'bel', 'name' => 'Belarusian', 'defaultRegion' => 'BY'),
		'bn' => array('ISO-639-3' => 'ben', 'name' => 'Bengali', 'defaultRegion' => 'BD'),
		'bi' => array('ISO-639-3' => 'bis', 'name' => 'Bislama', 'defaultRegion' => 'VU'),
		'bo' => array('ISO-639-3' => 'bod', 'name' => 'Tibetan', 'defaultRegion' => 'CN'),
		'bs' => array('ISO-639-3' => 'bos', 'name' => 'Bosnian', 'defaultRegion' => 'BA'),
		'br' => array('ISO-639-3' => 'bre', 'name' => 'Breton', 'defaultRegion' => 'FR'),
		'bg' => array('ISO-639-3' => 'bul', 'name' => 'Bulgarian', 'defaultRegion' => 'BG'),
		'my' => array('ISO-639-3' => 'mya', 'name' => 'Burmese', 'defaultRegion' => 'MM'),
		'ca' => array('ISO-639-3' => 'cat', 'name' => 'Catalan', 'defaultRegion' => 'ES'),
		'cs' => array('ISO-639-3' => 'ces', 'name' => 'Czech', 'defaultRegion' => 'CZ'),
		'ch' => array('ISO-639-3' => 'cha', 'name' => 'Chamorro', 'defaultRegion' => 'GU'),
		'ce' => array('ISO-639-3' => 'che', 'name' => 'Chechen', 'defaultRegion' => 'RU'),
		'zh' => array('ISO-639-3' => 'zho', 'name' => 'Chinese', 'defaultRegion' => 'CN'),
		'cv' => array('ISO-639-3' => 'chv', 'name' => 'Chuvash', 'defaultRegion' => 'RU'),
		'kw' => array('ISO-639-3' => 'cor', 'name' => 'Cornish', 'defaultRegion' => 'GB'),
		'co' => array('ISO-639-3' => 'cos', 'name' => 'Corsican', 'defaultRegion' => 'FR'),
		'cr' => array('ISO-639-3' => 'cre', 'name' => 'Cree', 'defaultRegion' => 'CA'),
		'cy' => array('ISO-639-3' => 'cym', 'name' => 'Welsh', 'defaultRegion' => 'GB'),
		'da' => array('ISO-639-3' => 'dan', 'name' => 'Danish', 'defaultRegion' => 'DK'),
		'de' => array('ISO-639-3' => 'deu', 'name' => 'German', 'defaultRegion' => 'DE'),
		'dv' => array('ISO-639-3' => 'div', 'name' => 'Dhivehi', 'defaultRegion' => 'MV'),
		'nl' => array('ISO-639-3' => 'nld', 'name' => 'Dutch', 'defaultRegion' => 'NL'),
		'dz' => array('ISO-639-3' => 'dzo', 'name' => 'Dzongkha', 'defaultRegion' => 'BT'),
		'el' => array('ISO-639-3' => 'ell', 'name' => 'Greek', 'defaultRegion' => 'GR'),
		'en' => array('ISO-639-3' => 'eng', 'name' => 'English', 'defaultRegion' => 'US'),
		'et' => array('ISO-639-3' => 'est', 'name' => 'Estonian', 'defaultRegion' => 'EE'),
		'ee' => array('ISO-639-3' => 'ewe', 'name' => 'Ewe', 'defaultRegion' => 'TG'),
		'fo' => array('ISO-639-3' => 'fao', 'name' => 'Faroese', 'defaultRegion' => 'FO'),
		'fa' => array('ISO-639-3' => 'fas', 'name' => 'Persian', 'defaultRegion' => 'IR'),
		'fj' => array('ISO-639-3' => 'fij', 'name' => 'Fijian', 'defaultRegion' => 'FJ'),
		'fi' => array('ISO-639-3' => 'fin', 'name' => 'Finnish', 'defaultRegion' => 'FI'),
		'fr' => array('ISO-639-3' => 'fra', 'name' => 'French', 'defaultRegion' => 'FR'),
		'fy' => array('ISO-639-3' => 'fry', 'name' => 'Western Frisian', 'defaultRegion' => 'NL'),
		'ff' => array('ISO-639-3' => 'ful', 'name' => 'Fulah', 'defaultRegion' => 'NE'),
		'ka' => array('ISO-639-3' => 'kat', 'name' => 'Georgian', 'defaultRegion' => 'GE'),
		'gd' => array('ISO-639-3' => 'gla', 'name' => 'Scottish Gaelic', 'defaultRegion' => 'GB'),
		'ga' => array('ISO-639-3' => 'gle', 'name' => 'Irish', 'defaultRegion' => 'IE'),
		'gl' => array('ISO-639-3' => 'glg', 'name' => 'Galician', 'defaultRegion' => 'ES'),
		'gv' => array('ISO-639-3' => 'glv', 'name' => 'Manx', 'defaultRegion' => 'GB'),
		'gn' => array('ISO-639-3' => 'grn', 'name' => 'Guarani', 'defaultRegion' => 'PY'),
		'gu' => array('ISO-639-3' => 'guj', 'name' => 'Gujarati', 'defaultRegion' => 'IN'),
		'ht' => array('ISO-639-3' => 'hat', 'name' => 'Haitian', 'defaultRegion' => 'HT'),
		'ha' => array('ISO-639-3' => 'hau', 'name' => 'Hausa', 'defaultRegion' => 'SD'),
		'he' => array('ISO-639-3' => 'heb', 'name' => 'Hebrew', 'defaultRegion' => 'IL'),
		'hz' => array('ISO-639-3' => 'her', 'name' => 'Herero', 'defaultRegion' => 'NA'),
		'hi' => array('ISO-639-3' => 'hin', 'name' => 'Hindi', 'defaultRegion' => 'IN'),
		'ho' => array('ISO-639-3' => 'hmo', 'name' => 'Hiri Motu', 'defaultRegion' => 'PG'),
		'hr' => array('ISO-639-3' => 'hrv', 'name' => 'Croatian', 'defaultRegion' => 'HR'),
		'hu' => array('ISO-639-3' => 'hun', 'name' => 'Hungarian', 'defaultRegion' => 'HU'),
		'ig' => array('ISO-639-3' => 'ibo', 'name' => 'Igbo', 'defaultRegion' => 'NG'),
		'is' => array('ISO-639-3' => 'isl', 'name' => 'Icelandic', 'defaultRegion' => 'IS'),
		'ii' => array('ISO-639-3' => 'iii', 'name' => 'Sichuan Yi', 'defaultRegion' => 'CN'),
		'iu' => array('ISO-639-3' => 'iku', 'name' => 'Inuktitut', 'defaultRegion' => 'CA'),
		'id' => array('ISO-639-3' => 'ind', 'name' => 'Indonesian', 'defaultRegion' => 'ID'),
		'ik' => array('ISO-639-3' => 'ipk', 'name' => 'Inupiaq', 'defaultRegion' => 'US'),
		'it' => array('ISO-639-3' => 'ita', 'name' => 'Italian', 'defaultRegion' => 'IT'),
		'jv' => array('ISO-639-3' => 'jav', 'name' => 'Javanese', 'defaultRegion' => 'MY'),
		'ja' => array('ISO-639-3' => 'jpn', 'name' => 'Japanese', 'defaultRegion' => 'JP'),
		'kl' => array('ISO-639-3' => 'kal', 'name' => 'Kalaallisut', 'defaultRegion' => 'GL'),
		'kn' => array('ISO-639-3' => 'kan', 'name' => 'Kannada', 'defaultRegion' => 'IN'),
		'ks' => array('ISO-639-3' => 'kas', 'name' => 'Kashmiri', 'defaultRegion' => 'IN'),
		'kr' => array('ISO-639-3' => 'kau', 'name' => 'Kanuri', 'defaultRegion' => 'NG'),
		'kk' => array('ISO-639-3' => 'kaz', 'name' => 'Kazakh', 'defaultRegion' => 'KZ'),
		'km' => array('ISO-639-3' => 'khm', 'name' => 'Central Khmer', 'defaultRegion' => 'KH'),
		'ki' => array('ISO-639-3' => 'kik', 'name' => 'Kikuyu', 'defaultRegion' => 'KE'),
		'rw' => array('ISO-639-3' => 'kin', 'name' => 'Kinyarwanda', 'defaultRegion' => 'RW'),
		'ky' => array('ISO-639-3' => 'kir', 'name' => 'Kirghiz', 'defaultRegion' => 'KG'),
		'kv' => array('ISO-639-3' => 'kom', 'name' => 'Komi', 'defaultRegion' => 'RU'),
		'kg' => array('ISO-639-3' => 'kon', 'name' => 'Kongo', 'defaultRegion' => 'CG'),
		'ko' => array('ISO-639-3' => 'kor', 'name' => 'Korean', 'defaultRegion' => 'KR'),
		'kj' => array('ISO-639-3' => 'kua', 'name' => 'Kuanyama', 'defaultRegion' => 'AO'),
		'ku' => array('ISO-639-3' => 'kur', 'name' => 'Kurdish', 'defaultRegion' => 'TR'),
		'lo' => array('ISO-639-3' => 'lao', 'name' => 'Lao', 'defaultRegion' => 'LA'),
		'lv' => array('ISO-639-3' => 'lav', 'name' => 'Latvian', 'defaultRegion' => 'LV'),
		'li' => array('ISO-639-3' => 'lim', 'name' => 'Limburgan', 'defaultRegion' => 'NL'),
		'ln' => array('ISO-639-3' => 'lin', 'name' => 'Lingala', 'defaultRegion' => 'CG'),
		'lt' => array('ISO-639-3' => 'lit', 'name' => 'Lithuanian', 'defaultRegion' => 'LT'),
		'lb' => array('ISO-639-3' => 'ltz', 'name' => 'Luxembourgish', 'defaultRegion' => 'LU'),
		'lu' => array('ISO-639-3' => 'lub', 'name' => 'Luba-Katanga', 'defaultRegion' => 'CD'),
		'lg' => array('ISO-639-3' => 'lug', 'name' => 'Ganda', 'defaultRegion' => 'UG'),
		'mk' => array('ISO-639-3' => 'mkd', 'name' => 'Macedonian', 'defaultRegion' => 'MK'),
		'mh' => array('ISO-639-3' => 'mah', 'name' => 'Marshallese', 'defaultRegion' => 'MH'),
		'ml' => array('ISO-639-3' => 'mal', 'name' => 'Malayalam', 'defaultRegion' => 'IN'),
		'mi' => array('ISO-639-3' => 'mri', 'name' => 'Maori', 'defaultRegion' => 'NZ'),
		'mr' => array('ISO-639-3' => 'mar', 'name' => 'Marathi', 'defaultRegion' => 'IN'),
		'ms' => array('ISO-639-3' => 'msa', 'name' => 'Malay', 'defaultRegion' => 'MY'),
		'mg' => array('ISO-639-3' => 'mlg', 'name' => 'Malagasy', 'defaultRegion' => 'MG'),
		'mt' => array('ISO-639-3' => 'mlt', 'name' => 'Maltese', 'defaultRegion' => 'MT'),
		'mn' => array('ISO-639-3' => 'mon', 'name' => 'Mongolian', 'defaultRegion' => 'MN'),
		'na' => array('ISO-639-3' => 'nau', 'name' => 'Nauru', 'defaultRegion' => 'NR'),
		'nv' => array('ISO-639-3' => 'nav', 'name' => 'Navajo', 'defaultRegion' => 'US'),
		'nr' => array('ISO-639-3' => 'nbl', 'name' => 'South Ndebele', 'defaultRegion' => 'ZA'),
		'nd' => array('ISO-639-3' => 'nde', 'name' => 'North Ndebele', 'defaultRegion' => 'ZW'),
		'ng' => array('ISO-639-3' => 'ndo', 'name' => 'Ndonga', 'defaultRegion' => 'NR'),
		'ne' => array('ISO-639-3' => 'nep', 'name' => 'Nepali', 'defaultRegion' => 'NP'),
		'nn' => array('ISO-639-3' => 'nno', 'name' => 'Norwegian Nynorsk', 'defaultRegion' => 'NO'),
		'nb' => array('ISO-639-3' => 'nob', 'name' => 'Norwegian Bokmal', 'defaultRegion' => 'NO'),
		'no' => array('ISO-639-3' => 'nor', 'name' => 'Norwegian', 'defaultRegion' => 'NO'),
		'ny' => array('ISO-639-3' => 'nya', 'name' => 'Nyanja', 'defaultRegion' => 'ZA'),
		'oc' => array('ISO-639-3' => 'oci', 'name' => 'Occitan', 'defaultRegion' => 'FR'),
		'oj' => array('ISO-639-3' => 'oji', 'name' => 'Ojibwa', 'defaultRegion' => 'US'),
		'or' => array('ISO-639-3' => 'ori', 'name' => 'Oriya', 'defaultRegion' => 'IN'),
		'om' => array('ISO-639-3' => 'orm', 'name' => 'Oromo', 'defaultRegion' => 'KE'),
		'os' => array('ISO-639-3' => 'oss', 'name' => 'Ossetian', 'defaultRegion' => 'UZ'),
		'pa' => array('ISO-639-3' => 'pan', 'name' => 'Panjabi', 'defaultRegion' => 'IN'),
		'pl' => array('ISO-639-3' => 'pol', 'name' => 'Polish', 'defaultRegion' => 'PL'),
		'pt' => array('ISO-639-3' => 'por', 'name' => 'Portuguese', 'defaultRegion' => 'PT'),
		'ps' => array('ISO-639-3' => 'pus', 'name' => 'Pushto', 'defaultRegion' => 'AF'),
		'qu' => array('ISO-639-3' => 'que', 'name' => 'Quechua', 'defaultRegion' => 'PE'),
		'rm' => array('ISO-639-3' => 'roh', 'name' => 'Romansh', 'defaultRegion' => 'CH'),
		'ro' => array('ISO-639-3' => 'ron', 'name' => 'Romanian', 'defaultRegion' => 'RO'),
		'rn' => array('ISO-639-3' => 'run', 'name' => 'Rundi', 'defaultRegion' => 'BI'),
		'ru' => array('ISO-639-3' => 'rus', 'name' => 'Russian', 'defaultRegion' => 'RU'),
		'sg' => array('ISO-639-3' => 'sag', 'name' => 'Sango', 'defaultRegion' => 'CF'),
		'si' => array('ISO-639-3' => 'sin', 'name' => 'Sinhala', 'defaultRegion' => 'LK'),
		'sk' => array('ISO-639-3' => 'slk', 'name' => 'Slovak', 'defaultRegion' => 'SK'),
		'sl' => array('ISO-639-3' => 'slv', 'name' => 'Slovenian', 'defaultRegion' => 'SI'),
		'se' => array('ISO-639-3' => 'sme', 'name' => 'Northern Sami', 'defaultRegion' => 'SE'),
		'sm' => array('ISO-639-3' => 'smo', 'name' => 'Samoan', 'defaultRegion' => 'WS'),
		'sn' => array('ISO-639-3' => 'sna', 'name' => 'Shona', 'defaultRegion' => 'BW'),
		'sd' => array('ISO-639-3' => 'snd', 'name' => 'Sindhi', 'defaultRegion' => 'PK'),
		'so' => array('ISO-639-3' => 'som', 'name' => 'Somali', 'defaultRegion' => 'SO'),
		'st' => array('ISO-639-3' => 'sot', 'name' => 'Southern Sotho', 'defaultRegion' => 'LS'),
		'es' => array('ISO-639-3' => 'spa', 'name' => 'Spanish', 'defaultRegion' => 'ES'),
		'sc' => array('ISO-639-3' => 'srd', 'name' => 'Sardinian', 'defaultRegion' => 'IT'),
		'sr' => array('ISO-639-3' => 'srp', 'name' => 'Serbian', 'defaultRegion' => 'CS'),
		'ss' => array('ISO-639-3' => 'ssw', 'name' => 'Swati', 'defaultRegion' => 'SZ'),
		'su' => array('ISO-639-3' => 'sun', 'name' => 'Sundanese', 'defaultRegion' => 'ID'),
		'sw' => array('ISO-639-3' => 'swa', 'name' => 'Swahili', 'defaultRegion' => 'TZ'),
		'sv' => array('ISO-639-3' => 'swe', 'name' => 'Swedish', 'defaultRegion' => 'SE'),
		'ty' => array('ISO-639-3' => 'tah', 'name' => 'Tahitian', 'defaultRegion' => 'PF'),
		'ta' => array('ISO-639-3' => 'tam', 'name' => 'Tamil', 'defaultRegion' => 'SG'),
		'tt' => array('ISO-639-3' => 'tat', 'name' => 'Tatar', 'defaultRegion' => 'RU'),
		'te' => array('ISO-639-3' => 'tel', 'name' => 'Telugu', 'defaultRegion' => 'IN'),
		'tg' => array('ISO-639-3' => 'tgk', 'name' => 'Tajik', 'defaultRegion' => 'TJ'),
		'tl' => array('ISO-639-3' => 'tgl', 'name' => 'Tagalog', 'defaultRegion' => 'PH'),
		'th' => array('ISO-639-3' => 'tha', 'name' => 'Thai', 'defaultRegion' => 'TH'),
		'ti' => array('ISO-639-3' => 'tir', 'name' => 'Tigrinya', 'defaultRegion' => 'ER'),
		'to' => array('ISO-639-3' => 'ton', 'name' => 'Tonga', 'defaultRegion' => 'TO'),
		'tn' => array('ISO-639-3' => 'tsn', 'name' => 'Tswana', 'defaultRegion' => 'BW'),
		'ts' => array('ISO-639-3' => 'tso', 'name' => 'Tsonga', 'defaultRegion' => 'ZA'),
		'tk' => array('ISO-639-3' => 'tuk', 'name' => 'Turkmen', 'defaultRegion' => 'TM'),
		'tr' => array('ISO-639-3' => 'tur', 'name' => 'Turkish', 'defaultRegion' => 'TR'),
		'tw' => array('ISO-639-3' => 'twi', 'name' => 'Twi', 'defaultRegion' => 'GH'),
		'ug' => array('ISO-639-3' => 'uig', 'name' => 'Uighur', 'defaultRegion' => 'KZ'),
		'uk' => array('ISO-639-3' => 'ukr', 'name' => 'Ukrainian', 'defaultRegion' => 'UA'),
		'ur' => array('ISO-639-3' => 'urd', 'name' => 'Urdu', 'defaultRegion' => 'IN'),
		'uz' => array('ISO-639-3' => 'uzb', 'name' => 'Uzbek', 'defaultRegion' => 'UZ'),
		've' => array('ISO-639-3' => 'ven', 'name' => 'Venda', 'defaultRegion' => 'ZA'),
		'vi' => array('ISO-639-3' => 'vie', 'name' => 'Vietnamese', 'defaultRegion' => 'VN'),
		'wa' => array('ISO-639-3' => 'wln', 'name' => 'Walloon', 'defaultRegion' => 'BE'),
		'wo' => array('ISO-639-3' => 'wol', 'name' => 'Wolof', 'defaultRegion' => 'SN'),
		'xh' => array('ISO-639-3' => 'xho', 'name' => 'Xhosa', 'defaultRegion' => 'ZA'),
		'yi' => array('ISO-639-3' => 'yid', 'name' => 'Yiddish', 'defaultRegion' => 'BE'),
		'yo' => array('ISO-639-3' => 'yor', 'name' => 'Yoruba', 'defaultRegion' => 'NG'),
		'za' => array('ISO-639-3' => 'zha', 'name' => 'Zhuang', 'defaultRegion' => 'CN'),
		'zu' => array('ISO-639-3' => 'zul', 'name' => 'Zulu', 'defaultRegion' => 'ZW'),
	);
	
}