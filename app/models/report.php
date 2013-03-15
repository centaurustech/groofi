<?php

/**
 * @property User $Reporter
 * @property User $Reporter
 * @property Comment $Comment
 */

class Report extends AppModel {

    var $belongsTo = array(
        'Reporter' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'dependent' => true,
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'model_id',
            'counterScope' => array('Report.model' => 'User'),
            'counterCache' => 'report_count',
            'counterScope' => array('Report.model' => 'User'),
            'dependent' => true,
        ),
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'model_id',
            'counterScope' => array('Report.model' => 'Comment'),
            'counterCache' => 'report_count',
            'counterScope' => array('Report.model' => 'Comment'),
            'dependent' => true,
        )
    );
    
   

    static function hasReported($data) {
        return in_array(User::getAuthUser('id'), Set::extract('/Report/user_id', $data));
        
    }
    
    

}

?>
