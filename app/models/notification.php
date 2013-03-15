<?php

/**
 *  @property User $User
 *  @property Notificationtype $Notificationtype
 */
class Notification extends AppModel {

    var $name = 'Notification';
    var $displayField = 'id';
    var $belongsTo = array(
        'Notificationtype' => array(
            'className' => 'Notificationtype',
            'foreignKey' => 'notificationtype_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    function afterFind($results, $primary = false) {

        //vd($results);

        return parent::afterFind($results, $primary);
    }

    function add($notificationType, $data, $user_id, $owner_id = null, $unique = false) {
        // EL user id es de quien creo la accion.
        // checkeamos si existe la notificacion a crear,

        $notificationType = $this->Notificationtype->find('first', array(
                    'conditions' => array(
                        'Notificationtype.name' => $notificationType
                    ),
                    'contain' => array()
                        )
        );


        if ($notificationType) {
            $model = Inflector::classify($notificationType['Notificationtype']['model']);
            if (!is_array($data)) {
                $model_id = $data;
                $data = null;
            } else {
                $model_id = $data[$model]['id'];
                $data = serialize($data);
            }

            if ($unique) {
                $query['conditions'] = array(
                    'owner_id' => ( $owner_id ? $owner_id : $user_id ),
                    'user_id' => $user_id,
                    'notificationtype_id' => $notificationType['Notificationtype']['id'],
                    'model' => $model,
                    'model_id' => $model_id,
                );
                $exist = $this->find('all', $query);
                if ($exist) {
                    return false;
                }
            }

            $data = array(
                'owner_id' => ( $owner_id ? $owner_id : $user_id ),
                'user_id' => $user_id,
                'notificationtype_id' => $notificationType['Notificationtype']['id'],
                'model' => $model,
                'model_id' => $model_id,
                'data' => $data,
            );



            if ($data['model_id']) {
                $this->create();
                return $this->save($data);
            } else {
                $this->log("Error : model_id not found for model $model ", 'NOTIFICATIONS_LOG');
                return false;
            }
        } else {
            $this->log("Error : notification type  $notificationType Does not exist", 'NOTIFICATIONS_LOG');
            return false;
        }
    }

    function prepareEmail($notificationType, $data, $user_id, $owner_id = null) {
        $email = Configure::read('Email.default');
        $email['subject'] = __(up('EMAIL_SUBJECT_' . $notificationType), true); // subject for the message (string)

        $email['message'] = __(up('EMAIL_MESSAGE_' . $notificationType), true) . ( $email['delivery'] == 'debug' ? "\r\n[\r\n::VARIABLES\r\n]\r\n" : '' );

        foreach ($data as $key => $value) {

            if (!Set::numeric($value)) {
                foreach ($value as $field => $keyValue) {
                    if (is_string($keyValue)) {
                        $email['data'][up($key . '__' . $field)] = $keyValue;
                    }
                }
            }
        }
        $email['data']['LINK'] = '';
        $email['data']['VARIABLES'] = implode("\r\n:", array_keys($email['data']));
        //  vd($email['data']);
        return $email;
    }

    function setupEmail(&$email, $params, $to) {
        unset($params['message']);
        unset($params['data']);

        foreach ($params as $param => $value) {
            $email->{$param} = $value;
        }
        return $email;
    }

    function getOwnersEmails() {
        
    }

    function getFollowsEmails() {
        
    }

}

?>