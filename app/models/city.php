<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class City extends AppModel {

    var $actsAs = array('Sluggable' => array(
            'label' => 'title',
            'slug' => 'slug',
            'overwrite' => true
        )
    );

    static function getCountryName($data=null) {
        if ($data) {
            if (( $data['City']['country']) != '') {
                return $data['City']['country'];
            }
        }
        return false;
    }

    static function getName($data=null) {

        if ($data) {
            if (($data['City']['city'] . $data['City']['country']) != '') {
                return $data['City']['city'] . ', ' . $data['City']['country'];
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
                    $extra = array('controller' => 'offers', 'action' => 'index', 'country' => $data['City']['country_slug']);
                    $params['user'] = null; // unsets parent user
                    $params['city'] = $data['City']['city_slug'] ; // unsets parent user
                    break;
                case 'projects' :
                    $extra = array('controller' => 'projects', 'action' => 'index', 'country' => $data['City']['country_slug']);
                    $params['user'] = null; // unsets parent user
                    $params['city'] = $data['City']['city_slug'] ; // unsets parent user
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
                    $extra = array('controller' => 'offers', 'action' => 'index', 'country' => $data['City']['country_slug']);
                    $params['user'] = null; // unsets parent user
                    $params['city'] = $data['City']['city_slug']; // unsets parent user
                    break;
                case 'projects' :
                    $extra = array('controller' => 'projects', 'action' => 'index', 'country' => $data['City']['country_slug']);
                    $params['city'] = null; // unsets parent user
                    $params['user'] = $data['City']['city_slug']; // unsets parent user
                    break;
                default :
                    $extra = array('controller' => 'projects', 'action' => 'index', 'country' => $data['City']['country_slug']);
                    $params['city'] = null; // unsets parent user
                    $params['user'] = $data['City']['city_slug']; // unsets parent user
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

    function saveSlug($city, $country, $country_code, $id) {

        $city_slug = $this->slug($city);

        $country_slug = $this->slug($country);

        $count = $this->find('count', array(
                    'conditions' => array(
                        'city_slug' => $city_slug
                    )
                ));
        if ($count == 1) {
            $city_slug = $this->slug("$city $country_code");
        } elseif ($count >= 2) {
            $city_slug = $this->slug("$city $id");
        }


        vd("'$city' guardada conmo '$city_slug'");

        $data['City']['id'] = $id;
        $data['City']['city_slug'] = $city_slug;
        $data['City']['country_slug'] = $country_slug;
        $this->save($data);
    }

    function slugCities() {
        $this->contain = array();
        $sql = "UPDATE `groofi`.`cities` SET `city_slug` = '', `country_slug` = ''";

        $this->query($sql);

        $cities = $this->find('all', array());

        foreach ($cities as $key => $city) {
            $cityname = ($city['City']['city_ascii']!='' ? $city['City']['city_ascii'] : $city['City']['name']); 
            vd($cityname);
            $this->saveSlug($cityname , $city['City']['country'], $city['City']['country_code'], $city['City']['id']);
        }
        return false;
    }

}

?>
