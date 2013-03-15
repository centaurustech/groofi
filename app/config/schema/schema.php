<?php

/* SVN FILE: $Id$ */
/* App schema generated on: 2011-04-07 14:04:52 : 1302197872 */

class AppSchema extends CakeSchema {

    var $name = 'App';

    function before($event = array()) {
        return true;
    }

    function after($event = array()) {
        
    }

    var $reports = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'model' => array('type' => 'string', 'length' => 250, 'null' => false, 'default' => ''),
        'model_id' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
            , 'user_id' => array('column' => 'user_id', 'unique' => 0)
            , 'model' => array('column' => array('model', 'model_id'), 'unique' => 0)
            , 'created' => array('column' => 'created', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $votes = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'model' => array('type' => 'string', 'length' => 250, 'null' => false, 'default' => ''),
        'model_id' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'value' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
            , 'user_id' => array('column' => 'user_id', 'unique' => 0)
            , 'model' => array('column' => array('model', 'model_id'), 'unique' => 0)
            , 'created' => array('column' => 'created', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $comments = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'model' => array('type' => 'string', 'length' => 250, 'null' => false, 'default' => ''),
        'model_id' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'comment' => array('type' => 'text', 'null' => false, 'default' => ''),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'report_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
            , 'user_id' => array('column' => 'user_id', 'unique' => 0)
            , 'model' => array('column' => array('model', 'model_id'), 'unique' => 0)
            , 'created' => array('column' => 'created', 'unique' => 0)
            , 'report_count' => array('column' => 'report_count', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $projectpayments = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'project_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'current_payment' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'total_payments' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'amount' => array('type' => 'float', 'null' => false, 'default' => NULL),
        'amount_total' => array('type' => 'float', 'null' => false, 'default' => NULL),
        'receiver_email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 500),
        'sender_email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 500),
        
        'payKey' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 500),
        'paymentExecStatus' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 500),
        
        'responseenvelope_timestamp' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 500),
        'responseEnvelope_ack' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 500),
        'responseEnvelope_correlationId' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 500),
        'responseEnvelope_build' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 500),
      
        
        'info' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'errors' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
            , 'payment_id' => array('column' => array('current_payment', 'project_id'), 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $sponsorships = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'project_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'prize_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'contribution' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        //---------
        'payer_id' => array('type' => 'string', 'length' => 250, 'null' => false, 'default' => ''),
        'receiver_id' => array('type' => 'string', 'length' => 250, 'null' => false, 'default' => ''),
        'payer_email' => array('type' => 'string', 'length' => 512, 'null' => false, 'default' => ''),
        'receiver_email' => array('type' => 'string', 'length' => 512, 'null' => false, 'default' => ''),
        //---------
        'expresscheckout_checkoutstatus' => array('type' => 'string', 'length' => 512, 'null' => false, 'default' => NULL), // EXPRESS-CHECKOUT
        'expresscheckout_transaction_id' => array('type' => 'string', 'length' => 250, 'null' => false, 'default' => ''), // EXPRESS-CHECKOUT
        'expresscheckout_token' => array('type' => 'string', 'length' => 512, 'null' => false, 'default' => ''), // EXPRESS-CHECKOUT
        'expresscheckout_status' => array('type' => 'string', 'length' => 512, 'null' => false, 'default' => ''), // EXPRESS-CHECKOUT
        'expresscheckout_response' => array('type' => 'text', 'null' => false, 'default' => ''), // EXPRESS-CHECKOUT
        //---------
        'preapproval_curpayments' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'preapproval_curpaymentsamount' => array('type' => 'float', 'null' => false, 'default' => NULL),
        'preapproval_curperiodattempts' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'preapproval_currencycode' => array('type' => 'string', 'length' => 512, 'null' => false, 'default' => ''),
        'preapproval_senderemail' => array('type' => 'string', 'length' => 512, 'null' => false, 'default' => ''),
        'preapproval_key' => array('type' => 'string', 'length' => 512, 'null' => false, 'default' => ''),
        'preapproval_approved' => array('type' => 'integer', 'length' => 1, 'null' => false, 'default' => ''),
        'preapproval_status' => array('type' => 'string', 'length' => 512, 'null' => false, 'default' => ''),
        //---------
        'masspay_receiver_email' => array('type' => 'string', 'length' => 512, 'null' => false, 'default' => ''),
        'masspay_masspay_txn_id' => array('type' => 'string', 'length' => 512, 'null' => false, 'default' => ''),
        'masspay_status' => array('type' => 'string', 'length' => 512, 'null' => false, 'default' => ''),
        'masspay_mc_currency' => array('type' => 'string', 'length' => 512, 'null' => false, 'default' => ''),
        'masspay_mc_gross' => array('type' => 'float', 'null' => false, 'default' => ''),
        'masspay_mc_fee' => array('type' => 'float', 'null' => false, 'default' => ''),
        //---------
        'payment_type' => array('type' => 'string', 'length' => 100, 'null' => false, 'default' => ''),
        'status' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'internal_status' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'transferred' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'refound' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
            , 'user_id' => array('column' => 'user_id', 'unique' => 0)
            , 'created' => array('column' => 'created', 'unique' => 0)
            , 'status' => array('column' => 'status', 'unique' => 0)
            , 'upp_ids' => array('column' => array('user_id', 'project_id', 'prize_id'), 'unique' => 0)
            , 'up_ids' => array('column' => array('user_id', 'project_id'), 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $cities = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'search_text' => array('type' => 'text', 'null' => false, 'default' => NULL, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'city' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'city_slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'city_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'city_ascii' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'admin_code' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'admin_code_ascii' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'country' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'country_slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'country_code' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'city_full_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'city_soundex' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 4, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'population' => array('type' => 'float', 'null' => false, 'default' => NULL, 'key' => 'index'),
        'search_text_other' => array('type' => 'text', 'null' => false, 'default' => NULL, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'project_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'offer_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'user_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'indexes' => array('id' => array('column' => 'id', 'unique' => 1), 'city' => array('column' => 'city', 'unique' => 0), 'admin_code' => array('column' => 'admin_code', 'unique' => 0), 'country' => array('column' => 'country', 'unique' => 0), 'country_code' => array('column' => 'country_code', 'unique' => 0), 'city_soundex' => array('column' => 'city_soundex', 'unique' => 0), 'city_2' => array('column' => array('city', 'city_soundex'), 'unique' => 0), 'population' => array('column' => 'population', 'unique' => 0), 'search_text' => array('column' => array('search_text', 'search_text_other'), 'unique' => 0), 'search_text_2' => array('column' => 'search_text', 'unique' => 0), 'search_text_other' => array('column' => 'search_text_other', 'unique' => 0)),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $links = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
        'model_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'link' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 3000),
        'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 140),
        'description' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 140),
        'media_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
            , 'model' => array('column' => array('model', 'model_id'), 'unique' => 0)
            , 'media_id' => array('column' => 'media_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
    );
    var $posts = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 70),
        'model_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 140),
        'slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
        'description' => array('type' => 'text', 'null' => false, 'default' => NULL),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'published' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'public' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1), /* is public or not ? */
        'enabled' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1), /* if Not enabled the project it's not available for anyone */
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
            , 'user_id' => array('column' => 'user_id', 'unique' => 0)
            , 'model' => array('column' => array('model', 'model_id'), 'unique' => 0)
            , 'created' => array('column' => 'created', 'unique' => 0)
            , 'slug' => array('column' => 'slug', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $messages = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'sender_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'message' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 70),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'read' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
            , 'user_id' => array('column' => 'user_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $follows = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 70),
        'model_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
            , 'user_id' => array('column' => 'user_id', 'unique' => 0)
            , 'model' => array('column' => array('model', 'model_id'), 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $projects = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'category_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'offer_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 140),
        'slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
        'short_description' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 140),
        'motivation' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 512),
        'reason' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 512),
        'description' => array('type' => 'text', 'null' => false, 'default' => NULL),
        'video_url' => array('type' => 'string', 'null' => false, 'default' => NULL),
        'video' => array('type' => 'text', 'null' => false, 'default' => NULL),
        /* -------------------------------------------------------- */ // funding information 
        'funding_goal' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'project_duration' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'minimal_pledge' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        /* -------------------------------------------------------- */ // funding information
        'city_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 22),
        'city' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
        'country' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
        'country_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2),
        /* -------------------------------------------------------- */ // Project image information
        'dirname' => array('type' => 'string', 'null' => false, 'default' => NULL),
        'basename' => array('type' => 'string', 'null' => false, 'default' => NULL),
        /* -------------------------------------------------------- */
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'publish_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
        'end_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
        /* -------------------------------------------------------- */

        'post_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'comment_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'follow_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'sponsorships_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        /* -------------------------------------------------------- */
        'payment_type' => array('type' => 'string', 'length' => 100, 'null' => false, 'default' => PREAPPROVAL),
        'important' => array('type' => 'integer', 'null' => false, 'default' => 0), // diferent payment
        'outstanding' => array('type' => 'integer', 'null' => false, 'default' => 0), // show in homepage
        'leading' => array('type' => 'integer', 'null' => false, 'default' => 0), // caso de exito
        'finished' => array('type' => 'integer', 'null' => false, 'default' => 0), // 
        'about_to_finish' => array('type' => 'integer', 'null' => false, 'default' => 0), // 
        'funded' => array('type' => 'integer', 'null' => false, 'default' => 0), // 
        
        /* -------------------------------------------------------- */
        'public' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1), /* is public or not ? */
        'enabled' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1), /* if Not enabled the project it's not available for anyone */
        'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2), /*   */
        'paypal_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 1024),
        'paypal_email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 1024),
        'transferred' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'payments_done' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'payments_log' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
            , 'user_id' => array('column' => 'user_id', 'unique' => 0)
            , 'category_id' => array('column' => 'category_id', 'unique' => 0)
            , 'offer_id' => array('column' => 'offer_id', 'unique' => 0)
            , 'city_id' => array('column' => 'city_id', 'unique' => 0)
            , 'created' => array('column' => 'created', 'unique' => 0)
            , 'slug' => array('column' => 'slug', 'unique' => 0)
            , 'status' => array('column' => array('public', 'enabled', 'status'), 'unique' => 0)
            , 'status_2' => array('column' => array('public', 'enabled'), 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $offers = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'category_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 140),
        'slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
        'short_description' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 512),
        'description' => array('type' => 'text', 'null' => false, 'default' => NULL),
        'video_url' => array('type' => 'string', 'null' => false, 'default' => NULL),
        /* -------------------------------------------------------- */
        'funds_available' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'offer_duration' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'funding_sponsorships_founds' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'offer_sponsorships' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'offer_public' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        /* -------------------------------------------------------- */
        'city_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 22),
        'city' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
        'country' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
        'country_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2),
        /* -------------------------------------------------------- */
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'publish_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
        'end_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
        /* -------------------------------------------------------- */
        'post_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'comment_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'project_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'follow_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        /* -------------------------------------------------------- */
        'public' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1), /* is public or not ? */
        'enabled' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1), /* if Not enabled the project it's not available for anyone */
        'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2), /*   */
        'outstanding' => array('type' => 'integer', 'null' => false, 'default' => 0), // show in homepage
        'leading' => array('type' => 'integer', 'null' => false, 'default' => 0), // caso de exito
        'finished' => array('type' => 'integer', 'null' => false, 'default' => 0), // 
        'about_to_finish' => array('type' => 'integer', 'null' => false, 'default' => 0), // 
        /* -------------------------------------------------------- */
        'dirname' => array('type' => 'string', 'null' => false, 'default' => NULL),
        'basename' => array('type' => 'string', 'null' => false, 'default' => NULL),
        /* -------------------------------------------------------- */
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
            , 'user_id' => array('column' => 'user_id', 'unique' => 0)
            , 'category_id' => array('column' => 'category_id', 'unique' => 0)
            , 'city_id' => array('column' => 'city_id', 'unique' => 0)
            , 'created' => array('column' => 'created', 'unique' => 0)
            , 'slug' => array('column' => 'slug', 'unique' => 0)
            , 'status' => array('column' => array('public', 'enabled', 'status'), 'unique' => 0)
            , 'status_2' => array('column' => array('public', 'enabled'), 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $users = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'username' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'slug' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
        'display_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 256),
        // 'firstname' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 256),
// 'lastname' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 256),
        'biography' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'birthday' => array('type' => 'date', 'null' => true, 'default' => NULL),
        'gender' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'timezone' => array('type' => 'integer', 'null' => true, 'default' => NULL),
        /**/
        'dirname' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 1024),
        'basename' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 1024),
        /**/
        'city_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 22),
        'city' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
        'country' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
        'country_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 2),
        /**/
        'facebook_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
        'email' => array('type' => 'string', 'null' => false, 'default' => NULL),
        'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128),
        'password_confirmation' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128),
        /**/
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        /* - */
        'follow_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'follow_offer_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'project_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'project_proposal_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'offer_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'offer_proposal_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'message_count' => array('type' => 'integer', 'null' => false, 'default' => 0), // count new messages for this user..
        'report_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'sponsorships_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'score' => array('type' => 'integer', 'null' => false, 'default' => 0),
        /* - */
        'confirmed' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
        'active' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
        'enabled' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
        'level' => array('type' => 'integer', 'null' => false, 'default' => '0'),
        'admin' => array('type' => 'integer', 'null' => false, 'default' => '0'),
        /* - */

        /* - */
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
            , 'city_id' => array('column' => 'city_id', 'unique' => 0)
            , 'created' => array('column' => 'created', 'unique' => 0)
            , 'slug' => array('column' => 'slug', 'unique' => 0)
            , 'status' => array('column' => array('confirmed', 'active', 'enabled'), 'unique' => 0)
            , 'status_2' => array('column' => array('confirmed', 'enabled'), 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
    );
    var $prizes = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
        'model_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'value' => array('type' => 'integer', 'null' => true, 'default' => NULL),
        'description' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 140),
        'bakes_count' => array('type' => 'integer', 'null' => true, 'default' => 0),
        'sponsorships_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
            , 'model' => array('column' => array('model', 'model_id'), 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $users_projects = array(
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'project_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => array('user_id', 'project_id'), 'unique' => 1), 'user_id' => array('column' => 'user_id', 'unique' => 0), 'project_id' => array('column' => 'project_id', 'unique' => 0)),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $users_offers = array(
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'offer_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => array('user_id', 'offer_id'), 'unique' => 1), 'user_id' => array('column' => 'user_id', 'unique' => 0), 'offer_id' => array('column' => 'offer_id', 'unique' => 0)),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $categories = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
        'slug' => array('type' => 'string', 'null' => false, 'default' => NULL),
        'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
        'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL),
        'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL),
        'project_count' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'offer_count' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 22),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
            , 'slug' => array('column' => 'slug', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
    );
    var $notifications = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'notificationtype_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
        'model_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'owner_id' => array('type' => 'integer', 'null' => false, 'default' => NULL), // who creates the action
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL), // who is related to the action.
        'data' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        //  'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        /* ------------------------------------------------------------------------------------------ */
//  'user_status' => array('type' => 'integer', 'null' => false, 'default' => NULL), //
//  'activity_status' => array('type' => 'integer', 'null' => false, 'default' => NULL), //
//  'message_status' => array('type' => 'integer', 'null' => false, 'default' => NULL), //
//  'email_status' => array('type' => 'integer', 'null' => false, 'default' => NULL), //
//  'email_attempts' => array('type' => 'integer', 'null' => false, 'default' => NULL), //
        /* ------------------------------------------------------------------------------------------ */

        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
    );
    var $notificationtypes = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'model' => array('type' => 'string', 'null' => false, 'default' => NULL),
        'related_model' => array('type' => 'string', 'null' => false, 'default' => NULL),
        'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
        'description' => array('type' => 'string', 'null' => false, 'default' => NULL),
        'user_feed' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1), // se muestra en /profile/:user/activity 
        'activity_feed' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1), // se muestra en /my-activity 

        'notification' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1), // no se usa...
        'email_owner' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1),
        'email_user' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1),
        'email_user_type2' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1),
        'disableable' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $notificationtype_users = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1),
        'notificationtype_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $staticpages = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 140),
        'slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
        'subtitle' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 280),
        'content' => array('type' => 'text', 'null' => false, 'default' => NULL),
        'section' => array('type' => 'string', 'null' => false, 'default' => 'footer', 'length' => 50),
        'template' => array('type' => 'string', 'null' => false, 'default' => 'default', 'length' => 50),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'slug' => array('column' => 'slug', 'unique' => 0)),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $searches = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'searchtext' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 5000),
        'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 70),
        'model_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
            , 'model' => array('column' => array('model', 'model_id'), 'unique' => 0)
            , 'searchtext' => array('column' => 'searchtext', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );
    var $mails = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'to' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 500),
        'subject' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 500),
        'template' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 500),
        'data' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'user' => array('type' => 'text', 'null' => true, 'default' => NULL),
        'notification_id' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'sent' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'errors' => array('type' => 'integer', 'null' => false, 'default' => 0),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
    );

}

?>