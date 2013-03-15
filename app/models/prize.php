<?php

    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */

    /**
     * @property User $User
     * @property Project $Project
     * @property Offer $Offer
     */
    class Prize extends AppModel {

        var $belongsTo=array(
            'Project' => array(
                'className' => 'Project',
                'foreignKey' => 'model_id',
                /*                'counterCache' => true,
                  'counterScope' => array('Post.public' => 1), */
                'conditions' => array('model'=>'Project'),
                'dependent' => true,
            )
        );

        

        var $validate=array(
            'value' => array(
                'BOTH_FIELDS_MUST_BE_COMPLETED' => array(
                    'rule' => array('bothComplete'),
                    'required' => true
                ),
            ), 'description' => array(
                'BOTH_FIELDS_MUST_BE_COMPLETED' => array(
                    'rule' => array('bothComplete'),
                    'required' => true
                ),
            ),
        );

        function bothComplete($data) {
            $filled=( Validation::notEmpty($this->data[$this->alias]['value']) || Validation::notEmpty($this->data[$this->alias]['description']) );
            $value=array_shift($data);
            
            return  ($filled && !Validation::notEmpty($value)) ? false : true ;
        }


        function beforeSave($options = array()) { // Do not save incomplete prizes, do not show validation alerts.
            if ($this->data[$this->alias]['value'] == ''
                && $this->data[$this->alias]['description'] == ''
            ) {
                $this->data=array();
            }
            return parent::beforeSave($options);
        }

        
        function hasPrize($data) {
            return count(array_unique(Set::extract('/Prize/value', $data))) > 1 ;//user has filled any prize ? 
        }
    }

?>
