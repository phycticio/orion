<?php

namespace orion\helpers;

class Country {
	function get_countries() : array {
		return array(
			"AF" => "Afghanistan",
			"AX" => "Aland Islands",
			"AL" => "Albania",
			"DZ" => "Algeria",
			"AS" => "American Samoa",
			"AD" => "Andorra",
			"AO" => "Angola",
			"AI" => "Anguilla",
			"AQ" => "Antarctica",
			"AG" => "Antigua and Barbuda",
			"AR" => "Argentina",
			"AM" => "Armenia",
			"AW" => "Aruba",
			"AU" => "Australia",
			"AT" => "Austria",
			"AZ" => "Azerbaijan",
			"BS" => "Bahamas",
			"BH" => "Bahrain",
			"BD" => "Bangladesh",
			"BB" => "Barbados",
			"BY" => "Belarus",
			"BE" => "Belgium",
			"BZ" => "Belize",
			"BJ" => "Benin",
			"BM" => "Bermuda",
			"BT" => "Bhutan",
			"BO" => "Bolivia",
			"BQ" => "Bonaire, Sint Eustatius and Saba",
			"BA" => "Bosnia and Herzegovina",
			"BW" => "Botswana",
			"BV" => "Bouvet Island",
			"BR" => "Brazil",
			"IO" => "British Indian Ocean Territory",
			"BN" => "Brunei Darussalam",
			"BG" => "Bulgaria",
			"BF" => "Burkina Faso",
			"BI" => "Burundi",
			"KH" => "Cambodia",
			"CM" => "Cameroon",
			"CA" => "Canada",
			"CV" => "Cape Verde",
			"KY" => "Cayman Islands",
			"CF" => "Central African Republic",
			"TD" => "Chad",
			"CL" => "Chile",
			"CN" => "China",
			"CX" => "Christmas Island",
			"CC" => "Cocos (Keeling) Islands",
			"CO" => "Colombia",
			"KM" => "Comoros",
			"CG" => "Congo",
			"CD" => "Congo, the Democratic Republic of the",
			"CK" => "Cook Islands",
			"CR" => "Costa Rica",
			"CI" => "Cote D'Ivoire",
			"HR" => "Croatia",
			"CU" => "Cuba",
			"CW" => "Curacao",
			"CY" => "Cyprus",
			"CZ" => "Czech Republic",
			"DK" => "Denmark",
			"DJ" => "Djibouti",
			"DM" => "Dominica",
			"DO" => "Dominican Republic",
			"EC" => "Ecuador",
			"EG" => "Egypt",
			"SV" => "El Salvador",
			"GQ" => "Equatorial Guinea",
			"ER" => "Eritrea",
			"EE" => "Estonia",
			"ET" => "Ethiopia",
			"FK" => "Falkland Islands (Malvinas)",
			"FO" => "Faroe Islands",
			"FJ" => "Fiji",
			"FI" => "Finland",
			"FR" => "France",
			"GF" => "French Guiana",
			"PF" => "French Polynesia",
			"TF" => "French Southern Territories",
			"GA" => "Gabon",
			"GM" => "Gambia",
			"GE" => "Georgia",
			"DE" => "Germany",
			"GH" => "Ghana",
			"GI" => "Gibraltar",
			"GR" => "Greece",
			"GL" => "Greenland",
			"GD" => "Grenada",
			"GP" => "Guadeloupe",
			"GU" => "Guam",
			"GT" => "Guatemala",
			"GG" => "Guernsey",
			"GN" => "Guinea",
			"GW" => "Guinea-Bissau",
			"GY" => "Guyana",
			"HT" => "Haiti",
			"HM" => "Heard Island and Mcdonald Islands",
			"VA" => "Holy See (Vatican City State)",
			"HN" => "Honduras",
			"HK" => "Hong Kong",
			"HU" => "Hungary",
			"IS" => "Iceland",
			"IN" => "India",
			"ID" => "Indonesia",
			"IR" => "Iran, Islamic Republic of",
			"IQ" => "Iraq",
			"IE" => "Ireland",
			"IM" => "Isle of Man",
			"IL" => "Israel",
			"IT" => "Italy",
			"JM" => "Jamaica",
			"JP" => "Japan",
			"JE" => "Jersey",
			"JO" => "Jordan",
			"KZ" => "Kazakhstan",
			"KE" => "Kenya",
			"KI" => "Kiribati",
			"KP" => "Korea, Democratic People's Republic of",
			"KR" => "Korea, Republic of",
			"XK" => "Kosovo",
			"KW" => "Kuwait",
			"KG" => "Kyrgyzstan",
			"LA" => "Lao People's Democratic Republic",
			"LV" => "Latvia",
			"LB" => "Lebanon",
			"LS" => "Lesotho",
			"LR" => "Liberia",
			"LY" => "Libyan Arab Jamahiriya",
			"LI" => "Liechtenstein",
			"LT" => "Lithuania",
			"LU" => "Luxembourg",
			"MO" => "Macao",
			"MK" => "Macedonia, the Former Yugoslav Republic of",
			"MG" => "Madagascar",
			"MW" => "Malawi",
			"MY" => "Malaysia",
			"MV" => "Maldives",
			"ML" => "Mali",
			"MT" => "Malta",
			"MH" => "Marshall Islands",
			"MQ" => "Martinique",
			"MR" => "Mauritania",
			"MU" => "Mauritius",
			"YT" => "Mayotte",
			"MX" => "Mexico",
			"FM" => "Micronesia, Federated States of",
			"MD" => "Moldova, Republic of",
			"MC" => "Monaco",
			"MN" => "Mongolia",
			"ME" => "Montenegro",
			"MS" => "Montserrat",
			"MA" => "Morocco",
			"MZ" => "Mozambique",
			"MM" => "Myanmar",
			"NA" => "Namibia",
			"NR" => "Nauru",
			"NP" => "Nepal",
			"NL" => "Netherlands",
			"AN" => "Netherlands Antilles",
			"NC" => "New Caledonia",
			"NZ" => "New Zealand",
			"NI" => "Nicaragua",
			"NE" => "Niger",
			"NG" => "Nigeria",
			"NU" => "Niue",
			"NF" => "Norfolk Island",
			"MP" => "Northern Mariana Islands",
			"NO" => "Norway",
			"OM" => "Oman",
			"PK" => "Pakistan",
			"PW" => "Palau",
			"PS" => "Palestinian Territory, Occupied",
			"PA" => "Panama",
			"PG" => "Papua New Guinea",
			"PY" => "Paraguay",
			"PE" => "Peru",
			"PH" => "Philippines",
			"PN" => "Pitcairn",
			"PL" => "Poland",
			"PT" => "Portugal",
			"PR" => "Puerto Rico",
			"QA" => "Qatar",
			"RE" => "Reunion",
			"RO" => "Romania",
			"RU" => "Russian Federation",
			"RW" => "Rwanda",
			"BL" => "Saint Barthelemy",
			"SH" => "Saint Helena",
			"KN" => "Saint Kitts and Nevis",
			"LC" => "Saint Lucia",
			"MF" => "Saint Martin",
			"PM" => "Saint Pierre and Miquelon",
			"VC" => "Saint Vincent and the Grenadines",
			"WS" => "Samoa",
			"SM" => "San Marino",
			"ST" => "Sao Tome and Principe",
			"SA" => "Saudi Arabia",
			"SN" => "Senegal",
			"RS" => "Serbia",
			"CS" => "Serbia and Montenegro",
			"SC" => "Seychelles",
			"SL" => "Sierra Leone",
			"SG" => "Singapore",
			"SX" => "Sint Maarten",
			"SK" => "Slovakia",
			"SI" => "Slovenia",
			"SB" => "Solomon Islands",
			"SO" => "Somalia",
			"ZA" => "South Africa",
			"GS" => "South Georgia and the South Sandwich Islands",
			"SS" => "South Sudan",
			"ES" => "Spain",
			"LK" => "Sri Lanka",
			"SD" => "Sudan",
			"SR" => "Suriname",
			"SJ" => "Svalbard and Jan Mayen",
			"SZ" => "Swaziland",
			"SE" => "Sweden",
			"CH" => "Switzerland",
			"SY" => "Syrian Arab Republic",
			"TW" => "Taiwan, Province of China",
			"TJ" => "Tajikistan",
			"TZ" => "Tanzania, United Republic of",
			"TH" => "Thailand",
			"TL" => "Timor-Leste",
			"TG" => "Togo",
			"TK" => "Tokelau",
			"TO" => "Tonga",
			"TT" => "Trinidad and Tobago",
			"TN" => "Tunisia",
			"TR" => "Turkey",
			"TM" => "Turkmenistan",
			"TC" => "Turks and Caicos Islands",
			"TV" => "Tuvalu",
			"UG" => "Uganda",
			"UA" => "Ukraine",
			"AE" => "United Arab Emirates",
			"GB" => "United Kingdom",
			"US" => "United States",
			"UM" => "United States Minor Outlying Islands",
			"UY" => "Uruguay",
			"UZ" => "Uzbekistan",
			"VU" => "Vanuatu",
			"VE" => "Venezuela",
			"VN" => "Viet Nam",
			"VG" => "Virgin Islands, British",
			"VI" => "Virgin Islands, U.s.",
			"WF" => "Wallis and Futuna",
			"EH" => "Western Sahara",
			"YE" => "Yemen",
			"ZM" => "Zambia",
			"ZW" => "Zimbabwe"
		);
	}

	function get_country($country) : string {
		return $this->get_countries()[$country] ?? '';
	}

	function get_languages() : array {
		return array(
			"af" => "Afrikaans",
			"sq" => "Albanian - shqip",
			"am" => "Amharic - አማርኛ",
			"ar" => "Arabic - العربية",
			"an" => "Aragonese - aragonés",
			"hy" => "Armenian - հայերեն",
			"ast" => "Asturian - asturianu",
			"az" => "Azerbaijani - azərbaycan dili",
			"eu" => "Basque - euskara",
			"be" => "Belarusian - беларуская",
			"bn" => "Bengali - বাংলা",
			"bs" => "Bosnian - bosanski",
			"br" => "Breton - brezhoneg",
			"bg" => "Bulgarian - български",
			"ca" => "Catalan - català",
			"ckb" => "Central Kurdish - کوردی (دەستنوسی عەرەبی)",
			"zh" => "Chinese - 中文",
			"zh-HK" => "Chinese (Hong Kong) - 中文（香港）",
			"zh-CN" => "Chinese (Simplified) - 中文（简体）",
			"zh-TW" => "Chinese (Traditional) - 中文（繁體）",
			"co" => "Corsican",
			"hr" => "Croatian - hrvatski",
			"cs" => "Czech - čeština",
			"da" => "Danish - dansk",
			"nl" => "Dutch - Nederlands",
			"en" => "English",
			"en-AU" => "English (Australia)",
			"en-CA" => "English (Canada)",
			"en-IN" => "English (India)",
			"en-NZ" => "English (New Zealand)",
			"en-ZA" => "English (South Africa)",
			"en-GB" => "English (United Kingdom)",
			"en-US" => "English (United States)",
			"eo" => "Esperanto - esperanto",
			"et" => "Estonian - eesti",
			"fo" => "Faroese - føroyskt",
			"fil" => "Filipino",
			"fi" => "Finnish - suomi",
			"fr" => "French - français",
			"fr-CA" => "French (Canada) - français (Canada)",
			"fr-FR" => "French (France) - français (France)",
			"fr-CH" => "French (Switzerland) - français (Suisse)",
			"gl" => "Galician - galego",
			"ka" => "Georgian - ქართული",
			"de" => "German - Deutsch",
			"de-AT" => "German (Austria) - Deutsch (Österreich)",
			"de-DE" => "German (Germany) - Deutsch (Deutschland)",
			"de-LI" => "German (Liechtenstein) - Deutsch (Liechtenstein)",
			"de-CH" => "German (Switzerland) - Deutsch (Schweiz)",
			"el" => "Greek - Ελληνικά",
			"gn" => "Guarani",
			"gu" => "Gujarati - ગુજરાતી",
			"ha" => "Hausa",
			"haw" => "Hawaiian - ʻŌlelo Hawaiʻi",
			"he" => "Hebrew - עברית",
			"hi" => "Hindi - हिन्दी",
			"hu" => "Hungarian - magyar",
			"is" => "Icelandic - íslenska",
			"id" => "Indonesian - Indonesia",
			"ia" => "Interlingua",
			"ga" => "Irish - Gaeilge",
			"it" => "Italian - italiano",
			"it-IT" => "Italian (Italy) - italiano (Italia)",
			"it-CH" => "Italian (Switzerland) - italiano (Svizzera)",
			"ja" => "Japanese - 日本語",
			"kn" => "Kannada - ಕನ್ನಡ",
			"kk" => "Kazakh - қазақ тілі",
			"km" => "Khmer - ខ្មែរ",
			"ko" => "Korean - 한국어",
			"ku" => "Kurdish - Kurdî",
			"ky" => "Kyrgyz - кыргызча",
			"lo" => "Lao - ລາວ",
			"la" => "Latin",
			"lv" => "Latvian - latviešu",
			"ln" => "Lingala - lingála",
			"lt" => "Lithuanian - lietuvių",
			"mk" => "Macedonian - македонски",
			"ms" => "Malay - Bahasa Melayu",
			"ml" => "Malayalam - മലയാളം",
			"mt" => "Maltese - Malti",
			"mr" => "Marathi - मराठी",
			"mn" => "Mongolian - монгол",
			"ne" => "Nepali - नेपाली",
			"no" => "Norwegian - norsk",
			"nb" => "Norwegian Bokmål - norsk bokmål",
			"nn" => "Norwegian Nynorsk - nynorsk",
			"oc" => "Occitan",
			"or" => "Oriya - ଓଡ଼ିଆ",
			"om" => "Oromo - Oromoo",
			"ps" => "Pashto - پښتو",
			"fa" => "Persian - فارسی",
			"pl" => "Polish - polski",
			"pt" => "Portuguese - português",
			"pt-BR" => "Portuguese (Brazil) - português (Brasil)",
			"pt-PT" => "Portuguese (Portugal) - português (Portugal)",
			"pa" => "Punjabi - ਪੰਜਾਬੀ",
			"qu" => "Quechua",
			"ro" => "Romanian - română",
			"mo" => "Romanian (Moldova) - română (Moldova)",
			"rm" => "Romansh - rumantsch",
			"ru" => "Russian - русский",
			"gd" => "Scottish Gaelic",
			"sr" => "Serbian - српски",
			"sh" => "Serbo - Croatian",
			"sn" => "Shona - chiShona",
			"sd" => "Sindhi",
			"si" => "Sinhala - සිංහල",
			"sk" => "Slovak - slovenčina",
			"sl" => "Slovenian - slovenščina",
			"so" => "Somali - Soomaali",
			"st" => "Southern Sotho",
			"es" => "Spanish - español",
			"es-AR" => "Spanish (Argentina) - español (Argentina)",
			"es-419" => "Spanish (Latin America) - español (Latinoamérica)",
			"es-MX" => "Spanish (Mexico) - español (México)",
			"es-ES" => "Spanish (Spain) - español (España)",
			"es-US" => "Spanish (United States) - español (Estados Unidos)",
			"su" => "Sundanese",
			"sw" => "Swahili - Kiswahili",
			"sv" => "Swedish - svenska",
			"tg" => "Tajik - тоҷикӣ",
			"ta" => "Tamil - தமிழ்",
			"tt" => "Tatar",
			"te" => "Telugu - తెలుగు",
			"th" => "Thai - ไทย",
			"ti" => "Tigrinya - ትግርኛ",
			"to" => "Tongan - lea fakatonga",
			"tr" => "Turkish - Türkçe",
			"tk" => "Turkmen",
			"tw" => "Twi",
			"uk" => "Ukrainian - українська",
			"ur" => "Urdu - اردو",
			"ug" => "Uyghur",
			"uz" => "Uzbek - o‘zbek",
			"vi" => "Vietnamese - Tiếng Việt",
			"wa" => "Walloon - wa",
			"cy" => "Welsh - Cymraeg",
			"fy" => "Western Frisian",
			"xh" => "Xhosa",
			"yi" => "Yiddish",
			"yo" => "Yoruba - Èdè Yorùbá",
			"zu" => "Zulu - isiZulu"
		);
	}

	function get_language($language) : string {
		return $this->get_languages()[$language] ?? '';
	}
}

function Country() {
	static $instance;
	if(!isset($instance)) {
		$instance = new Country();
	}
	return $instance;
}
