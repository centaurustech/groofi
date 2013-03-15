<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class NotificationsController extends AppController {

    function beforeFilter() {
        $this->Auth->allow('listing'); //'index',
        parent::beforeFilter();
    }

    function index() {

        $query = array(
            'order' => 'Notification.created DESC'
        );

        foreach ($this->Notification->find('all', $query) as $notification) {
            $notificationData = $notification['Notification']['data'];
            unset($notification['Notification']['data']);
            vd($notification['Notification']);
        }
    }

    function wall() {

        $this->loadModel('Offer');
        $this->loadModel('User');
        $this->loadModel('Project');
        $this->loadModel('Sponsorship');
        $this->loadModel('Post');
        $this->loadModel('Comment');
        $this->loadModel('Category');
        $this->loadModel('Follow');

        $this->data = $this->Notification->User->getUser();

        if ($this->data) {
            $query = array();
            $query['order'] = array('Notification.created DESC');

            $userProfileNotifications = Set::extract('/Notificationtype/id', $this->Notification->Notificationtype->find('all', array(
                                'conditions' => array('Notificationtype.activity_feed' => 1),
                                'fields' => array('id'),
                                'contain' => array(),
                            )));

            // proyectos que sigo 
            $projects = Set::extract('/Follow/model_id', $this->Follow->find('all', array('conditions' => array(
                                    'Follow.user_id' => $this->data['User']['id'],
                                    'Follow.model' => 'Project'
                                ),
                                'fields' => array('model_id'),
                                'contain' => array(),
                                    )
                            )
            );

            // proyectos que patrocino
            $projects = am($projects, Set::extract('/Sponsorship/project_id', $this->Sponsorship->find('all', array('conditions' => array(
                                    'Sponsorship.user_id' => $this->data['User']['id'],
                                ),
                                'fields' => array('project_id'),
                                'contain' => array(),
                                    )
                            )
                    ));


            $projects = am($projects, Set::extract('/Project/id', $this->Project->find('all', array('conditions' => array(
                                    array(
                                        //'Project.user_id' => $this->data['User']['id'],
                                        'Project.offer_id' => Set::extract('/Offer/id', $this->Offer->find('all', array(
                                                    'contain' => array(),
                                                    'conditions' => array(
                                                        'Offer.user_id' => $this->data['User']['id']
                                                    ),
                                                    'fields' => array('id'),
                                                        )
                                                )
                                        )
                                    )
                                ),
                                'fields' => array('id'),
                                'contain' => array(),
                                    )
                            )
                    ));




            // ofrecimientos que sigo
            $offers = Set::extract('/Follow/model_id', $this->Follow->find('all', array('conditions' => array(
                                    'Follow.user_id' => $this->data['User']['id'],
                                    'Follow.model' => 'Offer'
                                ),
                                'fields' => array('model_id'),
                                'contain' => array(),
                                    )
                            )
            );



            // ofrecimientos en los que acepte el reto
            $offers = am($offers, Set::extract('/Project/offer_id', $this->Project->find('all', array('conditions' => array(
                                    'Project.user_id' => $this->data['User']['id'],
                                    'Project.offer_id >' => 0
                                ),
                                'fields' => array('offer_id'),
                                'contain' => array(),
                                    )
                            )
                    )
            );


            $posts = Set::extract('/Post/id', $this->Post->find('all', array('conditions' => array(
                                    'or' => array(
                                        array(
                                            'Post.model' => 'Project',
                                            'Post.model_id' => array_unique($projects),
                                        ), array(
                                            'Post.model' => 'Offer',
                                            'Post.model_id' => array_unique($offers),
                                        )
                                    )
                                ),
                                'fields' => array('id'),
                                'contain' => array(),
                                    )
                            )
            );



            $follows = Set::extract('/Follow/id', $this->Follow->find('all', array('conditions' => array(
                                    array(
                                        'Follow.model' => 'Offer',
                                        'Follow.model_id' => Set::extract('/Offer/id', $this->Offer->find('all', array(
                                                    'contain' => array(),
                                                    'conditions' => array(
                                                        'Offer.user_id' => $this->data['User']['id']
                                                    ),
                                                    'fields' => array('id'),
                                                        )
                                                )
                                        )
                                    )
                                ),
                                'fields' => array('id'),
                                'contain' => array(),
                                    )
                            )
            );


            $query['conditions'] = array(
                'Notification.notificationtype_id' => $userProfileNotifications
            );

            $query['conditions']['or'][] = array(
                'Notification.model' => 'Project',
                'Notification.model_id' => array_unique($projects),
            );

            $query['conditions']['or'][] = array(
                'Notification.model' => 'Offer',
                'Notification.model_id' => array_unique($offers),
            );

            $query['conditions']['or'][] = array(
                'Notification.model' => 'Post',
                'Notification.model_id' => array_unique($posts),
            );

            $query['conditions']['or'][] = array(
                'Notification.model' => 'Follow',
                'Notification.model_id' => array_unique($follows),
            );

            //$this->data['Notifications'] = $this->Notification->find('all', $query);
            $query['limit'] = 5;
            $this->paginate = $query;
            $this->data['Notifications'] = $this->paginate('Notification');

            foreach ($this->data['Notifications'] as $key => $notification) {

//                vd($notification["Notification"]) ;

                $model = Inflector::classify($notification["Notification"]['model']);
                $data = $this->{$model}->read(null, $notification["Notification"]['model_id']);
                if ($data) {

                    $this->data['Notifications'][$key]["Notification"]['data'] = serialize($data);
                } else {
                    unset($this->data['Notifications'][$key]);
                }
            }
        } else {
            $this->pageError = array('code' => 404);
        }

        $this->set('section', 'wall'); //??
        $this->render('/users/view');
    }

    function listing($user=true) { //user_feed
        $this->loadModel('Offer');
        $this->loadModel('User');
        $this->loadModel('Project');
        $this->loadModel('Sponsorship');
        $this->loadModel('Post');
        $this->loadModel('Comment');
        $this->loadModel('Category');

        $this->data = $this->Notification->User->getUser($user);

        $userProfileNotifications = Set::extract('/Notificationtype/id', $this->Notification->Notificationtype->find('all', array(
                            'conditions' => array('Notificationtype.user_feed' => 1), //activity_feed
                            'fields' => array('id'),
                            'contain' => array(),
                        )));

        if ($this->data) {
            $query = array();
            $query['order'] = array('Notification.created DESC');
            $query['conditions'] = array(
                'Notification.user_id' => $this->data['User']['id'],
                'Notification.notificationtype_id' => $userProfileNotifications
            );

            $this->paginate = $query;
            $this->paginate['limit'] = 5;
            $this->data['Notifications'] = $this->paginate('Notification');
            ;


            foreach ($this->data['Notifications'] as $key => $notification) {

//                vd($notification["Notification"]) ;

                $model = Inflector::classify($notification["Notification"]['model']);
                $data = $this->{$model}->read(null, $notification["Notification"]['model_id']);
                if ($data) {

                    $this->data['Notifications'][$key]["Notification"]['data'] = serialize($data);
                } else {
                    unset($this->data['Notifications'][$key]);
                }
            }




            /*
              if (!empty($this->data['Projects'])) {
              foreach ($this->data['Projects'] as $key => $project) {
              if (!Project::isOwnProject($project) && !Project::isPublic($project)) {
              unset($this->data['Projects'][$key]);
              }
              }
              }
             */



            //vd($this->data['Notifications']);
        } else {
            $this->pageError = array('code' => 404);
        }




        $this->set('section', 'activity'); //??
        $this->render('/users/view');
    }

}

?>
