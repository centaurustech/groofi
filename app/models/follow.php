<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Follow extends AppModel {

    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'counterCache' => 'follow_count',
            'counterScope' => array('Follow.model' => 'Project'),
            'dependent' => true,
        ),
        'User2' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'counterCache' => 'follow_offer_count',
            'counterScope' => array('Follow.model' => 'Offer'),
            'dependent' => true,
        ),        
        'Project' => array(
            'className' => 'Project',
            'foreignKey' => 'model_id',
            'conditions' => array('Follow.model' => 'Project'),
            'counterCache' => true,
            'dependent' => true,
        ),
        'Offer' => array(
            'className' => 'Offer',
            'conditions' => array('Follow.model' => 'Offer'),
            'foreignKey' => 'model_id',
            'counterCache' => true,
            'dependent' => true,
        )
    );

    static function isFollowing($data) {
        return in_array(User::getAuthUser('id'), Set::extract('/Follow/user_id', $data));
    }

}

?>
