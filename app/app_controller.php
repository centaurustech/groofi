<?php
App::import('Lib', 'Facebook.FB');

/**
 * @property AuthComponent $Auth
 * @property SessionComponent $Session
 * @property RequestHandlerComponent $RequestHandler
 * @property ConnectComponent $Connect
 */
class AppController extends Controller {

    var $uses = array('User');
    var $pageError = null;
    public $view = 'App'; //custom app view for overriding core helpers.
    var $helpers = array(
        'Html',
        'Time',
        'Form',
        'Session',
        'Js' => array('Jquery'),
        'Paginator',
        'Modules',
        'Text',
        'Media.Media',
        'Facebook.Facebook',
        'AppForm', //to override load the core helper and then your app helper.
        'AppHtml', //to override load the core helper and then your app helper.
        'AppText', //to override load the core helper and then your app helper.
        'Cksource',
        'Javascript',
        'Cropimage',
        'Paiseslistado',
        'Cropimage'


    );

    /*
      => array(
      'userScope' => array(
      'User.type' => USER_LEVEL_USER
      )
      )
     */
    var $components = array(
        'Auth',
        'Session',
        'Email',
        'Cookie',
        'RequestHandler',
        'DebugKit.Toolbar',
        'Facebook.Connect',
        'JqImgcrop',

    );

    function beforeFilter() {


        $this->Auth->fields = array(
            'username' => 'email',
            'password' => 'password'
        );

        $this->Auth->loginRedirect = array('controller' => 'notifications', 'action' => 'wall'); //
        $this->Auth->autoRedirect = false;

        $this->Auth->userScope = array(
            'User.enabled' => true, // user account must be enabled an not banned(enabled=0)
            'User.admin' => false, // user account must be enabled an not banned(enabled=0)
        );

		
        if (!isset($this->params['prefix'])) {
            $this->loadModel('Category');
            $this->loadModel('Sponsorship');


            $this->timeZones = array(
                "-12.0" => "(GMT -12:00) Eniwetok, Kwajalein",
                "-11.0" => "(GMT -11:00) Midway Island, Samoa",
                "-10.0" => "(GMT -10:00) Hawaii",
                "-9.0" => "(GMT -9:00) Alaska",
                "-8.0" => "(GMT -8:00) Pacific Time (US & Canada)",
                "-7.0" => "(GMT -7:00) Mountain Time (US & Canada)",
                "-6.0" => "(GMT -6:00) Central Time (US & Canada), Mexico City",
                "-5.0" => "(GMT -5:00) Eastern Time (US & Canada), Bogota, Lima",
                "-4.0" => "(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz",
                "-3.5" => "(GMT -3:30) Newfoundland",
                "-3.0" => "(GMT -3:00) Brazil, Buenos Aires, Georgetown",
                "-2.0" => "(GMT -2:00) Mid-Atlantic",
                "-1.0" => "(GMT -1:00 hour) Azores, Cape Verde Islands",
                "0.0" => "(GMT) Western Europe Time, London, Lisbon, Casablanca",
                "1.0" => "(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris",
                "2.0" => "(GMT +2:00) Kaliningrad, South Africa",
                "3.0" => "(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg",
                "3.5" => "(GMT +3:30) Tehran",
                "4.0" => "(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi",
                "4.5" => "(GMT +4:30) Kabul",
                "5.0" => "(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent",
                "5.5" => "(GMT +5:30) Bombay, Calcutta, Madras, New Delhi",
                "5.75" => "(GMT +5:45) Kathmandu",
                "6.0" => "(GMT +6:00) Almaty, Dhaka, Colombo",
                "7.0" => "(GMT +7:00) Bangkok, Hanoi, Jakarta",
                "8.0" => "(GMT +8:00) Beijing, Perth, Singapore, Hong Kong",
                "9.0" => "(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk",
                "9.5" => "(GMT +9:30) Adelaide, Darwin",
                "10.0" => "(GMT +10:00) Eastern Australia, Guam, Vladivostok",
                "11.0" => "(GMT +11:00) Magadan, Solomon Islands, New Caledonia",
                "12.0" => "(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka",
            );

            $this->genders = array(
                'male' => __('GENDER_MALE', true),
                'female' => __('GENDER_FEMALE', true),
            );


            $this->set('timezones', $this->timeZones); //Get all the details on the facebook user
            $this->set('genders', $this->genders); //Get all the details on the facebook user



            if ($this->Connect->user()) {
                $this->set('facebookUser', $this->Connect->user()); //Get all the details on the facebook user
                $this->set('facebook_id', $this->Connect->user('id')); //retrieve only the id from the facebook user
                $this->set('facebook_email', $this->Connect->user('email')); //retrieve only the email from the facebook user
            } else {
                $this->set('facebookUser', null); //Get all the details on the facebook user
                $this->set('facebook_id', null); //retrieve only the id from the facebook user
                $this->set('facebook_email', null); //retrieve only the email from the facebook user
            }

            if ($this->Auth->user()) { // - TODO
                $user = $this->User->read(null, $this->Auth->user('id'));
                $this->Session->write('Auth.User.message_count', $user['User']['message_count']);
            }

            $this->set('site_categories', $this->Category->find('all', array('contain' => false, 'conditions' => array('project_count > ' => 0))));

            //$this->Session->delete('FB');
            //$this->Session->delete('Auth');
        } elseif (isset($this->params['prefix'])) {

            $this->layout = low($this->params['prefix']) . '_' . $this->layout;
            if (low($this->params['prefix']) == 'admin') {
                $this->Auth->sessionKey = 'Admin';
                $this->Auth->userScope = array(
                    'User.enabled' => true,
                    'User.admin' => true,
                    'User.level <>' => USER_LEVEL_USER,
                );
                $this->Auth->fields = array(
                    'username' => 'username',
                    'password' => 'password'
                );
                $this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'index', 'admin' => true); //
                $this->set('adminMenu', $this->_getAdminMenu());
            }
        }
		$this->Auth->login($this->Cookie->read('Auth.User'));
        parent::beforeFilter();
    }

    function afterFilter() {
        preg_match_all('/(<cake:script>(?<=<cake:script>)[\\s\\S]*?(?=<\/cake:script>)<\/cake:script>)/i', $this->output, $outputResult, PREG_PATTERN_ORDER);
        if (isset($outputResult[0])) {
            $scripts = array();
            foreach ($outputResult[0] as $key => $output) {
                $this->output = str_replace($output, '', $this->output);
                $scripts[$key] = str_replace('<cake:script>', '', str_replace('</cake:script>', '', $output));
            }
            $this->output = str_replace('<cake:viewscripts></cake:viewscripts>', implode("\r\n", $scripts), $this->output);
        }
        parent::afterFilter();
    }

    function beforeRender() {
        if (isset($this->pageError) && !empty($this->pageError)) {
            extract($this->pageError, EXTR_OVERWRITE);
            $code = isset($code) ? $code : '404';
            $name = isset($name) ? $name : 'GENERIC_PAGE_ERROR_' . $code;
            $message = isset($message) ? $message : up($name . '_BODY');
            $link = isset($link) ? $link : null;
            $this->pageError = compact('code', 'name', 'message', 'link');
            $this->RequestHandler->cakeError('AppError', $this->pageError);
        }

        parent::beforeRender();
    }

    function _getAdminMenu() {
        $menu = array();
        if ($this->Auth->user()) {

            $menu['logout'] = array(
                0 => array('url' => '/admin/users/edit', 'extra_class' => 'account-icon' ), //, 'text' => $this->Auth->user('username')//
                array(
                    __('EDIT_ACCOUNT', true) => array('url' => '/admin/users/edit'),
                    __('ADMIN_LOGOUT', true) => array('url' => '/admin/users/logout')
                ),
                'extra_class' => 'account-menu'
            );


            /*
              $menu['admins'] = array(
              __('ADMINISTRATORS', true) => array('url' => '/admin/Users/index/filter:admin'),
              array(
              __('ADMIN_LIST', true) => array('url' => '/admin/users/index/filter:admin'),
              __('ADMIN_ADD', true) => array('url' => '/admin/users/add'),
              )
              );


              $menu['users'] = array(
              __('USERS', true) => array('url' => '/admin/Users'),
              array(
              __('ADMIN_LIST', true) => array('url' => '/admin/Users'),
              __('ADMIN_EXPORT', true) => array('url' => '/admin/users/index.csv'),
              )
              );
             */
            $menu['projects'] = array(__('PROJECTS', true) => array('url' => '/admin/projects'),
                array(
                    __('ADMIN_PROJECTS_MENU_ALL', true) => array('url' => '/admin/projects'),
                    __('ADMIN_PROJECTS_MENU_PROPOSALS', true) => array('url' => '/admin/projects/proposals'),
                    __('ADMIN_PROJECTS_MENU_REJECTED', true) => array('url' => '/admin/projects/rejected'),
                    __('ADMIN_PROJECTS_MENU_APPROVED', true) => array('url' => '/admin/projects/approved'),
                    __('ADMIN_PROJECTS_MENU_PUBLISHED', true) => array('url' => '/admin/projects/published'),
                    __('ADMIN_PROJECTS_MENU_ABOUT_TO_FINISH', true) => array('url' => '/admin/projects/about-to-finish'),
                    __('ADMIN_PROJECTS_MENU_FUNDED', true) => array('url' => '/admin/projects/funded'),
                    __('ADMIN_PROJECTS_MENU_NOT-FUNDED', true) => array('url' => '/admin/projects/not-funded'),
                    __('ADMIN_PROJECTS_MENU_FINISHED', true) => array('url' => '/admin/projects/finished'),
                    __('ADMIN_PROJECTS_MENU_OUTSTANDING', true) => array('url' => '/admin/projects/outstanding'),
                    __('ADMIN_PROJECTS_MENU_LEADING', true) => array('url' => '/admin/projects/leading'),
					__('ADMIN_PROJECTS_MENU_WEEK', true) => array('url' => '/admin/projects/week')
                )
            );

			$menu['predefineds'] = array('Proyectos Predefinidos' => array('url' => '/admin/predefinidos/list'),
                array(
                    'Ingresar' => array('url' => '/admin/predefinidos/create'),
					'Modificar / Borrar' => array('url' => '/admin/predefinidos/list')
                   
                )
            );

           /* $menu['offers'] = array(__('OFFERS', true) => array('url' => '/admin/offers'),
                array(
                    __('ADMIN_OFFERS_ALL', true) => array('url' => '/admin/offers'),
                    __('ADMIN_OFFERS_MENU_DISABLED', true) => array('url' => '/admin/offers/disabled'),
                    __('ADMIN_OFFERS_MENU_PROPOSALS', true) => array('url' => '/admin/offers/proposals'),
                    __('ADMIN_OFFERS_MENU_REJECTED', true) => array('url' => '/admin/offers/rejected'),
                    __('ADMIN_OFFERS_MENU_APPROVED', true) => array('url' => '/admin/offers/approved'),
                    __('ADMIN_OFFERS_MENU_PUBLISHED', true) => array('url' => '/admin/offers/published'),
                    __('ADMIN_OFFERS_MENU_ABOUT_TO_FINISH', true) => array('url' => '/admin/offers/about-to-finish'),
                    __('ADMIN_OFFERS_MENU_FINISHED', true) => array('url' => '/admin/offers/finished'),
                    __('ADMIN_OFFERS_MENU_OUTSTANDING', true) => array('url' => '/admin/offers/outstanding'),
                    __('ADMIN_OFFERS_MENU_LEADING', true) => array('url' => '/admin/offers/leading'),
					__('ADMIN_OFFERS_MENU_WEEK', true) => array('url' => '/admin/offers/week'),
                )
            );*/

            $menu['users'] = array(__('USERS', true) => array('url' => '/admin/users'),
                array(
                    __('ADMIN_USER_ALL', true) => array('url' => '/admin/users'),
                    __('ADMIN_USER_REPORTED_USERS', true) => array('url' => '/admin/users/reported'),
                    __('ADMIN_USER_ALL_ACTIVE_USERS', true) => array('url' => '/admin/users/active'),
                    __('ADMIN_USER_ALL_INACTIVE_USERS', true) => array('url' => '/admin/users/inactive'),
                    __('ADMIN_USER_ALL_FUNCTIONAL_USERS', true) => array('url' => '/admin/users/functional'),

                    __('ADMIN_USER_ALL_ADMIN_USERS', true) => array('url' => '/admin/admins/all'),
                    __('ADMIN_USER_ALL_ADMIN_USERS_ACTIVE', true) => array('url' => '/admin/admins/active'),
                    __('ADMIN_USER_ALL_ADMIN_USERS_INACTIVE', true) => array('url' => '/admin/admins/inactive'),

                    __('ADMIN_CREATE_ADMIN', true) => array('url' => '/admin/admins/add')
                )
            );
/*
            $menu['STATICPAGES'] = array(__('STATICPAGES', true) => array('url' => '/admin/staticpages'),
                array(
                    __('ADMIN_STATICPAGES_ALL', true) => array('url' => '/admin/staticpages')
                )
            );
*/
            $menu['PAYMENTS'] = array(__('PAYMENTS', true) => array('url' => '/admin/sponsorships'),
                array(
                    __('ADMIN_PAYMENTS_ALL', true) => array('url' => '/admin/sponsorships/all_paypal'),
                    __('ADMIN_PAYMENTS_COMPLETED', true) => array('url' => '/admin/sponsorships/completed'),
                    __('ADMIN_PAYMENTS_NOT_COMPLETED', true) => array('url' => '/admin/sponsorships/not-completed'),
					__('ADMIN_PAYMENTS_ALL_MP', true) => array('url' => '/admin/sponsorships/mercadopago/all')
                   
                )
            );
            // $this->loadModel('Role');
            $ret = '';
            $first = 0;

            foreach ($menu as $menuName => $menuItem) {

                foreach ($menuItem as $title => $value) {
                    $url = is_array($value) && array_key_exists('url', $value) ? $value['url'] : false;
                    if (!$url) {
                        if (is_array($value)) {
                            foreach ($value as $subTitle => $subValue) {
                                $url = array_key_exists('url', $subValue) ? $subValue['url'] : false;
                                /*
                                  if ($this->Role->isAuthorized($this->Auth->user(), $url)) {
                                  //vd('valid url');
                                  } else {
                                  unset($menu[$menuName][$title][$subTitle]);
                                  }
                                 */
                            }
                        }
                    } else {
                        /*
                          if ($this->Role->isAuthorized($this->Auth->user(), $url)) {
                          //vd('valid url');
                          } else {
                          unset($menu[$menuName]);
                          }
                         */
                    }
                }
            }


            if (empty($menu['logout']) && $this->Auth->user()) {
                $menu['logout'] = array(
                    __('ADMIN_LOGOUT', true) => array('url' => '/admin/Users/logout', 'extra_class' => 'sf-right logOutItem'),
                );
            }
        }
        return $menu;
    }

    var $uploadFileName = null;
    var $uploadFileType = null;
    var $uploadFile = null;
    var $autoPaginateOptions = array(
        'filter' => array(),
        'sort' => array(),
        'direction' => array(
            'default' => 'asc'
        ),
        'search' => array(),
        'limit' => array(
            '5' => 5,
            '10' => 10,
            '20' => 20,
            '50' => 50,
            '100' => 100,
        )
    );

    function upload($field, $id=false, $autoRender=false, $user_id=false) {


        $user_id = empty($user_id) ? ( isset($_SESSION['Auth']['User']['id']) ? $_SESSION['Auth']['User']['id'] : false ) : false; // get a loggued user

        if (!$user_id) {
            trigger_error('We need an user id');
            return false;
        }

        if (!$id) {
            $id = null;
        }

        $model = Inflector::classify($this->params['controller']);
        $this->uploadFile = $this->{$model}->Media->upload($model, $id, $this->data[$field][0], $user_id, $this->uploadFileName, $this->uploadFileType);
        $this->set('media', $this->uploadFile['Media']);
        $this->layout = 'ajax';

        if ($this->uploadFile && is_numeric($id)) { // save HABTM media
            $this->data = $this->{$model}->find('first', array(
                        'conditions' => array(
                            "$model.id" => $id
                        ),
                        'contain' => array('Media')
                            )
            );

            if (!empty($this->data)) {
                foreach ($this->data['Media'] as $key => $media) {
                    $this->data['Media']['Media'][$key] = $media['id'];
                }
                $this->data['Media']['Media'][] = $this->uploadFile['Media']['id'];
                $save = array('Media' => $this->data['Media'], $model => $this->data[$model]);
                $this->data = $save;
                $this->{$model}->saveAll($save, array('validate' => false)); // save the new file as a media of an user
            }
        }

        if ($autoRender) {
            $this->render('/common/upload');
        } else {
            return $this->uploadFile;
        }
    }

    function _parsePaginateParam($key, $model=null) {

        if ($key == 'order') {   // i have to check something here
        } else {



            $model = empty($model) ? Inflector::classify($this->name) : $model;
            if (array_key_exists($key, $this->paginate)) {
                $param = $this->paginate[$key];
            } else {
                $param = is_string($this->autoPaginateOptions[$key]) ? $this->autoPaginateOptions[$key] : false;
                $param = !$param ? @$this->autoPaginateOptions[$key]['default'] : $param;
            }

            if (!$param && $key == 'sort') {
                $param = $model . '.' . $this->{$model}->primaryKey;
            }

            if (isset($this->data[$model][$key])) {
                $param = $this->data[$model][$key];
            } elseif (isset($this->params['named'][$key])) {
                $param = $this->params['named'][$key];
            }

            $this->data[$model][$key] = $this->params['named'][$key] = $this->params['paging'][$model][$key] = $param;


            //if ($key )
            //vd( $param );

            return $param;
        }
    }

    function _parsePaginateParams($model=null) {


        $params = array('filter', 'sort', 'direction', 'limit', 'search');
        foreach ($params as $param) {
            if (!isset($this->autoPaginateOptions[$param]) || empty($this->autoPaginateOptions[$param])) {
                $this->autoPaginateOptions($param, array());
            } else {
                $this->data['autoPaginateOptions'][$param] = $this->autoPaginateOptions[$param];
            }
            $this->data[$model][$param] = $this->_parsePaginateParam($param); // OK
        }
        unset($this->data['autoPaginateOptions']['search']);
    }

    function autoPaginateOptions($class, $values = array()) {
        $class = low($class) == 'order' ? 'sort' : low($class);
        $params = array('filter', 'sort', 'direction', 'limit', 'search');
        if (in_array($class, $params)) {
            return $this->data['autoPaginateOptions'][$class] = $this->autoPaginateOptions[$class] = $values;
        } else {
            trigger_error("ERROR : '$class' not found in autoPaginateOptions params (" . implode(',', $params) . " ) ");
        }
    }

    function _preparePaginate($model=null, $autoPrepare=true) {

        $model = empty($model) ? Inflector::classify($this->name) : $model;

        if ($autoPrepare) {
            $this->_parsePaginateParams($model);
        }

        $sort = false;
        if (!empty($this->data[$model]['sort']) && $this->data[$model]['sort'] !== false) {
            if (is_array($this->autoPaginateOptions['sort'])) {
                $keys = array_keys($this->autoPaginateOptions['sort']);
                if (in_array($this->data[$model]['sort'], $keys, true)) {
                    $this->paginate['sort'] = $this->autoPaginateOptions['sort'][$this->data[$model]['sort']]; //. ' ' . $this->autoPaginateOptions['direction'] ;
                } else {
                    $sort = $this->data[$model]['sort'];
                }
            } else {
                trigger_error("ERROR :  ");
            }
        }

        if ($sort) { // chequeamos que exista lo que queremos ordenar
            $shechema = array_keys($this->{$model}->schema());
            $queryModel = strstr('.', $sort) ? array_shift(explode('.', $sort)) : $model;
            $field = strstr('.', $sort) ? array_pop(explode('.', $sort)) : $sort;
            $field = str_replace($queryModel . '.', '', $sort);
            @list($field, $direction) = explode(' ', $field);
            $direction = empty($direction) ? $this->data[$model]['direction'] : $direction;
            if (in_array($field, $shechema)) {
                $this->paginate['sort'] = $queryModel . '.' . $field; //. ' ' .$direction ; // Agregamos direction al order de la consulta
            } else {
                trigger_error("ERROR : field {$queryModel}.{$field} does not exist "); //[OK]
            }
        }
        if (isset($this->paginate['sort'])) {
            $direction = isset($this->paginate['direction']) ? $this->paginate['direction'] : ''; //
            $this->paginate['order'] = $this->paginate['sort'] . ' ' . $direction; //
            unset($this->paginate['sort']);
            unset($this->paginate['direction']);
        }



        if (
                !empty($this->autoPaginateOptions['filter'])  // estadefinido auto filtros
                && is_array($this->autoPaginateOptions['filter'])  // es un array autofiltros
                && in_array($this->data[$model]['filter'], array_keys($this->autoPaginateOptions['filter'])) // existe en los autoFiltros
        ) {
            if (in_array($this->data[$model]['filter'], array_keys($this->autoPaginateOptions['filter']))) {
                if (is_array($this->autoPaginateOptions['filter'][$this->data[$model]['filter']])) {
                    foreach ($this->autoPaginateOptions['filter'][$this->data[$model]['filter']] as $field => $value) {
                        $this->paginate['conditions'][$field] = $value;
                    }
                } elseif (is_string($this->autoPaginateOptions['filter'][$this->data[$model]['filter']])) {
                    $this->paginate['conditions'][] = $this->autoPaginateOptions['filter'][$this->data[$model]['filter']];
                }
            }
        } else {
            if (array_key_exists($this->data[$model]['filter'], $this->autoPaginateOptions['filter'])) { // si default no es "all" uso el filtro que corresponde.
                $this->paginate['conditions'][] = $this->autoPaginateOptions['filter'][$default];
            }
        }


        if (!empty($this->data[$model]['search']) && $this->data[$model]['search'] !== false) {
            if (!empty($this->autoPaginateOptions['search']) && is_array($this->autoPaginateOptions['search'])) {
                foreach ($this->autoPaginateOptions['search'] as $field => $value) {
                    if (is_numeric($field)) {
                        $field = $value;
                        $value = ':value';
                    }
                    $this->paginate['conditions']['or'][] = array($field => String::insert($value, array('value' => $this->data[$model]['search'])));
                }
            }
        }

        unset($this->data['autoPaginateOptions']['order']);



        if (!empty($this->data[$model]['limit']) && $this->data[$model]['limit'] !== false) {
            $this->paginate['limit'] = $this->data[$model]['limit'];
        } else {
            $this->paginate['limit'] = $this->data[$model]['limit'] = !empty($this->paginate['limit']) ? $this->paginate['limit'] : 10;
        }
    }

}

?>
