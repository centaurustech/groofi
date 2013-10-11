<?php

// -----------------------------------------------------------------------------
define('SITE_NAME', 'Groofi');


define('REPORT_COUNT_LIMIT', 2 ) ;

define('USER_LEVEL_USER', 0 ) ;
define('CONFIMATION_TOKEN_DURATION', 2 ) ;
define('USER_LEVEL_ADMIN', 99 ) ;
define('ADMIN_DEFAULT_HOME', 'USERS' ) ;

define('PREAPPROVA_EXTRA_TIME', 30); // Days


define('PROJECT_COMISION', 25 ); // %

define('REFOUND_EXTRA_REQUIRED_PERCENTEGE', 10 ); // % // balance must have x% extra than required



// MAIL CONFIGURATION - CONFIGURACION DE EMAIL.

//define('SMTP_FAST_SERVER', 'mail.groofi.com');
//define('SMTP_NORMAL_SERVER', 'mail.groofi.com');
define('SMTP_PORT', '587');
define('SMTP_TIMEOUT', '30');
define('SMTP_HOST', 'smtp.mandrillapp.com');
define('SMTP_USERNAME', 'alejandro.garrido.g@gmail.com');
define('SMTP_PASSWORD', 'BD4-PoFKpGf4x5NBUh4PEQ');
define('SMTP_REPLYTO', 'noreply@groofi.com');
define('SMTP_FROM', 'GROOFI <noreply@groofi.com>');



// PAYPAL INFORMATION
//    define('PAYPAL_EMAIL', 'gaston_1314122319_biz@gotvertigo.com');
//    define('PAYPAL_API_USERNAME', 'gaston_1314122319_biz_api1.gotvertigo.com');
//    define('PAYPAL_API_PASSWORD', '1314122365');
//    define('PAYPAL_SIGNATURE', 'AQU0e5vuZCvSg-XJploSa.sGUDlpAvzp3fHzTj2Tpy23FDRYdXbiqgPg');

define('PAYPAL_EMAIL', 'paypal@groofi.com');
define('PAYPAL_API_USERNAME', 'paypal_api1.groofi.com');
define('PAYPAL_API_PASSWORD', '9Y4HVDSNTUPZKRKL');
define('PAYPAL_SIGNATURE', 'AmUXjeigxgz9QRZoASm8gBUxmuG0A9c5eK6cWSH3GKWdn32ZuaNSJK67');

// ----------------------------------------

define('X_PAYPAL_API_APPLICATION_ID', 'APP-80W284485P519543T'); // Test app id




define('X_PAYPAL_API_REQUESTFORMAT', "NV");
define('X_PAYPAL_API_RESPONSEFORMAT', "NV");
define('PAYPAL_LIMIT', 10000 ); // 10000
define('PAYPAL_MASSPAYMENT_COST', 1); // %

// define('PAYPAL_AUTH_TOKEN', '');
// define('AUTH_TIMESTAMP', '');
//Live	API Certificate	Name-Value Pair	https://api.paypal.com/nvp
//Live	API Signature	Name-Value Pair	https://api-3t.paypal.com/nvp
//Live	API Certificate	SOAP	https://api.paypal.com/2.0/
//Live	API Signature	SOAP	https://api-3t.paypal.com/2.0/
//Live	Adaptive APIs	JSON, NVP, XML	https://svcs.paypal.com/AdaptivePayments/API_operation
//Live	Permissions Service APIs	JSON, NVP, SOAP	https://svcs.paypal.com/Permission/API_operation
//Sandbox	API Certificate	Name-Value Pair	https://api.sandbox.paypal.com/nvp
//Sandbox	API Signature	Name-Value Pair	https://api-3t.sandbox.paypal.com/nvp
//Sandbox	API Certificate	SOAP	https://api.sandbox.paypal.com/2.0/
//Sandbox	API Signature	SOAP	https://api-3t.sandbox.paypal.com/2.0/
//Sandbox	Adaptive APIs	JSON, NVP, XML	https://svcs.sandbox.paypal.com/AdaptivePayments/API_operation
//Sandbox	Permissions Service APIs	JSON, NVP, SOAP   	https://svcs.sandbox.paypal.com/Permission/API_operation
//------------------------------------------------------------------------------
//
//define('PAYPAL_API_ENDPOINT', 'https://api-3t.sandbox.paypal.com/nvp');
//define('X_PAYPAL_API_ENDPOINT', 'https://svcs.sandbox.paypal.com');

define('PAYPAL_API_ENDPOINT', 'https://api-3t.paypal.com/nvp');
define('X_PAYPAL_API_ENDPOINT', 'https://svcs.paypal.com');



//------------------------------------------------------------------------------
define('X_PAYPAL_DEVICE_ID', 'mydevice');
define('X_PAYPAL_PAYPAL_REDIRECT_URL', 'https://www.paypal.com/webscr&cmd=');
//define('X_PAYPAL_PAYPAL_REDIRECT_URL', 'https://www.sandbox.paypal.com/webscr&cmd=');
define('X_PAYPAL_DEVELOPER_PORTAL', 'https://developer.paypal.com');
define('X_PAYPAL_LOGFILENAME', '../Log/logdata.log');
define('X_PAYPAL_DEVICE_IPADDRESS', '127.0.0.1');
define('X_PAYPAL_REQUEST_SOURCE', 'PHP_NVP_SDK_V1.1');

//------------------------------------------------------------------------------
define('PAYPAL_URL', 'https://www.paypal.com/webscr&cmd=_express-checkout&token=');
//define('PAYPAL_URL', 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=');
define('PAYPAL_EXPRESS-CHECKOUT_URL', 'https://www.paypal.com/webscr&cmd=_express-checkout&token=');
//define('PAYPAL_EXPRESS-CHECKOUT_URL', 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=');
define('PAYPAL_ADAPTATIVE_ACCOUNTS_URL', 'https://www.paypal.com/webscr?cmd=_ap-preapproval&preapprovalkey=');
//define('PAYPAL_ADAPTATIVE_ACCOUNTS_URL', 'https://www.sandbox.paypal.com/webscr?cmd=_ap-preapproval&preapprovalkey=');
//------------------------------------------------------------------------------

define('PAYPAL_VERSION', '65.1');
define('PAYPAL_USE_PROXY', FALSE);
define('PAYPAL_PROXY_HOST', '127.0.0.1');
define('PAYPAL_PROXY_PORT', '808');
define('PAYPAL_SUBJECT', '');

// Ack related constants
//------------------------------------------------------------------------------
define('PAYPAL_ACK_SUCCESS', 'SUCCESS');
define('PAYPAL_ACK_SUCCESS_WITH_WARNING', 'SUCCESSWITHWARNING');


define('SPONSORSHIP_STATUS_INCOMPLETE', 0);
define('SPONSORSHIP_STATUS_COMPLETE', 1);


define('PAYPAL_STATUS_INCOMPLETE', SPONSORSHIP_STATUS_INCOMPLETE);
define('PAYPAL_STATUS_COMPLETED', 1);
define('PAYPAL_STATUS_CHARGED', 12);
define('PAYPAL_STATUS_CREATED', 2);
define('PAYPAL_STATUS_DENIED', 3);
define('PAYPAL_STATUS_EXPIRED', 4);
define('PAYPAL_STATUS_FAILED', 5);
define('PAYPAL_STATUS_PENDING', 6);
define('PAYPAL_STATUS_REFUNDED', 7);
define('PAYPAL_STATUS_REVERSED', 8);
define('PAYPAL_STATUS_PROCESSED', 9);
define('PAYPAL_STATUS_VOIDED', 10);
define('PAYPAL_STATUS_CANCELED_REVERSAL', 11);


define('PAYPAL_PREAPPROVAL_ACTIVE', 1);
define('PAYPAL_PREAPPROVAL_CANCELED', SPONSORSHIP_STATUS_INCOMPLETE);
define('PAYPAL_PREAPPROVAL_DEACTIVED', SPONSORSHIP_STATUS_INCOMPLETE);
define('EXPRESSCHECKOUT', 'EXPRESSCHECKOUT');
define('PREAPPROVAL', 'PREAPPROVAL');



// GOOGLE ACCOUNT INFO
define('GOOGLE_SITE_VERIFICATION', false);
define('GOOGLE_ANALITYCS_ACCOUNT', false);

// ------------------------------------------------------------------------------------------------------------------------------
if (isset($_SERVER['SERVER_NAME'])) {
    define('SITE_URL', 'http://' . $_SERVER['SERVER_NAME']);
    define('CDN_SERVER', 'http://' . $_SERVER['SERVER_NAME']);
    define('STATIC_SERVER', 'http://' . $_SERVER['SERVER_NAME']);
    define('ASSETS_SERVER', 'http://' . $_SERVER['SERVER_NAME']);
} else {
    define('SITE_URL', 'http://127.0.0.1');
    define('CDN_SERVER', 'http://127.0.0.1');
    define('STATIC_SERVER', 'http://127.0.0.1');
    define('ASSETS_SERVER', 'http://127.0.0.1');
}


define('IMAGE_BASE_DIR', 'img/');
define('IMAGE_UPLOAD_DIR', 'uploads/');
define('ROOT_PATH', 'asd'); // ??? ?? ?? ??
define('IMAGE_FULL_UPLOAD_DIR', IMAGE_BASE_DIR . IMAGE_UPLOAD_DIR);
//define('IMAGE_CACHE_DIR' ,  IMAGE_BASE_DIR.DS.'/cache'.DS );
define('IMAGE_CACHE_DIR', 'files/');
define('IMAGE_STATIC', '/img/static');
define('IMAGE_DEFAULT', WWW_ROOT . DS . IMAGE_BASE_DIR . 'default' . DS);
define('DEFAULT_IMAGE', IMAGE_DEFAULT . 'default_noimage.png');
// *********************************************************************************************************

define('DEFAULT_LIMIT', 10);
define('USERS_INDEX_LIMIT', DEFAULT_LIMIT);


/* USER ROLES */
define('AUTH_MODEL', 'User');
define('SYSTEM_ADMIN', 999);
define('ROLE_ADMIN', 99);
define('ROLE_CLUB_CORREDORES', 100);
define('ROLE_USER', 1);

/**
 * Defines the default error type when using the log() function. Used for
 * differentiating error logging and debugging. Currently PHP supports LOG_DEBUG.
 */
define('LOG_ERROR', 2);

/* App custom errors */
define('ERROR_VALIDATION', 100);
define('ERROR_NOT_SELECTED', 101);
define('ERROR_NO_POST_DATA', 102);
define('ERROR_USER_NOT_FOUND', 103);
define('TWITTER_APP_NOT_FOUND', 104);
define('RACE_NOT_FOUNT', 105);
define('ERROR_INVALID_HASH', 106);
define('ERROR_NOT_FOUND', 107);
define('RACE_FULL', 108);

/*
  PP	 the path to the application's directory.
  APP_DIR	the name of the current application's app directory.
  APP_PATH	absolute path to the application's app directory.
  CACHE	path to the cache files directory.
  CAKE	path to the application's cake directory.
  COMPONENTS	path to the application's components directory.
  CONFIGS	path to the configuration files directory.
  CONTROLLER_TESTS	path to the controller tests directory.
  CONTROLLERS	path to the application's controllers.
  CSS	path to the CSS files directory.
  ELEMENTS	path to the elements directory.
  HELPER_TESTS	path to the helper tests directory.
  HELPERS	path to the helpers directory.
  INFLECTIONS	path to the inflections directory (usually inside the configuration directory).
  JS	path to the JavaScript files directory.
  LAYOUTS	path to the layouts directory.
  LIB_TESTS	path to the Cake Library tests directory.
  LIBS	path to the Cake libs directory.
  LOGS	path to the logs directory.
  MODEL_TESTS	path to the model tests directory.
  MODELS	path to the models directory.
  SCRIPTS	path to the Cake scripts directory.
  TESTS	path to the tests directory (parent for the models, controllers, etc. test directories)
  TMP	path to the tmp directory.
  VENDORS	path to the vendors directory.
  VIEWS	path to the views directory.

  CORE_PATH	 path to the Cake core libraries.
  WWW_ROOT 	path to the application's webroot directory
  CAKE_CORE_INCLUDE_PATH	path to the Cake core libraries.
  ROOT	the name of the directory parent to the base index.php of CakePHP.
  WEBROOT_DIR	the name of the application's webroot directory.
 */

/* ----------------------------------------------------------------------------------- */

define('CUSTOM_ALPHANUM', '/^[a-z0-9]$/i');
define('CUSTOM_SLUG', '/^[a-z][a-z0-9-]*$/i');

/* ----------------------------------------------------------------------------------- */
define('ACTIVE', 1);
define('INACTIVE', 0);

define('DAYS_TO_BE_FINISHING', 2 ) ;

define('IS_PUBLIC', 1);
define('IS_IMPORTANT', 1);
define('IS_NOT_PUBLIC', 0);
define('IS_NOT_IMPORTANT', 0);
define('IS_ENABLED', 1);
define('IS_DISABLED', 0);

define('EMAIL_ATTEMPTS', 5);
define('EMAIL_ON_QUEUE', 1);
define('USER_STATUS_ENABLED', IS_ENABLED);
define('USER_STATUS_DISABLED', IS_DISABLED);
define('ACTIVITY_STATUS_ENABLED', IS_ENABLED);
define('ACTIVITY_STATUS_DISABLED', IS_DISABLED);
define('MESSAGE_ENABLED', IS_ENABLED);
define('MESSAGE_DISABLED', IS_DISABLED);


define('PROJECT_FUNDED_VALUE_VALID', 75);
/* ---- */
define('PROJECT_STATUS_NEW', 0);
define('PROJECT_STATUS_APROVED', 1);
define('PROJECT_STATUS_REJECTED', 2);
define('PROJECT_STATUS_PUBLISHED', 3);
define('PROJECT_FUNDED', 4);
define('PROJECT_NOT_FUNDED', 5);
define('PROJECT_ABOUT_TO_FINISH', 6);
define('PROJECT_FINISHED', 7);
define('PROJECT_NOT_FINISHED', 0);


define('OFFER_STATUS_NEW', 0);
define('OFFER_STATUS_APROVED', 1);
define('OFFER_STATUS_REJECTED', 2);
define('OFFER_STATUS_PUBLISHED', 3);
define('OFFER_ABOUT_TO_FINISH', 6);
define('OFFER_FINISHED', 7);
define('OFFER_NOT_FINISHED', 0);


define('PROJECT_MIN_DURATION', 7);
define('PROJECT_MAX_DURATION', 365);

define('OFFER_MIN_DURATION', 7);
define('OFFER_MAX_DURATION', 365);


define('NOTIFICATION_OFFER_COMMENTED',1);
define('NOTIFICATION_OFFER_PENDING_APPROVE',2);
define('NOTIFICATION_OFFER_APPROVED',3);
define('NOTIFICATION_OFFER_REJECTED',4);
define('NOTIFICATION_OFFER_CREATED',5);
define('NOTIFICATION_OFFER_NEW_UPDATE',6);
define('NOTIFICATION_OFFER_NEW_PROJECT',7);
define('NOTIFICATION_OFFER_NEW_USER',8);
define('NOTIFICATION_OFFER_ABOUT_TO_FINISH',9);
define('NOTIFICATION_OFFER_FINISHED',10);
define('NOTIFICATION_POST_COMMENTED',11);
define('NOTIFICATION_PROJECT_COMMENTED',12);
define('NOTIFICATION_PROJECT_PENDING_APPROVE',13);
define('NOTIFICATION_PROJECT_APPROVED',14);
define('NOTIFICATION_PROJECT_REJECTED',15);
define('NOTIFICATION_PROJECT_NEW_BACKER',16);
define('NOTIFICATION_PROJECT_NEW_UPDATE',17);
define('NOTIFICATION_PROJECT_CREATED',18);
define('NOTIFICATION_PROJECT_ABOUT_TO_FINISH',19);
define('NOTIFICATION_PROJECT_FINISH',20);
define('NOTIFICATION_PROJECT_FUNDED',21);
define('NOTIFICATION_PROJECT_DONT_FUNDED',22);
define('NOTIFICATION_USER_WELCOME_MAIL',23);
define('NOTIFICATION_PASSWORD_RECOVERY',24);






define('SPONSORSHIP_PENDING' ,0 ) ;
define('SPONSORSHIP_COMPLETED' , 1 ) ;
define('SPONSORSHIP_TRANSFERRED' , 2 ) ;
define('SPONSORSHIP_CANCELED' , 3) ;
define('SPONSORSHIP_ERROR' , 4 ) ;
define('SPONSORSHIP_WAITING' , 5 ) ;

?>
