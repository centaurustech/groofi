<?

    include_once '../common/init.php';
    
    include_once APP . '../cake' . DS . 'libs' . DS . 'inflector.php';
    

    $isEmptyCountry=false;

    if (isset($argv[1])) {
        $includedCountries=explode('=', $argv[1]);
    }

    if (isset($argv[2])) {
        $excludedCountries=explode('=', $argv[2]);
        $isEmptyCountry=true;
    }

    if (TRUNCATE_TABLE && CREATE_CITIES) {
        if (EXEC_QUERY) {
            if (CITIES_FROM == 0) {
            //    echo "BORRANDO TABLA \r\n\r\n\r\n";
            //    mysql_query("TRUNCATE TABLE `cities`;");
            }
        }
    }

    if (EXEC_QUERY && CREATE_CITIES) {
        mysql_query("ALTER TABLE `cities` DISABLE KEYS;");
    }

    if (CREATE_CITIES) {
        $fields = "geonameid;name;asciiname;alternatenames;latitude;longitude;feature class;feature code;country code;cc2;admin1 code;admin2 code;admin3 code;admin4 code;population;elevation;gtopo30;timezone;modification date";
        $ignore = array("latitude", "longitude", "elevation", "gtopo30", "timezone", "modification date");

        if (!$isEmptyCountry) {
            getListCity($includedCountries, $excludedCountries, $fields, $ignore);
        } else {
            $aux=fopen('sources/countryInfo.txt', "r");
            $cList['countryInfo']=getList($aux);
            foreach ($includedCountries as $emptyCountry) {
                if ($emptyCountry != '') {
                    genEmptyCountries($cList['countryInfo'][$emptyCountry]);
                }
            }
        }
    }

    if (EXEC_QUERY && CREATE_CITIES) {
        mysql_query("ALTER TABLE `cities` ENABLE KEYS;");
    }

    if (OPTIMIZE_TABLE && EXEC_QUERY) {
        echo "Optimizando tabla ciudades \r\n\r\n";
        mysql_query("CHECK TABLE `cities`;");
        mysql_query("ANALYZE TABLE `cities`;");
        mysql_query("REPAIR TABLE `cities`;");
        mysql_query("OPTIMIZE TABLE `cities`;");
        sleep(5);
    }
?>