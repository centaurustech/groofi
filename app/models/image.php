<?php

/**
 * @property User $User
 */
class Category extends AppModel {

    var $name = 'Category';
    var $displayField = 'slug';
    var $actsAs = array(
        'Sluggable' => array(
            'label' => 'name',
            'slug' => 'slug'
        ), 'Tree'
    );
    var $hasMany = array(
        'Project' => array(
            'className' => 'Project',
            'foreignKey' => 'category_id',
            'dependent' => false
        ),
    );



    static function getName($data=null, $model = 'Category') {
        $data = isset($data[$model]) ? $data : array($model => $data);
        if (isset($data[$model])) {
            return __(up($model . '_' . Inflector::slug(parent::getName($data, $model))), true);
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

            unset($params['category']);

            switch (low($extra)) {
                case 'offers' :
                    $extra = array('controller' => 'offers', 'action' => 'index');
                    $params['user'] = null; // unsets parent user
                    break;
                case 'projects' :
                    $extra = array('controller' => 'projects', 'action' => 'index');
                    $params['user'] = null; // unsets parent user
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

    function getFromSlug($slug='') {
        return $this->find('first', array('conditions' => array('Category.slug' => $slug), 'contain' => array()));

        //return @array_shift(Set::extract('/Category/id',$this->find('first',array('conditions'=>array('Category.slug'=>$slug),'contain'=>array()))));
    }

}

?>