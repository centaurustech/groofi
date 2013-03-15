<?php

    class Link extends AppModel {

        var $name="Link";
        var $useTable="links";
        var $primaryKey='id';
        var $conditions;
        var $order;
        var $limit;
        var $belongsTo=array(
            'User' => array(
                'className' => 'User',
                'foreignKey' => 'model_id',
                'conditions' => array("Link.model" => 'User')
            ), 'Project' => array(
                'className' => 'Project',
                'foreignKey' => 'model_id',
                'conditions' => array("Link.model" => 'Project')
            ),
            'Offer' => array(
                'className' => 'Offer',
                'foreignKey' => 'model_id',
                'conditions' => array("Link.model" => 'Offer')
            ),
            'Staticpage' => array(
                'className' => 'Staticpage',
                'foreignKey' => 'model_id',
                'conditions' => array("Link.model" => 'Staticpage')
            ),
        );
        
        var $validate=array(
            'link' => array(
                'url' => array(
                    'rule' => array('url', false),
                    'required' => true,
                    'allowEmpty' => true,
					'message' => 'Por favor ingrese una url v&aacute;lida'
                )
            )
        );

        function beforeSave($options = array()) { // no guarda links vacios. pero tampoco chilla en la validacion.
            if ($this->data['Link']['link'] == '') {
                $this->data=array();
            } else {
                if ( !Validation::url($this->data['Link']['link'],true) ) {
                    $this->data['Link']['link'] = 'http://' . $this->data['Link']['link'] ;
                } 
                
            }
            return parent::beforeSave($options);
        }
		static function getUsersLinks($userid){
			$pp=new Link;
			$datos=$pp->query("select * from links where model_id=$userid and model='User' order by id");
			return $datos;
		}

    }

?>
