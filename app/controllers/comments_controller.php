<?

/**
 * @property Category $Category
 */
class CommentsController extends AppController {

    function beforeFilter() {

        if(isset($_SESSION['idioma']) && !empty($_SESSION['idioma'])){
            $idioma = $_SESSION['idioma'];
            Configure::write('Config.language', $idioma);
        }

        $this->Auth->allow('index', 'add','add2');
        parent::beforeFilter();
    }

    function add($model, $id) {
		$origen=0;
        if ($this->data) {
			 $origen=$this->data['ori'];
			
            $this->data['Comment']['user_id'] = $this->Auth->user('id');
            $this->data['Comment']['model'] = Inflector::classify($model);
            $this->data['Comment']['model_id'] = $id;
            $error = true;

            /* - */
            if ($this->Comment->save($this->data)) {
                $error = false;
                $this->data = array('error' => $error, 'comment_id' => $this->Comment->id, 'data' => $this->data);

                //$comentedModel = $this->{Inflector::classify($model)}->read(null,$id) ;

                $action = up($model) . '_COMMENTED';
                $data = $this->Comment->find(array('Comment.id' => $this->Comment->id));

                if (!$this->Comment->User->Notification->add(
                                $action
                                , $data
                                , $this->Auth->user('id')
                                , $data[Inflector::classify($model)]['user_id']
                        )
                ) {
                    $this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                } else {
                    $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Comment->User->Notification->id)));
                }
            }


          /* if ($this->RequestHandler->isAjax()) {
			   echo 'mierda';exit;
                if ($error) {
                    $this->data = array('error' => $error);
                    foreach ($this->Comment->validationErrors as $field => $msg) {
                        $this->data['errors']["Comment" . ucfirst($field)] = __($msg, true);
                    }
                }
               $this->render('/common/json_response', 'json/default');
            }*/
        }
		
		if ($error) {
                    $this->data = array('error' => $error);
					if(!($this->Auth->user('id'))){
						$this->data['errors']['login']='Error Login';
					}
                    foreach ($this->Comment->validationErrors as $field => $msg) {
                        $this->data['errors']["Comment" . ucfirst($field)] = __($msg, true);
                    }
					
                }
		
        $this->set(compact('model', 'id'));
		$this->set('error',  $this->data['errors']);
		$this->set('ori', $origen);
		$this->layout='panino';
		$this->render('/comments/panino2');
		
    }
	
	
	

    function index($model, $id) {
        $model = Inflector::classify($model);
		unset($_SESSION['VOLVER']);
        // get data
			App::import('model',  $model);
			$q=new $model();
		
        $modelData = $q->getViewData($id); // - get view data for a project.
		
        if ($q->isPublic($modelData)) {
            $this->paginate = $this->Comment->queryStandarSet();
            $this->paginate['limit'] = 10;
            $this->paginate['order'] = 'Comment.created DESC';
            $this->paginate['conditions']['Comment.model'] = $model ; 
            $this->paginate['conditions']['Comment.model_id'] = $modelData[$model]['id'] ; 
            $this->data = $this->paginate('Comment');
			
            $this->set('model', $model);
            $this->set('id', $modelData[$model]['id']);
        } /*else {
            if (!$this->RequestHandler->isAjax()) {
                $this->redirect($this->Comment->{$model}->getLink($modelData));
            }
        }*/
		
			App::import('model', 'Link');
			$pp=new Project();
			$datos=$pp->query("select * from links where model_id=". $modelData['Project']['id']." and model='Project'");
			$modelData['LOSLINKS']=$datos;
		 Project::verifyPrivacityStatus($modelData['Project']['id'],$this->here);
		
        $this->set(low($model), $modelData);

        $this->render(low($model) . '_comments');
    }

    function view($id) {
        $query['conditions'] = array(
            'Comment.id' => $id,
        );


        $this->data = $this->Comment->find('first', $query);
    }

}

