<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @property Report $Report
 */
class ReportsController extends AppController {

    function add($model, $model_id) {
        if ($model == 'User') {
            $model_id = array_shift(Set::extract('/User/id', $this->Report->User->getUser($model_id)));
        }

        $query = array(
            'conditions' => array(
                'Report.user_id' => $this->Auth->user('id'),
                'Report.model' => $model,
                'Report.model_id' => $model_id,
            ),
            'contains' => array()
        );

        $this->data = $this->Report->find('all', $query);

        if (!$this->data) {
            $this->data['Report']['user_id'] = $this->Auth->user('id');
            $this->data['Report']['model'] = $model;
            $this->data['Report']['model_id'] = $model_id;
            $this->Report->save($this->data);
        }
        $this->data = array('status' => 'OK');
        $this->render('/common/json_response', 'json/default');
    }

    function admin_delete($model, $id) {

 
        $reports = $this->Report->find('all', array('conditions' => array(
                        'Report.model' => Inflector::classify($model),
                        'Report.model_id' => $id
                    ),
                    'contain' => array()
                        )
        );
        
        
        
        foreach ($reports as $key => $report) {
            $id = array_shift(Set::extract('/Report/id', $report));
            $this->Report->delete($id,false);
        }


        $this->data = array('status' => 'OK');
        $this->render('/common/json_response', 'json/default');
    }

}

?>
