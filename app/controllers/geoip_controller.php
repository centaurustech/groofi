<?php
class IpmundoController extends AppController {
    var $name='Ipmundo';
    function beforeFilter() {

        $this->Auth->allow('lookup');
        parent::beforeFilter();

    }




    function lookup()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $siglapais=geoip_country_code_by_name($ip);

        echo $siglapais;
        $this->render('staticpages/geoip');

    }
}
?>