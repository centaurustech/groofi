<?php

/**
 * @property Link $Links
 * @property User $User
 * @property Post $Post
 * @property Offer $Offer
 * @property Category $Category
 */
class Predefinido extends AppModel {
	var $belongsTo = array(
        
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id',
            'counterCache' => true,
            'counterScope' => array(),
            'conditions' => array(),
            'dependent' => true,
        )
    );
	
     var $hasMany = array(
        
        'Prize' => array(
            'className' => 'Prize',
            'foreignKey' => 'model_id',
            'conditions' => array('Prize.model' => 'Predefinido'),
            'dependent' => true,
            'order' => 'Prize.value ASC'
        )
    );
}

?>
