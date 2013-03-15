<?php



error_reporting(E_ALL);

set_time_limit(0);

ini_set("memory_limit", "512M");

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('ROOT')) {
    define('ROOT', dirname(dirname(dirname(dirname(dirname(__FILE__)))))); // OK
}


if (!defined('APP_DIR')) {
		define('APP_DIR', basename(dirname(dirname(dirname(dirname(__FILE__))))));
}


if (!defined('CAKE_CORE_INCLUDE_PATH')) {
    define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . 'cake'); //
}



if (!defined('WEBROOT_DIR')) {
    define('WEBROOT_DIR', ROOT . DS . APP_DIR . DS . 'webroot');
}
if (!defined('WWW_ROOT')) {
    define('WWW_ROOT', WEBROOT_DIR . DS);
}
if (!defined('CORE_PATH')) {
    if (function_exists('ini_set') && ini_set('include_path', CAKE_CORE_INCLUDE_PATH . PATH_SEPARATOR . ROOT . DS . APP_DIR . DS . PATH_SEPARATOR . ini_get('include_path'))) {
        define('APP_PATH', null);
        define('CORE_PATH', null);
    } else {
        define('APP_PATH', ROOT . DS . APP_DIR . DS);
        define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
    }
}

if (!defined('APP')) {
    define('APP', ROOT . DS . APP_DIR . DS);
}

if (!defined('CONFIGS')) {
    define('CONFIGS', APP_PATH . 'config/');
}

/* -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */


include_once APP_PATH . 'config/bootstrap.php';

include_once APP_PATH . 'config/database.php';

include_once APP_PATH . 'config/config.php';


define('LOG_IGNORED', FALSE); // create a sql file
define('CREATE_SQL', TRUE); // create a sql file
define('CREATE_CITIES', TRUE); // create cities records
define('OPTIMIZE_TABLE', FALSE); // optimize table at end of all
define('TRUNCATE_TABLE', TRUE); // (true)INSERT OR (false)UPDATE RECORDS
define('UPDATE_DATA', FALSE); // (true)INSERT OR (false)UPDATE RECORDS
define('EXEC_QUERY', TRUE); // EXEC QUERYS
define('MIN_COUNTRY_POP', 2500000); // paises con al menos x habitantes
define('MIN_CITY_POP', 0); // ciudades con al menos x habitantes
define('CITIES_FROM', 0); // ciudades con al menos x habitantes
define('DOWNLOAD_SOURCES', FALSE);
define('CREATE_COUNTRIES_LIST', FALSE);
define('ADD_EMPTY_COUNTRIES', TRUE); // use somewhere cities for countries without cities
define('ADD_ALL_COUNTRIES', FALSE); // use somewhere cities for countries with cities



/* ------------------------------------------------------------------------ */
define('INSERT_QUERY_STRING', "INSERT  DELAYED INTO cities (`id`,`search_text`,`city`,`city_name`, `admin_code`,`country`,`country_code`, `city_soundex` ,  `search_text_other` , `population`,`city_full_name` , `city_ascii` ,`city_slug` ,`country_slug` , `admin_code_ascii` ) values ('%s' ,'%s','%s' ,'%s' ,'%s' ,'%s','%s' ,'%s','%s','%s','%s','%s','%s','%s','%s') ;");
define('UPDATE_QUERY_STRING', "REPLACE INTO `cities` SET `id` = '%s' , `search_text` = '%s' , `city` = '%s' , `city_name` = '%s' , `admin_code` = '%s' , `country` = '%s'  ,  `country_code` = '%s'  ,  `city_soundex` = '%s'  ,  `search_text_other` = '%s'  ,  `population` = '%s'  ,  `city_full_name` = '%s'  ,  `city_ascii` = '%s'  ,  `city_slug` = '%s'  ,  `country_slug` = '%s'  ,  `admin_code_ascii` = '%s'  ; ");


global $featuredClasses;
global $featureCodes;
global $includedCountries;
global $excludedCountries;


$includedCountries = array();
$excludedCountries = array();
$featuredClasses = array('A'); //, 'P');

$dbConfig = new DATABASE_CONFIG();

$link = mysql_connect($dbConfig->default['host'], $dbConfig->default['login'], $dbConfig->default['password']);

$db_selected = mysql_select_db($dbConfig->default['database'], $link);

function my_str_split($string) {
    $slen = strlen($string);
    for ($i = 0; $i < $slen; $i++) {
        $sArray[$i] = $string{$i};
    }
    return $sArray;
}

function noDiacritics($string) {
    //cyrylic transcription
    $cyrylicFrom = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $cyrylicTo = array('A', 'B', 'W', 'G', 'D', 'Ie', 'Io', 'Z', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'Ch', 'C', 'Tch', 'Sh', 'Shtch', '', 'Y', '', 'E', 'Iu', 'Ia', 'a', 'b', 'w', 'g', 'd', 'ie', 'io', 'z', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'ch', 'c', 'tch', 'sh', 'shtch', '', 'y', '', 'e', 'iu', 'ia');


    $from = array("Á", "À", "Â", "Ä", "Ă", "Ā", "Ã", "Å", "Ą", "Æ", "Ć", "Ċ", "Ĉ", "Č", "Ç", "Ď", "Đ", "Ð", "É", "È", "Ė", "Ê", "Ë", "Ě", "Ē", "Ę", "Ə", "Ġ", "Ĝ", "Ğ", "Ģ", "á", "à", "â", "ä", "ă", "ā", "ã", "å", "ą", "æ", "ć", "ċ", "ĉ", "č", "ç", "ď", "đ", "ð", "é", "è", "ė", "ê", "ë", "ě", "ē", "ę", "ə", "ġ", "ĝ", "ğ", "ģ", "Ĥ", "Ħ", "I", "Í", "Ì", "İ", "Î", "Ï", "Ī", "Į", "Ĳ", "Ĵ", "Ķ", "Ļ", "Ł", "Ń", "Ň", "Ñ", "Ņ", "Ó", "Ò", "Ô", "Ö", "Õ", "Ő", "Ø", "Ơ", "Œ", "ĥ", "ħ", "ı", "í", "ì", "i", "î", "ï", "ī", "į", "ĳ", "ĵ", "ķ", "ļ", "ł", "ń", "ň", "ñ", "ņ", "ó", "ò", "ô", "ö", "õ", "ő", "ø", "ơ", "œ", "Ŕ", "Ř", "Ś", "Ŝ", "Š", "Ş", "Ť", "Ţ", "Þ", "Ú", "Ù", "Û", "Ü", "Ŭ", "Ū", "Ů", "Ų", "Ű", "Ư", "Ŵ", "Ý", "Ŷ", "Ÿ", "Ź", "Ż", "Ž", "ŕ", "ř", "ś", "ŝ", "š", "ş", "ß", "ť", "ţ", "þ", "ú", "ù", "û", "ü", "ŭ", "ū", "ů", "ų", "ű", "ư", "ŵ", "ý", "ŷ", "ÿ", "ź", "ż", "ž");
    $to = array("A", "A", "A", "A", "A", "A", "A", "A", "A", "AE", "C", "C", "C", "C", "C", "D", "D", "D", "E", "E", "E", "E", "E", "E", "E", "E", "G", "G", "G", "G", "G", "a", "a", "a", "a", "a", "a", "a", "a", "a", "ae", "c", "c", "c", "c", "c", "d", "d", "d", "e", "e", "e", "e", "e", "e", "e", "e", "g", "g", "g", "g", "g", "H", "H", "I", "I", "I", "I", "I", "I", "I", "I", "IJ", "J", "K", "L", "L", "N", "N", "N", "N", "O", "O", "O", "O", "O", "O", "O", "O", "CE", "h", "h", "i", "i", "i", "i", "i", "i", "i", "i", "ij", "j", "k", "l", "l", "n", "n", "n", "n", "o", "o", "o", "o", "o", "o", "o", "o", "o", "R", "R", "S", "S", "S", "S", "T", "T", "T", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "W", "Y", "Y", "Y", "Z", "Z", "Z", "r", "r", "s", "s", "s", "s", "B", "t", "t", "b", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "w", "y", "y", "y", "z", "z", "z");


    $from = array_merge($from, $cyrylicFrom);
    $to = array_merge($to, $cyrylicTo);

    $newstring = str_replace($from, $to, $string);
    return $newstring;
}

function makeSlugs($string, $maxlen=0) {
    $newStringTab = array();
    $string = strtolower(noDiacritics($string));
    if (function_exists('str_split')) {
        $stringTab = str_split($string);
    } else {
        $stringTab = my_str_split($string);
    }

    $numbers = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-");
    //$numbers=array("0","1","2","3","4","5","6","7","8","9");

    foreach ($stringTab as $letter) {
        if (in_array($letter, range("a", "z")) || in_array($letter, $numbers)) {
            $newStringTab[] = $letter;
            //print($letter);
        } elseif ($letter == " ") {
            $newStringTab[] = "-";
        }
    }

    if (count($newStringTab)) {
        $newString = implode($newStringTab);
        if ($maxlen > 0) {
            $newString = substr($newString, 0, $maxlen);
        }

        $newString = removeDuplicates('--', '-', $newString);
    } else {
        $newString = '';
    }

    return $newString;
}

function checkSlug($sSlug) {
    if (ereg("^[a-zA-Z0-9]+[a-zA-Z0-9\_\-]*$", $sSlug)) {
        return true;
    }

    return false;
}

function removeDuplicates($sSearch, $sReplace, $sSubject) {
    $i = 0;
    do {

        $sSubject = str_replace($sSearch, $sReplace, $sSubject);
        $pos = strpos($sSubject, $sSearch);

        $i++;
        if ($i > 100) {
            die('removeDuplicates() loop error');
        }
    } while ($pos !== false);

    return $sSubject;
}

function escape($str) {
    $search = array("\\", "\0", "\n", "\r", "\r\n", "\x1a", "'", '"');
    $replace = array("\\\\", "\\0", "", "", "", "\Z", "\'", '\"');
    return str_replace($search, $replace, trim($str));
}

function env($key) {
    if ($key == 'HTTPS') {
        if (isset($_SERVER['HTTPS'])) {
            return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
        }
        return (strpos(env('SCRIPT_URI'), 'https://') === 0);
    }

    if ($key == 'SCRIPT_NAME') {
        if (env('CGI_MODE') && isset($_ENV['SCRIPT_URL'])) {
            $key = 'SCRIPT_URL';
        }
    }

    $val = null;
    if (isset($_SERVER[$key])) {
        $val = $_SERVER[$key];
    } elseif (isset($_ENV[$key])) {
        $val = $_ENV[$key];
    } elseif (getenv($key) !== false) {
        $val = getenv($key);
    }

    if ($key === 'REMOTE_ADDR' && $val === env('SERVER_ADDR')) {
        $addr = env('HTTP_PC_REMOTE_ADDR');
        if ($addr !== null) {
            $val = $addr;
        }
    }

    if ($val !== null) {
        return $val;
    }

    switch ($key) {
        case 'SCRIPT_FILENAME':
            if (defined('SERVER_IIS') && SERVER_IIS === true) {
                return str_replace('\\\\', '\\', env('PATH_TRANSLATED'));
            }
            break;
        case 'DOCUMENT_ROOT':
            $name = env('SCRIPT_NAME');
            $filename = env('SCRIPT_FILENAME');
            $offset = 0;
            if (!strpos($name, '.php')) {
                $offset = 4;
            }
            return substr($filename, 0, strlen($filename) - (strlen($name) + $offset));
            break;
        case 'PHP_SELF':
            return str_replace(env('DOCUMENT_ROOT'), '', env('SCRIPT_FILENAME'));
            break;
        case 'CGI_MODE':
            return (PHP_SAPI === 'cgi');
            break;
        case 'HTTP_BASE':
            $host = env('HTTP_HOST');
            $parts = explode('.', $host);
            $count = count($parts);

            if ($count === 1) {
                return '.' . $host;
            } elseif ($count === 2) {
                return '.' . $host;
            } elseif ($count === 3) {
                $gTLD = array('aero', 'asia', 'biz', 'cat', 'com', 'coop', 'edu', 'gov', 'info', 'int', 'jobs', 'mil', 'mobi', 'museum', 'name', 'net', 'org', 'pro', 'tel', 'travel', 'xxx');
                if (in_array($parts[1], $gTLD)) {
                    return '.' . $host;
                }
            }
            array_shift($parts);
            return '.' . implode('.', $parts);
            break;
    }
    return null;
}

function getList($h, $titles=false, $ignore=false, $max = 0, $from = 0) {
    if ($h) {
        $aux = 0;
        $cList = array();
        while (!feof($h)) {
            $buffer = fgets($h, 1024);
            $values = str_getcsv($buffer, "\t");
            if ($aux == 0) {
                $cListKeys = $titles ? explode("\t", $titles) : $values;
            } else {
                if ($from == 0 || $aux >= $from) {
                    foreach ($cListKeys as $pos => $key) {
                        //    $key=strtolower(preg_replace("/\r\n|\n*$/", "", $key)); //strtolower(Inflector::slug(preg_replace("/\r\n|\n*$/", "", $key)));

                        if ($ignore === false || ( is_array($ignore) && !in_array($key, $ignore) )) {
                            @$cList[$values[0]][$key] = $values[$pos]; //escape();
                        }
                    }
                }
            }
            $aux++;
            if ($max > 0 && ( $max + $from ) == $aux) {
                break;
            }
        }
        fclose($h);
    }
    return $cList;
}

function downloadCountries() {
    $aux = fopen('sources/countryInfo.txt', "r");
    $cList['countryInfo'] = getList($aux);
    $done = true;
    foreach ($cList['countryInfo'] as $code => $country) {
        if ($code == 'GT') {
            $done = false;
        }
        if ($code != '' && !$done) {
            $cmd = "cd sources/cities && wget http://download.geonames.org/export/dump/$code.zip && unzip  -o $code.zip && rm $code.zip ";
            echo shell_exec($cmd) . "\r\n\r\n\r\n";
        }
    }

    $files = array();
    foreach ($cList['countryInfo'] as $code => $country) {
        if (!file_exists("sources/cities/$code.txt") && $code != '') {
            $files[] = "$code.txt";
        }
    }

    if (count($files) > 0) {
        $text = count($files) == 1 ? 'el archivo ' : 'los archivos ';
        echo "Error en " . $text . implode(', ', $files) . "\r\n";
    }
}

function createCountriesList() {
    $aux = fopen('sources/countryInfo.txt', "r");
    $cList['countryInfo'] = getList($aux);
    $fileName = "countries_list.php";
    @unlink($fileName);
    $fp = fopen($fileName, 'w');
    fwrite($fp, "<? \r\n \$countries = array ( \r\n ");
    foreach ($cList['countryInfo'] as $code => $country) {
        if ($code != '') {
            $countries[] = "'$code' /* {$country['Country']} */ ";
        }
    }
    fwrite($fp, implode(", \r\n\t", $countries));
    fwrite($fp, "\r\n);\r\n?>");
    fclose($fp);
}

function getListCity($includedCountries = array(), $excludedCountries =array(), $titles=false, $ignore=false, $featuredClasses=array('A', 'P')) {

    $aux = fopen('sources/countryInfo.txt', "r");
    $cList['countryInfo'] = getList($aux);

    $aux = fopen('sources/admin1CodesASCII.txt', "r");
    $cList['admin1CodesASCII'] = getList($aux);

    $cListKeys = explode(";", $titles); // field headers


    if (empty($includedCountries)) {
        $text = " Se prosesaran todos los paises ";
    } else {
        $text = " Se prosesaran los paises " . implode(', ', $includedCountries);
    }

    if (!empty($excludedCountries)) {
        $text .= " exepto " . implode(', ', $excludedCountries);
    }

    echo "\r\n\r\n___________________________________________________________________________________\r\n\r\n";
    echo $text . "\r\n___________________________________________________________________________________\r\n\r\n";




    foreach ($cList['countryInfo'] as $code => $country) {



        $aux = 0;
        if (!in_array($code, $excludedCountries) && $code != '') {
            $hasCities = false;
            $fp = null;

            $parseCountry = empty($includedCountries) ? true : in_array($code, $includedCountries);

            if (CREATE_SQL && $parseCountry) {
                $fileName = ( TRUNCATE_TABLE ) || (!UPDATE_DATA ) ? "sql/insert/city_$code.sql" : "sql/update/update_city_$code.sql";
                @unlink($fileName);
                $fp = fopen($fileName, 'w');
            }

            $parseCountry = $parseCountry && empty($includedCountries) ? ( $country['Population'] > MIN_COUNTRY_POP || MIN_COUNTRY_POP == 0 ? true : false ) : $parseCountry;


            if ($parseCountry) {

                if (TRUNCATE_TABLE) {
                    echo "[*] Borrando todas las ciudades de {$country['Country']} tabla.\r\n";
                    mysql_query("DELETE FROM `cities` WHERE country_code = '$code';");
                }

                echo "[*] Comenzamos procesamiento de ciudades para : " . $country['Country'] . "\r\n";
                $cities = file("sources/cities/$code.txt");
                if ($cities) {
                    echo "\t[*] Archivo de ciudades cargado \r\n";
                } else {

                    echo "\t[X] Archivo de ciudades NO cargado \r\n";
                }
                $aux = 0;


                foreach ($cities as $key => $buffer) {
                    $values = str_getcsv($buffer, "\t");
                    foreach ($cListKeys as $pos => $n) {
                        $city[$n] = $values[$pos];
                    }

                    $proc = procCity($city, $cList, $featuredClasses, $fp);

                    echo "\t  [ " . str_pad(number_format($key, 0, ',', '.'), 10, "0", STR_PAD_LEFT) . " ] Procesadas \r";

                    if ($proc) {
                        $aux++;
                        $hasCities = true;
                    }
                }
                if (ADD_ALL_COUNTRIES) {
                    genEmptyCountries($country, $fp);
                }
                echo "\r\n\t  [ " . str_pad(number_format($aux, 0, ',', '.'), 10, "0", STR_PAD_LEFT) . " ] Insertadas";
                echo "\r\n___________________________________________________________________________________\r\n\r\n";
                $small = false;
                $parsed = true;
            } elseif (empty($includedCountries)) {
                echo $country['Country'] . " Auto-ignorado por ser muy pequeño \r\n\r\n___________________________________________________________________________________\r\n\r\n";
                $small = true;
                $parsed = false;
            }


            if (ADD_EMPTY_COUNTRIES && !$hasCities && ( in_array($code, $includedCountries) || empty($includedCountries) )) {
                genEmptyCountries($country, $fp);
            }

            if (CREATE_SQL && ( in_array($code, $includedCountries) || empty($includedCountries) )) {
                fclose($fp);
                unset($fp);
            }
        }
    }
}

function genEmptyCountries($country, &$fp = null) {
    echo $country['Country'] . " - Se agrego como empty country \r\n\r\n___________________________________________________________________________________\r\n\r\n";
    $code = $country['ISO'];
    if (empty($fp)) {
        $created = true;
        $fileName = ( TRUNCATE_TABLE ) || (!UPDATE_DATA ) ? "sql/insert/city_$code.sql" : "sql/update/update_city_$code.sql";
        @unlink($fileName);
        $fp = fopen($fileName, 'w');
    } else {
        $created = false;
    }

    $sqlR = (( TRUNCATE_TABLE ) || (!UPDATE_DATA )) ? INSERT_QUERY_STRING : UPDATE_QUERY_STRING;




    $city_sql['id'] = str_pad($country['ISO-Numeric'], 9, "9", STR_PAD_LEFT);
    $city_sql['search_text'] = escape($country['Country']);
    $city_sql['city'] = escape($country['Country']);
    $city_sql['city_name'] = escape($country['Country']);
    $city_sql['admin_code'] = escape($country['Country']);
    $city_sql['country'] = escape($country['Country']);
    $city_sql['country_code'] = escape($code);
    $city_sql['city_full_name'] = escape($country['Country']);


    $city_sql['city_soundex'] = soundex(escape($country['Country']));
    $city_sql['search_text_other'] = strtolower(escape($country['Country']));
    $city_sql['population'] = $country['Population'];


    // var_dump($city_sql);
    $r = sprintf($sqlR
            , $city_sql['id']
            , $city_sql['search_text']
            , $city_sql['city']
            , $city_sql['city_name']
            , $city_sql['admin_code']
            , $city_sql['country']
            , $city_sql['country_code']
            , $city_sql['city_soundex']
            , $city_sql['search_text_other']
            , $city_sql['population']
            , $city_sql['city_full_name']
            , makeSlugs($country['Country'])
            , strtolower(makeSlugs($country['Country'])) // slug
            , strtolower(makeSlugs($country['Country'])) // slug
            , makeSlugs($country['Country'])
    );


    if (CREATE_SQL) {
        fwrite($fp, $r . " \r\n");
    }

    if (EXEC_QUERY) {
        $result = mysql_query($r);
    }

    if ($created) {
        fclose($fp);
        unset($fp);
    }
}

function procCity($city, $cList, $featuredClasses, &$fp) {

    $ret = false;

    $sqlR = (( TRUNCATE_TABLE ) || (!UPDATE_DATA )) ? INSERT_QUERY_STRING : UPDATE_QUERY_STRING;

    $aCode = $city['country code'] . '.' . $city['admin1 code'];

    // $featureCodes = array( 'ADM4' , '' );

    $featuredClasses = array('A', 'P'); //'A' ,

    $featureCodes = array(
        'ADM1' // , 'ADM2' , 'ADM3'  , // provincias y partidos
            //'PPLS' , 'PPL' , 'PPLC' , 'PPLL' /* P */  // localidades
    );

    if (
            ( in_array($city['feature class'], $featuredClasses) || empty($featuredClasses))
            && ( in_array($city['feature code'], $featureCodes) || empty($featureCodes) )
            && (
            $city['population'] > MIN_CITY_POP
            || MIN_CITY_POP == 0
            || $city['population'] == ''
            || $city['population'] == '0'
            )
    ) {



        $admin_code = $cList['admin1CodesASCII'][$aCode][2];
        $admin_code_ascii = $cList['admin1CodesASCII'][$aCode][3];

        if ($admin_code != '') {

            $s = $city['name'] != $admin_code ? $admin_code : '';

            $s = $s != '' ? $s : '';

            $cityName = $city['name'] . $s; // . ' (' . $cList['countryInfo'][$city['country code']]['Country']  . ')' ;


            $city_sql = array();




            /* geonameid;name;asciiname;alternatenames;
             * latitude;longitude;feature class;feature code;country code
             * ;cc2;admin1 code;admin2 code;admin3 code;admin4 code;population;elevation;gtopo30;timezone;modification date";
             */

            //   $city_sql['city'] = escape($city['name']);
            //$city_sql['city_name'] = escape($cityName);
            // $city_sql['city_full_name'] = escape($city['name'] . $s . ' (' . $cList['countryInfo'][$city['country code']]['Country'] . ')'); // . $city['population']
            /*
              $city_sql['city'] = escape($city['name']);
              $city_sql['city_name'] = escape($city['name']);
              $city_sql['city_ascii'] = noDiacritics(escape($city['name']));

              $city_sql['admin_code'] = escape($city['asciiname']);
              $city_sql['admin_code_ascii'] = noDiacritics(escape($city['asciiname']));
             */



            $city_sql['city'] = escape($admin_code);
            $city_sql['city_ascii'] = noDiacritics(escape($city_sql['city']));
            $city_sql['search_text'] = strtolower(escape(implode(' ', array_unique(explode(' ', implode(' ', $city_sql))))));

            /* -- */

            $city_sql['city_name'] = escape($admin_code . ', ' . $cList['countryInfo'][$city['country code']]['Country']);  // city display name
            $city_sql['country'] = escape($cList['countryInfo'][$city['country code']]['Country']);
            $city_sql['admin_code'] = $city_sql['city'];
            $city_sql['admin_code_ascii'] = noDiacritics(escape($city_sql['admin_code']));
            $city_sql['city_full_name'] = escape($admin_code . ', ' . $cList['countryInfo'][$city['country code']]['Country']); // . $city['population']
            $city_sql['search_text_other'] = strtolower(escape(implode(' ', array_unique(explode(' ', implode(' ', $city_sql))))));

            /* ----------------------------------------------------------- */
            $city_sql['country_code'] = $city['country code'];
            $city_sql['id'] = $city['geonameid'];
            $city_sql['city_soundex'] = soundex(escape($city_sql['city_ascii']));
            $city_sql['population'] = !empty($city['population']) ? $city['population'] : 0;

            $r = sprintf($sqlR
                    , $city_sql['id']
                    , $city_sql['search_text']
                    , $city_sql['city']
                    , $city_sql['city_name']
                    , $city_sql['admin_code']
                    , $city_sql['country']
                    , $city_sql['country_code']
                    , $city_sql['city_soundex']
                    , $city_sql['search_text_other']
                    , $city_sql['population']
                    , $city_sql['city_full_name']
                    , $city_sql['city_ascii']
                    , strtolower(makeSlugs($city_sql['city_ascii'])) // slug
                    , strtolower(makeSlugs($cList['countryInfo'][$city['country code']]['Country'])) // slug
                    , $city_sql['admin_code_ascii']
            );




            if (CREATE_SQL) {
                fwrite($fp, $r . " \r\n");
            }

            if (EXEC_QUERY) {
                $result = mysql_query($r);
            }


            if ($result || !EXEC_QUERY) {
                @mysql_free_result($result);
                $ret = "Procesando ciudad : " . $city_sql['city_full_name'];
            } else {
                $ret = "Error al Procesar ciudad : " . $city_sql['city_full_name'];
            }
        }
    }
    unset($city_sql);
    unset($r);
    unset($s);
    unset($cityName);
    unset($admin_code);
    unset($sqlR);
    unset($city);
    unset($result);
    unset($cList);

    return $ret;
}

?>
