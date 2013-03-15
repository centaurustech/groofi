<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @property Offer $Offer
 */
class OffersController extends AppController {

    function beforeFilter() {

        if(isset($_SESSION['idioma']) && !empty($_SESSION['idioma'])){
            $idioma = $_SESSION['idioma'];
            Configure::write('Config.language', $idioma);
        }

        $this->Auth->allow('view', 'listing', 'index', 'cron_aboutToFinish', 'cron_Finished');
        parent::beforeFilter();
    }

    function beforeRender() {
        $base_money = array(
            '0-1000' => __('LESS_THAN_1000', true),
            '1000-5000' => __('FROM_1000_TO_5000', true),
            '5000-10000' => __('FROM_5000_TO_10000', true),
            '10000-20000' => __('FROM_10000_TO_20000', true),
            '20000' => __('20000_OR_MORE', true),
        );

        $base_categories = $this->Offer->Category->generatetreelist(null, null, null, " - ");
        foreach ($base_categories as $key => $category) {
            $base_categories[$key] = __('CATEGORY_' . up($category), true);
        }
        $this->set(compact('base_money', 'base_categories'));
        parent::beforeRender();
    }

    // OFFER_APPROVED
    function admin_approve($offerId=null) {
        $this->data = $this->Offer->read(null, $offerId);
        if ($this->data) {
            if ($this->data['Offer']['enabled'] == IS_DISABLED) { //proposal-accepted
                $this->data['Offer'] = am($this->data['Offer'], Configure::read('Offer.status.proposal-accepted'));
                if ($this->Offer->save($this->data, false)) {
                    $offer = $this->Offer->find(array('Offer.id' => $offerId));
                    if (!$this->Offer->User->Notification->add(
                                    'OFFER_APPROVED'
                                    , $offer
                                    , $offer['Offer']['user_id']
                            )
                    ) {
                        $this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                    } else {
                        $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Offer->User->Notification->id)));
                    }
                    $this->redirect('/admin/offers/view/' . $offerId);
                }
            }
        }
        $this->render('/common/ajax', 'ajax');
    }

    // OFFER_REJECTED
    function admin_reject($offerId=null) {
        $this->data = $this->Offer->read(null, $offerId);
        if ($this->data) {

            if ($this->data['Offer']['enabled'] == IS_DISABLED) { // proposal-rejected //
                $this->data['Offer'] = am($this->data['Offer'], Configure::read('Offer.status.proposal-rejected'));


                unset($this->data['Offer']['file']);

                $this->Offer->set($this->data['Offer']);


                if ($this->Offer->save($this->data, false)) {
                    $offer = $this->Offer->find(array('Offer.id' => $offerId));
                    if (!$this->Offer->User->Notification->add(
                                    'OFFER_REJECTED'
                                    , $offer
                                    , $offer['Offer']['user_id']
                            )
                    ) {
                        $this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                    } else {
                        $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Offer->User->Notification->id)));
                    }
                    $this->redirect('/admin/offers/view/' . $offerId);
                } else {
                    vd('WE CAN NOT SAVE THIS');
                }
            }
        }
        $this->render('/common/ajax', 'ajax');
    }

    function admin_view($id = null) {

        if (!$id) {
            $this->Session->setFlash(__('Invalid offer', true));
            $this->redirect(array('action' => 'index'));
        }

        $this->set('offer', $this->Offer->read(null, $id));
    }

    var $paginate = array(
        //          'order' => 'Project.created',
        'direction' => 'DESC',
        'limit' => 10,
    );

    function admin_flag() {
        $ok = true;
        foreach ($this->data['Offer'] as $id => $data) {
            $saveData['Offer'] = $data;
            $saveData['Offer']['id'] = $id;
            $ok &= $this->Offer->save($saveData, false);
        }

        $this->data = array(
            'status' => $ok
        );
        $this->render('/common/json_response', 'json/default');
    }

    function admin_index($filter='all') {

        $this->data['Offer']['filter'] = $this->params['named']['filter'] = $filter;

        $this->autoPaginateOptions('filter', array(
            'disabled' => Configure::read('Offer.filter.status.disabled'), // caso de exito
            'proposals' => Configure::read('Offer.filter.status.proposal'),
            'rejected' => Configure::read('Offer.filter.status.proposal-rejected'),
            'approved' => Configure::read('Offer.filter.status.proposal-accepted'),
            'published' => Configure::read('Offer.filter.status.published'),
            'about-to-finish' => Configure::read('Offer.filter.about-to-finish'), // caso de exito
            'finished' => Configure::read('Offer.filter.finished'), // caso de exito
            'outstanding' => Configure::read('Offer.filter.outstanding'), // show in home page
            'leading' => Configure::read('Offer.filter.leading'), // caso de exito
			'week'=>array ('Offer.week =' => '1'),
            'default' => 'all'
                )
        );


        $this->autoPaginateOptions('sort', array('Offer.id', 'Offer.created', 'Offer.user_id', 'Offer.category_id', 'Offer.title'));
        $this->autoPaginateOptions('search', array('Offer.id', 'Offer.title like' => '%:value%'));
        $this->_preparePaginate();

        /**/
        /*
          vd($filter);
         */
        // vd($this->paginate);


        $this->paginate['contain'] = array('User', 'Category');


        $this->data['results'] = $this->paginate('Offer');

        $this->render('admin_index');
    }

    function getAboutToFinish() {

    }

//OFFER_ABOUT_TO_FINISH

    function getFinished() {

    }

// OFFER_FINISHED

    function add() {
        if ($this->data) {

            $this->data['Offer'] = am($this->data['Offer'], Configure::read('Offer.status.proposal')); // set Offer status as proposal

            $invalid = false;
            $hasLink = count(array_unique(Set::extract('/Link/link', $this->data))) > 1; //user has filled any link ?


            $invalid = $invalid || !$hasLink;


            if ($this->Offer->saveAll($this->data, array('validate' => 'only')) && !$invalid) {

                $this->Offer->saveAll($this->data);

                if ($this->Offer->id) {

                    if (!$this->Offer->User->Notification->add(
                                    'OFFER_PENDING_APPROVE'
                                    , $this->Offer->find(array('Offer.id' => $this->Offer->id))
                                    , $this->Auth->user('id')
                            )
                    ) {
                        $this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                    } else {
                        $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Offer->User->Notification->id)));
                    }


                    $this->redirect(array('controller' => 'offers', 'action' => 'listing', 'user' => User::getSlug($this->Auth->user())));
                } else {
                    $this->log('Error : Offer not saved ');
                }
            }

            if (!$hasLink) {
                $this->Offer->invalidate('link', __('AT_LEAST_ONE_LINK', true));
            }
        } else {
            $this->data['Offer']['offer_public'] = 1;
            $this->data['Offer']['offer_duration'] = 180;
        }
    }

    function edit($id = null, $publish=false, $getData = false) {

        if ($getData) { // try to validate and save data directly.
            $query['contain'] = array(); //,'Prize'

            $query['conditions'] = array(
                'Offer.user_id' => $this->Auth->user('id'),
                'Offer.id' => $id,
                'Offer.enabled' => 1
            );
            $this->data = $this->Offer->find('first', $query);
        }





        if (empty($this->data)) {
            if ($id) {
                $this->data = $this->Offer->find('first', array(
                            'conditions' => array('Offer.id' => $id, 'Offer.user_id' => $this->Auth->user('id')),
                            'contain' => array('Link')
                                )
                );
            }


            if (empty($this->data)) {
                $this->pageError = array('code' => 404);
            } elseif ($this->data['Offer']['enabled'] == 1 && $this->data['Offer']['public'] == 1) { // if offer exist and belongs to an auth user, check if it's editable
                $this->pageError = array('code' => 404);
            } elseif ($this->data['Offer']['enabled'] == 0) {
                $this->pageError = array('code' => 404);
            }
        } else {

            if ($publish) { // Wich validation set we will use ?
                $validData = $this->Offer->publishValidation($this->data);
            } else {
                $validData = $this->Offer->editValidation($this->data);
            }


            if ($validData) {
                if ($this->Offer->saveAll($validData, array('validate' => false))) {
                    if ($publish) {
                        if (!$this->Offer->User->Notification->add(
                                        'OFFER_CREATED'
                                        , $this->Offer->find(array('Offer.id' => $this->Offer->id))
                                        , $this->Auth->user('id')
                                )
                        ) {
                            $this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                        } else {
                            $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Offer->User->Notification->id)));
                        }
                    }
                    // send user to offer pre/view
                    $this->redirect(Router::url(array('controller' => 'offers', 'action' => 'view', 'offer' => Offer::getSlug($validData), 'user' => User::getSlug($this->Auth->user()))));
                }
            } else {
                $this->Session->setFlash(__(( $publish ? 'THIS_OFFER_IS_NOT_VALID_IT_CAN_NOT_BE_PUBLISHED' : 'THE_OFFER_COULD_NOT_BE_SAVED_PLEASE_TRY_AGAIN.'), true));
            }
        }

        $this->set('leadingOffer', $this->Offer->getLeading());
    }

    function index() { //DISCOVER
        $statuses = array(
            'most-popular' => __('MOST_POPULAR', true),
            'most-recent' => __('MOST_RECENT', true),
            'by-end' => __('BY_END', true),
            'finished' => __('FINISHED', true),
        );

        if (isset($this->params['search']) && empty($this->params['search'])) {
            $this->redirect('/projects', 403);
        }

        $this->set('statuses', $statuses);

        $this->set('categories', $this->Offer->Category->find('all', array('conditions' => array('Category.offer_count >' => 0), 'contain' => array())));

        $cities = $this->Offer->City->find('all', array(
                    'conditions' => array('City.offer_count >' => 0),
                    'contain' => array()
                        )
        );
        if (!empty($cities)) {
            $this->set('cities', $cities);
        }

        $baseUrl = array_filter(array(
            'city' => isset($this->params['city']) ? $this->params['city'] : null,
            'country' => isset($this->params['country']) ? $this->params['country'] : null,
            'category' => isset($this->params['category']) ? $this->params['category'] : null,
            'status' => isset($this->params['status']) ? $this->params['status'] : null,
                ), function ($element) {
                    return!is_null($element);
                });

        extract($baseUrl);
        $this->set(compact(array_keys($baseUrl)));

        /* -------------------------------------------------------------------- */

        $this->paginate = $this->Offer->queryStandarSet(false);
        $this->paginate['limit'] = 6;

        if (isset($this->params['search'])) {
            $this->loadModel('Search');
            $this->paginate['conditions']['Offer.id'] = $this->Search->customSearch($this->params['search'], 'Offer');
        }


        if (isset($category)) {
            $category_info = $this->Offer->Category->getFromSlug($category);
            $this->paginate['conditions']['Offer.category_id'] = @array_shift(Set::extract('/Category/id', $category_info));
            $this->set('categoryName', Category::getName($category_info));
        }

        if (isset($country) && !isset($city)) {
            $cities = $this->Offer->City->find('all', array(
                        'conditions' => array(
                            'City.country_slug' => $country
                        ),
                        'contain' => array()
                            )
            );
            $this->set('cityName', array_shift(Set::extract('/City/country', $cities)));
        } elseif (isset($city)) {
            $cities = $this->Offer->City->find('all', array(
                        'conditions' => array(
                            'City.country_slug' => $country,
                            'City.city_slug' => $city
                        ),
                        'contain' => array()
                            )
            );
            $city_name = array_shift(Set::extract('/City/city_name', $cities));
            $this->set('cityName', array_shift(Set::extract('/City/city_name', $cities)));
        }



        if (isset($status)) {
            switch ($status) {
                case 'most-recent' :
                    $this->paginate['order'] = 'Offer.publish_date DESC'; // mas recientemente publicados , no filtra
                    $this->paginate['conditions']['Offer.end_date >'] = date('Y-m-d');
                    break;
                case 'most-popular' : // DEFINIR CUALES SON LOS CRITERIOS PARA ESTO
                    $this->paginate['order'] = 'Offer.project_count DESC , Offer.follow_count DESC';
                    break;
                case 'by-end' :  // muestra los proyectos que terminan dentro de los proximos 15 dias ordenados por fecha de finalizacion.
                    $this->paginate['conditions']['Offer.end_date >'] = date('Y-m-d');
                    $this->paginate['conditions']['Offer.end_date <'] = date('Y-m-d', strtotime('+10 days'));
                    $this->paginate['order'] = 'Offer.end_date ASC';
                    break;
                case 'finished' :  // muestra los proyectos que terminan dentro de los proximos 15 dias ordenados por fecha de finalizacion.
                    $this->paginate['conditions']['Offer.end_date <'] = date('Y-m-d');
                    $this->paginate['order'] = 'Offer.end_date DESC';
                    break;
            }
            $this->set('statusName', $statuses[$status]);
        }



        $this->data = $this->paginate('Offer');
        $this->set('baseUrl', $baseUrl);
    }

    function view($id = null) {

        if ($id) {
            $this->data = $this->Offer->getViewData($id);
        }
        /*
        if (empty($this->data)) {
            $this->pageError = array('code' => 404);
        } elseif (!Offer::isPublic($this->data)) { // offer was not revised by system admins.
            $this->pageError = array('code' => 403);
        } elseif ($this->data['Offer']['user_id'] != $this->Auth->user('id') && $this->data['Offer']['public'] == 0) { // the offer exist
            $this->pageError = array('code' => 404);
        }
*/


                if(empty($this->data)) {
            $this->pageError = array('code' => 404);
        } elseif($this->data['Offer']['enabled'] == 0) { // offer was not revised by system admins.
            $this->pageError = array('code' => 403);
        } elseif($this->data['Offer']['user_id'] != $this->Auth->user('id') && $this->data['Offer']['public'] == 0) { // the offer exist
            $this->pageError = array('code' => 404);
        } else {
            /*
              if ($this->data['Project']['offer_id'] > 0  ) {
              $this->set('offer', $this->Project->Offer->getViewData($this->data['Project']['offer_id']) );
              }
             */
        }



    }

    function listing($user=true) { //listing
        $this->data = $this->Offer->User->getUser($user);

        if ($this->data) {

            $following = Set::extract('/Follow/model_id', $this->Offer->Follow->find('all', array(
                                'conditions' => array('Follow.user_id' => $this->data['User']['id'], 'Follow.model' => 'Offer'),
                                'contain' => array(),
                                    )
                            )
            );

            $query = $this->Offer->queryStandarSet(true, true);
            $query['conditions'] = array(
                'or' => array(
                    'Offer.user_id' => $this->data['User']['id'],
                    'Offer.id' => $following
                )
            );

            $this->data['Offers'] = $this->Offer->find('all', $query); //,'City'

            if (!empty($this->data['Offers'])) {

                foreach ($this->data['Offers'] as $key => $offer) {
                    if (!Offer::isOwnOffer($offer) && !Offer::isPublic($offer)) {
                        unset($this->data['Offers'][$key]);
                    }
                }





                //
            } else {
                $this->pageError = array('code' => 404);
            }
        } else {
            $this->pageError = array('code' => 404);
        }



        $this->set('section', 'offers');
        $this->render('/users/view');
    }

    /*
      function publish($id = null) {
      $published = false;
      $this->set('published', false);
      $query['contain'] = false;
      $query['conditions'] = array(
      'Offer.user_id' => $this->Auth->user('id'),
      'Offer.id' => $id,
      'Offer.enabled' => 1
      );
      $this->data = $this->Offer->find('first', $query);
      if (!$this->data) {
      $this->pageError = array('code' => 403);
      } else {
      if ($this->data['Offer']['public'] == IS_NOT_PUBLIC) {

      $this->data['Offer']['public'] = IS_PUBLIC;
      $this->data['Offer']['status'] = OFFER_STATUS_PUBLISHED;
      $this->data['Offer']['publish_date'] = date('Y-m-d');
      $this->data['Offer']['end_date'] = date('Y-m-d', strtotime("+{$this->data['Offer']['offer_duration']} days"));

      unset($this->data['Offer']['file']);
      if ($this->Offer->save($this->data)) {
      if (!$this->Offer->User->Notification->add(
      'OFFER_CREATED'
      , $this->Offer->find(array('Offer.id' => $this->Offer->id))
      , $this->Auth->user('id')
      )
      ) {
      $this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
      } else {
      $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email','admin' =>false, $this->Offer->User->Notification->id)));
      }

      if (!$this->RequestHandler->isAjax()) {
      $this->Session->setFlash(__('THIS_OFFER_IS_NOW_PUBLISHED', true));
      $this->redirect(Offer::getLink($this->data));
      }

      $published = true;
      } else {
      if (!$this->RequestHandler->isAjax()) {
      $this->Session->setFlash(__('THIS_OFFER_IS_NOT_VALID_IT_CAN_NOT_BE_PUBLISHED', true));
      $this->redirect('/offers/edit/' . $id);
      }
      }
      }
      }
      $this->data = array(
      'status' => $published
      );
      $this->render('/common/json_response', 'json/default');
      }
     */

    function delete($id) {
        $query['contain'] = false;
        $query['conditions'] = array(
            'Offer.user_id' => $this->Auth->user('id'),
            'Offer.id' => $id,
            'Offer.public' => IS_NOT_PUBLIC
        );
        $this->data = $this->Offer->find('first', $query);
        if (!$this->data) {
            $this->pageError = array('code' => 403);
        } else {
            $this->Offer->delete($id);
            $this->redirect('/profile');
        }
        $this->render('/common/ajax');
    }

    function cron_aboutToFinish() {
        $query = array();
        $query['contain'] = array();
        $query['fields'] = array('Offer.id', 'Offer.user_id');

        $query['conditions']['Offer.end_date'] = date('Y-m-d', strtotime("+" . DAYS_TO_BE_FINISHING . " days"));
        $query['conditions']['Offer.about_to_finish'] = 0;

        $endingOffers = $this->Offer->find('all', $query);

        // vd(date('d-m-Y', strtotime("+" . DAYS_TO_BE_FINISHING . " days")));

        foreach ($endingOffers as $offer) {

            $offer['Offer']['about_to_finish'] = 1;

            $this->Offer->save($offer, false);

            if (!$this->Offer->User->Notification->add(//OFFER_ABOUT_TO_FINISH
                            'OFFER_ABOUT_TO_FINISH'
                            , $offer['Offer']['id']
                            , $offer['Offer']['user_id']
                    )
            ) {
                $notification_ids[] = $this->Offer->User->Notification->id;
            }
        }

        foreach ($notification_ids as $notification_id) {
            $emailed = $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $notification_id)));
        }



        $this->render('/common/ajax', 'ajax');
    }

    function cron_Finished() {
        $query = array();
        $query['contain'] = array();
        $query['fields'] = array('Offer.id', 'Offer.user_id');

        $query['conditions']['Offer.end_date'] = date('Y-m-d');
        $query['conditions']['Offer.finished'] = 0;

        $finishedOffers = $this->Offer->find('all', $query);


        foreach ($finishedOffers as $offer) {

            $offer['Offer']['finished'] = 1;

            $this->Offer->save($offer, false);

            if ($this->Offer->User->Notification->add(//OFFER_ABOUT_TO_FINISH
                            'OFFER_FINISHED'
                            , $offer['Offer']['id']
                            , $offer['Offer']['user_id']
                    )
            ) {
                $notification_ids[] = $this->Offer->User->Notification->id;
            }
        }

        foreach ($notification_ids as $notification_id) {
            $emailed = $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $notification_id)));
        }


        $this->render('/common/ajax', 'ajax');
    }

}

?>
