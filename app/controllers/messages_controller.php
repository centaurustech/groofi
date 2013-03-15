<?

/**
 * @property Message $Message
 */
class MessagesController extends AppController {

    function index($tab='unread') {
        $query['contains'] = array('Sender', 'User');
        $query['order'] = 'Message.created DESC';

        switch ($tab) {
            /*case 'unread' :
                $query['conditions'] = array('Message.user_id' => $this->Auth->user('id'), 'Message.read' => 0,
					'NOT'=>array(
               array('Message.sender_id'=> array($this->Auth->user('id')))
            )	*/
			case 'unread' :
                $query['conditions'] = array('Message.user_id' => $this->Auth->user('id'), 'Message.read' => 0);
                break;
            case 'read' :
                $query['conditions'] = array('Message.user_id' => $this->Auth->user('id'), 'Message.read' => 1);
                break;
            case 'all' :
                $query['conditions'] = array('or' => array('Message.user_id' => $this->Auth->user('id'), 'Message.sender_id' => $this->Auth->user('id')));
                break;
            case 'sent' :
                $query['conditions'] = array('Message.sender_id' => $this->Auth->user('id'));
                break;
        }

        $this->data = $this->Message->find('all', $query);
        $this->set(compact('tab'));
    }

    function add() {
        $sender = $this->data['Message']['sender_id'] = $this->Auth->user('id');
        if ($sender) {
            if ($this->Message->save($this->data)) {
                echo json_encode(array(
                    'error' => false,
                    'error_msg' => ''
                        )
                );
                
                
                
            } else {
                echo json_encode(array(
                    'error' => true,
                    'error_msg' => __('THIS_MESSAGE_CANT_NOT_BE_SENT', true)
                        )
                );
            }
        } else {
            echo json_encode(array(
                'error' => true,
                'error_msg' => __('THIS_MESSAGE_CANT_NOT_BE_SENT', true)
                    )
            );
        }

        $this->layout = 'json/default';
    }
	function add2() {
        $sender = $this->data['Message']['sender_id'] = $this->Auth->user('id');
        if ($sender) {
            if ($this->Message->save($this->data)) {
                //exito
                $this->set('enviook', 1);
                
                
            } else {
                //error
				 $this->set('enviook', 0);
            }
        } else {
           //error
		    	$this->set('enviook', 0);
        }

        $this->layout='panino';
		$this->render('/messages/panino2');
    }
	function read2($id) {
        $this->data = $this->Message->find('first', array(
                    'contain' => array(),
                    'conditions' => array(
                        'Message.id' => $id,
                        'Message.user_id' => $this->Auth->user('id')
                    ),
                        )
        );

        if ($this->data) {
            $this->data['Message']['read'] = 1;
            if ($this->Message->save($this->data)) {
                $this->set('enviook', 1);

            } else {
                $this->set('enviook',0);
            }
        } else {
            $this->set('enviook', 0);
        }
         $this->layout='panino';
		 $this->render('/messages/panino4');
    }
    function read($id) {
        $this->data = $this->Message->find('first', array(
                    'contain' => array(),
                    'conditions' => array(
                        'Message.id' => $id,
                        'Message.user_id' => $this->Auth->user('id')
                    ),
                        )
        );

        if ($this->data) {
            $this->data['Message']['read'] = 1;
            if ($this->Message->save($this->data)) {
                echo json_encode(array(
                    'error' => false,
                    'error_msg' => ''
                        )
                );

                if ($this->Auth->user()) {
                    $user = $this->Message->User->read(null, $this->Auth->user('id'));
                    $this->Session->write('Auth.User.message_count', $user['User']['message_count']);
                }
            } else {
                echo json_encode(array(
                    'error' => true,
                    'error_msg' => FALSE
                        )
                );
            }
        } else {
            echo json_encode(array(
                'error' => true,
                'error_msg' => FALSE
                    )
            );
        }
        $this->layout = 'json/default';
    }

    function delete2($id) {
        $this->data = $this->Message->find('first', array(
                    'contain' => array(),
                    'conditions' => array(
                        'Message.id' => $id,
                        'Message.user_id' => $this->Auth->user('id')
                    ),
                        )
        );

        if ($this->data) {
            if ($this->Message->delete($this->data['Message']['id'])) {
                 $this->set('deleteok', 1);
				 $this->set('ori', $this->data['ori']);
            } else {
               $this->set('deleteok', 0);
            }
        } else {
            $this->set('deleteok', 0);
        }
        $this->layout='panino';
		$this->render('/messages/panino3');
    }
	
	function delete($id) {
        $this->data = $this->Message->find('first', array(
                    'contain' => array(),
                    'conditions' => array(
                        'Message.id' => $id,
                        'Message.user_id' => $this->Auth->user('id')
                    ),
                        )
        );

        if ($this->data) {
            if ($this->Message->delete($this->data['Message']['id'])) {
                echo json_encode(array(
                    'error' => false,
                    'error_msg' => ''
                        )
                );
            } else {
                echo json_encode(array(
                    'error' => true,
                    'error_msg' => FALSE
                        )
                );
            }
        } else {
            echo json_encode(array(
                'error' => true,
                'error_msg' => FALSE
                    )
            );
        }
        $this->layout = 'json/default';
    }

}

?>