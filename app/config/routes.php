<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
Router::parseExtensions('html', 'rss', 'json', 'xml', 'txt');

Router::connectNamed(array(
    'tab',
    'user',
    'category',
    'status',
    'filter',
    'search',
    'sort',
    'direction',
    'limit',
    'country',
        ), array('default' => true)
);


Router::connect('/admin/projects/:filter/*', array('controller' => 'projects', 'action' => 'index', 'admin' => true), array(
    'pass' => array('filter'),
    'filter' => 'all|proposals|rejected|approved|outstanding|leading|published|disabled|about-to-finish|finished|funded|not-funded|week'
        )
);




Router::connect('/admin/offers/:filter/*', array('controller' => 'offers', 'action' => 'index', 'admin' => true), array(
    'pass' => array('filter'),
    'filter' => 'all|proposals|rejected|approved|outstanding|leading|published|disabled|about-to-finish|finished|week'
        )
);



Router::connect('/admin/sponsorships/:filter/*', array('controller' => 'sponsorships', 'action' => 'index', 'admin' => true), array(
    'pass' => array('filter'),
    'filter' => 'all|completed|not-completed|all_paypal'
        )
);

Router::connect('/admin/sponsorships/mercadopago/:filter/*', array('controller' => 'sponsorships', 'action' => 'index2', 'admin' => true), array(
    'pass' => array('filter'),
    'filter' => 'all'
        )
);



Router::connect('/admin/:type/:filter/*', array('controller' => 'users', 'action' => 'index', 'admin' => true), array(
    'pass' => array('filter','type'),
    'filter' => 'all|reported|active|inactive|functional',
    'type' => 'users|admins'
        )
);


/*
Router::connect('/admin/admins/:filter/*', array('controller' => 'users', 'action' => 'index', 'admin' => true), array(
        'pass' => array('filter'),
        'filter' => 'all|active|inactive'
    )
);
*/
Router::connect('/admin/admins/add/*', array('controller' => 'users', 'action' => 'add', 'admin' => true));


Router::connect('/', array('controller' => 'staticpages', 'action' => 'home'));
Router::connect('/admin', array('controller' => 'users', 'action' => 'index', 'admin' => true));
Router::connect('/home', array('controller' => 'staticpages', 'action' => 'home'));
Router::connect('/guidelines', array('controller' => 'staticpages', 'action' => 'guidelines'));
Router::connect('/como-funciona', array('controller' => 'staticpages', 'action' => 'comofunciona'));
Router::connect('/faq', array('controller' => 'staticpages', 'action' => 'faq'));
Router::connect('/contacto', array('controller' => 'staticpages', 'action' => 'contacto'));
Router::connect('/translate', array('controller' => 'staticpages', 'action' => 'translate'));
Router::connect('/country', array('controller' => 'staticpages', 'action' => 'country'));
Router::connect('/mp_ipn.php', array('controller' => 'sponsorships', 'action' => 'mp_ipn'));


Router::connect('/debug_kit/:controller/:action/*', array('plugin' => 'debugKit'));
Router::connect('/debug_kit/:controller/*', array('plugin' => 'debugKit'));



Router::connect('/msg/:messageSlug', array('controller' => 'staticpages', 'action' => 'message'), array('pass' => array('messageSlug')));





/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
Router::connect('/page/*', array('controller' => 'staticpages', 'action' => 'view'));

/* -------------------------------------------------------------------- */

Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
Router::connect('/login2', array('controller' => 'users', 'action' => 'login2'));
Router::connect('/login3', array('controller' => 'users', 'action' => 'login3'));
Router::connect('/sincro', array('controller' => 'users', 'action' => 'sincro'));
Router::connect('/signup', array('controller' => 'users', 'action' => 'add')); // users/add
Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
Router::connect('/forgotPassword', array('controller' => 'users', 'action' => 'forgot_password'));

Router::connect('/confirm/:hc/*', array('controller' => 'users', 'action' => 'confirm'), array('pass' => array('hc')));
Router::connect('/recover_password/:hc/*', array('controller' => 'users', 'action' => 'recover_password'), array('pass' => array('hc')));




Router::connect('/profile', array('controller' => 'notifications', 'action' => 'listing')); // users/index

Router::connect('/profile/:user', array('controller' => 'notifications', 'action' => 'listing'), array('pass' => array('user'), 'user' => '[a-zA-Z0-9-_ \+]+')); // /profile/userSlug


Router::connect('/profile/:user/activity', array('controller' => 'notifications', 'action' => 'listing'), array('pass' => array('user'), 'user' => '[a-zA-Z0-9-_ \+]+')); // /profile/userSlug

Router::connect('/profile/:user/bio', array('controller' => 'users', 'action' => 'view', 'bio' => true), array('pass' => array('user'), 'user' => '[a-zA-Z0-9-_ \+]+')); // /profile/userSlug
Router::connect('/profile/:user/projects', array('controller' => 'projects', 'action' => 'listing'), array('pass' => array('user'), 'user' => '[a-zA-Z0-9-_ \+]+')); // /profile/userSlug
Router::connect('/profile/:user/offers', array('controller' => 'offers', 'action' => 'listing'), array('pass' => array('user'), 'user' => '[a-zA-Z0-9-_ \+]+')); // /profile/userSlug
Router::connect('/profile/:user/follows', array('controller' => 'follows', 'action' => 'listing'), array('pass' => array('user'), 'user' => '[a-zA-Z0-9-_ \+]+')); // /profile/userSlug
Router::connect('/profile/:user/backed', array('controller' => 'sponsorships', 'action' => 'listing'), array('pass' => array('user'), 'user' => '[a-zA-Z0-9-_ \+]+')); // /profile/userSlug

Router::connect('/verifyPrivate', array('controller' => 'projects', 'action' => 'verifyPrivate'));


Router::connect('/report/:model/:user', array('controller' => 'reports', 'action' => 'add'), array('pass' => array('model', 'user'))); // /profile/userSlug
Router::connect('/vote/:model/:user/:value', array('controller' => 'votes', 'action' => 'add'), array('pass' => array('model', 'user', 'value'))); // /profile/userSlug
Router::connect('/report/:model/:comment', array('controller' => 'reports', 'action' => 'add'), array('pass' => array('model', 'comment'))); // /profile/userSlug
//Router::connect('/profile/:user/offers', array('controller' => 'offers', 'action' => 'profile'), array('pass' => array('user'), 'user' => '[a-zA-Z0-9-_]+')); // /profile/userSlug


Router::connect('/settings/delete', array('controller' => 'users', 'action' => 'delete'));
Router::connect('/settings', array('controller' => 'users', 'action' => 'edit', 'tab' => 'profile'), array(
    'pass' => array('tab')
        )
); // users/add

Router::connect(// users/edit
        '/settings/facebook', array('controller' => 'users', 'action' => 'edit', 'tab' => 'profile', 'update' => true), array(
    'pass' => array('tab', 'update')
        )
);

Router::connect(// users/edit
        '/settings/:tab', array('controller' => 'users', 'action' => 'edit'), array(
    'pass' => array('tab'),
    'type' => 'profile|account|notifications'
        )
);





Router::connect('/discover', array('controller' => 'projects', 'action' => 'index'));
$models = array('projects', 'offers');
foreach ($models as $model) {
    $route_params = array('controller' => $model, 'action' => 'index');
    $urls = array('/discover/:model');
    $urls[] = '/discover/:model/in/:category';
    $urls[] = '/discover/:model/from/:country/:city';
    $urls[] = '/discover/:model/from/:country';
    $urls[] = '/discover/:model/in/:category/from/:country/:city';
    $urls[] = '/discover/:model/in/:category/from/:country';
    $urls[] = '/discover/:status/:model';
    $urls[] = '/discover/:status/:model/in/:category';
    $urls[] = '/discover/:status/:model/from/:country/:city';
    $urls[] = '/discover/:status/:model/from/:country';
    $urls[] = '/discover/:status/:model/in/:category/from/:country/:city';
    $urls[] = '/discover/:status/:model/in/:category/from/:country';
    $urls[] = '/discover/:model/:page';
    $urls[] = '/discover/:model/in/:category/:page';
    $urls[] = '/discover/:model/from/:country/:city/:page';
    $urls[] = '/discover/:model/from/:country/:page';
    $urls[] = '/discover/:model/in/:category/from/:country/:city/:page';
    $urls[] = '/discover/:model/in/:category/from/:country/:page';
    $urls[] = '/discover/:status/:model/:page';
    $urls[] = '/discover/:status/:model/in/:category/:page';
    $urls[] = '/discover/:status/:model/from/:country/:city/:page';
    $urls[] = '/discover/:status/:model/from/:country/:page';
    $urls[] = '/discover/:status/:model/in/:category/from/:country/:city/:page';
    $urls[] = '/discover/:status/:model/in/:category/from/:country/:page';
    foreach ($urls as $url) {
        Router::connect(str_replace(':model', $model, $url), $route_params);
    }
    unset($urls);
    unset($route_params);
}



Router::connect('/sponsorships/payment-ipn.php', array('controller' => 'sponsorships', 'action' => 'paymentIpn'));


Router::connect('/sponsorships/payment-success', array('controller' => 'sponsorships', 'action' => 'paymentIpn'));
Router::connect('/sponsorships/payment-complete', array('controller' => 'sponsorships', 'action' => 'paymentSuccess', 'status' => 'completed'));
Router::connect('/sponsorships/payment-not-complete', array('controller' => 'sponsorships', 'action' => 'paymentSuccess', 'status' => 'not-completed'));









Router::connect('/signup/info', array('controller' => 'staticpages', 'action' => 'view', 'slug' => 'register-info'), array('pass' => array('slug')));
Router::connect('/signup/inthanksfo', array('controller' => 'staticpages', 'action' => 'view', 'slug' => 'register-thanks'), array('pass' => array('slug')));





/* Projects actions */

Router::connect('/profile/:user/update/:post/:page', array('controller' => 'posts', 'action' => 'view'), array('pass' => array('post')));
Router::connect('/profile/:user/update/:post/*', array('controller' => 'posts', 'action' => 'view'), array('pass' => array('post')));
Router::connect('/project/:model_id/create-update', array('controller' => 'posts', 'action' => 'add', 'type' => 'project'), array('pass' => array('type', 'model_id')));
Router::connect('/project/:model_id/edit-update/:post_id', array('controller' => 'posts', 'action' => 'edit', 'type' => 'project'), array('pass' => array('type', 'model_id', 'post_id')));
Router::connect('/offer/:model_id/create-update', array('controller' => 'posts', 'action' => 'add', 'type' => 'offer'), array('pass' => array('type', 'model_id')));
Router::connect('/offer/:model_id/edit-update/:post_id', array('controller' => 'posts', 'action' => 'edit', 'type' => 'offer'), array('pass' => array('type', 'model_id', 'post_id')));

Router::connect('/profile/:user/projects/:project', array('controller' => 'projects', 'action' => 'view'), array('pass' => array('project')));
Router::connect('/profile/:user/offers/:offer', array('controller' => 'offers', 'action' => 'view'), array('pass' => array('offer')));

Router::connect('/profile/:user/:model/:project/sponsors/*', array('controller' => 'sponsorships', 'action' => 'index'), array('pass' => array('model', 'project')));
Router::connect('/profile/:user/:model/:project/comments/*', array('controller' => 'comments', 'action' => 'index'), array('pass' => array('model', 'project')));
Router::connect('/profile/:user/:model/:project/updates/*', array('controller' => 'posts', 'action' => 'index'), array('pass' => array('model', 'project')));






Router::connect('/profile/:user/:model/:offer/sponsors/*', array('controller' => 'sponsorships', 'action' => 'index'), array('pass' => array('model', 'offer')));

Router::connect('/profile/:user/:model/:offer/comments/*', array('controller' => 'comments', 'action' => 'index'), array('pass' => array('model', 'offer')));

Router::connect('/profile/:user/:model/:offer/updates/*', array('controller' => 'posts', 'action' => 'index'), array('pass' => array('model', 'offer')));

Router::connect('/profile/:user/:model/:offer/projects/*', array('controller' => 'projects', 'action' => 'list_offers'), array('pass' => array('model', 'offer')));



Router::connect('/profile/:user/:model/:project/back/:prize', array('controller' => 'sponsorships', 'action' => 'add'), array('pass' => array('model', 'project', 'user', 'prize')));
Router::connect('/profile/:user/:model/:project/back/:prize/:rta', array('controller' => 'sponsorships', 'action' => 'add'), array('pass' => array('model', 'project', 'user', 'prize','rta')));
Router::connect('/profile/:user/:model/:project/back', array('controller' => 'sponsorships', 'action' => 'add'), array('pass' => array('model', 'project', 'user')));





Router::connect('/project/edit/:id', array('controller' => 'projects', 'action' => 'edit', 'publish' => false), array('pass' => array('id', 'publish')));
Router::connect('/project/publish/:id', array('controller' => 'projects', 'action' => 'edit', 'publish' => true), array('pass' => array('id', 'publish')));
Router::connect('/project/:id/publish', array('controller' => 'projects', 'action' => 'edit', 'publish' => true, 'getData' => true), array('pass' => array('id', 'publish', 'getData')));

Router::connect('/offer/edit/:id', array('controller' => 'offers', 'action' => 'edit', 'publish' => false), array('pass' => array('id', 'publish')));
Router::connect('/offer/publish/:id', array('controller' => 'offers', 'action' => 'edit', 'publish' => true), array('pass' => array('id', 'publish')));
Router::connect('/offer/:id/publish', array('controller' => 'offers', 'action' => 'edit', 'publish' => true, 'getData' => true), array('pass' => array('id', 'publish', 'getData')));
//Router::connect('/:model/:project/follow', array('controller' => 'follows', 'action' => 'add'), array('pass' => array('model', 'project')));


Router::connect('/:model/:project/follow', array('controller' => 'follows', 'action' => 'add'), array('pass' => array('model', 'project')));

Router::connect('/:model/:offer/follow', array('controller' => 'follows', 'action' => 'add'), array('pass' => array('model', 'offer')));

Router::connect('/:model/:project/unfollow', array('controller' => 'follows', 'action' => 'delete'), array('pass' => array('model', 'project')));

Router::connect('/:model/:offer/unfollow', array('controller' => 'follows', 'action' => 'delete'), array('pass' => array('model', 'offer')));

Router::connect('/messages', array('controller' => 'messages', 'action' => 'index'));
Router::connect('/messages/read', array('controller' => 'messages', 'action' => 'index', 'read'));
Router::connect('/messages/all', array('controller' => 'messages', 'action' => 'index', 'all'));
Router::connect('/messages/sent', array('controller' => 'messages', 'action' => 'index', 'sent'));


/*

  Router::connect('/projects/search/:search', array('controller' => 'searches', 'action' => 'index', 'projects'));
  Router::connect('/offers/search/:search', array('controller' => 'searches', 'action' => 'index', 'offers'));

 */



$models = array('projects', 'offers');
foreach ($models as $model) {
    $route_params = array('controller' => $model, 'action' => 'index');

    $url = "/search/$model";

    Router::connect($url, array('controller' => $model, 'action' => 'index', 'search' => false));

    $urls = array('/search/:model/:search');
    $urls[] = '/search/:model/in/:category/:search';
    $urls[] = '/search/:model/from/:country/:city/:search';
    $urls[] = '/search/:model/from/:country/:search';
    $urls[] = '/search/:model/in/:category/from/:country/:city/:search';
    $urls[] = '/search/:model/in/:category/from/:country/:search';
    $urls[] = '/search/:status/:model/:search';
    $urls[] = '/search/:status/:model/in/:category/:search';
    $urls[] = '/search/:status/:model/from/:country/:city/:search';
    $urls[] = '/search/:status/:model/from/:country/:search';
    $urls[] = '/search/:status/:model/in/:category/from/:country/:city/:search';
    $urls[] = '/search/:status/:model/in/:category/from/:country/:search';
    $urls[] = '/search/:model/:page/:search';
    $urls[] = '/search/:model/in/:category/:page/:search';
    $urls[] = '/search/:model/from/:country/:city/:page/:search';
    $urls[] = '/search/:model/from/:country/:page/:search';
    $urls[] = '/search/:model/in/:category/from/:country/:city/:page/:search';
    $urls[] = '/search/:model/in/:category/from/:country/:page/:search';
    $urls[] = '/search/:status/:model/:page/:search';
    $urls[] = '/search/:status/:model/in/:category/:page/:search';
    $urls[] = '/search/:status/:model/from/:country/:city/:page/:search';
    $urls[] = '/search/:status/:model/from/:country/:page/:search';
    $urls[] = '/search/:status/:model/in/:category/from/:country/:city/:page/:search';
    $urls[] = '/search/:status/:model/in/:category/from/:country/:page/:search';
    foreach ($urls as $url) {
        Router::connect(str_replace(':model', $model, $url), $route_params);
    }
    unset($urls);
    unset($route_params);
}


Router::connect('/news/*', array('controller' => 'notifications', 'action' => 'wall'));


// cron actions
//
/*
 * 0 	0 	*   *   *   wget http://groofi.gv/cron/projects/about_to_finish
 * 0 	0 	*   *   *   wget http://groofi.gv/cron/projects/finished
 * 0 	0 	*   *   *   wget http://groofi.gv/cron/offers/about_to_finish
 * 0 	0 	*   *   *   wget http://groofi.gv/cron/offers/finished
 */

Router::connect('/cron/projects/about_to_finish', array('controller' => 'projects', 'action' => 'cron_aboutToFinish'));
Router::connect('/cron/projects/finished', array('controller' => 'projects', 'action' => 'cron_Finished'));
Router::connect('/cron/offers/about_to_finish', array('controller' => 'offers', 'action' => 'cron_aboutToFinish'));
Router::connect('/cron/offers/finished', array('controller' => 'offers', 'action' => 'cron_Finished'));
Router::connect('/cron/searches/index', array('controller' => 'searches', 'action' => 'cron_indexData'));


/*Pryectos predefinidos*/
Router::connect('/admin/predefinidos/create/*', array('controller' => 'predefinidos', 'action' => 'index', 'admin' => true), array(
    'pass' => array('id')
        )
);
Router::connect('/admin/predefinidos/list', array('controller' => 'predefinidos', 'action' => 'list', 'admin' => true)
);
Router::connect('/predefined/:id/:title', array('controller' => 'predefinidos', 'action' => 'view'), array('pass' => array('id', 'title')));
Router::connect('/createFromPredefined/:id', array('controller' => 'predefinidos', 'action' => 'createProjectFromBase'), array('pass' => array('id')));

