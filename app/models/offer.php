<?php

/**
 * @property Link $Links
 * @property User $User
 * @property Post $Post
 * @property User $Parthner
 * @property User $Interested
 */
class Offer extends AppModel {

    //var $actAs=array('Enableable');

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
        )
        , 'category_id' => array(
            'default' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false
            )
        )
        , 'short_description' => array(
            'default' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false
            ),
            'BETWEEN_50_140_CHARS' => array(
                'rule' => array('between', 50, 140),
                'required' => true,
                'allowEmpty' => false
            ),
        )
        , 'description' => array(
            'default' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false
            ),
            'minLength_140' => array(
                'rule' => array('minLength', 140),
                'required' => true,
                'on' => 'update'
            )
        ),
        'offer_sponsorships' => array(
            'integer_value' => array(
                'rule' => array('custom', '/[0-9]+/'),
                'required' => true,
                'allowEmpty' => false
            ),
            'greater_than_0' => array(
                'rule' => array('comparison', 'isgreater', 0),
                'required' => true,
                'allowEmpty' => false
            )
        ),
        'funding_sponsorships_founds' => array(
            'integer_value_10_2000' => array(
                'rule' => array('crange', 10, 2000),
                'required' => true,
                'allowEmpty' => false
            )
        ),
        'file' => array(
            'valid_upload' => array(
                'rule' => array('validateUploadedFile', true),
                'message' => 'YOU_MUST_UPLOAD_AN_IMAGE',
                'required' => true,
                'allowEmpty' => false,
                'on' => 'update'
            ),
            'resource' => array('rule' => 'checkResource'),
            //'access' => array('rule' => 'checkAccess'),
            //'location' => array('rule' => array('checkLocation', array(MEDIA_TRANSFER, '/tmp/'))),
            //'permission' => array('rule' => array('checkPermission', '*')),
            'size' => array('rule' => array('checkSize', '10M')),
            //  'pixels' => array('rule' => array('checkPixels', '1600x1600')),
            'extension' => array('rule' => array('checkExtension', false, array('jpg', 'jpeg', 'png', 'gif', 'tmp'))),
            'mimeType' => array('rule' => array('checkMimeType', false, array('image/jpeg', 'image/png', 'image/gif', 'image/jpg')))
        )
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
    var $actsAs = array(/**/
        'Media.Transfer',
        'Media.Generator',
        'Media.Meta',
        'Media.Coupler',
        'Enableable',
        'Containable',
        'Sluggable' => array(
            'label' => 'title',
            'slug' => 'slug',
            'overwrite' => true
        )
    );
    var $hasOne = array();
    var $virtualFields = array(
        'image_file' => "CONCAT_WS('/', Offer.dirname, Offer.basename)",
        'time_left' => " DATEDIFF(Offer.end_date, NOW())",
        'elapsed_time' => " DATEDIFF( NOW() , Offer.publish_date)",
        'total_time' => " DATEDIFF( Offer.end_date , Offer.publish_date)",
    );
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'counterCache' => true,
            'counterScope' => array('Offer.enabled >' => 0),
            'conditions' => array(),
            'dependent' => true,
        ),
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'counterCache' => 'offer_count',
            'counterScope' => array('Offer.enabled >' => 0), // projects aproved
            'conditions' => array(),
            'dependent' => true,
        ),
        '_User' => array(// used to add another conunterCache
            'className' => 'User',
            'foreignKey' => 'user_id',
            'counterCache' => 'offer_proposal_count',
            'counterScope' => array('Offer.enabled' => 0), // offers proposals
            'conditions' => array(),
            'dependent' => true,
        ),
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id',
            'counterCache' => true,
            'counterScope' => array('Offer.enabled >' => 0),
            'conditions' => array(),
            'dependent' => true,
        )
    );
    var $hasMany = array(
        'Link' => array(
            'className' => 'Link',
            'foreignKey' => 'model_id',
            'conditions' => array('Link.model' => 'Offer'),
            'dependent' => true
        ),
        'Follow' => array(
            'className' => 'Follow',
            'foreignKey' => 'model_id',
            'conditions' => array('Follow.model' => 'Offer'),
            'dependent' => true
        ),
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'model_id',
            'conditions' => array('Post.model' => 'Offer'),
            'dependent' => true,
        ),
        'Project' => array(
            'className' => 'Project',
            'foreignKey' => 'offer_id',
            'conditions' => array( 'Project.enabled' => 1 , 'Project.public' => 1 ),
            'dependent' => true,
        )/* ,'Interested' => array(
              'className' => 'User',
              'foreignKey' => 'user_id',
              'conditions' => array(),
              'dependent' => true,
              ) */
    );

    // follows
    /*
      var $hasAndBelongsToMany=array(
      'Parthner' => array(// usuarios que quieren hacer lo mismo
      'className' => 'User',
      'joinTable' => 'users_offers',
      'foreignKey' => 'offer_id',
      'associationForeignKey' => 'user_id',
      'unique' => true,
      'conditions' => '',
      'fields' => '',
      'order' => '',
      'limit' => '',
      'offset' => '',
      'finderQuery' => '',
      'deleteQuery' => '',
      'insertQuery' => ''
      )
      );
     */


    function queryStandarSet($all=true, $profile=false) {
        $query['contain'] = array(
            'User',
            'Category',
            'Post',
        );

        if (!$profile) {
            $query['contain'][] = 'User.Link';
            $query['contain'][] = 'User.City';
            $query['contain'][] = 'Follow.User';
            $query['contain'][] = 'Project.User';
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
            $query['conditions']['or'] = array(
                $this->alias . '.slug' => $id,
                $this->alias . '.id' => $id,
            );
            return parent::getViewData($this->alias, $query, $cache);
        }
    }

    static function getLink($data=null, $extra = array(), $full=false, $model=null) {

        if (!isset($data['User'])) { // getUserData
            App::import('model', 'User');
            $user = new User();
            $user = $user->getUser($data['Offer']['user_id']);
        } else {
            $user = $data;
        }


        if (is_string($extra) || (is_array($extra) && isset($extra['extra']) )) {
            $params = (is_array($extra) && isset($extra['extra']) ) ? $extra : array();
            $extra = (is_array($extra) && isset($extra['extra']) ) ? $extra['extra'] : $extra;
            if (isset($params['extra'])) {
                unset($params['extra']);
            }
            $params['user'] = User::getSlug($user);
            switch (low($extra)) {

                case 'unfollow' :
                    $extra = array('controller' => 'follows', 'action' => 'delete', 'model' => 'offers', 'offer' => $data['Offer']['id']);
                    $params['user'] = null; // unsets parent user
                    break;
                case 'follow' :
                    $extra = array('controller' => 'follows', 'action' => 'add', 'model' => 'offers', 'offer' => $data['Offer']['id']);
                    $params['user'] = null; // unsets parent user
                    break;
                case 'projects' :
                    $extra = array('controller' => 'projects', 'action' => 'list_offers', 'model' => 'offers');
                    break;
                case 'sponsorships' :
                    $extra = array('controller' => 'sponsorships', 'action' => 'index', 'model' => 'offers');
                    break;
                case 'comments' :
                    $extra = array('controller' => 'comments', 'action' => 'index', 'model' => 'offers');
                    break;
                case 'updates' :
                    $extra = array('controller' => 'posts', 'action' => 'index', 'model' => 'offers');
                    break;
                case 'create-update' :
                    $extra = array('controller' => 'posts', 'action' => 'add', 'type' => 'offer', 'model_id' => $data['Offer']['id']);
                    $params['user'] = null; // unsets parent user
                    $params['offer'] = null; // unsets parent user
                    break;
                case 'back' :
                    $extra = array('controller' => 'sponsorships', 'action' => 'add', 'model' => 'offers');
                    break;
                case 'edit' :
                    $extra = array('controller' => 'offers', 'action' => 'edit', 'id' => $data['Offer']['id'], 'publish' => false);
                    $params['user'] = null; // unsets parent user
                    $params['offer'] = null; // unsets parent user
                    break;
                case 'delete' :
                    $extra = array('controller' => 'offers', 'action' => 'delete', $data['Offer']['id']);
                    $params['user'] = null; // unsets parent user
                    $params['offer'] = null; // unsets parent user
                    break;
                case 'publish' :
                    $extra = array('controller' => 'offers', 'action' => 'edit', 'id' => $data['Offer']['id'], 'publish' => true);
                    $params['user'] = null; // unsets parent user
                    $params['offer'] = null; // unsets parent user
                    break;

                case 'publish_2' :
                    $extra = array('controller' => 'offers', 'action' => 'edit', 'id' => $data['Offer']['id'], 'publish' => true, 'getData' => true);
                    $params['user'] = null; // unsets parent user
                    $params['offer'] = null; // unsets parent user
                    break;
                default :
                    $extra = array();
            }

            $extra = am($extra, $params);
        } else {
            $extra['user'] = User::getSlug($user);
        }


        return parent::getLink($data, $extra, $full, 'Offer');
    }

    static function isFinished($data=False) {
        return (Offer::isPublic($data) && ($data['Offer']['time_left'] <= 0));
    }

    static function isAboutToFinish($data=False) {
        return (Offer::isPublic($data) && ($data['Offer']['time_left'] <= DAYS_TO_BE_FINISHING && $data['Offer']['time_left'] > 0 ));
    }

    static function isPublic($data=False) {
        if (is_bool($data)) {
            return array(
                'Offer.enabled' => IS_ENABLED,
                'Offer.public' => IS_PUBLIC,
                'User.active' => IS_ENABLED,
                'User.confirmed' => IS_ENABLED,
            );
        } elseif (is_array($data)) {
            return( $data['Offer']['enabled'] == IS_ENABLED && $data['Offer']['public'] == IS_PUBLIC );
        }
        return false;
    }

    static function isPublished($data=False) {
        if (is_bool($data)) {
            return array(
                'Offer.public' => IS_PUBLIC
            );
        } elseif (is_array($data)) {
            return( $data['Offer']['public'] == IS_PUBLIC );
        }
        return false;
    }

    static function isOwnOffer($data) {
        $authUser = isset($_SESSION['Auth']['User']) ? $_SESSION['Auth']['User'] : false;
        if ($authUser) {
            if (!isset($data['User'])) { // getUserData
                App::import('model', 'User');
                $user = new User();
                $user = $user->getUser($data['Offer']['user_id']);
            } else {
                $user = $data;
            }
            if ($user['User']['id'] == $authUser['id']) {
                return true;
            }
        }
        return false;
    }

    function bindToCity($offer, $city_id=false) {
        if (!$city_id) {
            $city_id = array_shift(Set::extract('/User/city_id', $this->User->getUser($offer['Offer']['user_id'], array('contain' => array(), 'fields' => array('User.city_id')))));
            if ($city_id) {
                $this->bindToCity($offer, $city_id);
            }
        } else {
            $city = $this->City->read(null, $city_id);
            if ($city) {
                $offer['Offer']['city_id'] = $city['City']['id'];
                $offer['Offer']['city'] = $city['City']['city_name'];
                $offer['Offer']['country'] = $city['City']['country'];
                $offer['Offer']['country_id'] = $city['City']['country_code'];
                return $this->save($offer);
            }
        }
        return false;
    }

    function getHighlight($find = true, $limit = 3) {
        $query = $this->queryStandarSet(false);
        $query['conditions']['Offer.outstanding'] = 1;
        $query['limit'] = $limit;
        $query['order'] = 'rand()';
        return $find ? $this->find('all', $query) : $query;
    }

    function getLeading($find = true, $limit = 1) {
        $query = $this->queryStandarSet(false);
        $query['conditions']['Offer.leading'] = 1;
        $query['limit'] = ( $limit == 1 ? 1000 : $limit );
        $query['order'] = 'rand()';
        return $find ? $this->find(($limit == 1 ? 'first' : 'all'), $query) : $query;
    }

    function commonValidation($data) {
        // unset un-used validation rules
        unset($this->validate['title']);
        unset($this->validate['category_id']);
        unset($this->validate['short_description']);

        if ($data['Offer']['basename'] != '') {
            unset($this->validate['file']['valid_upload']);
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

        $data['Offer']['public'] = IS_NOT_PUBLIC;
        $data['Offer']['status'] = OFFER_STATUS_APROVED;

        return ( $this->saveAll($data, array('validate' => 'only')) ? $data : false );
    }

    function publishValidation($data) {

        $this->commonValidation($data);

        //Set offer publish information
        $data['Offer']['public'] = IS_PUBLIC;
        $data['Offer']['status'] = OFFER_STATUS_PUBLISHED;
        $data['Offer']['publish_date'] = date('Y-m-d');
        $data['Offer']['end_date'] = date('Y-m-d', strtotime("+{$data['Offer']['offer_duration']} days"));



        if ($this->saveAll($data, array('validate' => 'only'))) {
            // Unset not modificable data
            unset($data['Offer']['title']);
            unset($data['Offer']['category_id']);
            unset($data['Offer']['short_description']);

            return $data;
        } else {
            //$this->invalidate('prize', __('AT_LEAST_ONE_PRIZE', true));
            return false;
        }
    }
	public static function aVer($id){
		$offer=new Offer;
		$datos=$offer->query("select id from offers where id='$id'");
		return $datos[0]['offers'];
	}
	

}

?>