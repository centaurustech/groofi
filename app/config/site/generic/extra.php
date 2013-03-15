<?php

    if (SITE_ENVIROMENT) {
        $serverSlugFileName=SITE_ENVIROMENT . '__extra_facebook.php';
        $serverSlugFileName=CONFIGS . DS . 'site' . DS . $serverSlugFileName;
        if (!file_exists($serverSlugFileName)) {
            $contentx=@file_get_contents(CONFIGS . DS . 'site' . DS . 'generic' . DS . 'extras' . DS . 'facebook.php');
            $openedfile=fopen($serverSlugFileName, "w");
            fwrite($openedfile, $contentx);
            fclose($openedfile);
        }
        include_once $serverSlugFileName;

    } else {
        include_once CONFIGS . DS . 'site' . DS . 'generic' . DS . 'extras' . DS . 'facebook.php';
    }

    Configure::write($config);

    $files=Configure::read('Upload.files');

    if (!empty($files)) {
        foreach ($files as $type => $config) {
            foreach ($config as $configName => $configs) {
                if ($configName == 'type') {
                    $files[$type][$configName]=itinerateExtencions($configs);
                }
            }
        }

        $config['Upload']['files']=$files;

        $config['Upload']['fileTypes']=array();
        $config['Upload']['fileSizes']=array();


        foreach (array_keys($files) as $fileType) {
            $config['Upload']['fileTypes'] += array_map(create_function('$v', "return '$fileType';"), array_flip($files[$fileType]['type']));

            $config['Upload']['fileSizes'] += array($fileType => $files[$fileType]['size']);

            $config['Upload']['allowed'][$fileType]=implode(';', array_map(create_function('$v', 'return "*.$v";'), $files[$fileType]['type']));

            $config['Upload']['allowedDesc'][$fileType]=__('ALL SUPPORTED ' . up($fileType) . ' FORMATS', true) . ' (' . implode(';', array_unique(array_map(create_function('$v', 'return strtolower("*.$v");'), $files[$fileType]['type']))) . ')';

            $config['Upload']['fileTypesJson'][$fileType]=json_encode(array_map(create_function('$v', "return '$fileType';"), array_flip($files[$fileType]['type'])));

            $config['Upload']['fileSizesJson'][$fileType]=json_encode(array($fileType => ($files[$fileType]['size'] )));
        }

        $config['Upload']['allowed']['all']=implode(';', array_map(create_function('$v', 'return "*.$v";'), array_keys($config['Upload']['fileTypes'])));
        $config['Upload']['allowedDesc']['all']=__('ALL SUPPORTED FORMATS', true) . ' (' . implode(';', array_unique(array_map(create_function('$v', 'return strtolower("*.$v");'), array_keys($config['Upload']['fileTypes'])))) . ')';
        $config['Upload']['fileTypesJson']['all']=json_encode($config['Upload']['fileTypes']);
        $config['Upload']['fileSizesJson']['all']=json_encode($config['Upload']['fileSizes']);
    }

    $countries=Configure::read('Countries');
    if (isset($countries)) {
        $config['Common']['countries']['all']=$countries;

        $countriesList=array_map(create_function('$value', 'return __(up(\'COUNTRY_\'.Inflector::slug($value)),true);'), $countries);
        $config['Common']['countries']['list']=$countriesList;
        if (!empty($countriesList)) {

            foreach ($countriesList as $code => $txt) {
                $countriesFilter[$code]=array("txt" => $txt, "url" => array("country" => $code));
            }
            if (isset($countriesFilter)) {
                $config['Common']['countries']['filterList']=$countriesFilter;
            }
        }
    }


    Configure::write($config);
?>