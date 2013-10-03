<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class country extends AppModel {

    var $actsAs = array('Sluggable' => array(
        'label' => 'title',
        'slug' => 'slug',
        'overwrite' => true
    )
    );

    static function getCountryName($data=null) {
        if ($data) {
            if (( $data['country']['country']) != '') {
                return $data['country']['country'];
            }
        }
        return false;
    }

    static function getName($data=null) {

        if ($data) {
            if (($data['country']['country'] . $data['country']['country']) != '') {
                return $data['country']['country'] . ', ' . $data['country']['country'];
            }
        }

        return false;
    }

    static function getLink($data=null, $extra = array(), $full=false, $model=null) {
        if (is_string($extra) || (is_array($extra) && isset($extra['extra']) )) {
            $params = (is_array($extra) && isset($extra['extra']) ) ? $extra : array();
            $extra = (is_array($extra) && isset($extra['extra']) ) ? $extra['extra'] : $extra;

            if (isset($params['extra'])) {
                unset($params['extra']);
            }
            switch (low($extra)) {
                case 'offers' :
                    $extra = array('controller' => 'offers', 'action' => 'index', 'country' => $data['country']['country_slug']);
                    $params['user'] = null; // unsets parent user
                    $params['country'] = $data['country']['country_slug'] ; // unsets parent user
                    break;
                case 'projects' :
                    $extra = array('controller' => 'projects', 'action' => 'index', 'country' => $data['country']['country_slug']);
                    $params['user'] = null; // unsets parent user
                    $params['country'] = $data['country']['country_slug'] ; // unsets parent user
                    break;
                default :
                    $extra = array();
            }

            $extra = am($extra, $params);
        } else {
            $extra = array('controller' => 'projects', 'action' => 'index');
            $params['user'] = null; // unsets parent user
        }

        return parent::getLink($data, $extra, $full, $model);
    }

    static function getCountryLink($data=null, $extra = array(), $full=false, $model=null) {
        if (is_string($extra) || (is_array($extra) && isset($extra['extra']) )) {
            $params = (is_array($extra) && isset($extra['extra']) ) ? $extra : array();
            $extra = (is_array($extra) && isset($extra['extra']) ) ? $extra['extra'] : $extra;

            if (isset($params['extra'])) {
                unset($params['extra']);
            }
            switch (low($extra)) {
                case 'offers' :
                    $extra = array('controller' => 'offers', 'action' => 'index', 'country' => $data['country']['country_slug']);
                    $params['user'] = null; // unsets parent user
                    $params['country'] = $data['country']['country_slug']; // unsets parent user
                    break;
                case 'projects' :
                    $extra = array('controller' => 'projects', 'action' => 'index', 'country' => $data['country']['country_slug']);
                    $params['country'] = null; // unsets parent user
                    $params['user'] = $data['country']['country_slug']; // unsets parent user
                    break;
                default :
                    $extra = array('controller' => 'projects', 'action' => 'index', 'country' => $data['country']['country_slug']);
                    $params['country'] = null; // unsets parent user
                    $params['user'] = $data['country']['country_slug']; // unsets parent user
            }

            $extra = am($extra, $params);
        } else {
            $extra = array('controller' => 'projects', 'action' => 'index');
            $params['user'] = null; // unsets parent user
        }

        return parent::getLink($data, $extra, $full, $model);
    }

    function slug($word) {

        return SluggableBehavior::__slug( low( Inflector::slug($word, '-') ), array(
                'label' => 'title',
                'slug' => 'slug',
                'separator' => '-',
                'length' => 100,
                'overwrite' => true
            )
        );
    }

    function saveSlug($country, $country, $country_code, $id) {

        $country_slug = $this->slug($country);

        $country_slug = $this->slug($country);

        $count = $this->find('count', array(
            'conditions' => array(
                'country_slug' => $country_slug
            )
        ));
        if ($count == 1) {
            $country_slug = $this->slug("$country $country_code");
        } elseif ($count >= 2) {
            $country_slug = $this->slug("$country $id");
        }


        vd("'$country' guardada conmo '$country_slug'");

        $data['country']['id'] = $id;
        $data['country']['country_slug'] = $country_slug;
        $data['country']['country_slug'] = $country_slug;
        $this->save($data);
    }

    function slugCountries() {
        $this->contain = array();
        $sql = "UPDATE `groofi`.`countries` SET `country_slug` = '', `country_slug` = ''";

        $this->query($sql);

        $cities = $this->find('all', array());

        foreach ($cities as $key => $country) {
            $countryname = ($country['country']['country_ascii']!='' ? $country['country']['country_ascii'] : $country['country']['name']);
            vd($countryname);
            $this->saveSlug($countryname , $country['country']['country'], $country['country']['country_code'], $country['country']['id']);
        }
        return false;
    }
    public function  getCountries($idioma){



        $sql = "SELECT * from countries AS c, projects AS p WHERE c.PAI_ISO2=p.paislugar AND p.idioma ='".$idioma."' group by PAI_ISO2";
        return $this->query($sql);


    }

}

?>
