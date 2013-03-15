<?php

// Default configurations
$config['Email']['default'] = array(
    'smtpOptions' => array(
        'port' => SMTP_PORT,
        'timeout' => SMTP_TIMEOUT,
        'host' => SMTP_HOST,
        'username' => SMTP_USERNAME,
        'password' => SMTP_PASSWORD
    ),
    'replyTo' => SMTP_REPLYTO,
    'from' => SMTP_FROM,
    'template' => 'default',
    'layout' => 'default',
    'sendAs' => 'text',
   // 'delivery' => 'debug'
    'delivery' => 'smtp'
);

// UPLOAD FILES SUPPORTED BY SITE
$files = array(
    'image' => array(
        'type' => array('bmp', 'gif', 'jpeg', 'jpg', 'png'),
        'size' => 25 * 1024 * 1024 // (UPLOAD MAX FILE SIZE )
    ),
    'video' => array(
        'type' => array('mp2', 'mpeg', 'mpg', 'mov', 'qt', 'avi', 'flv', 'mp4'),
        'size' => 100 * 1024 * 1024 // (UPLOAD MAX FILE SIZE
    ),
    'audio' => array(
        'type' => array('mp3'), // ONLY MP3 SUPPORT
        'size' => 100 * 1024 * 1024 // (UPLOAD MAX FILE SIZE
    )
);

$config['Upload']['files'] = $files;
$config['Global']['date_format'] = 'DMY';


// SITE COUNTRY LIST

$countries = array(
    'AD' /* Andorra */,
    'AE' /* United Arab Emirates */,
    'AF' /* Afghanistan */,
    'AG' /* Antigua and Barbuda */,
    'AI' /* Anguilla */,
    'AL' /* Albania */,
    'AM' /* Armenia */,
    'AO' /* Angola */,
    'AQ' /* Antarctica */,
    'AR' /* Argentina */,
    'AS' /* American Samoa */,
    'AT' /* Austria */,
    'AU' /* Australia */,
    'AW' /* Aruba */,
    'AX' /* Aland Islands */,
    'AZ' /* Azerbaijan */,
    'BA' /* Bosnia and Herzegovina */,
    'BB' /* Barbados */,
    'BD' /* Bangladesh */,
    'BE' /* Belgium */,
    'BF' /* Burkina Faso */,
    'BG' /* Bulgaria */,
    'BH' /* Bahrain */,
    'BI' /* Burundi */,
    'BJ' /* Benin */,
    'BL' /* Saint Barthélemy */,
    'BM' /* Bermuda */,
    'BN' /* Brunei */,
    'BO' /* Bolivia */,
    'BQ' /* Bonaire, Saint Eustatius and Saba  */,
    'BR' /* Brazil */,
    'BS' /* Bahamas */,
    'BT' /* Bhutan */,
    'BV' /* Bouvet Island */,
    'BW' /* Botswana */,
    'BY' /* Belarus */,
    'BZ' /* Belize */,
    'CA' /* Canada */,
    'CC' /* Cocos Islands */,
    'CD' /* Democratic Republic of the Congo */,
    'CF' /* Central African Republic */,
    'CG' /* Republic of the Congo */,
    'CH' /* Switzerland */,
    'CI' /* Ivory Coast */,
    'CK' /* Cook Islands */,
    'CL' /* Chile */,
    'CM' /* Cameroon */,
    'CN' /* China */,
    'CO' /* Colombia */,
    'CR' /* Costa Rica */,
    'CU' /* Cuba */,
    'CV' /* Cape Verde */,
    'CW' /* Curacao */,
    'CX' /* Christmas Island */,
    'CY' /* Cyprus */,
    'CZ' /* Czech Republic */,
    'DE' /* Germany */,
    'DJ' /* Djibouti */,
    'DK' /* Denmark */,
    'DM' /* Dominica */,
    'DO' /* Dominican Republic */,
    'DZ' /* Algeria */,
    'EC' /* Ecuador */,
    'EE' /* Estonia */,
    'EG' /* Egypt */,
    'EH' /* Western Sahara */,
    'ER' /* Eritrea */,
    'ES' /* Spain */,
    'ET' /* Ethiopia */,
    'FI' /* Finland */,
    'FJ' /* Fiji */,
    'FK' /* Falkland Islands */,
    'FM' /* Micronesia */,
    'FO' /* Faroe Islands */,
    'FR' /* France */,
    'GA' /* Gabon */,
    'GB' /* United Kingdom */,
    'GD' /* Grenada */,
    'GE' /* Georgia */,
    'GF' /* French Guiana */,
    'GG' /* Guernsey */,
    'GH' /* Ghana */,
    'GI' /* Gibraltar */,
    'GL' /* Greenland */,
    'GM' /* Gambia */,
    'GN' /* Guinea */,
    'GP' /* Guadeloupe */,
    'GQ' /* Equatorial Guinea */,
    'GR' /* Greece */,
    'GS' /* South Georgia and the South Sandwich Islands */,
    'GT' /* Guatemala */,
    'GU' /* Guam */,
    'GW' /* Guinea-Bissau */,
    'GY' /* Guyana */,
    'HK' /* Hong Kong */,
    'HM' /* Heard Island and McDonald Islands */,
    'HN' /* Honduras */,
    'HR' /* Croatia */,
    'HT' /* Haiti */,
    'HU' /* Hungary */,
    'ID' /* Indonesia */,
    'IE' /* Ireland */,
    'IL' /* Israel */,
    'IM' /* Isle of Man */,
    'IN' /* India */,
    'IO' /* British Indian Ocean Territory */,
    'IQ' /* Iraq */,
    'IR' /* Iran */,
    'IS' /* Iceland */,
    'IT' /* Italy */,
    'JE' /* Jersey */,
    'JM' /* Jamaica */,
    'JO' /* Jordan */,
    'JP' /* Japan */,
    'KE' /* Kenya */,
    'KG' /* Kyrgyzstan */,
    'KH' /* Cambodia */,
    'KI' /* Kiribati */,
    'KM' /* Comoros */,
    'KN' /* Saint Kitts and Nevis */,
    'KP' /* North Korea */,
    'KR' /* South Korea */,
    'XK' /* Kosovo */,
    'KW' /* Kuwait */,
    'KY' /* Cayman Islands */,
    'KZ' /* Kazakhstan */,
    'LA' /* Laos */,
    'LB' /* Lebanon */,
    'LC' /* Saint Lucia */,
    'LI' /* Liechtenstein */,
    'LK' /* Sri Lanka */,
    'LR' /* Liberia */,
    'LS' /* Lesotho */,
    'LT' /* Lithuania */,
    'LU' /* Luxembourg */,
    'LV' /* Latvia */,
    'LY' /* Libya */,
    'MA' /* Morocco */,
    'MC' /* Monaco */,
    'MD' /* Moldova */,
    'ME' /* Montenegro */,
    'MF' /* Saint Martin */,
    'MG' /* Madagascar */,
    'MH' /* Marshall Islands */,
    'MK' /* Macedonia */,
    'ML' /* Mali */,
    'MM' /* Myanmar */,
    'MN' /* Mongolia */,
    'MO' /* Macao */,
    'MP' /* Northern Mariana Islands */,
    'MQ' /* Martinique */,
    'MR' /* Mauritania */,
    'MS' /* Montserrat */,
    'MT' /* Malta */,
    'MU' /* Mauritius */,
    'MV' /* Maldives */,
    'MW' /* Malawi */,
    'MX' /* Mexico */,
    'MY' /* Malaysia */,
    'MZ' /* Mozambique */,
    'NA' /* Namibia */,
    'NC' /* New Caledonia */,
    'NE' /* Niger */,
    'NF' /* Norfolk Island */,
    'NG' /* Nigeria */,
    'NI' /* Nicaragua */,
    'NL' /* Netherlands */,
    'NO' /* Norway */,
    'NP' /* Nepal */,
    'NR' /* Nauru */,
    'NU' /* Niue */,
    'NZ' /* New Zealand */,
    'OM' /* Oman */,
    'PA' /* Panama */,
    'PE' /* Peru */,
    'PF' /* French Polynesia */,
    'PG' /* Papua New Guinea */,
    'PH' /* Philippines */,
    'PK' /* Pakistan */,
    'PL' /* Poland */,
    'PM' /* Saint Pierre and Miquelon */,
    'PN' /* Pitcairn */,
    'PR' /* Puerto Rico */,
    'PS' /* Palestinian Territory */,
    'PT' /* Portugal */,
    'PW' /* Palau */,
    'PY' /* Paraguay */,
    'QA' /* Qatar */,
    'RE' /* Reunion */,
    'RO' /* Romania */,
    'RS' /* Serbia */,
    'RU' /* Russia */,
    'RW' /* Rwanda */,
    'SA' /* Saudi Arabia */,
    'SB' /* Solomon Islands */,
    'SC' /* Seychelles */,
    'SD' /* Sudan */,
    'SE' /* Sweden */,
    'SG' /* Singapore */,
    'SH' /* Saint Helena */,
    'SI' /* Slovenia */,
    'SJ' /* Svalbard and Jan Mayen */,
    'SK' /* Slovakia */,
    'SL' /* Sierra Leone */,
    'SM' /* San Marino */,
    'SN' /* Senegal */,
    'SO' /* Somalia */,
    'SR' /* Suriname */,
    'ST' /* Sao Tome and Principe */,
    'SV' /* El Salvador */,
    'SX' /* Sint Maarten */,
    'SY' /* Syria */,
    'SZ' /* Swaziland */,
    'TC' /* Turks and Caicos Islands */,
    'TD' /* Chad */,
    'TF' /* French Southern Territories */,
    'TG' /* Togo */,
    'TH' /* Thailand */,
    'TJ' /* Tajikistan */,
    'TK' /* Tokelau */,
    'TL' /* East Timor */,
    'TM' /* Turkmenistan */,
    'TN' /* Tunisia */,
    'TO' /* Tonga */,
    'TR' /* Turkey */,
    'TT' /* Trinidad and Tobago */,
    'TV' /* Tuvalu */,
    'TW' /* Taiwan */,
    'TZ' /* Tanzania */,
    'UA' /* Ukraine */,
    'UG' /* Uganda */,
    'UM' /* United States Minor Outlying Islands */,
    'US' /* United States */,
    'UY' /* Uruguay */,
    'UZ' /* Uzbekistan */,
    'VA' /* Vatican */,
    'VC' /* Saint Vincent and the Grenadines */,
    'VE' /* Venezuela */,
    'VG' /* British Virgin Islands */,
    'VI' /* U.S. Virgin Islands */,
    'VN' /* Vietnam */,
    'VU' /* Vanuatu */,
    'WF' /* Wallis and Futuna */,
    'WS' /* Samoa */,
    'YE' /* Yemen */,
    'YT' /* Mayotte */,
    'ZA' /* South Africa */,
    'ZM' /* Zambia */,
    'ZW' /* Zimbabwe */,
    'CS' /* Serbia and Montenegro */,
    'AN' /* Netherlands Antilles */
);
$countries[""] = "ALL";
$config['Countries'] = $countries;

// SITE FORBIDEN USERNAMES
$config['stopwords'] = array(
    'sitemap', 'a', 'acá', 'ahí', 'ajena', 'ajenas', 'ajeno', 'ajenos', 'al', 'algo', 'algún',
    'alguna', 'algunas', 'alguno', 'algunos', 'allá', 'alli', 'allí', 'ambos', 'ampleamos',
    'ante', 'antes', 'aquel', 'aquella', 'aquellas', 'aquello', 'aquellos', 'aqui', 'aquí',
    'arriba', 'asi', 'atras', 'aun', 'aunque', 'bajo', 'bastante', 'bien', 'cabe', 'cada',
    'casi', 'cierta', 'ciertas', 'cierto', 'ciertos', 'como', 'cómo', 'con', 'conmigo',
    'conseguimos', 'conseguir', 'consigo', 'consigue', 'consiguen', 'consigues', 'contigo',
    'contra', 'cual', 'cuales', 'cualquier', 'cualquiera', 'cualquieras', 'cuan', 'cuán',
    'cuando', 'cuanta', 'cuánta', 'cuantas', 'cuántas', 'cuanto', 'cuánto', 'cuantos', 'cuántos',
    'de', 'dejar', 'del', 'demás', 'demas', 'demasiada', 'demasiadas', 'demasiado', 'demasiados',
    'dentro', 'desde', 'donde', 'dos', 'el', 'él', 'ella', 'ellas', 'ello', 'ellos', 'empleais', 'emplean',
    'emplear', 'empleas', 'empleo', 'en', 'encima', 'entonces', 'entre', 'era', 'eramos', 'eran', 'eras',
    'eres', 'es', 'esa', 'esas', 'ese', 'eso', 'esos', 'esta', 'estaba', 'estado', 'estais', 'estamos', 'estan'
    , 'estar', 'estas', 'este', 'esto', 'estos', 'estoy', 'etc', 'fin', 'fue', 'fueron', 'fui', 'fuimos', 'gueno'
    , 'ha', 'hace', 'haceis', 'hacemos', 'hacen', 'hacer', 'haces', 'hacia', 'hago', 'hasta', 'incluso', 'intenta',
    'intentais', 'intentamos', 'intentan', 'intentar', 'intentas', 'intento', 'ir', 'jamás', 'junto', 'juntos',
    'la', 'largo', 'las', 'lo', 'los', 'mas', 'más', 'me', 'menos', 'mi', 'mía', 'mia', 'mias', 'mientras', 'mio', 'mío'
    , 'mios', 'mis', 'misma', 'mismas', 'mismo', 'mismos', 'modo', 'mucha', 'muchas', 'muchísima', 'muchísimas'
    , 'muchísimo', 'muchísimos', 'mucho', 'muchos', 'muy', 'nada', 'ni', 'ningun', 'ninguna', 'ningunas', 'ninguno',
    'ningunos', 'no', 'nos', 'nosotras', 'nosotros', 'nuestra', 'nuestras', 'nuestro', 'nuestros', 'nunca'
    , 'os', 'otra', 'otras', 'otro', 'otros', 'para', 'parecer', 'pero', 'poca', 'pocas', 'poco', 'pocos', 'podeis',
    'podemos', 'poder', 'podria', 'podriais', 'podriamos', 'podrian', 'podrias', 'por', 'por qué', 'porque', 'primero'
    , 'primero desde', 'puede', 'pueden', 'puedo', 'pues', 'que', 'qué', 'querer', 'quien', 'quién', 'quienes',
    'quienesquiera', 'quienquiera', 'quiza', 'quizas', 'sabe', 'sabeis', 'sabemos', 'saben', 'saber', 'sabes',
    'se', 'segun', 'ser', 'si', 'sí', 'siempre', 'siendo', 'sin', 'sín', 'sino', 'so', 'sobre', 'sois', 'solamente',
    'solo', 'somos', 'soy', 'sr', 'sra', 'sres', 'sta', 'su', 'sus', 'suya', 'suyas', 'suyo', 'suyos', 'tal', 'tales',
    'también', 'tambien', 'tampoco', 'tan', 'tanta', 'tantas', 'tanto', 'tantos', 'te', 'teneis', 'tenemos', 'tener'
    , 'tengo', 'ti', 'tiempo', 'tiene', 'tienen', 'toda', 'todas', 'todo', 'todos', 'tomar', 'trabaja', 'trabajais',
    'trabajamos', 'trabajan', 'trabajar', 'trabajas', 'trabajo', 'tras', 'tú', 'tu', 'tus', 'tuya', 'tuyo', 'tuyos'
    , 'ultimo', 'un', 'una', 'unas', 'uno', 'unos', 'usa', 'usais', 'usamos', 'usan', 'usar', 'usas', 'uso', 'usted',
    'ustedes', 'va', 'vais', 'valor', 'vamos', 'van', 'varias', 'varios', 'vaya', 'verdad', 'verdadera', 'vosotras'
    , 'vosotros', 'voy', 'vuestra', 'vuestras', 'vuestro', 'vuestros', 'y', 'ya', 'yo', 'a', 'able', 'about', 'above'
    , 'abroad', 'according', 'accordingly', 'across', 'actually', 'adj', 'after', 'afterwards', 'again', 'against',
    'ago', 'ahead', 'ain’t', 'all', 'allow', 'allows', 'almost', 'alone', 'along', 'alongside', 'already', 'also',
    'although', 'always', 'am', 'amid', 'amidst', 'among', 'amongst', 'an', 'and', 'another', 'any', 'anybody',
    'anyhow', 'anyone', 'anything', 'anyway', 'anyways', 'anywhere', 'apart', 'appear', 'appreciate',
    'appropriate', 'are', 'aren’t', 'around', 'as', 'a’s', 'aside', 'ask', 'asking', 'associated', 'at',
    'available', 'away', 'awfully', 'b', 'back', 'backward', 'backwards', 'be', 'became', 'because',
    'become', 'becomes', 'becoming', 'been', 'before', 'beforehand', 'begin', 'behind', 'being', 'believe'
    , 'below', 'beside', 'besides', 'best', 'better', 'between', 'beyond', 'both', 'brief', 'but', 'by', 'c',
    'came', 'can', 'cannot', 'cant', 'can’t', 'caption', 'cause', 'causes', 'certain', 'certainly', 'changes',
    'clearly', 'c’mon', 'co', 'co.', 'com', 'come', 'comes', 'concerning', 'consequently', 'consider', 'considering', 'contain',
    'containing', 'contains', 'corresponding', 'could', 'couldn’t', 'course', 'c’s', 'currently', 'd', 'dare', 'daren’t', 'definitely',
    'described', 'despite', 'did', 'didn’t', 'different', 'directly', 'do', 'does', 'doesn’t', 'doing', 'done', 'don’t', 'down', 'downwards'
    , 'during', 'e', 'each', 'edu', 'eg', 'eight', 'eighty', 'either', 'else', 'elsewhere', 'end', 'ending', 'enough'
    , 'entirely', 'especially', 'et', 'etc', 'even', 'ever', 'evermore', 'every', 'everybody', 'everyone', 'everything'
    , 'everywhere', 'ex', 'exactly', 'example', 'except', 'f', 'fairly', 'far', 'farther', 'few', 'fewer', 'fifth', 'first',
    'five', 'followed', 'following', 'follows', 'for', 'forever', 'former', 'formerly', 'forth', 'forward', 'found', 'four',
    'from', 'further', 'furthermore', 'g', 'get', 'gets', 'getting', 'given', 'gives', 'go', 'goes', 'going', 'gone', 'got',
    'gotten', 'greetings', 'h', 'had', 'hadn’t', 'half', 'happens', 'hardly', 'has', 'hasn’t', 'have', 'haven’t', 'having',
    'he', 'he’d', 'he’ll', 'hello', 'help', 'hence', 'her', 'here', 'hereafter', 'hereby', 'herein', 'here’s', 'hereupon',
    'hers', 'herself', 'he’s', 'hi', 'him', 'himself', 'his', 'hither', 'hopefully', 'how', 'howbeit', 'however', 'hundred',
    'i', 'i’d', 'ie', 'if', 'ignored', 'i’ll', 'i’m', 'immediate', 'in', 'inasmuch', 'inc', 'inc.', 'indeed', 'indicate', 'indicated'
    , 'indicates', 'inner', 'inside', 'insofar', 'instead', 'into', 'inward', 'is', 'isn’t', 'it', 'it’d', 'it’ll', 'its', 'it’s'
    , 'itself', 'i’ve', 'j', 'just', 'k', 'keep', 'keeps', 'kept', 'know', 'known', 'knows', 'l', 'last', 'lately', 'later', 'latter'
    , 'latterly', 'least', 'less', 'lest', 'let', 'let’s', 'like', 'liked', 'likely', 'likewise', 'little', 'look', 'looking'
    , 'looks', 'low', 'lower', 'ltd', 'm', 'made', 'mainly', 'make', 'makes', 'many', 'may', 'maybe', 'mayn’t', 'me', 'mean'
    , 'meantime', 'meanwhile', 'merely', 'might', 'mightn’t', 'mine', 'minus', 'miss', 'more', 'moreover', 'most', 'mostly'
    , 'mr', 'mrs', 'much', 'must', 'mustn’t', 'my', 'myself', 'n', 'name', 'namely', 'nd', 'near', 'nearly', 'necessary', 'need'
    , 'needn’t', 'needs', 'neither', 'never', 'neverf', 'neverless', 'nevertheless', 'new', 'next', 'nine', 'ninety', 'no'
    , 'nobody', 'non', 'none', 'nonetheless', 'noone', 'no-one', 'nor', 'normally', 'not', 'nothing', 'notwithstanding',
    'novel', 'now', 'nowhere', 'o', 'obviously', 'of', 'off', 'often', 'oh', 'ok', 'okay', 'old', 'fila', 'filas', 'on', 'once', 'one', 'ones'
    , 'one’s', 'only', 'onto', 'opposite', 'or', 'other', 'others', 'otherwise', 'ought', 'oughtn’t', 'our', 'ours',
    'ourselves', 'out', 'outside', 'over', 'overall', 'own', 'p', 'particular', 'particularly', 'past', 'per', 'perhaps'
    , 'placed', 'please', 'plus', 'possible', 'presumably', 'probably', 'provided', 'provides', 'q', 'que', 'quite', 'qv'
    , 'r', 'rather', 'rd', 're', 'really', 'reasonably', 'recent', 'recently', 'regarding', 'regardless', 'regards', 'relatively'
    , 'respectively', 'right', 'round', 's', 'said', 'same', 'saw', 'say', 'saying', 'says', 'second', 'secondly', 'see', 'seeing',
    'seem', 'seemed', 'seeming', 'seems', 'seen', 'self', 'selves', 'sensible', 'sent', 'serious', 'seriously', 'seven', 'several'
    , 'shall', 'shan’t', 'she', 'she’d', 'she’ll', 'she’s', 'should', 'shouldn’t', 'since', 'six', 'so', 'some', 'somebody', 'someday',
    'somehow', 'someone', 'something', 'sometime', 'sometimes', 'somewhat', 'somewhere', 'soon', 'sorry', 'specified', 'specify',
    'specifying', 'still', 'sub', 'such', 'sup', 'sure', 't', 'take', 'taken', 'taking', 'tell', 'tends', 'th', 'than', 'thank', 'thanks'
    , 'thanx', 'that', 'that’ll', 'thats', 'that’s', 'that’ve', 'the', 'their', 'theirs', 'them', 'themselves', 'then', 'thence', 'there'
    , 'thereafter', 'thereby', 'there’d', 'therefore', 'therein', 'there’ll', 'there’re', 'theres', 'there’s', 'thereupon', 'there’ve'
    , 'these', 'they', 'they’d', 'they’ll', 'they’re', 'they’ve', 'thing', 'things', 'think', 'third', 'thirty', 'this', 'thorough', 'thoroughly'
    , 'those', 'though', 'three', 'through', 'throughout', 'thru', 'thus', 'till', 'to', 'together', 'too', 'took', 'toward', 'towards', 'tried',
    'tries', 'truly', 'try', 'trying', 't’s', 'twice', 'two', 'u', 'un', 'under', 'underneath', 'undoing', 'unfortunately', 'unless', 'unlike',
    'unlikely', 'until', 'unto', 'up', 'upon', 'upwards', 'us', 'use', 'used', 'useful', 'uses', 'using', 'usually', 'v', 'value', 'various', 'versus'
    , 'very', 'via', 'viz', 'vs', 'w', 'want', 'wants', 'was', 'wasn’t', 'way', 'we', 'we’d', 'welcome', 'well', 'we’ll', 'went', 'were', 'we’re', 'weren’t'
    , 'we’ve', 'what', 'whatever', 'what’ll', 'what’s', 'what’ve', 'when', 'whence', 'whenever', 'where', 'whereafter', 'whereas', 'whereby', 'wherein'
    , 'where’s', 'whereupon', 'wherever', 'whether', 'which', 'whichever', 'while', 'whilst', 'whither', 'who', 'who’d', 'whoever', 'whole', 'who’ll'
    , 'whom', 'whomever', 'who’s', 'whose', 'why', 'will', 'willing', 'wish', 'with', 'within', 'without', 'wonder', 'won’t', 'would', 'wouldn’t', 'x'
    , 'y', 'yes', 'yet', 'you', 'you’d', 'you’ll', 'your', 'you’re', 'yours', 'yourself', 'yourselves', 'you’ve', 'z', 'zero', 'admin'
);



$config['Project']['status']['proposal'] = array(
    'public' => IS_NOT_PUBLIC,
    'enabled' => IS_DISABLED,
    'status' => PROJECT_STATUS_NEW
);

$config['Project']['status']['accepted'] = array(
    'public' => IS_NOT_PUBLIC,
    'enabled' => IS_ENABLED,
    'status' => PROJECT_STATUS_APROVED,
    'important' => IS_NOT_IMPORTANT
);

$config['Project']['status']['important'] = array(
    'public' => IS_NOT_PUBLIC,
    'enabled' => IS_ENABLED,
    'status' => PROJECT_STATUS_APROVED,
    'important' => IS_IMPORTANT
);

$config['Project']['status']['rejected'] = array(
    'public' => IS_NOT_PUBLIC,
    'enabled' => IS_DISABLED,
    'status' => PROJECT_STATUS_REJECTED
);


$config['Offer']['status']['proposal'] = array(
    'public' => IS_NOT_PUBLIC,
    'enabled' => IS_DISABLED,
    'status' => OFFER_STATUS_NEW
);

$config['Offer']['status']['proposal-accepted'] = array(
    'public' => IS_NOT_PUBLIC,
    'enabled' => IS_ENABLED,
    'status' => OFFER_STATUS_APROVED
);

$config['Offer']['status']['proposal-rejected'] = array(
    'public' => IS_NOT_PUBLIC,
    'enabled' => IS_DISABLED,
    'status' => OFFER_STATUS_REJECTED
);


/* ------------------------------------------------------------------------- */


$config['Project']['filter']['status']['public'] = array('Project.public' => IS_PUBLIC, 'Project.enabled' => IS_ENABLED,);
$config['Project']['filter']['status']['disabled'] = array('Project.public' => IS_PUBLIC, 'Project.enabled' => IS_DISABLED);
$config['Project']['filter']['status']['proposal'] = array('Project.status' => PROJECT_STATUS_NEW);
$config['Project']['filter']['status']['accepted'] = array('Project.status' => PROJECT_STATUS_APROVED); //, 'Project.important' => IS_NOT_IMPORTANT
$config['Project']['filter']['status']['rejected'] = array('Project.status' => PROJECT_STATUS_REJECTED);
$config['Project']['filter']['status']['published'] = am($config['Project']['filter']['status']['public'], array('Project.status' => PROJECT_STATUS_PUBLISHED));
$config['Project']['filter']['status']['important'] = am($config['Project']['filter']['status']['accepted'], array('Project.important' => IS_IMPORTANT));
$config['Project']['filter']['outstanding'] = am($config['Project']['filter']['status']['public'], array('Project.outstanding' => ACTIVE));
$config['Project']['filter']['leading'] = am($config['Project']['filter']['status']['published'], array('Project.leading' => ACTIVE));
$config['Project']['filter']['about-to-finish'] = array('Project.end_date >=' => date('Y-m-d'), 'Project.end_date <=' => date('Y-m-d', strtotime("+7 days")));
$config['Project']['filter']['about-to-finish'] = am($config['Project']['filter']['status']['published'], $config['Project']['filter']['about-to-finish']);
$config['Project']['filter']['finished'] = array('Project.end_date <=' => date('Y-m-d'));
$config['Project']['filter']['finished'] = am($config['Project']['filter']['status']['published'], $config['Project']['filter']['finished']);
$config['Project']['filter']['funded'] = array(am($config['Project']['filter']['finished'], array('Project.status' => PROJECT_FUNDED)));
$config['Project']['filter']['not-funded'] = array(am($config['Project']['filter']['finished'], array('Project.status' => PROJECT_NOT_FUNDED)));

/* ---------------------------------------------------------------------------------------------------------------------------- */

$config['Offer']['filter']['status']['public'] = array('Offer.public' => IS_PUBLIC, 'Offer.enabled' => IS_ENABLED,);
$config['Offer']['filter']['status']['disabled'] = array('Offer.public' => IS_PUBLIC, 'Offer.enabled' => IS_DISABLED);
$config['Offer']['filter']['status']['proposal'] = array('Offer.status' => OFFER_STATUS_NEW);
$config['Offer']['filter']['status']['proposal-accepted'] = array('Offer.status' => OFFER_STATUS_APROVED);
$config['Offer']['filter']['status']['proposal-rejected'] = array('Offer.status' => OFFER_STATUS_REJECTED);
$config['Offer']['filter']['status']['published'] = array('Offer.public' => IS_PUBLIC, 'Offer.enabled' => IS_ENABLED, 'Offer.status' => OFFER_STATUS_PUBLISHED);
$config['Offer']['filter']['outstanding'] = am($config['Offer']['filter']['status']['public'], array('Offer.outstanding' => ACTIVE));
$config['Offer']['filter']['leading'] = am($config['Offer']['filter']['status']['published'], array('Offer.leading' => ACTIVE));
$config['Offer']['filter']['about-to-finish'] = array('Offer.end_date >=' => date('Y-m-d'), 'Offer.end_date <=' => date('Y-m-d', strtotime("+7 days")));
$config['Offer']['filter']['about-to-finish'] = am($config['Offer']['filter']['status']['published'], $config['Offer']['filter']['about-to-finish']);
$config['Offer']['filter']['finished'] = array('Offer.end_date <=' => date('Y-m-d'));
$config['Offer']['filter']['finished'] = am($config['Offer']['filter']['status']['published'], $config['Offer']['filter']['finished']);

 

   
 
 
                    
$config['Paypal']['payment']['status'] = array(
    'CANCELED_REVERSAL' => PAYPAL_STATUS_CANCELED_REVERSAL,
    'COMPLETED' => PAYPAL_STATUS_COMPLETED,
    'CREATED' => PAYPAL_STATUS_CREATED,
    'DENIED' => PAYPAL_STATUS_DENIED,
    'EXPIRED' => PAYPAL_STATUS_EXPIRED,
    'FAILED' => PAYPAL_STATUS_FAILED,
    'PENDING' => PAYPAL_STATUS_PENDING,
    'REFUNDED' => PAYPAL_STATUS_REFUNDED,
    'REVERSED' => PAYPAL_STATUS_REVERSED,
    'PROCESSED' => PAYPAL_STATUS_PROCESSED,
    'VOIDED' => PAYPAL_STATUS_VOIDED,
);



$config['Paypal']['preapproval']['status'] = array(
    'ACTIVE' => PAYPAL_PREAPPROVAL_ACTIVE,
    'CANCELED' => PAYPAL_PREAPPROVAL_CANCELED,
    'DEACTIVED' => PAYPAL_PREAPPROVAL_DEACTIVED,
);


$config['Sponsorship']['status']  = array(
    SPONSORSHIP_STATUS_INCOMPLETE => 'INCOMPLETE' ,
    SPONSORSHIP_STATUS_COMPLETE => 'COMPLETE' ,
);


//*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------*//
?>