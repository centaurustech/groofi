<?php
    include_once CONFIGS . DS . 'site/enviroment/enviroment.php';
    if (SITE_ENVIROMENT) {
        $serverSlugFileName =  SITE_ENVIROMENT . '__database.php' ;
        $serverSlugFileName = CONFIGS . DS . 'site' . DS . $serverSlugFileName ;
        if (!file_exists($serverSlugFileName)) {
            $contentx =@file_get_contents(  CONFIGS . DS . 'site' . DS . 'generic' . DS .'database.php' );
            $openedfile = fopen($serverSlugFileName, "w");
            fwrite($openedfile, $contentx);
            fclose($openedfile);
        }
        include_once $serverSlugFileName  ;
    }  else {
        include_once  CONFIGS . DS . 'site' . DS . 'generic' . DS .'database.php';
    }
?>