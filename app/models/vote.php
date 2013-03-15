<?php

/**
 * @property User $Reporter
 * @property User $Reporter
 * @property Comment $Comment
 */

class Vote extends AppModel {

    var $belongsTo = array(
        'Voter' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'dependent' => true,
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'model_id',
            'counterCache' => 'votes_count',
            'counterScope' => array('Vote.model' => 'User'),
            'dependent' => true,
        ),
  
    );

    static function hasVoted($data) {
        return in_array(User::getAuthUser('id'), Set::extract('/Vote/user_id', $data));
        
    }
    
    

}

?>
