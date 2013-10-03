<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @property Mail $Mail
 */
class MailsController extends AppController {

    function beforeFilter() {
        if(isset($_SESSION['idioma']) && !empty($_SESSION['idioma'])){
            $idioma = $_SESSION['idioma'];
            Configure::write('Config.language', $idioma);

        }
        $this->Auth->allow('email'); //'index',
        parent::beforeFilter();
    }

    function email($notification_id, $debug=false) {


        $this->loadModel('Notification');
        $this->loadModel('Notificationtype');

        $emailData = $this->Notification->read(null, $notification_id);

		


        if ($emailData) {


            $model = Inflector::classify($emailData['Notificationtype']['model']);
            $this->loadModel($model);
            $this->{$model}->recursive = -1;
            $emailData[$model] = array_shift($this->{$model}->read(null, $emailData['Notification']['model_id']));
            //


            if ($emailData['Notificationtype']['model'] != $emailData['Notificationtype']['related_model']) {
                $relatedModel = Inflector::classify($emailData['Notificationtype']['related_model']);
                $this->loadModel($relatedModel);
                $this->{$relatedModel}->recursive = -1;
                if (array_key_exists(low($relatedModel) . "_id", $this->{$model}->_schema)) {
                    $relatedModelId = $emailData[$model][low($relatedModel) . "_id"];
                } else {

                    $relatedModelId = $emailData[$model]['model_id'];
                }
                $query['conditions'] = array(
                    "$relatedModel.id" => $relatedModelId
                );
                $emailData[$relatedModel] = array_shift($this->{$relatedModel}->find('first', $query));
            } else {
                $relatedModelId = $emailData[$model]['id'];
                $relatedModel = $model;
            }

            $follower = false;


            if ($emailData['Notification']['user_id'] != $emailData['Notification']['owner_id']) {
                $emailData['Owner'] = array_shift($this->User->read(null, $emailData['Notification']['owner_id']));
            } else {
                $emailData['Owner'] = $emailData['User'];
            }

		

			//echo $emailData['Notificationtype']['email_owner'];exit;

            if ($emailData['Notificationtype']['email_owner'] == 1) { // send  a mail to owner
                $mailSent = $this->{low('email_owner__' . $emailData['Notificationtype']['name'])}($notification_id, $emailData);
				//echo $mailSent ;exit;
				//echo low('email_owner__' . $emailData['Notificationtype']['name']);exit;
				
				
                if (low($relatedModel) == 'offer') { // // agregar los mails a los usuarios que siguen un ofrecimiento.
                    $query['contains'] = array();
                    $query['fields'] = array('user_id');
                    $query['conditions'] = array(
                        'Follow.model' => $relatedModel,
                        'Follow.model_id' => $relatedModelId,
                    );
                    $this->loadModel('Follow');
                    $follow_user_ids = array_unique(Set::extract('/Follow/user_id', $this->Follow->find('all', $query)));
                    foreach ($follow_user_ids as $user_id) {
                        $emailData['Owner'] = array_shift($this->User->read(null, $user_id)); // updates owner information
                        $mailSent = $this->{'email_owner__' . low($emailData['Notificationtype']['name'])}($notification_id, $emailData);
                    }
                }
            }


			
            if ($emailData['Notificationtype']['email_user'] == 1) {
                // get project/ offer related users [ followers / backers / who created a related project ]
                $query = array();
                $query['contains'] = array();
                $query['fields'] = array('user_id');
                if ($relatedModel) {

                    if (low($relatedModel) == 'offer') {
                        $query['conditions'] = array(
                            'Project.offer_id' => $relatedModelId,
                        );

                        $this->loadModel('Project');
                        $follow_type2_user_ids = array_unique(Set::extract('/Project/user_id', $this->Project->find('all', $query)));


                        $query['conditions'] = array(
                            'Follow.model' => $relatedModel,
                            'Follow.model_id' => $relatedModelId,
                        );

                        $this->loadModel('Follow');
                        $follow_user_ids = array_unique(Set::extract('/Follow/user_id', $this->Follow->find('all', $query)));
                    } elseif (low($relatedModel) == 'project') {
                        $query['conditions'] = array(
                            'Sponsorship.project_id' => $relatedModelId,
                        );
                        $this->loadModel('Sponsorship');


                        $follow_type2_user_ids = array_unique(Set::extract('/Sponsorship/user_id', $this->Sponsorship->find('all', $query)));

                        $query['conditions'] = array(
                            'Follow.model' => $relatedModel,
                            'Follow.model_id' => $relatedModelId,
                        );

                        $this->loadModel('Follow');
                        $follow_user_ids = array_unique(Set::extract('/Follow/user_id', $this->Follow->find('all', $query)));
                    }

                    $user_ids = array_unique(am($follow_user_ids, $follow_type2_user_ids));

                    foreach ($user_ids as $user_id) {
                        $follower = $emailData['Notificationtype']['email_user_type2'] == 0 ? true : in_array($user_id, $follow_user_ids); // if true it's a followr else it's a (backer/created a related project)
                        $mailSent = $this->{'email_user__' . low($emailData['Notificationtype']['name'])}($notification_id, $emailData, $follower);
                    }
                }
            }

            //vd($emailData);

            // how many mails have we to send ?
            //vd($emailData['Notificationtype']['name']);

            /*
              $autoLoadData[] = Inflector::classify($emailData['NotificationType']['related_model']);
              }
             */

            // model_id 
        }

        $this->set('template', $this->Email->template);
        $this->set('debug', $debug);

        
        //$this->render('/common/ajax', 'email/text/default');
        $mailSent = false;
        return $mailSent;
    }

    function _prepareEmail($notification_id, $user, $subject, $template, $emailData) {

		//vd($emailData[$user]['id']);exit;
        $userData = $this->User->read(null, $emailData[$user]['id']);
		
		//echo $emailData['Notificationtype']['name'] ;exit;
        if ($emailData['Notificationtype']['disableable'] == 1) {
            $this->loadModel('NotificationtypeUser');
            $notificationQuery['conditions'] = array('NotificationtypeUser.user_id' => $userData['User']['id'], 'NotificationtypeUser.notificationtype_id' => $emailData['Notificationtype']['id']);
            $sendMail = (bool) $this->NotificationtypeUser->find('first', $notificationQuery);
        } else {
            $sendMail = true;
        }

        if ($sendMail) {
            $this->set('user', $userData); // set the new user info.
            //vd($userData['User']['email']);
            $emailConfigs = Configure::read('Email.default');
            $emailConfigs['to'] = $userData['User']['email']; //'gastonmusante@gmail.com'; //

            $emailConfigs['subject'] = __($subject, true);
            $emailConfigs['template'] = $template;
            $this->Email->reset();
            foreach ($emailConfigs as $property => $value) {
                $this->Email->{$property} = $value; //
            }
            $this->set('emailData', $emailData);
            return $this->Mail->checkEmail($notification_id, $userData, $subject, $template, $emailData); // si el mail existe vemos que hacemos....
        }
        return false;
    }

    function __call($name, $arguments) { // used for generic emails
        $mailSent = false;

        list( $type, $name ) = explode('__', $name);

        if (low($type) == 'email_user') {
            $notification_id = $arguments[0];
            $emailData = $arguments[1];
            $follower = $arguments[2];
            $mailSent = $this->email_user($notification_id, $emailData, $follower, low($name));
        } elseif (low($type) == 'email_owner') {
            $notification_id = $arguments[0];
            $emailData = $arguments[1];

            $mailSent = $this->email_owner($notification_id, $emailData, low($name));
        }

        return $mailSent;
    }

    function email_owner($notification_id, $emailData, $name='') {

        $mailSent = false;
        $mail_id = $this->_prepareEmail($notification_id, 'Owner', strtoupper($name . '_SUBJECT_OWNER'), $name . '_owner', $emailData);

        if ($mail_id) {
            $mailSent = $this->Email->send();

            $this->Mail->updateEmail($mail_id, $this->Email, $mailSent);
            /*4echo '<pre>';
            var_dump($mail_id, $this->Email, $mailSent);exit;
            echo '</pre>';*/
        }
        return $mailSent;
    }

    function email_user($notification_id, $emailData, $follower=False, $name='') {

        $mailSent = false;
        $follower = $follower ? '_follower' : '_follower_type2';
        $mail_id = $this->_prepareEmail($notification_id, 'User', strtoupper($name . '_SUBJECT' . $follower), $name . $follower, $emailData);
        if ($mail_id) {
            $mailSent = $this->Email->send();
            $this->Mail->updateEmail($mail_id, $this->Email, $mailSent);
        }
        return $mailSent;
    }

    /* These mails need custom proc ------------------------------------------ */

    function email_user__offer_about_to_finish($notification_id, $emailData, $follower=False, $name='offer_about_to_finish') { }

    function email_user__offer_finished($notification_id, $emailData, $follower=False, $name='offer_finished') {  }

  //  function email_user__project_about_to_finish($notification_id, $emailData, $follower=False, $name='project_about_to_finish') {  }

    function email_user__project_funded($notification_id, $emailData, $follower=False, $name='project_funded') {  }

    function email_user__project_dont_funded($notification_id, $emailData, $follower=False, $name='project_dont_funded') {   }

}

?>
