<?php

    class Notificationtype extends AppModel {

        var $name='Notificationtype';
        var $displayField='name';
        //The Associations below have been created with all possible keys, those that are not needed can be removed
        var $recursive=-1;
        var $hasMany=array(
            'Notification' => array(
                'className' => 'Notification',
                'foreignKey' => 'notificationtype_id',
                'dependent' => false,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            )
        );

        var $hasAndBelongsToMany=array(
            'User' =>
            array(
                'className' => 'User',
                'joinTable' => 'notificationtype_users',
                'foreignKey' => 'notificationtype_id',
                'associationForeignKey' => 'user_id',
                'unique' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'deleteQuery' => '',
                'insertQuery' => ''
            )
        );



    }

?>