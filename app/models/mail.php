<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Mail extends AppModel {

    function checkEmail($notification_id, $user, $subject, $template, $emailData) {
        /*

          $emailConfigs = Configure::read('Email.default');
          $emailConfigs['to'] = 'gastonmusante@gmail.com' ;// $user['email'];
          $emailConfigs['subject'] = $subject;
          $emailConfigs['template'] = $template;
          $this->Email->reset();
          foreach ($emailConfigs as $property => $value) {
          $this->Email->{$property} = $value;
          }
          $this->set('emailData', $emailData);
         */
        $user_id = $user['User']['id'];

        $query['conditions'] = array(
            'notification_id' => $notification_id,
            'user_id' => $user_id,
        );

        $email = $this->find('first', $query);
        
        if (!$email) {
            $this->data['Mail'] = array(
                'to' => $user['User']['email'],
                'subject' => $subject,
                'template' => $template,
                'notification_id' => $notification_id,
                'user_id' => $user_id,
            );
            $this->save($this->data);
            return $this->id;
        } else { // check if we have to send this email again.-
            if ($email['Mail']['sent']==0 && $email['Mail']['errors'] == EMAIL_ATTEMPTS ) {
                return false ;
            }
            return $email['Mail']['id'];
        }
        return false;
    }   
    
    

    function updateEmail($mail_id, &$emailComponent, $sent) {
        
        $this->data = $this->read(null, $mail_id);
        
        $this->data['Mail']['id'] = $mail_id;
        $this->data['Mail']['sent'] = $sent;
        $errors = (int) $this->data['Mail']['errors'];
        $this->data['Mail']['errors'] = !$sent ? $errors++ : $errors;
        $this->save($this->data);
    }

}

?>
