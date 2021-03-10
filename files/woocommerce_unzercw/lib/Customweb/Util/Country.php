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
 * This util to handle countries and their states.
 *
 * @author Simon Schurter
 *
 */
final class Customweb_Util_Country {

	private static $countriesMap = array(
		'AD' => array(
			'code' => 'AD',
 			'name' => 'Andorra',
 			'code3' => 'AND',
 			'numeric' => '020',
 			'states' => array(
			),
 		),
 		'AE' => array(
			'code' => 'AE',
 			'name' => 'United Arab Emirates',
 			'code3' => 'ARE',
 			'numeric' => '784',
 			'states' => array(
				'AJ' => array(
					'code' => 'AJ',
 					'name' => '‘Ajmān',
 				),
 				'AZ' => array(
					'code' => 'AZ',
 					'name' => 'Abū Zaby',
 				),
 				'DU' => array(
					'code' => 'DU',
 					'name' => 'Dubayy',
 				),
 				'FU' => array(
					'code' => 'FU',
 					'name' => 'Al Fujayrah',
 				),
 				'RK' => array(
					'code' => 'RK',
 					'name' => 'R\'as al Khaymah',
 				),
 				'SH' => array(
					'code' => 'SH',
 					'name' => 'Ash Shāriqah',
 				),
 				'UQ' => array(
					'code' => 'UQ',
 					'name' => 'Umm al Qaywayn',
 				),
 			),
 		),
 		'AF' => array(
			'code' => 'AF',
 			'name' => 'Afghanistan',
 			'code3' => 'AFG',
 			'numeric' => '004',
 			'states' => array(
				'BAL' => array(
					'code' => 'BAL',
 					'name' => 'Balkh',
 				),
 				'BAM' => array(
					'code' => 'BAM',
 					'name' => 'Bāmīān',
 				),
 				'BDG' => array(
					'code' => 'BDG',
 					'name' => 'Bādghīs',
 				),
 				'BDS' => array(
					'code' => 'BDS',
 					'name' => 'Badakhshān',
 				),
 				'BGL' => array(
					'code' => 'BGL',
 					'name' => 'Baghlān',
 				),
 				'FRA' => array(
					'code' => 'FRA',
 					'name' => 'Farāh',
 				),
 				'FYB' => array(
					'code' => 'FYB',
 					'name' => 'Fāryāb',
 				),
 				'GHA' => array(
					'code' => 'GHA',
 					'name' => 'Ghaznī',
 				),
 				'GHO' => array(
					'code' => 'GHO',
 					'name' => 'Ghowr',
 				),
 				'HEL' => array(
					'code' => 'HEL',
 					'name' => 'Helmand',
 				),
 				'HER' => array(
					'code' => 'HER',
 					'name' => 'Herāt',
 				),
 				'JOW' => array(
					'code' => 'JOW',
 					'name' => 'Jowzjān',
 				),
 				'KAB' => array(
					'code' => 'KAB',
 					'name' => 'Kabul',
 				),
 				'KAN' => array(
					'code' => 'KAN',
 					'name' => 'Kandahār',
 				),
 				'KAP' => array(
					'code' => 'KAP',
 					'name' => 'Kāpīsā',
 				),
 				'KDZ' => array(
					'code' => 'KDZ',
 					'name' => 'Kondoz',
 				),
 				'KNR' => array(
					'code' => 'KNR',
 					'name' => 'Konar',
 				),
 				'LAG' => array(
					'code' => 'LAG',
 					'name' => 'Laghmān',
 				),
 				'LOW' => array(
					'code' => 'LOW',
 					'name' => 'Lowgar',
 				),
 				'NAN' => array(
					'code' => 'NAN',
 					'name' => 'Nangrahār',
 				),
 				'NIM' => array(
					'code' => 'NIM',
 					'name' => 'Nīmrūz',
 				),
 				'ORU' => array(
					'code' => 'ORU',
 					'name' => 'Orūzgān',
 				),
 				'PAR' => array(
					'code' => 'PAR',
 					'name' => 'Parwān',
 				),
 				'PIA' => array(
					'code' => 'PIA',
 					'name' => 'Paktīā',
 				),
 				'PKA' => array(
					'code' => 'PKA',
 					'name' => 'Paktīkā',
 				),
 				'SAM' => array(
					'code' => 'SAM',
 					'name' => 'Samangān',
 				),
 				'SAR' => array(
					'code' => 'SAR',
 					'name' => 'Sar-e Pol',
 				),
 				'TAK' => array(
					'code' => 'TAK',
 					'name' => 'Takhār',
 				),
 				'WAR' => array(
					'code' => 'WAR',
 					'name' => 'Wardak',
 				),
 				'ZAB' => array(
					'code' => 'ZAB',
 					'name' => 'Zābol',
 				),
 			),
 		),
 		'AG' => array(
			'code' => 'AG',
 			'name' => 'Antigua & Barbuda',
 			'code3' => 'ATG',
 			'numeric' => '028',
 			'states' => array(
			),
 		),
 		'AI' => array(
			'code' => 'AI',
 			'name' => 'Anguilla',
 			'code3' => 'AIA',
 			'numeric' => '660',
 			'states' => array(
			),
 		),
 		'AL' => array(
			'code' => 'AL',
 			'name' => 'Albania',
 			'code3' => 'ALB',
 			'numeric' => '008',
 			'states' => array(
				'BR' => array(
					'code' => 'BR',
 					'name' => 'Berat',
 				),
 				'BU' => array(
					'code' => 'BU',
 					'name' => 'Bulqizë',
 				),
 				'DI' => array(
					'code' => 'DI',
 					'name' => 'Dibër',
 				),
 				'DL' => array(
					'code' => 'DL',
 					'name' => 'Delvinë',
 				),
 				'DR' => array(
					'code' => 'DR',
 					'name' => 'Durrës',
 				),
 				'DV' => array(
					'code' => 'DV',
 					'name' => 'Devoll',
 				),
 				'EL' => array(
					'code' => 'EL',
 					'name' => 'Elbasan',
 				),
 				'ER' => array(
					'code' => 'ER',
 					'name' => 'Kolonjë',
 				),
 				'FR' => array(
					'code' => 'FR',
 					'name' => 'Fier',
 				),
 				'GJ' => array(
					'code' => 'GJ',
 					'name' => 'Gjirokastër',
 				),
 				'GR' => array(
					'code' => 'GR',
 					'name' => 'Gramsh',
 				),
 				'HA' => array(
					'code' => 'HA',
 					'name' => 'Has',
 				),
 				'KA' => array(
					'code' => 'KA',
 					'name' => 'Kavajë',
 				),
 				'KC' => array(
					'code' => 'KC',
 					'name' => 'Kucovë',
 				),
 				'KO' => array(
					'code' => 'KO',
 					'name' => 'Korcë',
 				),
 				'KR' => array(
					'code' => 'KR',
 					'name' => 'Krujë',
 				),
 				'KU' => array(
					'code' => 'KU',
 					'name' => 'Kukës',
 				),
 				'LA' => array(
					'code' => 'LA',
 					'name' => 'Laç',
 				),
 				'LB' => array(
					'code' => 'LB',
 					'name' => 'Librazhd',
 				),
 				'LE' => array(
					'code' => 'LE',
 					'name' => 'Lezhë',
 				),
 				'LU' => array(
					'code' => 'LU',
 					'name' => 'Lushnjë',
 				),
 				'MK' => array(
					'code' => 'MK',
 					'name' => 'Mallakastër',
 				),
 				'MM' => array(
					'code' => 'MM',
 					'name' => 'Malësia e Madhe',
 				),
 				'MR' => array(
					'code' => 'MR',
 					'name' => 'Mirditë',
 				),
 				'MT' => array(
					'code' => 'MT',
 					'name' => 'Mat',
 				),
 				'PG' => array(
					'code' => 'PG',
 					'name' => 'Pogradec',
 				),
 				'PQ' => array(
					'code' => 'PQ',
 					'name' => 'Peqin',
 				),
 				'PR' => array(
					'code' => 'PR',
 					'name' => 'Përmet',
 				),
 				'PU' => array(
					'code' => 'PU',
 					'name' => 'Pukë',
 				),
 				'SH' => array(
					'code' => 'SH',
 					'name' => 'Shkodër',
 				),
 				'SK' => array(
					'code' => 'SK',
 					'name' => 'Skrapar',
 				),
 				'SR' => array(
					'code' => 'SR',
 					'name' => 'Sarandë',
 				),
 				'TE' => array(
					'code' => 'TE',
 					'name' => 'Tepelenë',
 				),
 				'TP' => array(
					'code' => 'TP',
 					'name' => 'Tropojë',
 				),
 				'TR' => array(
					'code' => 'TR',
 					'name' => 'Tiranë',
 				),
 				'VL' => array(
					'code' => 'VL',
 					'name' => 'Vlorë',
 				),
 			),
 		),
 		'AM' => array(
			'code' => 'AM',
 			'name' => 'Armenia',
 			'code3' => 'ARM',
 			'numeric' => '051',
 			'states' => array(
				'AG' => array(
					'code' => 'AG',
 					'name' => 'Aragacotn',
 				),
 				'AR' => array(
					'code' => 'AR',
 					'name' => 'Ararat',
 				),
 				'AV' => array(
					'code' => 'AV',
 					'name' => 'Armavir',
 				),
 				'ER' => array(
					'code' => 'ER',
 					'name' => 'Erevan',
 				),
 				'GR' => array(
					'code' => 'GR',
 					'name' => 'Geģark\'unik\'',
 				),
 				'KT' => array(
					'code' => 'KT',
 					'name' => 'Kotayk\'',
 				),
 				'LO' => array(
					'code' => 'LO',
 					'name' => 'Loŕy',
 				),
 				'SH' => array(
					'code' => 'SH',
 					'name' => 'Širak',
 				),
 				'SU' => array(
					'code' => 'SU',
 					'name' => 'Syunik\'',
 				),
 				'TV' => array(
					'code' => 'TV',
 					'name' => 'Tavuš',
 				),
 				'VD' => array(
					'code' => 'VD',
 					'name' => 'Vayoc Jor',
 				),
 			),
 		),
 		'AN' => array(
			'code' => 'AN',
 			'name' => 'Netherlands Antilles',
 			'code3' => 'ANT',
 			'numeric' => '',
 			'states' => array(
			),
 		),
 		'AO' => array(
			'code' => 'AO',
 			'name' => 'Angola',
 			'code3' => 'AGO',
 			'numeric' => '024',
 			'states' => array(
				'BGO' => array(
					'code' => 'BGO',
 					'name' => 'Bengo',
 				),
 				'BGU' => array(
					'code' => 'BGU',
 					'name' => 'Benguela',
 				),
 				'BIE' => array(
					'code' => 'BIE',
 					'name' => 'Bié',
 				),
 				'CAB' => array(
					'code' => 'CAB',
 					'name' => 'Cabinda',
 				),
 				'CCU' => array(
					'code' => 'CCU',
 					'name' => 'Cuando-Cubango',
 				),
 				'CNN' => array(
					'code' => 'CNN',
 					'name' => 'Cunene',
 				),
 				'CNO' => array(
					'code' => 'CNO',
 					'name' => 'Cuanza Norte',
 				),
 				'CUS' => array(
					'code' => 'CUS',
 					'name' => 'Cuanza Sul',
 				),
 				'HUA' => array(
					'code' => 'HUA',
 					'name' => 'Huambo',
 				),
 				'HUI' => array(
					'code' => 'HUI',
 					'name' => 'Huíla',
 				),
 				'LNO' => array(
					'code' => 'LNO',
 					'name' => 'Lunda Norte',
 				),
 				'LSU' => array(
					'code' => 'LSU',
 					'name' => 'Lunda Sul',
 				),
 				'LUA' => array(
					'code' => 'LUA',
 					'name' => 'Luanda',
 				),
 				'MAL' => array(
					'code' => 'MAL',
 					'name' => 'Malange',
 				),
 				'MOX' => array(
					'code' => 'MOX',
 					'name' => 'Moxico',
 				),
 				'NAM' => array(
					'code' => 'NAM',
 					'name' => 'Namibe',
 				),
 				'UIG' => array(
					'code' => 'UIG',
 					'name' => 'Uíge',
 				),
 				'ZAI' => array(
					'code' => 'ZAI',
 					'name' => 'Zaïre',
 				),
 			),
 		),
 		'AQ' => array(
			'code' => 'AQ',
 			'name' => 'Antarctica',
 			'code3' => 'ATA',
 			'numeric' => '010',
 			'states' => array(
			),
 		),
 		'AR' => array(
			'code' => 'AR',
 			'name' => 'Argentina',
 			'code3' => 'ARG',
 			'numeric' => '032',
 			'states' => array(
				'A' => array(
					'code' => 'A',
 					'name' => 'Salta',
 				),
 				'B' => array(
					'code' => 'B',
 					'name' => 'Buenos Aires',
 				),
 				'C' => array(
					'code' => 'C',
 					'name' => 'Capital federal',
 				),
 				'D' => array(
					'code' => 'D',
 					'name' => 'San Luis',
 				),
 				'E' => array(
					'code' => 'E',
 					'name' => 'Entre Ríos',
 				),
 				'F' => array(
					'code' => 'F',
 					'name' => 'La Rioja',
 				),
 				'G' => array(
					'code' => 'G',
 					'name' => 'Santiago del Estero',
 				),
 				'H' => array(
					'code' => 'H',
 					'name' => 'Chaco',
 				),
 				'J' => array(
					'code' => 'J',
 					'name' => 'San Juan',
 				),
 				'K' => array(
					'code' => 'K',
 					'name' => 'Catamarca',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'La Pampa',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'Mendoza',
 				),
 				'N' => array(
					'code' => 'N',
 					'name' => 'Misiones',
 				),
 				'P' => array(
					'code' => 'P',
 					'name' => 'Formosa',
 				),
 				'Q' => array(
					'code' => 'Q',
 					'name' => 'Neuquén',
 				),
 				'R' => array(
					'code' => 'R',
 					'name' => 'Río Negro',
 				),
 				'S' => array(
					'code' => 'S',
 					'name' => 'Santa Fe',
 				),
 				'T' => array(
					'code' => 'T',
 					'name' => 'Tucumán',
 				),
 				'U' => array(
					'code' => 'U',
 					'name' => 'Chubut',
 				),
 				'V' => array(
					'code' => 'V',
 					'name' => 'Tierra del Fuego',
 				),
 				'W' => array(
					'code' => 'W',
 					'name' => 'Corrientes',
 				),
 				'X' => array(
					'code' => 'X',
 					'name' => 'Córdoba',
 				),
 				'Y' => array(
					'code' => 'Y',
 					'name' => 'Jujuy',
 				),
 				'Z' => array(
					'code' => 'Z',
 					'name' => 'Santa Cruz',
 				),
 			),
 		),
 		'AS' => array(
			'code' => 'AS',
 			'name' => 'American Samoa',
 			'code3' => 'ASM',
 			'numeric' => '016',
 			'states' => array(
			),
 		),
 		'AT' => array(
			'code' => 'AT',
 			'name' => 'Austria',
 			'code3' => 'AUT',
 			'numeric' => '040',
 			'states' => array(
				'1' => array(
					'code' => '1',
 					'name' => 'Burgenland',
 				),
 				'2' => array(
					'code' => '2',
 					'name' => 'Kärnten',
 				),
 				'3' => array(
					'code' => '3',
 					'name' => 'Niederösterreich',
 				),
 				'4' => array(
					'code' => '4',
 					'name' => 'Oberösterreich',
 				),
 				'5' => array(
					'code' => '5',
 					'name' => 'Salzburg',
 				),
 				'6' => array(
					'code' => '6',
 					'name' => 'Steiermark',
 				),
 				'7' => array(
					'code' => '7',
 					'name' => 'Tirol',
 				),
 				'8' => array(
					'code' => '8',
 					'name' => 'Vorarlberg',
 				),
 				'9' => array(
					'code' => '9',
 					'name' => 'Wien',
 				),
 			),
 		),
 		'AU' => array(
			'code' => 'AU',
 			'name' => 'Australia',
 			'code3' => 'AUS',
 			'numeric' => '036',
 			'states' => array(
				'CT' => array(
					'code' => 'CT',
 					'name' => 'Australian Capital Territory',
 				),
 				'NS' => array(
					'code' => 'NS',
 					'name' => 'New South Wales',
 				),
 				'NT' => array(
					'code' => 'NT',
 					'name' => 'Northern Territory',
 				),
 				'QL' => array(
					'code' => 'QL',
 					'name' => 'Queensland',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'South Australia',
 				),
 				'TS' => array(
					'code' => 'TS',
 					'name' => 'Tasmania',
 				),
 				'VI' => array(
					'code' => 'VI',
 					'name' => 'Victoria',
 				),
 				'WA' => array(
					'code' => 'WA',
 					'name' => 'Western Australia',
 				),
 			),
 		),
 		'AW' => array(
			'code' => 'AW',
 			'name' => 'Aruba',
 			'code3' => 'ABW',
 			'numeric' => '533',
 			'states' => array(
			),
 		),
 		'AX' => array(
			'code' => 'AX',
 			'name' => 'Aland Islands',
 			'code3' => 'ALA',
 			'numeric' => '248',
 			'states' => array(
			),
 		),
 		'AZ' => array(
			'code' => 'AZ',
 			'name' => 'Azerbaijan',
 			'code3' => 'AZE',
 			'numeric' => '031',
 			'states' => array(
				'AB' => array(
					'code' => 'AB',
 					'name' => 'Äli Bayramli',
 				),
 				'ABS' => array(
					'code' => 'ABS',
 					'name' => 'Abşeron',
 				),
 				'AGA' => array(
					'code' => 'AGA',
 					'name' => 'Ağstafa',
 				),
 				'AGC' => array(
					'code' => 'AGC',
 					'name' => 'Ağcabädi',
 				),
 				'AGM' => array(
					'code' => 'AGM',
 					'name' => 'Ağdam',
 				),
 				'AGS' => array(
					'code' => 'AGS',
 					'name' => 'Ağdas',
 				),
 				'AGU' => array(
					'code' => 'AGU',
 					'name' => 'Ağsu',
 				),
 				'AST' => array(
					'code' => 'AST',
 					'name' => 'Astara',
 				),
 				'BA' => array(
					'code' => 'BA',
 					'name' => 'Baki',
 				),
 				'BAB' => array(
					'code' => 'BAB',
 					'name' => 'Babäk',
 				),
 				'BAL' => array(
					'code' => 'BAL',
 					'name' => 'Balakän',
 				),
 				'BAR' => array(
					'code' => 'BAR',
 					'name' => 'Bärdä',
 				),
 				'BEY' => array(
					'code' => 'BEY',
 					'name' => 'Beyläqan',
 				),
 				'BIL' => array(
					'code' => 'BIL',
 					'name' => 'Biläsuvar',
 				),
 				'CAB' => array(
					'code' => 'CAB',
 					'name' => 'Cäbrayil',
 				),
 				'CAL' => array(
					'code' => 'CAL',
 					'name' => 'Cälilabad',
 				),
 				'CUL' => array(
					'code' => 'CUL',
 					'name' => 'Culfa',
 				),
 				'DAS' => array(
					'code' => 'DAS',
 					'name' => 'Daşkäsän',
 				),
 				'DAV' => array(
					'code' => 'DAV',
 					'name' => 'Däväçi',
 				),
 				'FUZ' => array(
					'code' => 'FUZ',
 					'name' => 'Füzuli',
 				),
 				'GA' => array(
					'code' => 'GA',
 					'name' => 'Gäncä',
 				),
 				'GAD' => array(
					'code' => 'GAD',
 					'name' => 'Gädäbäy',
 				),
 				'GOR' => array(
					'code' => 'GOR',
 					'name' => 'Goranboy',
 				),
 				'GOY' => array(
					'code' => 'GOY',
 					'name' => 'Göyçay',
 				),
 				'HAC' => array(
					'code' => 'HAC',
 					'name' => 'Haciqabul',
 				),
 				'IMI' => array(
					'code' => 'IMI',
 					'name' => 'Imişli',
 				),
 				'ISM' => array(
					'code' => 'ISM',
 					'name' => 'Ismayilli',
 				),
 				'KAL' => array(
					'code' => 'KAL',
 					'name' => 'Kälbäcär',
 				),
 				'KUR' => array(
					'code' => 'KUR',
 					'name' => 'Kürdämir',
 				),
 				'LA' => array(
					'code' => 'LA',
 					'name' => 'Länkäran',
 				),
 				'LAC' => array(
					'code' => 'LAC',
 					'name' => 'Laçin',
 				),
 				'LAN' => array(
					'code' => 'LAN',
 					'name' => 'Länkäran',
 				),
 				'LER' => array(
					'code' => 'LER',
 					'name' => 'Lerik',
 				),
 				'MAS' => array(
					'code' => 'MAS',
 					'name' => 'Masalli',
 				),
 				'MI' => array(
					'code' => 'MI',
 					'name' => 'Mingäçevir',
 				),
 				'MM' => array(
					'code' => 'MM',
 					'name' => 'Naxçivan',
 				),
 				'NA' => array(
					'code' => 'NA',
 					'name' => 'Naftalan',
 				),
 				'NEF' => array(
					'code' => 'NEF',
 					'name' => 'Neftçala',
 				),
 				'OGU' => array(
					'code' => 'OGU',
 					'name' => 'Oğuz',
 				),
 				'ORD' => array(
					'code' => 'ORD',
 					'name' => 'Ordubad',
 				),
 				'QAB' => array(
					'code' => 'QAB',
 					'name' => 'Qäbälä',
 				),
 				'QAX' => array(
					'code' => 'QAX',
 					'name' => 'Qax',
 				),
 				'QAZ' => array(
					'code' => 'QAZ',
 					'name' => 'Qazax',
 				),
 				'QBA' => array(
					'code' => 'QBA',
 					'name' => 'Quba',
 				),
 				'QBI' => array(
					'code' => 'QBI',
 					'name' => 'Qubadlı',
 				),
 				'QOB' => array(
					'code' => 'QOB',
 					'name' => 'Qobustan',
 				),
 				'QUS' => array(
					'code' => 'QUS',
 					'name' => 'Qusar',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Şäki',
 				),
 				'SAB' => array(
					'code' => 'SAB',
 					'name' => 'Sabirabad',
 				),
 				'SAD' => array(
					'code' => 'SAD',
 					'name' => 'Sädäräk',
 				),
 				'SAH' => array(
					'code' => 'SAH',
 					'name' => 'Şahbuz',
 				),
 				'SAK' => array(
					'code' => 'SAK',
 					'name' => 'Şäki',
 				),
 				'SAL' => array(
					'code' => 'SAL',
 					'name' => 'Salyan',
 				),
 				'SAR' => array(
					'code' => 'SAR',
 					'name' => 'Şärur',
 				),
 				'SAT' => array(
					'code' => 'SAT',
 					'name' => 'Saatli',
 				),
 				'SIY' => array(
					'code' => 'SIY',
 					'name' => 'Siyäzän',
 				),
 				'SKR' => array(
					'code' => 'SKR',
 					'name' => 'Şämkir',
 				),
 				'SM' => array(
					'code' => 'SM',
 					'name' => 'Sumqayit',
 				),
 				'SMI' => array(
					'code' => 'SMI',
 					'name' => 'Şamaxı',
 				),
 				'SMX' => array(
					'code' => 'SMX',
 					'name' => 'Samux',
 				),
 				'SS' => array(
					'code' => 'SS',
 					'name' => 'Şuşa',
 				),
 				'SUS' => array(
					'code' => 'SUS',
 					'name' => 'Şuşa',
 				),
 				'TAR' => array(
					'code' => 'TAR',
 					'name' => 'Tärtär',
 				),
 				'TOV' => array(
					'code' => 'TOV',
 					'name' => 'Tovuz',
 				),
 				'UCA' => array(
					'code' => 'UCA',
 					'name' => 'Ucar',
 				),
 				'XA' => array(
					'code' => 'XA',
 					'name' => 'Xankändi',
 				),
 				'XAC' => array(
					'code' => 'XAC',
 					'name' => 'Xaçmaz',
 				),
 				'XAN' => array(
					'code' => 'XAN',
 					'name' => 'Xanlar',
 				),
 				'XCI' => array(
					'code' => 'XCI',
 					'name' => 'Xocalı',
 				),
 				'XIZ' => array(
					'code' => 'XIZ',
 					'name' => 'Xizi',
 				),
 				'XVD' => array(
					'code' => 'XVD',
 					'name' => 'Xocavänd',
 				),
 				'YAR' => array(
					'code' => 'YAR',
 					'name' => 'Yardimli',
 				),
 				'YE' => array(
					'code' => 'YE',
 					'name' => 'Yevlax',
 				),
 				'YEV' => array(
					'code' => 'YEV',
 					'name' => 'Yevlax',
 				),
 				'ZAN' => array(
					'code' => 'ZAN',
 					'name' => 'Zängılan',
 				),
 				'ZAQ' => array(
					'code' => 'ZAQ',
 					'name' => 'Zaqatala',
 				),
 				'ZAR' => array(
					'code' => 'ZAR',
 					'name' => 'Zärdab',
 				),
 			),
 		),
 		'BA' => array(
			'code' => 'BA',
 			'name' => 'Bosnia & Herzegovina',
 			'code3' => 'BIH',
 			'numeric' => '070',
 			'states' => array(
				'BIH' => array(
					'code' => 'BIH',
 					'name' => 'Federacija Bosna i Hercegovina',
 				),
 				'SRP' => array(
					'code' => 'SRP',
 					'name' => 'Republika Srpska',
 				),
 			),
 		),
 		'BB' => array(
			'code' => 'BB',
 			'name' => 'Barbados',
 			'code3' => 'BRB',
 			'numeric' => '052',
 			'states' => array(
			),
 		),
 		'BD' => array(
			'code' => 'BD',
 			'name' => 'Bangladesh',
 			'code3' => 'BGD',
 			'numeric' => '050',
 			'states' => array(
				'1' => array(
					'code' => '1',
 					'name' => 'Barisal bibhag',
 				),
 				'1B' => array(
					'code' => '1B',
 					'name' => 'Barisal anchal',
 				),
 				'1Q' => array(
					'code' => '1Q',
 					'name' => 'Patuakhali anchal',
 				),
 				'2' => array(
					'code' => '2',
 					'name' => 'Chittagong bibhag',
 				),
 				'2A' => array(
					'code' => '2A',
 					'name' => 'Bandarban anchal',
 				),
 				'2D' => array(
					'code' => '2D',
 					'name' => 'Chittagong anchal',
 				),
 				'2E' => array(
					'code' => '2E',
 					'name' => 'Chittagong Hill Tracts',
 				),
 				'2F' => array(
					'code' => '2F',
 					'name' => 'Comilla anchal',
 				),
 				'2O' => array(
					'code' => '2O',
 					'name' => 'Noakhali anchal',
 				),
 				'2T' => array(
					'code' => '2T',
 					'name' => 'Sylhet anchal',
 				),
 				'3' => array(
					'code' => '3',
 					'name' => 'Dhaka bibhag',
 				),
 				'3G' => array(
					'code' => '3G',
 					'name' => 'Dhaka anchal',
 				),
 				'3I' => array(
					'code' => '3I',
 					'name' => 'Faridpur anchal',
 				),
 				'3J' => array(
					'code' => '3J',
 					'name' => 'Jamalpur anchal',
 				),
 				'3N' => array(
					'code' => '3N',
 					'name' => 'Mymensingh anchal',
 				),
 				'3U' => array(
					'code' => '3U',
 					'name' => 'Tangail anchal',
 				),
 				'4' => array(
					'code' => '4',
 					'name' => 'Khulna bibhag',
 				),
 				'4K' => array(
					'code' => '4K',
 					'name' => 'Jessore anchal',
 				),
 				'4L' => array(
					'code' => '4L',
 					'name' => 'Khulna anchal',
 				),
 				'4M' => array(
					'code' => '4M',
 					'name' => 'Khustia anchal',
 				),
 				'5' => array(
					'code' => '5',
 					'name' => 'Rajshahi bibhag',
 				),
 				'5C' => array(
					'code' => '5C',
 					'name' => 'Bogra anchal',
 				),
 				'5H' => array(
					'code' => '5H',
 					'name' => 'Dinajpur anchal',
 				),
 				'5P' => array(
					'code' => '5P',
 					'name' => 'Pabna anchal',
 				),
 				'5R' => array(
					'code' => '5R',
 					'name' => 'Rajshahi anchal',
 				),
 				'5S' => array(
					'code' => '5S',
 					'name' => 'Rangpur anchal',
 				),
 			),
 		),
 		'BE' => array(
			'code' => 'BE',
 			'name' => 'Belgium',
 			'code3' => 'BEL',
 			'numeric' => '056',
 			'states' => array(
				'BRU' => array(
					'code' => 'BRU',
 					'name' => 'Bruxelles-Capitale, Region de (fr), Brussels Hoofdstedelijk Gewest',
 				),
 				'VAN' => array(
					'code' => 'VAN',
 					'name' => 'Antwerpen',
 				),
 				'VBR' => array(
					'code' => 'VBR',
 					'name' => 'Vlaams Brabant',
 				),
 				'VLG' => array(
					'code' => 'VLG',
 					'name' => 'Vlaamse Gewest',
 				),
 				'VLI' => array(
					'code' => 'VLI',
 					'name' => 'Limburg',
 				),
 				'VOV' => array(
					'code' => 'VOV',
 					'name' => 'Oost-Vlaanderen',
 				),
 				'VWV' => array(
					'code' => 'VWV',
 					'name' => 'West-Vlaanderen',
 				),
 				'WAL' => array(
					'code' => 'WAL',
 					'name' => 'Wallonne, Region',
 				),
 				'WBR' => array(
					'code' => 'WBR',
 					'name' => 'Brabant Wallon',
 				),
 				'WHT' => array(
					'code' => 'WHT',
 					'name' => 'Hainaut',
 				),
 				'WLG' => array(
					'code' => 'WLG',
 					'name' => 'Liège',
 				),
 				'WLX' => array(
					'code' => 'WLX',
 					'name' => 'Luxembourg',
 				),
 				'WNA' => array(
					'code' => 'WNA',
 					'name' => 'Namur',
 				),
 			),
 		),
 		'BF' => array(
			'code' => 'BF',
 			'name' => 'Burkina Faso',
 			'code3' => 'BFA',
 			'numeric' => '854',
 			'states' => array(
				'BAL' => array(
					'code' => 'BAL',
 					'name' => 'Balé',
 				),
 				'BAM' => array(
					'code' => 'BAM',
 					'name' => 'Bam',
 				),
 				'BAN' => array(
					'code' => 'BAN',
 					'name' => 'Banwa',
 				),
 				'BAZ' => array(
					'code' => 'BAZ',
 					'name' => 'Bazèga',
 				),
 				'BGR' => array(
					'code' => 'BGR',
 					'name' => 'Bougouriba',
 				),
 				'BLG' => array(
					'code' => 'BLG',
 					'name' => 'Boulgou',
 				),
 				'BLK' => array(
					'code' => 'BLK',
 					'name' => 'Boulkiemdé',
 				),
 				'COM' => array(
					'code' => 'COM',
 					'name' => 'Comoé',
 				),
 				'GAN' => array(
					'code' => 'GAN',
 					'name' => 'Ganzourgou',
 				),
 				'GNA' => array(
					'code' => 'GNA',
 					'name' => 'Gnagna',
 				),
 				'GOU' => array(
					'code' => 'GOU',
 					'name' => 'Gourma',
 				),
 				'HOU' => array(
					'code' => 'HOU',
 					'name' => 'Houet',
 				),
 				'IOB' => array(
					'code' => 'IOB',
 					'name' => 'Ioba',
 				),
 				'KAD' => array(
					'code' => 'KAD',
 					'name' => 'Kadiogo',
 				),
 				'KEN' => array(
					'code' => 'KEN',
 					'name' => 'Kénédougou',
 				),
 				'KMD' => array(
					'code' => 'KMD',
 					'name' => 'Komondjari',
 				),
 				'KMP' => array(
					'code' => 'KMP',
 					'name' => 'Kompienga',
 				),
 				'KOP' => array(
					'code' => 'KOP',
 					'name' => 'Koulpélogo',
 				),
 				'KOS' => array(
					'code' => 'KOS',
 					'name' => 'Kossi',
 				),
 				'KOT' => array(
					'code' => 'KOT',
 					'name' => 'Kouritenga',
 				),
 				'KOW' => array(
					'code' => 'KOW',
 					'name' => 'Kourwéogo',
 				),
 				'LER' => array(
					'code' => 'LER',
 					'name' => 'Léraba',
 				),
 				'LOR' => array(
					'code' => 'LOR',
 					'name' => 'Loroum',
 				),
 				'MOU' => array(
					'code' => 'MOU',
 					'name' => 'Mouhoun',
 				),
 				'NAM' => array(
					'code' => 'NAM',
 					'name' => 'Namentenga',
 				),
 				'NAO' => array(
					'code' => 'NAO',
 					'name' => 'Nahouri',
 				),
 				'NAY' => array(
					'code' => 'NAY',
 					'name' => 'Nayala',
 				),
 				'NOU' => array(
					'code' => 'NOU',
 					'name' => 'Noumbiel',
 				),
 				'OUB' => array(
					'code' => 'OUB',
 					'name' => 'Oubritenga',
 				),
 				'OUD' => array(
					'code' => 'OUD',
 					'name' => 'Oudalan',
 				),
 				'PAS' => array(
					'code' => 'PAS',
 					'name' => 'Passoré',
 				),
 				'PON' => array(
					'code' => 'PON',
 					'name' => 'Poni',
 				),
 				'SEN' => array(
					'code' => 'SEN',
 					'name' => 'Séno',
 				),
 				'SIS' => array(
					'code' => 'SIS',
 					'name' => 'Sissili',
 				),
 				'SMT' => array(
					'code' => 'SMT',
 					'name' => 'Sanmatenga',
 				),
 				'SNG' => array(
					'code' => 'SNG',
 					'name' => 'Sanguié',
 				),
 				'SOM' => array(
					'code' => 'SOM',
 					'name' => 'Soum',
 				),
 				'SOR' => array(
					'code' => 'SOR',
 					'name' => 'Sourou',
 				),
 				'TAP' => array(
					'code' => 'TAP',
 					'name' => 'Tapoa',
 				),
 				'TUI' => array(
					'code' => 'TUI',
 					'name' => 'Tui',
 				),
 				'YAG' => array(
					'code' => 'YAG',
 					'name' => 'Yagha',
 				),
 				'YAT' => array(
					'code' => 'YAT',
 					'name' => 'Yatenga',
 				),
 				'ZIR' => array(
					'code' => 'ZIR',
 					'name' => 'Ziro',
 				),
 				'ZON' => array(
					'code' => 'ZON',
 					'name' => 'Zondoma',
 				),
 				'ZOU' => array(
					'code' => 'ZOU',
 					'name' => 'Zoundwéogo',
 				),
 			),
 		),
 		'BG' => array(
			'code' => 'BG',
 			'name' => 'Bulgaria',
 			'code3' => 'BGR',
 			'numeric' => '100',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Sofija-Grad',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Burgas',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Varna',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Loveč',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Montana',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Plovdiv',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Ruse',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Sofija',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Haskovo',
 				),
 			),
 		),
 		'BH' => array(
			'code' => 'BH',
 			'name' => 'Bahrain',
 			'code3' => 'BHR',
 			'numeric' => '048',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Al Ḩadd',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Al Muḩarraq',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Al Manāmah',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Jidd Ḩafş',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Al Minţaqah ash Shamālīyah',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Sitrah',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Al Minţaqah al Wusţa',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Madīnat ‘Īsá',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Ar Rifā‘',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Al Minţaqah al Gharbīyah',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Minţaqat Juzur Ḩawār',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Madīnat Ḩamad',
 				),
 			),
 		),
 		'BI' => array(
			'code' => 'BI',
 			'name' => 'Burundi',
 			'code3' => 'BDI',
 			'numeric' => '108',
 			'states' => array(
				'BB' => array(
					'code' => 'BB',
 					'name' => 'Bubanza',
 				),
 				'BJ' => array(
					'code' => 'BJ',
 					'name' => 'Bujumbura',
 				),
 				'BR' => array(
					'code' => 'BR',
 					'name' => 'Bururi',
 				),
 				'CA' => array(
					'code' => 'CA',
 					'name' => 'Cankuzo',
 				),
 				'CI' => array(
					'code' => 'CI',
 					'name' => 'Cibitoke',
 				),
 				'GI' => array(
					'code' => 'GI',
 					'name' => 'Gitega',
 				),
 				'KI' => array(
					'code' => 'KI',
 					'name' => 'Kirundo',
 				),
 				'KR' => array(
					'code' => 'KR',
 					'name' => 'Karuzi',
 				),
 				'KY' => array(
					'code' => 'KY',
 					'name' => 'Kayanza',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Makamba',
 				),
 				'MU' => array(
					'code' => 'MU',
 					'name' => 'Muramvya',
 				),
 				'MY' => array(
					'code' => 'MY',
 					'name' => 'Muyinga',
 				),
 				'NG' => array(
					'code' => 'NG',
 					'name' => 'Ngozi',
 				),
 				'RT' => array(
					'code' => 'RT',
 					'name' => 'Rutana',
 				),
 				'RY' => array(
					'code' => 'RY',
 					'name' => 'Ruyigi',
 				),
 			),
 		),
 		'BJ' => array(
			'code' => 'BJ',
 			'name' => 'Benin',
 			'code3' => 'BEN',
 			'numeric' => '204',
 			'states' => array(
				'AK' => array(
					'code' => 'AK',
 					'name' => 'Atakora',
 				),
 				'AQ' => array(
					'code' => 'AQ',
 					'name' => 'Atlantique',
 				),
 				'BO' => array(
					'code' => 'BO',
 					'name' => 'Borgou',
 				),
 				'MO' => array(
					'code' => 'MO',
 					'name' => 'Mono',
 				),
 				'OU' => array(
					'code' => 'OU',
 					'name' => 'Ouémé',
 				),
 				'ZO' => array(
					'code' => 'ZO',
 					'name' => 'Zou',
 				),
 			),
 		),
 		'BM' => array(
			'code' => 'BM',
 			'name' => 'Bermuda',
 			'code3' => 'BMU',
 			'numeric' => '060',
 			'states' => array(
			),
 		),
 		'BN' => array(
			'code' => 'BN',
 			'name' => 'Brunei Darussalam',
 			'code3' => 'BRN',
 			'numeric' => '096',
 			'states' => array(
				'BE' => array(
					'code' => 'BE',
 					'name' => 'Belait',
 				),
 				'BM' => array(
					'code' => 'BM',
 					'name' => 'Brunei-Muara',
 				),
 				'TE' => array(
					'code' => 'TE',
 					'name' => 'Temburong',
 				),
 				'TU' => array(
					'code' => 'TU',
 					'name' => 'Tutong',
 				),
 			),
 		),
 		'BO' => array(
			'code' => 'BO',
 			'name' => 'Bolivia',
 			'code3' => 'BOL',
 			'numeric' => '068',
 			'states' => array(
				'B' => array(
					'code' => 'B',
 					'name' => 'El Beni',
 				),
 				'C' => array(
					'code' => 'C',
 					'name' => 'Cochabamba',
 				),
 				'H' => array(
					'code' => 'H',
 					'name' => 'Chuquisaca',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'La Paz',
 				),
 				'N' => array(
					'code' => 'N',
 					'name' => 'Pando',
 				),
 				'O' => array(
					'code' => 'O',
 					'name' => 'Oruro',
 				),
 				'P' => array(
					'code' => 'P',
 					'name' => 'Potosi',
 				),
 				'S' => array(
					'code' => 'S',
 					'name' => 'Santa Cruz',
 				),
 				'T' => array(
					'code' => 'T',
 					'name' => 'Tarija',
 				),
 			),
 		),
 		'BR' => array(
			'code' => 'BR',
 			'name' => 'Brazil',
 			'code3' => 'BRA',
 			'numeric' => '076',
 			'states' => array(
				'AC' => array(
					'code' => 'AC',
 					'name' => 'Acre',
 				),
 				'AL' => array(
					'code' => 'AL',
 					'name' => 'Alagoas',
 				),
 				'AM' => array(
					'code' => 'AM',
 					'name' => 'Amazonas',
 				),
 				'AP' => array(
					'code' => 'AP',
 					'name' => 'Amapá',
 				),
 				'BA' => array(
					'code' => 'BA',
 					'name' => 'Bahia',
 				),
 				'CE' => array(
					'code' => 'CE',
 					'name' => 'Ceará',
 				),
 				'DF' => array(
					'code' => 'DF',
 					'name' => 'Distrito Federal',
 				),
 				'ES' => array(
					'code' => 'ES',
 					'name' => 'Espírito Santo',
 				),
 				'GO' => array(
					'code' => 'GO',
 					'name' => 'Goiás',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Maranhāo',
 				),
 				'MG' => array(
					'code' => 'MG',
 					'name' => 'Minas Gerais',
 				),
 				'MS' => array(
					'code' => 'MS',
 					'name' => 'Mato Grosso do Sul',
 				),
 				'MT' => array(
					'code' => 'MT',
 					'name' => 'Mato Grosso',
 				),
 				'PA' => array(
					'code' => 'PA',
 					'name' => 'Pará',
 				),
 				'PB' => array(
					'code' => 'PB',
 					'name' => 'Paraíba',
 				),
 				'PE' => array(
					'code' => 'PE',
 					'name' => 'Pernambuco',
 				),
 				'PI' => array(
					'code' => 'PI',
 					'name' => 'Piauí',
 				),
 				'PR' => array(
					'code' => 'PR',
 					'name' => 'Paraná',
 				),
 				'R0' => array(
					'code' => 'R0',
 					'name' => 'Rondônia',
 				),
 				'RJ' => array(
					'code' => 'RJ',
 					'name' => 'Rio de Janeiro',
 				),
 				'RN' => array(
					'code' => 'RN',
 					'name' => 'Rio Grande do Norte',
 				),
 				'RR' => array(
					'code' => 'RR',
 					'name' => 'Roraima',
 				),
 				'RS' => array(
					'code' => 'RS',
 					'name' => 'Rio Grande do Sul',
 				),
 				'SC' => array(
					'code' => 'SC',
 					'name' => 'Santa Catarina',
 				),
 				'SE' => array(
					'code' => 'SE',
 					'name' => 'Sergipe',
 				),
 				'SP' => array(
					'code' => 'SP',
 					'name' => 'São Paulo',
 				),
 				'TO' => array(
					'code' => 'TO',
 					'name' => 'Tocantins',
 				),
 			),
 		),
 		'BS' => array(
			'code' => 'BS',
 			'name' => 'Bahamas',
 			'code3' => 'BHS',
 			'numeric' => '044',
 			'states' => array(
				'AC' => array(
					'code' => 'AC',
 					'name' => 'Acklins and Crooked Islands',
 				),
 				'BI' => array(
					'code' => 'BI',
 					'name' => 'Bimini',
 				),
 				'CI' => array(
					'code' => 'CI',
 					'name' => 'Cat Island',
 				),
 				'EX' => array(
					'code' => 'EX',
 					'name' => 'Exuma',
 				),
 				'FC' => array(
					'code' => 'FC',
 					'name' => 'Fresh Creek',
 				),
 				'FP' => array(
					'code' => 'FP',
 					'name' => 'Freeport',
 				),
 				'GH' => array(
					'code' => 'GH',
 					'name' => 'Governor\'s Harbour',
 				),
 				'GT' => array(
					'code' => 'GT',
 					'name' => 'Green Turtle Cay',
 				),
 				'HI' => array(
					'code' => 'HI',
 					'name' => 'Harbour Island',
 				),
 				'HR' => array(
					'code' => 'HR',
 					'name' => 'High Rock',
 				),
 				'IN' => array(
					'code' => 'IN',
 					'name' => 'Inagua',
 				),
 				'KB' => array(
					'code' => 'KB',
 					'name' => 'Kemps Bay',
 				),
 				'LI' => array(
					'code' => 'LI',
 					'name' => 'Long Island',
 				),
 				'MG' => array(
					'code' => 'MG',
 					'name' => 'Mayaguana',
 				),
 				'MH' => array(
					'code' => 'MH',
 					'name' => 'Marsh Harbour',
 				),
 				'NB' => array(
					'code' => 'NB',
 					'name' => 'Nicholls Town and Berry Islands',
 				),
 				'NP' => array(
					'code' => 'NP',
 					'name' => 'New Providence',
 				),
 				'RI' => array(
					'code' => 'RI',
 					'name' => 'Ragged Island',
 				),
 				'RS' => array(
					'code' => 'RS',
 					'name' => 'Rock Sound',
 				),
 				'SP' => array(
					'code' => 'SP',
 					'name' => 'Sandy Point',
 				),
 				'SR' => array(
					'code' => 'SR',
 					'name' => 'San Salvador and Rum Cay',
 				),
 			),
 		),
 		'BT' => array(
			'code' => 'BT',
 			'name' => 'Bhutan',
 			'code3' => 'BTN',
 			'numeric' => '064',
 			'states' => array(
				'11' => array(
					'code' => '11',
 					'name' => 'Paro',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Chhukha',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Ha',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Samtse',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Thimphu',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Tsirang',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Dagana',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Punakha',
 				),
 				'24' => array(
					'code' => '24',
 					'name' => 'Wangdue Phodrang',
 				),
 				'31' => array(
					'code' => '31',
 					'name' => 'Sarpang',
 				),
 				'32' => array(
					'code' => '32',
 					'name' => 'Trongsa',
 				),
 				'33' => array(
					'code' => '33',
 					'name' => 'Bumthang',
 				),
 				'34' => array(
					'code' => '34',
 					'name' => 'Zhemgang',
 				),
 				'41' => array(
					'code' => '41',
 					'name' => 'Trashigang',
 				),
 				'42' => array(
					'code' => '42',
 					'name' => 'Monggar',
 				),
 				'43' => array(
					'code' => '43',
 					'name' => 'Pemagatshel',
 				),
 				'44' => array(
					'code' => '44',
 					'name' => 'Lhuentse',
 				),
 				'45' => array(
					'code' => '45',
 					'name' => 'Samdrup Jongkha',
 				),
 				'GA' => array(
					'code' => 'GA',
 					'name' => 'Gasa',
 				),
 				'TY' => array(
					'code' => 'TY',
 					'name' => 'Trashi Yangtse',
 				),
 			),
 		),
 		'BV' => array(
			'code' => 'BV',
 			'name' => 'Bouvet Island',
 			'code3' => 'BVT',
 			'numeric' => '074',
 			'states' => array(
			),
 		),
 		'BW' => array(
			'code' => 'BW',
 			'name' => 'Botswana',
 			'code3' => 'BWA',
 			'numeric' => '072',
 			'states' => array(
				'CE' => array(
					'code' => 'CE',
 					'name' => 'Central [Serowe-Palapye]',
 				),
 				'CH' => array(
					'code' => 'CH',
 					'name' => 'Chobe',
 				),
 				'GH' => array(
					'code' => 'GH',
 					'name' => 'Ghanzi',
 				),
 				'KG' => array(
					'code' => 'KG',
 					'name' => 'Kgalagadi',
 				),
 				'KL' => array(
					'code' => 'KL',
 					'name' => 'Kgatleng',
 				),
 				'KW' => array(
					'code' => 'KW',
 					'name' => 'Kweneng',
 				),
 				'NE' => array(
					'code' => 'NE',
 					'name' => 'North-East',
 				),
 				'NG' => array(
					'code' => 'NG',
 					'name' => 'Ngamiland [North-West]',
 				),
 				'SE' => array(
					'code' => 'SE',
 					'name' => 'South-East',
 				),
 				'SO' => array(
					'code' => 'SO',
 					'name' => 'Southern [Ngwaketse]',
 				),
 			),
 		),
 		'BY' => array(
			'code' => 'BY',
 			'name' => 'Belarus',
 			'code3' => 'BLR',
 			'numeric' => '112',
 			'states' => array(
				'BR' => array(
					'code' => 'BR',
 					'name' => 'Brestskaya voblasts\'',
 				),
 				'HO' => array(
					'code' => 'HO',
 					'name' => 'Homyel\'skaya voblasts’',
 				),
 				'HR' => array(
					'code' => 'HR',
 					'name' => 'Hrodnenskaya voblasts\'',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Mahilyowskaya voblasts\'',
 				),
 				'MI' => array(
					'code' => 'MI',
 					'name' => 'Minskaya voblasts\'',
 				),
 				'VI' => array(
					'code' => 'VI',
 					'name' => 'Vitsyebskaya voblasts\'',
 				),
 			),
 		),
 		'BZ' => array(
			'code' => 'BZ',
 			'name' => 'Belize',
 			'code3' => 'BLZ',
 			'numeric' => '084',
 			'states' => array(
				'CY' => array(
					'code' => 'CY',
 					'name' => 'Cayo',
 				),
 				'CZL' => array(
					'code' => 'CZL',
 					'name' => 'Corozal',
 				),
 				'OW' => array(
					'code' => 'OW',
 					'name' => 'Orange Walk',
 				),
 				'SC' => array(
					'code' => 'SC',
 					'name' => 'Stann Creek',
 				),
 				'TOL' => array(
					'code' => 'TOL',
 					'name' => 'Toledo',
 				),
 			),
 		),
 		'CA' => array(
			'code' => 'CA',
 			'name' => 'Canada',
 			'code3' => 'CAN',
 			'numeric' => '124',
 			'states' => array(
				'AB' => array(
					'code' => 'AB',
 					'name' => 'Alberta',
 				),
 				'BC' => array(
					'code' => 'BC',
 					'name' => 'British Columbia',
 				),
 				'MB' => array(
					'code' => 'MB',
 					'name' => 'Manitoba',
 				),
 				'NB' => array(
					'code' => 'NB',
 					'name' => 'New Brunswick',
 				),
 				'NF' => array(
					'code' => 'NF',
 					'name' => 'Newfoundland',
 				),
 				'NS' => array(
					'code' => 'NS',
 					'name' => 'Nova Scotia',
 				),
 				'NT' => array(
					'code' => 'NT',
 					'name' => 'Northwest Territories',
 				),
 				'ON' => array(
					'code' => 'ON',
 					'name' => 'Ontario',
 				),
 				'PE' => array(
					'code' => 'PE',
 					'name' => 'Printe Edward Island',
 				),
 				'QC' => array(
					'code' => 'QC',
 					'name' => 'Quebec',
 				),
 				'SK' => array(
					'code' => 'SK',
 					'name' => 'Saskatchewan',
 				),
 				'YT' => array(
					'code' => 'YT',
 					'name' => 'Yukon Territory',
 				),
 			),
 		),
 		'CC' => array(
			'code' => 'CC',
 			'name' => 'Cocos (Keeling) Islands',
 			'code3' => 'CCK',
 			'numeric' => '166',
 			'states' => array(
			),
 		),
 		'CD' => array(
			'code' => 'CD',
 			'name' => 'Zaire',
 			'code3' => 'COD',
 			'numeric' => '180',
 			'states' => array(
				'BC' => array(
					'code' => 'BC',
 					'name' => 'Bas-Congo',
 				),
 				'BN' => array(
					'code' => 'BN',
 					'name' => 'Bandundu',
 				),
 				'EQ' => array(
					'code' => 'EQ',
 					'name' => 'Équateur',
 				),
 				'HC' => array(
					'code' => 'HC',
 					'name' => 'Haut-Congo',
 				),
 				'KA' => array(
					'code' => 'KA',
 					'name' => 'Katanga',
 				),
 				'KE' => array(
					'code' => 'KE',
 					'name' => 'Kasai-Oriental',
 				),
 				'KN' => array(
					'code' => 'KN',
 					'name' => 'Kinshasa',
 				),
 				'KW' => array(
					'code' => 'KW',
 					'name' => 'Kasai-Occidental',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Maniema',
 				),
 				'NK' => array(
					'code' => 'NK',
 					'name' => 'Nord-Kivu',
 				),
 				'SK' => array(
					'code' => 'SK',
 					'name' => 'Sud-Kivu',
 				),
 			),
 		),
 		'CF' => array(
			'code' => 'CF',
 			'name' => 'Central African Republic',
 			'code3' => 'CAF',
 			'numeric' => '140',
 			'states' => array(
				'AC' => array(
					'code' => 'AC',
 					'name' => 'Ouham',
 				),
 				'BB' => array(
					'code' => 'BB',
 					'name' => 'Bamingui-Bangoran',
 				),
 				'BGF' => array(
					'code' => 'BGF',
 					'name' => 'Bangui',
 				),
 				'BK' => array(
					'code' => 'BK',
 					'name' => 'Basse-Kotto',
 				),
 				'HK' => array(
					'code' => 'HK',
 					'name' => 'Haute-Kotto',
 				),
 				'HM' => array(
					'code' => 'HM',
 					'name' => 'Haut-Mbomou',
 				),
 				'HS' => array(
					'code' => 'HS',
 					'name' => 'Mambéré-Kadéï',
 				),
 				'KB' => array(
					'code' => 'KB',
 					'name' => 'Nana-Grébizi',
 				),
 				'KG' => array(
					'code' => 'KG',
 					'name' => 'Kémo',
 				),
 				'LB' => array(
					'code' => 'LB',
 					'name' => 'Lobaye',
 				),
 				'MB' => array(
					'code' => 'MB',
 					'name' => 'Mbomou',
 				),
 				'MP' => array(
					'code' => 'MP',
 					'name' => 'Ombella-Mpoko',
 				),
 				'NM' => array(
					'code' => 'NM',
 					'name' => 'Nana-Mambéré',
 				),
 				'OP' => array(
					'code' => 'OP',
 					'name' => 'Ouham-Pendé',
 				),
 				'SE' => array(
					'code' => 'SE',
 					'name' => 'Sangha-Mbaéré',
 				),
 				'UK' => array(
					'code' => 'UK',
 					'name' => 'Ouaka',
 				),
 				'VK' => array(
					'code' => 'VK',
 					'name' => 'Vakaga',
 				),
 			),
 		),
 		'CG' => array(
			'code' => 'CG',
 			'name' => 'Congo',
 			'code3' => 'COG',
 			'numeric' => '178',
 			'states' => array(
				'11' => array(
					'code' => '11',
 					'name' => 'Bouenza',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Pool',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Sangha',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Plateaux',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Cuvette-Ouest',
 				),
 				'2' => array(
					'code' => '2',
 					'name' => 'Lékoumou',
 				),
 				'5' => array(
					'code' => '5',
 					'name' => 'Kouilou',
 				),
 				'7' => array(
					'code' => '7',
 					'name' => 'Likouala',
 				),
 				'8' => array(
					'code' => '8',
 					'name' => 'Cuvette',
 				),
 				'9' => array(
					'code' => '9',
 					'name' => 'Niari',
 				),
 				'BZV' => array(
					'code' => 'BZV',
 					'name' => 'Brazzaville',
 				),
 			),
 		),
 		'CH' => array(
			'code' => 'CH',
 			'name' => 'Switzerland',
 			'code3' => 'CHE',
 			'numeric' => '756',
 			'states' => array(
				'AG' => array(
					'code' => 'AG',
 					'name' => 'Aargau',
 				),
 				'AI' => array(
					'code' => 'AI',
 					'name' => 'Appenzell Inner-Rhoden',
 				),
 				'AR' => array(
					'code' => 'AR',
 					'name' => 'Appenzell Ausser-Rhoden',
 				),
 				'BE' => array(
					'code' => 'BE',
 					'name' => 'Bern',
 				),
 				'BL' => array(
					'code' => 'BL',
 					'name' => 'Basel-Landschaft',
 				),
 				'BS' => array(
					'code' => 'BS',
 					'name' => 'Basel-Stadt',
 				),
 				'FR' => array(
					'code' => 'FR',
 					'name' => 'Freiburg',
 				),
 				'GE' => array(
					'code' => 'GE',
 					'name' => 'Geneve',
 				),
 				'GL' => array(
					'code' => 'GL',
 					'name' => 'Glarus',
 				),
 				'GR' => array(
					'code' => 'GR',
 					'name' => 'Graubünden',
 				),
 				'JU' => array(
					'code' => 'JU',
 					'name' => 'Jura',
 				),
 				'LU' => array(
					'code' => 'LU',
 					'name' => 'Luzern',
 				),
 				'NE' => array(
					'code' => 'NE',
 					'name' => 'Neuchatel',
 				),
 				'NW' => array(
					'code' => 'NW',
 					'name' => 'Nidwalden',
 				),
 				'OW' => array(
					'code' => 'OW',
 					'name' => 'Obwalden',
 				),
 				'SG' => array(
					'code' => 'SG',
 					'name' => 'Sankt Gallen',
 				),
 				'SH' => array(
					'code' => 'SH',
 					'name' => 'Schaffhausen',
 				),
 				'SO' => array(
					'code' => 'SO',
 					'name' => 'Solothurn',
 				),
 				'SZ' => array(
					'code' => 'SZ',
 					'name' => 'Schwyz',
 				),
 				'TG' => array(
					'code' => 'TG',
 					'name' => 'Thurgau',
 				),
 				'TI' => array(
					'code' => 'TI',
 					'name' => 'Ticino',
 				),
 				'UR' => array(
					'code' => 'UR',
 					'name' => 'Uri',
 				),
 				'VD' => array(
					'code' => 'VD',
 					'name' => 'Vaud',
 				),
 				'VS' => array(
					'code' => 'VS',
 					'name' => 'Wallis',
 				),
 				'ZG' => array(
					'code' => 'ZG',
 					'name' => 'Zug',
 				),
 				'ZH' => array(
					'code' => 'ZH',
 					'name' => 'Zürich',
 				),
 			),
 		),
 		'CI' => array(
			'code' => 'CI',
 			'name' => 'Cote D\'ivoire',
 			'code3' => 'CIV',
 			'numeric' => '384',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Lagunes',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Haut-Sassandra',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Savanes',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Vallée du Bandama',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Moyen-Comoé',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => '18 Montagnes',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Lacs',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Zanzan',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Bas-Sassandra',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Denguélé',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Nzi-Comoé',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Marahoué',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Sud-Comoé',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Worodougou',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Sud-Bandama',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Agnébi',
 				),
 			),
 		),
 		'CK' => array(
			'code' => 'CK',
 			'name' => 'Cook Islands',
 			'code3' => 'COK',
 			'numeric' => '184',
 			'states' => array(
			),
 		),
 		'CL' => array(
			'code' => 'CL',
 			'name' => 'Chile',
 			'code3' => 'CHL',
 			'numeric' => '152',
 			'states' => array(
				'AI' => array(
					'code' => 'AI',
 					'name' => 'Aisén del General Carlos Ibáñiez del Campo',
 				),
 				'AN' => array(
					'code' => 'AN',
 					'name' => 'Antofagasta',
 				),
 				'AR' => array(
					'code' => 'AR',
 					'name' => 'Araucanía',
 				),
 				'AT' => array(
					'code' => 'AT',
 					'name' => 'Atacama',
 				),
 				'BI' => array(
					'code' => 'BI',
 					'name' => 'Bío-Bío',
 				),
 				'CO' => array(
					'code' => 'CO',
 					'name' => 'Coquimbo',
 				),
 				'LI' => array(
					'code' => 'LI',
 					'name' => 'Libertador General Bernardo O\'Higgins',
 				),
 				'LL' => array(
					'code' => 'LL',
 					'name' => 'Los Lagos',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Magallanes',
 				),
 				'ML' => array(
					'code' => 'ML',
 					'name' => 'Maule',
 				),
 				'RM' => array(
					'code' => 'RM',
 					'name' => 'Regíon Metropolitana de Santiago',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Tarapacá',
 				),
 				'VS' => array(
					'code' => 'VS',
 					'name' => 'Valparaiso',
 				),
 			),
 		),
 		'CM' => array(
			'code' => 'CM',
 			'name' => 'Cameroon',
 			'code3' => 'CMR',
 			'numeric' => '120',
 			'states' => array(
				'AD' => array(
					'code' => 'AD',
 					'name' => 'Adamaoua',
 				),
 				'CE' => array(
					'code' => 'CE',
 					'name' => 'Centre',
 				),
 				'EN' => array(
					'code' => 'EN',
 					'name' => 'Far North',
 				),
 				'ES' => array(
					'code' => 'ES',
 					'name' => 'Est',
 				),
 				'LT' => array(
					'code' => 'LT',
 					'name' => 'Littoral',
 				),
 				'NO' => array(
					'code' => 'NO',
 					'name' => 'North',
 				),
 				'NW' => array(
					'code' => 'NW',
 					'name' => 'North-West',
 				),
 				'OU' => array(
					'code' => 'OU',
 					'name' => 'West',
 				),
 				'SU' => array(
					'code' => 'SU',
 					'name' => 'South',
 				),
 				'SW' => array(
					'code' => 'SW',
 					'name' => 'South-West',
 				),
 			),
 		),
 		'CN' => array(
			'code' => 'CN',
 			'name' => 'China',
 			'code3' => 'CHN',
 			'numeric' => '156',
 			'states' => array(
				'11' => array(
					'code' => '11',
 					'name' => 'Beijing',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Tianjin',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Hebei',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Shanxi',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Nei Monggol',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Liaoning',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Jilin',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Heilongjiang',
 				),
 				'31' => array(
					'code' => '31',
 					'name' => 'Shanghai',
 				),
 				'32' => array(
					'code' => '32',
 					'name' => 'Jiangsu',
 				),
 				'33' => array(
					'code' => '33',
 					'name' => 'Zhejiang',
 				),
 				'34' => array(
					'code' => '34',
 					'name' => 'Anhui',
 				),
 				'35' => array(
					'code' => '35',
 					'name' => 'Fujian',
 				),
 				'36' => array(
					'code' => '36',
 					'name' => 'Jiangxi',
 				),
 				'37' => array(
					'code' => '37',
 					'name' => 'Shandong',
 				),
 				'41' => array(
					'code' => '41',
 					'name' => 'Henan',
 				),
 				'42' => array(
					'code' => '42',
 					'name' => 'Hubei',
 				),
 				'43' => array(
					'code' => '43',
 					'name' => 'Hunan',
 				),
 				'44' => array(
					'code' => '44',
 					'name' => 'Guangdong',
 				),
 				'45' => array(
					'code' => '45',
 					'name' => 'Guangxi',
 				),
 				'46' => array(
					'code' => '46',
 					'name' => 'Hainan',
 				),
 				'50' => array(
					'code' => '50',
 					'name' => 'Chongqing',
 				),
 				'51' => array(
					'code' => '51',
 					'name' => 'Sichuan',
 				),
 				'52' => array(
					'code' => '52',
 					'name' => 'Guizhou',
 				),
 				'53' => array(
					'code' => '53',
 					'name' => 'Yunnan',
 				),
 				'54' => array(
					'code' => '54',
 					'name' => 'Xizang',
 				),
 				'61' => array(
					'code' => '61',
 					'name' => 'Shaanxi',
 				),
 				'62' => array(
					'code' => '62',
 					'name' => 'Gansu',
 				),
 				'63' => array(
					'code' => '63',
 					'name' => 'Qinghai',
 				),
 				'64' => array(
					'code' => '64',
 					'name' => 'Ningxia',
 				),
 				'65' => array(
					'code' => '65',
 					'name' => 'Xinjiang',
 				),
 				'71' => array(
					'code' => '71',
 					'name' => 'Taiwan',
 				),
 				'91' => array(
					'code' => '91',
 					'name' => 'Hong Kong',
 				),
 			),
 		),
 		'CO' => array(
			'code' => 'CO',
 			'name' => 'Colombia',
 			'code3' => 'COL',
 			'numeric' => '170',
 			'states' => array(
				'AMA' => array(
					'code' => 'AMA',
 					'name' => 'Amazonas',
 				),
 				'ANT' => array(
					'code' => 'ANT',
 					'name' => 'Antioguia',
 				),
 				'ARA' => array(
					'code' => 'ARA',
 					'name' => 'Arauca',
 				),
 				'ATL' => array(
					'code' => 'ATL',
 					'name' => 'Atlántico',
 				),
 				'BOL' => array(
					'code' => 'BOL',
 					'name' => 'Bolívar',
 				),
 				'BOY' => array(
					'code' => 'BOY',
 					'name' => 'Boyacá',
 				),
 				'CAL' => array(
					'code' => 'CAL',
 					'name' => 'Caldas',
 				),
 				'CAQ' => array(
					'code' => 'CAQ',
 					'name' => 'Caquetá',
 				),
 				'CAS' => array(
					'code' => 'CAS',
 					'name' => 'Casanare',
 				),
 				'CAU' => array(
					'code' => 'CAU',
 					'name' => 'Cauca',
 				),
 				'CES' => array(
					'code' => 'CES',
 					'name' => 'Cesar',
 				),
 				'CHO' => array(
					'code' => 'CHO',
 					'name' => 'Chocó',
 				),
 				'COR' => array(
					'code' => 'COR',
 					'name' => 'Córdoba',
 				),
 				'CUN' => array(
					'code' => 'CUN',
 					'name' => 'Cundinamarca',
 				),
 				'DC' => array(
					'code' => 'DC',
 					'name' => 'Distrito Capital de Santa Fe de Bogota',
 				),
 				'GUA' => array(
					'code' => 'GUA',
 					'name' => 'Guainía',
 				),
 				'GUV' => array(
					'code' => 'GUV',
 					'name' => 'Guaviare',
 				),
 				'HUI' => array(
					'code' => 'HUI',
 					'name' => 'Huila',
 				),
 				'LAG' => array(
					'code' => 'LAG',
 					'name' => 'La Guajira',
 				),
 				'MAG' => array(
					'code' => 'MAG',
 					'name' => 'Magdalena',
 				),
 				'MET' => array(
					'code' => 'MET',
 					'name' => 'Meta',
 				),
 				'NAR' => array(
					'code' => 'NAR',
 					'name' => 'Nariño',
 				),
 				'NSA' => array(
					'code' => 'NSA',
 					'name' => 'Norte de Santander',
 				),
 				'PUT' => array(
					'code' => 'PUT',
 					'name' => 'Putumayo',
 				),
 				'QUI' => array(
					'code' => 'QUI',
 					'name' => 'Quindío',
 				),
 				'RIS' => array(
					'code' => 'RIS',
 					'name' => 'Risaralda',
 				),
 				'SAN' => array(
					'code' => 'SAN',
 					'name' => 'Santander',
 				),
 				'SAP' => array(
					'code' => 'SAP',
 					'name' => 'San Andrés, Providencia y Santa Catalina',
 				),
 				'SUC' => array(
					'code' => 'SUC',
 					'name' => 'Sucre',
 				),
 				'TOL' => array(
					'code' => 'TOL',
 					'name' => 'Tolima',
 				),
 				'VAC' => array(
					'code' => 'VAC',
 					'name' => 'Valle del Cauca',
 				),
 				'VAU' => array(
					'code' => 'VAU',
 					'name' => 'Vaupés',
 				),
 				'VID' => array(
					'code' => 'VID',
 					'name' => 'Vichada',
 				),
 			),
 		),
 		'CR' => array(
			'code' => 'CR',
 			'name' => 'Costa Rica',
 			'code3' => 'CRC',
 			'numeric' => '',
 			'states' => array(
				'A' => array(
					'code' => 'A',
 					'name' => 'Alajuela',
 				),
 				'C' => array(
					'code' => 'C',
 					'name' => 'Cartago',
 				),
 				'G' => array(
					'code' => 'G',
 					'name' => 'Guanacaste',
 				),
 				'H' => array(
					'code' => 'H',
 					'name' => 'Heredia',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'Limón',
 				),
 				'P' => array(
					'code' => 'P',
 					'name' => 'Puntarenas',
 				),
 				'SJ' => array(
					'code' => 'SJ',
 					'name' => 'San José',
 				),
 			),
 		),
 		'CU' => array(
			'code' => 'CU',
 			'name' => 'Cuba',
 			'code3' => 'CUB',
 			'numeric' => '192',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Pinar del Río',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'La Habana',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Ciudad de La Habana',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Matanzas',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Villa Clara',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Sancti Spíritus',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Camagüey',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Las Tunas',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Holguín',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Granma',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Santiago de Cuba',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Guantánamo',
 				),
 				'99' => array(
					'code' => '99',
 					'name' => 'Isla de la Juventud',
 				),
 			),
 		),
 		'CV' => array(
			'code' => 'CV',
 			'name' => 'Cape Verde',
 			'code3' => 'CPV',
 			'numeric' => '132',
 			'states' => array(
				'B' => array(
					'code' => 'B',
 					'name' => 'Ilhas de Barlavento',
 				),
 				'BR' => array(
					'code' => 'BR',
 					'name' => 'Brava',
 				),
 				'BV' => array(
					'code' => 'BV',
 					'name' => 'Boa Vista',
 				),
 				'CA' => array(
					'code' => 'CA',
 					'name' => 'Santa Catarina',
 				),
 				'CR' => array(
					'code' => 'CR',
 					'name' => 'Santa Cruz',
 				),
 				'FO' => array(
					'code' => 'FO',
 					'name' => 'Fogo',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Maio',
 				),
 				'PA' => array(
					'code' => 'PA',
 					'name' => 'Paul',
 				),
 				'PN' => array(
					'code' => 'PN',
 					'name' => 'Porto Novo',
 				),
 				'PR' => array(
					'code' => 'PR',
 					'name' => 'Praia',
 				),
 				'RG' => array(
					'code' => 'RG',
 					'name' => 'Ribeira Grande',
 				),
 				'S' => array(
					'code' => 'S',
 					'name' => 'Ilhas de Sotavento',
 				),
 				'SL' => array(
					'code' => 'SL',
 					'name' => 'Sal',
 				),
 				'SN' => array(
					'code' => 'SN',
 					'name' => 'Sāo Nicolau',
 				),
 				'SV' => array(
					'code' => 'SV',
 					'name' => 'Sāo Vicente',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Tarrafal',
 				),
 			),
 		),
 		'CX' => array(
			'code' => 'CX',
 			'name' => 'Christmas Island',
 			'code3' => 'CXR',
 			'numeric' => '162',
 			'states' => array(
			),
 		),
 		'CY' => array(
			'code' => 'CY',
 			'name' => 'Cyprus',
 			'code3' => 'CYP',
 			'numeric' => '196',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Lefkosia',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Lemesos',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Larnaka',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Ammochostos',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Pafos',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Keryneia',
 				),
 			),
 		),
 		'CZ' => array(
			'code' => 'CZ',
 			'name' => 'Czech Republic',
 			'code3' => 'CZE',
 			'numeric' => '203',
 			'states' => array(
				'CJC' => array(
					'code' => 'CJC',
 					'name' => 'Jihočeský kraj',
 				),
 				'CJM' => array(
					'code' => 'CJM',
 					'name' => 'Jihomoravský kraj',
 				),
 				'CSC' => array(
					'code' => 'CSC',
 					'name' => 'Severočeský kraj',
 				),
 				'CSM' => array(
					'code' => 'CSM',
 					'name' => 'Severomoravský kraj',
 				),
 				'CST' => array(
					'code' => 'CST',
 					'name' => 'Středočeský kraj',
 				),
 				'CVC' => array(
					'code' => 'CVC',
 					'name' => 'Východočeský kraj',
 				),
 				'CZC' => array(
					'code' => 'CZC',
 					'name' => 'Západočeský kraj',
 				),
 				'PRG' => array(
					'code' => 'PRG',
 					'name' => 'Praha',
 				),
 			),
 		),
 		'DE' => array(
			'code' => 'DE',
 			'name' => 'Germany',
 			'code3' => 'DEU',
 			'numeric' => '276',
 			'states' => array(
				'BB' => array(
					'code' => 'BB',
 					'name' => 'Brandenburg',
 				),
 				'BE' => array(
					'code' => 'BE',
 					'name' => 'Berlin',
 				),
 				'BW' => array(
					'code' => 'BW',
 					'name' => 'Baden-Württemberg',
 				),
 				'BY' => array(
					'code' => 'BY',
 					'name' => 'Bayern',
 				),
 				'HB' => array(
					'code' => 'HB',
 					'name' => 'Bremen',
 				),
 				'HE' => array(
					'code' => 'HE',
 					'name' => 'Hessen',
 				),
 				'HH' => array(
					'code' => 'HH',
 					'name' => 'Hamburg',
 				),
 				'MV' => array(
					'code' => 'MV',
 					'name' => 'Mecklenburg-Vorpommern',
 				),
 				'NI' => array(
					'code' => 'NI',
 					'name' => 'Niedersachsen',
 				),
 				'NW' => array(
					'code' => 'NW',
 					'name' => 'Nordrhein-Westfalen',
 				),
 				'RP' => array(
					'code' => 'RP',
 					'name' => 'Rheinland-Pfalz',
 				),
 				'SH' => array(
					'code' => 'SH',
 					'name' => 'Schleswig-Holstein',
 				),
 				'SL' => array(
					'code' => 'SL',
 					'name' => 'Saarland',
 				),
 				'SN' => array(
					'code' => 'SN',
 					'name' => 'Sachsen',
 				),
 				'ST' => array(
					'code' => 'ST',
 					'name' => 'Sachsen-Anhalt',
 				),
 				'TH' => array(
					'code' => 'TH',
 					'name' => 'Thüringen',
 				),
 			),
 		),
 		'DJ' => array(
			'code' => 'DJ',
 			'name' => 'Djibouti',
 			'code3' => 'DJI',
 			'numeric' => '262',
 			'states' => array(
				'AS' => array(
					'code' => 'AS',
 					'name' => 'Ali Sabieh',
 				),
 				'DI' => array(
					'code' => 'DI',
 					'name' => 'Dikhil',
 				),
 				'OB' => array(
					'code' => 'OB',
 					'name' => 'Obock',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Tadjoura',
 				),
 			),
 		),
 		'DK' => array(
			'code' => 'DK',
 			'name' => 'Denmark',
 			'code3' => 'DNK',
 			'numeric' => '208',
 			'states' => array(
				'015' => array(
					'code' => '015',
 					'name' => 'Kǿbenhavn',
 				),
 				'020' => array(
					'code' => '020',
 					'name' => 'Frederiksborg',
 				),
 				'025' => array(
					'code' => '025',
 					'name' => 'Roskilde',
 				),
 				'030' => array(
					'code' => '030',
 					'name' => 'Vestsjælland',
 				),
 				'035' => array(
					'code' => '035',
 					'name' => 'Storstrǿm',
 				),
 				'040' => array(
					'code' => '040',
 					'name' => 'Bornholm',
 				),
 				'042' => array(
					'code' => '042',
 					'name' => 'Fyn',
 				),
 				'050' => array(
					'code' => '050',
 					'name' => 'Sǿnderjylland',
 				),
 				'055' => array(
					'code' => '055',
 					'name' => 'Ribe',
 				),
 				'060' => array(
					'code' => '060',
 					'name' => 'Vejle',
 				),
 				'065' => array(
					'code' => '065',
 					'name' => 'Ringkǿbing',
 				),
 				'070' => array(
					'code' => '070',
 					'name' => 'Århus',
 				),
 				'076' => array(
					'code' => '076',
 					'name' => 'Viborg',
 				),
 				'080' => array(
					'code' => '080',
 					'name' => 'Nordjylland',
 				),
 				'101' => array(
					'code' => '101',
 					'name' => 'Kǿbenhavn',
 				),
 				'147' => array(
					'code' => '147',
 					'name' => 'Frederiksberg',
 				),
 			),
 		),
 		'DM' => array(
			'code' => 'DM',
 			'name' => 'Dominica',
 			'code3' => 'DMA',
 			'numeric' => '212',
 			'states' => array(
			),
 		),
 		'DO' => array(
			'code' => 'DO',
 			'name' => 'Dominican Republic',
 			'code3' => 'DOM',
 			'numeric' => '214',
 			'states' => array(
				'AL' => array(
					'code' => 'AL',
 					'name' => 'La Altagracia',
 				),
 				'AZ' => array(
					'code' => 'AZ',
 					'name' => 'Azua',
 				),
 				'BH' => array(
					'code' => 'BH',
 					'name' => 'Barahona',
 				),
 				'BR' => array(
					'code' => 'BR',
 					'name' => 'Bahoruco',
 				),
 				'CR' => array(
					'code' => 'CR',
 					'name' => 'San Cristóbal',
 				),
 				'DA' => array(
					'code' => 'DA',
 					'name' => 'Dajabón',
 				),
 				'DN' => array(
					'code' => 'DN',
 					'name' => 'Distrito National',
 				),
 				'DU' => array(
					'code' => 'DU',
 					'name' => 'Duarte',
 				),
 				'EP' => array(
					'code' => 'EP',
 					'name' => 'La Estrelleta [Elías Piña]',
 				),
 				'HM' => array(
					'code' => 'HM',
 					'name' => 'Hato Mayor',
 				),
 				'IN' => array(
					'code' => 'IN',
 					'name' => 'Independencia',
 				),
 				'JU' => array(
					'code' => 'JU',
 					'name' => 'San Juan',
 				),
 				'MC' => array(
					'code' => 'MC',
 					'name' => 'Monte Cristi',
 				),
 				'MN' => array(
					'code' => 'MN',
 					'name' => 'Monseñor Nouel',
 				),
 				'MP' => array(
					'code' => 'MP',
 					'name' => 'Monte Plata',
 				),
 				'MT' => array(
					'code' => 'MT',
 					'name' => 'María Trinidad Sánchez',
 				),
 				'PM' => array(
					'code' => 'PM',
 					'name' => 'San Pedro de Macorís',
 				),
 				'PN' => array(
					'code' => 'PN',
 					'name' => 'Pedernales',
 				),
 				'PP' => array(
					'code' => 'PP',
 					'name' => 'Puerto Plata',
 				),
 				'PR' => array(
					'code' => 'PR',
 					'name' => 'Peravia',
 				),
 				'RO' => array(
					'code' => 'RO',
 					'name' => 'La Romana',
 				),
 				'SC' => array(
					'code' => 'SC',
 					'name' => 'Salcedo',
 				),
 				'SE' => array(
					'code' => 'SE',
 					'name' => 'El Seibo',
 				),
 				'SM' => array(
					'code' => 'SM',
 					'name' => 'Samaná',
 				),
 				'SR' => array(
					'code' => 'SR',
 					'name' => 'Santiago Rodríguez',
 				),
 				'ST' => array(
					'code' => 'ST',
 					'name' => 'Santiago',
 				),
 				'SZ' => array(
					'code' => 'SZ',
 					'name' => 'Sanchez Ramírez',
 				),
 				'VA' => array(
					'code' => 'VA',
 					'name' => 'Valverde',
 				),
 				'VE' => array(
					'code' => 'VE',
 					'name' => 'La Vega',
 				),
 			),
 		),
 		'DZ' => array(
			'code' => 'DZ',
 			'name' => 'Algeria',
 			'code3' => 'DZA',
 			'numeric' => '012',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Adrar',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Chlef',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Laghouat',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Oum el Bouaghi',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Batna',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Béjaïa',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Biskra',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Béchar',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Blida',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Bouira',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Tamanghasset',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Tébessa',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Tlemcen',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Tiaret',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Tizi Ouzou',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Alger',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Djelfa',
 				),
 				'18' => array(
					'code' => '18',
 					'name' => 'Jijel',
 				),
 				'19' => array(
					'code' => '19',
 					'name' => 'Sétif',
 				),
 				'20' => array(
					'code' => '20',
 					'name' => 'Saïda',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Skikda',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Sidi Bel Abbès',
 				),
 				'24' => array(
					'code' => '24',
 					'name' => 'Guelma',
 				),
 				'25' => array(
					'code' => '25',
 					'name' => 'Constantine',
 				),
 				'26' => array(
					'code' => '26',
 					'name' => 'Médéa',
 				),
 				'27' => array(
					'code' => '27',
 					'name' => 'Mostaganem',
 				),
 				'28' => array(
					'code' => '28',
 					'name' => 'Msila',
 				),
 				'29' => array(
					'code' => '29',
 					'name' => 'Mascara',
 				),
 				'30' => array(
					'code' => '30',
 					'name' => 'Ouargla',
 				),
 				'31' => array(
					'code' => '31',
 					'name' => 'Oran',
 				),
 				'32' => array(
					'code' => '32',
 					'name' => 'El Bayadh',
 				),
 				'33' => array(
					'code' => '33',
 					'name' => 'Illizi',
 				),
 				'34' => array(
					'code' => '34',
 					'name' => 'Bordj Bou Arréridj',
 				),
 				'35' => array(
					'code' => '35',
 					'name' => 'Boumerdès',
 				),
 				'36' => array(
					'code' => '36',
 					'name' => 'El Tarf',
 				),
 				'37' => array(
					'code' => '37',
 					'name' => 'Tindouf',
 				),
 				'38' => array(
					'code' => '38',
 					'name' => 'Tissemsilt',
 				),
 				'39' => array(
					'code' => '39',
 					'name' => 'El Oued',
 				),
 				'40' => array(
					'code' => '40',
 					'name' => 'Khenchela',
 				),
 				'41' => array(
					'code' => '41',
 					'name' => 'Souk Ahras',
 				),
 				'42' => array(
					'code' => '42',
 					'name' => 'Tipaza',
 				),
 				'43' => array(
					'code' => '43',
 					'name' => 'Mila',
 				),
 				'44' => array(
					'code' => '44',
 					'name' => 'Aïn Defla',
 				),
 				'45' => array(
					'code' => '45',
 					'name' => 'Naama',
 				),
 				'46' => array(
					'code' => '46',
 					'name' => 'Aïn Témouchent',
 				),
 				'47' => array(
					'code' => '47',
 					'name' => 'Ghardaïa',
 				),
 				'48' => array(
					'code' => '48',
 					'name' => 'Relizane',
 				),
 			),
 		),
 		'EC' => array(
			'code' => 'EC',
 			'name' => 'Ecuador',
 			'code3' => 'ECU',
 			'numeric' => '218',
 			'states' => array(
				'A' => array(
					'code' => 'A',
 					'name' => 'Azuay',
 				),
 				'B' => array(
					'code' => 'B',
 					'name' => 'Bolívar',
 				),
 				'C' => array(
					'code' => 'C',
 					'name' => 'Carchi',
 				),
 				'E' => array(
					'code' => 'E',
 					'name' => 'Esmeraldas',
 				),
 				'F' => array(
					'code' => 'F',
 					'name' => 'Cañar',
 				),
 				'G' => array(
					'code' => 'G',
 					'name' => 'Guayas',
 				),
 				'H' => array(
					'code' => 'H',
 					'name' => 'Chimborazo',
 				),
 				'I' => array(
					'code' => 'I',
 					'name' => 'Imbabura',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'Loja',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'Manabí',
 				),
 				'N' => array(
					'code' => 'N',
 					'name' => 'Napo',
 				),
 				'O' => array(
					'code' => 'O',
 					'name' => 'El Oro',
 				),
 				'P' => array(
					'code' => 'P',
 					'name' => 'Pichincha',
 				),
 				'R' => array(
					'code' => 'R',
 					'name' => 'Los Ríos',
 				),
 				'S' => array(
					'code' => 'S',
 					'name' => 'Morona-Santiago',
 				),
 				'T' => array(
					'code' => 'T',
 					'name' => 'Tungurahua',
 				),
 				'U' => array(
					'code' => 'U',
 					'name' => 'Sucumbíos',
 				),
 				'W' => array(
					'code' => 'W',
 					'name' => 'Galápagos',
 				),
 				'X' => array(
					'code' => 'X',
 					'name' => 'Cotopaxi',
 				),
 				'Y' => array(
					'code' => 'Y',
 					'name' => 'Pastaza',
 				),
 				'Z' => array(
					'code' => 'Z',
 					'name' => 'Zarnora-Chinchipe',
 				),
 			),
 		),
 		'EE' => array(
			'code' => 'EE',
 			'name' => 'Estonia',
 			'code3' => 'EST',
 			'numeric' => '233',
 			'states' => array(
				'37' => array(
					'code' => '37',
 					'name' => 'Harjumaa',
 				),
 				'39' => array(
					'code' => '39',
 					'name' => 'Hiiumaa',
 				),
 				'44' => array(
					'code' => '44',
 					'name' => 'Ida-Virumaa',
 				),
 				'49' => array(
					'code' => '49',
 					'name' => 'Jōgevamaa',
 				),
 				'51' => array(
					'code' => '51',
 					'name' => 'Järvamaa',
 				),
 				'57' => array(
					'code' => '57',
 					'name' => 'Läänemaa',
 				),
 				'59' => array(
					'code' => '59',
 					'name' => 'Lääne-Virumaa',
 				),
 				'65' => array(
					'code' => '65',
 					'name' => 'Pōlvamaa',
 				),
 				'67' => array(
					'code' => '67',
 					'name' => 'Pärnumaa',
 				),
 				'70' => array(
					'code' => '70',
 					'name' => 'Raplamaa',
 				),
 				'74' => array(
					'code' => '74',
 					'name' => 'Saaremaa',
 				),
 				'78' => array(
					'code' => '78',
 					'name' => 'Tartumaa',
 				),
 				'82' => array(
					'code' => '82',
 					'name' => 'Valgamaa',
 				),
 				'84' => array(
					'code' => '84',
 					'name' => 'Viljandimaa',
 				),
 				'86' => array(
					'code' => '86',
 					'name' => 'Vōrumaa',
 				),
 			),
 		),
 		'EG' => array(
			'code' => 'EG',
 			'name' => 'Egypt',
 			'code3' => 'EGY',
 			'numeric' => '818',
 			'states' => array(
				'ALX' => array(
					'code' => 'ALX',
 					'name' => 'Al Iskandarīyah',
 				),
 				'ASN' => array(
					'code' => 'ASN',
 					'name' => 'Aswān',
 				),
 				'AST' => array(
					'code' => 'AST',
 					'name' => 'Asyūţ',
 				),
 				'BA' => array(
					'code' => 'BA',
 					'name' => 'Al Baḩr al Aḩmar',
 				),
 				'BH' => array(
					'code' => 'BH',
 					'name' => 'Al Buḩayrah',
 				),
 				'BNS' => array(
					'code' => 'BNS',
 					'name' => 'Banī Suwayf',
 				),
 				'C' => array(
					'code' => 'C',
 					'name' => 'Al Qāhirah',
 				),
 				'DK' => array(
					'code' => 'DK',
 					'name' => 'Ad Daqahlīyah',
 				),
 				'DT' => array(
					'code' => 'DT',
 					'name' => 'Dumyāţ',
 				),
 				'FYM' => array(
					'code' => 'FYM',
 					'name' => 'Al Fayyūm',
 				),
 				'GH' => array(
					'code' => 'GH',
 					'name' => 'Al Gharbīyah',
 				),
 				'GZ' => array(
					'code' => 'GZ',
 					'name' => 'Al Jīzah',
 				),
 				'IS' => array(
					'code' => 'IS',
 					'name' => 'Al Ismā‘īlīyah',
 				),
 				'JS' => array(
					'code' => 'JS',
 					'name' => 'Janūb Sīnā\'',
 				),
 				'KB' => array(
					'code' => 'KB',
 					'name' => 'Al Qalyūbīyah',
 				),
 				'KFS' => array(
					'code' => 'KFS',
 					'name' => 'Kafr ash Shaykh',
 				),
 				'KN' => array(
					'code' => 'KN',
 					'name' => 'Qinā',
 				),
 				'MN' => array(
					'code' => 'MN',
 					'name' => 'Al Minyā',
 				),
 				'MNF' => array(
					'code' => 'MNF',
 					'name' => 'Al Minūfīyah',
 				),
 				'MT' => array(
					'code' => 'MT',
 					'name' => 'Maţrūḩ',
 				),
 				'PTS' => array(
					'code' => 'PTS',
 					'name' => 'Būr Sa‘īd',
 				),
 				'SHG' => array(
					'code' => 'SHG',
 					'name' => 'Sūhāj',
 				),
 				'SHR' => array(
					'code' => 'SHR',
 					'name' => 'Ash Sharqīyah',
 				),
 				'SIN' => array(
					'code' => 'SIN',
 					'name' => 'Shamāl Sīnā\'',
 				),
 				'SUZ' => array(
					'code' => 'SUZ',
 					'name' => 'As Suways',
 				),
 				'WAD' => array(
					'code' => 'WAD',
 					'name' => 'Al Wādī al Jadīd',
 				),
 			),
 		),
 		'EH' => array(
			'code' => 'EH',
 			'name' => 'Western Sahara',
 			'code3' => 'ESH',
 			'numeric' => '732',
 			'states' => array(
			),
 		),
 		'ER' => array(
			'code' => 'ER',
 			'name' => 'Eritrea',
 			'code3' => 'ERI',
 			'numeric' => '232',
 			'states' => array(
				'AG' => array(
					'code' => 'AG',
 					'name' => 'Akele Guzai [Akalä Guzay]',
 				),
 				'AS' => array(
					'code' => 'AS',
 					'name' => 'Asmara [Asmära]',
 				),
 				'BA' => array(
					'code' => 'BA',
 					'name' => 'Barka',
 				),
 				'DE' => array(
					'code' => 'DE',
 					'name' => 'Denkalia [Dänkali]',
 				),
 				'GS' => array(
					'code' => 'GS',
 					'name' => 'Gash-Setit [Gaš enna Sätit]',
 				),
 				'HA' => array(
					'code' => 'HA',
 					'name' => 'Hamasien [Hamasén]',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Sahel',
 				),
 				'SM' => array(
					'code' => 'SM',
 					'name' => 'Semhar [Sämhar]',
 				),
 				'SN' => array(
					'code' => 'SN',
 					'name' => 'Senhit [Sänhet]',
 				),
 				'SR' => array(
					'code' => 'SR',
 					'name' => 'Seraye [Särayé]',
 				),
 			),
 		),
 		'ES' => array(
			'code' => 'ES',
 			'name' => 'Spain',
 			'code3' => 'ESP',
 			'numeric' => '724',
 			'states' => array(
				'A' => array(
					'code' => 'A',
 					'name' => 'Alicante',
 				),
 				'AB' => array(
					'code' => 'AB',
 					'name' => 'Albacete',
 				),
 				'AL' => array(
					'code' => 'AL',
 					'name' => 'Almería',
 				),
 				'AN' => array(
					'code' => 'AN',
 					'name' => 'Andalucía',
 				),
 				'AR' => array(
					'code' => 'AR',
 					'name' => 'Aragón',
 				),
 				'AV' => array(
					'code' => 'AV',
 					'name' => 'Ávila',
 				),
 				'B' => array(
					'code' => 'B',
 					'name' => 'Barcelona',
 				),
 				'BA' => array(
					'code' => 'BA',
 					'name' => 'Badajoz',
 				),
 				'BI' => array(
					'code' => 'BI',
 					'name' => 'Vizcaya',
 				),
 				'BU' => array(
					'code' => 'BU',
 					'name' => 'Burgos',
 				),
 				'C' => array(
					'code' => 'C',
 					'name' => 'La Coruña',
 				),
 				'CA' => array(
					'code' => 'CA',
 					'name' => 'Cádiz',
 				),
 				'CC' => array(
					'code' => 'CC',
 					'name' => 'Cáceres',
 				),
 				'CL' => array(
					'code' => 'CL',
 					'name' => 'Castilla y León',
 				),
 				'CM' => array(
					'code' => 'CM',
 					'name' => 'Castilla-La Mancha',
 				),
 				'CN' => array(
					'code' => 'CN',
 					'name' => 'Canarias',
 				),
 				'CO' => array(
					'code' => 'CO',
 					'name' => 'Córdoba',
 				),
 				'CR' => array(
					'code' => 'CR',
 					'name' => 'Ciudad Real',
 				),
 				'CS' => array(
					'code' => 'CS',
 					'name' => 'Castellón',
 				),
 				'CT' => array(
					'code' => 'CT',
 					'name' => 'Cataluña',
 				),
 				'CU' => array(
					'code' => 'CU',
 					'name' => 'Cuenca',
 				),
 				'EX' => array(
					'code' => 'EX',
 					'name' => 'Extremadura',
 				),
 				'GA' => array(
					'code' => 'GA',
 					'name' => 'Galicia',
 				),
 				'GC' => array(
					'code' => 'GC',
 					'name' => 'Las Palmas',
 				),
 				'GE' => array(
					'code' => 'GE',
 					'name' => 'Gerona',
 				),
 				'GR' => array(
					'code' => 'GR',
 					'name' => 'Granada',
 				),
 				'GU' => array(
					'code' => 'GU',
 					'name' => 'Guadalajara',
 				),
 				'H' => array(
					'code' => 'H',
 					'name' => 'Huelva',
 				),
 				'HU' => array(
					'code' => 'HU',
 					'name' => 'Huesca',
 				),
 				'J' => array(
					'code' => 'J',
 					'name' => 'Jaén',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'Lérida',
 				),
 				'LE' => array(
					'code' => 'LE',
 					'name' => 'León',
 				),
 				'LO' => array(
					'code' => 'LO',
 					'name' => 'La Rioja',
 				),
 				'LU' => array(
					'code' => 'LU',
 					'name' => 'Lugo',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'Madrid',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Málaga',
 				),
 				'MU' => array(
					'code' => 'MU',
 					'name' => 'Murcia',
 				),
 				'NA' => array(
					'code' => 'NA',
 					'name' => 'Navarra',
 				),
 				'O' => array(
					'code' => 'O',
 					'name' => 'Asturias',
 				),
 				'OR' => array(
					'code' => 'OR',
 					'name' => 'Orense',
 				),
 				'P' => array(
					'code' => 'P',
 					'name' => 'Palencia',
 				),
 				'PM' => array(
					'code' => 'PM',
 					'name' => 'Baleares',
 				),
 				'PO' => array(
					'code' => 'PO',
 					'name' => 'Pontevedra',
 				),
 				'PV' => array(
					'code' => 'PV',
 					'name' => 'País Vasco',
 				),
 				'S' => array(
					'code' => 'S',
 					'name' => 'Cantabria',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Salamanca',
 				),
 				'SE' => array(
					'code' => 'SE',
 					'name' => 'Sevilla',
 				),
 				'SG' => array(
					'code' => 'SG',
 					'name' => 'Segovia',
 				),
 				'SO' => array(
					'code' => 'SO',
 					'name' => 'Soria',
 				),
 				'SS' => array(
					'code' => 'SS',
 					'name' => 'Guipúzcoa',
 				),
 				'T' => array(
					'code' => 'T',
 					'name' => 'Tarragona',
 				),
 				'TE' => array(
					'code' => 'TE',
 					'name' => 'Teruel',
 				),
 				'TF' => array(
					'code' => 'TF',
 					'name' => 'Santa Cruz De Tenerife',
 				),
 				'TO' => array(
					'code' => 'TO',
 					'name' => 'Toledo',
 				),
 				'V' => array(
					'code' => 'V',
 					'name' => 'Valencia',
 				),
 				'VA' => array(
					'code' => 'VA',
 					'name' => 'Valladolid',
 				),
 				'VC' => array(
					'code' => 'VC',
 					'name' => 'Valenciana, Comunidad',
 				),
 				'VI' => array(
					'code' => 'VI',
 					'name' => 'Álava',
 				),
 				'Z' => array(
					'code' => 'Z',
 					'name' => 'Zaragoza',
 				),
 				'ZA' => array(
					'code' => 'ZA',
 					'name' => 'Zamora',
 				),
 			),
 		),
 		'ET' => array(
			'code' => 'ET',
 			'name' => 'Ethiopia',
 			'code3' => 'ETH',
 			'numeric' => '231',
 			'states' => array(
				'AA' => array(
					'code' => 'AA',
 					'name' => 'Addis Ababa [Addis Abeba]',
 				),
 				'AF' => array(
					'code' => 'AF',
 					'name' => 'Afar',
 				),
 				'AM' => array(
					'code' => 'AM',
 					'name' => 'Amara [Amhara]',
 				),
 				'BE' => array(
					'code' => 'BE',
 					'name' => 'Benshangul-Gumaz [Bénishangul]',
 				),
 				'GA' => array(
					'code' => 'GA',
 					'name' => 'Gambela Peoples [Gambéla]',
 				),
 				'HA' => array(
					'code' => 'HA',
 					'name' => 'Harari People [Harer]',
 				),
 				'OR' => array(
					'code' => 'OR',
 					'name' => 'Oromia [Oromo]',
 				),
 				'SN' => array(
					'code' => 'SN',
 					'name' => 'Southern Nations, Nationalities and Peoples',
 				),
 				'SO' => array(
					'code' => 'SO',
 					'name' => 'Somali',
 				),
 				'TI' => array(
					'code' => 'TI',
 					'name' => 'Tigrai [Tegré]',
 				),
 			),
 		),
 		'FI' => array(
			'code' => 'FI',
 			'name' => 'Finland',
 			'code3' => 'FIN',
 			'numeric' => '246',
 			'states' => array(
				'AL' => array(
					'code' => 'AL',
 					'name' => 'Ahvenanmaan lääni',
 				),
 				'ES' => array(
					'code' => 'ES',
 					'name' => 'Etelä-Suomen lääni',
 				),
 				'IS' => array(
					'code' => 'IS',
 					'name' => 'Itä-Suomen lääni',
 				),
 				'LL' => array(
					'code' => 'LL',
 					'name' => 'Lapin lääni',
 				),
 				'LS' => array(
					'code' => 'LS',
 					'name' => 'Länsi-Suomen lääni',
 				),
 				'OL' => array(
					'code' => 'OL',
 					'name' => 'Oulun lääni',
 				),
 			),
 		),
 		'FJ' => array(
			'code' => 'FJ',
 			'name' => 'Fiji',
 			'code3' => 'FJI',
 			'numeric' => '242',
 			'states' => array(
				'C' => array(
					'code' => 'C',
 					'name' => 'Central',
 				),
 				'E' => array(
					'code' => 'E',
 					'name' => 'Eastern',
 				),
 				'N' => array(
					'code' => 'N',
 					'name' => 'Northern',
 				),
 				'R' => array(
					'code' => 'R',
 					'name' => 'Rotuma',
 				),
 				'W' => array(
					'code' => 'W',
 					'name' => 'Western',
 				),
 			),
 		),
 		'FK' => array(
			'code' => 'FK',
 			'name' => 'Falkland Islands',
 			'code3' => 'FLK',
 			'numeric' => '238',
 			'states' => array(
			),
 		),
 		'FM' => array(
			'code' => 'FM',
 			'name' => 'Micronesia',
 			'code3' => 'FSM',
 			'numeric' => '583',
 			'states' => array(
				'KSA' => array(
					'code' => 'KSA',
 					'name' => 'Kosrae',
 				),
 				'PNI' => array(
					'code' => 'PNI',
 					'name' => 'Pohnpei',
 				),
 				'TRK' => array(
					'code' => 'TRK',
 					'name' => 'chuuk',
 				),
 				'YAP' => array(
					'code' => 'YAP',
 					'name' => 'Yap',
 				),
 			),
 		),
 		'FO' => array(
			'code' => 'FO',
 			'name' => 'Faroe Islands',
 			'code3' => 'FRO',
 			'numeric' => '234',
 			'states' => array(
			),
 		),
 		'FR' => array(
			'code' => 'FR',
 			'name' => 'France',
 			'code3' => 'FRA',
 			'numeric' => '250',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Ain',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Aisne',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Allier',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Alpes-de-Haute-Provence',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Hautes-Alpes',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Alpes-Maritimes',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Ardèche',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Ardennes',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Ariège',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Aube',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Aude',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Aveyron',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Bauches-du-Rhône',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Calvados',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Cantal',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Charente',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Charente-Maritime',
 				),
 				'18' => array(
					'code' => '18',
 					'name' => 'Cher',
 				),
 				'19' => array(
					'code' => '19',
 					'name' => 'Corrèze',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Côte-d\'Or',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Cotes-d\'Armor',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Creuse',
 				),
 				'24' => array(
					'code' => '24',
 					'name' => 'Dordogne',
 				),
 				'25' => array(
					'code' => '25',
 					'name' => 'Doubs',
 				),
 				'26' => array(
					'code' => '26',
 					'name' => 'Drôme',
 				),
 				'27' => array(
					'code' => '27',
 					'name' => 'Eure',
 				),
 				'28' => array(
					'code' => '28',
 					'name' => 'Eure-et-Loir',
 				),
 				'29' => array(
					'code' => '29',
 					'name' => 'Finistère',
 				),
 				'2A' => array(
					'code' => '2A',
 					'name' => 'Corse-du-Sud',
 				),
 				'2B' => array(
					'code' => '2B',
 					'name' => 'Haute-Corse',
 				),
 				'30' => array(
					'code' => '30',
 					'name' => 'Gard',
 				),
 				'31' => array(
					'code' => '31',
 					'name' => 'Haute-Garonne',
 				),
 				'32' => array(
					'code' => '32',
 					'name' => 'Gers',
 				),
 				'33' => array(
					'code' => '33',
 					'name' => 'Gironde',
 				),
 				'34' => array(
					'code' => '34',
 					'name' => 'Hérault',
 				),
 				'35' => array(
					'code' => '35',
 					'name' => 'Ille-et-Vilaine',
 				),
 				'36' => array(
					'code' => '36',
 					'name' => 'Indre',
 				),
 				'37' => array(
					'code' => '37',
 					'name' => 'Indre-et-Loire',
 				),
 				'38' => array(
					'code' => '38',
 					'name' => 'Isère',
 				),
 				'39' => array(
					'code' => '39',
 					'name' => 'Jura',
 				),
 				'40' => array(
					'code' => '40',
 					'name' => 'Landes',
 				),
 				'41' => array(
					'code' => '41',
 					'name' => 'Loir-et-Cher',
 				),
 				'42' => array(
					'code' => '42',
 					'name' => 'Loire',
 				),
 				'43' => array(
					'code' => '43',
 					'name' => 'Haute-Loire',
 				),
 				'44' => array(
					'code' => '44',
 					'name' => 'Loire-Atlantique',
 				),
 				'45' => array(
					'code' => '45',
 					'name' => 'Loiret',
 				),
 				'46' => array(
					'code' => '46',
 					'name' => 'Lot',
 				),
 				'47' => array(
					'code' => '47',
 					'name' => 'Lot-et-Garonne',
 				),
 				'48' => array(
					'code' => '48',
 					'name' => 'Lozère',
 				),
 				'49' => array(
					'code' => '49',
 					'name' => 'Maine-et-Loire',
 				),
 				'50' => array(
					'code' => '50',
 					'name' => 'Manche',
 				),
 				'51' => array(
					'code' => '51',
 					'name' => 'Marne',
 				),
 				'52' => array(
					'code' => '52',
 					'name' => 'Haute-Marne',
 				),
 				'53' => array(
					'code' => '53',
 					'name' => 'Mayenne',
 				),
 				'54' => array(
					'code' => '54',
 					'name' => 'Meurthe-et-Moselle',
 				),
 				'55' => array(
					'code' => '55',
 					'name' => 'Meuse',
 				),
 				'56' => array(
					'code' => '56',
 					'name' => 'Morbihan',
 				),
 				'57' => array(
					'code' => '57',
 					'name' => 'Moselle',
 				),
 				'58' => array(
					'code' => '58',
 					'name' => 'Nièvre',
 				),
 				'59' => array(
					'code' => '59',
 					'name' => 'Nord',
 				),
 				'60' => array(
					'code' => '60',
 					'name' => 'Oise',
 				),
 				'61' => array(
					'code' => '61',
 					'name' => 'Orne',
 				),
 				'62' => array(
					'code' => '62',
 					'name' => 'Pas-de-Calais',
 				),
 				'63' => array(
					'code' => '63',
 					'name' => 'Puy-de-Dôme',
 				),
 				'64' => array(
					'code' => '64',
 					'name' => 'Pyrénées-Atlantiques',
 				),
 				'65' => array(
					'code' => '65',
 					'name' => 'Hautes-Pyrénées',
 				),
 				'66' => array(
					'code' => '66',
 					'name' => 'Pyrénées-Orientales',
 				),
 				'67' => array(
					'code' => '67',
 					'name' => 'Bas-Rhin',
 				),
 				'68' => array(
					'code' => '68',
 					'name' => 'Haut-Rhin',
 				),
 				'69' => array(
					'code' => '69',
 					'name' => 'Rhône',
 				),
 				'70' => array(
					'code' => '70',
 					'name' => 'Haute-Saône',
 				),
 				'71' => array(
					'code' => '71',
 					'name' => 'Saône-et-Loire',
 				),
 				'72' => array(
					'code' => '72',
 					'name' => 'Sarthe',
 				),
 				'73' => array(
					'code' => '73',
 					'name' => 'Savoie',
 				),
 				'74' => array(
					'code' => '74',
 					'name' => 'Haute-Savoie',
 				),
 				'75' => array(
					'code' => '75',
 					'name' => 'Paris',
 				),
 				'76' => array(
					'code' => '76',
 					'name' => 'Seine-Maritime',
 				),
 				'77' => array(
					'code' => '77',
 					'name' => 'Seine-et-Marne',
 				),
 				'78' => array(
					'code' => '78',
 					'name' => 'Yvelines',
 				),
 				'79' => array(
					'code' => '79',
 					'name' => 'Deux-Sèvres',
 				),
 				'80' => array(
					'code' => '80',
 					'name' => 'Somme',
 				),
 				'81' => array(
					'code' => '81',
 					'name' => 'Tarn',
 				),
 				'82' => array(
					'code' => '82',
 					'name' => 'Tarn-et-Garonne',
 				),
 				'83' => array(
					'code' => '83',
 					'name' => 'Var',
 				),
 				'84' => array(
					'code' => '84',
 					'name' => 'Vaucluse',
 				),
 				'85' => array(
					'code' => '85',
 					'name' => 'Vendée',
 				),
 				'86' => array(
					'code' => '86',
 					'name' => 'Vienne',
 				),
 				'87' => array(
					'code' => '87',
 					'name' => 'Haute-Vienne',
 				),
 				'88' => array(
					'code' => '88',
 					'name' => 'Vosges',
 				),
 				'89' => array(
					'code' => '89',
 					'name' => 'Yonne',
 				),
 				'90' => array(
					'code' => '90',
 					'name' => 'Territoire de Belfort',
 				),
 				'91' => array(
					'code' => '91',
 					'name' => 'Essonne',
 				),
 				'92' => array(
					'code' => '92',
 					'name' => 'Hauts-de-Seine',
 				),
 				'93' => array(
					'code' => '93',
 					'name' => 'Seine-Saint-Denis',
 				),
 				'94' => array(
					'code' => '94',
 					'name' => 'Val-de-Marne',
 				),
 				'95' => array(
					'code' => '95',
 					'name' => 'Val-d\'Oise',
 				),
 				'A' => array(
					'code' => 'A',
 					'name' => 'Alsace',
 				),
 				'B' => array(
					'code' => 'B',
 					'name' => 'Aquitaine',
 				),
 				'C' => array(
					'code' => 'C',
 					'name' => 'Auvergne',
 				),
 				'D' => array(
					'code' => 'D',
 					'name' => 'Bourgogne',
 				),
 				'E' => array(
					'code' => 'E',
 					'name' => 'Bretagne',
 				),
 				'F' => array(
					'code' => 'F',
 					'name' => 'Centre',
 				),
 				'G' => array(
					'code' => 'G',
 					'name' => 'Champagne-Ardenne',
 				),
 				'GF' => array(
					'code' => 'GF',
 					'name' => 'Guyane',
 				),
 				'GP' => array(
					'code' => 'GP',
 					'name' => 'Guadeloupe',
 				),
 				'H' => array(
					'code' => 'H',
 					'name' => 'Corse',
 				),
 				'I' => array(
					'code' => 'I',
 					'name' => 'Franche-Comté',
 				),
 				'J' => array(
					'code' => 'J',
 					'name' => 'Île-de-France',
 				),
 				'K' => array(
					'code' => 'K',
 					'name' => 'Languedoc-Roussillon',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'Limousin',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'Lorraine',
 				),
 				'MQ' => array(
					'code' => 'MQ',
 					'name' => 'Martinique',
 				),
 				'N' => array(
					'code' => 'N',
 					'name' => 'Midi-Pyrénées',
 				),
 				'NC' => array(
					'code' => 'NC',
 					'name' => 'Nouvelle-Calédonie',
 				),
 				'O' => array(
					'code' => 'O',
 					'name' => 'Nord-Pas-de-Calais',
 				),
 				'P' => array(
					'code' => 'P',
 					'name' => 'Basse-Normandie',
 				),
 				'PF' => array(
					'code' => 'PF',
 					'name' => 'Polynésie française',
 				),
 				'PM' => array(
					'code' => 'PM',
 					'name' => 'Saint-Pierre-et-Miquelon',
 				),
 				'Q' => array(
					'code' => 'Q',
 					'name' => 'Haute-Normandie',
 				),
 				'R' => array(
					'code' => 'R',
 					'name' => 'Pays de la Loire',
 				),
 				'RE' => array(
					'code' => 'RE',
 					'name' => 'Réunion',
 				),
 				'S' => array(
					'code' => 'S',
 					'name' => 'Picardie',
 				),
 				'T' => array(
					'code' => 'T',
 					'name' => 'Poitou-Charentes',
 				),
 				'TF' => array(
					'code' => 'TF',
 					'name' => 'Terres Australes',
 				),
 				'U' => array(
					'code' => 'U',
 					'name' => 'Provence-Alpes-Côte d\'Azur',
 				),
 				'V' => array(
					'code' => 'V',
 					'name' => 'Rhône-Alpes',
 				),
 				'WF' => array(
					'code' => 'WF',
 					'name' => 'Wallis et Futuna',
 				),
 				'YT' => array(
					'code' => 'YT',
 					'name' => 'Mayotte',
 				),
 			),
 		),
 		'GA' => array(
			'code' => 'GA',
 			'name' => 'Gabon',
 			'code3' => 'GAB',
 			'numeric' => '266',
 			'states' => array(
				'1' => array(
					'code' => '1',
 					'name' => 'Estuaire',
 				),
 				'2' => array(
					'code' => '2',
 					'name' => 'Haut-Ogooué',
 				),
 				'3' => array(
					'code' => '3',
 					'name' => 'Moyen-Ogooué',
 				),
 				'4' => array(
					'code' => '4',
 					'name' => 'Ngounié',
 				),
 				'5' => array(
					'code' => '5',
 					'name' => 'Nyanga',
 				),
 				'6' => array(
					'code' => '6',
 					'name' => 'Ogooué-Ivindo',
 				),
 				'7' => array(
					'code' => '7',
 					'name' => 'Ogooué-Lolo',
 				),
 				'8' => array(
					'code' => '8',
 					'name' => 'Ogooué-Maritime',
 				),
 				'9' => array(
					'code' => '9',
 					'name' => 'Woleu-Ntem',
 				),
 			),
 		),
 		'GB' => array(
			'code' => 'GB',
 			'name' => 'United Kingdom',
 			'code3' => 'GBR',
 			'numeric' => '826',
 			'states' => array(
				'ABD' => array(
					'code' => 'ABD',
 					'name' => 'Aberdeenshire',
 				),
 				'ABE' => array(
					'code' => 'ABE',
 					'name' => 'Aberdeen City',
 				),
 				'AGB' => array(
					'code' => 'AGB',
 					'name' => 'Argyll and Bute',
 				),
 				'AGY' => array(
					'code' => 'AGY',
 					'name' => 'Isle of Anglesey [Sir Ynys Man GB-YNM]',
 				),
 				'ANS' => array(
					'code' => 'ANS',
 					'name' => 'Angus',
 				),
 				'ANT' => array(
					'code' => 'ANT',
 					'name' => 'Antrim',
 				),
 				'ARD' => array(
					'code' => 'ARD',
 					'name' => 'Ards',
 				),
 				'ARM' => array(
					'code' => 'ARM',
 					'name' => 'Armagh',
 				),
 				'BAS' => array(
					'code' => 'BAS',
 					'name' => 'Bath and North East Somerset',
 				),
 				'BBD' => array(
					'code' => 'BBD',
 					'name' => 'Blackburn with Darwen',
 				),
 				'BDF' => array(
					'code' => 'BDF',
 					'name' => 'Bedfordshire',
 				),
 				'BDG' => array(
					'code' => 'BDG',
 					'name' => 'Barking and Dagenham',
 				),
 				'BEN' => array(
					'code' => 'BEN',
 					'name' => 'Brent',
 				),
 				'BEX' => array(
					'code' => 'BEX',
 					'name' => 'Bexley',
 				),
 				'BFS' => array(
					'code' => 'BFS',
 					'name' => 'Belfast',
 				),
 				'BGE' => array(
					'code' => 'BGE',
 					'name' => 'Bridgend [Pen-y-bont ar Ogwr GB-POG]',
 				),
 				'BGW' => array(
					'code' => 'BGW',
 					'name' => 'Blaenau Gwent',
 				),
 				'BIR' => array(
					'code' => 'BIR',
 					'name' => 'Birmingham',
 				),
 				'BKM' => array(
					'code' => 'BKM',
 					'name' => 'Buckinghamshire',
 				),
 				'BLA' => array(
					'code' => 'BLA',
 					'name' => 'Ballymena',
 				),
 				'BLY' => array(
					'code' => 'BLY',
 					'name' => 'Ballymoney',
 				),
 				'BMH' => array(
					'code' => 'BMH',
 					'name' => 'Bournemouth',
 				),
 				'BNB' => array(
					'code' => 'BNB',
 					'name' => 'Banbridge',
 				),
 				'BNE' => array(
					'code' => 'BNE',
 					'name' => 'Barnet',
 				),
 				'BNH' => array(
					'code' => 'BNH',
 					'name' => 'Brighton and Hove',
 				),
 				'BNS' => array(
					'code' => 'BNS',
 					'name' => 'Barnsley',
 				),
 				'BOL' => array(
					'code' => 'BOL',
 					'name' => 'Bolton',
 				),
 				'BPL' => array(
					'code' => 'BPL',
 					'name' => 'Blackpool',
 				),
 				'BRC' => array(
					'code' => 'BRC',
 					'name' => 'Bracknell Forest',
 				),
 				'BRD' => array(
					'code' => 'BRD',
 					'name' => 'Bradford',
 				),
 				'BRY' => array(
					'code' => 'BRY',
 					'name' => 'Bromley',
 				),
 				'BST' => array(
					'code' => 'BST',
 					'name' => 'Bristol, City of',
 				),
 				'BUR' => array(
					'code' => 'BUR',
 					'name' => 'Bury',
 				),
 				'CAM' => array(
					'code' => 'CAM',
 					'name' => 'Cambridgeshire',
 				),
 				'CAY' => array(
					'code' => 'CAY',
 					'name' => 'Caerphilly [Caerffili GB-CAF]',
 				),
 				'CGN' => array(
					'code' => 'CGN',
 					'name' => 'Ceredigion [Sir Ceredigion]',
 				),
 				'CGV' => array(
					'code' => 'CGV',
 					'name' => 'Craigavon',
 				),
 				'CHA' => array(
					'code' => 'CHA',
 					'name' => 'Channel Islands',
 				),
 				'CHS' => array(
					'code' => 'CHS',
 					'name' => 'Cheshire',
 				),
 				'CKF' => array(
					'code' => 'CKF',
 					'name' => 'Carrickfergus',
 				),
 				'CKT' => array(
					'code' => 'CKT',
 					'name' => 'Cookstown',
 				),
 				'CLD' => array(
					'code' => 'CLD',
 					'name' => 'Calderdale',
 				),
 				'CLK' => array(
					'code' => 'CLK',
 					'name' => 'Clackmannanshire',
 				),
 				'CLR' => array(
					'code' => 'CLR',
 					'name' => 'Coleraine',
 				),
 				'CMA' => array(
					'code' => 'CMA',
 					'name' => 'Cumbria',
 				),
 				'CMD' => array(
					'code' => 'CMD',
 					'name' => 'Camden',
 				),
 				'CMN' => array(
					'code' => 'CMN',
 					'name' => 'Carmarthenshire [Sir Gaerfyrddin GB-GFY]',
 				),
 				'CON' => array(
					'code' => 'CON',
 					'name' => 'Cornwall',
 				),
 				'COV' => array(
					'code' => 'COV',
 					'name' => 'Coventry',
 				),
 				'CRF' => array(
					'code' => 'CRF',
 					'name' => 'Cardiff (City of) [Caerdydd GB-CRD]',
 				),
 				'CRY' => array(
					'code' => 'CRY',
 					'name' => 'Croydon',
 				),
 				'CSR' => array(
					'code' => 'CSR',
 					'name' => 'Castlereagh',
 				),
 				'CWY' => array(
					'code' => 'CWY',
 					'name' => 'Conwy',
 				),
 				'DAL' => array(
					'code' => 'DAL',
 					'name' => 'Darlington',
 				),
 				'DBY' => array(
					'code' => 'DBY',
 					'name' => 'Derbyshire',
 				),
 				'DEN' => array(
					'code' => 'DEN',
 					'name' => 'Denbighshire [Sir Ddinbych GB-DDB]',
 				),
 				'DER' => array(
					'code' => 'DER',
 					'name' => 'Derby',
 				),
 				'DEV' => array(
					'code' => 'DEV',
 					'name' => 'Devon',
 				),
 				'DGN' => array(
					'code' => 'DGN',
 					'name' => 'Dungannon',
 				),
 				'DGY' => array(
					'code' => 'DGY',
 					'name' => 'Dumfries and Galloway',
 				),
 				'DNC' => array(
					'code' => 'DNC',
 					'name' => 'Doncaster',
 				),
 				'DND' => array(
					'code' => 'DND',
 					'name' => 'Dundee City',
 				),
 				'DOR' => array(
					'code' => 'DOR',
 					'name' => 'Dorset',
 				),
 				'DOW' => array(
					'code' => 'DOW',
 					'name' => 'Down',
 				),
 				'DRY' => array(
					'code' => 'DRY',
 					'name' => 'Derry',
 				),
 				'DUD' => array(
					'code' => 'DUD',
 					'name' => 'Dudley',
 				),
 				'DUR' => array(
					'code' => 'DUR',
 					'name' => 'Durharn',
 				),
 				'EAL' => array(
					'code' => 'EAL',
 					'name' => 'Ealing',
 				),
 				'EAW' => array(
					'code' => 'EAW',
 					'name' => 'England and Wales',
 				),
 				'EAY' => array(
					'code' => 'EAY',
 					'name' => 'East Ayrshire',
 				),
 				'EDH' => array(
					'code' => 'EDH',
 					'name' => 'Edinburgh, City of',
 				),
 				'EDU' => array(
					'code' => 'EDU',
 					'name' => 'East Dunbartonshire',
 				),
 				'ELN' => array(
					'code' => 'ELN',
 					'name' => 'East Lothian',
 				),
 				'ELS' => array(
					'code' => 'ELS',
 					'name' => 'Eilean Siar',
 				),
 				'ENF' => array(
					'code' => 'ENF',
 					'name' => 'Enfield',
 				),
 				'ENG' => array(
					'code' => 'ENG',
 					'name' => 'England',
 				),
 				'ERW' => array(
					'code' => 'ERW',
 					'name' => 'East Renfrewshire',
 				),
 				'ERY' => array(
					'code' => 'ERY',
 					'name' => 'East Riding of Yorkshire',
 				),
 				'ESS' => array(
					'code' => 'ESS',
 					'name' => 'Essex',
 				),
 				'ESX' => array(
					'code' => 'ESX',
 					'name' => 'East Sussex',
 				),
 				'FAL' => array(
					'code' => 'FAL',
 					'name' => 'Falkirk',
 				),
 				'FER' => array(
					'code' => 'FER',
 					'name' => 'Fermanagh',
 				),
 				'FIF' => array(
					'code' => 'FIF',
 					'name' => 'Fife',
 				),
 				'FLN' => array(
					'code' => 'FLN',
 					'name' => 'Flintshire [Sir y Fflint GB-FFL]',
 				),
 				'GAT' => array(
					'code' => 'GAT',
 					'name' => 'Gateshead',
 				),
 				'GBN' => array(
					'code' => 'GBN',
 					'name' => 'Great Britain',
 				),
 				'GLG' => array(
					'code' => 'GLG',
 					'name' => 'Glasgow City',
 				),
 				'GLS' => array(
					'code' => 'GLS',
 					'name' => 'Gloucestershire',
 				),
 				'GRE' => array(
					'code' => 'GRE',
 					'name' => 'Greenwich',
 				),
 				'GSY' => array(
					'code' => 'GSY',
 					'name' => 'Guernsey [Guernesey]',
 				),
 				'GWN' => array(
					'code' => 'GWN',
 					'name' => 'Gwynedd',
 				),
 				'HAL' => array(
					'code' => 'HAL',
 					'name' => 'Haiton',
 				),
 				'HAM' => array(
					'code' => 'HAM',
 					'name' => 'Hampshire',
 				),
 				'HAV' => array(
					'code' => 'HAV',
 					'name' => 'Havering',
 				),
 				'HCK' => array(
					'code' => 'HCK',
 					'name' => 'Hackney',
 				),
 				'HEF' => array(
					'code' => 'HEF',
 					'name' => 'Herefordshire, County of',
 				),
 				'HIL' => array(
					'code' => 'HIL',
 					'name' => 'Hillingdon',
 				),
 				'HLD' => array(
					'code' => 'HLD',
 					'name' => 'Highland',
 				),
 				'HMF' => array(
					'code' => 'HMF',
 					'name' => 'Hammersmith and Fulham',
 				),
 				'HNS' => array(
					'code' => 'HNS',
 					'name' => 'Hounslow',
 				),
 				'HPL' => array(
					'code' => 'HPL',
 					'name' => 'Hartlepool',
 				),
 				'HRT' => array(
					'code' => 'HRT',
 					'name' => 'Hertfordshire',
 				),
 				'HRW' => array(
					'code' => 'HRW',
 					'name' => 'Harrow',
 				),
 				'HRY' => array(
					'code' => 'HRY',
 					'name' => 'Haringey',
 				),
 				'IOM' => array(
					'code' => 'IOM',
 					'name' => 'Isle of Man',
 				),
 				'IOS' => array(
					'code' => 'IOS',
 					'name' => 'Isles of Scilly',
 				),
 				'IOW' => array(
					'code' => 'IOW',
 					'name' => 'Isle of Wight',
 				),
 				'ISL' => array(
					'code' => 'ISL',
 					'name' => 'Islington',
 				),
 				'IVC' => array(
					'code' => 'IVC',
 					'name' => 'Inverclyde',
 				),
 				'JSY' => array(
					'code' => 'JSY',
 					'name' => 'Jersey',
 				),
 				'KEC' => array(
					'code' => 'KEC',
 					'name' => 'Kensington and Chelsea',
 				),
 				'KEN' => array(
					'code' => 'KEN',
 					'name' => 'Kent',
 				),
 				'KHL' => array(
					'code' => 'KHL',
 					'name' => 'Kingston upon Hull, City of',
 				),
 				'KIR' => array(
					'code' => 'KIR',
 					'name' => 'Kirklees',
 				),
 				'KTT' => array(
					'code' => 'KTT',
 					'name' => 'Kingston upon Thames',
 				),
 				'KWL' => array(
					'code' => 'KWL',
 					'name' => 'Knowsley',
 				),
 				'LAN' => array(
					'code' => 'LAN',
 					'name' => 'Lancashire',
 				),
 				'LBH' => array(
					'code' => 'LBH',
 					'name' => 'Lambeth',
 				),
 				'LCE' => array(
					'code' => 'LCE',
 					'name' => 'Leitester',
 				),
 				'LDS' => array(
					'code' => 'LDS',
 					'name' => 'Leeds',
 				),
 				'LEC' => array(
					'code' => 'LEC',
 					'name' => 'Leicestershire',
 				),
 				'LEW' => array(
					'code' => 'LEW',
 					'name' => 'Lewisham',
 				),
 				'LIN' => array(
					'code' => 'LIN',
 					'name' => 'Lincolnshire',
 				),
 				'LIV' => array(
					'code' => 'LIV',
 					'name' => 'Liverpool',
 				),
 				'LMV' => array(
					'code' => 'LMV',
 					'name' => 'Limavady',
 				),
 				'LND' => array(
					'code' => 'LND',
 					'name' => 'London, City of',
 				),
 				'LRN' => array(
					'code' => 'LRN',
 					'name' => 'Larne',
 				),
 				'LSB' => array(
					'code' => 'LSB',
 					'name' => 'Lisburn',
 				),
 				'LUT' => array(
					'code' => 'LUT',
 					'name' => 'Luton',
 				),
 				'MAN' => array(
					'code' => 'MAN',
 					'name' => 'Manchester',
 				),
 				'MDB' => array(
					'code' => 'MDB',
 					'name' => 'Middlesbrough',
 				),
 				'MDW' => array(
					'code' => 'MDW',
 					'name' => 'Medway',
 				),
 				'MFT' => array(
					'code' => 'MFT',
 					'name' => 'Magherafelt',
 				),
 				'MIK' => array(
					'code' => 'MIK',
 					'name' => 'Milton Keynes',
 				),
 				'MLN' => array(
					'code' => 'MLN',
 					'name' => 'Midlothian',
 				),
 				'MON' => array(
					'code' => 'MON',
 					'name' => 'Monmouthshire [Sir Fynwy GB-FYN]',
 				),
 				'MRT' => array(
					'code' => 'MRT',
 					'name' => 'Merton',
 				),
 				'MRY' => array(
					'code' => 'MRY',
 					'name' => 'Moray',
 				),
 				'MTY' => array(
					'code' => 'MTY',
 					'name' => 'Merthyr Tydfil [Merthyr Tudful GB-MTU]',
 				),
 				'MYL' => array(
					'code' => 'MYL',
 					'name' => 'Moyle',
 				),
 				'NAY' => array(
					'code' => 'NAY',
 					'name' => 'North Ayrshire',
 				),
 				'NBL' => array(
					'code' => 'NBL',
 					'name' => 'Northumberland',
 				),
 				'NDN' => array(
					'code' => 'NDN',
 					'name' => 'North Down',
 				),
 				'NEL' => array(
					'code' => 'NEL',
 					'name' => 'North East Lincolnshire',
 				),
 				'NET' => array(
					'code' => 'NET',
 					'name' => 'Newcastle upon Tyne',
 				),
 				'NFK' => array(
					'code' => 'NFK',
 					'name' => 'Norfolk',
 				),
 				'NGM' => array(
					'code' => 'NGM',
 					'name' => 'Nottingham',
 				),
 				'NIR' => array(
					'code' => 'NIR',
 					'name' => 'Northern Ireland',
 				),
 				'NLK' => array(
					'code' => 'NLK',
 					'name' => 'North Lanarkshire',
 				),
 				'NLN' => array(
					'code' => 'NLN',
 					'name' => 'North Lincolnshire',
 				),
 				'NSM' => array(
					'code' => 'NSM',
 					'name' => 'North Somerset',
 				),
 				'NTA' => array(
					'code' => 'NTA',
 					'name' => 'Newtownabbey',
 				),
 				'NTH' => array(
					'code' => 'NTH',
 					'name' => 'Northamptonshire',
 				),
 				'NTL' => array(
					'code' => 'NTL',
 					'name' => 'Neath Port Talbot [Castell-nedd Port Talbot GB-CTL]',
 				),
 				'NTT' => array(
					'code' => 'NTT',
 					'name' => 'Nottinghamshire',
 				),
 				'NTY' => array(
					'code' => 'NTY',
 					'name' => 'North Tyneside',
 				),
 				'NWM' => array(
					'code' => 'NWM',
 					'name' => 'Newham',
 				),
 				'NWP' => array(
					'code' => 'NWP',
 					'name' => 'Newport [Casnewydd GB-CNW]',
 				),
 				'NYK' => array(
					'code' => 'NYK',
 					'name' => 'North Yorkshire',
 				),
 				'NYM' => array(
					'code' => 'NYM',
 					'name' => 'Newry and Mourne',
 				),
 				'OLD' => array(
					'code' => 'OLD',
 					'name' => 'Oldham',
 				),
 				'OMH' => array(
					'code' => 'OMH',
 					'name' => 'Omagh',
 				),
 				'ORK' => array(
					'code' => 'ORK',
 					'name' => 'Orkney Islands',
 				),
 				'OXF' => array(
					'code' => 'OXF',
 					'name' => 'Oxfordshire',
 				),
 				'PEM' => array(
					'code' => 'PEM',
 					'name' => 'Pembrokeshire [Sir Benfro CB-BNF]',
 				),
 				'PKN' => array(
					'code' => 'PKN',
 					'name' => 'Perth and Kinross',
 				),
 				'PLY' => array(
					'code' => 'PLY',
 					'name' => 'Plymouth',
 				),
 				'POL' => array(
					'code' => 'POL',
 					'name' => 'Poole',
 				),
 				'POR' => array(
					'code' => 'POR',
 					'name' => 'Portsmouth',
 				),
 				'POW' => array(
					'code' => 'POW',
 					'name' => 'Powys',
 				),
 				'PTE' => array(
					'code' => 'PTE',
 					'name' => 'Peterborough',
 				),
 				'RCC' => array(
					'code' => 'RCC',
 					'name' => 'Redcar and Cleveland',
 				),
 				'RCH' => array(
					'code' => 'RCH',
 					'name' => 'Rochdale',
 				),
 				'RCT' => array(
					'code' => 'RCT',
 					'name' => 'Rhondda, Cynon, Taff [Rhondda, Cynon, Taf]',
 				),
 				'RDB' => array(
					'code' => 'RDB',
 					'name' => 'Redbridge',
 				),
 				'RDG' => array(
					'code' => 'RDG',
 					'name' => 'Reading',
 				),
 				'RFW' => array(
					'code' => 'RFW',
 					'name' => 'Renfrewshire',
 				),
 				'RIC' => array(
					'code' => 'RIC',
 					'name' => 'Richmond upon Thames',
 				),
 				'ROT' => array(
					'code' => 'ROT',
 					'name' => 'Rotherharn',
 				),
 				'RUT' => array(
					'code' => 'RUT',
 					'name' => 'Rutland',
 				),
 				'SAW' => array(
					'code' => 'SAW',
 					'name' => 'Sandweil',
 				),
 				'SAY' => array(
					'code' => 'SAY',
 					'name' => 'South Ayrshire',
 				),
 				'SCB' => array(
					'code' => 'SCB',
 					'name' => 'Scottish Borders, The',
 				),
 				'SCT' => array(
					'code' => 'SCT',
 					'name' => 'Scotland',
 				),
 				'SFK' => array(
					'code' => 'SFK',
 					'name' => 'Suffolk',
 				),
 				'SFT' => array(
					'code' => 'SFT',
 					'name' => 'Sefton',
 				),
 				'SGC' => array(
					'code' => 'SGC',
 					'name' => 'South Gloucestershire',
 				),
 				'SHF' => array(
					'code' => 'SHF',
 					'name' => 'Sheffield',
 				),
 				'SHN' => array(
					'code' => 'SHN',
 					'name' => 'St. Helens',
 				),
 				'SHR' => array(
					'code' => 'SHR',
 					'name' => 'Shropshire',
 				),
 				'SKP' => array(
					'code' => 'SKP',
 					'name' => 'Stockport',
 				),
 				'SLF' => array(
					'code' => 'SLF',
 					'name' => 'Salford',
 				),
 				'SLG' => array(
					'code' => 'SLG',
 					'name' => 'Slough',
 				),
 				'SLK' => array(
					'code' => 'SLK',
 					'name' => 'South Lanarkshire',
 				),
 				'SND' => array(
					'code' => 'SND',
 					'name' => 'Sunderland',
 				),
 				'SOL' => array(
					'code' => 'SOL',
 					'name' => 'Solihull',
 				),
 				'SOM' => array(
					'code' => 'SOM',
 					'name' => 'Somerset',
 				),
 				'SOS' => array(
					'code' => 'SOS',
 					'name' => 'Southend-on-Sea',
 				),
 				'SRY' => array(
					'code' => 'SRY',
 					'name' => 'Surrey',
 				),
 				'STB' => array(
					'code' => 'STB',
 					'name' => 'Strabane',
 				),
 				'STE' => array(
					'code' => 'STE',
 					'name' => 'Stoke-on-Trent',
 				),
 				'STG' => array(
					'code' => 'STG',
 					'name' => 'Stirling',
 				),
 				'STH' => array(
					'code' => 'STH',
 					'name' => 'Southampton',
 				),
 				'STN' => array(
					'code' => 'STN',
 					'name' => 'Sutton',
 				),
 				'STS' => array(
					'code' => 'STS',
 					'name' => 'Staffordshire',
 				),
 				'STT' => array(
					'code' => 'STT',
 					'name' => 'Stockton-On-Tees',
 				),
 				'STY' => array(
					'code' => 'STY',
 					'name' => 'South Tyneside',
 				),
 				'SWA' => array(
					'code' => 'SWA',
 					'name' => 'Swansea (City of) [Abertawe GB-ATA]',
 				),
 				'SWD' => array(
					'code' => 'SWD',
 					'name' => 'Swindon',
 				),
 				'SWK' => array(
					'code' => 'SWK',
 					'name' => 'Southwark',
 				),
 				'TAM' => array(
					'code' => 'TAM',
 					'name' => 'Tameside',
 				),
 				'TFW' => array(
					'code' => 'TFW',
 					'name' => 'Telford and Wrekin',
 				),
 				'THR' => array(
					'code' => 'THR',
 					'name' => 'Thurrock',
 				),
 				'TOB' => array(
					'code' => 'TOB',
 					'name' => 'Torbay',
 				),
 				'TOF' => array(
					'code' => 'TOF',
 					'name' => 'Torfaen [Tor-faen]',
 				),
 				'TRF' => array(
					'code' => 'TRF',
 					'name' => 'Trafford',
 				),
 				'TWH' => array(
					'code' => 'TWH',
 					'name' => 'Tower Hamlets',
 				),
 				'UKM' => array(
					'code' => 'UKM',
 					'name' => 'United Kingdom',
 				),
 				'VGL' => array(
					'code' => 'VGL',
 					'name' => 'Vale of Glamorgan, The [Bro Morgannwg GB-BMG]',
 				),
 				'WAR' => array(
					'code' => 'WAR',
 					'name' => 'Warwickshire',
 				),
 				'WBK' => array(
					'code' => 'WBK',
 					'name' => 'West Berkshire',
 				),
 				'WDU' => array(
					'code' => 'WDU',
 					'name' => 'West Dunbartonshire',
 				),
 				'WFT' => array(
					'code' => 'WFT',
 					'name' => 'Waltham Forest',
 				),
 				'WGN' => array(
					'code' => 'WGN',
 					'name' => 'Wigan',
 				),
 				'WIL' => array(
					'code' => 'WIL',
 					'name' => 'Wiltshire',
 				),
 				'WKF' => array(
					'code' => 'WKF',
 					'name' => 'Wakefield',
 				),
 				'WLL' => array(
					'code' => 'WLL',
 					'name' => 'Walsall',
 				),
 				'WLN' => array(
					'code' => 'WLN',
 					'name' => 'West Lothian',
 				),
 				'WLS' => array(
					'code' => 'WLS',
 					'name' => 'Wales [Cymru]',
 				),
 				'WLV' => array(
					'code' => 'WLV',
 					'name' => 'Wolverhampton',
 				),
 				'WND' => array(
					'code' => 'WND',
 					'name' => 'Wandsworth',
 				),
 				'WNM' => array(
					'code' => 'WNM',
 					'name' => 'Windsor and Maidenhead',
 				),
 				'WOK' => array(
					'code' => 'WOK',
 					'name' => 'Wokingham',
 				),
 				'WOR' => array(
					'code' => 'WOR',
 					'name' => 'Worcestershire',
 				),
 				'WRL' => array(
					'code' => 'WRL',
 					'name' => 'Wirral',
 				),
 				'WRT' => array(
					'code' => 'WRT',
 					'name' => 'Warrington',
 				),
 				'WRX' => array(
					'code' => 'WRX',
 					'name' => 'Wrexham [Wrecsam GB-WRC]',
 				),
 				'WSM' => array(
					'code' => 'WSM',
 					'name' => 'Westminster',
 				),
 				'WSX' => array(
					'code' => 'WSX',
 					'name' => 'West Sussex',
 				),
 				'YOR' => array(
					'code' => 'YOR',
 					'name' => 'York',
 				),
 				'ZET' => array(
					'code' => 'ZET',
 					'name' => 'Shetland Islands',
 				),
 			),
 		),
 		'GD' => array(
			'code' => 'GD',
 			'name' => 'Grenada',
 			'code3' => 'GRD',
 			'numeric' => '308',
 			'states' => array(
			),
 		),
 		'GE' => array(
			'code' => 'GE',
 			'name' => 'Georgia',
 			'code3' => 'GEO',
 			'numeric' => '268',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Abashis Raioni',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Adigenis Raioni',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Akhalgoris Raioni',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Akhalk\'alak\'is Raioni',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Akhalts\'ikhis Raioni',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Akhmetis Raioni',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Ambrolauris Raioni',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Aspindzis Raioni',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Baghdat\'is Raioni',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Bolnisis Raioni',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Borjomis Raioni',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Ch\'khorotsqus Raioni',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Ch\'okhatauris Raioni',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Dedop\'listsqaros Raioni',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Dmanisis Raioni',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Dushet\'is Raioni',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Galis Raioni',
 				),
 				'18' => array(
					'code' => '18',
 					'name' => 'Gardabnis Raioni',
 				),
 				'19' => array(
					'code' => '19',
 					'name' => 'Goris Raioni',
 				),
 				'20' => array(
					'code' => '20',
 					'name' => 'Gudaut\'is Raioni',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Gulrip\'shis Raioni',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Gurjaanis Raioni',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Javis Raioni',
 				),
 				'24' => array(
					'code' => '24',
 					'name' => 'K\'arelis Raioni',
 				),
 				'25' => array(
					'code' => '25',
 					'name' => 'Kaspis Raioni',
 				),
 				'26' => array(
					'code' => '26',
 					'name' => 'K\'edis Raioni',
 				),
 				'27' => array(
					'code' => '27',
 					'name' => 'Kharagaulis Raioni',
 				),
 				'28' => array(
					'code' => '28',
 					'name' => 'Khashuris Raioni',
 				),
 				'29' => array(
					'code' => '29',
 					'name' => 'Khelvach\'auris Raioni',
 				),
 				'30' => array(
					'code' => '30',
 					'name' => 'Khobis Raioni',
 				),
 				'31' => array(
					'code' => '31',
 					'name' => 'Khonis Raioni',
 				),
 				'32' => array(
					'code' => '32',
 					'name' => 'Khulos Raioni',
 				),
 				'33' => array(
					'code' => '33',
 					'name' => 'K\'obuletis Raioni',
 				),
 				'34' => array(
					'code' => '34',
 					'name' => 'Lagodekhis Raioni',
 				),
 				'35' => array(
					'code' => '35',
 					'name' => 'Lanch\'khut\'is Raioni',
 				),
 				'36' => array(
					'code' => '36',
 					'name' => 'Lentekhis Raioni',
 				),
 				'37' => array(
					'code' => '37',
 					'name' => 'Marneulis Raioni',
 				),
 				'38' => array(
					'code' => '38',
 					'name' => 'Martvilis Raioni',
 				),
 				'39' => array(
					'code' => '39',
 					'name' => 'Mestiis Raioni',
 				),
 				'40' => array(
					'code' => '40',
 					'name' => 'Mts\'khet\'is Raioni',
 				),
 				'41' => array(
					'code' => '41',
 					'name' => 'Ninotsmindis Raioni',
 				),
 				'42' => array(
					'code' => '42',
 					'name' => 'Och\'amch\'iris Raioni',
 				),
 				'43' => array(
					'code' => '43',
 					'name' => 'Onis Raioni',
 				),
 				'44' => array(
					'code' => '44',
 					'name' => 'Ozurget\'is Raioni',
 				),
 				'45' => array(
					'code' => '45',
 					'name' => 'Qazbegis Raioni',
 				),
 				'46' => array(
					'code' => '46',
 					'name' => 'Qvarlis Raioni',
 				),
 				'47' => array(
					'code' => '47',
 					'name' => 'Sach\'kheris Raioni',
 				),
 				'48' => array(
					'code' => '48',
 					'name' => 'Sagarejos Raioni',
 				),
 				'49' => array(
					'code' => '49',
 					'name' => 'Samtrediis Raioni',
 				),
 				'50' => array(
					'code' => '50',
 					'name' => 'Senakis Raioni',
 				),
 				'51' => array(
					'code' => '51',
 					'name' => 'Shuakhevis Raioni',
 				),
 				'52' => array(
					'code' => '52',
 					'name' => 'Sighnaghis Raioni',
 				),
 				'53' => array(
					'code' => '53',
 					'name' => 'Sokhumis Raioni',
 				),
 				'54' => array(
					'code' => '54',
 					'name' => 'T\'elavis Raioni',
 				),
 				'55' => array(
					'code' => '55',
 					'name' => 'T\'erjolis Raioni',
 				),
 				'56' => array(
					'code' => '56',
 					'name' => 'T\'et\'ritsqaros Raioni',
 				),
 				'57' => array(
					'code' => '57',
 					'name' => 'T\'ianet\'is Raioni',
 				),
 				'58' => array(
					'code' => '58',
 					'name' => 'Ts\'ageris Raioni',
 				),
 				'59' => array(
					'code' => '59',
 					'name' => 'Tsalenjikhis Raioni',
 				),
 				'60' => array(
					'code' => '60',
 					'name' => 'Tsalkis Raioni',
 				),
 				'61' => array(
					'code' => '61',
 					'name' => 'Vanis Raioni',
 				),
 				'62' => array(
					'code' => '62',
 					'name' => 'Zestap\'onis Raioni',
 				),
 				'63' => array(
					'code' => '63',
 					'name' => 'Zugdidis Raioni',
 				),
 				'AB' => array(
					'code' => 'AB',
 					'name' => 'Ap\'khazet\'is Avtonomiuri Respublika [Abkhazia]',
 				),
 				'AJ' => array(
					'code' => 'AJ',
 					'name' => 'Acharis Avtonomiuri Respublika [Ajaria]',
 				),
 				'BUS' => array(
					'code' => 'BUS',
 					'name' => 'Bat\'umi',
 				),
 				'CHI' => array(
					'code' => 'CHI',
 					'name' => 'Chiat\'ura',
 				),
 				'GAG' => array(
					'code' => 'GAG',
 					'name' => 'Gagra',
 				),
 				'GOR' => array(
					'code' => 'GOR',
 					'name' => 'Gori',
 				),
 				'KUT' => array(
					'code' => 'KUT',
 					'name' => 'K\'ut\'aisi',
 				),
 				'PTI' => array(
					'code' => 'PTI',
 					'name' => 'P\'ot\'i',
 				),
 				'RUS' => array(
					'code' => 'RUS',
 					'name' => 'Rust\'avi',
 				),
 				'SUI' => array(
					'code' => 'SUI',
 					'name' => 'Sokhumi',
 				),
 				'TBS' => array(
					'code' => 'TBS',
 					'name' => 'T\'bilisi',
 				),
 				'TQI' => array(
					'code' => 'TQI',
 					'name' => 'Tqibuli',
 				),
 				'TQV' => array(
					'code' => 'TQV',
 					'name' => 'Tqvarch\'eli',
 				),
 				'TSQ' => array(
					'code' => 'TSQ',
 					'name' => 'Tsqalmbo',
 				),
 				'ZUG' => array(
					'code' => 'ZUG',
 					'name' => 'Zugdidi',
 				),
 			),
 		),
 		'GF' => array(
			'code' => 'GF',
 			'name' => 'French Guiana',
 			'code3' => 'GUF',
 			'numeric' => '254',
 			'states' => array(
			),
 		),
 		'GG' => array(
			'code' => 'GG',
 			'name' => 'Guernsey',
 			'code3' => 'GGY',
 			'numeric' => '831',
 			'states' => array(
			),
 		),
 		'GH' => array(
			'code' => 'GH',
 			'name' => 'Ghana',
 			'code3' => 'GHA',
 			'numeric' => '288',
 			'states' => array(
				'AA' => array(
					'code' => 'AA',
 					'name' => 'Greater Accra',
 				),
 				'AH' => array(
					'code' => 'AH',
 					'name' => 'Ashanti',
 				),
 				'BA' => array(
					'code' => 'BA',
 					'name' => 'Brong-Ahafo',
 				),
 				'CP' => array(
					'code' => 'CP',
 					'name' => 'Central',
 				),
 				'EP' => array(
					'code' => 'EP',
 					'name' => 'Eastern',
 				),
 				'NP' => array(
					'code' => 'NP',
 					'name' => 'Northern',
 				),
 				'TV' => array(
					'code' => 'TV',
 					'name' => 'Volta',
 				),
 				'UE' => array(
					'code' => 'UE',
 					'name' => 'Upper East',
 				),
 				'UW' => array(
					'code' => 'UW',
 					'name' => 'Upper West',
 				),
 				'WP' => array(
					'code' => 'WP',
 					'name' => 'Western',
 				),
 			),
 		),
 		'GI' => array(
			'code' => 'GI',
 			'name' => 'Gibraltar',
 			'code3' => 'GIB',
 			'numeric' => '292',
 			'states' => array(
			),
 		),
 		'GL' => array(
			'code' => 'GL',
 			'name' => 'Greenland',
 			'code3' => 'GRL',
 			'numeric' => '304',
 			'states' => array(
			),
 		),
 		'GM' => array(
			'code' => 'GM',
 			'name' => 'Gambia',
 			'code3' => 'GMB',
 			'numeric' => '270',
 			'states' => array(
				'B' => array(
					'code' => 'B',
 					'name' => 'Banjul',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'Lower River',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'MacCarthy Island',
 				),
 				'N' => array(
					'code' => 'N',
 					'name' => 'North Bank',
 				),
 				'U' => array(
					'code' => 'U',
 					'name' => 'Upper River',
 				),
 				'W' => array(
					'code' => 'W',
 					'name' => 'Western',
 				),
 			),
 		),
 		'GN' => array(
			'code' => 'GN',
 			'name' => 'Guinea',
 			'code3' => 'GIN',
 			'numeric' => '324',
 			'states' => array(
				'B' => array(
					'code' => 'B',
 					'name' => 'Bake, Gouvernorat de',
 				),
 				'BE' => array(
					'code' => 'BE',
 					'name' => 'Beyla',
 				),
 				'BF' => array(
					'code' => 'BF',
 					'name' => 'Boffa',
 				),
 				'BK' => array(
					'code' => 'BK',
 					'name' => 'Boké',
 				),
 				'C' => array(
					'code' => 'C',
 					'name' => 'Conakry, Gouvernorat de',
 				),
 				'CO' => array(
					'code' => 'CO',
 					'name' => 'Coyah',
 				),
 				'D' => array(
					'code' => 'D',
 					'name' => 'Kindia, Gouvernorat de',
 				),
 				'DB' => array(
					'code' => 'DB',
 					'name' => 'Dabola',
 				),
 				'DI' => array(
					'code' => 'DI',
 					'name' => 'Dinguiraye',
 				),
 				'DL' => array(
					'code' => 'DL',
 					'name' => 'Dalaba',
 				),
 				'DU' => array(
					'code' => 'DU',
 					'name' => 'Dubréka',
 				),
 				'F' => array(
					'code' => 'F',
 					'name' => 'Faranah, Gouvernorat de',
 				),
 				'FA' => array(
					'code' => 'FA',
 					'name' => 'Faranah',
 				),
 				'FO' => array(
					'code' => 'FO',
 					'name' => 'Forécariah',
 				),
 				'FR' => array(
					'code' => 'FR',
 					'name' => 'Fria',
 				),
 				'GA' => array(
					'code' => 'GA',
 					'name' => 'Gaoual',
 				),
 				'GU' => array(
					'code' => 'GU',
 					'name' => 'Guékédou',
 				),
 				'K' => array(
					'code' => 'K',
 					'name' => 'Kankan, Gouvernorat de',
 				),
 				'KA' => array(
					'code' => 'KA',
 					'name' => 'Kankan',
 				),
 				'KB' => array(
					'code' => 'KB',
 					'name' => 'Koubia',
 				),
 				'KD' => array(
					'code' => 'KD',
 					'name' => 'Koundara',
 				),
 				'KE' => array(
					'code' => 'KE',
 					'name' => 'Kérouané',
 				),
 				'KO' => array(
					'code' => 'KO',
 					'name' => 'Kouroussa',
 				),
 				'KS' => array(
					'code' => 'KS',
 					'name' => 'Kissidougou',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'Labé, Gouvernorat de',
 				),
 				'LA' => array(
					'code' => 'LA',
 					'name' => 'Labé',
 				),
 				'LE' => array(
					'code' => 'LE',
 					'name' => 'Lélouma',
 				),
 				'LO' => array(
					'code' => 'LO',
 					'name' => 'Lola',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'Mamou, Gouvernorat de',
 				),
 				'MC' => array(
					'code' => 'MC',
 					'name' => 'Macenta',
 				),
 				'MD' => array(
					'code' => 'MD',
 					'name' => 'Mandiana',
 				),
 				'ML' => array(
					'code' => 'ML',
 					'name' => 'Mali',
 				),
 				'MM' => array(
					'code' => 'MM',
 					'name' => 'Mamou',
 				),
 				'N' => array(
					'code' => 'N',
 					'name' => 'Nzérékoré, Gouvernorat de',
 				),
 				'NZ' => array(
					'code' => 'NZ',
 					'name' => 'Nzérékoré',
 				),
 				'PI' => array(
					'code' => 'PI',
 					'name' => 'Pita',
 				),
 				'SI' => array(
					'code' => 'SI',
 					'name' => 'Siguiri',
 				),
 				'TE' => array(
					'code' => 'TE',
 					'name' => 'Télimélé',
 				),
 				'TO' => array(
					'code' => 'TO',
 					'name' => 'Tougué',
 				),
 				'YO' => array(
					'code' => 'YO',
 					'name' => 'Yomou',
 				),
 			),
 		),
 		'GP' => array(
			'code' => 'GP',
 			'name' => 'Guadeloupe',
 			'code3' => 'GLP',
 			'numeric' => '312',
 			'states' => array(
			),
 		),
 		'GQ' => array(
			'code' => 'GQ',
 			'name' => 'Equatorial Guinea',
 			'code3' => 'GNQ',
 			'numeric' => '226',
 			'states' => array(
				'AN' => array(
					'code' => 'AN',
 					'name' => 'Annobón',
 				),
 				'BN' => array(
					'code' => 'BN',
 					'name' => 'Bioko Norte',
 				),
 				'BS' => array(
					'code' => 'BS',
 					'name' => 'Bioko Sur',
 				),
 				'C' => array(
					'code' => 'C',
 					'name' => 'Región Continental',
 				),
 				'CS' => array(
					'code' => 'CS',
 					'name' => 'Centro Sur',
 				),
 				'I' => array(
					'code' => 'I',
 					'name' => 'Región Insular',
 				),
 				'KN' => array(
					'code' => 'KN',
 					'name' => 'Kie-Ntem',
 				),
 				'LI' => array(
					'code' => 'LI',
 					'name' => 'Litoral',
 				),
 				'WN' => array(
					'code' => 'WN',
 					'name' => 'Wele-Nzás',
 				),
 			),
 		),
 		'GR' => array(
			'code' => 'GR',
 			'name' => 'Greece',
 			'code3' => 'GRC',
 			'numeric' => '300',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Aitolia-Akarnania',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Voiotia',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Evvoia',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Evrytania',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Fthiotis',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Fokis',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Argolis',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Arkadia',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Achaïa',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Ileia',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Korinthia',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Lakonia',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Messinia',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Zakynthos',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Kerkyra',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Kefallinia',
 				),
 				'24' => array(
					'code' => '24',
 					'name' => 'Lefkas',
 				),
 				'31' => array(
					'code' => '31',
 					'name' => 'Arta',
 				),
 				'32' => array(
					'code' => '32',
 					'name' => 'Thesprotia',
 				),
 				'33' => array(
					'code' => '33',
 					'name' => 'Ioannina',
 				),
 				'34' => array(
					'code' => '34',
 					'name' => 'Preveza',
 				),
 				'41' => array(
					'code' => '41',
 					'name' => 'Karditsa',
 				),
 				'42' => array(
					'code' => '42',
 					'name' => 'Larisa',
 				),
 				'43' => array(
					'code' => '43',
 					'name' => 'Magnisia',
 				),
 				'44' => array(
					'code' => '44',
 					'name' => 'Trikala',
 				),
 				'51' => array(
					'code' => '51',
 					'name' => 'Grevena',
 				),
 				'52' => array(
					'code' => '52',
 					'name' => 'Drama',
 				),
 				'53' => array(
					'code' => '53',
 					'name' => 'Imathia',
 				),
 				'54' => array(
					'code' => '54',
 					'name' => 'Thessaloniki',
 				),
 				'55' => array(
					'code' => '55',
 					'name' => 'Kavalla',
 				),
 				'56' => array(
					'code' => '56',
 					'name' => 'Kastoria',
 				),
 				'57' => array(
					'code' => '57',
 					'name' => 'Kilkis',
 				),
 				'58' => array(
					'code' => '58',
 					'name' => 'Kozani',
 				),
 				'59' => array(
					'code' => '59',
 					'name' => 'Pella',
 				),
 				'61' => array(
					'code' => '61',
 					'name' => 'Pieria',
 				),
 				'62' => array(
					'code' => '62',
 					'name' => 'Serrai',
 				),
 				'63' => array(
					'code' => '63',
 					'name' => 'Florina',
 				),
 				'64' => array(
					'code' => '64',
 					'name' => 'Chalkidiki',
 				),
 				'71' => array(
					'code' => '71',
 					'name' => 'Evros',
 				),
 				'72' => array(
					'code' => '72',
 					'name' => 'Xanthi',
 				),
 				'73' => array(
					'code' => '73',
 					'name' => 'Rodopi',
 				),
 				'81' => array(
					'code' => '81',
 					'name' => 'Dodekanisos',
 				),
 				'82' => array(
					'code' => '82',
 					'name' => 'Kyklades',
 				),
 				'83' => array(
					'code' => '83',
 					'name' => 'Lesvos',
 				),
 				'84' => array(
					'code' => '84',
 					'name' => 'Samos',
 				),
 				'85' => array(
					'code' => '85',
 					'name' => 'Chios',
 				),
 				'91' => array(
					'code' => '91',
 					'name' => 'Irakleion',
 				),
 				'92' => array(
					'code' => '92',
 					'name' => 'Lasithion',
 				),
 				'93' => array(
					'code' => '93',
 					'name' => 'Rethymnon',
 				),
 				'94' => array(
					'code' => '94',
 					'name' => 'Chania',
 				),
 				'A1' => array(
					'code' => 'A1',
 					'name' => 'Attiki',
 				),
 				'I' => array(
					'code' => 'I',
 					'name' => 'Anatoliki Makedonia kai Thraki',
 				),
 				'II' => array(
					'code' => 'II',
 					'name' => 'Kentriki Makedonia',
 				),
 				'III' => array(
					'code' => 'III',
 					'name' => 'Dytiki Makedonia',
 				),
 				'IV' => array(
					'code' => 'IV',
 					'name' => 'Ipeiros',
 				),
 				'IX' => array(
					'code' => 'IX',
 					'name' => 'Attiki',
 				),
 				'V' => array(
					'code' => 'V',
 					'name' => 'Thessalia',
 				),
 				'VI' => array(
					'code' => 'VI',
 					'name' => 'Ionioi Nisoi',
 				),
 				'VII' => array(
					'code' => 'VII',
 					'name' => 'Dytiki Ellada',
 				),
 				'VIII' => array(
					'code' => 'VIII',
 					'name' => 'Sterea Ellada',
 				),
 				'X' => array(
					'code' => 'X',
 					'name' => 'Peloponnisos',
 				),
 				'XI' => array(
					'code' => 'XI',
 					'name' => 'Voreio Aigaio',
 				),
 				'XII' => array(
					'code' => 'XII',
 					'name' => 'Notio Aigaio',
 				),
 				'XIII' => array(
					'code' => 'XIII',
 					'name' => 'Kriti',
 				),
 			),
 		),
 		'GS' => array(
			'code' => 'GS',
 			'name' => 'S.Georgia & S.Sandwich Islands',
 			'code3' => 'SGS',
 			'numeric' => '239',
 			'states' => array(
			),
 		),
 		'GT' => array(
			'code' => 'GT',
 			'name' => 'Guatemala',
 			'code3' => 'GTM',
 			'numeric' => '320',
 			'states' => array(
				'AV' => array(
					'code' => 'AV',
 					'name' => 'Alta Verapaz',
 				),
 				'BV' => array(
					'code' => 'BV',
 					'name' => 'Baja Verapaz',
 				),
 				'CM' => array(
					'code' => 'CM',
 					'name' => 'Chimaltenango',
 				),
 				'CQ' => array(
					'code' => 'CQ',
 					'name' => 'Chiquimula',
 				),
 				'ES' => array(
					'code' => 'ES',
 					'name' => 'Escuintla',
 				),
 				'GU' => array(
					'code' => 'GU',
 					'name' => 'Guatemala',
 				),
 				'HU' => array(
					'code' => 'HU',
 					'name' => 'Huehuetenango',
 				),
 				'IZ' => array(
					'code' => 'IZ',
 					'name' => 'Izabal',
 				),
 				'JA' => array(
					'code' => 'JA',
 					'name' => 'Jalapa',
 				),
 				'JU' => array(
					'code' => 'JU',
 					'name' => 'Jutiapa',
 				),
 				'PE' => array(
					'code' => 'PE',
 					'name' => 'Petén',
 				),
 				'PR' => array(
					'code' => 'PR',
 					'name' => 'El Progreso',
 				),
 				'QC' => array(
					'code' => 'QC',
 					'name' => 'Quiché',
 				),
 				'QZ' => array(
					'code' => 'QZ',
 					'name' => 'Quezaltenango',
 				),
 				'RE' => array(
					'code' => 'RE',
 					'name' => 'Retalhuleu',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Sacatepéquez',
 				),
 				'SM' => array(
					'code' => 'SM',
 					'name' => 'San Marcos',
 				),
 				'SO' => array(
					'code' => 'SO',
 					'name' => 'Sololá',
 				),
 				'SR' => array(
					'code' => 'SR',
 					'name' => 'Santa Rosa',
 				),
 				'SU' => array(
					'code' => 'SU',
 					'name' => 'Suchitepéquez',
 				),
 				'TO' => array(
					'code' => 'TO',
 					'name' => 'Totonicapán',
 				),
 				'ZA' => array(
					'code' => 'ZA',
 					'name' => 'Zacapa',
 				),
 			),
 		),
 		'GU' => array(
			'code' => 'GU',
 			'name' => 'Guam',
 			'code3' => 'GUM',
 			'numeric' => '316',
 			'states' => array(
			),
 		),
 		'GW' => array(
			'code' => 'GW',
 			'name' => 'Guinea-Bissau',
 			'code3' => 'GNB',
 			'numeric' => '624',
 			'states' => array(
				'BA' => array(
					'code' => 'BA',
 					'name' => 'Bafatá',
 				),
 				'BL' => array(
					'code' => 'BL',
 					'name' => 'Bolama',
 				),
 				'BM' => array(
					'code' => 'BM',
 					'name' => 'Biombo',
 				),
 				'BS' => array(
					'code' => 'BS',
 					'name' => 'Bissau',
 				),
 				'CA' => array(
					'code' => 'CA',
 					'name' => 'Cacheu',
 				),
 				'GA' => array(
					'code' => 'GA',
 					'name' => 'Gabú',
 				),
 				'OI' => array(
					'code' => 'OI',
 					'name' => 'Oio',
 				),
 				'QU' => array(
					'code' => 'QU',
 					'name' => 'Quinara',
 				),
 			),
 		),
 		'GY' => array(
			'code' => 'GY',
 			'name' => 'Guyana',
 			'code3' => 'GUY',
 			'numeric' => '328',
 			'states' => array(
				'BA' => array(
					'code' => 'BA',
 					'name' => 'Barima-Waini',
 				),
 				'CU' => array(
					'code' => 'CU',
 					'name' => 'Cuyuni-Mazaruni',
 				),
 				'DE' => array(
					'code' => 'DE',
 					'name' => 'Demerara-Mahaica',
 				),
 				'EB' => array(
					'code' => 'EB',
 					'name' => 'East Berbice-Corentyne',
 				),
 				'ES' => array(
					'code' => 'ES',
 					'name' => 'Essequibo Islands-West Demerara',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Mahaica-Berbice',
 				),
 				'PM' => array(
					'code' => 'PM',
 					'name' => 'Pomeroon-Supenaam',
 				),
 				'PT' => array(
					'code' => 'PT',
 					'name' => 'Potaro-Siparuni',
 				),
 				'UD' => array(
					'code' => 'UD',
 					'name' => 'Upper Demerara-Berbice',
 				),
 				'UT' => array(
					'code' => 'UT',
 					'name' => 'Upper Takutu-Upper Essequibo',
 				),
 			),
 		),
 		'HK' => array(
			'code' => 'HK',
 			'name' => 'Hong Kong',
 			'code3' => 'HKG',
 			'numeric' => '344',
 			'states' => array(
			),
 		),
 		'HM' => array(
			'code' => 'HM',
 			'name' => 'Heard & McDonald Islands',
 			'code3' => 'HMD',
 			'numeric' => '334',
 			'states' => array(
			),
 		),
 		'HN' => array(
			'code' => 'HN',
 			'name' => 'Honduras',
 			'code3' => 'HND',
 			'numeric' => '340',
 			'states' => array(
				'AT' => array(
					'code' => 'AT',
 					'name' => 'Atlántida',
 				),
 				'CH' => array(
					'code' => 'CH',
 					'name' => 'Choluteca',
 				),
 				'CL' => array(
					'code' => 'CL',
 					'name' => 'Colón',
 				),
 				'CM' => array(
					'code' => 'CM',
 					'name' => 'Comayagua',
 				),
 				'CP' => array(
					'code' => 'CP',
 					'name' => 'Copán',
 				),
 				'CR' => array(
					'code' => 'CR',
 					'name' => 'Cortés',
 				),
 				'EP' => array(
					'code' => 'EP',
 					'name' => 'El Paraíso',
 				),
 				'FM' => array(
					'code' => 'FM',
 					'name' => 'Francisco Morazán',
 				),
 				'GD' => array(
					'code' => 'GD',
 					'name' => 'Gracias a Dios',
 				),
 				'IB' => array(
					'code' => 'IB',
 					'name' => 'Islas de la Bahía',
 				),
 				'IN' => array(
					'code' => 'IN',
 					'name' => 'Intibucá',
 				),
 				'LE' => array(
					'code' => 'LE',
 					'name' => 'Lempira',
 				),
 				'LP' => array(
					'code' => 'LP',
 					'name' => 'La Paz',
 				),
 				'OC' => array(
					'code' => 'OC',
 					'name' => 'Ocotepeque',
 				),
 				'OL' => array(
					'code' => 'OL',
 					'name' => 'Olancho',
 				),
 				'SB' => array(
					'code' => 'SB',
 					'name' => 'Santa Bárbara',
 				),
 				'VA' => array(
					'code' => 'VA',
 					'name' => 'Valle',
 				),
 				'YO' => array(
					'code' => 'YO',
 					'name' => 'Yoro',
 				),
 			),
 		),
 		'HR' => array(
			'code' => 'HR',
 			'name' => 'Croatia',
 			'code3' => 'HRV',
 			'numeric' => '191',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Zagrebačka županija',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Krapinsko-zagorska županija',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Sisaško-moslavačka županija',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Karlovačka županija',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Varaždinska županija',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Koprivničkco-križevačka županija',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Bjelovarsko-bilogorska županija',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Primorsko-goranska županija',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Ličko-senjska županija',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Virovitičko-podravska županija',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Požeško-slavonska županija',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Brodsko-posavska županija',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Zadarska županija',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Osječko-baranjska županija',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Šibensko-kninska županija',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Vukovarsko-srijemska županija',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Splitsko-dalmatinska županija',
 				),
 				'18' => array(
					'code' => '18',
 					'name' => 'Istarska županija',
 				),
 				'19' => array(
					'code' => '19',
 					'name' => 'Dubrovačko-neretvanska županija',
 				),
 				'20' => array(
					'code' => '20',
 					'name' => 'Medjimurska županija',
 				),
 			),
 		),
 		'HT' => array(
			'code' => 'HT',
 			'name' => 'Haiti',
 			'code3' => 'HTI',
 			'numeric' => '332',
 			'states' => array(
				'AR' => array(
					'code' => 'AR',
 					'name' => 'Artibonite',
 				),
 				'CE' => array(
					'code' => 'CE',
 					'name' => 'Centre',
 				),
 				'GA' => array(
					'code' => 'GA',
 					'name' => 'Grande-Anse',
 				),
 				'ND' => array(
					'code' => 'ND',
 					'name' => 'Nord',
 				),
 				'NE' => array(
					'code' => 'NE',
 					'name' => 'Nord-Est',
 				),
 				'NO' => array(
					'code' => 'NO',
 					'name' => 'Nord-Ouest',
 				),
 				'OU' => array(
					'code' => 'OU',
 					'name' => 'Ouest',
 				),
 				'SD' => array(
					'code' => 'SD',
 					'name' => 'Sud',
 				),
 				'SE' => array(
					'code' => 'SE',
 					'name' => 'Sud-Est',
 				),
 			),
 		),
 		'HU' => array(
			'code' => 'HU',
 			'name' => 'Hungary',
 			'code3' => 'HUN',
 			'numeric' => '348',
 			'states' => array(
				'BA' => array(
					'code' => 'BA',
 					'name' => 'Baranya',
 				),
 				'BC' => array(
					'code' => 'BC',
 					'name' => 'Békéscsaba',
 				),
 				'BE' => array(
					'code' => 'BE',
 					'name' => 'Békés',
 				),
 				'BK' => array(
					'code' => 'BK',
 					'name' => 'Bács-Kiskun',
 				),
 				'BU' => array(
					'code' => 'BU',
 					'name' => 'Budapest',
 				),
 				'BZ' => array(
					'code' => 'BZ',
 					'name' => 'Borsod-Abaúj-Zemplén',
 				),
 				'CS' => array(
					'code' => 'CS',
 					'name' => 'Csongrád',
 				),
 				'DE' => array(
					'code' => 'DE',
 					'name' => 'Debrecen',
 				),
 				'DU' => array(
					'code' => 'DU',
 					'name' => 'Dunaújváros',
 				),
 				'EG' => array(
					'code' => 'EG',
 					'name' => 'Eger',
 				),
 				'FE' => array(
					'code' => 'FE',
 					'name' => 'Fejér',
 				),
 				'GS' => array(
					'code' => 'GS',
 					'name' => 'Gyór-Moson-Sopron',
 				),
 				'GY' => array(
					'code' => 'GY',
 					'name' => 'Gyór',
 				),
 				'HB' => array(
					'code' => 'HB',
 					'name' => 'Hajdú-Bihar',
 				),
 				'HE' => array(
					'code' => 'HE',
 					'name' => 'Heves',
 				),
 				'HV' => array(
					'code' => 'HV',
 					'name' => 'Hódmezóvásárhely',
 				),
 				'JN' => array(
					'code' => 'JN',
 					'name' => 'Jasz-Nagykun-Szolnok',
 				),
 				'KE' => array(
					'code' => 'KE',
 					'name' => 'Komárom-Esztergom',
 				),
 				'KM' => array(
					'code' => 'KM',
 					'name' => 'Kecskemét',
 				),
 				'KV' => array(
					'code' => 'KV',
 					'name' => 'Kaposvár',
 				),
 				'MI' => array(
					'code' => 'MI',
 					'name' => 'Miskolc',
 				),
 				'NK' => array(
					'code' => 'NK',
 					'name' => 'Nagykanizsa',
 				),
 				'NO' => array(
					'code' => 'NO',
 					'name' => 'Nógrád',
 				),
 				'NY' => array(
					'code' => 'NY',
 					'name' => 'Nyíregyháza',
 				),
 				'PE' => array(
					'code' => 'PE',
 					'name' => 'Pest',
 				),
 				'PS' => array(
					'code' => 'PS',
 					'name' => 'Pécs',
 				),
 				'SD' => array(
					'code' => 'SD',
 					'name' => 'Szeged',
 				),
 				'SF' => array(
					'code' => 'SF',
 					'name' => 'Székesfehérvár',
 				),
 				'SH' => array(
					'code' => 'SH',
 					'name' => 'Szombathely',
 				),
 				'SK' => array(
					'code' => 'SK',
 					'name' => 'Szolnok',
 				),
 				'SN' => array(
					'code' => 'SN',
 					'name' => 'Sopron',
 				),
 				'SO' => array(
					'code' => 'SO',
 					'name' => 'Somogy',
 				),
 				'SS' => array(
					'code' => 'SS',
 					'name' => 'Szekszárd',
 				),
 				'ST' => array(
					'code' => 'ST',
 					'name' => 'Salgótarján',
 				),
 				'SZ' => array(
					'code' => 'SZ',
 					'name' => 'Szabolcs-Szatmár-Bereg',
 				),
 				'TB' => array(
					'code' => 'TB',
 					'name' => 'Tatabánya',
 				),
 				'TO' => array(
					'code' => 'TO',
 					'name' => 'Tolna',
 				),
 				'VA' => array(
					'code' => 'VA',
 					'name' => 'Vas',
 				),
 				'VE' => array(
					'code' => 'VE',
 					'name' => 'Veszprém',
 				),
 				'VM' => array(
					'code' => 'VM',
 					'name' => 'Veszprém',
 				),
 				'ZA' => array(
					'code' => 'ZA',
 					'name' => 'Zala',
 				),
 				'ZE' => array(
					'code' => 'ZE',
 					'name' => 'Zalaegerszeg',
 				),
 			),
 		),
 		'ID' => array(
			'code' => 'ID',
 			'name' => 'Indonesia',
 			'code3' => 'IDN',
 			'numeric' => '360',
 			'states' => array(
				'AC' => array(
					'code' => 'AC',
 					'name' => 'Aceh',
 				),
 				'BA' => array(
					'code' => 'BA',
 					'name' => 'Bali',
 				),
 				'BE' => array(
					'code' => 'BE',
 					'name' => 'Bengkulu',
 				),
 				'IJ' => array(
					'code' => 'IJ',
 					'name' => 'Irian Jaya',
 				),
 				'IJU' => array(
					'code' => 'IJU',
 					'name' => 'Irian Jaya',
 				),
 				'JA' => array(
					'code' => 'JA',
 					'name' => 'Jambi',
 				),
 				'JB' => array(
					'code' => 'JB',
 					'name' => 'Jawa Barat',
 				),
 				'JI' => array(
					'code' => 'JI',
 					'name' => 'Jawa Timur',
 				),
 				'JK' => array(
					'code' => 'JK',
 					'name' => 'Jakarta Raya',
 				),
 				'JT' => array(
					'code' => 'JT',
 					'name' => 'Jawa Tengah',
 				),
 				'JWU' => array(
					'code' => 'JWU',
 					'name' => 'Jawa',
 				),
 				'KAU' => array(
					'code' => 'KAU',
 					'name' => 'Kalimantan',
 				),
 				'KB' => array(
					'code' => 'KB',
 					'name' => 'Kalimantan Barat',
 				),
 				'KI' => array(
					'code' => 'KI',
 					'name' => 'Kalimantan Timur',
 				),
 				'KS' => array(
					'code' => 'KS',
 					'name' => 'Kalimantan Selatan',
 				),
 				'KT' => array(
					'code' => 'KT',
 					'name' => 'Kalimantan Tengah',
 				),
 				'LA' => array(
					'code' => 'LA',
 					'name' => 'Lampung',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Maluku',
 				),
 				'MAU' => array(
					'code' => 'MAU',
 					'name' => 'Maluku',
 				),
 				'NB' => array(
					'code' => 'NB',
 					'name' => 'Nusa Tenggara Barat',
 				),
 				'NT' => array(
					'code' => 'NT',
 					'name' => 'Nusa Tenggara Timur',
 				),
 				'NUU' => array(
					'code' => 'NUU',
 					'name' => 'Nusa Tenggara',
 				),
 				'RI' => array(
					'code' => 'RI',
 					'name' => 'Riau',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Sulawesi Utara',
 				),
 				'SB' => array(
					'code' => 'SB',
 					'name' => 'Sumatera Barat',
 				),
 				'SG' => array(
					'code' => 'SG',
 					'name' => 'Sulawesi Tenggara',
 				),
 				'SLU' => array(
					'code' => 'SLU',
 					'name' => 'Sulawesi',
 				),
 				'SMU' => array(
					'code' => 'SMU',
 					'name' => 'Sumatera',
 				),
 				'SN' => array(
					'code' => 'SN',
 					'name' => 'Sulawesi Selatan',
 				),
 				'SS' => array(
					'code' => 'SS',
 					'name' => 'Sumatera Selatan',
 				),
 				'ST' => array(
					'code' => 'ST',
 					'name' => 'Sulawesi Tengah',
 				),
 				'SU' => array(
					'code' => 'SU',
 					'name' => 'Sumatera Utara',
 				),
 				'TT' => array(
					'code' => 'TT',
 					'name' => 'Timor Timur',
 				),
 				'YO' => array(
					'code' => 'YO',
 					'name' => 'Yogyakarta',
 				),
 			),
 		),
 		'IE' => array(
			'code' => 'IE',
 			'name' => 'Ireland',
 			'code3' => 'IRL',
 			'numeric' => '372',
 			'states' => array(
				'CN' => array(
					'code' => 'CN',
 					'name' => 'Cavan',
 				),
 				'CP' => array(
					'code' => 'CP',
 					'name' => 'Connaught',
 				),
 				'CW' => array(
					'code' => 'CW',
 					'name' => 'Carlow',
 				),
 				'D' => array(
					'code' => 'D',
 					'name' => 'Dublin',
 				),
 				'DL' => array(
					'code' => 'DL',
 					'name' => 'Donegal',
 				),
 				'G' => array(
					'code' => 'G',
 					'name' => 'Galway',
 				),
 				'KE' => array(
					'code' => 'KE',
 					'name' => 'Kildare',
 				),
 				'KK' => array(
					'code' => 'KK',
 					'name' => 'Kilkenny',
 				),
 				'LD' => array(
					'code' => 'LD',
 					'name' => 'Longford',
 				),
 				'LH' => array(
					'code' => 'LH',
 					'name' => 'Louth',
 				),
 				'LM' => array(
					'code' => 'LM',
 					'name' => 'Leitrim',
 				),
 				'LP' => array(
					'code' => 'LP',
 					'name' => 'Leinster',
 				),
 				'LS' => array(
					'code' => 'LS',
 					'name' => 'Laois',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'Munster',
 				),
 				'MH' => array(
					'code' => 'MH',
 					'name' => 'Meath',
 				),
 				'MN' => array(
					'code' => 'MN',
 					'name' => 'Monaghan',
 				),
 				'MO' => array(
					'code' => 'MO',
 					'name' => 'Mayo',
 				),
 				'OY' => array(
					'code' => 'OY',
 					'name' => 'Offaly',
 				),
 				'RN' => array(
					'code' => 'RN',
 					'name' => 'Roscommon',
 				),
 				'SO' => array(
					'code' => 'SO',
 					'name' => 'Sligo',
 				),
 				'UP' => array(
					'code' => 'UP',
 					'name' => 'Ulster',
 				),
 				'WH' => array(
					'code' => 'WH',
 					'name' => 'Westmeath',
 				),
 				'WW' => array(
					'code' => 'WW',
 					'name' => 'Wicklow',
 				),
 				'WX' => array(
					'code' => 'WX',
 					'name' => 'Wexford',
 				),
 			),
 		),
 		'IL' => array(
			'code' => 'IL',
 			'name' => 'Israel',
 			'code3' => 'ISR',
 			'numeric' => '376',
 			'states' => array(
				'2' => array(
					'code' => '2',
 					'name' => 'HaZafon',
 				),
 				'D' => array(
					'code' => 'D',
 					'name' => 'HaDarom',
 				),
 				'HA' => array(
					'code' => 'HA',
 					'name' => 'Hefa',
 				),
 				'JM' => array(
					'code' => 'JM',
 					'name' => 'Yerushalayim',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'HaMerkaz',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Tel-Aviv',
 				),
 			),
 		),
 		'IM' => array(
			'code' => 'IM',
 			'name' => 'Isle of Man',
 			'code3' => 'IMN',
 			'numeric' => '833',
 			'states' => array(
			),
 		),
 		'IN' => array(
			'code' => 'IN',
 			'name' => 'India',
 			'code3' => 'IND',
 			'numeric' => '356',
 			'states' => array(
				'AN' => array(
					'code' => 'AN',
 					'name' => 'Andaman and Nicobar Islands',
 				),
 				'AP' => array(
					'code' => 'AP',
 					'name' => 'Andhra Pradesh',
 				),
 				'AR' => array(
					'code' => 'AR',
 					'name' => 'Arunachal Pradesh',
 				),
 				'AS' => array(
					'code' => 'AS',
 					'name' => 'Assam',
 				),
 				'BR' => array(
					'code' => 'BR',
 					'name' => 'Bihar',
 				),
 				'CH' => array(
					'code' => 'CH',
 					'name' => 'Chandigarh',
 				),
 				'DD' => array(
					'code' => 'DD',
 					'name' => 'Daman and Diu',
 				),
 				'DL' => array(
					'code' => 'DL',
 					'name' => 'Delhi',
 				),
 				'DN' => array(
					'code' => 'DN',
 					'name' => 'Dadra and Nagar Haveli',
 				),
 				'GA' => array(
					'code' => 'GA',
 					'name' => 'Goa',
 				),
 				'GJ' => array(
					'code' => 'GJ',
 					'name' => 'Gujarat',
 				),
 				'HP' => array(
					'code' => 'HP',
 					'name' => 'Himachal Pradesh',
 				),
 				'HR' => array(
					'code' => 'HR',
 					'name' => 'Haryana',
 				),
 				'JK' => array(
					'code' => 'JK',
 					'name' => 'Jammu and Kashmir',
 				),
 				'KA' => array(
					'code' => 'KA',
 					'name' => 'Karnataka',
 				),
 				'KL' => array(
					'code' => 'KL',
 					'name' => 'Kerala',
 				),
 				'LD' => array(
					'code' => 'LD',
 					'name' => 'Lakshadweep',
 				),
 				'MH' => array(
					'code' => 'MH',
 					'name' => 'Maharashtra',
 				),
 				'ML' => array(
					'code' => 'ML',
 					'name' => 'Meghalaya',
 				),
 				'MN' => array(
					'code' => 'MN',
 					'name' => 'Manipur',
 				),
 				'MP' => array(
					'code' => 'MP',
 					'name' => 'Madhya Pradesh',
 				),
 				'MZ' => array(
					'code' => 'MZ',
 					'name' => 'Mizoram',
 				),
 				'NL' => array(
					'code' => 'NL',
 					'name' => 'Nagaland',
 				),
 				'OR' => array(
					'code' => 'OR',
 					'name' => 'Orissa',
 				),
 				'PB' => array(
					'code' => 'PB',
 					'name' => 'Punjab',
 				),
 				'PY' => array(
					'code' => 'PY',
 					'name' => 'Pondicherry',
 				),
 				'RJ' => array(
					'code' => 'RJ',
 					'name' => 'Rajasthan',
 				),
 				'SK' => array(
					'code' => 'SK',
 					'name' => 'Sikkim',
 				),
 				'TN' => array(
					'code' => 'TN',
 					'name' => 'Tamil Nadu',
 				),
 				'TR' => array(
					'code' => 'TR',
 					'name' => 'Tripura',
 				),
 				'UP' => array(
					'code' => 'UP',
 					'name' => 'Uttar Pradesh',
 				),
 				'WB' => array(
					'code' => 'WB',
 					'name' => 'West Bengal',
 				),
 			),
 		),
 		'IO' => array(
			'code' => 'IO',
 			'name' => 'British Indian Ocean Territory',
 			'code3' => 'IOT',
 			'numeric' => '086',
 			'states' => array(
			),
 		),
 		'IQ' => array(
			'code' => 'IQ',
 			'name' => 'Iraq',
 			'code3' => 'IRQ',
 			'numeric' => '368',
 			'states' => array(
				'AN' => array(
					'code' => 'AN',
 					'name' => 'Al Anbār',
 				),
 				'AR' => array(
					'code' => 'AR',
 					'name' => 'Arbīl',
 				),
 				'BA' => array(
					'code' => 'BA',
 					'name' => 'Al Başrah',
 				),
 				'BB' => array(
					'code' => 'BB',
 					'name' => 'Bābil',
 				),
 				'BG' => array(
					'code' => 'BG',
 					'name' => 'Baghdād',
 				),
 				'DA' => array(
					'code' => 'DA',
 					'name' => 'Dahūk',
 				),
 				'DI' => array(
					'code' => 'DI',
 					'name' => 'Diyālá',
 				),
 				'DQ' => array(
					'code' => 'DQ',
 					'name' => 'Dhī Qār',
 				),
 				'KA' => array(
					'code' => 'KA',
 					'name' => 'Karbalā\'',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Maysān',
 				),
 				'MU' => array(
					'code' => 'MU',
 					'name' => 'Al Muthanná',
 				),
 				'NA' => array(
					'code' => 'NA',
 					'name' => 'An Najaf',
 				),
 				'NI' => array(
					'code' => 'NI',
 					'name' => 'Nīnawá',
 				),
 				'QA' => array(
					'code' => 'QA',
 					'name' => 'Al Qādisīyah',
 				),
 				'SD' => array(
					'code' => 'SD',
 					'name' => 'Şalāḩ ad Dīn',
 				),
 				'SU' => array(
					'code' => 'SU',
 					'name' => 'As Sulaymānīyah',
 				),
 				'TS' => array(
					'code' => 'TS',
 					'name' => 'At Ta\'mīm',
 				),
 				'WA' => array(
					'code' => 'WA',
 					'name' => 'Wāsiţ',
 				),
 			),
 		),
 		'IR' => array(
			'code' => 'IR',
 			'name' => 'Iran',
 			'code3' => 'IRN',
 			'numeric' => '364',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Āzarbāyjān-e-Sharqī',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Āzarbāyjān-e-Gharbī',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Ardabīl',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Eşfahān',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Īlām',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Būshehr',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Tehrān',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Chahār Maḩāll vā Bakhtīārī',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Khorāsān',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Khūzestān',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Zanjān',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Semnān',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Sīstān va Balūchestān',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Fārs',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Kermān',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Kordestān',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Kermānshāhān',
 				),
 				'18' => array(
					'code' => '18',
 					'name' => 'Kohkīlūyeh va Būyer Aḩmadī',
 				),
 				'19' => array(
					'code' => '19',
 					'name' => 'Gīlān',
 				),
 				'20' => array(
					'code' => '20',
 					'name' => 'Lorestān',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Māzandarān',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Markazī',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Hormozgān',
 				),
 				'24' => array(
					'code' => '24',
 					'name' => 'Hamadān',
 				),
 				'25' => array(
					'code' => '25',
 					'name' => 'Yazd',
 				),
 				'26' => array(
					'code' => '26',
 					'name' => 'Qom',
 				),
 			),
 		),
 		'IS' => array(
			'code' => 'IS',
 			'name' => 'Iceland',
 			'code3' => 'IS',
 			'numeric' => '352',
 			'states' => array(
				'0' => array(
					'code' => '0',
 					'name' => 'Reykjavīk',
 				),
 				'1' => array(
					'code' => '1',
 					'name' => 'Höfudborgarsvædi utan Reykjavíkur',
 				),
 				'2' => array(
					'code' => '2',
 					'name' => 'Sudurnes',
 				),
 				'3' => array(
					'code' => '3',
 					'name' => 'Vesturland',
 				),
 				'4' => array(
					'code' => '4',
 					'name' => 'Vestfirdir',
 				),
 				'5' => array(
					'code' => '5',
 					'name' => 'Nordurland vestra',
 				),
 				'6' => array(
					'code' => '6',
 					'name' => 'Nordurland eystra',
 				),
 				'7' => array(
					'code' => '7',
 					'name' => 'Austurland',
 				),
 				'8' => array(
					'code' => '8',
 					'name' => 'Sudurland',
 				),
 			),
 		),
 		'IT' => array(
			'code' => 'IT',
 			'name' => 'Italy',
 			'code3' => 'ITA',
 			'numeric' => '380',
 			'states' => array(
				'21' => array(
					'code' => '21',
 					'name' => 'Piemonte',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Valle d\'Aosta',
 				),
 				'25' => array(
					'code' => '25',
 					'name' => 'Lombardia',
 				),
 				'32' => array(
					'code' => '32',
 					'name' => 'Trentino-Alte Adige',
 				),
 				'34' => array(
					'code' => '34',
 					'name' => 'Veneto',
 				),
 				'36' => array(
					'code' => '36',
 					'name' => 'Friuli-Venezia Giulia',
 				),
 				'42' => array(
					'code' => '42',
 					'name' => 'Liguria',
 				),
 				'45' => array(
					'code' => '45',
 					'name' => 'Emilia-Romagna',
 				),
 				'52' => array(
					'code' => '52',
 					'name' => 'Toscana',
 				),
 				'55' => array(
					'code' => '55',
 					'name' => 'Umbria',
 				),
 				'57' => array(
					'code' => '57',
 					'name' => 'Marche',
 				),
 				'62' => array(
					'code' => '62',
 					'name' => 'Lazio',
 				),
 				'65' => array(
					'code' => '65',
 					'name' => 'Abruzzo',
 				),
 				'67' => array(
					'code' => '67',
 					'name' => 'Molise',
 				),
 				'72' => array(
					'code' => '72',
 					'name' => 'Campania',
 				),
 				'75' => array(
					'code' => '75',
 					'name' => 'Puglia',
 				),
 				'77' => array(
					'code' => '77',
 					'name' => 'Basilicata',
 				),
 				'78' => array(
					'code' => '78',
 					'name' => 'Calabria',
 				),
 				'82' => array(
					'code' => '82',
 					'name' => 'Sicilia',
 				),
 				'88' => array(
					'code' => '88',
 					'name' => 'Sardegna',
 				),
 				'AG' => array(
					'code' => 'AG',
 					'name' => 'Agrigento',
 				),
 				'AL' => array(
					'code' => 'AL',
 					'name' => 'Alessandria',
 				),
 				'AN' => array(
					'code' => 'AN',
 					'name' => 'Ancona',
 				),
 				'AO' => array(
					'code' => 'AO',
 					'name' => 'Aosta',
 				),
 				'AP' => array(
					'code' => 'AP',
 					'name' => 'Ascoli Piceno',
 				),
 				'AQ' => array(
					'code' => 'AQ',
 					'name' => 'L\'Aquila',
 				),
 				'AR' => array(
					'code' => 'AR',
 					'name' => 'Arezzo',
 				),
 				'AT' => array(
					'code' => 'AT',
 					'name' => 'Asti',
 				),
 				'AV' => array(
					'code' => 'AV',
 					'name' => 'Avellino',
 				),
 				'BA' => array(
					'code' => 'BA',
 					'name' => 'Bari',
 				),
 				'BG' => array(
					'code' => 'BG',
 					'name' => 'Bergamo',
 				),
 				'BI' => array(
					'code' => 'BI',
 					'name' => 'Biella',
 				),
 				'BL' => array(
					'code' => 'BL',
 					'name' => 'Belluno',
 				),
 				'BN' => array(
					'code' => 'BN',
 					'name' => 'Benevento',
 				),
 				'BO' => array(
					'code' => 'BO',
 					'name' => 'Bologna',
 				),
 				'BR' => array(
					'code' => 'BR',
 					'name' => 'Brindisi',
 				),
 				'BS' => array(
					'code' => 'BS',
 					'name' => 'Brescia',
 				),
 				'BZ' => array(
					'code' => 'BZ',
 					'name' => 'Bolzano',
 				),
 				'CA' => array(
					'code' => 'CA',
 					'name' => 'Cagliari',
 				),
 				'CB' => array(
					'code' => 'CB',
 					'name' => 'Campobasso',
 				),
 				'CE' => array(
					'code' => 'CE',
 					'name' => 'Caserta',
 				),
 				'CH' => array(
					'code' => 'CH',
 					'name' => 'Chieti',
 				),
 				'CL' => array(
					'code' => 'CL',
 					'name' => 'Caltanissetta',
 				),
 				'CN' => array(
					'code' => 'CN',
 					'name' => 'Cuneo',
 				),
 				'CO' => array(
					'code' => 'CO',
 					'name' => 'Como',
 				),
 				'CR' => array(
					'code' => 'CR',
 					'name' => 'Cremona',
 				),
 				'CS' => array(
					'code' => 'CS',
 					'name' => 'Cosenza',
 				),
 				'CT' => array(
					'code' => 'CT',
 					'name' => 'Catania',
 				),
 				'CZ' => array(
					'code' => 'CZ',
 					'name' => 'Catanzaro',
 				),
 				'EN' => array(
					'code' => 'EN',
 					'name' => 'Enna',
 				),
 				'FE' => array(
					'code' => 'FE',
 					'name' => 'Ferrara',
 				),
 				'FG' => array(
					'code' => 'FG',
 					'name' => 'Foggia',
 				),
 				'FI' => array(
					'code' => 'FI',
 					'name' => 'Firenze',
 				),
 				'FO' => array(
					'code' => 'FO',
 					'name' => 'Forlì',
 				),
 				'FR' => array(
					'code' => 'FR',
 					'name' => 'Frosinone',
 				),
 				'GE' => array(
					'code' => 'GE',
 					'name' => 'Genova',
 				),
 				'GO' => array(
					'code' => 'GO',
 					'name' => 'Gorizia',
 				),
 				'GR' => array(
					'code' => 'GR',
 					'name' => 'Grosseto',
 				),
 				'IM' => array(
					'code' => 'IM',
 					'name' => 'Imperia',
 				),
 				'IS' => array(
					'code' => 'IS',
 					'name' => 'Isernia',
 				),
 				'KR' => array(
					'code' => 'KR',
 					'name' => 'Crotone',
 				),
 				'LC' => array(
					'code' => 'LC',
 					'name' => 'Lecco',
 				),
 				'LE' => array(
					'code' => 'LE',
 					'name' => 'Lecce',
 				),
 				'LI' => array(
					'code' => 'LI',
 					'name' => 'Livorno',
 				),
 				'LO' => array(
					'code' => 'LO',
 					'name' => 'Lodi',
 				),
 				'LT' => array(
					'code' => 'LT',
 					'name' => 'Latina',
 				),
 				'LU' => array(
					'code' => 'LU',
 					'name' => 'Lucca',
 				),
 				'MC' => array(
					'code' => 'MC',
 					'name' => 'Macerata',
 				),
 				'ME' => array(
					'code' => 'ME',
 					'name' => 'Mesaina',
 				),
 				'MI' => array(
					'code' => 'MI',
 					'name' => 'Milano',
 				),
 				'MN' => array(
					'code' => 'MN',
 					'name' => 'Mantova',
 				),
 				'MO' => array(
					'code' => 'MO',
 					'name' => 'Modena',
 				),
 				'MS' => array(
					'code' => 'MS',
 					'name' => 'Massa',
 				),
 				'MT' => array(
					'code' => 'MT',
 					'name' => 'Matera',
 				),
 				'NA' => array(
					'code' => 'NA',
 					'name' => 'Napoli',
 				),
 				'NO' => array(
					'code' => 'NO',
 					'name' => 'Novara',
 				),
 				'NU' => array(
					'code' => 'NU',
 					'name' => 'Nuoro',
 				),
 				'OR' => array(
					'code' => 'OR',
 					'name' => 'Oristano',
 				),
 				'PA' => array(
					'code' => 'PA',
 					'name' => 'Palermo',
 				),
 				'PC' => array(
					'code' => 'PC',
 					'name' => 'Piacenza',
 				),
 				'PD' => array(
					'code' => 'PD',
 					'name' => 'Padova',
 				),
 				'PE' => array(
					'code' => 'PE',
 					'name' => 'Pescara',
 				),
 				'PG' => array(
					'code' => 'PG',
 					'name' => 'Perugia',
 				),
 				'PI' => array(
					'code' => 'PI',
 					'name' => 'Pisa',
 				),
 				'PN' => array(
					'code' => 'PN',
 					'name' => 'Pordenone',
 				),
 				'PO' => array(
					'code' => 'PO',
 					'name' => 'Prato',
 				),
 				'PR' => array(
					'code' => 'PR',
 					'name' => 'Parma',
 				),
 				'PS' => array(
					'code' => 'PS',
 					'name' => 'Pesaro',
 				),
 				'PT' => array(
					'code' => 'PT',
 					'name' => 'Pistoia',
 				),
 				'PV' => array(
					'code' => 'PV',
 					'name' => 'Pavia',
 				),
 				'PZ' => array(
					'code' => 'PZ',
 					'name' => 'Potenza',
 				),
 				'RA' => array(
					'code' => 'RA',
 					'name' => 'Ravenna',
 				),
 				'RC' => array(
					'code' => 'RC',
 					'name' => 'Reggio Calabria',
 				),
 				'RE' => array(
					'code' => 'RE',
 					'name' => 'Reggio Emilia',
 				),
 				'RG' => array(
					'code' => 'RG',
 					'name' => 'Ragusa',
 				),
 				'RI' => array(
					'code' => 'RI',
 					'name' => 'Rieti',
 				),
 				'RM' => array(
					'code' => 'RM',
 					'name' => 'Roma',
 				),
 				'RN' => array(
					'code' => 'RN',
 					'name' => 'Rimini',
 				),
 				'RO' => array(
					'code' => 'RO',
 					'name' => 'Rovigo',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Salerno',
 				),
 				'SI' => array(
					'code' => 'SI',
 					'name' => 'Siena',
 				),
 				'SO' => array(
					'code' => 'SO',
 					'name' => 'Sondrio',
 				),
 				'SP' => array(
					'code' => 'SP',
 					'name' => 'La Spezia',
 				),
 				'SR' => array(
					'code' => 'SR',
 					'name' => 'Siracusa',
 				),
 				'SS' => array(
					'code' => 'SS',
 					'name' => 'Sassari',
 				),
 				'SV' => array(
					'code' => 'SV',
 					'name' => 'Savona',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Taranto',
 				),
 				'TE' => array(
					'code' => 'TE',
 					'name' => 'Teramo',
 				),
 				'TN' => array(
					'code' => 'TN',
 					'name' => 'Trento',
 				),
 				'TO' => array(
					'code' => 'TO',
 					'name' => 'Torino',
 				),
 				'TP' => array(
					'code' => 'TP',
 					'name' => 'Trapani',
 				),
 				'TR' => array(
					'code' => 'TR',
 					'name' => 'Terni',
 				),
 				'TS' => array(
					'code' => 'TS',
 					'name' => 'Trieste',
 				),
 				'TV' => array(
					'code' => 'TV',
 					'name' => 'Treviso',
 				),
 				'UD' => array(
					'code' => 'UD',
 					'name' => 'Udine',
 				),
 				'VA' => array(
					'code' => 'VA',
 					'name' => 'Varese',
 				),
 				'VB' => array(
					'code' => 'VB',
 					'name' => 'Verbano-Cusio-Ossola',
 				),
 				'VC' => array(
					'code' => 'VC',
 					'name' => 'Vercelli',
 				),
 				'VE' => array(
					'code' => 'VE',
 					'name' => 'Venezia',
 				),
 				'VI' => array(
					'code' => 'VI',
 					'name' => 'Vicenza',
 				),
 				'VR' => array(
					'code' => 'VR',
 					'name' => 'Verona',
 				),
 				'VT' => array(
					'code' => 'VT',
 					'name' => 'Viterbo',
 				),
 				'W' => array(
					'code' => 'W',
 					'name' => 'Vibo Valentia',
 				),
 			),
 		),
 		'JE' => array(
			'code' => 'JE',
 			'name' => 'Jersey',
 			'code3' => 'JEY',
 			'numeric' => '832',
 			'states' => array(
			),
 		),
 		'JM' => array(
			'code' => 'JM',
 			'name' => 'Jamaica',
 			'code3' => 'JAM',
 			'numeric' => '388',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Kingston',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Saint Andrew',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Saint Thomas',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Portland',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Saint Mary',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Saint Ann',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Trelawny',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Saint James',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Hanover',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Westmoreland',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Saint Elizabeth',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Manchester',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Clarendon',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Saint Catherine',
 				),
 			),
 		),
 		'JO' => array(
			'code' => 'JO',
 			'name' => 'Jordan',
 			'code3' => 'JOR',
 			'numeric' => '400',
 			'states' => array(
				'AJ' => array(
					'code' => 'AJ',
 					'name' => '‘Ajlūn',
 				),
 				'AM' => array(
					'code' => 'AM',
 					'name' => '‘Ammān',
 				),
 				'AQ' => array(
					'code' => 'AQ',
 					'name' => 'Al \'Aqaba',
 				),
 				'AT' => array(
					'code' => 'AT',
 					'name' => 'Aţ Ţafīlah',
 				),
 				'AZ' => array(
					'code' => 'AZ',
 					'name' => 'Az Zarqā\'',
 				),
 				'BA' => array(
					'code' => 'BA',
 					'name' => 'Al Balqā\'',
 				),
 				'IR' => array(
					'code' => 'IR',
 					'name' => 'Irbid',
 				),
 				'JA' => array(
					'code' => 'JA',
 					'name' => 'Jarash',
 				),
 				'KA' => array(
					'code' => 'KA',
 					'name' => 'Al Karak',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Al Mafraq',
 				),
 				'MD' => array(
					'code' => 'MD',
 					'name' => 'Mādaba',
 				),
 				'MN' => array(
					'code' => 'MN',
 					'name' => 'Ma‘ān',
 				),
 			),
 		),
 		'JP' => array(
			'code' => 'JP',
 			'name' => 'Japan',
 			'code3' => 'JPN',
 			'numeric' => '392',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Hokkaidô [Hokkaido]',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Aomori',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Iwate',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Miyagi',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Akita',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Yamagata',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Hukusima [Fukushima]',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Ibaraki',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Totigi [Tochigi]',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Gunma',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Saitama',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Tiba [Chiba]',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Tôkyô [Tokyo]',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Kanagawa',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Niigata',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Toyama',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Isikawa [Ishikawa]',
 				),
 				'18' => array(
					'code' => '18',
 					'name' => 'Hukui [Fukui]',
 				),
 				'19' => array(
					'code' => '19',
 					'name' => 'Yamanasi [Yamanashi]',
 				),
 				'20' => array(
					'code' => '20',
 					'name' => 'Nagano',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Gihu [Gifu]',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Sizuoka [Shizuoka]',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Aiti [Aichi]',
 				),
 				'24' => array(
					'code' => '24',
 					'name' => 'Mie',
 				),
 				'25' => array(
					'code' => '25',
 					'name' => 'Siga [Shiga]',
 				),
 				'26' => array(
					'code' => '26',
 					'name' => 'Kyôto [Kyoto]',
 				),
 				'27' => array(
					'code' => '27',
 					'name' => 'Ôsaka [Osaka]',
 				),
 				'28' => array(
					'code' => '28',
 					'name' => 'Hyôgo [Hyogo]',
 				),
 				'29' => array(
					'code' => '29',
 					'name' => 'Nara',
 				),
 				'30' => array(
					'code' => '30',
 					'name' => 'Wakayama',
 				),
 				'31' => array(
					'code' => '31',
 					'name' => 'Tottori',
 				),
 				'33' => array(
					'code' => '33',
 					'name' => 'Okayama',
 				),
 				'34' => array(
					'code' => '34',
 					'name' => 'Hirosima [Hiroshima]',
 				),
 				'35' => array(
					'code' => '35',
 					'name' => 'Yamaguti [Yamaguchi]',
 				),
 				'36' => array(
					'code' => '36',
 					'name' => 'Tokusima [Tokushima]',
 				),
 				'37' => array(
					'code' => '37',
 					'name' => 'Kagawa',
 				),
 				'38' => array(
					'code' => '38',
 					'name' => 'Ehime',
 				),
 				'39' => array(
					'code' => '39',
 					'name' => 'Kôti [Kochi]',
 				),
 				'40' => array(
					'code' => '40',
 					'name' => 'Hukuoka [Fukuoka]',
 				),
 				'41' => array(
					'code' => '41',
 					'name' => 'Saga',
 				),
 				'42' => array(
					'code' => '42',
 					'name' => 'Nagasaki',
 				),
 				'43' => array(
					'code' => '43',
 					'name' => 'Kumamoto',
 				),
 				'44' => array(
					'code' => '44',
 					'name' => 'Ôita [Oita]',
 				),
 				'45' => array(
					'code' => '45',
 					'name' => 'Miyazaki',
 				),
 				'46' => array(
					'code' => '46',
 					'name' => 'Kagosima [Kagoshima]',
 				),
 				'47' => array(
					'code' => '47',
 					'name' => 'Okinawa',
 				),
 			),
 		),
 		'KE' => array(
			'code' => 'KE',
 			'name' => 'Kenya',
 			'code3' => 'KEN',
 			'numeric' => '404',
 			'states' => array(
				'110' => array(
					'code' => '110',
 					'name' => 'Nairobi Municipality',
 				),
 				'200' => array(
					'code' => '200',
 					'name' => 'Central',
 				),
 				'300' => array(
					'code' => '300',
 					'name' => 'Coast',
 				),
 				'400' => array(
					'code' => '400',
 					'name' => 'Eastern',
 				),
 				'500' => array(
					'code' => '500',
 					'name' => 'North-Eastern',
 				),
 				'600' => array(
					'code' => '600',
 					'name' => 'Nyanza',
 				),
 				'700' => array(
					'code' => '700',
 					'name' => 'Rift Valley',
 				),
 				'900' => array(
					'code' => '900',
 					'name' => 'Western',
 				),
 			),
 		),
 		'KG' => array(
			'code' => 'KG',
 			'name' => 'Kyrgyzstan',
 			'code3' => 'KGZ',
 			'numeric' => '417',
 			'states' => array(
				'C' => array(
					'code' => 'C',
 					'name' => 'Chu',
 				),
 				'J' => array(
					'code' => 'J',
 					'name' => 'Jalal-Abad',
 				),
 				'N' => array(
					'code' => 'N',
 					'name' => 'Naryn',
 				),
 				'O' => array(
					'code' => 'O',
 					'name' => 'Osh',
 				),
 				'T' => array(
					'code' => 'T',
 					'name' => 'Talas',
 				),
 				'Y' => array(
					'code' => 'Y',
 					'name' => 'Ysyk-Köl',
 				),
 			),
 		),
 		'KH' => array(
			'code' => 'KH',
 			'name' => 'Cambodia',
 			'code3' => 'KHM',
 			'numeric' => '116',
 			'states' => array(
				'1' => array(
					'code' => '1',
 					'name' => 'Banteay Mean Chey [Bântéay Méanchey]',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Kracheh [Krâchéh]',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Mond01 Kiri [Môndól Kiri]',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Phnom Penh [Phnum Pénh]',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Preah Vihear [Preăh Vihéar]',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Prey Veaeng [Prey Vêng]',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Pousaat [Poŭthĭsăt]',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Rotanak Kiri [Rôtânôkiri]',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Siem Reab [Siĕmréab]',
 				),
 				'18' => array(
					'code' => '18',
 					'name' => 'Krong Preah Sihanouk [Krŏng Preăh Sihanouk]',
 				),
 				'19' => array(
					'code' => '19',
 					'name' => 'Stueng Traeng [Stœng Trêng]',
 				),
 				'2' => array(
					'code' => '2',
 					'name' => 'Baat Dambang [Bătdâmbâng]',
 				),
 				'20' => array(
					'code' => '20',
 					'name' => 'Svaay Rieng [Svay Riĕng]',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Taakaev [Takêv]',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Otdar Mean Chey [Ŏtdâr Méanchey]',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Krong Kaeb [Krŏng Kêb]',
 				),
 				'3' => array(
					'code' => '3',
 					'name' => 'Kampong Chaam [Kâmpóng Cham]',
 				),
 				'4' => array(
					'code' => '4',
 					'name' => 'Kampong Chhnang [Kâmpóng Chhnăng]',
 				),
 				'5' => array(
					'code' => '5',
 					'name' => 'Kampong Spueu [Kâmpóng Spœ]',
 				),
 				'6' => array(
					'code' => '6',
 					'name' => 'Kampong Thum [Kâmpóng Thum]',
 				),
 				'7' => array(
					'code' => '7',
 					'name' => 'Kampot [Kâmpôt]',
 				),
 				'8' => array(
					'code' => '8',
 					'name' => 'Kandaal [Kândal]',
 				),
 			),
 		),
 		'KI' => array(
			'code' => 'KI',
 			'name' => 'Kiribati',
 			'code3' => 'KIR',
 			'numeric' => '296',
 			'states' => array(
				'G' => array(
					'code' => 'G',
 					'name' => 'Gilbert Islands',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'Line Islands',
 				),
 				'P' => array(
					'code' => 'P',
 					'name' => 'Phoenix Islands',
 				),
 			),
 		),
 		'KM' => array(
			'code' => 'KM',
 			'name' => 'Comoros',
 			'code3' => 'COM',
 			'numeric' => '174',
 			'states' => array(
				'A' => array(
					'code' => 'A',
 					'name' => 'Anjouan',
 				),
 				'G' => array(
					'code' => 'G',
 					'name' => 'Grande Comore',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'Mohéli',
 				),
 			),
 		),
 		'KN' => array(
			'code' => 'KN',
 			'name' => 'Saint Kitts & Nevis',
 			'code3' => 'KNA',
 			'numeric' => '659',
 			'states' => array(
			),
 		),
 		'KP' => array(
			'code' => 'KP',
 			'name' => 'Korea',
 			'code3' => 'PRK',
 			'numeric' => '408',
 			'states' => array(
				'CHA' => array(
					'code' => 'CHA',
 					'name' => 'Chagang-do',
 				),
 				'HAB' => array(
					'code' => 'HAB',
 					'name' => 'Hamgyongbuk-do',
 				),
 				'HAN' => array(
					'code' => 'HAN',
 					'name' => 'Hamgyongnam-do',
 				),
 				'HWB' => array(
					'code' => 'HWB',
 					'name' => 'Hwanghaebuk-do',
 				),
 				'HWN' => array(
					'code' => 'HWN',
 					'name' => 'Hwanghaenam-do',
 				),
 				'KAE' => array(
					'code' => 'KAE',
 					'name' => 'Kaesong-si',
 				),
 				'KAN' => array(
					'code' => 'KAN',
 					'name' => 'Kangwon-do',
 				),
 				'NAM' => array(
					'code' => 'NAM',
 					'name' => 'Nampo-si',
 				),
 				'PYB' => array(
					'code' => 'PYB',
 					'name' => 'Pyonganbuk-do',
 				),
 				'PYN' => array(
					'code' => 'PYN',
 					'name' => 'Pyongannam-do',
 				),
 				'PYO' => array(
					'code' => 'PYO',
 					'name' => 'Pyongyang-si',
 				),
 				'YAN' => array(
					'code' => 'YAN',
 					'name' => 'Yanggang-do',
 				),
 			),
 		),
 		'KR' => array(
			'code' => 'KR',
 			'name' => 'Korea',
 			'code3' => 'KOR',
 			'numeric' => '410',
 			'states' => array(
				'11' => array(
					'code' => '11',
 					'name' => 'Seoul Teugbyeolsi [ Seoul-T’ŭkpyŏlshi]',
 				),
 				'26' => array(
					'code' => '26',
 					'name' => 'Busan Gwang\'yeogsi [Pusan-Kwangyŏkshi]',
 				),
 				'27' => array(
					'code' => '27',
 					'name' => 'Daegu Gwang\'yeogsi [Taegu-Kwangyŏkshi)',
 				),
 				'28' => array(
					'code' => '28',
 					'name' => 'Incheon Gwang\'yeogsi [Inchŏn-Kwangyŏkshi]',
 				),
 				'29' => array(
					'code' => '29',
 					'name' => 'Gwangju Gwang\'yeogsi [Kwangju-Kwangyŏkshi]',
 				),
 				'30' => array(
					'code' => '30',
 					'name' => 'Daejeon Gwang\'yeogsi [Taejŏn-Kwangyŏkshi]',
 				),
 				'31' => array(
					'code' => '31',
 					'name' => 'Ulsan Gwang\'yeogsi [Ulsan-Kwangyŏkshi]',
 				),
 				'41' => array(
					'code' => '41',
 					'name' => 'Gyeonggido [Kyŏnggi-do]',
 				),
 				'42' => array(
					'code' => '42',
 					'name' => 'Gang\'weondo [Kang-won-do]',
 				),
 				'43' => array(
					'code' => '43',
 					'name' => 'Chungcheongbugdo [Ch\'ungch\'ŏngbuk-do]',
 				),
 				'44' => array(
					'code' => '44',
 					'name' => 'Chungcheongnamdo [Ch\'ungch\'ŏngnam-do]',
 				),
 				'45' => array(
					'code' => '45',
 					'name' => 'Jeonrabugdo [Chŏllabuk-do)',
 				),
 				'46' => array(
					'code' => '46',
 					'name' => 'Jeonranamdo [Chŏllanam-do]',
 				),
 				'47' => array(
					'code' => '47',
 					'name' => 'Gyeongsangbugdo [Kyŏngsangbuk-do]',
 				),
 				'48' => array(
					'code' => '48',
 					'name' => 'Gyeongsangnamdo [Kyŏngsangnam-do]',
 				),
 				'49' => array(
					'code' => '49',
 					'name' => 'Jejudo [Cheju-do]',
 				),
 			),
 		),
 		'KW' => array(
			'code' => 'KW',
 			'name' => 'Kuwait',
 			'code3' => 'KWT',
 			'numeric' => '414',
 			'states' => array(
				'AH' => array(
					'code' => 'AH',
 					'name' => 'Al Aḩmadi',
 				),
 				'FA' => array(
					'code' => 'FA',
 					'name' => 'Al Farwānīyah',
 				),
 				'HA' => array(
					'code' => 'HA',
 					'name' => 'Ḩawallī',
 				),
 				'JA' => array(
					'code' => 'JA',
 					'name' => 'Al Jahrah',
 				),
 				'KU' => array(
					'code' => 'KU',
 					'name' => 'Al Kuwayt',
 				),
 			),
 		),
 		'KY' => array(
			'code' => 'KY',
 			'name' => 'Cayman Islands',
 			'code3' => 'CYM',
 			'numeric' => '136',
 			'states' => array(
			),
 		),
 		'KZ' => array(
			'code' => 'KZ',
 			'name' => 'Kazakhstan',
 			'code3' => 'KAZ',
 			'numeric' => '398',
 			'states' => array(
				'AKM' => array(
					'code' => 'AKM',
 					'name' => 'Aqmola oblysy',
 				),
 				'AKT' => array(
					'code' => 'AKT',
 					'name' => 'Aqtöbe oblysy',
 				),
 				'ALA' => array(
					'code' => 'ALA',
 					'name' => 'Almaty',
 				),
 				'ALM' => array(
					'code' => 'ALM',
 					'name' => 'Almaty oblysy',
 				),
 				'ATY' => array(
					'code' => 'ATY',
 					'name' => 'Atyraü oblysy',
 				),
 				'BAY' => array(
					'code' => 'BAY',
 					'name' => 'Bayqonyr',
 				),
 				'KAR' => array(
					'code' => 'KAR',
 					'name' => 'Qaraghandy oblysy',
 				),
 				'KUS' => array(
					'code' => 'KUS',
 					'name' => 'Qostanay oblysy',
 				),
 				'KZY' => array(
					'code' => 'KZY',
 					'name' => 'Qyzylorda oblysy',
 				),
 				'MAN' => array(
					'code' => 'MAN',
 					'name' => 'Mangghystaū oblysy',
 				),
 				'PAV' => array(
					'code' => 'PAV',
 					'name' => 'Pavlodar oblysy',
 				),
 				'SEV' => array(
					'code' => 'SEV',
 					'name' => 'Soltüstik Kazakstan oblysy',
 				),
 				'VOS' => array(
					'code' => 'VOS',
 					'name' => 'Shyghys Kazakstan oblysy',
 				),
 				'YUZ' => array(
					'code' => 'YUZ',
 					'name' => 'Ongtüstik Kazakstan oblysy',
 				),
 				'ZAP' => array(
					'code' => 'ZAP',
 					'name' => 'Batys Kazakstan oblysy',
 				),
 				'ZHA' => array(
					'code' => 'ZHA',
 					'name' => 'Zhambyl oblysy',
 				),
 			),
 		),
 		'LA' => array(
			'code' => 'LA',
 			'name' => 'Laos',
 			'code3' => 'LAO',
 			'numeric' => '418',
 			'states' => array(
				'AT' => array(
					'code' => 'AT',
 					'name' => 'Attapu [Attopeu]',
 				),
 				'BK' => array(
					'code' => 'BK',
 					'name' => 'Bokèo',
 				),
 				'BL' => array(
					'code' => 'BL',
 					'name' => 'Bolikhamxai [Borikhane]',
 				),
 				'CH' => array(
					'code' => 'CH',
 					'name' => 'Champasak [Champassak]',
 				),
 				'HO' => array(
					'code' => 'HO',
 					'name' => 'Houaphan',
 				),
 				'KH' => array(
					'code' => 'KH',
 					'name' => 'Khammouan',
 				),
 				'LM' => array(
					'code' => 'LM',
 					'name' => 'Louang Namtha',
 				),
 				'LP' => array(
					'code' => 'LP',
 					'name' => 'Louangphabang [Louang Prabang]',
 				),
 				'OU' => array(
					'code' => 'OU',
 					'name' => 'Oudômxai [Oudomsai]',
 				),
 				'PH' => array(
					'code' => 'PH',
 					'name' => 'Phôngsali [Phong Saly]',
 				),
 				'SL' => array(
					'code' => 'SL',
 					'name' => 'Salavan [Saravane]',
 				),
 				'SV' => array(
					'code' => 'SV',
 					'name' => 'Savannakhét',
 				),
 				'VI' => array(
					'code' => 'VI',
 					'name' => 'Vientiane',
 				),
 				'VT' => array(
					'code' => 'VT',
 					'name' => 'Vientiane',
 				),
 				'XA' => array(
					'code' => 'XA',
 					'name' => 'Xaignabouli [Sayaboury]',
 				),
 				'XE' => array(
					'code' => 'XE',
 					'name' => 'Xékong [Sékong]',
 				),
 				'XI' => array(
					'code' => 'XI',
 					'name' => 'Xiangkhoang [Xieng Khouang]',
 				),
 			),
 		),
 		'LB' => array(
			'code' => 'LB',
 			'name' => 'Lebanon',
 			'code3' => 'LBN',
 			'numeric' => '422',
 			'states' => array(
				'AS' => array(
					'code' => 'AS',
 					'name' => 'Loubnâne ech Chemâli',
 				),
 				'BA' => array(
					'code' => 'BA',
 					'name' => 'Beiroût',
 				),
 				'BI' => array(
					'code' => 'BI',
 					'name' => 'El Béqaa',
 				),
 				'JA' => array(
					'code' => 'JA',
 					'name' => 'Loubnâne ej Jnoûbi',
 				),
 				'JL' => array(
					'code' => 'JL',
 					'name' => 'Jabal Loubnâne',
 				),
 				'NA' => array(
					'code' => 'NA',
 					'name' => 'Nabatîyé (An Nabaţīyah',
 				),
 			),
 		),
 		'LC' => array(
			'code' => 'LC',
 			'name' => 'Saint Lucia',
 			'code3' => 'LCA',
 			'numeric' => '662',
 			'states' => array(
			),
 		),
 		'LI' => array(
			'code' => 'LI',
 			'name' => 'Liechtenstein',
 			'code3' => 'LIE',
 			'numeric' => '438',
 			'states' => array(
			),
 		),
 		'LK' => array(
			'code' => 'LK',
 			'name' => 'Sri Lanka',
 			'code3' => 'LKA',
 			'numeric' => '144',
 			'states' => array(
				'1' => array(
					'code' => '1',
 					'name' => 'Basnahira Palata',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Colombo',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Gampaha',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Kalutara',
 				),
 				'2' => array(
					'code' => '2',
 					'name' => 'Madhyama Palata',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Kandy',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Matale',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Nuwara Eliya',
 				),
 				'3' => array(
					'code' => '3',
 					'name' => 'Dakunu Palata',
 				),
 				'31' => array(
					'code' => '31',
 					'name' => 'Galle',
 				),
 				'32' => array(
					'code' => '32',
 					'name' => 'Matara',
 				),
 				'33' => array(
					'code' => '33',
 					'name' => 'Hambantota',
 				),
 				'4' => array(
					'code' => '4',
 					'name' => 'Uturu Palata',
 				),
 				'41' => array(
					'code' => '41',
 					'name' => 'Jaffna',
 				),
 				'42' => array(
					'code' => '42',
 					'name' => 'Kilinochchi',
 				),
 				'43' => array(
					'code' => '43',
 					'name' => 'Mannar',
 				),
 				'44' => array(
					'code' => '44',
 					'name' => 'Vavuniya',
 				),
 				'45' => array(
					'code' => '45',
 					'name' => 'Mullaittivu',
 				),
 				'5' => array(
					'code' => '5',
 					'name' => 'Negenahira Palata',
 				),
 				'51' => array(
					'code' => '51',
 					'name' => 'Batticaloa',
 				),
 				'52' => array(
					'code' => '52',
 					'name' => 'Arnpara',
 				),
 				'53' => array(
					'code' => '53',
 					'name' => 'Trincomalee',
 				),
 				'6' => array(
					'code' => '6',
 					'name' => 'Wayamba Palata',
 				),
 				'61' => array(
					'code' => '61',
 					'name' => 'Kurunegala',
 				),
 				'62' => array(
					'code' => '62',
 					'name' => 'Puttalam',
 				),
 				'7' => array(
					'code' => '7',
 					'name' => 'Uturumeda Palata',
 				),
 				'71' => array(
					'code' => '71',
 					'name' => 'Anuradhapura',
 				),
 				'72' => array(
					'code' => '72',
 					'name' => 'Polonnaruwa',
 				),
 				'8' => array(
					'code' => '8',
 					'name' => 'Uva Palata',
 				),
 				'81' => array(
					'code' => '81',
 					'name' => 'Badulla',
 				),
 				'82' => array(
					'code' => '82',
 					'name' => 'Monaragala',
 				),
 				'9' => array(
					'code' => '9',
 					'name' => 'Sabaragamuwa Palata',
 				),
 				'91' => array(
					'code' => '91',
 					'name' => 'Ratnapura',
 				),
 				'92' => array(
					'code' => '92',
 					'name' => 'Kegalla',
 				),
 			),
 		),
 		'LR' => array(
			'code' => 'LR',
 			'name' => 'Liberia',
 			'code3' => 'LBR',
 			'numeric' => '430',
 			'states' => array(
				'BG' => array(
					'code' => 'BG',
 					'name' => 'Bong',
 				),
 				'BM' => array(
					'code' => 'BM',
 					'name' => 'Bomi',
 				),
 				'CM' => array(
					'code' => 'CM',
 					'name' => 'Grand Cape Mount',
 				),
 				'GB' => array(
					'code' => 'GB',
 					'name' => 'Grand Bassa',
 				),
 				'GG' => array(
					'code' => 'GG',
 					'name' => 'Grand Gedeh',
 				),
 				'GK' => array(
					'code' => 'GK',
 					'name' => 'Grand Kru',
 				),
 				'LO' => array(
					'code' => 'LO',
 					'name' => 'Lofa',
 				),
 				'MG' => array(
					'code' => 'MG',
 					'name' => 'Margibi',
 				),
 				'MO' => array(
					'code' => 'MO',
 					'name' => 'Montserrado',
 				),
 				'MY' => array(
					'code' => 'MY',
 					'name' => 'Maryland',
 				),
 				'NI' => array(
					'code' => 'NI',
 					'name' => 'Nimba',
 				),
 				'RI' => array(
					'code' => 'RI',
 					'name' => 'Rivercess',
 				),
 				'SI' => array(
					'code' => 'SI',
 					'name' => 'Sinoe',
 				),
 			),
 		),
 		'LS' => array(
			'code' => 'LS',
 			'name' => 'Lesotho',
 			'code3' => 'LSO',
 			'numeric' => '426',
 			'states' => array(
				'A' => array(
					'code' => 'A',
 					'name' => 'Maseru',
 				),
 				'B' => array(
					'code' => 'B',
 					'name' => 'Butha-Buthe',
 				),
 				'C' => array(
					'code' => 'C',
 					'name' => 'Leribe',
 				),
 				'D' => array(
					'code' => 'D',
 					'name' => 'Berea',
 				),
 				'E' => array(
					'code' => 'E',
 					'name' => 'Mafeteng',
 				),
 				'F' => array(
					'code' => 'F',
 					'name' => 'Mohale\'s Hoek',
 				),
 				'G' => array(
					'code' => 'G',
 					'name' => 'Quthing',
 				),
 				'H' => array(
					'code' => 'H',
 					'name' => 'Qacha\'s Nek',
 				),
 				'J' => array(
					'code' => 'J',
 					'name' => 'Mokhotlong',
 				),
 				'K' => array(
					'code' => 'K',
 					'name' => 'Thaba-Tseka',
 				),
 			),
 		),
 		'LT' => array(
			'code' => 'LT',
 			'name' => 'Lithuania',
 			'code3' => 'LTU',
 			'numeric' => '440',
 			'states' => array(
				'AL' => array(
					'code' => 'AL',
 					'name' => 'Alytaus Apskritis',
 				),
 				'KL' => array(
					'code' => 'KL',
 					'name' => 'Klaipėdos Apskritis',
 				),
 				'KU' => array(
					'code' => 'KU',
 					'name' => 'Kauno Apskritis',
 				),
 				'MR' => array(
					'code' => 'MR',
 					'name' => 'Marijampolės Apskritis',
 				),
 				'PN' => array(
					'code' => 'PN',
 					'name' => 'Panevėžio Apskritis',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Šiauliu Apskritis',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Tauragės Apskritis',
 				),
 				'TE' => array(
					'code' => 'TE',
 					'name' => 'Telšiu Apskritis',
 				),
 				'UT' => array(
					'code' => 'UT',
 					'name' => 'Utenos Apskritis',
 				),
 				'VL' => array(
					'code' => 'VL',
 					'name' => 'Vilniaus Apskritis',
 				),
 			),
 		),
 		'LU' => array(
			'code' => 'LU',
 			'name' => 'Luxembourg',
 			'code3' => 'LUX',
 			'numeric' => '442',
 			'states' => array(
				'D' => array(
					'code' => 'D',
 					'name' => 'Diekirch',
 				),
 				'G' => array(
					'code' => 'G',
 					'name' => 'Grevenmacher',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'Luxembourg',
 				),
 			),
 		),
 		'LV' => array(
			'code' => 'LV',
 			'name' => 'Latvia',
 			'code3' => 'LVA',
 			'numeric' => '428',
 			'states' => array(
				'AI' => array(
					'code' => 'AI',
 					'name' => 'Aizkraukles Aprinkis',
 				),
 				'AL' => array(
					'code' => 'AL',
 					'name' => 'Alūksnes Aprinkis',
 				),
 				'BL' => array(
					'code' => 'BL',
 					'name' => 'Balvu Aprinkis',
 				),
 				'BU' => array(
					'code' => 'BU',
 					'name' => 'Bauskas Aprinkis',
 				),
 				'CE' => array(
					'code' => 'CE',
 					'name' => 'Cēsu Aprinkis',
 				),
 				'DA' => array(
					'code' => 'DA',
 					'name' => 'Daugavpils Aprinkis',
 				),
 				'DGV' => array(
					'code' => 'DGV',
 					'name' => 'Daugavpils',
 				),
 				'DO' => array(
					'code' => 'DO',
 					'name' => 'Dobeles Aprinkis',
 				),
 				'GU' => array(
					'code' => 'GU',
 					'name' => 'Gulbenes Aprinkis',
 				),
 				'JEL' => array(
					'code' => 'JEL',
 					'name' => 'Jelgava',
 				),
 				'JK' => array(
					'code' => 'JK',
 					'name' => 'Jēkabpils Aprinkis',
 				),
 				'JL' => array(
					'code' => 'JL',
 					'name' => 'Jelgavas Aprinkis',
 				),
 				'JUR' => array(
					'code' => 'JUR',
 					'name' => 'Jūrmala',
 				),
 				'KR' => array(
					'code' => 'KR',
 					'name' => 'Krāslavas Aprinkis',
 				),
 				'KU' => array(
					'code' => 'KU',
 					'name' => 'Kuldīgas Aprinkis',
 				),
 				'LE' => array(
					'code' => 'LE',
 					'name' => 'Liepājas Aprinkis',
 				),
 				'LM' => array(
					'code' => 'LM',
 					'name' => 'Limbažu Aprinkis',
 				),
 				'LPX' => array(
					'code' => 'LPX',
 					'name' => 'Liepāja',
 				),
 				'LU' => array(
					'code' => 'LU',
 					'name' => 'Ludzas Aprinkis',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Madonas Aprinkis',
 				),
 				'OG' => array(
					'code' => 'OG',
 					'name' => 'Ogres Aprinkis',
 				),
 				'PR' => array(
					'code' => 'PR',
 					'name' => 'Preilu Aprinkis',
 				),
 				'RE' => array(
					'code' => 'RE',
 					'name' => 'Rēzeknes Aprinkis',
 				),
 				'REZ' => array(
					'code' => 'REZ',
 					'name' => 'Rēzekne',
 				),
 				'RI' => array(
					'code' => 'RI',
 					'name' => 'Rīgas Aprinkis',
 				),
 				'RIX' => array(
					'code' => 'RIX',
 					'name' => 'Rīga',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Saldus Aprinkis',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Talsu Aprinkis',
 				),
 				'TU' => array(
					'code' => 'TU',
 					'name' => 'Tukuma Aprinkis',
 				),
 				'VE' => array(
					'code' => 'VE',
 					'name' => 'Ventspils Aprinkis',
 				),
 				'VEN' => array(
					'code' => 'VEN',
 					'name' => 'Ventspils',
 				),
 				'VK' => array(
					'code' => 'VK',
 					'name' => 'Valkas Aprinkis',
 				),
 				'VM' => array(
					'code' => 'VM',
 					'name' => 'Valmieras Aprinkis',
 				),
 			),
 		),
 		'LY' => array(
			'code' => 'LY',
 			'name' => 'Libya',
 			'code3' => 'LBY',
 			'numeric' => '434',
 			'states' => array(
				'BA' => array(
					'code' => 'BA',
 					'name' => 'Banghāzī',
 				),
 				'BU' => array(
					'code' => 'BU',
 					'name' => 'Al Buţnān',
 				),
 				'FA' => array(
					'code' => 'FA',
 					'name' => 'Fazzān',
 				),
 				'JA' => array(
					'code' => 'JA',
 					'name' => 'Al Jabal al Akhḑar',
 				),
 				'JG' => array(
					'code' => 'JG',
 					'name' => 'Al Jabal al Gharbī',
 				),
 				'Ju' => array(
					'code' => 'Ju',
 					'name' => 'Al Jufrah',
 				),
 				'MI' => array(
					'code' => 'MI',
 					'name' => 'Mişrātah',
 				),
 				'NA' => array(
					'code' => 'NA',
 					'name' => 'Naggaza',
 				),
 				'SF' => array(
					'code' => 'SF',
 					'name' => 'Sawfajjin',
 				),
 				'TB' => array(
					'code' => 'TB',
 					'name' => 'Ţarābulus',
 				),
 				'WA' => array(
					'code' => 'WA',
 					'name' => 'Al Wāḩah',
 				),
 				'Wu' => array(
					'code' => 'Wu',
 					'name' => 'Al Wusţá',
 				),
 				'ZA' => array(
					'code' => 'ZA',
 					'name' => 'Az Zāwiyah',
 				),
 			),
 		),
 		'MA' => array(
			'code' => 'MA',
 			'name' => 'Morocco',
 			'code3' => 'MAR',
 			'numeric' => '504',
 			'states' => array(
				'AGD' => array(
					'code' => 'AGD',
 					'name' => 'Agadir',
 				),
 				'ASZ' => array(
					'code' => 'ASZ',
 					'name' => 'Assa-Zag',
 				),
 				'AZI' => array(
					'code' => 'AZI',
 					'name' => 'Azilal',
 				),
 				'BAH' => array(
					'code' => 'BAH',
 					'name' => 'Aït Baha',
 				),
 				'BEM' => array(
					'code' => 'BEM',
 					'name' => 'Beni Mellal',
 				),
 				'BER' => array(
					'code' => 'BER',
 					'name' => 'Berkane',
 				),
 				'BES' => array(
					'code' => 'BES',
 					'name' => 'Ben Slimane',
 				),
 				'BOD' => array(
					'code' => 'BOD',
 					'name' => 'Boujdour',
 				),
 				'BOM' => array(
					'code' => 'BOM',
 					'name' => 'Boulemane',
 				),
 				'CAS' => array(
					'code' => 'CAS',
 					'name' => 'Casablanca [Dar el Beïda]',
 				),
 				'CE' => array(
					'code' => 'CE',
 					'name' => 'Centre',
 				),
 				'CHE' => array(
					'code' => 'CHE',
 					'name' => 'Chefchaouene',
 				),
 				'CHI' => array(
					'code' => 'CHI',
 					'name' => 'Chichaoua',
 				),
 				'CN' => array(
					'code' => 'CN',
 					'name' => 'Centre-Nord',
 				),
 				'CS' => array(
					'code' => 'CS',
 					'name' => 'Centre-Sud',
 				),
 				'ERR' => array(
					'code' => 'ERR',
 					'name' => 'Errachidia',
 				),
 				'ES' => array(
					'code' => 'ES',
 					'name' => 'Est',
 				),
 				'ESI' => array(
					'code' => 'ESI',
 					'name' => 'Essaouira',
 				),
 				'ESM' => array(
					'code' => 'ESM',
 					'name' => 'Es Semara',
 				),
 				'FES' => array(
					'code' => 'FES',
 					'name' => 'Fès',
 				),
 				'FIG' => array(
					'code' => 'FIG',
 					'name' => 'Figuig',
 				),
 				'GUE' => array(
					'code' => 'GUE',
 					'name' => 'Guelmim',
 				),
 				'HAJ' => array(
					'code' => 'HAJ',
 					'name' => 'El Hajeb',
 				),
 				'HAO' => array(
					'code' => 'HAO',
 					'name' => 'Al Haouz',
 				),
 				'HOC' => array(
					'code' => 'HOC',
 					'name' => 'Al Hoceïma',
 				),
 				'IFR' => array(
					'code' => 'IFR',
 					'name' => 'Ifrane',
 				),
 				'IRA' => array(
					'code' => 'IRA',
 					'name' => 'Jrada',
 				),
 				'JDI' => array(
					'code' => 'JDI',
 					'name' => 'El Jadida',
 				),
 				'KEN' => array(
					'code' => 'KEN',
 					'name' => 'Kénitra',
 				),
 				'KES' => array(
					'code' => 'KES',
 					'name' => 'Kelaat Sraghna',
 				),
 				'KHE' => array(
					'code' => 'KHE',
 					'name' => 'Khemisset',
 				),
 				'KHN' => array(
					'code' => 'KHN',
 					'name' => 'Khenifra',
 				),
 				'KHO' => array(
					'code' => 'KHO',
 					'name' => 'Khouribga',
 				),
 				'LAA' => array(
					'code' => 'LAA',
 					'name' => 'Laayoune',
 				),
 				'LAR' => array(
					'code' => 'LAR',
 					'name' => 'Larache',
 				),
 				'MAR' => array(
					'code' => 'MAR',
 					'name' => 'Marrakech',
 				),
 				'MEK' => array(
					'code' => 'MEK',
 					'name' => 'Meknès',
 				),
 				'MEL' => array(
					'code' => 'MEL',
 					'name' => 'Aït Melloul',
 				),
 				'NAD' => array(
					'code' => 'NAD',
 					'name' => 'Nador',
 				),
 				'NO' => array(
					'code' => 'NO',
 					'name' => 'Nord-Ouest',
 				),
 				'OUA' => array(
					'code' => 'OUA',
 					'name' => 'Ouarzazate',
 				),
 				'OUD' => array(
					'code' => 'OUD',
 					'name' => 'Oued ed Dahab',
 				),
 				'OUJ' => array(
					'code' => 'OUJ',
 					'name' => 'Oujda',
 				),
 				'RBA' => array(
					'code' => 'RBA',
 					'name' => 'Rabat-Salé',
 				),
 				'SAF' => array(
					'code' => 'SAF',
 					'name' => 'Safi',
 				),
 				'SEF' => array(
					'code' => 'SEF',
 					'name' => 'Sefrou',
 				),
 				'SET' => array(
					'code' => 'SET',
 					'name' => 'Settat',
 				),
 				'SIK' => array(
					'code' => 'SIK',
 					'name' => 'Sidi Kacem',
 				),
 				'SU' => array(
					'code' => 'SU',
 					'name' => 'Sud',
 				),
 				'TAO' => array(
					'code' => 'TAO',
 					'name' => 'Taounate',
 				),
 				'TAR' => array(
					'code' => 'TAR',
 					'name' => 'Taroudannt',
 				),
 				'TAT' => array(
					'code' => 'TAT',
 					'name' => 'Tata',
 				),
 				'TAZ' => array(
					'code' => 'TAZ',
 					'name' => 'Taza',
 				),
 				'TET' => array(
					'code' => 'TET',
 					'name' => 'Tétouan',
 				),
 				'TIZ' => array(
					'code' => 'TIZ',
 					'name' => 'Tiznit',
 				),
 				'TNG' => array(
					'code' => 'TNG',
 					'name' => 'Tanger',
 				),
 				'TNT' => array(
					'code' => 'TNT',
 					'name' => 'Tan-Tan',
 				),
 				'TS' => array(
					'code' => 'TS',
 					'name' => 'Tensift',
 				),
 			),
 		),
 		'MC' => array(
			'code' => 'MC',
 			'name' => 'Monaco',
 			'code3' => 'MCO',
 			'numeric' => '492',
 			'states' => array(
			),
 		),
 		'MD' => array(
			'code' => 'MD',
 			'name' => 'Moldova',
 			'code3' => 'MDA',
 			'numeric' => '498',
 			'states' => array(
				'ANE' => array(
					'code' => 'ANE',
 					'name' => 'Anenii Noi',
 				),
 				'BAL' => array(
					'code' => 'BAL',
 					'name' => 'Bălţi',
 				),
 				'BAS' => array(
					'code' => 'BAS',
 					'name' => 'Basarabeasca',
 				),
 				'BRI' => array(
					'code' => 'BRI',
 					'name' => 'Brinceni',
 				),
 				'CAH' => array(
					'code' => 'CAH',
 					'name' => 'Cahul',
 				),
 				'CAI' => array(
					'code' => 'CAI',
 					'name' => 'Căinari',
 				),
 				'CAL' => array(
					'code' => 'CAL',
 					'name' => 'Călăraşi',
 				),
 				'CAM' => array(
					'code' => 'CAM',
 					'name' => 'Camenca',
 				),
 				'CAN' => array(
					'code' => 'CAN',
 					'name' => 'Cantemir',
 				),
 				'CAS' => array(
					'code' => 'CAS',
 					'name' => 'Căuşeni',
 				),
 				'CHI' => array(
					'code' => 'CHI',
 					'name' => 'Chişinău',
 				),
 				'CHL' => array(
					'code' => 'CHL',
 					'name' => 'Cahul',
 				),
 				'CIA' => array(
					'code' => 'CIA',
 					'name' => 'Ciadîr-Lunga',
 				),
 				'CIM' => array(
					'code' => 'CIM',
 					'name' => 'Cimişlia',
 				),
 				'COM' => array(
					'code' => 'COM',
 					'name' => 'Comrat',
 				),
 				'CRI' => array(
					'code' => 'CRI',
 					'name' => 'Criuleni',
 				),
 				'DBI' => array(
					'code' => 'DBI',
 					'name' => 'Dubăsari',
 				),
 				'DON' => array(
					'code' => 'DON',
 					'name' => 'Donduşeni',
 				),
 				'DRO' => array(
					'code' => 'DRO',
 					'name' => 'Drochia',
 				),
 				'DUB' => array(
					'code' => 'DUB',
 					'name' => 'Dubăsari',
 				),
 				'EDI' => array(
					'code' => 'EDI',
 					'name' => 'Edineţ',
 				),
 				'FAL' => array(
					'code' => 'FAL',
 					'name' => 'Făleşti',
 				),
 				'FLO' => array(
					'code' => 'FLO',
 					'name' => 'Floreşti',
 				),
 				'GLO' => array(
					'code' => 'GLO',
 					'name' => 'Glodeni',
 				),
 				'GRI' => array(
					'code' => 'GRI',
 					'name' => 'Grigoriopol',
 				),
 				'HIN' => array(
					'code' => 'HIN',
 					'name' => 'Hînceşti',
 				),
 				'IAL' => array(
					'code' => 'IAL',
 					'name' => 'Ialoveni',
 				),
 				'LEO' => array(
					'code' => 'LEO',
 					'name' => 'Leova',
 				),
 				'NIS' => array(
					'code' => 'NIS',
 					'name' => 'Nisporeni',
 				),
 				'OCN' => array(
					'code' => 'OCN',
 					'name' => 'Ocniţa',
 				),
 				'OHI' => array(
					'code' => 'OHI',
 					'name' => 'Orhei',
 				),
 				'ORH' => array(
					'code' => 'ORH',
 					'name' => 'Orhei',
 				),
 				'REZ' => array(
					'code' => 'REZ',
 					'name' => 'Rezina',
 				),
 				'RIB' => array(
					'code' => 'RIB',
 					'name' => 'Rîbniţa',
 				),
 				'RIS' => array(
					'code' => 'RIS',
 					'name' => 'Rîşcani',
 				),
 				'RIT' => array(
					'code' => 'RIT',
 					'name' => 'Rîbniţa',
 				),
 				'SIN' => array(
					'code' => 'SIN',
 					'name' => 'Sîngerei',
 				),
 				'SLO' => array(
					'code' => 'SLO',
 					'name' => 'Slobozia',
 				),
 				'SOA' => array(
					'code' => 'SOA',
 					'name' => 'Soroca',
 				),
 				'SOC' => array(
					'code' => 'SOC',
 					'name' => 'Soroca',
 				),
 				'SOL' => array(
					'code' => 'SOL',
 					'name' => 'Şoldăneşti',
 				),
 				'STE' => array(
					'code' => 'STE',
 					'name' => 'Ştefan Vodă',
 				),
 				'STR' => array(
					'code' => 'STR',
 					'name' => 'Străşeni',
 				),
 				'TAR' => array(
					'code' => 'TAR',
 					'name' => 'Taraclia',
 				),
 				'TEL' => array(
					'code' => 'TEL',
 					'name' => 'Teleneşti',
 				),
 				'TIG' => array(
					'code' => 'TIG',
 					'name' => 'Tighina',
 				),
 				'TIR' => array(
					'code' => 'TIR',
 					'name' => 'Tiraspol',
 				),
 				'UGI' => array(
					'code' => 'UGI',
 					'name' => 'Ungheni',
 				),
 				'UNG' => array(
					'code' => 'UNG',
 					'name' => 'Ungheni',
 				),
 				'VUL' => array(
					'code' => 'VUL',
 					'name' => 'Vulcăneşti',
 				),
 			),
 		),
 		'MF' => array(
			'code' => 'MF',
 			'name' => 'Saint Martin',
 			'code3' => 'MAF',
 			'numeric' => '663',
 			'states' => array(
			),
 		),
 		'MG' => array(
			'code' => 'MG',
 			'name' => 'Madagascar',
 			'code3' => 'MDG',
 			'numeric' => '450',
 			'states' => array(
				'A' => array(
					'code' => 'A',
 					'name' => 'Toamasina',
 				),
 				'D' => array(
					'code' => 'D',
 					'name' => 'Antsiranana',
 				),
 				'F' => array(
					'code' => 'F',
 					'name' => 'Fianarantsoa',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'Mahajanga',
 				),
 				'T' => array(
					'code' => 'T',
 					'name' => 'Antananarivo',
 				),
 				'U' => array(
					'code' => 'U',
 					'name' => 'Toliara',
 				),
 			),
 		),
 		'MH' => array(
			'code' => 'MH',
 			'name' => 'Marshall Islands',
 			'code3' => 'MHL',
 			'numeric' => '584',
 			'states' => array(
				'ALK' => array(
					'code' => 'ALK',
 					'name' => 'Ailuk',
 				),
 				'ALL' => array(
					'code' => 'ALL',
 					'name' => 'Ailinglapalap',
 				),
 				'ARN' => array(
					'code' => 'ARN',
 					'name' => 'Arno',
 				),
 				'AUR' => array(
					'code' => 'AUR',
 					'name' => 'Aur',
 				),
 				'EBO' => array(
					'code' => 'EBO',
 					'name' => 'Ebon',
 				),
 				'ENI' => array(
					'code' => 'ENI',
 					'name' => 'Eniwetok',
 				),
 				'JAL' => array(
					'code' => 'JAL',
 					'name' => 'Jaluit',
 				),
 				'KIL' => array(
					'code' => 'KIL',
 					'name' => 'Kili',
 				),
 				'KWA' => array(
					'code' => 'KWA',
 					'name' => 'Kwajalein',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'Ralik chain',
 				),
 				'LAE' => array(
					'code' => 'LAE',
 					'name' => 'Lae',
 				),
 				'LIB' => array(
					'code' => 'LIB',
 					'name' => 'Lib',
 				),
 				'LIK' => array(
					'code' => 'LIK',
 					'name' => 'Likiep',
 				),
 				'MAJ' => array(
					'code' => 'MAJ',
 					'name' => 'Majuro',
 				),
 				'MAL' => array(
					'code' => 'MAL',
 					'name' => 'Maloelap',
 				),
 				'MEJ' => array(
					'code' => 'MEJ',
 					'name' => 'Mejit',
 				),
 				'MIL' => array(
					'code' => 'MIL',
 					'name' => 'Mili',
 				),
 				'NMK' => array(
					'code' => 'NMK',
 					'name' => 'Namorik',
 				),
 				'NMU' => array(
					'code' => 'NMU',
 					'name' => 'Namu',
 				),
 				'RON' => array(
					'code' => 'RON',
 					'name' => 'Rongelap',
 				),
 				'T' => array(
					'code' => 'T',
 					'name' => 'Ratak chain',
 				),
 				'UJA' => array(
					'code' => 'UJA',
 					'name' => 'Ujae',
 				),
 				'UJL' => array(
					'code' => 'UJL',
 					'name' => 'Ujelang',
 				),
 				'UTI' => array(
					'code' => 'UTI',
 					'name' => 'Utirik',
 				),
 				'WTH' => array(
					'code' => 'WTH',
 					'name' => 'Wotho',
 				),
 				'WTJ' => array(
					'code' => 'WTJ',
 					'name' => 'Wotje',
 				),
 			),
 		),
 		'MK' => array(
			'code' => 'MK',
 			'name' => 'Macedonia',
 			'code3' => 'MKD',
 			'numeric' => '807',
 			'states' => array(
			),
 		),
 		'ML' => array(
			'code' => 'ML',
 			'name' => 'Mali',
 			'code3' => 'MLI',
 			'numeric' => '466',
 			'states' => array(
				'1' => array(
					'code' => '1',
 					'name' => 'Kayes',
 				),
 				'2' => array(
					'code' => '2',
 					'name' => 'Koulikoro',
 				),
 				'3' => array(
					'code' => '3',
 					'name' => 'Sikasso',
 				),
 				'4' => array(
					'code' => '4',
 					'name' => 'Ségou',
 				),
 				'5' => array(
					'code' => '5',
 					'name' => 'Mopti',
 				),
 				'6' => array(
					'code' => '6',
 					'name' => 'Tombouctou',
 				),
 				'7' => array(
					'code' => '7',
 					'name' => 'Gao',
 				),
 				'8' => array(
					'code' => '8',
 					'name' => 'Kidal',
 				),
 				'BKO' => array(
					'code' => 'BKO',
 					'name' => 'Bamako',
 				),
 			),
 		),
 		'MM' => array(
			'code' => 'MM',
 			'name' => 'Myanmar',
 			'code3' => 'MMR',
 			'numeric' => '104',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Sagaing',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Bago',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Magway',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Mandalay',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Tanintharyi',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Yangon',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Ayeyarwady',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Kachin',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Kayah',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Kayin',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Chin',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Mon',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Rakhine',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Shan',
 				),
 			),
 		),
 		'MN' => array(
			'code' => 'MN',
 			'name' => 'Mongolia',
 			'code3' => 'MNG',
 			'numeric' => '496',
 			'states' => array(
				'035' => array(
					'code' => '035',
 					'name' => 'Orhon',
 				),
 				'037' => array(
					'code' => '037',
 					'name' => 'Darhan uul',
 				),
 				'039' => array(
					'code' => '039',
 					'name' => 'Hentiy',
 				),
 				'041' => array(
					'code' => '041',
 					'name' => 'Hövsgöl',
 				),
 				'043' => array(
					'code' => '043',
 					'name' => 'Hovd',
 				),
 				'046' => array(
					'code' => '046',
 					'name' => 'Uvs',
 				),
 				'047' => array(
					'code' => '047',
 					'name' => 'Töv',
 				),
 				'049' => array(
					'code' => '049',
 					'name' => 'Selenge',
 				),
 				'051' => array(
					'code' => '051',
 					'name' => 'Sühbaatar',
 				),
 				'053' => array(
					'code' => '053',
 					'name' => 'Ömnögovĭ',
 				),
 				'055' => array(
					'code' => '055',
 					'name' => 'Övörhangay',
 				),
 				'057' => array(
					'code' => '057',
 					'name' => 'Dzavhan',
 				),
 				'059' => array(
					'code' => '059',
 					'name' => 'Dundgovĭ',
 				),
 				'061' => array(
					'code' => '061',
 					'name' => 'Dornod',
 				),
 				'063' => array(
					'code' => '063',
 					'name' => 'Dornogovĭ',
 				),
 				'064' => array(
					'code' => '064',
 					'name' => 'Govĭ-Sümber',
 				),
 				'065' => array(
					'code' => '065',
 					'name' => 'Govĭ-Altay',
 				),
 				'067' => array(
					'code' => '067',
 					'name' => 'Bulgan',
 				),
 				'069' => array(
					'code' => '069',
 					'name' => 'Bayanhongor',
 				),
 				'071' => array(
					'code' => '071',
 					'name' => 'Bayan-Ölgiy',
 				),
 				'073' => array(
					'code' => '073',
 					'name' => 'Arhangay',
 				),
 				'1' => array(
					'code' => '1',
 					'name' => 'Ulaanbaatar',
 				),
 			),
 		),
 		'MO' => array(
			'code' => 'MO',
 			'name' => 'Macau',
 			'code3' => 'MAC',
 			'numeric' => '446',
 			'states' => array(
			),
 		),
 		'MP' => array(
			'code' => 'MP',
 			'name' => 'Northern Mariana Islands',
 			'code3' => 'MNP',
 			'numeric' => '580',
 			'states' => array(
			),
 		),
 		'MQ' => array(
			'code' => 'MQ',
 			'name' => 'Martinique',
 			'code3' => 'MTQ',
 			'numeric' => '474',
 			'states' => array(
			),
 		),
 		'MR' => array(
			'code' => 'MR',
 			'name' => 'Mauritania',
 			'code3' => 'MRT',
 			'numeric' => '478',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Hodh ech Chargui',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Hodh el Gharbi',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Assaba',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Gorgol',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Brakna',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Trarza',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Adrar',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Dakhlet Nouādhibou',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Tagant',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Guidimaka',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Tiris Zemmour',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Inchiri',
 				),
 				'NKC' => array(
					'code' => 'NKC',
 					'name' => 'Nouakchott',
 				),
 			),
 		),
 		'MS' => array(
			'code' => 'MS',
 			'name' => 'Montserrat',
 			'code3' => 'MSR',
 			'numeric' => '500',
 			'states' => array(
			),
 		),
 		'MT' => array(
			'code' => 'MT',
 			'name' => 'Malta',
 			'code3' => 'MLT',
 			'numeric' => '470',
 			'states' => array(
			),
 		),
 		'MU' => array(
			'code' => 'MU',
 			'name' => 'Mauritius',
 			'code3' => 'MUS',
 			'numeric' => '480',
 			'states' => array(
				'AG' => array(
					'code' => 'AG',
 					'name' => 'Agalega Islands',
 				),
 				'BL' => array(
					'code' => 'BL',
 					'name' => 'Black River',
 				),
 				'BR' => array(
					'code' => 'BR',
 					'name' => 'Beau Bassin-Rose Hill',
 				),
 				'CC' => array(
					'code' => 'CC',
 					'name' => 'Cargados Carajos Shoals [Saint Brandon Islands]',
 				),
 				'CU' => array(
					'code' => 'CU',
 					'name' => 'Curepipe',
 				),
 				'FL' => array(
					'code' => 'FL',
 					'name' => 'Flacq',
 				),
 				'GP' => array(
					'code' => 'GP',
 					'name' => 'Grand Port',
 				),
 				'MO' => array(
					'code' => 'MO',
 					'name' => 'Moka',
 				),
 				'PA' => array(
					'code' => 'PA',
 					'name' => 'Pamplemousses',
 				),
 				'PL' => array(
					'code' => 'PL',
 					'name' => 'Port Louis',
 				),
 				'PW' => array(
					'code' => 'PW',
 					'name' => 'Plaines Wilhems',
 				),
 				'QB' => array(
					'code' => 'QB',
 					'name' => 'Quatre Bornes',
 				),
 				'RO' => array(
					'code' => 'RO',
 					'name' => 'Rodrigues Island',
 				),
 				'RR' => array(
					'code' => 'RR',
 					'name' => 'Rivière du Rempart',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Savanne',
 				),
 				'VP' => array(
					'code' => 'VP',
 					'name' => 'Vacoas-Phoenix',
 				),
 			),
 		),
 		'MV' => array(
			'code' => 'MV',
 			'name' => 'Maldives',
 			'code3' => 'MDV',
 			'numeric' => '462',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Seenu',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Alif',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Lhaviyani',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Vaavu',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Laamu',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Haa Alif',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Thaa',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Meemu',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Raa',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Faafu',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Dhaalu',
 				),
 				'20' => array(
					'code' => '20',
 					'name' => 'Baa',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Haa Dhaalu',
 				),
 				'24' => array(
					'code' => '24',
 					'name' => 'Shaviyani',
 				),
 				'25' => array(
					'code' => '25',
 					'name' => 'Noonu',
 				),
 				'26' => array(
					'code' => '26',
 					'name' => 'Kaafu',
 				),
 				'27' => array(
					'code' => '27',
 					'name' => 'Gaaf Alif',
 				),
 				'28' => array(
					'code' => '28',
 					'name' => 'Gaafu Dhaalu',
 				),
 				'29' => array(
					'code' => '29',
 					'name' => 'Gnaviyani',
 				),
 				'MLE' => array(
					'code' => 'MLE',
 					'name' => 'Male',
 				),
 			),
 		),
 		'MW' => array(
			'code' => 'MW',
 			'name' => 'Malawi',
 			'code3' => 'MWI',
 			'numeric' => '454',
 			'states' => array(
				'BL' => array(
					'code' => 'BL',
 					'name' => 'Blantyre',
 				),
 				'C' => array(
					'code' => 'C',
 					'name' => 'Central',
 				),
 				'CK' => array(
					'code' => 'CK',
 					'name' => 'Chikwawa',
 				),
 				'CR' => array(
					'code' => 'CR',
 					'name' => 'Chiradzulu',
 				),
 				'CT' => array(
					'code' => 'CT',
 					'name' => 'Chitipa',
 				),
 				'DE' => array(
					'code' => 'DE',
 					'name' => 'Dedza',
 				),
 				'DO' => array(
					'code' => 'DO',
 					'name' => 'Dowa',
 				),
 				'KR' => array(
					'code' => 'KR',
 					'name' => 'Karonga',
 				),
 				'KS' => array(
					'code' => 'KS',
 					'name' => 'Kasungu',
 				),
 				'LI' => array(
					'code' => 'LI',
 					'name' => 'Lilongwe',
 				),
 				'MC' => array(
					'code' => 'MC',
 					'name' => 'Mchinji',
 				),
 				'MG' => array(
					'code' => 'MG',
 					'name' => 'Mangochi',
 				),
 				'MH' => array(
					'code' => 'MH',
 					'name' => 'Machinga',
 				),
 				'MU' => array(
					'code' => 'MU',
 					'name' => 'Mulanje',
 				),
 				'MW' => array(
					'code' => 'MW',
 					'name' => 'Mwanza',
 				),
 				'MZ' => array(
					'code' => 'MZ',
 					'name' => 'Mzimba',
 				),
 				'N' => array(
					'code' => 'N',
 					'name' => 'Northern',
 				),
 				'NB' => array(
					'code' => 'NB',
 					'name' => 'Nkhata Bay',
 				),
 				'NI' => array(
					'code' => 'NI',
 					'name' => 'Ntchisi',
 				),
 				'NK' => array(
					'code' => 'NK',
 					'name' => 'Nkhotakota',
 				),
 				'NS' => array(
					'code' => 'NS',
 					'name' => 'Nsanje',
 				),
 				'NU' => array(
					'code' => 'NU',
 					'name' => 'Ntcheu',
 				),
 				'RU' => array(
					'code' => 'RU',
 					'name' => 'Rumphi',
 				),
 				'S' => array(
					'code' => 'S',
 					'name' => 'Southern',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Salima',
 				),
 				'TH' => array(
					'code' => 'TH',
 					'name' => 'Thyolo',
 				),
 				'ZO' => array(
					'code' => 'ZO',
 					'name' => 'Zomba',
 				),
 			),
 		),
 		'MX' => array(
			'code' => 'MX',
 			'name' => 'Mexico',
 			'code3' => 'MEX',
 			'numeric' => '484',
 			'states' => array(
				'AGU' => array(
					'code' => 'AGU',
 					'name' => 'Aguascalientes',
 				),
 				'BCN' => array(
					'code' => 'BCN',
 					'name' => 'Baja California',
 				),
 				'BCS' => array(
					'code' => 'BCS',
 					'name' => 'Baja California Sur',
 				),
 				'CAM' => array(
					'code' => 'CAM',
 					'name' => 'Campeche',
 				),
 				'CHH' => array(
					'code' => 'CHH',
 					'name' => 'Chihuahua',
 				),
 				'CHP' => array(
					'code' => 'CHP',
 					'name' => 'Chiapas',
 				),
 				'COA' => array(
					'code' => 'COA',
 					'name' => 'Coahuila',
 				),
 				'COL' => array(
					'code' => 'COL',
 					'name' => 'Colima',
 				),
 				'DIF' => array(
					'code' => 'DIF',
 					'name' => 'Distrito Federal',
 				),
 				'DUR' => array(
					'code' => 'DUR',
 					'name' => 'Durango',
 				),
 				'GRO' => array(
					'code' => 'GRO',
 					'name' => 'Guerrero',
 				),
 				'GUA' => array(
					'code' => 'GUA',
 					'name' => 'Guanajuato',
 				),
 				'HID' => array(
					'code' => 'HID',
 					'name' => 'Hidalgo',
 				),
 				'JAL' => array(
					'code' => 'JAL',
 					'name' => 'Jalisco',
 				),
 				'MEX' => array(
					'code' => 'MEX',
 					'name' => 'México',
 				),
 				'MIC' => array(
					'code' => 'MIC',
 					'name' => 'Michoacán',
 				),
 				'MOR' => array(
					'code' => 'MOR',
 					'name' => 'Morelos',
 				),
 				'NAY' => array(
					'code' => 'NAY',
 					'name' => 'Nayarit',
 				),
 				'NLE' => array(
					'code' => 'NLE',
 					'name' => 'Nuevo León',
 				),
 				'OAX' => array(
					'code' => 'OAX',
 					'name' => 'Oaxaca',
 				),
 				'PUE' => array(
					'code' => 'PUE',
 					'name' => 'Puebla',
 				),
 				'QUE' => array(
					'code' => 'QUE',
 					'name' => 'Queretaro',
 				),
 				'ROO' => array(
					'code' => 'ROO',
 					'name' => 'Quintana Roo',
 				),
 				'SIN' => array(
					'code' => 'SIN',
 					'name' => 'Sinaloa',
 				),
 				'SLP' => array(
					'code' => 'SLP',
 					'name' => 'San Luis Potosí',
 				),
 				'SON' => array(
					'code' => 'SON',
 					'name' => 'Sonora',
 				),
 				'TAB' => array(
					'code' => 'TAB',
 					'name' => 'Tabasco',
 				),
 				'TAM' => array(
					'code' => 'TAM',
 					'name' => 'Tamaulipas',
 				),
 				'TLA' => array(
					'code' => 'TLA',
 					'name' => 'Tlaxcala',
 				),
 				'VER' => array(
					'code' => 'VER',
 					'name' => 'Veracruz',
 				),
 				'YUC' => array(
					'code' => 'YUC',
 					'name' => 'Yucatán',
 				),
 				'ZAC' => array(
					'code' => 'ZAC',
 					'name' => 'Zacatecas',
 				),
 			),
 		),
 		'MY' => array(
			'code' => 'MY',
 			'name' => 'Malaysia',
 			'code3' => 'MYS',
 			'numeric' => '458',
 			'states' => array(
				'A' => array(
					'code' => 'A',
 					'name' => 'Perak',
 				),
 				'B' => array(
					'code' => 'B',
 					'name' => 'Selangor',
 				),
 				'C' => array(
					'code' => 'C',
 					'name' => 'Pahang',
 				),
 				'D' => array(
					'code' => 'D',
 					'name' => 'Kelantan',
 				),
 				'J' => array(
					'code' => 'J',
 					'name' => 'Johor',
 				),
 				'K' => array(
					'code' => 'K',
 					'name' => 'Kedah',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'Wilayah Persekutuan Labuan',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'Melaka',
 				),
 				'N' => array(
					'code' => 'N',
 					'name' => 'Negeri Sembilan',
 				),
 				'P' => array(
					'code' => 'P',
 					'name' => 'Pulau Pinang',
 				),
 				'R' => array(
					'code' => 'R',
 					'name' => 'Perlis',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Sabah',
 				),
 				'SK' => array(
					'code' => 'SK',
 					'name' => 'Sarawak',
 				),
 				'T' => array(
					'code' => 'T',
 					'name' => 'Terengganu',
 				),
 				'W' => array(
					'code' => 'W',
 					'name' => 'Wilayah Persekutuan Kuala Lumpur',
 				),
 			),
 		),
 		'MZ' => array(
			'code' => 'MZ',
 			'name' => 'Mozambique',
 			'code3' => 'MOZ',
 			'numeric' => '508',
 			'states' => array(
				'A' => array(
					'code' => 'A',
 					'name' => 'Niassa',
 				),
 				'B' => array(
					'code' => 'B',
 					'name' => 'Manica',
 				),
 				'G' => array(
					'code' => 'G',
 					'name' => 'Gaza',
 				),
 				'I' => array(
					'code' => 'I',
 					'name' => 'Inhambane',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'Maputo',
 				),
 				'MPM' => array(
					'code' => 'MPM',
 					'name' => 'Maputo',
 				),
 				'N' => array(
					'code' => 'N',
 					'name' => 'Nampula',
 				),
 				'P' => array(
					'code' => 'P',
 					'name' => 'Cabo Delgado',
 				),
 				'Q' => array(
					'code' => 'Q',
 					'name' => 'Zambézia',
 				),
 				'S' => array(
					'code' => 'S',
 					'name' => 'Sofala',
 				),
 				'T' => array(
					'code' => 'T',
 					'name' => 'Tete',
 				),
 			),
 		),
 		'NA' => array(
			'code' => 'NA',
 			'name' => 'Namibia',
 			'code3' => 'NAM',
 			'numeric' => '516',
 			'states' => array(
				'CA' => array(
					'code' => 'CA',
 					'name' => 'Caprivi',
 				),
 				'ER' => array(
					'code' => 'ER',
 					'name' => 'Erongo',
 				),
 				'HA' => array(
					'code' => 'HA',
 					'name' => 'Hardap',
 				),
 				'KA' => array(
					'code' => 'KA',
 					'name' => 'Karas',
 				),
 				'KH' => array(
					'code' => 'KH',
 					'name' => 'Khomas',
 				),
 				'KU' => array(
					'code' => 'KU',
 					'name' => 'Kunene',
 				),
 				'OD' => array(
					'code' => 'OD',
 					'name' => 'Otjozondjupa',
 				),
 				'OH' => array(
					'code' => 'OH',
 					'name' => 'Omaheke',
 				),
 				'OK' => array(
					'code' => 'OK',
 					'name' => 'Okavango',
 				),
 				'ON' => array(
					'code' => 'ON',
 					'name' => 'Oshana',
 				),
 				'OS' => array(
					'code' => 'OS',
 					'name' => 'Omusati',
 				),
 				'OT' => array(
					'code' => 'OT',
 					'name' => 'Oshikoto',
 				),
 				'OW' => array(
					'code' => 'OW',
 					'name' => 'Ohangwena',
 				),
 			),
 		),
 		'NC' => array(
			'code' => 'NC',
 			'name' => 'New Caledonia',
 			'code3' => 'NCL',
 			'numeric' => '540',
 			'states' => array(
			),
 		),
 		'NE' => array(
			'code' => 'NE',
 			'name' => 'Niger',
 			'code3' => 'NER',
 			'numeric' => '562',
 			'states' => array(
				'1' => array(
					'code' => '1',
 					'name' => 'Agadez',
 				),
 				'2' => array(
					'code' => '2',
 					'name' => 'Diffa',
 				),
 				'3' => array(
					'code' => '3',
 					'name' => 'Dosso',
 				),
 				'4' => array(
					'code' => '4',
 					'name' => 'Maradi',
 				),
 				'5' => array(
					'code' => '5',
 					'name' => 'Tahoua',
 				),
 				'6' => array(
					'code' => '6',
 					'name' => 'Tillaberi',
 				),
 				'7' => array(
					'code' => '7',
 					'name' => 'Zinder',
 				),
 				'8' => array(
					'code' => '8',
 					'name' => 'Niamey',
 				),
 			),
 		),
 		'NF' => array(
			'code' => 'NF',
 			'name' => 'Norfolk Island',
 			'code3' => 'NFK',
 			'numeric' => '574',
 			'states' => array(
			),
 		),
 		'NG' => array(
			'code' => 'NG',
 			'name' => 'Nigeria',
 			'code3' => 'NGA',
 			'numeric' => '566',
 			'states' => array(
				'AB' => array(
					'code' => 'AB',
 					'name' => 'Abia',
 				),
 				'AD' => array(
					'code' => 'AD',
 					'name' => 'Adamawa',
 				),
 				'AK' => array(
					'code' => 'AK',
 					'name' => 'Akwa Ibom',
 				),
 				'AN' => array(
					'code' => 'AN',
 					'name' => 'Anambra',
 				),
 				'BA' => array(
					'code' => 'BA',
 					'name' => 'Bauchi',
 				),
 				'BE' => array(
					'code' => 'BE',
 					'name' => 'Benue',
 				),
 				'BO' => array(
					'code' => 'BO',
 					'name' => 'Borno',
 				),
 				'CR' => array(
					'code' => 'CR',
 					'name' => 'Cross River',
 				),
 				'DE' => array(
					'code' => 'DE',
 					'name' => 'Delta',
 				),
 				'ED' => array(
					'code' => 'ED',
 					'name' => 'Edo',
 				),
 				'EN' => array(
					'code' => 'EN',
 					'name' => 'Enugu',
 				),
 				'FC' => array(
					'code' => 'FC',
 					'name' => 'Abuja Capital Territory',
 				),
 				'IM' => array(
					'code' => 'IM',
 					'name' => 'Imo',
 				),
 				'JI' => array(
					'code' => 'JI',
 					'name' => 'Jigawa',
 				),
 				'KD' => array(
					'code' => 'KD',
 					'name' => 'Kaduna',
 				),
 				'KE' => array(
					'code' => 'KE',
 					'name' => 'Kebbi',
 				),
 				'KN' => array(
					'code' => 'KN',
 					'name' => 'Kano',
 				),
 				'KO' => array(
					'code' => 'KO',
 					'name' => 'Kogi',
 				),
 				'KT' => array(
					'code' => 'KT',
 					'name' => 'Katsina',
 				),
 				'KW' => array(
					'code' => 'KW',
 					'name' => 'Kwara',
 				),
 				'LA' => array(
					'code' => 'LA',
 					'name' => 'Lagos',
 				),
 				'NI' => array(
					'code' => 'NI',
 					'name' => 'Niger',
 				),
 				'OG' => array(
					'code' => 'OG',
 					'name' => 'Ogun',
 				),
 				'ON' => array(
					'code' => 'ON',
 					'name' => 'Ondo',
 				),
 				'OS' => array(
					'code' => 'OS',
 					'name' => 'Osun',
 				),
 				'OY' => array(
					'code' => 'OY',
 					'name' => 'Oyo',
 				),
 				'PL' => array(
					'code' => 'PL',
 					'name' => 'Plateau',
 				),
 				'RI' => array(
					'code' => 'RI',
 					'name' => 'Rivers',
 				),
 				'SO' => array(
					'code' => 'SO',
 					'name' => 'Sokoto',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Taraba',
 				),
 				'YO' => array(
					'code' => 'YO',
 					'name' => 'Yobe',
 				),
 			),
 		),
 		'NI' => array(
			'code' => 'NI',
 			'name' => 'Nicaragua',
 			'code3' => 'NIC',
 			'numeric' => '558',
 			'states' => array(
				'BO' => array(
					'code' => 'BO',
 					'name' => 'Boaco',
 				),
 				'CA' => array(
					'code' => 'CA',
 					'name' => 'Carazo',
 				),
 				'CI' => array(
					'code' => 'CI',
 					'name' => 'Chinandega',
 				),
 				'CO' => array(
					'code' => 'CO',
 					'name' => 'Chontales',
 				),
 				'ES' => array(
					'code' => 'ES',
 					'name' => 'Estelí',
 				),
 				'GR' => array(
					'code' => 'GR',
 					'name' => 'Granada',
 				),
 				'JI' => array(
					'code' => 'JI',
 					'name' => 'Jinotega',
 				),
 				'LE' => array(
					'code' => 'LE',
 					'name' => 'León',
 				),
 				'MD' => array(
					'code' => 'MD',
 					'name' => 'Madriz',
 				),
 				'MN' => array(
					'code' => 'MN',
 					'name' => 'Manaqua',
 				),
 				'MS' => array(
					'code' => 'MS',
 					'name' => 'Masaya',
 				),
 				'MT' => array(
					'code' => 'MT',
 					'name' => 'Matagalpa',
 				),
 				'NS' => array(
					'code' => 'NS',
 					'name' => 'Nueva Segovia',
 				),
 				'RI' => array(
					'code' => 'RI',
 					'name' => 'Rivas',
 				),
 				'SJ' => array(
					'code' => 'SJ',
 					'name' => 'Río San Juan',
 				),
 				'ZE' => array(
					'code' => 'ZE',
 					'name' => 'Zelaya',
 				),
 			),
 		),
 		'NL' => array(
			'code' => 'NL',
 			'name' => 'Netherlands',
 			'code3' => 'NLD',
 			'numeric' => '528',
 			'states' => array(
				'DR' => array(
					'code' => 'DR',
 					'name' => 'Drenthe',
 				),
 				'FL' => array(
					'code' => 'FL',
 					'name' => 'Flevoland',
 				),
 				'FR' => array(
					'code' => 'FR',
 					'name' => 'Friesland',
 				),
 				'GE' => array(
					'code' => 'GE',
 					'name' => 'Gelderland',
 				),
 				'GR' => array(
					'code' => 'GR',
 					'name' => 'Groningen',
 				),
 				'LI' => array(
					'code' => 'LI',
 					'name' => 'Limburg',
 				),
 				'NB' => array(
					'code' => 'NB',
 					'name' => 'Noord-Brabant',
 				),
 				'NH' => array(
					'code' => 'NH',
 					'name' => 'Noord-Holland',
 				),
 				'OV' => array(
					'code' => 'OV',
 					'name' => 'Overijssel',
 				),
 				'UT' => array(
					'code' => 'UT',
 					'name' => 'Utrecht',
 				),
 				'ZE' => array(
					'code' => 'ZE',
 					'name' => 'Zeeland',
 				),
 				'ZH' => array(
					'code' => 'ZH',
 					'name' => 'Zuid-Holland',
 				),
 			),
 		),
 		'NO' => array(
			'code' => 'NO',
 			'name' => 'Norway',
 			'code3' => 'NOR',
 			'numeric' => '578',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Østfold',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Akershus',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Oslo',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Hedmark',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Oppland',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Buskerud',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Vestfold',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Telemark',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Aust-Agder',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Vest-Agder',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Rogaland',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Hordaland',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Sogn og Fjordane',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Møre og Romsdal',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Sør-Trøndelag',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Nord-Trøndelag',
 				),
 				'18' => array(
					'code' => '18',
 					'name' => 'Nordland',
 				),
 				'19' => array(
					'code' => '19',
 					'name' => 'Troms',
 				),
 				'20' => array(
					'code' => '20',
 					'name' => 'Finnmark',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Svalbard',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Jan Mayen',
 				),
 			),
 		),
 		'NP' => array(
			'code' => 'NP',
 			'name' => 'Nepal',
 			'code3' => 'NPL',
 			'numeric' => '524',
 			'states' => array(
				'1' => array(
					'code' => '1',
 					'name' => 'Madhyamanchal',
 				),
 				'2' => array(
					'code' => '2',
 					'name' => 'Madhya Pashchimanchal',
 				),
 				'3' => array(
					'code' => '3',
 					'name' => 'Pashchimanchal',
 				),
 				'4' => array(
					'code' => '4',
 					'name' => 'Purwanchal',
 				),
 				'5' => array(
					'code' => '5',
 					'name' => 'Sudur Pashchimanchal',
 				),
 				'BA' => array(
					'code' => 'BA',
 					'name' => 'Bagmati',
 				),
 				'BH' => array(
					'code' => 'BH',
 					'name' => 'Bheri',
 				),
 				'DH' => array(
					'code' => 'DH',
 					'name' => 'Dhawalagiri',
 				),
 				'GA' => array(
					'code' => 'GA',
 					'name' => 'Gandaki',
 				),
 				'JA' => array(
					'code' => 'JA',
 					'name' => 'Janakpur',
 				),
 				'KA' => array(
					'code' => 'KA',
 					'name' => 'Karnali',
 				),
 				'KO' => array(
					'code' => 'KO',
 					'name' => 'Kosi [Koshi]',
 				),
 				'LU' => array(
					'code' => 'LU',
 					'name' => 'Lumbini',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Mahakali',
 				),
 				'ME' => array(
					'code' => 'ME',
 					'name' => 'Mechi',
 				),
 				'NA' => array(
					'code' => 'NA',
 					'name' => 'Narayani',
 				),
 				'RA' => array(
					'code' => 'RA',
 					'name' => 'Rapti',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Sagarmatha',
 				),
 				'SE' => array(
					'code' => 'SE',
 					'name' => 'Seti',
 				),
 			),
 		),
 		'NR' => array(
			'code' => 'NR',
 			'name' => 'Nauru',
 			'code3' => 'NRU',
 			'numeric' => '520',
 			'states' => array(
			),
 		),
 		'NU' => array(
			'code' => 'NU',
 			'name' => 'Niue',
 			'code3' => 'NIU',
 			'numeric' => '570',
 			'states' => array(
			),
 		),
 		'NZ' => array(
			'code' => 'NZ',
 			'name' => 'New Zealand',
 			'code3' => 'NZL',
 			'numeric' => '554',
 			'states' => array(
				'AUK' => array(
					'code' => 'AUK',
 					'name' => 'Auckland',
 				),
 				'BOP' => array(
					'code' => 'BOP',
 					'name' => 'Bay of Plenty',
 				),
 				'CAN' => array(
					'code' => 'CAN',
 					'name' => 'Canterbury',
 				),
 				'GIS' => array(
					'code' => 'GIS',
 					'name' => 'Gisborne',
 				),
 				'HKB' => array(
					'code' => 'HKB',
 					'name' => 'Hawkes\'s Bay',
 				),
 				'MBH' => array(
					'code' => 'MBH',
 					'name' => 'Marlborough',
 				),
 				'MWT' => array(
					'code' => 'MWT',
 					'name' => 'Manawatu-Wanganui',
 				),
 				'N' => array(
					'code' => 'N',
 					'name' => 'North Island',
 				),
 				'NSN' => array(
					'code' => 'NSN',
 					'name' => 'Nelson',
 				),
 				'NTL' => array(
					'code' => 'NTL',
 					'name' => 'Northland',
 				),
 				'OTA' => array(
					'code' => 'OTA',
 					'name' => 'Otago',
 				),
 				'S' => array(
					'code' => 'S',
 					'name' => 'South Island',
 				),
 				'STL' => array(
					'code' => 'STL',
 					'name' => 'Southland',
 				),
 				'TAS' => array(
					'code' => 'TAS',
 					'name' => 'Tasman',
 				),
 				'TKI' => array(
					'code' => 'TKI',
 					'name' => 'Taranaki',
 				),
 				'WGN' => array(
					'code' => 'WGN',
 					'name' => 'Wellington',
 				),
 				'WKO' => array(
					'code' => 'WKO',
 					'name' => 'Waikato',
 				),
 				'WTC' => array(
					'code' => 'WTC',
 					'name' => 'West Coast',
 				),
 			),
 		),
 		'OM' => array(
			'code' => 'OM',
 			'name' => 'Oman',
 			'code3' => 'OMN',
 			'numeric' => '512',
 			'states' => array(
				'BA' => array(
					'code' => 'BA',
 					'name' => 'Al Bāţinah',
 				),
 				'DA' => array(
					'code' => 'DA',
 					'name' => 'Ad Dākhilīyah',
 				),
 				'JA' => array(
					'code' => 'JA',
 					'name' => 'Al Janūbīyah [Zufār]',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Masqaţ',
 				),
 				'MU' => array(
					'code' => 'MU',
 					'name' => 'Musandam',
 				),
 				'SH' => array(
					'code' => 'SH',
 					'name' => 'Ash Sharqīyah',
 				),
 				'WU' => array(
					'code' => 'WU',
 					'name' => 'Al Wusţā',
 				),
 				'ZA' => array(
					'code' => 'ZA',
 					'name' => 'Az Zāhirah',
 				),
 			),
 		),
 		'PA' => array(
			'code' => 'PA',
 			'name' => 'Panama',
 			'code3' => 'PAN',
 			'numeric' => '591',
 			'states' => array(
				'0' => array(
					'code' => '0',
 					'name' => 'Comarca de San Blas',
 				),
 				'1' => array(
					'code' => '1',
 					'name' => 'Botas del Toro',
 				),
 				'2' => array(
					'code' => '2',
 					'name' => 'Coclé',
 				),
 				'3' => array(
					'code' => '3',
 					'name' => 'Colón',
 				),
 				'4' => array(
					'code' => '4',
 					'name' => 'Chiriquī',
 				),
 				'5' => array(
					'code' => '5',
 					'name' => 'Darién',
 				),
 				'6' => array(
					'code' => '6',
 					'name' => 'Herrera',
 				),
 				'7' => array(
					'code' => '7',
 					'name' => 'Los Santos',
 				),
 				'8' => array(
					'code' => '8',
 					'name' => 'Panamá',
 				),
 				'9' => array(
					'code' => '9',
 					'name' => 'Veraguas',
 				),
 			),
 		),
 		'PE' => array(
			'code' => 'PE',
 			'name' => 'Peru',
 			'code3' => 'PER',
 			'numeric' => '604',
 			'states' => array(
				'AMA' => array(
					'code' => 'AMA',
 					'name' => 'Amazonas',
 				),
 				'ANC' => array(
					'code' => 'ANC',
 					'name' => 'Ancash',
 				),
 				'APU' => array(
					'code' => 'APU',
 					'name' => 'Apurímac',
 				),
 				'ARE' => array(
					'code' => 'ARE',
 					'name' => 'Arequipa',
 				),
 				'AYA' => array(
					'code' => 'AYA',
 					'name' => 'Ayacucho',
 				),
 				'CAJ' => array(
					'code' => 'CAJ',
 					'name' => 'Cajamarca',
 				),
 				'CAL' => array(
					'code' => 'CAL',
 					'name' => 'El Callao',
 				),
 				'CUS' => array(
					'code' => 'CUS',
 					'name' => 'Cuzco [Cusco]',
 				),
 				'HUC' => array(
					'code' => 'HUC',
 					'name' => 'Huánuco',
 				),
 				'HUV' => array(
					'code' => 'HUV',
 					'name' => 'Huancavelica',
 				),
 				'ICA' => array(
					'code' => 'ICA',
 					'name' => 'Ica',
 				),
 				'JUN' => array(
					'code' => 'JUN',
 					'name' => 'Junín',
 				),
 				'LAL' => array(
					'code' => 'LAL',
 					'name' => 'La Libertad',
 				),
 				'LAM' => array(
					'code' => 'LAM',
 					'name' => 'Lambayeque',
 				),
 				'LIM' => array(
					'code' => 'LIM',
 					'name' => 'Lima',
 				),
 				'LOR' => array(
					'code' => 'LOR',
 					'name' => 'Loreto',
 				),
 				'MDD' => array(
					'code' => 'MDD',
 					'name' => 'Madre de Dios',
 				),
 				'MOQ' => array(
					'code' => 'MOQ',
 					'name' => 'Moquegua',
 				),
 				'PAS' => array(
					'code' => 'PAS',
 					'name' => 'Pasco',
 				),
 				'PIU' => array(
					'code' => 'PIU',
 					'name' => 'Piura',
 				),
 				'PUN' => array(
					'code' => 'PUN',
 					'name' => 'Puno',
 				),
 				'SAM' => array(
					'code' => 'SAM',
 					'name' => 'San Martín',
 				),
 				'TAC' => array(
					'code' => 'TAC',
 					'name' => 'Tacna',
 				),
 				'TUM' => array(
					'code' => 'TUM',
 					'name' => 'Tumbes',
 				),
 				'UCA' => array(
					'code' => 'UCA',
 					'name' => 'Ucayali',
 				),
 			),
 		),
 		'PF' => array(
			'code' => 'PF',
 			'name' => 'French Polynesia',
 			'code3' => 'PYF',
 			'numeric' => '258',
 			'states' => array(
			),
 		),
 		'PG' => array(
			'code' => 'PG',
 			'name' => 'Papua New Guinea',
 			'code3' => 'PNG',
 			'numeric' => '598',
 			'states' => array(
				'CPK' => array(
					'code' => 'CPK',
 					'name' => 'Chimbu',
 				),
 				'CPM' => array(
					'code' => 'CPM',
 					'name' => 'Central',
 				),
 				'EBR' => array(
					'code' => 'EBR',
 					'name' => 'East New Britain',
 				),
 				'EHG' => array(
					'code' => 'EHG',
 					'name' => 'Eastern Highlands',
 				),
 				'EPW' => array(
					'code' => 'EPW',
 					'name' => 'Enga',
 				),
 				'ESW' => array(
					'code' => 'ESW',
 					'name' => 'East Sepik',
 				),
 				'GPK' => array(
					'code' => 'GPK',
 					'name' => 'Gulf',
 				),
 				'MBA' => array(
					'code' => 'MBA',
 					'name' => 'Milne Bay',
 				),
 				'MPL' => array(
					'code' => 'MPL',
 					'name' => 'Morobe',
 				),
 				'MPM' => array(
					'code' => 'MPM',
 					'name' => 'Madang',
 				),
 				'MRL' => array(
					'code' => 'MRL',
 					'name' => 'Manus',
 				),
 				'NCD' => array(
					'code' => 'NCD',
 					'name' => 'National Capital District',
 				),
 				'NIK' => array(
					'code' => 'NIK',
 					'name' => 'New Ireland',
 				),
 				'NPP' => array(
					'code' => 'NPP',
 					'name' => 'Northern',
 				),
 				'NSA' => array(
					'code' => 'NSA',
 					'name' => 'North Solomons',
 				),
 				'SAN' => array(
					'code' => 'SAN',
 					'name' => 'Sandaun [West Sepik]',
 				),
 				'SHM' => array(
					'code' => 'SHM',
 					'name' => 'Southern Highlands',
 				),
 				'WBK' => array(
					'code' => 'WBK',
 					'name' => 'West New Britain',
 				),
 				'WHM' => array(
					'code' => 'WHM',
 					'name' => 'Western Highlands',
 				),
 				'WPD' => array(
					'code' => 'WPD',
 					'name' => 'Western',
 				),
 			),
 		),
 		'PH' => array(
			'code' => 'PH',
 			'name' => 'Philippines',
 			'code3' => 'PHL',
 			'numeric' => '608',
 			'states' => array(
			),
 		),
 		'PK' => array(
			'code' => 'PK',
 			'name' => 'Pakistan',
 			'code3' => 'PAK',
 			'numeric' => '586',
 			'states' => array(
				'BA' => array(
					'code' => 'BA',
 					'name' => 'Baluchistan',
 				),
 				'IS' => array(
					'code' => 'IS',
 					'name' => 'Islamabad',
 				),
 				'JK' => array(
					'code' => 'JK',
 					'name' => 'Azad Kashmir',
 				),
 				'NA' => array(
					'code' => 'NA',
 					'name' => 'Northern Areas',
 				),
 				'NW' => array(
					'code' => 'NW',
 					'name' => 'North-West Frontier',
 				),
 				'PB' => array(
					'code' => 'PB',
 					'name' => 'Punjab',
 				),
 				'SD' => array(
					'code' => 'SD',
 					'name' => 'Sind',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Federally Administered Tribal Areas',
 				),
 			),
 		),
 		'PL' => array(
			'code' => 'PL',
 			'name' => 'Poland',
 			'code3' => 'POL',
 			'numeric' => '616',
 			'states' => array(
				'BB' => array(
					'code' => 'BB',
 					'name' => 'Bielsko',
 				),
 				'BK' => array(
					'code' => 'BK',
 					'name' => 'Białystok',
 				),
 				'BP' => array(
					'code' => 'BP',
 					'name' => 'Biała Podlaska',
 				),
 				'BY' => array(
					'code' => 'BY',
 					'name' => 'Bydgoszcz',
 				),
 				'CH' => array(
					'code' => 'CH',
 					'name' => 'Chełm',
 				),
 				'CI' => array(
					'code' => 'CI',
 					'name' => 'Ciechanów',
 				),
 				'CZ' => array(
					'code' => 'CZ',
 					'name' => 'Czestochowa',
 				),
 				'EL' => array(
					'code' => 'EL',
 					'name' => 'Elblag',
 				),
 				'GD' => array(
					'code' => 'GD',
 					'name' => 'Gdańsk',
 				),
 				'GO' => array(
					'code' => 'GO',
 					'name' => 'Gorzów',
 				),
 				'JG' => array(
					'code' => 'JG',
 					'name' => 'Jelenia Gera',
 				),
 				'KA' => array(
					'code' => 'KA',
 					'name' => 'Katowice',
 				),
 				'KI' => array(
					'code' => 'KI',
 					'name' => 'Kielce',
 				),
 				'KL' => array(
					'code' => 'KL',
 					'name' => 'Kalisz',
 				),
 				'KN' => array(
					'code' => 'KN',
 					'name' => 'Konin',
 				),
 				'KO' => array(
					'code' => 'KO',
 					'name' => 'Koszalin',
 				),
 				'KR' => array(
					'code' => 'KR',
 					'name' => 'Kraków',
 				),
 				'KS' => array(
					'code' => 'KS',
 					'name' => 'Krosno',
 				),
 				'LD' => array(
					'code' => 'LD',
 					'name' => 'Łódź',
 				),
 				'LE' => array(
					'code' => 'LE',
 					'name' => 'Leszno',
 				),
 				'LG' => array(
					'code' => 'LG',
 					'name' => 'Legnica',
 				),
 				'LO' => array(
					'code' => 'LO',
 					'name' => 'Łomia',
 				),
 				'LU' => array(
					'code' => 'LU',
 					'name' => 'Lublin',
 				),
 				'NS' => array(
					'code' => 'NS',
 					'name' => 'Nowy Sacz',
 				),
 				'OL' => array(
					'code' => 'OL',
 					'name' => 'Olsztyn',
 				),
 				'OP' => array(
					'code' => 'OP',
 					'name' => 'Opole',
 				),
 				'OS' => array(
					'code' => 'OS',
 					'name' => 'Ostrołeka',
 				),
 				'PI' => array(
					'code' => 'PI',
 					'name' => 'Piła',
 				),
 				'PL' => array(
					'code' => 'PL',
 					'name' => 'Płock',
 				),
 				'PO' => array(
					'code' => 'PO',
 					'name' => 'Poznań',
 				),
 				'PR' => array(
					'code' => 'PR',
 					'name' => 'Przemyśl',
 				),
 				'PT' => array(
					'code' => 'PT',
 					'name' => 'Piotrków',
 				),
 				'RA' => array(
					'code' => 'RA',
 					'name' => 'Radom',
 				),
 				'RZ' => array(
					'code' => 'RZ',
 					'name' => 'Rzeszów',
 				),
 				'SE' => array(
					'code' => 'SE',
 					'name' => 'Siedlce',
 				),
 				'SI' => array(
					'code' => 'SI',
 					'name' => 'Sieradz',
 				),
 				'SK' => array(
					'code' => 'SK',
 					'name' => 'Skierniewice',
 				),
 				'SL' => array(
					'code' => 'SL',
 					'name' => 'Słupsk',
 				),
 				'SU' => array(
					'code' => 'SU',
 					'name' => 'Suwałki',
 				),
 				'SZ' => array(
					'code' => 'SZ',
 					'name' => 'Szczecin',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Tarnów',
 				),
 				'TG' => array(
					'code' => 'TG',
 					'name' => 'Tarnobrzeg',
 				),
 				'TO' => array(
					'code' => 'TO',
 					'name' => 'Toruń',
 				),
 				'WA' => array(
					'code' => 'WA',
 					'name' => 'Warszawa',
 				),
 				'WB' => array(
					'code' => 'WB',
 					'name' => 'Wałbrzych',
 				),
 				'WL' => array(
					'code' => 'WL',
 					'name' => 'Włocławek',
 				),
 				'WR' => array(
					'code' => 'WR',
 					'name' => 'Wrocław',
 				),
 				'ZA' => array(
					'code' => 'ZA',
 					'name' => 'Zamość',
 				),
 				'ZG' => array(
					'code' => 'ZG',
 					'name' => 'Zielona Góra',
 				),
 			),
 		),
 		'PM' => array(
			'code' => 'PM',
 			'name' => 'St. Pierre & Miquelon',
 			'code3' => 'SPM',
 			'numeric' => '666',
 			'states' => array(
			),
 		),
 		'PN' => array(
			'code' => 'PN',
 			'name' => 'Pitcairn',
 			'code3' => 'PCN',
 			'numeric' => '612',
 			'states' => array(
			),
 		),
 		'PR' => array(
			'code' => 'PR',
 			'name' => 'Puerto Rico',
 			'code3' => 'PRI',
 			'numeric' => '630',
 			'states' => array(
			),
 		),
 		'PT' => array(
			'code' => 'PT',
 			'name' => 'Portugal',
 			'code3' => 'PRT',
 			'numeric' => '620',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Aveiro',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Beja',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Braga',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Bragança',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Castelo Branco',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Coimbra',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Évora',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Faro',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Guarda',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Leiria',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Lisboa',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Portalegre',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Porto',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Santarém',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Setúbal',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Viana do Castelo',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Vila Real',
 				),
 				'18' => array(
					'code' => '18',
 					'name' => 'Viseu',
 				),
 				'20' => array(
					'code' => '20',
 					'name' => 'Regiāo Autónoma dos Açores',
 				),
 				'30' => array(
					'code' => '30',
 					'name' => 'Regiāo Autónoma da Madeira',
 				),
 			),
 		),
 		'PW' => array(
			'code' => 'PW',
 			'name' => 'Palau',
 			'code3' => 'PLW',
 			'numeric' => '585',
 			'states' => array(
			),
 		),
 		'PY' => array(
			'code' => 'PY',
 			'name' => 'Paraguay',
 			'code3' => 'PRY',
 			'numeric' => '600',
 			'states' => array(
				'1' => array(
					'code' => '1',
 					'name' => 'Concepción',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Alto Parang',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Central',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Neembucú',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Amambay',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Canindeyú',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Presidente Hayes',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Alto Paraguay',
 				),
 				'19' => array(
					'code' => '19',
 					'name' => 'Boquerón',
 				),
 				'2' => array(
					'code' => '2',
 					'name' => 'San Pedro',
 				),
 				'3' => array(
					'code' => '3',
 					'name' => 'Cordillera',
 				),
 				'4' => array(
					'code' => '4',
 					'name' => 'Guairá',
 				),
 				'5' => array(
					'code' => '5',
 					'name' => 'Caaguazú',
 				),
 				'6' => array(
					'code' => '6',
 					'name' => 'Caazapá',
 				),
 				'7' => array(
					'code' => '7',
 					'name' => 'Itapúa',
 				),
 				'8' => array(
					'code' => '8',
 					'name' => 'Misiones',
 				),
 				'9' => array(
					'code' => '9',
 					'name' => 'Paraguarī',
 				),
 				'ASU' => array(
					'code' => 'ASU',
 					'name' => 'Asunción',
 				),
 			),
 		),
 		'QA' => array(
			'code' => 'QA',
 			'name' => 'Qatar',
 			'code3' => 'QAT',
 			'numeric' => '634',
 			'states' => array(
				'DA' => array(
					'code' => 'DA',
 					'name' => 'Ad Dawḩah',
 				),
 				'GH' => array(
					'code' => 'GH',
 					'name' => 'Al Ghuwayrīyah',
 				),
 				'JB' => array(
					'code' => 'JB',
 					'name' => 'Jarīyān al Bāţnah',
 				),
 				'JU' => array(
					'code' => 'JU',
 					'name' => 'Al Jumaylīyah',
 				),
 				'KH' => array(
					'code' => 'KH',
 					'name' => 'Al Khawr',
 				),
 				'MS' => array(
					'code' => 'MS',
 					'name' => 'Madīnat ash Shamāl',
 				),
 				'RA' => array(
					'code' => 'RA',
 					'name' => 'Ar Rayyān',
 				),
 				'US' => array(
					'code' => 'US',
 					'name' => 'Umm Şalāl',
 				),
 				'WA' => array(
					'code' => 'WA',
 					'name' => 'Al Wakrah',
 				),
 			),
 		),
 		'RE' => array(
			'code' => 'RE',
 			'name' => 'Reunion',
 			'code3' => 'REU',
 			'numeric' => '638',
 			'states' => array(
			),
 		),
 		'RO' => array(
			'code' => 'RO',
 			'name' => 'Romania',
 			'code3' => 'ROU',
 			'numeric' => '642',
 			'states' => array(
				'AB' => array(
					'code' => 'AB',
 					'name' => 'Alba',
 				),
 				'AG' => array(
					'code' => 'AG',
 					'name' => 'Argeş',
 				),
 				'AR' => array(
					'code' => 'AR',
 					'name' => 'Arad',
 				),
 				'B' => array(
					'code' => 'B',
 					'name' => 'Bucureşti',
 				),
 				'BC' => array(
					'code' => 'BC',
 					'name' => 'Bacău',
 				),
 				'BH' => array(
					'code' => 'BH',
 					'name' => 'Bihor',
 				),
 				'BN' => array(
					'code' => 'BN',
 					'name' => 'Bistriţa-Năsăud',
 				),
 				'BR' => array(
					'code' => 'BR',
 					'name' => 'Brăila',
 				),
 				'BT' => array(
					'code' => 'BT',
 					'name' => 'Botoşani',
 				),
 				'BV' => array(
					'code' => 'BV',
 					'name' => 'Braşov',
 				),
 				'BZ' => array(
					'code' => 'BZ',
 					'name' => 'Buzău',
 				),
 				'CJ' => array(
					'code' => 'CJ',
 					'name' => 'Cluj',
 				),
 				'CL' => array(
					'code' => 'CL',
 					'name' => 'Călăraşi',
 				),
 				'CS' => array(
					'code' => 'CS',
 					'name' => 'Caraş-Severin',
 				),
 				'CT' => array(
					'code' => 'CT',
 					'name' => 'Constanţa',
 				),
 				'CV' => array(
					'code' => 'CV',
 					'name' => 'Covasna',
 				),
 				'DB' => array(
					'code' => 'DB',
 					'name' => 'Dâmboviţa',
 				),
 				'DJ' => array(
					'code' => 'DJ',
 					'name' => 'Dolj',
 				),
 				'GJ' => array(
					'code' => 'GJ',
 					'name' => 'Gorj',
 				),
 				'GL' => array(
					'code' => 'GL',
 					'name' => 'Galaţi',
 				),
 				'GR' => array(
					'code' => 'GR',
 					'name' => 'Giurgiu',
 				),
 				'HD' => array(
					'code' => 'HD',
 					'name' => 'Hunedoara',
 				),
 				'HR' => array(
					'code' => 'HR',
 					'name' => 'Harghita',
 				),
 				'IL' => array(
					'code' => 'IL',
 					'name' => 'Ialomiţa',
 				),
 				'IS' => array(
					'code' => 'IS',
 					'name' => 'Iaşi',
 				),
 				'MH' => array(
					'code' => 'MH',
 					'name' => 'Mehedinţi',
 				),
 				'MM' => array(
					'code' => 'MM',
 					'name' => 'Maramureş',
 				),
 				'MS' => array(
					'code' => 'MS',
 					'name' => 'Mureş',
 				),
 				'NT' => array(
					'code' => 'NT',
 					'name' => 'Neamţ',
 				),
 				'OT' => array(
					'code' => 'OT',
 					'name' => 'Olt',
 				),
 				'PH' => array(
					'code' => 'PH',
 					'name' => 'Prahova',
 				),
 				'SB' => array(
					'code' => 'SB',
 					'name' => 'Sibiu',
 				),
 				'SJ' => array(
					'code' => 'SJ',
 					'name' => 'Sălaj',
 				),
 				'SM' => array(
					'code' => 'SM',
 					'name' => 'Satu Mare',
 				),
 				'SV' => array(
					'code' => 'SV',
 					'name' => 'Suceava',
 				),
 				'TL' => array(
					'code' => 'TL',
 					'name' => 'Tulcea',
 				),
 				'TM' => array(
					'code' => 'TM',
 					'name' => 'Timiş',
 				),
 				'TR' => array(
					'code' => 'TR',
 					'name' => 'Teleorman',
 				),
 				'VL' => array(
					'code' => 'VL',
 					'name' => 'Vâlcea',
 				),
 				'VN' => array(
					'code' => 'VN',
 					'name' => 'Vrancea',
 				),
 				'VS' => array(
					'code' => 'VS',
 					'name' => 'Vaslui',
 				),
 			),
 		),
 		'RU' => array(
			'code' => 'RU',
 			'name' => 'Russian Federation',
 			'code3' => 'RUS',
 			'numeric' => '643',
 			'states' => array(
				'AD' => array(
					'code' => 'AD',
 					'name' => 'Adygeya, Respublika',
 				),
 				'AGB' => array(
					'code' => 'AGB',
 					'name' => 'Aginskiy Buryatskiy avtonomnyy okrug',
 				),
 				'AL' => array(
					'code' => 'AL',
 					'name' => 'Altay, Respublika',
 				),
 				'ALT' => array(
					'code' => 'ALT',
 					'name' => 'Altayskiy kray',
 				),
 				'AMU' => array(
					'code' => 'AMU',
 					'name' => 'Amurskaya Oblast\'',
 				),
 				'ARK' => array(
					'code' => 'ARK',
 					'name' => 'Arkhangel\'skaya Oblast\'',
 				),
 				'AST' => array(
					'code' => 'AST',
 					'name' => 'Astrakhanskaya Oblast\'',
 				),
 				'BA' => array(
					'code' => 'BA',
 					'name' => 'Bashkortostan, Respublika',
 				),
 				'BEL' => array(
					'code' => 'BEL',
 					'name' => 'Belgorodskaya Oblast\'',
 				),
 				'BRY' => array(
					'code' => 'BRY',
 					'name' => 'Bryanskaya Oblast\'',
 				),
 				'BU' => array(
					'code' => 'BU',
 					'name' => 'Buryatiya, Respublika',
 				),
 				'CE' => array(
					'code' => 'CE',
 					'name' => 'Chechenskaya Respublika',
 				),
 				'CHE' => array(
					'code' => 'CHE',
 					'name' => 'Chelyabinskaya Oblast\'',
 				),
 				'CHI' => array(
					'code' => 'CHI',
 					'name' => 'Chitinskaya Oblast\'',
 				),
 				'CHU' => array(
					'code' => 'CHU',
 					'name' => 'Chukotskiy avtonomnyy okrug',
 				),
 				'CU' => array(
					'code' => 'CU',
 					'name' => 'Chuvashskaya Respublika',
 				),
 				'DA' => array(
					'code' => 'DA',
 					'name' => 'Dagestan, Respublika',
 				),
 				'EVE' => array(
					'code' => 'EVE',
 					'name' => 'Evenkiyskiy avtonomnyy okrug',
 				),
 				'IN' => array(
					'code' => 'IN',
 					'name' => 'Ingushskaya Respublika',
 				),
 				'IRK' => array(
					'code' => 'IRK',
 					'name' => 'Irkutskaya Oblast\'',
 				),
 				'IVA' => array(
					'code' => 'IVA',
 					'name' => 'Ivanovskaya Oblast\'',
 				),
 				'KAM' => array(
					'code' => 'KAM',
 					'name' => 'Kamchatskaya Oblast\'',
 				),
 				'KB' => array(
					'code' => 'KB',
 					'name' => 'Kabardino-Balkarskaya Respublika',
 				),
 				'KC' => array(
					'code' => 'KC',
 					'name' => 'Karachayevo-Cherkesskaya Respublika',
 				),
 				'KDA' => array(
					'code' => 'KDA',
 					'name' => 'Krasnodarskiy kray',
 				),
 				'KEM' => array(
					'code' => 'KEM',
 					'name' => 'Kemerovskaya Oblast\'',
 				),
 				'KGD' => array(
					'code' => 'KGD',
 					'name' => 'Kaliningradskaya Oblast\'',
 				),
 				'KGN' => array(
					'code' => 'KGN',
 					'name' => 'Kurganskaya Oblast\'',
 				),
 				'KHA' => array(
					'code' => 'KHA',
 					'name' => 'Khabarovskiy kray',
 				),
 				'KHM' => array(
					'code' => 'KHM',
 					'name' => 'Khanty-Mansiyskiy avtonomnyy okrug',
 				),
 				'KIR' => array(
					'code' => 'KIR',
 					'name' => 'Kirovskaya Oblast\'',
 				),
 				'KK' => array(
					'code' => 'KK',
 					'name' => 'Khakasiya, Respublika',
 				),
 				'KL' => array(
					'code' => 'KL',
 					'name' => 'Kalmykiya, Respublika',
 				),
 				'KLU' => array(
					'code' => 'KLU',
 					'name' => 'Kaluzhskaya Oblast\'',
 				),
 				'KO' => array(
					'code' => 'KO',
 					'name' => 'Komi, Respublika',
 				),
 				'KOP' => array(
					'code' => 'KOP',
 					'name' => 'Komi-Permyatskiy avtonomnyy okrug',
 				),
 				'KOR' => array(
					'code' => 'KOR',
 					'name' => 'Koryakskiy avtonomnyy okrug',
 				),
 				'KOS' => array(
					'code' => 'KOS',
 					'name' => 'Kostromskaya Oblast\'',
 				),
 				'KR' => array(
					'code' => 'KR',
 					'name' => 'Kareliya, Respublika',
 				),
 				'KRS' => array(
					'code' => 'KRS',
 					'name' => 'Kurskaya Oblast\'',
 				),
 				'KYA' => array(
					'code' => 'KYA',
 					'name' => 'Krasnoyarskiy kray',
 				),
 				'LEN' => array(
					'code' => 'LEN',
 					'name' => 'Leningradskaya Oblast\'',
 				),
 				'LIP' => array(
					'code' => 'LIP',
 					'name' => 'Lipetskaya Oblast\'',
 				),
 				'MAG' => array(
					'code' => 'MAG',
 					'name' => 'Magadanskaya Oblast\'',
 				),
 				'ME' => array(
					'code' => 'ME',
 					'name' => 'Mariy El, Respublika',
 				),
 				'MO' => array(
					'code' => 'MO',
 					'name' => 'Mordoviya, Respublika',
 				),
 				'MOS' => array(
					'code' => 'MOS',
 					'name' => 'Moskovskaya Oblast\'',
 				),
 				'MOW' => array(
					'code' => 'MOW',
 					'name' => 'Moskva',
 				),
 				'MUR' => array(
					'code' => 'MUR',
 					'name' => 'Murmanskaya Oblast\'',
 				),
 				'NEN' => array(
					'code' => 'NEN',
 					'name' => 'Nenetskiy avtonomnyy okrug',
 				),
 				'NGR' => array(
					'code' => 'NGR',
 					'name' => 'Novgorodskaya Oblast\'',
 				),
 				'NIZ' => array(
					'code' => 'NIZ',
 					'name' => 'Nizhegorodskaya Oblast\'',
 				),
 				'NVS' => array(
					'code' => 'NVS',
 					'name' => 'Novosibirskaya Oblast\'',
 				),
 				'OMS' => array(
					'code' => 'OMS',
 					'name' => 'Omskaya Oblast\'',
 				),
 				'ORE' => array(
					'code' => 'ORE',
 					'name' => 'Orenburgskaya Oblast\'',
 				),
 				'ORL' => array(
					'code' => 'ORL',
 					'name' => 'Orlovskaya Oblast\'',
 				),
 				'PER' => array(
					'code' => 'PER',
 					'name' => 'Permskaya Oblast\'',
 				),
 				'PNZ' => array(
					'code' => 'PNZ',
 					'name' => 'Penzenskaya Oblast\'',
 				),
 				'PRI' => array(
					'code' => 'PRI',
 					'name' => 'Primorskiy kray',
 				),
 				'PSK' => array(
					'code' => 'PSK',
 					'name' => 'Pskovskaya Oblast\'',
 				),
 				'ROS' => array(
					'code' => 'ROS',
 					'name' => 'Rostovskaya Oblast\'',
 				),
 				'RYA' => array(
					'code' => 'RYA',
 					'name' => 'Ryazanskaya Oblast\'',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Sakha, Respublika [Yakutiya]',
 				),
 				'SAK' => array(
					'code' => 'SAK',
 					'name' => 'Sakhalinskaya Oblast\'',
 				),
 				'SAM' => array(
					'code' => 'SAM',
 					'name' => 'Samarskaya Oblast’',
 				),
 				'SAR' => array(
					'code' => 'SAR',
 					'name' => 'Saratovskaya Oblast\'',
 				),
 				'SE' => array(
					'code' => 'SE',
 					'name' => 'Severnaya Osetiya, Respublika [Alaniya]',
 				),
 				'SMO' => array(
					'code' => 'SMO',
 					'name' => 'Smolenskaya Oblast\'',
 				),
 				'SPE' => array(
					'code' => 'SPE',
 					'name' => 'Sankt-Peterburg',
 				),
 				'STA' => array(
					'code' => 'STA',
 					'name' => 'Stavropol \'skiy kray',
 				),
 				'SVE' => array(
					'code' => 'SVE',
 					'name' => 'Sverdlovskaya Oblast\'',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Tatarstan, Respublika',
 				),
 				'TAM' => array(
					'code' => 'TAM',
 					'name' => 'Tambovskaya Oblast\'',
 				),
 				'TAY' => array(
					'code' => 'TAY',
 					'name' => 'Taymyrskiy (Dolgano-Nenetskiy) avtonomnyy okrug',
 				),
 				'TOM' => array(
					'code' => 'TOM',
 					'name' => 'Tomskaya Oblast’',
 				),
 				'TUL' => array(
					'code' => 'TUL',
 					'name' => 'Tul\'skaya Oblast\'',
 				),
 				'TVE' => array(
					'code' => 'TVE',
 					'name' => 'Tverskaya Oblast\'',
 				),
 				'TY' => array(
					'code' => 'TY',
 					'name' => 'Tyva, Respublika [Tuva]',
 				),
 				'TYU' => array(
					'code' => 'TYU',
 					'name' => 'Tyumenskaya Oblast\'',
 				),
 				'UD' => array(
					'code' => 'UD',
 					'name' => 'Udmurtskaya Respublika',
 				),
 				'ULY' => array(
					'code' => 'ULY',
 					'name' => 'Ul\'yanovskaya Oblast\'',
 				),
 				'UOB' => array(
					'code' => 'UOB',
 					'name' => 'Ust’-Ordynskiy Buryatskiy avtonomnyy okrug',
 				),
 				'VGG' => array(
					'code' => 'VGG',
 					'name' => 'Volgogradskaya Oblast\'',
 				),
 				'VLA' => array(
					'code' => 'VLA',
 					'name' => 'Vladimirskaya Oblast\'',
 				),
 				'VLG' => array(
					'code' => 'VLG',
 					'name' => 'Vologodskaya Oblast\'',
 				),
 				'VOR' => array(
					'code' => 'VOR',
 					'name' => 'Voronezhskaya Oblast\'',
 				),
 				'YAN' => array(
					'code' => 'YAN',
 					'name' => 'Yamalo-Nenetskiy avtonomnyy okrug',
 				),
 				'YAR' => array(
					'code' => 'YAR',
 					'name' => 'Yaroslavskaya Oblast\'',
 				),
 				'YEV' => array(
					'code' => 'YEV',
 					'name' => 'Yevreyskaya avtonomnaya oblast\'',
 				),
 			),
 		),
 		'RW' => array(
			'code' => 'RW',
 			'name' => 'Rwanda',
 			'code3' => 'RWA',
 			'numeric' => '646',
 			'states' => array(
				'B' => array(
					'code' => 'B',
 					'name' => 'Gitarama',
 				),
 				'C' => array(
					'code' => 'C',
 					'name' => 'Butare',
 				),
 				'D' => array(
					'code' => 'D',
 					'name' => 'Gikongoro',
 				),
 				'E' => array(
					'code' => 'E',
 					'name' => 'Cyangugu',
 				),
 				'F' => array(
					'code' => 'F',
 					'name' => 'Kibuye',
 				),
 				'G' => array(
					'code' => 'G',
 					'name' => 'Gisenyi',
 				),
 				'H' => array(
					'code' => 'H',
 					'name' => 'Ruhengeri',
 				),
 				'I' => array(
					'code' => 'I',
 					'name' => 'Byumba',
 				),
 				'J' => array(
					'code' => 'J',
 					'name' => 'Kibungo',
 				),
 				'K' => array(
					'code' => 'K',
 					'name' => 'Kigali-Rural',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'Kigali-Ville',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'Mutara',
 				),
 			),
 		),
 		'SA' => array(
			'code' => 'SA',
 			'name' => 'Saudi Arabia',
 			'code3' => 'SAU',
 			'numeric' => '682',
 			'states' => array(
				'02' => array(
					'code' => '02',
 					'name' => 'Makkah',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Al Madīnah',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Ash Sharqīyah',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Al Qaşim',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Ḩā\'il',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Tabūk',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Al Ḩudūd ash Shamālīyah',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Jīzān',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Najrān',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Al Bāḩah',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Al Jawf',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => '‘Asīr',
 				),
 				'O1' => array(
					'code' => 'O1',
 					'name' => 'Ar Riyāḑ',
 				),
 			),
 		),
 		'SB' => array(
			'code' => 'SB',
 			'name' => 'Solomon Islands',
 			'code3' => 'SLB',
 			'numeric' => '090',
 			'states' => array(
				'CE' => array(
					'code' => 'CE',
 					'name' => 'Central',
 				),
 				'CT' => array(
					'code' => 'CT',
 					'name' => 'Capital Territory',
 				),
 				'GU' => array(
					'code' => 'GU',
 					'name' => 'Guadalcanal',
 				),
 				'IS' => array(
					'code' => 'IS',
 					'name' => 'Isabel',
 				),
 				'MK' => array(
					'code' => 'MK',
 					'name' => 'Makira',
 				),
 				'ML' => array(
					'code' => 'ML',
 					'name' => 'Malaita',
 				),
 				'TE' => array(
					'code' => 'TE',
 					'name' => 'Temotu',
 				),
 				'WE' => array(
					'code' => 'WE',
 					'name' => 'Western',
 				),
 			),
 		),
 		'SC' => array(
			'code' => 'SC',
 			'name' => 'Seychelles',
 			'code3' => 'SYC',
 			'numeric' => '690',
 			'states' => array(
			),
 		),
 		'SD' => array(
			'code' => 'SD',
 			'name' => 'Sudan',
 			'code3' => 'SDN',
 			'numeric' => '729',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Ash Shamālīyah',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Shamāl Dārfūr',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Al Kharţūm',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'An Nīl',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Kassalā',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Al Qaḑārif',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Al Jazīrah',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'An Nīl al Abyaḑ',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Shamāl Kurdufān',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Gharb Kurdufān',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Janūb Dārfūr',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Gharb Dārfūr',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Janūb Kurdufān',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Gharb Baḩr al Ghazāl',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Shamāl Baḩr al Ghazāl',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Gharb al Istiwā\'īyah',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Baḩr al Jabal',
 				),
 				'18' => array(
					'code' => '18',
 					'name' => 'Al Buḩayrāt',
 				),
 				'19' => array(
					'code' => '19',
 					'name' => 'Sharq al Istiwā\'iyah',
 				),
 				'20' => array(
					'code' => '20',
 					'name' => 'Jūnqalī',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Wārāb',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Al Waḩdah',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'A‘ālī an Nīl',
 				),
 				'24' => array(
					'code' => '24',
 					'name' => 'An Nīl al Azraq',
 				),
 				'25' => array(
					'code' => '25',
 					'name' => 'Sinnār',
 				),
 				'26' => array(
					'code' => '26',
 					'name' => 'Al Baḩr al Aḩmar',
 				),
 			),
 		),
 		'SE' => array(
			'code' => 'SE',
 			'name' => 'Sweden',
 			'code3' => 'SWE',
 			'numeric' => '752',
 			'states' => array(
				'AB' => array(
					'code' => 'AB',
 					'name' => 'Stockholms län',
 				),
 				'AC' => array(
					'code' => 'AC',
 					'name' => 'Västerbottens län',
 				),
 				'BD' => array(
					'code' => 'BD',
 					'name' => 'Norrbottens län',
 				),
 				'C' => array(
					'code' => 'C',
 					'name' => 'Uppsala län',
 				),
 				'D' => array(
					'code' => 'D',
 					'name' => 'Södermanlands län',
 				),
 				'E' => array(
					'code' => 'E',
 					'name' => 'Östergötlands län',
 				),
 				'F' => array(
					'code' => 'F',
 					'name' => 'Jönköpings län',
 				),
 				'G' => array(
					'code' => 'G',
 					'name' => 'Kronobergs län',
 				),
 				'H' => array(
					'code' => 'H',
 					'name' => 'Kalmar län',
 				),
 				'I' => array(
					'code' => 'I',
 					'name' => 'Gotlands län',
 				),
 				'K' => array(
					'code' => 'K',
 					'name' => 'Blekinge län',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'Skåne län',
 				),
 				'N' => array(
					'code' => 'N',
 					'name' => 'Hallands län',
 				),
 				'O' => array(
					'code' => 'O',
 					'name' => 'Västra Götalands län',
 				),
 				'S' => array(
					'code' => 'S',
 					'name' => 'Värmlands län',
 				),
 				'T' => array(
					'code' => 'T',
 					'name' => 'Örebro län',
 				),
 				'U' => array(
					'code' => 'U',
 					'name' => 'Västmanlands län',
 				),
 				'W' => array(
					'code' => 'W',
 					'name' => 'Dalarnas län',
 				),
 				'X' => array(
					'code' => 'X',
 					'name' => 'Gävleborgs län',
 				),
 				'Y' => array(
					'code' => 'Y',
 					'name' => 'Västernorrlands län',
 				),
 				'Z' => array(
					'code' => 'Z',
 					'name' => 'Jämtlands län',
 				),
 			),
 		),
 		'SG' => array(
			'code' => 'SG',
 			'name' => 'Singapore',
 			'code3' => 'SGP',
 			'numeric' => '702',
 			'states' => array(
				'AC' => array(
					'code' => 'AC',
 					'name' => 'Ascension',
 				),
 				'SH' => array(
					'code' => 'SH',
 					'name' => 'Saint Helena',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Tristan da Cunha',
 				),
 			),
 		),
 		'SI' => array(
			'code' => 'SI',
 			'name' => 'Slovenia',
 			'code3' => 'SVN',
 			'numeric' => '705',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Pomurska',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Podravska',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Koroška',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Savinjska',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Zasavska',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Spodnjeposavska',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Dolenjska',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Osrednjeslovenska',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Gorenjska',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Notranjsko-kraška',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Goriška',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Obalno-kraška',
 				),
 			),
 		),
 		'SJ' => array(
			'code' => 'SJ',
 			'name' => 'Svalbard & Jan Mayen Islands',
 			'code3' => 'SJM',
 			'numeric' => '744',
 			'states' => array(
			),
 		),
 		'SK' => array(
			'code' => 'SK',
 			'name' => 'Slovak Republic',
 			'code3' => 'SVK',
 			'numeric' => '703',
 			'states' => array(
				'BC' => array(
					'code' => 'BC',
 					'name' => 'Banskobystrický kraj',
 				),
 				'BL' => array(
					'code' => 'BL',
 					'name' => 'Bratislavský kraj',
 				),
 				'KI' => array(
					'code' => 'KI',
 					'name' => 'Košický kraj',
 				),
 				'NI' => array(
					'code' => 'NI',
 					'name' => 'Nitriansky kraj',
 				),
 				'PV' => array(
					'code' => 'PV',
 					'name' => 'Prešovský kraj',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Trnavský kraj',
 				),
 				'TC' => array(
					'code' => 'TC',
 					'name' => 'Trenčiansky kraj',
 				),
 				'ZI' => array(
					'code' => 'ZI',
 					'name' => 'Žilinský kraj',
 				),
 			),
 		),
 		'SL' => array(
			'code' => 'SL',
 			'name' => 'Sierra Leone',
 			'code3' => 'SLE',
 			'numeric' => '694',
 			'states' => array(
				'E' => array(
					'code' => 'E',
 					'name' => 'Eastern',
 				),
 				'N' => array(
					'code' => 'N',
 					'name' => 'Northern',
 				),
 				'S' => array(
					'code' => 'S',
 					'name' => 'Southern',
 				),
 				'W' => array(
					'code' => 'W',
 					'name' => 'Western Area',
 				),
 			),
 		),
 		'SM' => array(
			'code' => 'SM',
 			'name' => 'San Marino',
 			'code3' => 'SMR',
 			'numeric' => '674',
 			'states' => array(
			),
 		),
 		'SN' => array(
			'code' => 'SN',
 			'name' => 'Senegal',
 			'code3' => 'SEN',
 			'numeric' => '686',
 			'states' => array(
				'DB' => array(
					'code' => 'DB',
 					'name' => 'Diourbel',
 				),
 				'DK' => array(
					'code' => 'DK',
 					'name' => 'Dakar',
 				),
 				'FK' => array(
					'code' => 'FK',
 					'name' => 'Fatick',
 				),
 				'KD' => array(
					'code' => 'KD',
 					'name' => 'Kolda',
 				),
 				'KL' => array(
					'code' => 'KL',
 					'name' => 'Kaolack',
 				),
 				'LG' => array(
					'code' => 'LG',
 					'name' => 'Louga',
 				),
 				'SL' => array(
					'code' => 'SL',
 					'name' => 'Saint-Louis',
 				),
 				'TC' => array(
					'code' => 'TC',
 					'name' => 'Tambacounda',
 				),
 				'TH' => array(
					'code' => 'TH',
 					'name' => 'Thiès',
 				),
 				'ZG' => array(
					'code' => 'ZG',
 					'name' => 'Ziguinchor',
 				),
 			),
 		),
 		'SO' => array(
			'code' => 'SO',
 			'name' => 'Somalia',
 			'code3' => 'SOM',
 			'numeric' => '706',
 			'states' => array(
				'AW' => array(
					'code' => 'AW',
 					'name' => 'Awdal',
 				),
 				'BK' => array(
					'code' => 'BK',
 					'name' => 'Bakool',
 				),
 				'BN' => array(
					'code' => 'BN',
 					'name' => 'Banaadir',
 				),
 				'BR' => array(
					'code' => 'BR',
 					'name' => 'Bari',
 				),
 				'BY' => array(
					'code' => 'BY',
 					'name' => 'BaY',
 				),
 				'GA' => array(
					'code' => 'GA',
 					'name' => 'Galguduud',
 				),
 				'GE' => array(
					'code' => 'GE',
 					'name' => 'Gedo',
 				),
 				'HI' => array(
					'code' => 'HI',
 					'name' => 'Hiiraan',
 				),
 				'JD' => array(
					'code' => 'JD',
 					'name' => 'Jubbada Dhexe',
 				),
 				'JH' => array(
					'code' => 'JH',
 					'name' => 'Jubbada Hoose',
 				),
 				'MU' => array(
					'code' => 'MU',
 					'name' => 'Mudug',
 				),
 				'NU' => array(
					'code' => 'NU',
 					'name' => 'Nugaal',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Sanaag',
 				),
 				'SD' => array(
					'code' => 'SD',
 					'name' => 'Shabeellaha Dhexe',
 				),
 				'SH' => array(
					'code' => 'SH',
 					'name' => 'Shabeellaha Hoose',
 				),
 				'SO' => array(
					'code' => 'SO',
 					'name' => 'Sool',
 				),
 				'TO' => array(
					'code' => 'TO',
 					'name' => 'Togdheer',
 				),
 				'WO' => array(
					'code' => 'WO',
 					'name' => 'Woqooyi Galbeed',
 				),
 			),
 		),
 		'SR' => array(
			'code' => 'SR',
 			'name' => 'Suriname',
 			'code3' => 'SUR',
 			'numeric' => '740',
 			'states' => array(
				'BR' => array(
					'code' => 'BR',
 					'name' => 'Brokopondo',
 				),
 				'CM' => array(
					'code' => 'CM',
 					'name' => 'Commewijne',
 				),
 				'CR' => array(
					'code' => 'CR',
 					'name' => 'Coronie',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Marowijne',
 				),
 				'NI' => array(
					'code' => 'NI',
 					'name' => 'Nickerie',
 				),
 				'PM' => array(
					'code' => 'PM',
 					'name' => 'Paramaribo',
 				),
 				'PR' => array(
					'code' => 'PR',
 					'name' => 'Para',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Saramacca',
 				),
 				'SI' => array(
					'code' => 'SI',
 					'name' => 'Sipaliwini',
 				),
 				'WA' => array(
					'code' => 'WA',
 					'name' => 'Wanica',
 				),
 			),
 		),
 		'ST' => array(
			'code' => 'ST',
 			'name' => 'Sao Tome & Principe',
 			'code3' => 'STP',
 			'numeric' => '678',
 			'states' => array(
				'P' => array(
					'code' => 'P',
 					'name' => 'Príncipe',
 				),
 				'S' => array(
					'code' => 'S',
 					'name' => 'Sāo Tomé',
 				),
 			),
 		),
 		'SV' => array(
			'code' => 'SV',
 			'name' => 'El Salvador',
 			'code3' => 'SLV',
 			'numeric' => '222',
 			'states' => array(
				'AH' => array(
					'code' => 'AH',
 					'name' => 'Ahuachapán',
 				),
 				'CA' => array(
					'code' => 'CA',
 					'name' => 'Cabañas',
 				),
 				'CH' => array(
					'code' => 'CH',
 					'name' => 'Chalatenango',
 				),
 				'CU' => array(
					'code' => 'CU',
 					'name' => 'Cuscatlán',
 				),
 				'LI' => array(
					'code' => 'LI',
 					'name' => 'La Libertad',
 				),
 				'MO' => array(
					'code' => 'MO',
 					'name' => 'Morazán',
 				),
 				'PA' => array(
					'code' => 'PA',
 					'name' => 'La Paz',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Santa Ana',
 				),
 				'SM' => array(
					'code' => 'SM',
 					'name' => 'San Miguel',
 				),
 				'SO' => array(
					'code' => 'SO',
 					'name' => 'Sonsonate',
 				),
 				'SS' => array(
					'code' => 'SS',
 					'name' => 'San Salvador',
 				),
 				'SU' => array(
					'code' => 'SU',
 					'name' => 'Usulután',
 				),
 				'SV' => array(
					'code' => 'SV',
 					'name' => 'San Vicente',
 				),
 				'UN' => array(
					'code' => 'UN',
 					'name' => 'La Unión',
 				),
 			),
 		),
 		'SY' => array(
			'code' => 'SY',
 			'name' => 'Syria',
 			'code3' => 'SYR',
 			'numeric' => '760',
 			'states' => array(
				'DI' => array(
					'code' => 'DI',
 					'name' => 'Dimashq',
 				),
 				'DR' => array(
					'code' => 'DR',
 					'name' => 'Dar’ā',
 				),
 				'DY' => array(
					'code' => 'DY',
 					'name' => 'Dayr az Zawr',
 				),
 				'HA' => array(
					'code' => 'HA',
 					'name' => 'Al Ḩasakah',
 				),
 				'HI' => array(
					'code' => 'HI',
 					'name' => 'Ḩimş',
 				),
 				'HL' => array(
					'code' => 'HL',
 					'name' => 'Ḩalab',
 				),
 				'HM' => array(
					'code' => 'HM',
 					'name' => 'Ḩamāh',
 				),
 				'ID' => array(
					'code' => 'ID',
 					'name' => 'Idlib',
 				),
 				'LA' => array(
					'code' => 'LA',
 					'name' => 'Al Lādhiqīyah',
 				),
 				'QU' => array(
					'code' => 'QU',
 					'name' => 'Al Qunayţirah',
 				),
 				'RA' => array(
					'code' => 'RA',
 					'name' => 'Ar Raqqah',
 				),
 				'RD' => array(
					'code' => 'RD',
 					'name' => 'Rīf Dimashq',
 				),
 				'SU' => array(
					'code' => 'SU',
 					'name' => 'As Suwaydā\'',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Ţarţūs',
 				),
 			),
 		),
 		'SZ' => array(
			'code' => 'SZ',
 			'name' => 'Swaziland',
 			'code3' => 'SWZ',
 			'numeric' => '748',
 			'states' => array(
				'HH' => array(
					'code' => 'HH',
 					'name' => 'Hhohho',
 				),
 				'LU' => array(
					'code' => 'LU',
 					'name' => 'Lubombo',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Manzini',
 				),
 				'SH' => array(
					'code' => 'SH',
 					'name' => 'Shiselweni',
 				),
 			),
 		),
 		'TC' => array(
			'code' => 'TC',
 			'name' => 'Turks & Caicos Islands',
 			'code3' => 'TCA',
 			'numeric' => '796',
 			'states' => array(
			),
 		),
 		'TD' => array(
			'code' => 'TD',
 			'name' => 'Chad',
 			'code3' => 'TCD',
 			'numeric' => '148',
 			'states' => array(
				'BA' => array(
					'code' => 'BA',
 					'name' => 'Batha',
 				),
 				'BET' => array(
					'code' => 'BET',
 					'name' => 'Borkou-Ennedi-Tibesti',
 				),
 				'BI' => array(
					'code' => 'BI',
 					'name' => 'Biltine',
 				),
 				'CB' => array(
					'code' => 'CB',
 					'name' => 'Chari-Baguirmi',
 				),
 				'GR' => array(
					'code' => 'GR',
 					'name' => 'Guéra',
 				),
 				'KA' => array(
					'code' => 'KA',
 					'name' => 'Kanem',
 				),
 				'LC' => array(
					'code' => 'LC',
 					'name' => 'Lac',
 				),
 				'LO' => array(
					'code' => 'LO',
 					'name' => 'Logone-Occidental',
 				),
 				'LR' => array(
					'code' => 'LR',
 					'name' => 'Logone-Oriental',
 				),
 				'MC' => array(
					'code' => 'MC',
 					'name' => 'Moyen-Chari',
 				),
 				'MK' => array(
					'code' => 'MK',
 					'name' => 'Mayo-Kébbi',
 				),
 				'OD' => array(
					'code' => 'OD',
 					'name' => 'Ouaddaï',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Salamat',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Tandjilé',
 				),
 			),
 		),
 		'TF' => array(
			'code' => 'TF',
 			'name' => 'French Southern Territories',
 			'code3' => 'ATF',
 			'numeric' => '260',
 			'states' => array(
			),
 		),
 		'TG' => array(
			'code' => 'TG',
 			'name' => 'Togo',
 			'code3' => 'TGO',
 			'numeric' => '768',
 			'states' => array(
				'C' => array(
					'code' => 'C',
 					'name' => 'Centre',
 				),
 				'K' => array(
					'code' => 'K',
 					'name' => 'Kara',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'Maritime',
 				),
 				'P' => array(
					'code' => 'P',
 					'name' => 'Plateaux',
 				),
 				'S' => array(
					'code' => 'S',
 					'name' => 'Savannes',
 				),
 			),
 		),
 		'TH' => array(
			'code' => 'TH',
 			'name' => 'Thailand',
 			'code3' => 'THA',
 			'numeric' => '764',
 			'states' => array(
				'10' => array(
					'code' => '10',
 					'name' => 'Krung Thep Maha Nakhon [Bangkok]',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Samut Prakan',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Nonthaburi',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Pathum Thani',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Phra Nakhon Si Ayutthaya',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Ang Thong',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Lop Buri',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Sing Buri',
 				),
 				'18' => array(
					'code' => '18',
 					'name' => 'Chai Nat',
 				),
 				'19' => array(
					'code' => '19',
 					'name' => 'Saraburi',
 				),
 				'20' => array(
					'code' => '20',
 					'name' => 'Chon Buri',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Rayong',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Chanthaburi',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Trat',
 				),
 				'24' => array(
					'code' => '24',
 					'name' => 'Chachoengsao',
 				),
 				'25' => array(
					'code' => '25',
 					'name' => 'Prachin Buri',
 				),
 				'26' => array(
					'code' => '26',
 					'name' => 'Nakhon Nayok',
 				),
 				'27' => array(
					'code' => '27',
 					'name' => 'Sa Kaeo',
 				),
 				'30' => array(
					'code' => '30',
 					'name' => 'Nakhon Ratchasima',
 				),
 				'31' => array(
					'code' => '31',
 					'name' => 'Buri Ram',
 				),
 				'32' => array(
					'code' => '32',
 					'name' => 'Surin',
 				),
 				'33' => array(
					'code' => '33',
 					'name' => 'Si Sa Ket',
 				),
 				'34' => array(
					'code' => '34',
 					'name' => 'Ubon Ratchathani',
 				),
 				'35' => array(
					'code' => '35',
 					'name' => 'Yasothon',
 				),
 				'36' => array(
					'code' => '36',
 					'name' => 'Chaiyaphum',
 				),
 				'37' => array(
					'code' => '37',
 					'name' => 'Amnat Charoen',
 				),
 				'39' => array(
					'code' => '39',
 					'name' => 'Nong Bua Lam Phu',
 				),
 				'40' => array(
					'code' => '40',
 					'name' => 'Khon Kaen',
 				),
 				'41' => array(
					'code' => '41',
 					'name' => 'Udon Thani',
 				),
 				'42' => array(
					'code' => '42',
 					'name' => 'Loei',
 				),
 				'43' => array(
					'code' => '43',
 					'name' => 'Nong Khai',
 				),
 				'44' => array(
					'code' => '44',
 					'name' => 'Maha Sarakham',
 				),
 				'45' => array(
					'code' => '45',
 					'name' => 'Roi Et',
 				),
 				'46' => array(
					'code' => '46',
 					'name' => 'Kalasin',
 				),
 				'47' => array(
					'code' => '47',
 					'name' => 'Sakon Nakhon',
 				),
 				'48' => array(
					'code' => '48',
 					'name' => 'Nakhon Phanom',
 				),
 				'49' => array(
					'code' => '49',
 					'name' => 'Mukdahan',
 				),
 				'50' => array(
					'code' => '50',
 					'name' => 'Chiang Mai',
 				),
 				'51' => array(
					'code' => '51',
 					'name' => 'Lamphun',
 				),
 				'52' => array(
					'code' => '52',
 					'name' => 'Lampang',
 				),
 				'53' => array(
					'code' => '53',
 					'name' => 'Uttaradit',
 				),
 				'54' => array(
					'code' => '54',
 					'name' => 'Phrae',
 				),
 				'55' => array(
					'code' => '55',
 					'name' => 'Nan',
 				),
 				'56' => array(
					'code' => '56',
 					'name' => 'Phayao',
 				),
 				'57' => array(
					'code' => '57',
 					'name' => 'Chiang Rai',
 				),
 				'58' => array(
					'code' => '58',
 					'name' => 'Mae Hong Son',
 				),
 				'60' => array(
					'code' => '60',
 					'name' => 'Nakhon Sawan',
 				),
 				'61' => array(
					'code' => '61',
 					'name' => 'Uthai Thani',
 				),
 				'62' => array(
					'code' => '62',
 					'name' => 'Kamphaeng Phet',
 				),
 				'63' => array(
					'code' => '63',
 					'name' => 'Tak',
 				),
 				'64' => array(
					'code' => '64',
 					'name' => 'Sukhothai',
 				),
 				'65' => array(
					'code' => '65',
 					'name' => 'Phitsanulok',
 				),
 				'66' => array(
					'code' => '66',
 					'name' => 'Phichit',
 				),
 				'67' => array(
					'code' => '67',
 					'name' => 'Phetchabun',
 				),
 				'70' => array(
					'code' => '70',
 					'name' => 'Ratchaburi',
 				),
 				'71' => array(
					'code' => '71',
 					'name' => 'Kanchanaburi',
 				),
 				'72' => array(
					'code' => '72',
 					'name' => 'Suphan Buri',
 				),
 				'73' => array(
					'code' => '73',
 					'name' => 'Nakhon Pathom',
 				),
 				'74' => array(
					'code' => '74',
 					'name' => 'Samut Sakhon',
 				),
 				'75' => array(
					'code' => '75',
 					'name' => 'Samut Songkhram',
 				),
 				'76' => array(
					'code' => '76',
 					'name' => 'Phetchaburi',
 				),
 				'77' => array(
					'code' => '77',
 					'name' => 'Prachuap Khiri Khan',
 				),
 				'80' => array(
					'code' => '80',
 					'name' => 'Nakhon Si Thammarat',
 				),
 				'81' => array(
					'code' => '81',
 					'name' => 'Krabi',
 				),
 				'82' => array(
					'code' => '82',
 					'name' => 'Phangnga',
 				),
 				'83' => array(
					'code' => '83',
 					'name' => 'Phuket',
 				),
 				'84' => array(
					'code' => '84',
 					'name' => 'Surat Thani',
 				),
 				'85' => array(
					'code' => '85',
 					'name' => 'Ranong',
 				),
 				'86' => array(
					'code' => '86',
 					'name' => 'Chumphon',
 				),
 				'90' => array(
					'code' => '90',
 					'name' => 'Songkhla',
 				),
 				'91' => array(
					'code' => '91',
 					'name' => 'Satun',
 				),
 				'92' => array(
					'code' => '92',
 					'name' => 'Trang',
 				),
 				'93' => array(
					'code' => '93',
 					'name' => 'Phatthalung',
 				),
 				'94' => array(
					'code' => '94',
 					'name' => 'Pattani',
 				),
 				'95' => array(
					'code' => '95',
 					'name' => 'Yala',
 				),
 				'96' => array(
					'code' => '96',
 					'name' => 'Narathiwat',
 				),
 				'S' => array(
					'code' => 'S',
 					'name' => 'Phatthaya',
 				),
 			),
 		),
 		'TJ' => array(
			'code' => 'TJ',
 			'name' => 'Tajikistan',
 			'code3' => 'TJK',
 			'numeric' => '762',
 			'states' => array(
				'GB' => array(
					'code' => 'GB',
 					'name' => 'Gorno-Badakhshan',
 				),
 				'KR' => array(
					'code' => 'KR',
 					'name' => 'Karategin',
 				),
 				'KT' => array(
					'code' => 'KT',
 					'name' => 'Khatlon',
 				),
 				'LN' => array(
					'code' => 'LN',
 					'name' => 'Leninabad',
 				),
 			),
 		),
 		'TK' => array(
			'code' => 'TK',
 			'name' => 'Tokelau',
 			'code3' => 'TKL',
 			'numeric' => '772',
 			'states' => array(
			),
 		),
 		'TM' => array(
			'code' => 'TM',
 			'name' => 'Turkmenistan',
 			'code3' => 'TKM',
 			'numeric' => '795',
 			'states' => array(
				'A' => array(
					'code' => 'A',
 					'name' => 'Ahal',
 				),
 				'B' => array(
					'code' => 'B',
 					'name' => 'Balkan',
 				),
 				'D' => array(
					'code' => 'D',
 					'name' => 'Daşhowuz',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'Lebap',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'Mary',
 				),
 			),
 		),
 		'TN' => array(
			'code' => 'TN',
 			'name' => 'Tunisia',
 			'code3' => 'TUN',
 			'numeric' => '788',
 			'states' => array(
				'11' => array(
					'code' => '11',
 					'name' => 'Tunis',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'L\'Ariana',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Ben Arous',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Nabeul',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Zaghouan',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Bizerte',
 				),
 				'31' => array(
					'code' => '31',
 					'name' => 'Béja',
 				),
 				'32' => array(
					'code' => '32',
 					'name' => 'Jendouba',
 				),
 				'33' => array(
					'code' => '33',
 					'name' => 'Le Kef',
 				),
 				'34' => array(
					'code' => '34',
 					'name' => 'Siliana',
 				),
 				'41' => array(
					'code' => '41',
 					'name' => 'Kairouan',
 				),
 				'42' => array(
					'code' => '42',
 					'name' => 'Kasserine',
 				),
 				'43' => array(
					'code' => '43',
 					'name' => 'Sidi Bouzid',
 				),
 				'51' => array(
					'code' => '51',
 					'name' => 'Sousse',
 				),
 				'52' => array(
					'code' => '52',
 					'name' => 'Monastir',
 				),
 				'53' => array(
					'code' => '53',
 					'name' => 'Mahdia',
 				),
 				'61' => array(
					'code' => '61',
 					'name' => 'Sfax',
 				),
 				'71' => array(
					'code' => '71',
 					'name' => 'Gafsa',
 				),
 				'72' => array(
					'code' => '72',
 					'name' => 'Tozeur',
 				),
 				'73' => array(
					'code' => '73',
 					'name' => 'Kebili',
 				),
 				'81' => array(
					'code' => '81',
 					'name' => 'Gabès',
 				),
 				'82' => array(
					'code' => '82',
 					'name' => 'Medenine',
 				),
 				'83' => array(
					'code' => '83',
 					'name' => 'Tataouine',
 				),
 			),
 		),
 		'TO' => array(
			'code' => 'TO',
 			'name' => 'Tonga',
 			'code3' => 'TON',
 			'numeric' => '776',
 			'states' => array(
			),
 		),
 		'TP' => array(
			'code' => 'TP',
 			'name' => 'East Timor',
 			'code3' => 'TMP',
 			'numeric' => '',
 			'states' => array(
			),
 		),
 		'TR' => array(
			'code' => 'TR',
 			'name' => 'Turkey',
 			'code3' => 'TUR',
 			'numeric' => '792',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Adana',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Adiyaman',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Afyon',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Ağrı',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Amasya',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Ankara',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Antalya',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Artvin',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Aydin',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Balıkesir',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Bilecik',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Bingöl',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Bitlis',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Bolu',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Burdur',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Bursa',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Çanakkale',
 				),
 				'18' => array(
					'code' => '18',
 					'name' => 'Çankırı',
 				),
 				'19' => array(
					'code' => '19',
 					'name' => 'Çorum',
 				),
 				'20' => array(
					'code' => '20',
 					'name' => 'Denizli',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Diyarbakır',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Edirne',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Elaziğ',
 				),
 				'24' => array(
					'code' => '24',
 					'name' => 'Erzincan',
 				),
 				'25' => array(
					'code' => '25',
 					'name' => 'Erzurum',
 				),
 				'26' => array(
					'code' => '26',
 					'name' => 'Eskişehir',
 				),
 				'27' => array(
					'code' => '27',
 					'name' => 'Gaziantep',
 				),
 				'28' => array(
					'code' => '28',
 					'name' => 'Giresun',
 				),
 				'29' => array(
					'code' => '29',
 					'name' => 'Gümüşhane',
 				),
 				'30' => array(
					'code' => '30',
 					'name' => 'Hakkari',
 				),
 				'31' => array(
					'code' => '31',
 					'name' => 'Hatay',
 				),
 				'32' => array(
					'code' => '32',
 					'name' => 'Isparta',
 				),
 				'33' => array(
					'code' => '33',
 					'name' => 'İçel',
 				),
 				'34' => array(
					'code' => '34',
 					'name' => 'İstanbul',
 				),
 				'35' => array(
					'code' => '35',
 					'name' => 'İzmir',
 				),
 				'36' => array(
					'code' => '36',
 					'name' => 'Kars',
 				),
 				'37' => array(
					'code' => '37',
 					'name' => 'Kastamonu',
 				),
 				'38' => array(
					'code' => '38',
 					'name' => 'Kayseri',
 				),
 				'39' => array(
					'code' => '39',
 					'name' => 'Kırklareli',
 				),
 				'40' => array(
					'code' => '40',
 					'name' => 'Kırşehir',
 				),
 				'41' => array(
					'code' => '41',
 					'name' => 'Kocaeli',
 				),
 				'42' => array(
					'code' => '42',
 					'name' => 'Konya',
 				),
 				'43' => array(
					'code' => '43',
 					'name' => 'Kütahya',
 				),
 				'44' => array(
					'code' => '44',
 					'name' => 'Malatya',
 				),
 				'46' => array(
					'code' => '46',
 					'name' => 'Kahramanmaraş',
 				),
 				'47' => array(
					'code' => '47',
 					'name' => 'Mardin',
 				),
 				'48' => array(
					'code' => '48',
 					'name' => 'Muğla',
 				),
 				'49' => array(
					'code' => '49',
 					'name' => 'Muş',
 				),
 				'4S' => array(
					'code' => '4S',
 					'name' => 'Manisa',
 				),
 				'51' => array(
					'code' => '51',
 					'name' => 'Niğde',
 				),
 				'52' => array(
					'code' => '52',
 					'name' => 'Ordu',
 				),
 				'53' => array(
					'code' => '53',
 					'name' => 'Rize',
 				),
 				'54' => array(
					'code' => '54',
 					'name' => 'Sakarya',
 				),
 				'56' => array(
					'code' => '56',
 					'name' => 'Siirt',
 				),
 				'57' => array(
					'code' => '57',
 					'name' => 'Sinop',
 				),
 				'59' => array(
					'code' => '59',
 					'name' => 'Tekirdağ',
 				),
 				'60' => array(
					'code' => '60',
 					'name' => 'Tokat',
 				),
 				'61' => array(
					'code' => '61',
 					'name' => 'Trabzon',
 				),
 				'62' => array(
					'code' => '62',
 					'name' => 'Tunceli',
 				),
 				'63' => array(
					'code' => '63',
 					'name' => 'Şanlıurfa',
 				),
 				'64' => array(
					'code' => '64',
 					'name' => 'Uşak',
 				),
 				'65' => array(
					'code' => '65',
 					'name' => 'Van',
 				),
 				'66' => array(
					'code' => '66',
 					'name' => 'Yozgat',
 				),
 				'67' => array(
					'code' => '67',
 					'name' => 'Zonguldak',
 				),
 				'68' => array(
					'code' => '68',
 					'name' => 'Aksaray',
 				),
 				'69' => array(
					'code' => '69',
 					'name' => 'Bayburt',
 				),
 				'70' => array(
					'code' => '70',
 					'name' => 'Karaman',
 				),
 				'71' => array(
					'code' => '71',
 					'name' => 'Kırıkkale',
 				),
 				'72' => array(
					'code' => '72',
 					'name' => 'Batman',
 				),
 				'73' => array(
					'code' => '73',
 					'name' => 'Şirnak',
 				),
 				'74' => array(
					'code' => '74',
 					'name' => 'Bartın',
 				),
 				'75' => array(
					'code' => '75',
 					'name' => 'Ardahan',
 				),
 				'76' => array(
					'code' => '76',
 					'name' => 'Iğdir',
 				),
 				'77' => array(
					'code' => '77',
 					'name' => 'Yalova',
 				),
 				'78' => array(
					'code' => '78',
 					'name' => 'Karabük',
 				),
 				'79' => array(
					'code' => '79',
 					'name' => 'Kilis',
 				),
 				'S8' => array(
					'code' => 'S8',
 					'name' => 'Sivas',
 				),
 				'SO' => array(
					'code' => 'SO',
 					'name' => 'Nevşehir',
 				),
 				'SS' => array(
					'code' => 'SS',
 					'name' => 'Samsun',
 				),
 			),
 		),
 		'TT' => array(
			'code' => 'TT',
 			'name' => 'Trinidad & Tobago',
 			'code3' => 'TTO',
 			'numeric' => '780',
 			'states' => array(
				'ARI' => array(
					'code' => 'ARI',
 					'name' => 'Arima',
 				),
 				'CHA' => array(
					'code' => 'CHA',
 					'name' => 'Chaguanas',
 				),
 				'CTT' => array(
					'code' => 'CTT',
 					'name' => 'Couva-Tabaquite-Talparo',
 				),
 				'DMN' => array(
					'code' => 'DMN',
 					'name' => 'Diego Martin',
 				),
 				'ETO' => array(
					'code' => 'ETO',
 					'name' => 'Eastern Tobago',
 				),
 				'PED' => array(
					'code' => 'PED',
 					'name' => 'Penal-Debe',
 				),
 				'POS' => array(
					'code' => 'POS',
 					'name' => 'Port of Spain',
 				),
 				'PRT' => array(
					'code' => 'PRT',
 					'name' => 'Princes Town',
 				),
 				'PTF' => array(
					'code' => 'PTF',
 					'name' => 'Point Fortin',
 				),
 				'RCM' => array(
					'code' => 'RCM',
 					'name' => 'Rio Claro-Mayaro',
 				),
 				'SFO' => array(
					'code' => 'SFO',
 					'name' => 'San Fernando',
 				),
 				'SGE' => array(
					'code' => 'SGE',
 					'name' => 'Sangre Grande',
 				),
 				'SIP' => array(
					'code' => 'SIP',
 					'name' => 'Siparia',
 				),
 				'SJL' => array(
					'code' => 'SJL',
 					'name' => 'San Juan-Laventille',
 				),
 				'TUP' => array(
					'code' => 'TUP',
 					'name' => 'Tunapuna-Piarco',
 				),
 				'WTO' => array(
					'code' => 'WTO',
 					'name' => 'Western Tobago',
 				),
 			),
 		),
 		'TV' => array(
			'code' => 'TV',
 			'name' => 'Tuvalu',
 			'code3' => 'TUV',
 			'numeric' => '798',
 			'states' => array(
			),
 		),
 		'TW' => array(
			'code' => 'TW',
 			'name' => 'Taiwan',
 			'code3' => 'TWN',
 			'numeric' => '158',
 			'states' => array(
				'CHA' => array(
					'code' => 'CHA',
 					'name' => 'Changhua',
 				),
 				'CYI' => array(
					'code' => 'CYI',
 					'name' => 'Chiayi',
 				),
 				'HSZ' => array(
					'code' => 'HSZ',
 					'name' => 'Hsinchu',
 				),
 				'HUA' => array(
					'code' => 'HUA',
 					'name' => 'Hualien',
 				),
 				'ILA' => array(
					'code' => 'ILA',
 					'name' => 'Ilan',
 				),
 				'KEE' => array(
					'code' => 'KEE',
 					'name' => 'Keelung',
 				),
 				'KHH' => array(
					'code' => 'KHH',
 					'name' => 'Kaohsiung',
 				),
 				'MIA' => array(
					'code' => 'MIA',
 					'name' => 'Miaoli',
 				),
 				'NAN' => array(
					'code' => 'NAN',
 					'name' => 'Nantou',
 				),
 				'PEN' => array(
					'code' => 'PEN',
 					'name' => 'Penghu',
 				),
 				'PIF' => array(
					'code' => 'PIF',
 					'name' => 'Pingtung',
 				),
 				'TAO' => array(
					'code' => 'TAO',
 					'name' => 'Taoyuan',
 				),
 				'TNN' => array(
					'code' => 'TNN',
 					'name' => 'Tainan',
 				),
 				'TPE' => array(
					'code' => 'TPE',
 					'name' => 'Taipei',
 				),
 				'TTT' => array(
					'code' => 'TTT',
 					'name' => 'Taitung',
 				),
 				'TXG' => array(
					'code' => 'TXG',
 					'name' => 'Taichung',
 				),
 				'YUN' => array(
					'code' => 'YUN',
 					'name' => 'Yunlin',
 				),
 			),
 		),
 		'TZ' => array(
			'code' => 'TZ',
 			'name' => 'Tanzania',
 			'code3' => 'TZA',
 			'numeric' => '834',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Arusha',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Dar-es-Salaam',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Dodoma',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Iringa',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Kagera',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Kaskazini Pemba',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Kaskazini Unguja',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Kigoma',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Kilimanjaro',
 				),
 				'10' => array(
					'code' => '10',
 					'name' => 'Kusini Pemba',
 				),
 				'11' => array(
					'code' => '11',
 					'name' => 'Kusini Unguja',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Lindi',
 				),
 				'13' => array(
					'code' => '13',
 					'name' => 'Mara',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Mbeya',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Mjini Magharibi',
 				),
 				'16' => array(
					'code' => '16',
 					'name' => 'Morogoro',
 				),
 				'17' => array(
					'code' => '17',
 					'name' => 'Mtwara',
 				),
 				'18' => array(
					'code' => '18',
 					'name' => 'Mwanza',
 				),
 				'19' => array(
					'code' => '19',
 					'name' => 'Pwani',
 				),
 				'20' => array(
					'code' => '20',
 					'name' => 'Rukwa',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Ruvuma',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Shinyanga',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Singida',
 				),
 				'24' => array(
					'code' => '24',
 					'name' => 'Tabora',
 				),
 				'25' => array(
					'code' => '25',
 					'name' => 'Tanga',
 				),
 			),
 		),
 		'UA' => array(
			'code' => 'UA',
 			'name' => 'Ukraine',
 			'code3' => 'UKR',
 			'numeric' => '804',
 			'states' => array(
				'05' => array(
					'code' => '05',
 					'name' => 'Vinnyts\'ka Oblast\'',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Volyns\'ka Oblast\'',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Luhans\'ka Oblast\'',
 				),
 				'12' => array(
					'code' => '12',
 					'name' => 'Dnipropetrovs\'ka Oblast\'',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Donets\'ka Oblast\'',
 				),
 				'18' => array(
					'code' => '18',
 					'name' => 'Zhytomyrs\'ka Oblast\'',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Zakarpats\'ka Oblast\'',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Zaporiz\'ka Oblast\'',
 				),
 				'26' => array(
					'code' => '26',
 					'name' => 'Ivano-Frankivs\'ka Oblast\'',
 				),
 				'30' => array(
					'code' => '30',
 					'name' => 'Kyïv',
 				),
 				'32' => array(
					'code' => '32',
 					'name' => 'Kyïvs\'ka Oblast\'',
 				),
 				'35' => array(
					'code' => '35',
 					'name' => 'Kirovohrads\'ka Oblast\'',
 				),
 				'40' => array(
					'code' => '40',
 					'name' => 'Sevastopol\'',
 				),
 				'43' => array(
					'code' => '43',
 					'name' => 'Respublika Krym',
 				),
 				'46' => array(
					'code' => '46',
 					'name' => 'L\'vivs\'ka Oblast\'',
 				),
 				'48' => array(
					'code' => '48',
 					'name' => 'Mykolaïvs\'ka Oblast\'',
 				),
 				'51' => array(
					'code' => '51',
 					'name' => 'Odes\'ka Oblast\'',
 				),
 				'53' => array(
					'code' => '53',
 					'name' => 'Poltavs\'ka Oblast\'',
 				),
 				'56' => array(
					'code' => '56',
 					'name' => 'Rivnens\'ka Oblast\'',
 				),
 				'59' => array(
					'code' => '59',
 					'name' => 'Sums\'ka Oblast\'',
 				),
 				'61' => array(
					'code' => '61',
 					'name' => 'Ternopil\'s\'ka Oblast\'',
 				),
 				'63' => array(
					'code' => '63',
 					'name' => 'Kharkivs\'ka Oblast\'',
 				),
 				'65' => array(
					'code' => '65',
 					'name' => 'Khersons\'ka Oblast\'',
 				),
 				'68' => array(
					'code' => '68',
 					'name' => 'Khmel\'nyts\'ka Oblast\'',
 				),
 				'71' => array(
					'code' => '71',
 					'name' => 'Cherkas\'ka Oblast\'',
 				),
 				'74' => array(
					'code' => '74',
 					'name' => 'Chernihivs\'ka Oblast\'',
 				),
 				'77' => array(
					'code' => '77',
 					'name' => 'Chernivets\'ka Oblast\'',
 				),
 			),
 		),
 		'UG' => array(
			'code' => 'UG',
 			'name' => 'Uganda',
 			'code3' => 'UGA',
 			'numeric' => '800',
 			'states' => array(
				'APA' => array(
					'code' => 'APA',
 					'name' => 'Apac',
 				),
 				'ARU' => array(
					'code' => 'ARU',
 					'name' => 'Arua',
 				),
 				'BUN' => array(
					'code' => 'BUN',
 					'name' => 'Bundibugyo',
 				),
 				'BUS' => array(
					'code' => 'BUS',
 					'name' => 'Bushenyi',
 				),
 				'GUL' => array(
					'code' => 'GUL',
 					'name' => 'Gulu',
 				),
 				'HOI' => array(
					'code' => 'HOI',
 					'name' => 'Hoima',
 				),
 				'IGA' => array(
					'code' => 'IGA',
 					'name' => 'Iganga',
 				),
 				'JIN' => array(
					'code' => 'JIN',
 					'name' => 'Jinja',
 				),
 				'KAP' => array(
					'code' => 'KAP',
 					'name' => 'Kapchorwa',
 				),
 				'KAS' => array(
					'code' => 'KAS',
 					'name' => 'Kasese',
 				),
 				'KBL' => array(
					'code' => 'KBL',
 					'name' => 'Kabale',
 				),
 				'KBR' => array(
					'code' => 'KBR',
 					'name' => 'Kabarole',
 				),
 				'KIB' => array(
					'code' => 'KIB',
 					'name' => 'Kiboga',
 				),
 				'KIS' => array(
					'code' => 'KIS',
 					'name' => 'Kisoro',
 				),
 				'KIT' => array(
					'code' => 'KIT',
 					'name' => 'Kitgum',
 				),
 				'KLA' => array(
					'code' => 'KLA',
 					'name' => 'Kampala',
 				),
 				'KLE' => array(
					'code' => 'KLE',
 					'name' => 'Kibaale',
 				),
 				'KLG' => array(
					'code' => 'KLG',
 					'name' => 'Kalangala',
 				),
 				'KLI' => array(
					'code' => 'KLI',
 					'name' => 'Kamuli',
 				),
 				'KOT' => array(
					'code' => 'KOT',
 					'name' => 'Kotido',
 				),
 				'KUM' => array(
					'code' => 'KUM',
 					'name' => 'Kumi',
 				),
 				'LIR' => array(
					'code' => 'LIR',
 					'name' => 'Lira',
 				),
 				'LUW' => array(
					'code' => 'LUW',
 					'name' => 'Luwero',
 				),
 				'MBL' => array(
					'code' => 'MBL',
 					'name' => 'Mbale',
 				),
 				'MBR' => array(
					'code' => 'MBR',
 					'name' => 'Mbarara',
 				),
 				'MOR' => array(
					'code' => 'MOR',
 					'name' => 'Moroto',
 				),
 				'MOY' => array(
					'code' => 'MOY',
 					'name' => 'Moyo',
 				),
 				'MPI' => array(
					'code' => 'MPI',
 					'name' => 'Mpigi',
 				),
 				'MSI' => array(
					'code' => 'MSI',
 					'name' => 'Masindi',
 				),
 				'MSK' => array(
					'code' => 'MSK',
 					'name' => 'Masaka',
 				),
 				'MUB' => array(
					'code' => 'MUB',
 					'name' => 'Mubende',
 				),
 				'MUK' => array(
					'code' => 'MUK',
 					'name' => 'Mukono',
 				),
 				'NEB' => array(
					'code' => 'NEB',
 					'name' => 'Nebbi',
 				),
 				'NTU' => array(
					'code' => 'NTU',
 					'name' => 'Ntungamo',
 				),
 				'PAL' => array(
					'code' => 'PAL',
 					'name' => 'Pallisa',
 				),
 				'RAK' => array(
					'code' => 'RAK',
 					'name' => 'Rakai',
 				),
 				'RUK' => array(
					'code' => 'RUK',
 					'name' => 'Rukungiri',
 				),
 				'SOR' => array(
					'code' => 'SOR',
 					'name' => 'Soroti',
 				),
 				'TOR' => array(
					'code' => 'TOR',
 					'name' => 'Tororo',
 				),
 			),
 		),
 		'US' => array(
			'code' => 'US',
 			'name' => 'United States',
 			'code3' => 'USA',
 			'numeric' => '840',
 			'states' => array(
				'AK' => array(
					'code' => 'AK',
 					'name' => 'Alaska',
 				),
 				'AL' => array(
					'code' => 'AL',
 					'name' => 'Alabama',
 				),
 				'AR' => array(
					'code' => 'AR',
 					'name' => 'Arkansas',
 				),
 				'AS' => array(
					'code' => 'AS',
 					'name' => 'American Samoa',
 				),
 				'AZ' => array(
					'code' => 'AZ',
 					'name' => 'Arizona',
 				),
 				'CA' => array(
					'code' => 'CA',
 					'name' => 'California',
 				),
 				'CO' => array(
					'code' => 'CO',
 					'name' => 'Colorado',
 				),
 				'CT' => array(
					'code' => 'CT',
 					'name' => 'Connecticut',
 				),
 				'DC' => array(
					'code' => 'DC',
 					'name' => 'District of Columbia',
 				),
 				'DE' => array(
					'code' => 'DE',
 					'name' => 'Delaware',
 				),
 				'FL' => array(
					'code' => 'FL',
 					'name' => 'Florida',
 				),
 				'GA' => array(
					'code' => 'GA',
 					'name' => 'Georgia',
 				),
 				'GU' => array(
					'code' => 'GU',
 					'name' => 'Guam',
 				),
 				'HI' => array(
					'code' => 'HI',
 					'name' => 'Hawaii',
 				),
 				'IA' => array(
					'code' => 'IA',
 					'name' => 'Iowa',
 				),
 				'ID' => array(
					'code' => 'ID',
 					'name' => 'Idaho',
 				),
 				'IL' => array(
					'code' => 'IL',
 					'name' => 'Illinois',
 				),
 				'IN' => array(
					'code' => 'IN',
 					'name' => 'Indiana',
 				),
 				'KS' => array(
					'code' => 'KS',
 					'name' => 'Kansas',
 				),
 				'KY' => array(
					'code' => 'KY',
 					'name' => 'Kentucky',
 				),
 				'LA' => array(
					'code' => 'LA',
 					'name' => 'Louisiana',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Massachusetts',
 				),
 				'MD' => array(
					'code' => 'MD',
 					'name' => 'Maryland',
 				),
 				'ME' => array(
					'code' => 'ME',
 					'name' => 'Maine',
 				),
 				'MI' => array(
					'code' => 'MI',
 					'name' => 'Michigan',
 				),
 				'MN' => array(
					'code' => 'MN',
 					'name' => 'Minnesota',
 				),
 				'MO' => array(
					'code' => 'MO',
 					'name' => 'Missouri',
 				),
 				'MP' => array(
					'code' => 'MP',
 					'name' => 'Northern Mariana Islands',
 				),
 				'MS' => array(
					'code' => 'MS',
 					'name' => 'Mississippi',
 				),
 				'MT' => array(
					'code' => 'MT',
 					'name' => 'Montana',
 				),
 				'NC' => array(
					'code' => 'NC',
 					'name' => 'North Carolina',
 				),
 				'ND' => array(
					'code' => 'ND',
 					'name' => 'North Dakota',
 				),
 				'NE' => array(
					'code' => 'NE',
 					'name' => 'Nebraska',
 				),
 				'NH' => array(
					'code' => 'NH',
 					'name' => 'New Hampshire',
 				),
 				'NJ' => array(
					'code' => 'NJ',
 					'name' => 'New Jersey',
 				),
 				'NM' => array(
					'code' => 'NM',
 					'name' => 'New Mexico',
 				),
 				'NV' => array(
					'code' => 'NV',
 					'name' => 'Nevada',
 				),
 				'NY' => array(
					'code' => 'NY',
 					'name' => 'New York',
 				),
 				'OH' => array(
					'code' => 'OH',
 					'name' => 'Ohio',
 				),
 				'OK' => array(
					'code' => 'OK',
 					'name' => 'Oklahoma',
 				),
 				'OR' => array(
					'code' => 'OR',
 					'name' => 'Oregon',
 				),
 				'PA' => array(
					'code' => 'PA',
 					'name' => 'Pennsylvania',
 				),
 				'PR' => array(
					'code' => 'PR',
 					'name' => 'Puerto Rico',
 				),
 				'RI' => array(
					'code' => 'RI',
 					'name' => 'Rhode Island',
 				),
 				'SC' => array(
					'code' => 'SC',
 					'name' => 'South Carolina',
 				),
 				'SD' => array(
					'code' => 'SD',
 					'name' => 'South Dakota',
 				),
 				'TN' => array(
					'code' => 'TN',
 					'name' => 'Tennessee',
 				),
 				'TX' => array(
					'code' => 'TX',
 					'name' => 'Texas',
 				),
 				'UM' => array(
					'code' => 'UM',
 					'name' => 'United States Minor Outlying Islands',
 				),
 				'UT' => array(
					'code' => 'UT',
 					'name' => 'Utah',
 				),
 				'VA' => array(
					'code' => 'VA',
 					'name' => 'Virginia',
 				),
 				'VI' => array(
					'code' => 'VI',
 					'name' => 'Virgin Islands, U.S.',
 				),
 				'VT' => array(
					'code' => 'VT',
 					'name' => 'Vermont',
 				),
 				'WA' => array(
					'code' => 'WA',
 					'name' => 'Washington',
 				),
 				'WI' => array(
					'code' => 'WI',
 					'name' => 'Wisconsin',
 				),
 				'WV' => array(
					'code' => 'WV',
 					'name' => 'West Virginia',
 				),
 				'WY' => array(
					'code' => 'WY',
 					'name' => 'Wyoming',
 				),
 			),
 		),
 		'UY' => array(
			'code' => 'UY',
 			'name' => 'Uruguay',
 			'code3' => 'URY',
 			'numeric' => '858',
 			'states' => array(
				'AR' => array(
					'code' => 'AR',
 					'name' => 'Artigas',
 				),
 				'CA' => array(
					'code' => 'CA',
 					'name' => 'Canelones',
 				),
 				'CL' => array(
					'code' => 'CL',
 					'name' => 'Cerro Largo',
 				),
 				'CO' => array(
					'code' => 'CO',
 					'name' => 'Colonia',
 				),
 				'DU' => array(
					'code' => 'DU',
 					'name' => 'Durazno',
 				),
 				'FD' => array(
					'code' => 'FD',
 					'name' => 'Florida',
 				),
 				'FS' => array(
					'code' => 'FS',
 					'name' => 'Flores',
 				),
 				'LA' => array(
					'code' => 'LA',
 					'name' => 'Lavalleja',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Maldonado',
 				),
 				'MO' => array(
					'code' => 'MO',
 					'name' => 'Montevideo',
 				),
 				'PA' => array(
					'code' => 'PA',
 					'name' => 'Paysandú',
 				),
 				'RN' => array(
					'code' => 'RN',
 					'name' => 'Río Negro',
 				),
 				'RO' => array(
					'code' => 'RO',
 					'name' => 'Rocha',
 				),
 				'RV' => array(
					'code' => 'RV',
 					'name' => 'Rivera',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Salto',
 				),
 				'SJ' => array(
					'code' => 'SJ',
 					'name' => 'San José',
 				),
 				'SO' => array(
					'code' => 'SO',
 					'name' => 'Soriano',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Tacuarembó',
 				),
 				'TT' => array(
					'code' => 'TT',
 					'name' => 'Treinta y Tres',
 				),
 			),
 		),
 		'UZ' => array(
			'code' => 'UZ',
 			'name' => 'Uzbekistan',
 			'code3' => 'UZB',
 			'numeric' => '860',
 			'states' => array(
				'AN' => array(
					'code' => 'AN',
 					'name' => 'Andijon',
 				),
 				'BU' => array(
					'code' => 'BU',
 					'name' => 'Bukhoro',
 				),
 				'FA' => array(
					'code' => 'FA',
 					'name' => 'Farghona',
 				),
 				'JI' => array(
					'code' => 'JI',
 					'name' => 'Jizzakh',
 				),
 				'KH' => array(
					'code' => 'KH',
 					'name' => 'Khorazm',
 				),
 				'NG' => array(
					'code' => 'NG',
 					'name' => 'Namangan',
 				),
 				'NW' => array(
					'code' => 'NW',
 					'name' => 'Nawoiy',
 				),
 				'QA' => array(
					'code' => 'QA',
 					'name' => 'Qashqadaryo',
 				),
 				'QR' => array(
					'code' => 'QR',
 					'name' => 'Qoraqalpoghiston Respublikasi',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Samarqand',
 				),
 				'SI' => array(
					'code' => 'SI',
 					'name' => 'Sirdaryo',
 				),
 				'SU' => array(
					'code' => 'SU',
 					'name' => 'Surkhondaryo',
 				),
 				'TO' => array(
					'code' => 'TO',
 					'name' => 'Toshkent',
 				),
 			),
 		),
 		'VA' => array(
			'code' => 'VA',
 			'name' => 'Vatican City',
 			'code3' => 'VAT',
 			'numeric' => '336',
 			'states' => array(
			),
 		),
 		'VC' => array(
			'code' => 'VC',
 			'name' => 'St. Vincent & the Grenadines',
 			'code3' => 'VCT',
 			'numeric' => '670',
 			'states' => array(
			),
 		),
 		'VE' => array(
			'code' => 'VE',
 			'name' => 'Venezuela',
 			'code3' => 'VEN',
 			'numeric' => '862',
 			'states' => array(
				'A' => array(
					'code' => 'A',
 					'name' => 'Distrito Federal',
 				),
 				'B' => array(
					'code' => 'B',
 					'name' => 'Anzoátegui',
 				),
 				'C' => array(
					'code' => 'C',
 					'name' => 'Apure',
 				),
 				'D' => array(
					'code' => 'D',
 					'name' => 'Aragua',
 				),
 				'E' => array(
					'code' => 'E',
 					'name' => 'Barinas',
 				),
 				'F' => array(
					'code' => 'F',
 					'name' => 'Bolívar',
 				),
 				'G' => array(
					'code' => 'G',
 					'name' => 'Carabobo',
 				),
 				'H' => array(
					'code' => 'H',
 					'name' => 'Cojedes',
 				),
 				'I' => array(
					'code' => 'I',
 					'name' => 'Falcón',
 				),
 				'J' => array(
					'code' => 'J',
 					'name' => 'Guárico',
 				),
 				'K' => array(
					'code' => 'K',
 					'name' => 'Lara',
 				),
 				'L' => array(
					'code' => 'L',
 					'name' => 'Mérida',
 				),
 				'M' => array(
					'code' => 'M',
 					'name' => 'Miranda',
 				),
 				'N' => array(
					'code' => 'N',
 					'name' => 'Monagas',
 				),
 				'O' => array(
					'code' => 'O',
 					'name' => 'Nueva Esparta',
 				),
 				'P' => array(
					'code' => 'P',
 					'name' => 'Portuguesa',
 				),
 				'R' => array(
					'code' => 'R',
 					'name' => 'Sucre',
 				),
 				'S' => array(
					'code' => 'S',
 					'name' => 'Táchira',
 				),
 				'T' => array(
					'code' => 'T',
 					'name' => 'Trujillo',
 				),
 				'U' => array(
					'code' => 'U',
 					'name' => 'Yaracuy',
 				),
 				'V' => array(
					'code' => 'V',
 					'name' => 'Zulia',
 				),
 				'W' => array(
					'code' => 'W',
 					'name' => 'Dependencias Federales',
 				),
 				'Y' => array(
					'code' => 'Y',
 					'name' => 'Delta Amacuro',
 				),
 				'Z' => array(
					'code' => 'Z',
 					'name' => 'Amazonas',
 				),
 			),
 		),
 		'VG' => array(
			'code' => 'VG',
 			'name' => 'Virgin Islands',
 			'code3' => 'VGB',
 			'numeric' => '092',
 			'states' => array(
			),
 		),
 		'VI' => array(
			'code' => 'VI',
 			'name' => 'Virgin Islands',
 			'code3' => 'VIR',
 			'numeric' => '850',
 			'states' => array(
			),
 		),
 		'VN' => array(
			'code' => 'VN',
 			'name' => 'Viet Nam',
 			'code3' => 'VNM',
 			'numeric' => '704',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Lai Chau',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Lao Cai',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Ha Giang',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Cao Bang',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Son La',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'Yen Bai',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Tuyen Quang',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Lang Son',
 				),
 				'14' => array(
					'code' => '14',
 					'name' => 'Hoa Binh',
 				),
 				'15' => array(
					'code' => '15',
 					'name' => 'Ha Tay',
 				),
 				'18' => array(
					'code' => '18',
 					'name' => 'Ninh Binh',
 				),
 				'20' => array(
					'code' => '20',
 					'name' => 'Thai Binh',
 				),
 				'21' => array(
					'code' => '21',
 					'name' => 'Thanh Hoa',
 				),
 				'22' => array(
					'code' => '22',
 					'name' => 'Nghe An',
 				),
 				'23' => array(
					'code' => '23',
 					'name' => 'Ha Tinh',
 				),
 				'24' => array(
					'code' => '24',
 					'name' => 'Quang Ninh',
 				),
 				'25' => array(
					'code' => '25',
 					'name' => 'Quang Tri',
 				),
 				'26' => array(
					'code' => '26',
 					'name' => 'Thua Thien-Hue',
 				),
 				'27' => array(
					'code' => '27',
 					'name' => 'Quang Nam',
 				),
 				'28' => array(
					'code' => '28',
 					'name' => 'Kon Turn',
 				),
 				'29' => array(
					'code' => '29',
 					'name' => 'Quang Ngai',
 				),
 				'30' => array(
					'code' => '30',
 					'name' => 'Gia Lai',
 				),
 				'31' => array(
					'code' => '31',
 					'name' => 'Binh Dinh',
 				),
 				'32' => array(
					'code' => '32',
 					'name' => 'Phu Yen',
 				),
 				'33' => array(
					'code' => '33',
 					'name' => 'Dac Lac',
 				),
 				'34' => array(
					'code' => '34',
 					'name' => 'Khanh Hoa',
 				),
 				'35' => array(
					'code' => '35',
 					'name' => 'Lam Dong',
 				),
 				'36' => array(
					'code' => '36',
 					'name' => 'Ninh Thuan',
 				),
 				'37' => array(
					'code' => '37',
 					'name' => 'Tay Ninh',
 				),
 				'39' => array(
					'code' => '39',
 					'name' => 'Dong Nai',
 				),
 				'40' => array(
					'code' => '40',
 					'name' => 'Binh Thuan',
 				),
 				'41' => array(
					'code' => '41',
 					'name' => 'Long An',
 				),
 				'43' => array(
					'code' => '43',
 					'name' => 'Ba Ria - Vung Tau',
 				),
 				'44' => array(
					'code' => '44',
 					'name' => 'An Giang',
 				),
 				'45' => array(
					'code' => '45',
 					'name' => 'Dong Thap',
 				),
 				'46' => array(
					'code' => '46',
 					'name' => 'Tien Giang',
 				),
 				'47' => array(
					'code' => '47',
 					'name' => 'Kien Giang',
 				),
 				'48' => array(
					'code' => '48',
 					'name' => 'Can Tho',
 				),
 				'49' => array(
					'code' => '49',
 					'name' => 'Vinh Long',
 				),
 				'50' => array(
					'code' => '50',
 					'name' => 'Ben Tre',
 				),
 				'51' => array(
					'code' => '51',
 					'name' => 'Tra Vinh',
 				),
 				'52' => array(
					'code' => '52',
 					'name' => 'Sec Trang',
 				),
 				'53' => array(
					'code' => '53',
 					'name' => 'Bat Can',
 				),
 				'54' => array(
					'code' => '54',
 					'name' => 'Bat Giang',
 				),
 				'55' => array(
					'code' => '55',
 					'name' => 'Bat Lieu',
 				),
 				'56' => array(
					'code' => '56',
 					'name' => 'Bat Ninh',
 				),
 				'57' => array(
					'code' => '57',
 					'name' => 'Binh Duong',
 				),
 				'58' => array(
					'code' => '58',
 					'name' => 'Binh Phuoc',
 				),
 				'59' => array(
					'code' => '59',
 					'name' => 'Ca Mau',
 				),
 				'60' => array(
					'code' => '60',
 					'name' => 'Da Nang, thanh pho',
 				),
 				'61' => array(
					'code' => '61',
 					'name' => 'Hai Duong',
 				),
 				'62' => array(
					'code' => '62',
 					'name' => 'Hai Phong, thanh pho',
 				),
 				'63' => array(
					'code' => '63',
 					'name' => 'Ha Nam',
 				),
 				'64' => array(
					'code' => '64',
 					'name' => 'Ha Noi, thu do',
 				),
 				'65' => array(
					'code' => '65',
 					'name' => 'Ho Chi Minh, thanh po [Sai Gon]',
 				),
 				'66' => array(
					'code' => '66',
 					'name' => 'Hung Yen',
 				),
 				'67' => array(
					'code' => '67',
 					'name' => 'Nam Dinh',
 				),
 				'68' => array(
					'code' => '68',
 					'name' => 'Phu Tho',
 				),
 				'69' => array(
					'code' => '69',
 					'name' => 'Thai Nguyen',
 				),
 				'70' => array(
					'code' => '70',
 					'name' => 'Vinh Yen',
 				),
 			),
 		),
 		'VU' => array(
			'code' => 'VU',
 			'name' => 'Vanuatu',
 			'code3' => 'VUT',
 			'numeric' => '548',
 			'states' => array(
				'MAP' => array(
					'code' => 'MAP',
 					'name' => 'Malampa',
 				),
 				'PAM' => array(
					'code' => 'PAM',
 					'name' => 'Pénama',
 				),
 				'SAM' => array(
					'code' => 'SAM',
 					'name' => 'Sanma',
 				),
 				'SEE' => array(
					'code' => 'SEE',
 					'name' => 'Shéfa',
 				),
 				'TAE' => array(
					'code' => 'TAE',
 					'name' => 'Taféa',
 				),
 				'TOB' => array(
					'code' => 'TOB',
 					'name' => 'Torba',
 				),
 			),
 		),
 		'WF' => array(
			'code' => 'WF',
 			'name' => 'Wallis & Futuna Islands',
 			'code3' => 'WLF',
 			'numeric' => '876',
 			'states' => array(
			),
 		),
 		'WS' => array(
			'code' => 'WS',
 			'name' => 'Samoa',
 			'code3' => 'WSM',
 			'numeric' => '882',
 			'states' => array(
				'AA' => array(
					'code' => 'AA',
 					'name' => 'A\'ana',
 				),
 				'AL' => array(
					'code' => 'AL',
 					'name' => 'Aiga-i-le-Tai',
 				),
 				'AT' => array(
					'code' => 'AT',
 					'name' => 'Atua',
 				),
 				'FA' => array(
					'code' => 'FA',
 					'name' => 'Fa\'asaleleaga',
 				),
 				'GE' => array(
					'code' => 'GE',
 					'name' => 'Gaga\'emauga',
 				),
 				'GI' => array(
					'code' => 'GI',
 					'name' => 'Gagaifomauga',
 				),
 				'PA' => array(
					'code' => 'PA',
 					'name' => 'Palauli',
 				),
 				'SA' => array(
					'code' => 'SA',
 					'name' => 'Satupa\'itea',
 				),
 				'TU' => array(
					'code' => 'TU',
 					'name' => 'Tuamasaga',
 				),
 				'VF' => array(
					'code' => 'VF',
 					'name' => 'Va\'a-o-Fonoti',
 				),
 				'VS' => array(
					'code' => 'VS',
 					'name' => 'Vaisigano',
 				),
 			),
 		),
 		'YE' => array(
			'code' => 'YE',
 			'name' => 'Yemen',
 			'code3' => 'YEM',
 			'numeric' => '887',
 			'states' => array(
				'AB' => array(
					'code' => 'AB',
 					'name' => 'Abyān',
 				),
 				'AD' => array(
					'code' => 'AD',
 					'name' => '‘Adan',
 				),
 				'BA' => array(
					'code' => 'BA',
 					'name' => 'Al Bayḑā\'',
 				),
 				'DH' => array(
					'code' => 'DH',
 					'name' => 'Dhamār',
 				),
 				'HD' => array(
					'code' => 'HD',
 					'name' => 'Ḩaḑramawt',
 				),
 				'HJ' => array(
					'code' => 'HJ',
 					'name' => 'Ḩajjah',
 				),
 				'HU' => array(
					'code' => 'HU',
 					'name' => 'Al Ḩudaydah',
 				),
 				'IB' => array(
					'code' => 'IB',
 					'name' => 'Ibb',
 				),
 				'JA' => array(
					'code' => 'JA',
 					'name' => 'Al Jawf',
 				),
 				'LA' => array(
					'code' => 'LA',
 					'name' => 'Laḩij',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Ma\'rib',
 				),
 				'MR' => array(
					'code' => 'MR',
 					'name' => 'Al Mahrah',
 				),
 				'MW' => array(
					'code' => 'MW',
 					'name' => 'Al Maḩwit',
 				),
 				'SD' => array(
					'code' => 'SD',
 					'name' => 'Şa\'dah',
 				),
 				'SH' => array(
					'code' => 'SH',
 					'name' => 'Shabwah',
 				),
 				'SN' => array(
					'code' => 'SN',
 					'name' => 'Şan‘ā\'',
 				),
 				'TA' => array(
					'code' => 'TA',
 					'name' => 'Ta‘izz',
 				),
 			),
 		),
 		'YT' => array(
			'code' => 'YT',
 			'name' => 'Mayotte',
 			'code3' => 'MYT',
 			'numeric' => '175',
 			'states' => array(
			),
 		),
 		'ZA' => array(
			'code' => 'ZA',
 			'name' => 'South Africa',
 			'code3' => 'ZAF',
 			'numeric' => '710',
 			'states' => array(
				'EC' => array(
					'code' => 'EC',
 					'name' => 'Eastern Cape',
 				),
 				'FS' => array(
					'code' => 'FS',
 					'name' => 'Free State',
 				),
 				'GT' => array(
					'code' => 'GT',
 					'name' => 'Gauteng',
 				),
 				'MP' => array(
					'code' => 'MP',
 					'name' => 'Mpumalanga',
 				),
 				'NC' => array(
					'code' => 'NC',
 					'name' => 'Northern Cape',
 				),
 				'NL' => array(
					'code' => 'NL',
 					'name' => 'Kwazulu-Natal',
 				),
 				'NP' => array(
					'code' => 'NP',
 					'name' => 'Northern Province',
 				),
 				'NW' => array(
					'code' => 'NW',
 					'name' => 'North-West',
 				),
 				'WC' => array(
					'code' => 'WC',
 					'name' => 'Western Cape',
 				),
 			),
 		),
 		'ZM' => array(
			'code' => 'ZM',
 			'name' => 'Zambia',
 			'code3' => 'ZMB',
 			'numeric' => '894',
 			'states' => array(
				'01' => array(
					'code' => '01',
 					'name' => 'Western',
 				),
 				'02' => array(
					'code' => '02',
 					'name' => 'Central',
 				),
 				'03' => array(
					'code' => '03',
 					'name' => 'Eastern',
 				),
 				'04' => array(
					'code' => '04',
 					'name' => 'Luapula',
 				),
 				'05' => array(
					'code' => '05',
 					'name' => 'Northern',
 				),
 				'06' => array(
					'code' => '06',
 					'name' => 'North-Western',
 				),
 				'07' => array(
					'code' => '07',
 					'name' => 'Southern',
 				),
 				'08' => array(
					'code' => '08',
 					'name' => 'Copperbelt',
 				),
 				'09' => array(
					'code' => '09',
 					'name' => 'Lusaka',
 				),
 			),
 		),
 		'ZW' => array(
			'code' => 'ZW',
 			'name' => 'Zimbabwe',
 			'code3' => 'ZWE',
 			'numeric' => '716',
 			'states' => array(
				'BU' => array(
					'code' => 'BU',
 					'name' => 'Bulawayo',
 				),
 				'HA' => array(
					'code' => 'HA',
 					'name' => 'Harare',
 				),
 				'MA' => array(
					'code' => 'MA',
 					'name' => 'Manicaland',
 				),
 				'MC' => array(
					'code' => 'MC',
 					'name' => 'Mashonaland Central',
 				),
 				'ME' => array(
					'code' => 'ME',
 					'name' => 'Mashonaland East',
 				),
 				'MI' => array(
					'code' => 'MI',
 					'name' => 'Midlands',
 				),
 				'MN' => array(
					'code' => 'MN',
 					'name' => 'Matabeleland North',
 				),
 				'MS' => array(
					'code' => 'MS',
 					'name' => 'Matabeleland South',
 				),
 				'MV' => array(
					'code' => 'MV',
 					'name' => 'Masvingo',
 				),
 				'MW' => array(
					'code' => 'MW',
 					'name' => 'Mashonaland West',
 				),
 			),
 		),
 		'BQ' => array(
			'code' => 'BQ',
 			'name' => 'Caribbean Netherlands',
 			'code3' => 'BES',
 			'numeric' => '535',
 			'states' => array(
			),
 		),
 		'CW' => array(
			'code' => 'CW',
 			'name' => 'Curaçao',
 			'code3' => 'CUW',
 			'numeric' => '531',
 			'states' => array(
			),
 		),
 		'ME' => array(
			'code' => 'ME',
 			'name' => 'Montenegro',
 			'code3' => 'MNE',
 			'numeric' => '499',
 			'states' => array(
			),
 		),
 		'RS' => array(
			'code' => 'RS',
 			'name' => 'Serbia',
 			'code3' => 'SRB',
 			'numeric' => '688',
 			'states' => array(
			),
 		),
 		'SH' => array(
			'code' => 'SH',
 			'name' => 'Saint Helena, Ascension and Tristan da Cunha',
 			'code3' => 'SHN',
 			'numeric' => '654',
 			'states' => array(
			),
 		),
 		'SS' => array(
			'code' => 'SS',
 			'name' => 'South Sudan',
 			'code3' => 'SSD',
 			'numeric' => '728',
 			'states' => array(
			),
 		),
 		'SX' => array(
			'code' => 'SX',
 			'name' => 'Sint Maarten',
 			'code3' => 'SXM',
 			'numeric' => '534',
 			'states' => array(
			),
 		),
 		'TL' => array(
			'code' => 'TL',
 			'name' => 'Timor-Leste',
 			'code3' => 'TLS',
 			'numeric' => '626',
 			'states' => array(
			),
 		),
 	);

	private static $replaceMap = array('š'=>'s', 'đ'=>'dj', 'ž'=>'z', 'č'=>'c',
		'ć'=>'c', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a',
		'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e',
		'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n',
		'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
		'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'Ŕ'=>'R',
		'ŕ'=>'r', "`" => "'", "´" => "'", "„" => ",", "`" => "'", "´" => "'",
		"“" => "\"", "”" => "\"", "´" => "'", "~" => "", "–" => "-", "’" => "'");

	private function __construct() {}

	public static function getCountries() {
		return self::$countriesMap;
	}

	public static function getCountryByCode($countryCode) {
		if (isset(self::$countriesMap[$countryCode])) {
			return self::$countriesMap[$countryCode];
		}
		return null;
	}
	
	/**
	 * This method returns the 3-Letter ISO code for the country given by the
	 * 2-Letter ISO code.
	 * 
	 * @param string $countryCode 2-Letter ISO Code
	 * @return string 3-Letter ISO Code
	 */
	public static function getCountry3LetterCode($countryCode) {
		$country = self::getCountryByCode($countryCode);
		if ($country !== null) {
			return $country['code3'];
		}
		else {
			throw new Exception("Could not resolve the 3-letter ISO code for country code '" . strip_tags($countryCode) . "'.");
		}
	}

	public static function getStateByCode($countryCode, $stateCode) {
		$country = self::getCountryByCode($countryCode);
		if ($country && isset($country['states'][$stateCode]) && is_array($country['states'])) {
			return $country['states'][$stateCode];
		}
		else {
			return null;
		}
	}

	public static function getStateByName($countryCode, $name) {
		$country = self::getCountryByCode($countryCode);
		if ($country && isset($country['states']) && is_array($country['states'])) {
			$name = self::normalizeName($name);
			foreach ($country['states'] as $state) {
				if (self::normalizeName($state['name']) == $name) {
					return $state;
				}
			}
		}
		
		return null;
	}
	
	public static function getCountryISONumericCode($countryCode) {
		$country = self::getCountryByCode($countryCode);
		if ($country && isset($country['numeric'])) {
			return $country['numeric'];
		}
		
		return null;
	}

	private static function normalizeName($name) {
		$name = strtolower($name);
		$name = str_replace(array_keys(self::$replaceMap), array_values(self::$replaceMap), $name);
		$name = preg_replace("/[^a-z0-9]/","_", $name);
		return $name;
	}

}
