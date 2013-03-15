<?php

/**
 * @property User $User
 */
class Comment extends AppModel {

    var $order = 'Comment.created DESC';
    var $name = 'Comment';
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => array(),
            'dependent' => true,
        ),
        'Project' => array(
            'className' => 'Project',
            'foreignKey' => 'model_id',
            'conditions' => array('Comment.model' => 'Project'),
            'counterCache' => 'comment_count',
            'counterScope' => array('Comment.model' => 'Project'),
            'dependent' => true,
        ), 'Offer' => array(
            'className' => 'Offer',
            'foreignKey' => 'model_id',
            'conditions' => array('Comment.model' => 'Offer'),
            'counterCache' => 'comment_count',
            'counterScope' => array('Comment.model' => 'Offer'),
            'dependent' => true,
        ),
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'model_id',
            'conditions' => array('Comment.model' => 'Post'),
            'counterCache' => 'comment_count',
            'counterScope' => array('Comment.model' => 'Post'),
            'dependent' => true,
        ),
    );
    var $validate = array(
        'comment' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty', true),
                'required' => true,
                'allowEmpty' => false,
				'message'=>'Por favor escriba su mensaje.'
            ),
            'maxLength_500' => array(
                'rule' => array('maxLength', 500),
                'required' => true,
				'message'=>'El texto escrito no debe tener m&aacute;s de 500 caracteres.'
            ),
            'minLength_3' => array(
                'rule' => array('minLength', 3),
                'required' => true,
				'message'=>'El texto escrito es demasiado breve.'
            )
        )
    );

    static function isPublic($data=False) {
        if (is_bool($data)) {
            return array(
                'User.active' => IS_ENABLED,
                'User.confirmed' => IS_ENABLED,
                'Comment.report_count <=' => REPORT_COUNT_LIMIT,
            );
        } elseif (is_array($data)) {
            return( $data['Comment']['report_count'] <= REPORT_COUNT_LIMIT );
        }
        return false;
    }

    function queryStandarSet($all=false, $profile=false) {
        $query['contain'] = array(
            'User',
            'Offer',
            'Project',
            'Post',
        );

        if (!$profile) {
          
        }

        if (is_bool($all) && $all === false) {
            $query['conditions'] = $this->isPublic();
        }

        return $query;
    }

}

?>