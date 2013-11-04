<?php

/**
 * @property Link $Links
 * @property User $User
 * @property Post $Post
 * @property Offer $Offer
 * @property Category $Category
 */
class Project extends AppModel {

    var $actsAs = array(
        /*'Media.Transfer',
        'Media.Coupler',
        'Media.Generator',
        'Media.Meta',*/
        'Enableable',
        'Containable',
        'Sluggable' => array(
            'label' => 'title',
            'slug' => 'slug',
            'overwrite' => true
        )
    );
    var $virtualFields = array(
        'image_file' => "CONCAT_WS('/', Project.dirname, Project.basename)",
        'time_left' => " DATEDIFF(Project.end_date, NOW())",
        'elapsed_time' => " DATEDIFF( NOW() , Project.publish_date)",
        'total_time' => " DATEDIFF( Project.end_date , Project.publish_date)",
        /*'file' => "WWW_ROOT.'/image/transfer/project/tmp/img/'.Project.basename",*/
    );
    var $hasOne = array();
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'counterCache' => 'project_count',
            'counterScope' => array('Project.enabled >' => 0, 'Project.public' => 1), // projects aproved
            'conditions' => array(),
            'dependent' => true,
        ),
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'counterCache' => 'project_count',
            'counterScope' => array('Project.enabled >' => 0, 'Project.public' => 1), // projects aproved
            'conditions' => array(),
            'dependent' => true,
        ),
        'Offer' => array(
            'className' => 'Offer',
            'foreignKey' => 'offer_id',
            'counterCache' => 'project_count',
            'counterScope' => array('Project.enabled >' => 0, 'Project.public' => 1), // projects aproved */
            'conditions' => array(),
            'dependent' => true,
        ),
        '_User' => array(// used to add another conunterCache
            'className' => 'User',
            'foreignKey' => 'user_id',
            'counterCache' => 'project_proposal_count',
            'counterScope' => array( 'Project.public' => 0 ), // projects proposals
            'conditions' => array(),
            'dependent' => true,
        ),
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id',
            'counterCache' => true,
            'counterScope' => array('Project.enabled >' => 0, 'Project.public' => 1),
            'conditions' => array(),
            'dependent' => true,
        )
    );
    var $hasMany = array(
        'Link' => array(
            'className' => 'Link',
            'foreignKey' => 'model_id',
            'conditions' => array('Link.model' => 'Project'),
            'dependent' => true
        ),
        'Follow' => array(
            'className' => 'Follow',
            'foreignKey' => 'model_id',
            'conditions' => array('Follow.model' => 'Project'),
            'dependent' => true
        ),
        'Sponsorship' => array(
            'className' => 'Sponsorship',
            'foreignKey' => 'project_id',
            'conditions' => array('Sponsorship.status' => PAYPAL_STATUS_COMPLETED),
            'dependent' => true
        ),
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'model_id',
            'conditions' => array('Post.model' => 'Project'),
            'dependent' => true,
        ),
        'Attachment' => array(
            'className' => 'Media.Attachment',
            'foreignKey' => 'foreign_key',
            'conditions' => array('Attachment.model' => 'Project'),
            'dependent' => true,
        ),
        'Prize' => array(
            'className' => 'Prize',
            'foreignKey' => 'model_id',
            'conditions' => array('Prize.model' => 'Project'),
            'dependent' => true,
            'order' => 'Prize.value ASC'
        )
    );
    var $validate = array(
        'title' => array(
            'default' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false
            ),
            'BETWEEN_3_50_CHARS' => array(
                'rule' => array('between', 3, 50),
                'required' => true,
                'allowEmpty' => false
            ),
            'PROJECT_MUST_BE_UNIQUE' => array(
                'rule' => 'isUnique',
                'required' => true,
                'allowEmpty'=>false,
            )
        )
        , 'category_id' => array(
            'default' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false
            )
        )
        , 'short_description' => array(
            'CAMPO_VACIO' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => 'false'
            ),
            'BETWEEN_50_140_CHARS' => array(
                'rule' => array('between', 50, 140),
                'required' => true,
                'allowEmpty' => false
            ),
        )
        , 'description' => array(
            'CAMPO_VACIO' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => 'false'
            ),
            'minLength_140' => array(
                'rule' => array('minLength', 140),
                'required' => true,
                'on' => 'update'
            )
        )
        , 'reason' => array(
                'default' => array(
                    'rule' => array('notEmpty'),
                    'required' => true,
                    'allowEmpty' => true,
                    'on' => 'update'
                ),
            'minLength_140' => array(
                'rule' => array('minLength', 140),
                'required' => true,
                'on' => 'update'
            )
        )
        , 'funding_goal' => array(
            'integer_value' => array(
                'rule' => array('custom', '/[0-9]+/'),
                'required' => true,
                'allowEmpty' => false
            ),
            'greater_than_0' => array(
                'rule' => array('comparison', 'isgreater', 0),
                'required' => true,
                'allowEmpty' => false
            ),
            'MUST_BE_IN_RAGE' => array(
                'rule' => array('crange', 10, 99000000),
                'required' => true,
                'allowEmpty' => false
                /*'message' => 'Debe escoger un valor entre 10 y 99000000'*/
            )


        ,
            'NUMERIC' => array(
                'rule' => array('numeric'),
                'required' => true,
                'allowEmpty' => false
            )
        )
        , 'project_duration' => array(
            'MUST_BE_IN_RAGE' => array(
                'rule' => array('crange', PROJECT_MIN_DURATION, PROJECT_MAX_DURATION),
                'required' => true,
                'allowEmpty' => false
            )
        ),
        'country' => array(
            'CAMPO_VACIO' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => 'false'
            )
        )

        /*'file' => array(
            'default' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false
            /*'valid_upload' => array(
                'rule' => array('validateUploadedFile', true),
                'message' => 'YOU_MUST_UPLOAD_AN_IMAGE',
                'required' => true,
                'allowEmpty' => false*/
           // ),
            /*'resource' => array('rule' => 'checkResource'),
            //'access' => array('rule' => 'checkAccess'),
            //'location' => array('rule' => array('checkLocation', array(MEDIA_TRANSFER, '/tmp/'))),
            //'permission' => array('rule' => array('checkPermission', '*')),
            'size' => array('rule' => array('checkSize', '10M')),
            //  'pixels' => array('rule' => array('checkPixels', '1600x1600')),
            'extension' => array('rule' => array('checkExtension', false, array('jpg', 'jpeg', 'png', 'gif', 'tmp'))),
            'mimeType' => array('rule' => array('checkMimeType', false, array('image/jpeg', 'image/png', 'image/gif', 'image/jpg')))*/
       // )*/
        , 'video_url' => array(
            'VideoUrl' => array(
                'rule' => array('VideoUrl', false),
                'required' => true,
                'allowEmpty' => true,
                'on' => 'update'
            )
        )

            /* ,
              'integer_value' => array(
              'rule' => array('custom', '/[0-9]+/'),
              'required' => true,
              'allowEmpty' => false
              ) */
    );

    static function isFinished($data=False) {
        return (Project::isPublic($data) && ($data['Project']['time_left'] <= 0));
    }

    static function isFunded($data=False) {
        return ( Project::getCollectedValue($data) >= $data['Project']['funding_goal'] );
    }


    static function isPaid($data=False) {
        //

        return ( Project::getCollectedValue($data) >= $data['Project']['funding_goal'] && $data['Project']['funded'] == 1 );
    }



    static function isAboutToFinish($data=False) {
        return (Project::isPublic($data) && ($data['Project']['time_left'] <= DAYS_TO_BE_FINISHING && $data['Project']['time_left'] > 0 ));
    }

    static function isPublished($data=False) {
        if (is_bool($data)) {
            return array(
                'Project.public' => IS_PUBLIC
            );
        } elseif (is_array($data)) {
            return( $data['Project']['public'] == IS_PUBLIC );
        }
        return false;
    }

    static function isPublic($data=False) {
        if (is_bool($data)) {
            return array(
                'Project.enabled' => IS_ENABLED,
                'Project.public' => IS_PUBLIC,
                'User.active' => IS_ENABLED,
                'User.confirmed' => IS_ENABLED,
            );
        } elseif (is_array($data)) {
            return( $data['Project']['enabled'] == IS_ENABLED && $data['Project']['public'] == IS_PUBLIC );
        }
        return false;
    }

    static function isImportant($data=False) {
        if (is_bool($data)) {
            return array(
                'Project.important' => IS_IMPORTANT
            );
        } elseif (is_array($data)) {
            return( $data['Project']['important'] == IS_IMPORTANT );
        }
        return false;
    }

    static function isEnabled($data=False) {
        if (is_bool($data)) {
            return array(
                'Project.enabled' => IS_ENABLED,
            );
        } elseif (is_array($data)) {
            return( $data['Project']['enabled'] == IS_ENABLED );
        }
        return false;
    }

    static function isOwnProject($data) {
        $authUser = isset($_SESSION['Auth']['User']) ? $_SESSION['Auth']['User'] : false;
        if ($authUser) {
            if (!isset($data['User'])) { // getUserData
                App::import('model', 'User');
                $user = new User();
                $user = $user->getUser($data['Project']['user_id']);
            } else {
                $user = $data;
            }
            if ($user['User']['id'] == $authUser['id']) {
                return true;
            }
        }
        return false;
    }

    static function belongsToOffer($data=null) {
        return( $data['Project']['offer_id'] > 0);
    }

    static function getLink($data=null, $extra = array(), $full=false, $model=null) {

        if (!isset($data['User'])) { // getUserData
            App::import('model', 'User');
            $user = new User();
            $user = $user->getUser($data['Project']['user_id']);
        } else {
            $user = $data;
        }


        if (is_string($extra) || (is_array($extra) && isset($extra['extra']) )) {
            $params = (is_array($extra) && isset($extra['extra']) ) ? $extra : array();
            $extra = (is_array($extra) && isset($extra['extra']) ) ? $extra['extra'] : $extra;
            if (isset($params['extra'])) {
                unset($params['extra']);
            }

            $params['admin'] = false;

            $params['user'] = User::getSlug($user);
            switch (low($extra)) {
                case 'unfollow' :
                    $extra = array('controller' => 'follows', 'action' => 'delete', 'model' => 'projects', 'project' => $data['Project']['id']);
                    $params['user'] = null; // unsets parent user
                    break;
                case 'follow' :
                    $extra = array('controller' => 'follows', 'action' => 'add', 'model' => 'projects', 'project' => $data['Project']['id']);
                    $params['user'] = null; // unsets parent user
                    break;
                case 'sponsorships' :
                    $extra = array('controller' => 'sponsorships', 'action' => 'index', 'model' => 'projects');
                    break;
                case 'comments' :
                    $extra = array('controller' => 'comments', 'action' => 'index', 'model' => 'projects');
                    break;
                case 'updates' :
                    $extra = array('controller' => 'posts', 'action' => 'index', 'model' => 'projects');
                    break;

                case 'create-update' :
                    $extra = array('controller' => 'posts', 'action' => 'add', 'type' => 'project', 'model_id' => $data['Project']['id']);
                    $params['user'] = null; // unsets parent user
                    $params['project'] = null; // unsets parent user
                    break;
                case 'back' :
                    $extra = array('controller' => 'sponsorships', 'action' => 'add', 'model' => 'projects');
                    break;
                case 'edit' :
                    $extra = array('controller' => 'projects', 'action' => 'edit', 'id' => $data['Project']['id'], 'publish' => false);
                    $params['user'] = null; // unsets parent user
                    $params['project'] = null; // unsets parent user
                    break;
                case 'delete' :
                    $extra = array('controller' => 'projects', 'action' => 'delete', $data['Project']['id']);
                    $params['user'] = null; // unsets parent user
                    $params['project'] = null; // unsets parent user
                    break;
                case 'publish' :
                    $extra = array('controller' => 'projects', 'action' => 'edit', 'id' => $data['Project']['id'], 'publish' => true);
                    $params['user'] = null; // unsets parent user
                    $params['project'] = null; // unsets parent user
                    break;
                case 'publish_2' :
                    $extra = array('controller' => 'projects', 'action' => 'edit', 'id' => $data['Project']['id'], 'publish' => true, 'getData' => true);
                    $params['user'] = null; // unsets parent user
                    $params['project'] = null; // unsets parent user
                    break;
                default :
                    $extra = array();
            }

            $extra = am($extra, $params);
        } else {
            $extra['user'] = User::getSlug($user);
            $extra['admin'] = isset($extra['admin']) ? $extra['admin'] : false;
        }


        return parent::getLink($data, $extra, $full, 'Project');
    }

    function getSponsorshipUsers($data) {
        //   return Set::extract('/Sponsorship/User',$data);
    }

    function queryStandarSet($all=true, $profile=false) {


        $query['contain'] = array(
            'User',
            'Category',
            'Offer',
            'Sponsorship',
            'Post',
        );

        if (!$profile) {
            $query['contain'][] = 'User.Link';
            $query['contain'][] = 'User.City';
            $query['contain'][] = 'Prize';
            $query['contain'][] = 'Category';
            $query['contain'][] = 'Follow';
            $query['contain'][] = 'Follow';
        }

        if (is_bool($all) && $all === false) {
            $query['conditions'] = $this->isPublic();
        }

        return $query;
    }

    function getViewData($id=false, $cache=true) {
        $query = $this->queryStandarSet();
        if (is_bool($id)) {

            return $query;

        } else {
//echo '<pre>';
//var_dump(ctype_digit($id));
if (ctype_digit($id)){
            $query['conditions']['or'] = array(

                $this->alias . '.id' => $id,


            );}else{

                $query['conditions']['or'] = array(
                $this->alias . '.slug' => $id,


            );}



            return parent::getViewData($this->alias, $query, $cache);
        }
    }

    function getFundedValue($data, $max=0) {
        $funding_goal = (float) $data['Project']['funding_goal'];
        $FundedValue = 0;

        if ($funding_goal > 0) {
            $FundedValue = ceil(Project::getCollectedValue($data) * 100 / $funding_goal);
        }

        return $max > 0 && $FundedValue > $max ? $max : $FundedValue;
    }

    function getCollectedValue($data) { // sum of all sponsorships prices values..
        return (float) array_sum(Set::extract('/Sponsorship/contribution', $data));
    }
	
	function getMoneda($data){
		return $data['Project']['moneda'];
	}
    function getMoneda1($data){
        $moneda=$data['Project']['moneda'];
        if($moneda=='ARS'){$moneda_proyecto ='$';}elseif($moneda=='GBP'){$moneda_proyecto ='£';}elseif($moneda=='EUR'){$moneda_proyecto ='€';}else{$moneda_proyecto ='$';}

        return $moneda_proyecto;
    }


    function beforeSave($options = array()) {


        if ($this->exists() && isset($this->data['Link'])) { // If we are editing and we have new links. delete all before saving.
            $this->Link->deleteAll(
                    array('Link.model' => $this->name,
                'Link.model_id' => $this->data[$this->alias]['id']
                    )
                    , false
                    , false
            );
        }

        if ($this->exists() && isset($this->data['Prize'])) { // If we are editing and we have new Prizes. delete all before saving.
            $this->Prize->deleteAll(
                    array('Prize.model' => $this->name,
                'Prize.model_id' => $this->data[$this->alias]['id']
                    )
                    , false
                    , false
            );
        }

        return parent::beforeSave($options);
    }

    function bindToCity($project, $city_id=false) {
        if (!$city_id) {
            $city_id = array_shift(Set::extract('/User/city_id', $this->User->getUser($project['Project']['user_id'], array('contain' => array(), 'fields' => array('User.city_id')))));
            if ($city_id) {
                $this->bindToCity($project, $city_id);
            }
        } else {
            $city = $this->City->read(null, $city_id);
            if ($city) {
                $project['Project']['city_id'] = $city['City']['id'];
                $project['Project']['city'] = $city['City']['city_name'];
                $project['Project']['country'] = $city['City']['country'];
                $project['Project']['country_id'] = $city['City']['country_code'];
                return $this->save($project);
            }
        }
        return false;
    }

    function getHighlight($find = true, $limit = 6) {
        $query = $this->queryStandarSet(false);
		$query['conditions']['Project.outstanding'] = 1;
        $query['conditions']['Project.idioma'] = $_SESSION['idioma'];
        $query['limit'] = $limit;
        $query['order'] = 'rand()';
        return $find ? $this->find('all', $query) : $query;
    }

    function getLeading($find = true, $limit = 1) {
        $query = $this->queryStandarSet(false);
        $query['conditions']['Project.leading'] = 1;
        $query['conditions']['Project.idioma'] = $_SESSION['idioma'];
        $query['limit'] = ( $limit == 1 ? 1000 : $limit );
        $query['order'] = 'rand()';
        return $find ? $this->find(($limit == 1 ? 'first' : 'all'), $query) : $query;
    }
	
	/**
	* Entrega los destacados de la semana
	*
	* @return array con datos de la tabla projects si $find es true, o los datos de consulta en cao contrario
	* @param Boolean $find a true provoca retorno de datos de consulta; a false retorna los datos de la consulta
	* @param Int $limit cantidad de registros que retornar� la consulta
	* 
	*/
	function getWeek($find = true, $limit = 8) {
      	$query = $this->queryStandarSet(false);
       	$query['conditions']['Project.leading'] = 1;
        $query['conditions']['Project.idioma'] = $_SESSION['idioma'];
        $query['limit'] = ( $limit == 1 ? 1000 : $limit );
        $query['order'] = 'Project.id';
        $uno= $find ? $this->find(($limit == 1 ? 'first' : 'all'), $query) : $query;
		$query = $this->queryStandarSet(false);
       	$query['conditions']['Project.week'] = 1;
        $query['conditions']['Project.idioma'] = $_SESSION['idioma'];
        $query['limit'] = ( $limit == 1 ? 1000 : $limit );
        $query['order'] = 'Project.id';
        $dos= $find ? $this->find(($limit == 1 ? 'first' : 'all'), $query) : $query;
		$ret=am($uno,$dos);
		$ret2=array();
		for($i=0;$i<count($ret);$i++){
			if(in_array($ret[$i],$ret2)){
				continue;	
			}
			$ret2[]=$ret[$i];
			if(count($ret2)>($limit-1)){
				break;	
			}
		}
		return $ret2;
		
    }

    function commonValidation($data) {
        // unset un-used validation rules
        unset($this->validate['title']);
        unset($this->validate['category_id']);
       // unset($this->validate['short_description']);

        if ($data['Project']['basename'] != '') {
       /*     unset($this->validate['file']['valid_upload']);*/
        }
    }

    function editValidation($data) {
        $this->commonValidation($data);
        // all fields are optional.
        foreach ($this->validate as $field => $rules) {

            foreach ($rules as $ruleName => $rule) {
                if (( is_array($rule['rule']) && low($rule['rule'][0]) == 'notempty' ) || is_string($rule['rule']) && low($rule['rule']) == 'notempty') {
                    unset($this->validate[$field][$ruleName]);
                } else {
                    $this->validate[$field][$ruleName]['allowEmpty'] = true; // The value can be null
                }
            }
        }

        $data['Project']['public'] = IS_NOT_PUBLIC;
        $data['Project']['status'] = PROJECT_STATUS_APROVED;

        return ( $this->saveAll($data, array('validate' => 'only')) ? $data : false );
    }
    function editValidation2($data) {

        $this->commonValidation($data);
        // all fields are optional.
        foreach ($this->validate as $field => $rules) {

            foreach ($rules as $ruleName => $rule) {
                if (( is_array($rule['rule']) && low($rule['rule'][0]) == 'notempty' ) || is_string($rule['rule']) && low($rule['rule']) == 'notempty') {
                    unset($this->validate[$field][$ruleName]);
                } else {
                    $this->validate[$field][$ruleName]['allowEmpty'] = true; // The value can be null
                }
            }
        }

        //$data['Project']['public'] = IS_NOT_PUBLIC;
        //$data['Project']['status'] = PROJECT_STATUS_APROVED;

        return ( $this->saveAll($data, array('validate' => 'only')) ? $data : false );
    }

    function publishValidation($data) {

        $this->commonValidation($data);
		

        //Set project publish information
        $data['Project']['public'] = IS_PUBLIC;
        $data['Project']['status'] = PROJECT_STATUS_PUBLISHED;
        $data['Project']['puplish_date'] = date('Y-m-d');
        $data['Project']['end_date'] = date('Y-m-d', strtotime("+{$data['Project']['project_duration']} days"));

		

        if ($this->saveAll($data, array('validate' => 'only')) && $this->Prize->hasPrize($data)) {
            // Unset not modificable data
            unset($data['Project']['title']);
            unset($data['Project']['category_id']);
            unset($data['Project']['short_description']);

            return $data;
        } else {

            $this->invalidate('prize', __('AT_LEAST_ONE_PRIZE', true));
            return false;
        }




    }
	/**
	* Entrega las categor�as para filtrar proyectos
	*
	* @return array con datos para generaci�n de los enlaces
	* @param String $cual define los datos del men� a obtener
	* 
	*/
	public static function getCategories($cual){
		switch($cual){
			case 'categorias':
			$pp=new Category;
			$datos=$pp->query("select * from categories where project_count>0 group by slug");
			return $datos;
			break;
			case 'mostrar':
			$statuses = array (
				'most-popular' => __ ('MOST_POPULAR', true),
				'most-recent' => __ ('MOST_RECENT', true),
				'by-end' => __ ('BY_END', true),
				'finished' => __ ('FINISHED', true),
        	);
			return $statuses;
			break;
			case 'ubicacion':
			$pp=new City;
			$datos=$pp->query("select * from cities where project_count>0 group by city_slug");
			return $datos;
			break;
		}
	}
	public static function verifyPrivacityStatus($projectId,$u){
		$p=new Project;
		$data = $p->getViewData($projectId);
		
		$s=new CakeSession();
		$owner=($s->read('Auth.User.id') == $data['Project']['user_id']);
		if($data['Project']['private'] && $s->check('privateViewId')!=$projectId && !$owner){
			$s->write('privateURL',$u);
			$s->write('privateId',$projectId);
			$s->write('privateTitle',$data['Project']['title']);
			$s->write('privateAutor',$data['User']['display_name']);
			$s->write('promptPrivate',1);
			echo '<script>if(document.referrer.indexOf("search")!=-1 || document.referrer.indexOf("discover")!=-1)location=document.referrer;else location="/";</script>';
			exit;
		}
		
		
	}
	public static function verifyPrivacityPass($pass){
		$s=new CakeSession();
		$p=new Project;
		$data = $p->getViewData( $s->read('privateId'));
		if($data['Project']['private_pass']==$pass){
			$s->write('privateViewId',$data['Project']['id']);
			return true;
		}
		return false;
	}
	
	
	
	public static function getPrivacityStatus($projectId){
		$p=new Project;
		$data = $p->getViewData($projectId);
		return $data['Project']['private'];
	}



}

?>
