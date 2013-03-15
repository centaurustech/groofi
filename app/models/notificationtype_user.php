<?php

    class NotificationtypeUser extends AppModel {

        public $belongsTo=array(
            'User', 'Notificationtype'
        );
		
    }

?>