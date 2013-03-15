<?php

include_once '../common/init.php';
include_once APP . '../cake' . DS . 'libs' . DS . 'inflector.php';
include_once 'countries_list.php';

/*
  echo "BORRANDO TABLA \r\n\r\n\r\n";
  mysql_query("TRUNCATE TABLE `cities`;");
 */

if (CREATE_COUNTRIES_LIST) {
    createCountriesList();
}

if (DOWNLOAD_SOURCES) {
    downloadCountries();
}


$enabled['AE'] = 'AE'; // Emiratos Árabes Unidos
$enabled['AF'] = 'AF'; // Afganistán
$enabled['AM'] = 'AM'; // Armenia
$enabled['AR'] = 'AR'; // Argentina
$enabled['AT'] = 'AT'; // Austria
$enabled['AU'] = 'AU'; // Australia
$enabled['AW'] = 'AW'; // Aruba
$enabled['BE'] = 'BE'; // Bélgica
$enabled['BG'] = 'BG'; // Bulgaria
$enabled['BO'] = 'BO'; // Bolivia
$enabled['BR'] = 'BR'; // Brasil
$enabled['BZ'] = 'BZ'; // Belice
$enabled['CA'] = 'CA'; // Canadá
$enabled['CI'] = 'CI'; // Costa de Marfil
$enabled['CL'] = 'CL'; // Chile
$enabled['CM'] = 'CM'; // Camerún
$enabled['CN'] = 'CN'; // China
$enabled['CO'] = 'CO'; // Colombia
$enabled['CR'] = 'CR'; // Costa Rica
$enabled['CU'] = 'CU'; // Cuba
$enabled['CZ'] = 'CZ'; // República Checa
$enabled['CH'] = 'CH'; // Suiza
$enabled['DE'] = 'DE'; // Alemania
$enabled['DK'] = 'DK'; // Dinamarca
$enabled['DO'] = 'DO'; // República Dominicana
$enabled['DZ'] = 'DZ'; // Argelia
$enabled['EC'] = 'EC'; // Ecuador
$enabled['EE'] = 'EE'; // Estonia
$enabled['EG'] = 'EG'; // Egipto
$enabled['ES'] = 'ES'; // España
$enabled['FI'] = 'FI'; // Finlandia
$enabled['FR'] = 'FR'; // Francia
$enabled['GB'] = 'GB'; // Reino Unido
$enabled['GQ'] = 'GQ'; // Guinea Ecuatorial
$enabled['GR'] = 'GR'; // Grecia
$enabled['GT'] = 'GT'; // Guatemala
$enabled['GY'] = 'GY'; // Guyana
$enabled['HK'] = 'HK'; // Hong Kong
$enabled['HN'] = 'HN'; // Honduras
$enabled['HR'] = 'HR'; // Croacia
$enabled['HT'] = 'HT'; // Haití
$enabled['HU'] = 'HU'; // Hungría
$enabled['ID'] = 'ID'; // Indonesia
$enabled['IE'] = 'IE'; // Irlanda
$enabled['IL'] = 'IL'; // Israel
$enabled['IN'] = 'IN'; // India
$enabled['IQ'] = 'IQ'; // Iraq
$enabled['IR'] = 'IR'; // Irán
$enabled['IS'] = 'IS'; // Islandia
$enabled['IT'] = 'IT'; // Italia
$enabled['JE'] = 'JE'; // Jersey
$enabled['JM'] = 'JM'; // Jamaica
$enabled['JO'] = 'JO'; // Jordania
$enabled['JP'] = 'JP'; // Japón
$enabled['KE'] = 'KE'; // Kenia
$enabled['KP'] = 'KP'; // Corea del Norte
$enabled['KR'] = 'KR'; // Corea del Sur
$enabled['LU'] = 'LU'; // Luxemburgo
$enabled['MA'] = 'MA'; // Marruecos
$enabled['MN'] = 'MN'; // Mongolia
$enabled['MX'] = 'MX'; // México
$enabled['MY'] = 'MY'; // Malasia
$enabled['NG'] = 'NG'; // Nigeria
$enabled['NI'] = 'NI'; // Nicaragua
$enabled['NO'] = 'NO'; // Noruega
$enabled['NP'] = 'NP'; // Nepal
$enabled['NZ'] = 'NZ'; // Nueva Zelanda
$enabled['PA'] = 'PA'; // Panamá
$enabled['PE'] = 'PE'; // Perú
$enabled['PH'] = 'PH'; // Filipinas
$enabled['PK'] = 'PK'; // Pakistán
$enabled['PL'] = 'PL'; // Polonia
$enabled['PR'] = 'PR'; // Puerto Rico
$enabled['PS'] = 'PS'; // Palestina
$enabled['PT'] = 'PT'; // Portugal
$enabled['PY'] = 'PY'; // Paraguay
$enabled['RO'] = 'RO'; // Rumania
$enabled['RS'] = 'RS'; // Serbia
$enabled['RU'] = 'RU'; // Rusia
$enabled['SA'] = 'SA'; // Arabia Saudí
$enabled['SD'] = 'SD'; // Sudán
$enabled['SE'] = 'SE'; // Suecia
$enabled['SI'] = 'SI'; // Eslovenia
$enabled['SK'] = 'SK'; // Eslovaquia
$enabled['SN'] = 'SN'; // Senegal
$enabled['SO'] = 'SO'; // Somalia
$enabled['SR'] = 'SR'; // Surinam
$enabled['SV'] = 'SV'; // El Salvador
$enabled['TG'] = 'TG'; // Togo
$enabled['TR'] = 'TR'; // Turquía
$enabled['TW'] = 'TW'; // Taiwán
$enabled['TZ'] = 'TZ'; // Tanzania
$enabled['UA'] = 'UA'; // Ucrania
$enabled['UG'] = 'UG'; // Uganda
$enabled['US'] = 'US'; // Estados Unidos
$enabled['UY'] = 'UY'; // Uruguay
$enabled['VE'] = 'VE'; // Venezuela
$enabled['VN'] = 'VN'; // Vietnam
$enabled['ZA'] = 'ZA'; // Sudáfrica
$enabled['ZM'] = 'ZM'; // Zambia
$enabled['ZW'] = 'ZW'; // Zimbabue


$aux = fopen('sources/countryInfo.txt', "r");
$cList['countryInfo'] = getList($aux);
$aux = 0;
echo "\r\n-------------------------------------------------------\r\n";
foreach ($cList['countryInfo'] as $country) {
    $parseCountry = empty($enabled) || in_array($country['ISO'], $enabled) ? true : false;
    $parseCountry = $parseCountry ? $country['Population'] > MIN_COUNTRY_POP || MIN_COUNTRY_POP == 0 ? true : false  : false;

    if (!$parseCountry) {
        echo '  ' . $country['ISO'] . '  ';
    } else {
        echo ' [' . $country['ISO'] . '] ';
    }




    if ($parseCountry) {
        $bigCountries[] = $country['ISO'];
        $country = $country['ISO'];
        $parse[] = $country;
        $aux++;
    } else {
        $smallCountries[] = $country['ISO'];
    }


    if ($aux == 10) {
        $aux = 0;
        $parse = implode('=', $parse);
        $cmd[] = "clear && php generate.php $parse";
        /* echo "\r\n-------------------------------------------------------";
          echo "\r\n- $parse                                               ";
          echo "\r\n- $cmd                                               ";
          echo "\r\n-------------------------------------------------------";
          echo "\r\n\r\n";
         *
         */
        // echo shell_exec($cmd);
        $parse = array();
    }
}

$cmd = implode(' && ', $cmd);
echo "\r\n-------------------------------------------------------\r\n\r\n";
echo ' Paises a parsear : ' . count($bigCountries) . "\r\n";
echo ' Paises ignorados : ' . count($smallCountries) . "\r\n";

echo "\r\n-------------------------------------------------------\r\n\r\n";
echo $cmd;
$parse = implode('=', $smallCountries);
$parse1 = implode('=', $bigCountries);
$cmd = " && clear && php generate.php $parse true";
echo $cmd;
echo "\r\n\r\n-------------------------------------------------------";

echo "\r\n\r\n";
?>
