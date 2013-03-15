<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @property User $User
 * @property Project $Project
 * @property Offer $Offer
 */
class Post extends AppModel {
    /*  ---  */

    var $actsAs = array(
        'Containable',
        'Sluggable' => array(
            'label' => 'title',
            'slug' => 'slug',
            'overwrite' => true
        )
    );
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'counterCache' => true,
            'counterScope' => array('Post.public' => 1),
            'conditions' => array(),
            'dependent' => true,
        ),
        'Project' => array(
            'className' => 'Project',
            'foreignKey' => 'model_id',
            'conditions' => array('Post.model' => 'Project'),
            'counterCache' => true,
            'counterScope' => array('Post.public' => 1, 'Post.model' => 'Project'),
            'conditions' => array(),
            'dependent' => true,
        ),
        'Offer' => array(
            'className' => 'Offer',
            'conditions' => array('Post.model' => 'Offer'),
            'foreignKey' => 'model_id',
            'counterCache' => true,
            'counterScope' => array('Post.public' => 1, 'Post.model' => 'Offer'),
            'conditions' => array(),
            'dependent' => true,
        )
    );
    var $hasMany = array(
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'model_id',
            'conditions' => array('Comment.model' => 'Post'),
            'dependent' => true
        ),
    );

    /*
      static function getLink($data = null, $extra = array(), $full = false, $model = null) {

      unset($data['Post']['slug']);
      return parent::getLink($data, $extra, $full, $model);
      }

     */

    static function getSlug($data = null) {
        return $data['Post']['id'];
    }

    static function getLink($data=null, $extra = array(), $full=false, $model=null) {

        //if (!isset($data['User'])  ) { // getUserData
            App::import('model', 'User');
            $user = new User();
            $user = $user->getUser($data['Post']['user_id']);
        //} else {
         //   $user = $data;
        //}




        if (is_string($extra) || (is_array($extra) && isset($extra['extra']) )) {
            $params = (is_array($extra) && isset($extra['extra']) ) ? $extra : array();
            $extra = (is_array($extra) && isset($extra['extra']) ) ? $extra['extra'] : $extra;
            if (isset($params['extra'])) {
                unset($params['extra']);
            }
            $params['user'] = User::getSlug($user);
            switch (low($extra)) {
                ///project/:model_id/edit-update/:post_id',
                case 'edit' :
                    $extra = array('controller' => 'posts', 'action' => 'edit', 'post_id' => $data['Post']['id'], 'type' => 'project', 'model_id' => $data['Post']['model_id']);
                    $params['user'] = null; // unsets parent user
                    $params['post'] = null; // unsets parent user
                    break;
                default :
                    $extra = array();
            }

            $extra = am($extra, $params);
        } else {



            $extra['user'] = User::getSlug($user);
        }


        return parent::getLink($data, $extra, $full, 'Post');
    }


     function isPublic($data=False) {
        if (is_bool($data)) {
            return array(
                $this->alias.'.enabled' => IS_ENABLED,
                $this->alias.'.public' => IS_PUBLIC ,
                'User.active' => IS_ENABLED,
                'User.confirmed' => IS_ENABLED,
            );
        } elseif (is_array($data)) {
            return( $data[$this->alias]['enabled'] == IS_ENABLED && $data[$this->alias]['public'] == IS_PUBLIC );
        }
        return false;
    }


    function queryStandarSet($all=true, $profile=false) {


        $query['contain'] = array(
            'User',
        );

        if (!$profile) {

        }

        if (is_bool($all) && $all === false) {
            $query['conditions'] = $this->isPublic();
        }

        return $query;
    }

    function getViewData($id=false, $cache=true) {

        $query = $this->queryStandarSet();
        if (is_bool($id)) {
            return $query;
        } else {
            $query['conditions']['or'] = array(
                $this->alias . '.slug' => $id,
                $this->alias . '.id' => $id,
            );
            return parent::getViewData($this->alias, $query, $cache);
        }
    }

}

?>
