<?php

class Message extends AppModel {

    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'counterCache' => 'message_count',
            'counterScope' => array('Message.read' => 0), // projects aproved
            'conditions' => array(),
            'dependent' => true,
        ),
        'Sender' => array(
            'className' => 'User',
            'foreignKey' => 'sender_id',
            'conditions' => array(),
            'dependent' => true,
        )
    );

    var $validate = array(
        'message' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty', true),
                'required' => true,
                'allowEmpty' => false
            ),
            'maxLength_2000' => array(
                'rule' => array('maxLength', 2000),
                'required' => true
            )

        )
    );

}

?>