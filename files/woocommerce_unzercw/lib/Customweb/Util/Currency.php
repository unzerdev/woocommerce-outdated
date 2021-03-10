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
 * This util to handle currencies.
 *
 * @author Thomas Hunziker
 *
 */
final class Customweb_Util_Currency {

	private static $currenciesMap = array(
		'AED' => array(
			'code' => 'AED',
 			'name' => 'United Arab Emirates dirham',
 			'numericCode' => '784',
 			'decimalPlaces' => '2',
 		),
 		'AFN' => array(
			'code' => 'AFN',
 			'name' => 'Afghan afghani',
 			'numericCode' => '971',
 			'decimalPlaces' => '2',
 		),
 		'ALL' => array(
			'code' => 'ALL',
 			'name' => 'Albanian lek',
 			'numericCode' => '8',
 			'decimalPlaces' => '2',
 		),
 		'AMD' => array(
			'code' => 'AMD',
 			'name' => 'Armenian dram',
 			'numericCode' => '51',
 			'decimalPlaces' => '2',
 		),
 		'ANG' => array(
			'code' => 'ANG',
 			'name' => 'Netherlands Antillean guilder',
 			'numericCode' => '532',
 			'decimalPlaces' => '2',
 		),
 		'AOA' => array(
			'code' => 'AOA',
 			'name' => 'Angolan kwanza',
 			'numericCode' => '973',
 			'decimalPlaces' => '2',
 		),
 		'ARS' => array(
			'code' => 'ARS',
 			'name' => 'Argentine peso',
 			'numericCode' => '32',
 			'decimalPlaces' => '2',
 		),
 		'AUD' => array(
			'code' => 'AUD',
 			'name' => 'Australian dollar',
 			'numericCode' => '36',
 			'decimalPlaces' => '2',
 		),
 		'AWG' => array(
			'code' => 'AWG',
 			'name' => 'Aruban florin',
 			'numericCode' => '533',
 			'decimalPlaces' => '2',
 		),
 		'AZN' => array(
			'code' => 'AZN',
 			'name' => 'Azerbaijani manat',
 			'numericCode' => '944',
 			'decimalPlaces' => '2',
 		),
 		'BAM' => array(
			'code' => 'BAM',
 			'name' => 'Bosnia and Herzegovina convertible mark',
 			'numericCode' => '977',
 			'decimalPlaces' => '2',
 		),
 		'BBD' => array(
			'code' => 'BBD',
 			'name' => 'Barbados dollar',
 			'numericCode' => '52',
 			'decimalPlaces' => '2',
 		),
 		'BDT' => array(
			'code' => 'BDT',
 			'name' => 'Bangladeshi taka',
 			'numericCode' => '50',
 			'decimalPlaces' => '2',
 		),
 		'BGN' => array(
			'code' => 'BGN',
 			'name' => 'Bulgarian lev',
 			'numericCode' => '975',
 			'decimalPlaces' => '2',
 		),
 		'BHD' => array(
			'code' => 'BHD',
 			'name' => 'Bahraini dinar',
 			'numericCode' => '48',
 			'decimalPlaces' => '3',
 		),
 		'BIF' => array(
			'code' => 'BIF',
 			'name' => 'Burundian franc',
 			'numericCode' => '108',
 			'decimalPlaces' => '0',
 		),
 		'BMD' => array(
			'code' => 'BMD',
 			'name' => 'Bermudian dollar',
 			'numericCode' => '60',
 			'decimalPlaces' => '2',
 		),
 		'BND' => array(
			'code' => 'BND',
 			'name' => 'Brunei dollar',
 			'numericCode' => '96',
 			'decimalPlaces' => '2',
 		),
 		'BOB' => array(
			'code' => 'BOB',
 			'name' => 'Boliviano',
 			'numericCode' => '68',
 			'decimalPlaces' => '2',
 		),
 		'BOV' => array(
			'code' => 'BOV',
 			'name' => 'Bolivian Mvdol',
 			'numericCode' => '984',
 			'decimalPlaces' => '2',
 		),
 		'BRL' => array(
			'code' => 'BRL',
 			'name' => 'Brazilian real',
 			'numericCode' => '986',
 			'decimalPlaces' => '2',
 		),
 		'BSD' => array(
			'code' => 'BSD',
 			'name' => 'Bahamian dollar',
 			'numericCode' => '44',
 			'decimalPlaces' => '2',
 		),
 		'BTC' => array(
			'code' => 'BTC',
 			'name' => 'Bitcoin',
 			'numericCode' => '0',
 			'decimalPlaces' => '8',
 		),
 		'BTN' => array(
			'code' => 'BTN',
 			'name' => 'Bhutanese ngultrum',
 			'numericCode' => '64',
 			'decimalPlaces' => '2',
 		),
 		'BWP' => array(
			'code' => 'BWP',
 			'name' => 'Botswana pula',
 			'numericCode' => '72',
 			'decimalPlaces' => '2',
 		),
 		'BYN' => array(
			'code' => 'BYN',
 			'name' => 'Belarusian ruble',
 			'numericCode' => '933',
 			'decimalPlaces' => '0',
 		),
 		'BZD' => array(
			'code' => 'BZD',
 			'name' => 'Belize dollar',
 			'numericCode' => '84',
 			'decimalPlaces' => '2',
 		),
 		'CAD' => array(
			'code' => 'CAD',
 			'name' => 'Canadian dollar',
 			'numericCode' => '124',
 			'decimalPlaces' => '2',
 		),
 		'CDF' => array(
			'code' => 'CDF',
 			'name' => 'Congolese franc',
 			'numericCode' => '976',
 			'decimalPlaces' => '2',
 		),
 		'CHE' => array(
			'code' => 'CHE',
 			'name' => 'WIR Euro',
 			'numericCode' => '947',
 			'decimalPlaces' => '2',
 		),
 		'CHF' => array(
			'code' => 'CHF',
 			'name' => 'Swiss franc',
 			'numericCode' => '756',
 			'decimalPlaces' => '2',
 		),
 		'CHW' => array(
			'code' => 'CHW',
 			'name' => 'WIR Franc',
 			'numericCode' => '948',
 			'decimalPlaces' => '2',
 		),
 		'CLF' => array(
			'code' => 'CLF',
 			'name' => 'Unidad de Fomento',
 			'numericCode' => '990',
 			'decimalPlaces' => '0',
 		),
 		'CLP' => array(
			'code' => 'CLP',
 			'name' => 'Chilean peso',
 			'numericCode' => '152',
 			'decimalPlaces' => '0',
 		),
 		'CNY' => array(
			'code' => 'CNY',
 			'name' => 'Chinese yuan',
 			'numericCode' => '156',
 			'decimalPlaces' => '2',
 		),
 		'COP' => array(
			'code' => 'COP',
 			'name' => 'Colombian peso',
 			'numericCode' => '170',
 			'decimalPlaces' => '2',
 		),
 		'COU' => array(
			'code' => 'COU',
 			'name' => 'Unidad de Valor Real',
 			'numericCode' => '970',
 			'decimalPlaces' => '2',
 		),
 		'CRC' => array(
			'code' => 'CRC',
 			'name' => 'Costa Rican colon',
 			'numericCode' => '188',
 			'decimalPlaces' => '2',
 		),
 		'CUC' => array(
			'code' => 'CUC',
 			'name' => 'Cuban convertible peso',
 			'numericCode' => '931',
 			'decimalPlaces' => '2',
 		),
 		'CUP' => array(
			'code' => 'CUP',
 			'name' => 'Cuban peso',
 			'numericCode' => '192',
 			'decimalPlaces' => '2',
 		),
 		'CVE' => array(
			'code' => 'CVE',
 			'name' => 'Cape Verde escudo',
 			'numericCode' => '132',
 			'decimalPlaces' => '0',
 		),
 		'CZK' => array(
			'code' => 'CZK',
 			'name' => 'Czech koruna',
 			'numericCode' => '203',
 			'decimalPlaces' => '2',
 		),
 		'DJF' => array(
			'code' => 'DJF',
 			'name' => 'Djiboutian franc',
 			'numericCode' => '262',
 			'decimalPlaces' => '0',
 		),
 		'DKK' => array(
			'code' => 'DKK',
 			'name' => 'Danish krone',
 			'numericCode' => '208',
 			'decimalPlaces' => '2',
 		),
 		'DOP' => array(
			'code' => 'DOP',
 			'name' => 'Dominican peso',
 			'numericCode' => '214',
 			'decimalPlaces' => '2',
 		),
 		'DZD' => array(
			'code' => 'DZD',
 			'name' => 'Algerian dinar',
 			'numericCode' => '12',
 			'decimalPlaces' => '2',
 		),
 		'EGP' => array(
			'code' => 'EGP',
 			'name' => 'Egyptian pound',
 			'numericCode' => '818',
 			'decimalPlaces' => '2',
 		),
 		'ERN' => array(
			'code' => 'ERN',
 			'name' => 'Eritrean nakfa',
 			'numericCode' => '232',
 			'decimalPlaces' => '2',
 		),
 		'ETB' => array(
			'code' => 'ETB',
 			'name' => 'Ethiopian birr',
 			'numericCode' => '230',
 			'decimalPlaces' => '2',
 		),
 		'EUR' => array(
			'code' => 'EUR',
 			'name' => 'Euro',
 			'numericCode' => '978',
 			'decimalPlaces' => '2',
 		),
 		'FJD' => array(
			'code' => 'FJD',
 			'name' => 'Fiji dollar',
 			'numericCode' => '242',
 			'decimalPlaces' => '2',
 		),
 		'FKP' => array(
			'code' => 'FKP',
 			'name' => 'Falkland Islands pound',
 			'numericCode' => '238',
 			'decimalPlaces' => '2',
 		),
 		'GBP' => array(
			'code' => 'GBP',
 			'name' => 'Pound sterling',
 			'numericCode' => '826',
 			'decimalPlaces' => '2',
 		),
 		'GEL' => array(
			'code' => 'GEL',
 			'name' => 'Georgian lari',
 			'numericCode' => '981',
 			'decimalPlaces' => '2',
 		),
 		'GHS' => array(
			'code' => 'GHS',
 			'name' => 'Ghanaian cedi',
 			'numericCode' => '936',
 			'decimalPlaces' => '2',
 		),
 		'GIP' => array(
			'code' => 'GIP',
 			'name' => 'Gibraltar pound',
 			'numericCode' => '292',
 			'decimalPlaces' => '2',
 		),
 		'GMD' => array(
			'code' => 'GMD',
 			'name' => 'Gambian dalasi',
 			'numericCode' => '270',
 			'decimalPlaces' => '2',
 		),
 		'GNF' => array(
			'code' => 'GNF',
 			'name' => 'Guinean franc',
 			'numericCode' => '324',
 			'decimalPlaces' => '0',
 		),
 		'GTQ' => array(
			'code' => 'GTQ',
 			'name' => 'Guatemalan quetzal',
 			'numericCode' => '320',
 			'decimalPlaces' => '2',
 		),
 		'GYD' => array(
			'code' => 'GYD',
 			'name' => 'Guyanese dollar',
 			'numericCode' => '328',
 			'decimalPlaces' => '2',
 		),
 		'HKD' => array(
			'code' => 'HKD',
 			'name' => 'Hong Kong dollar',
 			'numericCode' => '344',
 			'decimalPlaces' => '2',
 		),
 		'HNL' => array(
			'code' => 'HNL',
 			'name' => 'Honduran lempira',
 			'numericCode' => '340',
 			'decimalPlaces' => '2',
 		),
 		'HRK' => array(
			'code' => 'HRK',
 			'name' => 'Croatian kuna',
 			'numericCode' => '191',
 			'decimalPlaces' => '2',
 		),
 		'HTG' => array(
			'code' => 'HTG',
 			'name' => 'Haitian gourde',
 			'numericCode' => '332',
 			'decimalPlaces' => '2',
 		),
 		'HUF' => array(
			'code' => 'HUF',
 			'name' => 'Hungarian forint',
 			'numericCode' => '348',
 			'decimalPlaces' => '2',
 		),
 		'IDR' => array(
			'code' => 'IDR',
 			'name' => 'Indonesian rupiah',
 			'numericCode' => '360',
 			'decimalPlaces' => '2',
 		),
 		'ILS' => array(
			'code' => 'ILS',
 			'name' => 'Israeli new shekel',
 			'numericCode' => '376',
 			'decimalPlaces' => '2',
 		),
 		'INR' => array(
			'code' => 'INR',
 			'name' => 'Indian rupee',
 			'numericCode' => '356',
 			'decimalPlaces' => '2',
 		),
 		'IQD' => array(
			'code' => 'IQD',
 			'name' => 'Iraqi dinar',
 			'numericCode' => '368',
 			'decimalPlaces' => '3',
 		),
 		'IRR' => array(
			'code' => 'IRR',
 			'name' => 'Iranian rial',
 			'numericCode' => '364',
 			'decimalPlaces' => '0',
 		),
 		'ISK' => array(
			'code' => 'ISK',
 			'name' => 'Icelandic króna',
 			'numericCode' => '352',
 			'decimalPlaces' => '0',
 		),
 		'JMD' => array(
			'code' => 'JMD',
 			'name' => 'Jamaican dollar',
 			'numericCode' => '388',
 			'decimalPlaces' => '2',
 		),
 		'JOD' => array(
			'code' => 'JOD',
 			'name' => 'Jordanian dinar',
 			'numericCode' => '400',
 			'decimalPlaces' => '3',
 		),
 		'JPY' => array(
			'code' => 'JPY',
 			'name' => 'Japanese yen',
 			'numericCode' => '392',
 			'decimalPlaces' => '0',
 		),
 		'KES' => array(
			'code' => 'KES',
 			'name' => 'Kenyan shilling',
 			'numericCode' => '404',
 			'decimalPlaces' => '2',
 		),
 		'KGS' => array(
			'code' => 'KGS',
 			'name' => 'Kyrgyzstani som',
 			'numericCode' => '417',
 			'decimalPlaces' => '2',
 		),
 		'KHR' => array(
			'code' => 'KHR',
 			'name' => 'Cambodian riel',
 			'numericCode' => '116',
 			'decimalPlaces' => '2',
 		),
 		'KMF' => array(
			'code' => 'KMF',
 			'name' => 'Comoro franc',
 			'numericCode' => '174',
 			'decimalPlaces' => '0',
 		),
 		'KPW' => array(
			'code' => 'KPW',
 			'name' => 'North Korean won',
 			'numericCode' => '408',
 			'decimalPlaces' => '0',
 		),
 		'KRW' => array(
			'code' => 'KRW',
 			'name' => 'South Korean won',
 			'numericCode' => '410',
 			'decimalPlaces' => '0',
 		),
 		'KWD' => array(
			'code' => 'KWD',
 			'name' => 'Kuwaiti dinar',
 			'numericCode' => '414',
 			'decimalPlaces' => '3',
 		),
 		'KYD' => array(
			'code' => 'KYD',
 			'name' => 'Cayman Islands dollar',
 			'numericCode' => '136',
 			'decimalPlaces' => '2',
 		),
 		'KZT' => array(
			'code' => 'KZT',
 			'name' => 'Kazakhstani tenge',
 			'numericCode' => '398',
 			'decimalPlaces' => '2',
 		),
 		'LAK' => array(
			'code' => 'LAK',
 			'name' => 'Lao kip',
 			'numericCode' => '418',
 			'decimalPlaces' => '0',
 		),
 		'LBP' => array(
			'code' => 'LBP',
 			'name' => 'Lebanese pound',
 			'numericCode' => '422',
 			'decimalPlaces' => '0',
 		),
 		'LKR' => array(
			'code' => 'LKR',
 			'name' => 'Sri Lankan rupee',
 			'numericCode' => '144',
 			'decimalPlaces' => '2',
 		),
 		'LRD' => array(
			'code' => 'LRD',
 			'name' => 'Liberian dollar',
 			'numericCode' => '430',
 			'decimalPlaces' => '2',
 		),
 		'LSL' => array(
			'code' => 'LSL',
 			'name' => 'Lesotho loti',
 			'numericCode' => '426',
 			'decimalPlaces' => '2',
 		),
 		'LTL' => array(
			'code' => 'LTL',
 			'name' => 'Lithuanian litas',
 			'numericCode' => '440',
 			'decimalPlaces' => '2',
 		),
 		'LVL' => array(
			'code' => 'LVL',
 			'name' => 'Latvian lats',
 			'numericCode' => '428',
 			'decimalPlaces' => '2',
 		),
 		'LYD' => array(
			'code' => 'LYD',
 			'name' => 'Libyan dinar',
 			'numericCode' => '434',
 			'decimalPlaces' => '3',
 		),
 		'MAD' => array(
			'code' => 'MAD',
 			'name' => 'Moroccan dirham',
 			'numericCode' => '504',
 			'decimalPlaces' => '2',
 		),
 		'MDL' => array(
			'code' => 'MDL',
 			'name' => 'Moldovan leu',
 			'numericCode' => '498',
 			'decimalPlaces' => '2',
 		),
 		'MGA' => array(
			'code' => 'MGA',
 			'name' => 'Malagasy ariary',
 			'numericCode' => '969',
 			'decimalPlaces' => '0',
 		),
 		'MKD' => array(
			'code' => 'MKD',
 			'name' => 'Macedonian denar',
 			'numericCode' => '807',
 			'decimalPlaces' => '0',
 		),
 		'MMK' => array(
			'code' => 'MMK',
 			'name' => 'Myanma kyat',
 			'numericCode' => '104',
 			'decimalPlaces' => '0',
 		),
 		'MNT' => array(
			'code' => 'MNT',
 			'name' => 'Mongolian tugrik',
 			'numericCode' => '496',
 			'decimalPlaces' => '2',
 		),
 		'MOP' => array(
			'code' => 'MOP',
 			'name' => 'Macanese pataca',
 			'numericCode' => '446',
 			'decimalPlaces' => '2',
 		),
 		'MRO' => array(
			'code' => 'MRO',
 			'name' => 'Mauritanian ouguiya',
 			'numericCode' => '478',
 			'decimalPlaces' => '0',
 		),
 		'MUR' => array(
			'code' => 'MUR',
 			'name' => 'Mauritian rupee',
 			'numericCode' => '480',
 			'decimalPlaces' => '2',
 		),
 		'MVR' => array(
			'code' => 'MVR',
 			'name' => 'Maldivian rufiyaa',
 			'numericCode' => '462',
 			'decimalPlaces' => '2',
 		),
 		'MWK' => array(
			'code' => 'MWK',
 			'name' => 'Malawian kwacha',
 			'numericCode' => '454',
 			'decimalPlaces' => '2',
 		),
 		'MXN' => array(
			'code' => 'MXN',
 			'name' => 'Mexican peso',
 			'numericCode' => '484',
 			'decimalPlaces' => '2',
 		),
 		'MXV' => array(
			'code' => 'MXV',
 			'name' => 'Mexican Unidad de Inversion',
 			'numericCode' => '979',
 			'decimalPlaces' => '2',
 		),
 		'MYR' => array(
			'code' => 'MYR',
 			'name' => 'Malaysian ringgit',
 			'numericCode' => '458',
 			'decimalPlaces' => '2',
 		),
 		'MZN' => array(
			'code' => 'MZN',
 			'name' => 'Mozambican metical',
 			'numericCode' => '943',
 			'decimalPlaces' => '2',
 		),
 		'NAD' => array(
			'code' => 'NAD',
 			'name' => 'Namibian dollar',
 			'numericCode' => '516',
 			'decimalPlaces' => '2',
 		),
 		'NGN' => array(
			'code' => 'NGN',
 			'name' => 'Nigerian naira',
 			'numericCode' => '566',
 			'decimalPlaces' => '2',
 		),
 		'NIO' => array(
			'code' => 'NIO',
 			'name' => 'Nicaraguan córdoba',
 			'numericCode' => '558',
 			'decimalPlaces' => '2',
 		),
 		'NOK' => array(
			'code' => 'NOK',
 			'name' => 'Norwegian krone',
 			'numericCode' => '578',
 			'decimalPlaces' => '2',
 		),
 		'NPR' => array(
			'code' => 'NPR',
 			'name' => 'Nepalese rupee',
 			'numericCode' => '524',
 			'decimalPlaces' => '2',
 		),
 		'NZD' => array(
			'code' => 'NZD',
 			'name' => 'New Zealand dollar',
 			'numericCode' => '554',
 			'decimalPlaces' => '2',
 		),
 		'OMR' => array(
			'code' => 'OMR',
 			'name' => 'Omani rial',
 			'numericCode' => '512',
 			'decimalPlaces' => '3',
 		),
 		'PAB' => array(
			'code' => 'PAB',
 			'name' => 'Panamanian balboa',
 			'numericCode' => '590',
 			'decimalPlaces' => '2',
 		),
 		'PEN' => array(
			'code' => 'PEN',
 			'name' => 'Peruvian nuevo sol',
 			'numericCode' => '604',
 			'decimalPlaces' => '2',
 		),
 		'PGK' => array(
			'code' => 'PGK',
 			'name' => 'Papua New Guinean kina',
 			'numericCode' => '598',
 			'decimalPlaces' => '2',
 		),
 		'PHP' => array(
			'code' => 'PHP',
 			'name' => 'Philippine peso',
 			'numericCode' => '608',
 			'decimalPlaces' => '2',
 		),
 		'PKR' => array(
			'code' => 'PKR',
 			'name' => 'Pakistani rupee',
 			'numericCode' => '586',
 			'decimalPlaces' => '2',
 		),
 		'PLN' => array(
			'code' => 'PLN',
 			'name' => 'Polish złoty',
 			'numericCode' => '985',
 			'decimalPlaces' => '2',
 		),
 		'PYG' => array(
			'code' => 'PYG',
 			'name' => 'Paraguayan guaraní',
 			'numericCode' => '600',
 			'decimalPlaces' => '0',
 		),
 		'QAR' => array(
			'code' => 'QAR',
 			'name' => 'Qatari riyal',
 			'numericCode' => '634',
 			'decimalPlaces' => '2',
 		),
 		'RON' => array(
			'code' => 'RON',
 			'name' => 'Romanian new leu',
 			'numericCode' => '946',
 			'decimalPlaces' => '2',
 		),
 		'RSD' => array(
			'code' => 'RSD',
 			'name' => 'Serbian dinar',
 			'numericCode' => '941',
 			'decimalPlaces' => '2',
 		),
 		'RUB' => array(
			'code' => 'RUB',
 			'name' => 'Russian rouble',
 			'numericCode' => '643',
 			'decimalPlaces' => '2',
 		),
 		'RWF' => array(
			'code' => 'RWF',
 			'name' => 'Rwandan franc',
 			'numericCode' => '646',
 			'decimalPlaces' => '0',
 		),
 		'SAR' => array(
			'code' => 'SAR',
 			'name' => 'Saudi riyal',
 			'numericCode' => '682',
 			'decimalPlaces' => '2',
 		),
 		'SBD' => array(
			'code' => 'SBD',
 			'name' => 'Solomon Islands dollar',
 			'numericCode' => '90',
 			'decimalPlaces' => '2',
 		),
 		'SCR' => array(
			'code' => 'SCR',
 			'name' => 'Seychelles rupee',
 			'numericCode' => '690',
 			'decimalPlaces' => '2',
 		),
 		'SDG' => array(
			'code' => 'SDG',
 			'name' => 'Sudanese pound',
 			'numericCode' => '938',
 			'decimalPlaces' => '2',
 		),
 		'SEK' => array(
			'code' => 'SEK',
 			'name' => 'Swedish krona',
 			'numericCode' => '752',
 			'decimalPlaces' => '2',
 		),
 		'SGD' => array(
			'code' => 'SGD',
 			'name' => 'Singapore dollar',
 			'numericCode' => '702',
 			'decimalPlaces' => '2',
 		),
 		'SHP' => array(
			'code' => 'SHP',
 			'name' => 'Saint Helena pound',
 			'numericCode' => '654',
 			'decimalPlaces' => '2',
 		),
 		'SLL' => array(
			'code' => 'SLL',
 			'name' => 'Sierra Leonean leone',
 			'numericCode' => '694',
 			'decimalPlaces' => '0',
 		),
 		'SOS' => array(
			'code' => 'SOS',
 			'name' => 'Somali shilling',
 			'numericCode' => '706',
 			'decimalPlaces' => '2',
 		),
 		'SRD' => array(
			'code' => 'SRD',
 			'name' => 'Surinamese dollar',
 			'numericCode' => '968',
 			'decimalPlaces' => '2',
 		),
 		'SSP' => array(
			'code' => 'SSP',
 			'name' => 'South Sudanese pound',
 			'numericCode' => '0',
 			'decimalPlaces' => '2',
 		),
 		'STD' => array(
			'code' => 'STD',
 			'name' => 'São Tomé and Príncipe dobra',
 			'numericCode' => '678',
 			'decimalPlaces' => '0',
 		),
 		'SVC' => array(
			'code' => 'SVC',
 			'name' => 'El Salvador Colon',
 			'numericCode' => '222',
 			'decimalPlaces' => '2',
 		),
 		'SYP' => array(
			'code' => 'SYP',
 			'name' => 'Syrian pound',
 			'numericCode' => '760',
 			'decimalPlaces' => '2',
 		),
 		'SZL' => array(
			'code' => 'SZL',
 			'name' => 'Swazi lilangeni',
 			'numericCode' => '748',
 			'decimalPlaces' => '2',
 		),
 		'THB' => array(
			'code' => 'THB',
 			'name' => 'Thai baht',
 			'numericCode' => '764',
 			'decimalPlaces' => '2',
 		),
 		'TJS' => array(
			'code' => 'TJS',
 			'name' => 'Tajikistani somoni',
 			'numericCode' => '972',
 			'decimalPlaces' => '2',
 		),
 		'TMT' => array(
			'code' => 'TMT',
 			'name' => 'Turkmenistani manat',
 			'numericCode' => '934',
 			'decimalPlaces' => '2',
 		),
 		'TND' => array(
			'code' => 'TND',
 			'name' => 'Tunisian dinar',
 			'numericCode' => '788',
 			'decimalPlaces' => '3',
 		),
 		'TOP' => array(
			'code' => 'TOP',
 			'name' => 'Tongan paʻanga',
 			'numericCode' => '776',
 			'decimalPlaces' => '2',
 		),
 		'TRY' => array(
			'code' => 'TRY',
 			'name' => 'Turkish lira',
 			'numericCode' => '949',
 			'decimalPlaces' => '2',
 		),
 		'TTD' => array(
			'code' => 'TTD',
 			'name' => 'Trinidad and Tobago dollar',
 			'numericCode' => '780',
 			'decimalPlaces' => '2',
 		),
 		'TWD' => array(
			'code' => 'TWD',
 			'name' => 'New Taiwan dollar',
 			'numericCode' => '901',
 			'decimalPlaces' => '2',
 		),
 		'TZS' => array(
			'code' => 'TZS',
 			'name' => 'Tanzanian shilling',
 			'numericCode' => '834',
 			'decimalPlaces' => '2',
 		),
 		'UAH' => array(
			'code' => 'UAH',
 			'name' => 'Ukrainian hryvnia',
 			'numericCode' => '980',
 			'decimalPlaces' => '2',
 		),
 		'UGX' => array(
			'code' => 'UGX',
 			'name' => 'Ugandan shilling',
 			'numericCode' => '800',
 			'decimalPlaces' => '2',
 		),
 		'USD' => array(
			'code' => 'USD',
 			'name' => 'United States dollar',
 			'numericCode' => '840',
 			'decimalPlaces' => '2',
 		),
 		'USN' => array(
			'code' => 'USN',
 			'name' => 'United States dollar',
 			'numericCode' => '997',
 			'decimalPlaces' => '2',
 		),
 		'USS' => array(
			'code' => 'USS',
 			'name' => 'United States dollar ',
 			'numericCode' => '998',
 			'decimalPlaces' => '2',
 		),
 		'UYI' => array(
			'code' => 'UYI',
 			'name' => 'Uruguay Peso en Unidades Indexadas',
 			'numericCode' => '940',
 			'decimalPlaces' => '0',
 		),
 		'UYU' => array(
			'code' => 'UYU',
 			'name' => 'Uruguayan peso',
 			'numericCode' => '858',
 			'decimalPlaces' => '2',
 		),
 		'UZS' => array(
			'code' => 'UZS',
 			'name' => 'Uzbekistan som',
 			'numericCode' => '860',
 			'decimalPlaces' => '2',
 		),
 		'VEF' => array(
			'code' => 'VEF',
 			'name' => 'Venezuelan bolívar fuerte',
 			'numericCode' => '937',
 			'decimalPlaces' => '2',
 		),
 		'VND' => array(
			'code' => 'VND',
 			'name' => 'Vietnamese dong',
 			'numericCode' => '704',
 			'decimalPlaces' => '0',
 		),
 		'VUV' => array(
			'code' => 'VUV',
 			'name' => 'Vanuatu vatu',
 			'numericCode' => '548',
 			'decimalPlaces' => '0',
 		),
 		'WST' => array(
			'code' => 'WST',
 			'name' => 'Samoan tala',
 			'numericCode' => '882',
 			'decimalPlaces' => '2',
 		),
 		'XAF' => array(
			'code' => 'XAF',
 			'name' => 'CFA franc BEAC',
 			'numericCode' => '950',
 			'decimalPlaces' => '0',
 		),
 		'XBA' => array(
			'code' => 'XBA',
 			'name' => 'European Composite Unit',
 			'numericCode' => '955',
 			'decimalPlaces' => '0',
 		),
 		'XBB' => array(
			'code' => 'XBB',
 			'name' => 'European Monetary Unit',
 			'numericCode' => '956',
 			'decimalPlaces' => '0',
 		),
 		'XBC' => array(
			'code' => 'XBC',
 			'name' => 'European Unit of Account 9',
 			'numericCode' => '957',
 			'decimalPlaces' => '0',
 		),
 		'XBD' => array(
			'code' => 'XBD',
 			'name' => 'European Unit of Account 17',
 			'numericCode' => '958',
 			'decimalPlaces' => '0',
 		),
 		'XCD' => array(
			'code' => 'XCD',
 			'name' => 'East Caribbean dollar',
 			'numericCode' => '951',
 			'decimalPlaces' => '2',
 		),
 		'XDR' => array(
			'code' => 'XDR',
 			'name' => 'Special drawing rights',
 			'numericCode' => '960',
 			'decimalPlaces' => '0',
 		),
 		'XFU' => array(
			'code' => 'XFU',
 			'name' => 'UIC franc',
 			'numericCode' => '0',
 			'decimalPlaces' => '0',
 		),
 		'XOF' => array(
			'code' => 'XOF',
 			'name' => 'CFA franc BCEAO',
 			'numericCode' => '952',
 			'decimalPlaces' => '0',
 		),
 		'XPF' => array(
			'code' => 'XPF',
 			'name' => 'CFP franc',
 			'numericCode' => '953',
 			'decimalPlaces' => '0',
 		),
 		'YER' => array(
			'code' => 'YER',
 			'name' => 'Yemeni rial',
 			'numericCode' => '886',
 			'decimalPlaces' => '2',
 		),
 		'ZAR' => array(
			'code' => 'ZAR',
 			'name' => 'South African rand',
 			'numericCode' => '710',
 			'decimalPlaces' => '2',
 		),
 		'ZMW' => array(
			'code' => 'ZMW',
 			'name' => 'Zambian kwacha',
 			'numericCode' => '967',
 			'decimalPlaces' => '2',
 		),
 		'ZWL' => array(
			'code' => 'ZWL',
 			'name' => 'Zimbabwe Dollar',
 			'numericCode' => '932',
 			'decimalPlaces' => '2',
 		),
 	);

	private function __construct() {}

	public static function getCurrencies() {
		return self::$currenciesMap;
	}

	/**
	 * This method formats the given curreny according to the $deciamlSeperator and $thousandsSeperator.
	 *
	 * @param float $amount
	 * @param string $currency
	 * @param string $decimalSeperator
	 * @param string $thousandsSeperator
	 * @return string Formated amount
	 */
	public static function formatAmount($amount, $currency, $decimalSeperator = '.', $thousandsSeperator = '') {
		return number_format($amount, self::getDecimalPlaces($currency), $decimalSeperator, $thousandsSeperator);
	}

	/**
	 * This method compares two amounts by appling the currency decimal places.
	 *
	 * Return values:
	 *  - amount 1 > amount 2 =>  1
	 *  - amount 1 < amount 2 => -1
	 *  - amount 1 = amount 2 =>  0
	 *
	 * @param float $amount1
	 * @param float $amount2
	 * @param string $currency Currency code
	 * @return number
	 */
	public static function compareAmount($amount1, $amount2, $currency) {
		$amount1Formatted = self::roundAmount($amount1, $currency);
		$amount2Formatted = self::roundAmount($amount2, $currency);

		if ($amount1Formatted > $amount2Formatted) {
			return 1;
		}
		else if ($amount1Formatted < $amount2Formatted) {
			return -1;
		}
		else {
			return 0;
		}
	}
	
	/**
	 * This method returns the currency numeric code associated with the currency code provided.
	 * 
	 * @param string $currencyIsoCode Code as string (3 Letter)
	 * @return string Numeric representation of the currency code.
	 * @throws Exception
	 */
	public static function getNumericCode($currencyIsoCode) {
		if (isset(self::$currenciesMap[$currencyIsoCode])) {
			return self::$currenciesMap[$currencyIsoCode]['numericCode'];
		}
		else {
			throw new Exception("Could not resolve the numeric currency code for currency '" . strip_tags($currencyIsoCode) . "'.");
		}
	}


	public static function roundAmount($amount, $currency) {
		return round($amount, self::getDecimalPlaces($currency));
	}

	public static function getDecimalPlaces($currency) {
		return self::$currenciesMap[$currency]['decimalPlaces'];
	}

}
