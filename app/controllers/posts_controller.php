<?php

class PostsController extends AppController {

    function beforeFilter() {

        if(isset($_SESSION['idioma']) && !empty($_SESSION['idioma'])){
            $idioma = $_SESSION['idioma'];
            Configure::write('Config.language', $idioma);
        }

        $this->Auth->allow('index', 'view'); //'index',
        parent::beforeFilter();
    }

    var $name = 'Posts';

    function index($model, $id) {
        $model = Inflector::classify($model);
       // $modelData = $this->Post->{Inflector::classify($model)}->getViewData($id); // get view data for a project.
		App::import('model',  $model);
		$q=new $model();
		
        $modelData = $q->getViewData($id);
		Project::verifyPrivacityStatus($modelData['Project']['id'],$this->here);

        if ($this->Post->{$model}->isPublic($modelData)) {
            $this->paginate['limit'] = 20;
            $this->paginate['contain'] = array('Comment' => array('order' => 'Comment.created DESC'), 'Comment.User');
            $this->paginate['order'] = 'Post.created DESC';
            $this->paginate['conditions'] = array(
                'Post.model' => $model,
                'Post.model_id' => $modelData[$model]['id'],
            );

            $this->data = $this->paginate('Post');
        } else {
            $this->redirect($this->Post->{$model}->getLink($modelData));
        }
		App::import('model', 'Link');
			$pp=new Project();
			$datos=$pp->query("select * from links where model_id=". $modelData['Project']['id']." and model='Project'");
			$modelData['LOSLINKS']=$datos;
        $this->loadModel ('Sponsor');
        if ($id) {



            $this->set('sponsors', $this->Sponsor->find('all',array('conditions'=>array('Sponsor.id_project' => $modelData['Project']['id']), 'order'=>'Sponsor.id DESC') ));

        }
        $this->set(compact('model', 'id', 'modelData'));


        $this->render('view_posts'); // 
    }

    function view($id = null) {
	
        if (!$id) {
            $this->Session->setFlash(__('Invalid post', true));
            $this->redirect(array('controller' => 'users', 'action' => 'index'));
        } else {


            $user = array_shift(Set::extract('/User/id', $this->Post->User->getUser($this->params['user'])));

            $this->data = $this->Post->find(
                            'first'
                            , array(
                        'conditions' => array(
                            'Post.id' => $id,
                            'Post.user_id' => $user,
                        )
                        , 'contain' => array('User','Comment' => array('order' => 'Comment.created DESC'), 'Comment.User')
                            )
            );

            if ($this->data) {

                $model = Inflector::classify($this->data['Post']['model']);
                $model_id = $this->data['Post']['model_id'];

                $modelData = $this->Post->{$model}->getViewData($model_id); // get view data for a project.
				 Project::verifyPrivacityStatus($modelData['Project']['id'],$this->here);
                /*

                  $this->paginate['limit'] = 10;
                  $this->paginate['contain'] = array('User');
                  $this->paginate['order'] = 'Comment.created DESC';
                  $this->paginate['conditions'] = array(
                  'Comment.model' => 'Post',
                  'Comment.model_id' => $this->data['Post']['id'],
                  );


                  //   $comments =  $this->Paginate('Comment') ;
                  //     vd ($comments) ;

                  $this->data['Comment'] = $this->Paginate('Comment');
                 */
				App::import('model', 'Link');
			$pp=new Project();
			$datos=$pp->query("select * from links where model_id=". $modelData['Project']['id']." and model='Project'");
			$modelData['LOSLINKS']=$datos;

                $this->set(compact('model', 'id', 'modelData'));

                //$this->render(low($model) . '_post'); // 
                $this->render('view_post'); // 
            } else {
                $this->pageError = array('code' => 404);
            }
        }
    }

    function add($type, $model_id) {
		
        if (in_array(low($type), array('project', 'offer'))) {
            $model = Inflector::classify($type);
            $query['conditions'] = array(
                "$model.id" => $model_id,
                "$model.user_id" => $this->Auth->user('id')
            );
            $parent = $this->Post->{$model}->find('first', $query);
        }
		
        if (!empty($parent)) {

            if (!empty($this->data)) {
                $this->Post->create();

                unset($this->data['Post']['id']);
                $this->data['Post']['model'] = $type;
                $this->data['Post']['model_id'] = $model_id;
                $this->data['Post']['user_id'] = $this->Auth->user('id');
                $this->data['Post']['enabled'] = 1;

                if ($this->Post->save($this->data)) {
					
                    //$this->Session->setFlash(__('The post has been saved', true));
                    if ($this->data['Post']['public'] == 1) {
                        if (!$this->Post->User->Notification->add(//PROJECT_NEW_UPDATE
                                        up(Inflector::singularize($type)) . '_NEW_UPDATE'
                                        , $this->Post->find(array('Post.id' => $this->Post->id))
                                        , $this->Auth->user('id')
                                )
                        ) {
                            $this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                        } else {
                            $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Post->User->Notification->id)));
                        }
						
						/*App::import('model',  $model);
						$q=new $model();
		
      					$link=$q::getLink($parent, 'updates');
						header("Location:$link");*/
                       $this->redirect(array(
                            'controller' => 'posts',
                            'action' => 'view',
                            'post' => $this->Post->id,
                            'user' => $this->Auth->user('id')
                                )
                        );
                    } else {

                        $this->redirect(Router::url(array('controller' => 'projects', 'action' => 'listing', 'user' => User::getSlug($this->Auth->user()))));
                    }
                } else {
					
                    $this->Session->setFlash(__('The post could not be saved. Please, try again.', true));
                }
            } else {
                $this->data['Post']['public'] = 1;
            }


            $this->data['Post']['model'] = $type;
            $this->data['Post']['model_id'] = $model_id;
            $this->data['Post']['user_id'] = $this->Auth->user('id');
        } else {
            $this->pageError = array('code' => 404);
        }



        /*

          if (!empty($this->data)) {
          $this->Post->create();

          }
         */
    }
	
	
	
	
	
	
	
    function edit($type, $model_id, $id) {

        if (in_array(low($type), array('project', 'offer'))) {
            $model = Inflector::classify($type);
            $query['conditions'] = array(
                "$model.id" => $model_id,
                "$model.user_id" => $this->Auth->user('id')
            );
            $parent = $this->Post->{$model}->find('first', $query);
        }

        if (empty($parent) || !$id) {
            $this->Session->setFlash(__('Invalid post', true));
            $this->redirect(array('action' => 'index'));
        }

        if (!empty($this->data)) {
            if ($this->Post->save($this->data)) {
                $this->Session->setFlash(__('The post has been saved', true));
                if ($this->data['Post']['public'] == 1) {
                    if (!$this->Post->User->Notification->add(//PROJECT_NEW_UPDATE
                                    up(Inflector::singularize($type)) . '_NEW_UPDATE'
                                    , $this->Post->find(array('Post.id' => $this->Post->id))
                                    , $this->Auth->user('id')
                            )
                    ) {
                        $this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                    } else {
                        $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Post->User->Notification->id)));
                    }
                }



                $this->redirect(array(
                    'controller' => 'posts',
                    'action' => 'view',
                    'post' => $this->Post->id,
                    'user' => $this->Auth->user('id')
                        )
                );
            } else {
                $this->Session->setFlash(__('The post could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Post->read(null, $id);
            $this->data['Post']['public'] = 1;
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for post', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Post->delete($id)) {
            $this->Session->setFlash(__('Post deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Post was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

    function admin_index() {
        $this->Post->recursive = 0;
        $this->set('posts', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid post', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('post', $this->Post->read(null, $id));
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->Post->create();
            if ($this->Post->save($this->data)) {
                $this->Session->setFlash(__('The post has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The post could not be saved. Please, try again.', true));
            }
        }
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid post', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Post->save($this->data)) {
                $this->Session->setFlash(__('The post has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The post could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Post->read(null, $id);
        }
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for post', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Post->delete($id)) {
            $this->Session->setFlash(__('Post deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Post was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

}

?>