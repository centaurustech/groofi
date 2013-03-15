<?php

include_once CONFIGS . DS . 'site/enviroment/enviroment.php';

include_once APP . 'libs/common.functions.php';

if (SITE_ENVIROMENT) {
    $serverSlugFileName = SITE_ENVIROMENT . '__defines.php';
    $serverSlugFileName = CONFIGS . DS . 'site' . DS . $serverSlugFileName;
    if (!file_exists($serverSlugFileName)) {
        $contentx = @file_get_contents(CONFIGS . DS . 'site' . DS . 'generic' . DS . 'defines.php');
        $openedfile = fopen($serverSlugFileName, "w");
        fwrite($openedfile, $contentx);
        fclose($openedfile);
    }
    include_once $serverSlugFileName;

    // SERVER OWN GLOBAL CONFIGURATION || Do not edit this lines
    $serverSlugFileName = SITE_ENVIROMENT . '__global-config';
    $configFile = 'site' . DS . $serverSlugFileName;
    $serverSlugFileName = CONFIGS . $configFile . '.php';
    if (!file_exists($serverSlugFileName)) {
        $contentx = @file_get_contents(CONFIGS . DS . 'site' . DS . 'generic' . DS . 'global.php');
        $openedfile = fopen($serverSlugFileName, "w");
        fwrite($openedfile, $contentx);
        fclose($openedfile);
    }
    Configure::load($configFile);

    // SERVER OWN EXTRA CONFIGURATION || Do not edit this lines
    $serverSlugFileName = SITE_ENVIROMENT . '__extra-config.php';
    $serverSlugFileName = CONFIGS . DS . 'site' . DS . $serverSlugFileName;
    if (!file_exists($serverSlugFileName)) {
        $contentx = @file_get_contents(CONFIGS . DS . 'site' . DS . 'generic' . DS . 'extra.php');
        $openedfile = fopen($serverSlugFileName, "w");
        fwrite($openedfile, $contentx);
        fclose($openedfile);
    }
    include_once $serverSlugFileName;

    // SERVER OWN EXTRA CONFIGURATION || Do not edit this linesSITE_ENVIROMENT . '' ;
    $serverSlugFileName = SITE_ENVIROMENT . '__cache-config.php';
    $serverSlugFileName = CONFIGS . DS . 'site' . DS . $serverSlugFileName;
    if (!file_exists($serverSlugFileName)) {
        $contentx = @file_get_contents(CONFIGS . DS . 'site' . DS . 'generic' . DS . 'cache.php');
        $openedfile = fopen($serverSlugFileName, "w");
        fwrite($openedfile, $contentx);
        fclose($openedfile);
    }
    include_once $serverSlugFileName;




    // SERVER OWN GLOBAL CONFIGURATION || Do not edit this lines
    $serverSlugFileName = SITE_ENVIROMENT . '__message-config';
    $configFile = 'site' . DS . $serverSlugFileName;
    $serverSlugFileName = CONFIGS . $configFile . '.php';
    if (!file_exists($serverSlugFileName)) {
        $contentx = @file_get_contents(CONFIGS . DS . 'site' . DS . 'generic' . DS . 'messages.php');
        $openedfile = fopen($serverSlugFileName, "w");
        fwrite($openedfile, $contentx);
        fclose($openedfile);
    }
    Configure::load($configFile);
} else {

    include_once CONFIGS . 'site' . DS . 'generic' . DS . 'defines.php';

    Configure::load('site' . DS . 'generic' . DS . 'global');

    Configure::load('site' . DS . 'generic' . DS . 'messages');

    include_once CONFIGS . 'site' . DS . 'generic' . DS . 'extra.php';
    include_once CONFIGS . DS . 'site' . DS . 'generic' . DS . 'cache.php';
}
?>