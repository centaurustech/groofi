<?

/**
 * @property Follow $Follow
 */
class FollowsController extends AppController {

    function beforeFilter() {
        $this->Auth->allow('listing');
        parent::beforeFilter();
    }

    function add($model, $model_id) {
        $model = Inflector::classify($model);
        $this->Follow->{Inflector::classify($model)}->recursive = -1;
        $modelData = $this->Follow->{Inflector::classify($model)}->read(null, $model_id); // get data
        $this->data = false;
        if ($this->Auth->user() && $modelData[$model]['user_id'] != $this->Auth->user('id')) { // you cant follow your self
            $query['conditions']['Follow.user_id'] = $this->data['Follow']['user_id'] = $this->Auth->user('id');
            $query['conditions']['Follow.model'] = $this->data['Follow']['model'] = $model;
            $query['conditions']['Follow.model_id'] = $this->data['Follow']['model_id'] = $model_id;
			
            if (!$this->Follow->find('all', $query)) {
				
                $this->data = $this->Follow->save($this->data);
                if (low($model) == 'offer') {



                    if (!$this->Follow->User->Notification->add(//OFFER_NEW_USER
                                    'OFFER_NEW_USER'
                                    , $this->Follow->find(array('Follow.id' => $this->Follow->id))
                                    , $this->Auth->user('id')
                            )
                    ) {
                        $this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                    } else {
                        $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Follow->User->Notification->id)));
                    }
                }
            }
        }
        //$this->render('/common/ajax', 'ajax');
        //$this->render('/common/json_response', 'json/default');
		$loginok=$this->Auth->user()?1:0;
		$eselautor=$this->Auth->user() && $modelData[$model]['user_id'] == $this->Auth->user('id')?1:0;
		$this->set('loginok', $loginok);
		$this->set('agregar',1);
		$this->set('eselautor',$eselautor);
		$this->layout='panino';
		$this->render('/projects/panino2');
		
		
    }

    function delete($model, $model_id) {
        $model = Inflector::classify($model);
        $this->data = false;
        $this->Follow->recursive = -1;
        $query['conditions']['Follow.user_id'] = $this->data['Follow']['user_id'] = $this->Auth->user('id');
        $query['conditions']['Follow.model'] = $this->data['Follow']['model'] = $model;
        $query['conditions']['Follow.model_id'] = $this->data['Follow']['model_id'] = $model_id;
        $id = array_shift(Set::extract('/Follow/id', $this->Follow->find('all', $query)));
        $this->data = $this->Follow->delete($id, false);
        //$this->render('/common/json_response', 'json/default');
		$loginok=$this->Auth->user()?1:0;
		$this->set('loginok', $loginok);
		$this->set('borrar', 1);
		$this->layout='panino';
		$this->render('/projects/panino2');
		
    }

    function listing($user=true) { //listing
        $this->data = $this->Follow->User->getUser($user);
        if ($this->data) {
            $this->data['Follows'] = $this->Follow->find('all', array(
                        'conditions' => array(
                            'Follow.user_id' => $this->data['User']['id'],
                            'Follow.model' => 'Project',
                        ),
                        'contain' => array(
                        )
                            )
            ); //,'City'
            if ($this->data['Follows']) {
                foreach ($this->data['Follows'] as $key => $follow) {
                    $model = Inflector::classify($follow['Follow']['model']);
                    $this->data['Follows'][$key] += $this->Follow->{$model}->getViewData($follow['Follow']['model_id']);
                }
            }
        } else {
            $this->pageError = array('code' => 404);
        }
        $this->set('section', 'follows'); //??
        $this->render('/users/view');
    }

}

