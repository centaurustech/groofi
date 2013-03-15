<?php
class NotificationtypesController extends AppController {

	var $name = 'Notificationtypes';

	function admin_index() {
		$this->Notificationtype->recursive = 0;
		$this->set('notificationtypes', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid notificationtype', true), array('action' => 'index'));
		}
		$this->set('notificationtype', $this->Notificationtype->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Notificationtype->create();
			if ($this->Notificationtype->save($this->data)) {
				$this->flash(__('Notificationtype saved.', true), array('action' => 'index'));
			} else {
			}
		}

        $models = array(
            'User' => 'User' ,
            'Project' => 'Project' ,
            'Offfer' => 'Offer' 
        );

        $this->set(compact('models'));
            
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid notificationtype', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Notificationtype->save($this->data)) {
				$this->flash(__('The notificationtype has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Notificationtype->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid notificationtype', true)), array('action' => 'index'));
		}
		if ($this->Notificationtype->delete($id)) {
			$this->flash(__('Notificationtype deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Notificationtype was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
?>