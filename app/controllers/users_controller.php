<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @property User $User
 */
class UsersController extends AppController {

    function beforeFilter() {
        if(isset($_SESSION['idioma']) && !empty($_SESSION['idioma'])){
            $idioma = $_SESSION['idioma'];
            Configure::write('Config.language', $idioma);
        }

        $this->Auth->allow(array(
            'add', 'is_authenticated', 'forgot_password', 'recover_password', 'view', 'add', 'confirm', 'login','login2','login3','sincro'
                )
        );
        parent::beforeFilter();
        //$this->set('adminMenu', $this->_getAdminMenu());

    }


    function admin_logout() {
        $this->logout();

    }

    function logout() {
        $this->Auth->logout();
		$this->Cookie->delete('Auth.User');
        $this->redirect(Router::url(array(
                    'controller' => 'users',
                    'action' => 'login'
                        )
                )
        );
		

    }

    function delete() {


        $password = $this->Auth->password($this->data['deleteAccount']['password']);
        $query['conditions'] = array(
            'User.id' => $this->Auth->user('id'),
            'User.password' => $password,
        );
        $user = $this->User->find('all', $query);

        if($user) {
            // buscamos ofrecimientos o proyectos activos, si los encontramos la cuenta no podra ser eliminada.
            $query['conditions']['Project.finished'] = PROJECT_NOT_FINISHED;
            $query['conditions']['Project.user_id'] = $this->Auth->user('id');
            $query['contain'] = array();
            $projects = $this->User->Project->find('count', $query);

            $query['conditions']['Offer.finished'] = OFFER_NOT_FINISHED;
            $query['conditions']['Offer.user_id'] = $this->Auth->user('id');
            $query['contain'] = array();
            $offers = $this->User->Offer->find('count', $query);
        }  // --->


        $deleteable = $projects + $offers >= 1 ? false : true;




        $this->render('/common/ajax');

    }

    function is_authenticated() {
        $this->data['status'] = (bool) $this->Auth->user();
        if($this->data['status']) {
            $this->data['User'] = array(
                'id' => $this->Auth->user('id'),
                'email' => $this->Auth->user('email'),
                'display_name' => $this->Auth->user('display_name')
            );
        }

        if($this->RequestHandler->isAjax()) {
            $this->render('/common/json_response', 'json/default');
        } else {
            $this->pageError = array('code' => 404);
        }

    }


      function afterFacebookLogin(){

      //Logic to happen after successful facebook login.
      vd('logued in facebook complete');
      //$this->redirect('/custom_facebook_redirect');
      }

    function admin_login() {


        $this->set('error', false);

        if(!empty($this->data)) {
            if(!$this->Auth->login($this->data)) {

                $this->set('error', true);
            }
        }

        if($this->Auth->user()) {



            $this->redirect($this->Auth->redirect());
        }
        $this->render('admin_login');

    }
	function login3(){
		$fbid=0;
		if(isset($_COOKIE['track'])){
			$fbid=explode('__###__',$_COOKIE['track']);
			$fbid=$fbid[0];
		}
	    if(!isset($_COOKIE['track']) || empty($_COOKIE['track']) || empty($fbid)){
			header("Location:/signup");
			exit;
		}

		$this->set('completarLoginFB', 1);
		$this->set('dataFB', $_COOKIE['track']);
		$_SESSION['tmpdataFB']=$_COOKIE['track'];
		$_COOKIE['track']=0;
		setcookie("track", '', time()-86400, "/");
		$this->render('add');
	}
	function login2(){
		if(!empty($this->data)) {
			$this->Auth->autoRedirect = false;
        	$this->Auth->login($this->data);
			if( $this->Auth->user()){
				$this->set('loginok', 1);
				$this->layout='panino';
			 	$this->render('/users/panino2');
			}else{
				$this->set('loginok', 0);
				$this->layout='panino';
			 	$this->render('/users/panino2');
			}
        }else{
				$this->set('loginok', 0);
				$this->layout='panino';
			 	$this->render('/users/panino2');
		}
	}
	function sincro(){

		if(!isset($_SESSION['tmpdataFB']) || empty($_SESSION['tmpdataFB'])){
			header("Location:/signup");
			exit;
		}
		if(!empty($this->data) && $this->data['User']['sincronice']==1){

			App::import('model', 'User');
			$pp=new User();
			$this->Auth->autoRedirect = false;
        	$this->Auth->login($this->data);
			if( $this->Auth->user()){
				$totales=$this->Auth->user();
				$fbid=explode('__###__',$_SESSION['tmpdataFB']);
				$fbid=$fbid[0];
				$pp->query("update users set facebook_id='".$fbid."' where id='".$totales['User']['id']."'");
				unset($_SESSION['tmpdataFB']);
				if($this->data['User']['remember_me']){
					 $cookie = array();
                	 $cookie['email'] = $this->data['User']['email'];
                	 $cookie['password'] = $this->data['User'][$this->Auth->fields['password']];
                	 $this->Cookie->write('Auth.User', $cookie, true, '+2 weeks');
                	 unset($this->data['User']['remember_me']);
				}
				if( !isset($_SESSION['VOLVER']) || empty($_SESSION['VOLVER']) ){
					$this->redirect($this->Auth->redirect());
				}else{
					$this->redirect( $_SESSION['VOLVER']);
					$_SESSION['VOLVER']=0;
				 	unset($_SESSION['VOLVER']);
				}
				
				
			}else{
				$datafb=explode('__###__',$_SESSION['tmpdataFB']);
				$fbid=$datafb[0];
				$this->data['User']['facebook_id'] = $fbid;
				$this->data['User']['display_name'] = $datafb[1];
				if(isset($this->data['User']['password']) && $this->data['User']['password'] == $this->data['User']['password_confirmation']) {
                	$this->data['User']['password'] = $this->Auth->password($this->data['User']['password']);
           		}
				$link = Router::url(array('controller' => 'staticpages', 'action' => 'message', 'messageSlug' => 'thanks-for-registering'));
            	$sendEmail = true;
				if($this->User->save($this->data)) {
					unset($_SESSION['tmpdataFB']);
                	$this->User->setFbPhoto($file, $this->Connect, $this->data);
                	$this->Session->write('Message.variables', array('link' => '<a href="/login">Ingresa aqui</a>'));
                	if($sendEmail) {
                    	if(!$this->User->Notification->add(
                                    'USER_WELCOME_MAIL'
                                    , $this->User->find(array('User.id' => $this->User->id))
                                    , $this->User->id
                            )
                    	) {
                        $this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                    	} else {
                        	$this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->User->Notification->id)));
                   	 	}
                	}

                	$this->redirect($link);
            	}else{
					$this->set('completarLoginFB', 1);	
				}

 				$this->data['User']['password'] = '';
        		$this->data['User']['password_confirmation'] = '';
		 		if($this->data) {
					$this->set('validationErrorsArrayFB', $this->User->invalidFields());
		 		}
				
				
			}
		}
		$this->render('add');
	}
    function login() {


        App::import('model', 'User');
		/*if(!empty($this->data)) {
			$this->Auth->autoRedirect = false;
        	$this->Auth->login($this->data);
			if( $this->Auth->user()){
				echo 'ok';	
			}else{
				echo 'ko';
			}
			return;
        }*/
		/*
		if(isset($this->data['panino'])){
			 $this->set('loginok', (bool) $this->Auth->user());	
			 $this->set('probando', 123);
			 $this->layout='panino';
			 $this->render('/users/panino2');
			 return;
		}*/
        //-- code inside this function will execute only when autoRedirect was set to false (i.e. in a beforeFilter).
		
        $this->set('error', false);
        if(true) {


            if(!empty($this->data) && @$this->data['User']['remember_me']) {
                $cookie = array();
                $cookie['email'] = $this->data['User']['email'];
                $cookie['password'] = $this->data['User'][$this->Auth->fields['password']];
                $this->Cookie->write('Auth.User', $cookie, true, '+2 weeks');
                unset($this->data['User']['remember_me']);
            }
        } elseif(!empty($this->data)) {

            $this->Auth->login($this->data);
        } elseif(empty($this->data)) {
            $cookie = $this->Cookie->read('Auth.User');
            if(!is_null($cookie)) {
                if($this->Auth->login($cookie)) {
                    //  Clear auth message, just in case we use it.
                    $this->Session->delete('Message.auth');
                    $this->redirect($this->Auth->redirect());
                } else { // Delete invalid Cookie
                    $this->Cookie->delete('Auth.User');
                }
            }
        }

        if(!empty($this->data) && !(bool) $this->Auth->user()) { // si auth user === false

            unset($this->data['User']['password']);
            $this->set('error', true);
        }

        if(!$this->RequestHandler->isAjax()) {

            if($this->Auth->user() && (!isset($_SESSION['VOLVER']) || empty($_SESSION['VOLVER']))) {
               if (isset($this->data['User']['fblogin'])){

                   $fc_user = $this->User->find(array ('conditions'=>array('User.email'=>$this->data['User']['email'])));

                   $this->User->updateAll(array('User.recomendar_face' => $fc_user->data['User']['recomendar_face']+1),array('User.email'=>$this->data['User']['email']));

                   $this->redirect(array('controller'=>'notifications', 'action'=> 'wallfb', 'fb'=>1));
               }else{
                $this->redirect($this->Auth->redirect());}
            }else if(isset($_SESSION['VOLVER']) && !empty($_SESSION['VOLVER'])){
				 $this->redirect( $_SESSION['VOLVER']);
				 $_SESSION['VOLVER']=0;
				 unset($_SESSION['VOLVER']);
			}
            $this->render('add');
        } else {

            $this->set('status', (bool) $this->Auth->user());
        }

        if(!$this->RequestHandler->isAjax() && !$this->Auth->user() && $this->Connect->user() && !$this->Connect->hasAccount) {
            $this->redirect(array('controller' => 'users', 'action' => 'add'));
        }

    }

    function admin_resendActivation($user_id) {
        $id = array_shift(Set::extract('/Notification/id', $this->User->Notification->find(array(
                            'Notification.user_id' => $user_id,
                            'Notification.notificationtype_id' => NOTIFICATION_USER_WELCOME_MAIL,
                        ))));

        if($id) {
            $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $id)));
        } else {
            if(!$this->User->Notification->add(
                            'USER_WELCOME_MAIL'
                            , $this->User->find(array('User.id' => $user_id))
                            , $user_id
                    )
            ) {
                $this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
            } else {
                $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->User->Notification->id)));
            }
        }
        $this->data = array('status' => 'ok');
        //$this->render('/common/ajax');
        $this->render('/common/json_response', 'default/json');

    }

    function forgot_password() {

        $this->data = $this->User->find(array('User.email' => $this->data['User']['email']));

        if($this->data) {

            if(!$this->User->Notification->add(
                            'PASSWORD_RECOVERY'
                            , $this->data
                            , $this->data['User']['id']
                    )
            ) {
                $this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
            } else {
                $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->User->Notification->id)));
            }
            $this->redirect(Router::url(array('controller' => 'staticpages', 'action' => 'message', 'messageSlug' => 'recover-link')));
        } else {
			//die('error');
			if(isset($_POST['procesorecpass']))
				$this->set('ErrorRecordarClave', 1);
			$this->set('ErrorRecordarClave2', 1);
            $this->User->invalidate('email', __('FORGOT_PASSWORD_EMAIL_ERROR', true));
        }



        $this->render('add');

    }

    function recover_password($hc1, $hc2) {
        $user = $this->User->checkUserToken($hc1, $hc2);
        $this->data = $user ? $this->User->read(null, $user) : false;
        if($this->data) {
            if($this->Auth->login($this->data)) {
                $this->redirect(User::getLink($this->data, 'account'));
            }
        }
        $this->render('/common/ajax');

    }

    function view($user=true) {


        //   $this->User->City->slugCities();


        $this->User->contain = array('Link');
        $section = 'activity';

        $this->data = $this->User->getUser($user); // get user data.


        if(!$this->data) {
            $this->pageError = array('code' => 404);
        }

        $this->set(compact('section'));

    }

    function add() {
		
		
        if($this->Auth->user()) {
            $this->redirect(array('controller' => 'users', 'action' => 'edit'));
        }

        if($this->data) {
			
            if(isset($this->data['User']['password']) && $this->data['User']['password'] == $this->data['User']['password_confirmation']) {
                $this->data['User']['password'] = $this->Auth->password($this->data['User']['password']);
            }

            if(isset($this->data['User']['city_id'])) { // fill location info.
                $city = $this->User->City->read(null, $this->data['User']['city_id']);
                if($city) {
                    $this->data['User']['city_id'] = $city['City']['id'];
                    $this->data['User']['city'] = $city['City']['city_name'];
                    $this->data['User']['country'] = $city['City']['country'];
                    $this->data['User']['country_id'] = $city['City']['country_code'];
                } else {
                    $this->data['User']['city_id'] = null;
                    $this->data['User']['city'] = null;
                    $this->data['User']['country'] = null;
                    $this->data['User']['country_id'] = null;
                }
            }

            //$this->data['User']['enabled'] = 1; // tmp
            //$this->data['User']['active'] = 1; // tmp
            //$this->data['User']['confirmed'] = 1; // tmp

            $link = Router::url(array('controller' => 'staticpages', 'action' => 'message', 'messageSlug' => 'thanks-for-registering'));

            $sendEmail = true;

            if($this->Connect->user() && !$this->Connect->hasAccount && $this->data['User']['email'] == $this->Connect->user('email')) {
                $this->data['User']['enabled'] = 1;
                $this->data['User']['active'] = 1;
                $this->data['User']['confirmed'] = 1;
                $link = Router::url(array('controller' => 'staticpages', 'action' => 'message', 'messageSlug' => 'welcome'));
                $sendEmail = false;
            }
			
			$notifications = $this->User->Notificationtype->find('list', array(
                'conditions' => array(
                    'disableable' => 1,
                    'or' => array(
                        'email_owner' => 1,
                        'email_user' => 1,
                    )
                ),
                'order' => array('id ASC'),
                'contain' => false
                    )
            );
           
                foreach($notifications as $key => $notification) {
                    $this->data['Notificationtype']['Notificationtype'][] =$key;
					
                }

			/*vd($this->data['Notificationtype']);exit;*/

            if($this->User->save($this->data)) {
                $this->User->setFbPhoto($file, $this->Connect, $this->data);
                $this->Session->write('Message.variables', array('link' => '<a href="/login">Ingresa aqui</a>'));


                if($sendEmail) {
                    if(!$this->User->Notification->add(
                                    'USER_WELCOME_MAIL'
                                    , $this->User->find(array('User.id' => $this->User->id))
                                    , $this->User->id
                            )
                    ) {
                        $this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                    } else {
                        $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->User->Notification->id)));
                    }
                }

                $this->redirect($link);
            }
        } elseif($this->Connect->user() && !$this->Connect->hasAccount) {
            $this->data = $this->User->fillFbInfo($this->Connect, $this->data, false);
            $this->data['User']['facebook_id'] = $this->Connect->user('id');
        }

        $this->data['User']['password'] = '';
        $this->data['User']['password_confirmation'] = '';
		 if($this->data) {
			$this->set('validationErrorsArray', $this->User->invalidFields());
		 }
    }

    function confirm($hc1, $hc2) {
        $user = $this->User->checkUserToken($hc1, $hc2);
        $this->data = $user ? $this->User->read(null, $user) : false;
        if($this->data) {
            $this->data['User']['enabled'] = 1;
            $this->data['User']['active'] = 1;
            $this->data['User']['confirmed'] = 1;
            $this->User->save($this->data, false);
            $this->redirect(Router::url(array('controller' => 'staticpages', 'action' => 'message', 'messageSlug' => 'welcome')));
        } else {
            $this->pageError = array('code' => 404);
        }

        $this->render('/common/ajax');

    }

    function edit($tab=false, $update=false) {
		//vd($_POST);
		//exit;
		if(isset($_POST['tab2'])){
			$tab = 'account';
			if(!isset($_POST['que']) && (empty($this->data['User']['password']) && empty($this->data['User']['password_confirmation']))){
				unset($this->data['User']['password']);
                unset($this->data['User']['password_confirmation']);
                unset($this->User->validate['password_confirmation']);
                unset($this->User->validate['password']);
			}
		}
		

        /*
          $hash = User::getLink($this->Auth->user(), 'mail-confirmation', true); // ??

          vd($hash);
         */


        $this->User->Link; // ??  // load Link
        if($this->data) {
            if($tab == 'profile') {
                unset($this->data['User']['password']);
                unset($this->data['User']['password_confirmation']);
                unset($this->User->validate['password_confirmation']);
                unset($this->User->validate['password']);
				unset($this->User->validate['email']);
				unset($this->User->validate['slug']);
				
            } else {
                unset($this->User->validate['slug']);
                unset($this->User->validate['biography']);
                unset($this->User->validate['email']);
                unset($this->User->validate['display_name']);

                if(isset($this->data['User']['password']) && $this->data['User']['password'] == $this->data['User']['password_confirmation']) {
                    $this->data['User']['password'] = $this->Auth->password($this->data['User']['password']);
                }
				//vd( $this->data['User']);
            }
			  
            //$this->User->setLocation($this->data);
			
            if($this->User->saveAll($this->data, array('validate' => 'first'))) {
				
                $this->Session->write('Auth', $this->User->find('first', array('conditions' => array('User.id' => $this->User->id))));
				
                $this->Session->setFlash(__('YOUR_INFO_HAS_BEEN_UPDATED', true));
				if(!isset($_POST['tab2'])){
                	$this->redirect(Router::url(array('controller' => 'users', 'action' => 'edit', 'tab' => $tab)));
				}else{
					$this->redirect(Router::url(array('controller' => 'users', 'action' => 'edit', 'tab' =>'account')));
				}
            }
        }

        $this->data = $this->User->find('first', array(
            'conditions' => array('User.id' => $this->Auth->user('id')),
            'contain' => array('Notificationtype', 'Link'), //=> $this->Auth->user('id')
                )
        );

        if($this->data) {


            $this->data['User']['password'] = $this->data['User']['password_confirmation']; // set plain password-

            if($update) {
                $this->data = $this->User->fillFbInfo($this->Connect, $this->data);
            }

            $this->set('facebook_update', $update);

            $notifications = $this->User->Notificationtype->find('list', array(
                'conditions' => array(
                    'disableable' => 1,
                    'or' => array(
                        'email_owner' => 1,
                        'email_user' => 1,
                    )
                ),
                'order' => array('id ASC'),
                'contain' => false
                    )
            );
            if(empty($this->data['Notificationtype'])) {
                foreach($notifications as $key => $notification) {
                    $this->data['Notificationtype']['Notificationtype'][$key] = true;
                }
            }

            $this->set(compact('notifications'));
        } else {
            $this->Auth->logout();
            $this->redirect(array('controller' => 'users', 'action' => 'add'));
        }

        $this->data['User']['password'] = '';
        $this->data['User']['password_confirmation'] = '';
		if($this->data) {
			$this->set('validationErrorsArray', $this->User->invalidFields());	
		}
		if($tab=='account' || isset($_POST['tab2'])){
			 $this->render('edit2');
		}
    }
	

    function admin_index($filter=null, $type=null) {


        if(isset($_GET['idioma'])){

            $idioma = $_GET['idioma'];



        switch ($idioma){
            case "en": $new_idioma = "eng";
                break;
            case "es": $new_idioma = "esp";
                break;
            case "it": $new_idioma = "ita";
                break;
            default:  $new_idioma = "esp";
        }
        unset($_SESSION['idioma']);
        $_SESSION['idioma'] = $new_idioma;
            Configure::write('Config.language', $new_idioma);
        $this->redirect('/admin');
        }

        $this->data['User']['filter'] = $this->params['named']['filter'] = $filter . '_' . $type; // custom filter...


        $this->autoPaginateOptions('filter', array(
            'reported_users' => array('User.report_count >' => 0, 'User.admin' => 0),
            'active_users' => array('User.active' => 1, 'User.admin' => 0),
            'inactive_users' => array('User.active' => 0, 'User.admin' => 0),
            'functional_users' => array('User.confirmed' => 1, 'User.active' => 1, 'User.admin' => 0),
            'all_admins' => array('User.admin' => 1),
            'active_admins' => array('User.admin' => 1, 'User.active' => 1),
            'inactive_admins' => array('User.admin' => 1, 'User.active' => 0),
            'default' => 'all',
                )
        );

        $this->autoPaginateOptions('sort', array('User.id', 'User.created', 'User.display_name', 'User.email'));
        $this->autoPaginateOptions('search', array('User.id', 'User.email', 'User.display_name like' => '%:value%'));
        $this->_preparePaginate();

        $this->paginate['contain'] = array(
            'Notification' => array(
                'conditions' => array(
                    'Notification.notificationtype_id' => 23
                )
            )
        );

        $this->data['results'] = $this->paginate('User');

    }

    function admin_flag() {
        $ok = true;
        foreach($this->data['User'] as $id => $data) {
            $saveData['User'] = $data;
            $saveData['User']['id'] = $id;
            $ok &= $this->User->save($saveData, false);
        }

        $this->data = array(
            'status' => $ok
        );
        $this->render('/common/json_response', 'json/default');

    }

    function admin_add() {

        if($this->data) {
            if(isset($this->data['User']['password']) && $this->data['User']['password'] == $this->data['User']['password_confirmation']) {
                $this->data['User']['password'] = $this->Auth->password($this->data['User']['password']);
            }
            $this->data['User']['confirmed'] = 1;
            $this->data['User']['active'] = 1;
            $this->data['User']['enabled'] = 1;
            $this->data['User']['admin'] = 1;
            $this->data['User']['username'] = $this->data['User']['email'];
            $this->data['User']['level'] = USER_LEVEL_ADMIN;
            $this->User->create($this->data);
            if($this->User->admin_validates() && $this->User->save($this->data)) {
                $this->Session->setFlash(__('USER_HAS_BEEN_CREATED', true));
                $this->redirect(array('action' => 'index'));
            }
        }

    }

    function admin_edit($id=false) {

        if($this->data) {
            $this->data['User']['admin'] = 1;
            $this->data['User']['level'] = USER_LEVEL_ADMIN;

      //      $this->data['User']['username'] = $this->data['User']['email'];
            if($this->User->admin_validates($this->data) && $this->User->save($this->data)) {
                $this->Session->setFlash(__('USER_INFO_HAS_BEEN_UPDATED', true));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            $this->data = $this->User->read(null, $id ? $id : $this->Auth->user('id'));
        }
        $this->data['User']['password'] = $this->data['User']['password_confirmation'];

    }
    function  mails($notification_id){

        $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $notification_id)));
    }
}

?>
