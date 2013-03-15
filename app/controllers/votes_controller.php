<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @property Vote $Vote
 */
class VotesController extends AppController {

    function add($model, $model_id, $value=1) {
        if ($model == 'User') {
            $model_id = array_shift(Set::extract('/User/id', $this->Vote->User->getUser($model_id)));
        }

        $query = array(
            'conditions' => array(
                'Vote.user_id' => $this->Auth->user('id'),
                'Vote.model' => $model,
                'Vote.model_id' => $model_id,
            ),
            'contains' => array()
        );
        $this->Vote->contains =array () ;
        $this->data = $this->Vote->find('first', $query);


        $this->data['Vote']['user_id'] = $this->Auth->user('id');
        $this->data['Vote']['model'] = $model;
        $this->data['Vote']['model_id'] = $model_id;
        $this->data['Vote']['value'] = $value;

        $this->Vote->save($this->data);

        unset($query['conditions']['Vote.user_id']);

        $query['fields'] = 'AVG(value) as average';
        $score = $this->Vote->find('first', $query);
        $score = $score[0]['average'];

        
 
        $this->Vote->{$model}->query("UPDATE users SET score = $score WHERE id = $model_id");
        
        $this->data = array(
            'status' => 'OK',
            'score' => (int) $score
        );




        //$this->render('/common/ajax', 'ajax');
        $this->render('/common/json_response','json/default');
    }

}

?>
