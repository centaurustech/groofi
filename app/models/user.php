<?php
/**
 * @property Link $Links
 * @property Attachment $Attachment
 * @property Notification $Notification
 * @property Notificationtype $Notificationtype
 * @property Report $Report
 */
App::import('lib', 'Sanitize');

class User extends AppModel {

    var $name = "User";
    var $useTable = "users";
    var $primaryKey = 'id';
    var $conditions;
    var $order;
    var $limit;
    var $actsAs = array(
        'Media.Transfer',
        'Media.Coupler',
        'Media.Generator',
        'Media.Meta',
        'Enableable',
        'Sluggable' => array(
            'label' => 'title',
            'slug' => 'slug',
            'overwrite' => true
        )
    );

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->virtualFields['avatar_file'] = sprintf("CONCAT_WS('%s', %s.dirname, %s.basename)", addslashes(DS), $this->alias, $this->alias);
    }

    var $hasMany = array(
        'Report' => array(
            'className' => 'Report',
            'foreignKey' => 'model_id',
            'conditions' => array('Report.model' => 'User'),
            'dependent' => true
        ),
        'Link' => array(
            'className' => 'Link',
            'foreignKey' => 'model_id',
            'conditions' => array('Link.model' => 'User'),
            'dependent' => true
        ),
        'Sponsorship' => array(
            'className' => 'Sponsorship',
            'foreignKey' => 'user_id',
            'dependent' => true
        ),
        'Follow' => array(
            'className' => 'Follow',
            'foreignKey' => 'user_id',
            'dependent' => true
        ),
        'Attachment' => array(
            'className' => 'Media.Attachment',
            'foreignKey' => 'foreign_key',
            'conditions' => array('Attachment.model' => 'User'),
            'dependent' => true,
        ),
        'Notification' => array(
            'className' => 'Notification',
            'foreignKey' => 'user_id',
            'dependent' => true
        ),
        'Project' => array(
            'className' => 'Project',
            'foreignKey' => 'user_id',
            'dependent' => true
        ),
        'Offer' => array(
            'className' => 'Offer',
            'foreignKey' => 'user_id',
            'dependent' => true
        ),
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'user_id',
            'dependent' => true
        )
    );
    var $belongsTo = array(
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'counterCache' => 'user_count',
            'counterScope' => array('User.enabled >' => 0), // projects aproved
            'conditions' => array(),
            'dependent' => true,
        )
    );
    var $hasAndBelongsToMany = array(
        'Notificationtype' =>
        array(
            'className' => 'Notificationtype',
            'joinTable' => 'notificationtype_users',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'notificationtype_id',
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
    var $validate = array(
        'display_name' => array(
            'CAMPO_VACIO' => array(
                'rule' => array('notEmpty', true),
                'required' => true,
                'allowEmpty' => false

            ),
            'maxLength_50' => array(
                'rule' => array('maxLength', 50),
                'required' => true,
                'allowEmpty' => false

            ),
            'MIN_LENGHT_3_ERROR' => array(
                'rule' => array('minLength', 3),
                'required' => true,
                'allowEmpty' => false

				
            )
        ),
        'email' => array(
            "EMAIL_GENERIC_ERROR" => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false

            ),
            "EMAIL_GENERIC_ERROR" => array(
                'rule' => array('email'),
                'required' => true,
                'allowEmpty' => false
				),
            'MAIL_MUST_BE_UNIQUE' => array(
                'rule' => 'isUnique',
                'required' => true,
                'allowEmpty' => false
				)
        ),
        'password' => array(


            //    'password' => array('rule' => array('custom', CUSTOM_ALPHANUM), 'required' => false, 'allowEmpty' => false, 'last' => false),
            'match' => array(
                'rule' => array('compare_passwords','password', 'password_confirmation'),
                'required' => true,
                'allowEmpty' => false,
                ),
            'CAMPO_VACIO' => array(
                'rule' => array('password_empty','password'),
                'required' => false,
                'allowEmpty' => false),




        ),
        'password_confirmation' => array(
            //  'password' => array('rule' => array('custom', CUSTOM_ALPHANUM), 'required' => false, 'allowEmpty' => false, 'last' => false),
            'THIS_FIELD_CANNOT_BE_LEFT_BLANK' => array('rule' => array('maxLength', 25), 'required' => false, 'allowEmpty' => false)
        ),
        'biography' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty', true),
                'required' => false,
                'allowEmpty' => true,
                'on' => 'update'
            )
        ),
        'slug' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'required' => false,
                'allowEmpty' => true,
                'on' => 'update'
            ),
            'minLength_3' => array('rule' => array('minLength', 3), 'required' => false, 'allowEmpty' => false, 'on' => 'update'),
            'slug' => array('rule' => array('custom', CUSTOM_SLUG), 'required' => false, 'allowEmpty' => false, 'on' => 'update', 'last' => false),
            'forbiden' => array('rule' => array('forbidenWords', 'slug'), 'required' => false, 'allowEmpty' => false, 'on' => 'update', 'last' => false)
        ),
            /* 'file' => array(
              'resource' => array('rule' => 'checkResource'),
              'access' => array('rule' => 'checkAccess'),
              'location' => array('rule' => array('checkLocation', array(
              MEDIA_TRANSFER, '/tmp/'
              )
              )
              ),
              'permission' => array('rule' => array('checkPermission', '*')),
              'size' => array('rule' => array('checkSize', '5M')),
              'pixels' => array('rule' => array('checkPixels', '1600x1600')),
              'extension' => array('rule' => array('checkExtension', false, array(
              'jpg', 'jpeg', 'png', 'gif', 'tmp'
              )
              )
              ),
              'mimeType' => array('rule' => array('checkMimeType', false, array(
              'image/jpeg', 'image/png', 'image/gif', 'image/jpg'
              )
              )
              )
              ) */
    );

    static function getName($data= null) {
        return $data['User']['display_name']; //. "({$data['User']['id']})";
    }

    function getLocation($data, $model) {
        return '';
    }

    function _getSearchOptions() {
        return array(
            'contain' => array('Link', 'City', 'Report', 'Project', 'Project.Sponsorship'),
            'conditions' => array(
                'User.enabled' => 1,
                'User.active' => 1,
                'User.confirmed' => 1,
                'User.level' => 0
            ),
        );
    }

    static function getAuthUser($field=false) {
        if (!$field) {
            return (isset($_SESSION['Auth']['User']) ? $_SESSION['Auth']['User'] : false);
        } else {
            return (isset($_SESSION['Auth']['User'][$field]) ? $_SESSION['Auth']['User'][$field] : false);
        }
    }

    function getUser($user=false, $getSearchOptions=true) {

        if (is_bool($getSearchOptions)) {
            $options = $this->_getSearchOptions();
        } elseif (is_array($getSearchOptions)) {
            $options = $getSearchOptions;
        } else {
            $options = array();
        }


        if (is_bool($user)) {

            $user = isset($_SESSION['Auth']['User']['id']) ? $_SESSION['Auth']['User']['id'] : false;
            if ($user) {
                return $this->getUser($user);
            }
        } elseif (is_numeric($user)) {
            $options['conditions']['User.id'] = $user;
        } elseif (is_array($user)) {
            $options += $user;
        } elseif (is_string($user)) {
            $options['conditions']['User.slug'] = $user;
        }


        $optKey = "User-" . hash('sha256', serialize($options));
        if (isset($options) && Cache::read($optKey) === false) {
            $user = $this->find('first', $options);
            Cache::write($user, $optKey);
        } else {
            $user = Cache::read($optKey);
        }

        return $user;
    }

    function getHighlight() {
        return $this->find('all', array('contain' => array(), 'limit' => 15, 'conditions' => array('User.active' => 1, 'User.confirmed' => 1, 'User.score >' => 0 , 'User.level' => 0 ), 'order' => 'rand()'));
    }

    function getNewest() {
        return $this->find('all', array('contain' => array(), 'limit' => 30, 'conditions' => array('User.active' => 1, 'User.confirmed' => 1 , 'User.level' => 0 ), 'order' => array('User.created', 'rand()')));
    }

    function afterFind($results, $primary = false) {
        if (Set::numeric(array_keys($results))) {
            foreach ($results as $key => $result) {
                if (isset($results[$key][$this->alias]['biography'])) {
                    $results[$key][$this->alias]['plain_biography'] = Sanitize::html($results[$key][$this->alias]['biography'], array('remove' => true));
                }

                if (isset($results[$key][$this->alias]['avatar_file']) && $results[$key][$this->alias]['avatar_file'] == '/') {
                    $results[$key][$this->alias]['avatar_file'] = false;
                }
            }
        } elseif (isset($results[$this->alias])) {
            if (isset($results[$this->alias]['biography'])) {
                $results[$this->alias]['plain_biography'] = Sanitize::html($results[$this->alias]['biography'], array('remove' => true));
            }
            if (isset($results[$this->alias]['avatar_file']) && $results[$this->alias]['avatar_file'] == '/') {
                $results[$this->alias]['avatar_file'] = false;
            }
        }
        return parent::afterFind($results, $primary);
    }

    static function isOwner($user) {
        $authUser = isset($_SESSION['Auth']['User']) ? $_SESSION['Auth']['User'] : false;
        if ($authUser) {
            if (isset($user['User']) && $user['User']['id'] == $authUser['id']) {
                return true;
            }
        }
        return false;
    }

    function beforeSave($options = array()) {

        if (isset($this->data['User']['username']) && !empty($this->data['User']['username'])) { // slug username.
            $this->data['User']['slug'] = Inflector::slug($this->data['User']['username']);
        }

        if ($this->exists()) {
            $this->Link->deleteAll(array('Link.model' => $this->name, 'Link.model_id' => $this->data[$this->alias]['id']), false, false); // deletes all user links if exists
        }
        if(!empty($this->data['User']['password']) && !empty($this->data['User']['password_confirmation'] )) {

            $this->data['User']['password_confirmation'] = Security::hash($this->data['User']['password_confirmation'],null,true);

        }
        return true;

        return parent::beforeSave($options);
    }

    function fillFbInfo(&$FacebookConnect = null, $data = null, $getImage =true) {
        if (!$FacebookConnect) {
            trigger_error('we need facebook Connect to work');
            return false;
        } elseif ($FacebookConnect->user()) {
            $oldData = $data;
            $data['User']['facebook_id'] = $FacebookConnect->user('id');
            $data['User']['display_name'] = $FacebookConnect->user('name');
            $data['User']['email'] = $FacebookConnect->user('email'); // can't be changed only updated.
            //$data['User']['username']=$FacebookConnect->user('username');

            $data['User']['fb_username'] = $FacebookConnect->user('username');

            $data['User']['slug'] = $FacebookConnect->user('username');

            $location = $FacebookConnect->user('location');
            $location = $location['location']['name'];
            $location = $this->City->find('first', array('conditions' => array(
                            'city_name' => $location
                            )));
            if ($location) {
                $data['User']['city'] = $location["City"]["city_name"];
                $data['User']['city_id'] = $location["City"]["id"];
            }
            $data['User']['birthday'] = date('Y-m-d', strtotime($FacebookConnect->user('birthday')));
            $data['User']['timezone'] = (String) $FacebookConnect->user('timezone');
            $data['User']['gender'] = $FacebookConnect->user('gender');

            if (isset($oldData['Link']) && is_array($oldData['Link'])) {

                if (count($oldData['Link']) < 10) {
                    $links[] = $FacebookConnect->user('link');
                    $links[] = (strstr($FacebookConnect->user('website'), '://') ? '' : 'http://' ) . $FacebookConnect->user('website');
                }

                foreach ($oldData['Link'] as $key => $link) {
                    $links[] = $link['link'];
                    unset($oldData['Link'][$key]);
                }

                $data['Link'] = array_map(create_function('$link', ' return  array( \'link\' => $link );'), array_unique($links));
            }

            // $getImage = false ;

            if ($data['User']['basename'] == '' && $getImage) { // the user has not image and is Fb connected.
                $image = $this->setFbPhoto($FacebookConnect, $data, false);

                //  vd($image['User']);
                //MEDIA_TRANSFER . 'tmp/' . $FacebookConnect->user('id') . '_fb_avatar'
                if ($image) {
                    unset($oldData['User']['avatar_file']);
                    $data['User']['basename'] = $image['User']['basename'];
                    $data['User']['dirname'] = $image['User']['dirname'];
                    $data['User']['avatar_file'] = $image['User']['dirname'] . DS . $image['User']['basename'];
                }
            }
            $data = fillData($oldData, $data);
        }
        return $data;
    }

    function setLocation(&$data) {
        $city = $this->City->read(null, $data['User']['city_id']);
        if ($city) {
            $data['User']['city_id'] = $city['City']['id'];
            $data['User']['city'] = $city['City']['city_name'];
            $data['User']['country'] = $city['City']['country'];
            $data['User']['country_id'] = $city['City']['country_code'];
        } else {
            $data['User']['city_id'] = null;
            $data['User']['city'] = null;
            $data['User']['country'] = null;
            $data['User']['country_id'] = null;
        }
        return $data;
    }

    function downloadFbPhoto(&$FacebookConnect = null, $data = null) {
        if (!$FacebookConnect) {
            trigger_error('we need facebook Connect to work');
            return false;
        } elseif ($FacebookConnect->user()) {
            if (is_array($data)) {
                $this->data = $data;
            } elseif (is_numeric($data)) {
                $this->data = $this->read(null, $data);
            }
            $dirname = empty($this->data) ? 'tmp' : 'user' . DS . $this->data['User']['id'] . DS . 'img';
            $baseName = $FacebookConnect->user('id') . '_fb_avatar.png';
            $file = MEDIA_TRANSFER . $dirname . DS . $baseName;
            if (!file_exists($file)) {
                $file = MEDIA_TRANSFER . 'tmp' . DS . $baseName;
                $url = "https://graph.facebook.com/me/picture?type=large&access_token=" . $FacebookConnect->session["access_token"];
                $photo = file_get_contents($url);
                file_put_contents($file, $photo);
                $newFile = $this->Behaviors->Transfer->transfer($this, $file); // tranfer file to correct location
                unlink($file);
                if ($newFile) {
                    $this->Behaviors->Coupler->couple($this, $newFile);             // Couple the file to the user
                    $this->Behaviors->Generator->make($this, $newFile);             // generate thumbs
                    return $this->data;
                }
            }
            return array('User' => array(
                    'basename' => $baseName,
                    'dirname' => $dirname,
                    'file' => $dirname . DS . $baseName
                )
            );
        }
    }

    function compare_passwords($data, $password, $passwordConfirmation) {
        $v1 = AuthComponent::password($this->data[$this->name][$passwordConfirmation]) == $this->data[$this->name][$password];
        $v2 = $this->data[$this->name][$passwordConfirmation] == $this->data[$this->name][$password];
		
		//echo $this->data[$this->name][$passwordConfirmation].' '.$this->data[$this->name][$password];
		//exit;
        return ( $v1 || $v2  ? true : false );
    }
    function password_empty($password) {

        if($password['password'] == 'dd9ddd57e6c26912f488582606e935596d917831'){
            return false;
        }else{
            return true;
        }




    }


    function forbidenWords($data, $field) {
        return!in_array(low($data[$field]), Configure::read('stopwords'));
    }

    function setFbPhoto(&$FacebookConnect = null, $data = null, $save = true) {

        if (!$FacebookConnect) {
            //trigger_error('we need facebook Connect to work');
            return false;
        } elseif ($FacebookConnect->user()) {
            if (is_array($data)) {
                $this->data = $data;
            } elseif (is_numeric($data)) {
                $this->data = $this->read(null, $data);
            }
            if (!empty($this->data)) {
                $file = $this->downloadFbPhoto($FacebookConnect);

                if ($save) {
                    $this->data['User']['basename'] = $file['User']['basename'];
                    $this->data['User']['dirname'] = $file['User']['dirname'];
                    // $save ? $this->save($this->data, false) :
                    return $this->data;
                } else {
                    return $file;
                }
            } else {
                trigger_error('No data found');
            }
        }
        return false;
    }

    static function getLink($data=null, $extra = array(), $full=false, $model= 'User') {


        if (is_string($extra) || (is_array($extra) && isset($extra['extra']) )) {
            $params = (is_array($extra) && isset($extra['extra']) ) ? $extra : array();
            $extra = (is_array($extra) && isset($extra['extra']) ) ? $extra['extra'] : $extra;

            if (isset($params['extra'])) {
                unset($params['extra']);
            }

            $params['admin'] = false;

            switch (low($extra)) {
                case 'login' :
                    $extra = array('controller' => 'users', 'action' => 'login');
                    $extra['user'] = null;
                    break;
                case 'bio' :
                    $extra = array('controller' => 'users', 'action' => 'view', 'bio' => true);
                    $extra['user'] = User::getSlug($data);
                    break;
                case 'activity' :
                    $extra = array('controller' => 'notifications', 'action' => 'listing');
                    $extra['user'] = User::getSlug($data);
                    break;
                case 'projects' :
                    $extra = array('controller' => 'projects', 'action' => 'listing');
                    $extra['user'] = User::getSlug($data);
                    break;
                case 'offers' :
                    $extra = array('controller' => 'offers', 'action' => 'listing');
                    $extra['user'] = User::getSlug($data);
                    break;
                case 'follows' :
                    $extra = array('controller' => 'follows', 'action' => 'listing');
                    $extra['user'] = User::getSlug($data);
                    break;
                case 'bakes' :
                    $extra = array('controller' => 'sponsorships', 'action' => 'listing');
                    $extra['user'] = User::getSlug($data);
                    break;
                case 'settings' :
                    $extra = array('controller' => 'users', 'action' => 'edit', 'tab' => 'profile');
                    $extra['user'] = null; // unsets parent user
                    break;
                case 'account' :
                    $extra = array('controller' => 'users', 'action' => 'edit', 'tab' => 'account');
                    $extra['user'] = null; // unsets parent user
                    break;
                case 'report' :
                    $extra = array('controller' => 'reports', 'action' => 'add', 'model' => 'User');
                    $extra['user'] = User::getSlug($data); // unsets parent user
                    break;
                case 'mail-password-recovery' :
                    $extra = array('controller' => 'users', 'action' => 'recover_password', 'hc' => User::genUserToken($data));
                    $extra['user'] = null; // unsets parent user
                    break;

                case 'mail-confirmation' :
                    $extra = array('controller' => 'users', 'action' => 'confirm', 'hc' => User::genUserToken($data));
                    $extra['user'] = null; // unsets parent user
                    break;
                case 'vote' :
                    $extra = array('controller' => 'votes', 'action' => 'add', 'model' => 'User');
                    $extra['user'] = User::getSlug($data); // unsets parent user
                    break;
                default :
                    $extra = array('controller' => 'users', 'action' => 'view');
            }
            $extra = am($extra, $params);
        } else {

            $extra = array('controller' => 'notifications', 'action' => 'listing', 'admin' => false);
        }
        return parent::getLink($data, $extra, $full, $model);
    }

    /*
      function getUserScore($this->data) {




      }
     */

    function admin_validates($data=null) {

        if ($data) {
            $this->set($data);
        }

        $this->validate = array(
            'email' => array(
                'notEmpty' => array(
                    'rule' => array('notEmpty', true),
                    'required' => true,
                    'allowEmpty' => false,
                    'on' => 'create'
                ),
                'email' => array(
                    'rule' => array('email'),
                    'required' => true,
                    'on' => 'create'
                ),
                'MAIL-MUST-BE-UNIQUE' => array(
                    'rule' => 'isUnique',
                    'required' => true,
                    'on' => 'create'
                )
            ),
            'password' => array(
                //    'password' => array('rule' => array('custom', CUSTOM_ALPHANUM), 'required' => false, 'allowEmpty' => false, 'last' => false),
                'match' => array('rule' => array('compare_passwords', 'password', 'password_confirmation'), 'required' => true, 'allowEmpty' => false, 'last' => true)
            ),
            'password_confirmation' => array(
                //  'password' => array('rule' => array('custom', CUSTOM_ALPHANUM), 'required' => false, 'allowEmpty' => false, 'last' => false),
                'maxlength' => array('rule' => array('maxLength', 25), 'required' => false, 'allowEmpty' => false, 'last' => false)
            )
        );
        return $this->validates();
    }

    function genUserToken($user, $duration=2) {
        $email = (md5($user['User']['email']));
        $date = (md5(date('Ymd', strtotime("+{$duration}days"))));
        $hash = up($email) . '=' . $user['User']['id'] . '/' . up($date) . '=' . base64_encode($duration);
        return str_replace('==', '=', $hash);
    }

    function checkUserToken($user, $date, $fixedDuration=2) { //md5
        list($email, $id) = explode('=', $user);
        list($date, $duration) = explode('=', $date);
        $duration = (int) base64_decode($duration . '==');
        $userEmail = array_shift(Set::extract('/User/email', $this->read('email', $id)));
        $isValid = false;


        if ($fixedDuration == $duration) {
            for ($day = 1; $day <= $duration; $day++) {
                $md5Date = up(md5(date('Ymd', strtotime("+{$day}days"))));
                if ($md5Date == $date) {
                    $isValid = true;
                }
            }
        }



        if ($isValid && up(md5($userEmail)) == $email) {
            $isValid = $id;
        } else {
            $isValid = false;
        }
        return $isValid;
    }
	static function getUsersNotifications($userid){
		 	App::import('model', 'NotificationtypeUser');
			$pp=new NotificationtypeUser;
			$datos=$pp->query("select notificationtype_id from notificationtype_users where user_id=$userid order by id");
			return $datos;
		}
		static function getUserFromId($id) {
			//User
			App::import('model', 'User');
			$pp=new User;
			$datos=$pp->query("select display_name from users where id=$id");
			return $datos;
        

       
    }

}

?>
