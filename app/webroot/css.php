<?php

/**
 * CSS helping functions
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
 * @subpackage    cake.app.webroot
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
if (!defined('CAKE_CORE_INCLUDE_PATH')) {
    header('HTTP/1.1 404 Not Found');
    exit('File Not Found');
}

/**
 * Ensure required classes are available.
 */
if (!class_exists('File')) {
    uses('file');
}

/**
 * Make clean CSS
 *
 * @param unknown_type $path
 * @param unknown_type $name
 * @return unknown
 */
function make_clean_css_old($path, $name) {
    App::import('Vendor', 'csspp' . DS . 'csspp');
    $data = file_get_contents($path);
    $csspp = new csspp();
    $output = $csspp->compress($data);
    $ratio = 100 - (round(strlen($output) / strlen($data), 3) * 100);
    //     $output = " /* file: $name, ratio: $ratio% */ " . $output;
    return $output;
}

function make_clean_css($path, $name) {
    App::import('Vendor', 'csspp' . DS . 'csspp');
    $data = file_get_contents($path);
    $csspp = new csspp($name, '');
    $output = $csspp->process();

    // assets server
    $output = str_replace('ui/images', ASSETS_SERVER . 'img/ui', $output);
    $output = preg_replace('/(\.\.\/*)*img\//', '/img/', $output);
    $output = str_replace('/img/static', ASSETS_SERVER . '/img/static', $output);
    $output = str_replace('/img/assets', ASSETS_SERVER . '/img/assets', $output);
    $output = str_replace('/' . ASSETS_SERVER, ASSETS_SERVER, $output);




    $ratio = 100 - (round(strlen($output) / strlen($data), 3) * 100);
    //  $output = " /* file: $name, ratio: $ratio% */ " . $output;

    return $output;
}

/**
 * Write CSS cache
 *
 * @param unknown_type $path
 * @param unknown_type $content
 * @return unknown
 */
function write_css_cache($path, $content) {
    if (!is_dir(dirname($path))) {
        mkdir(dirname($path));
    }
    $cache = new File($path);
    return $cache->write($content);
}

// die($url);



    if (preg_match('|\.\.|', $url) || !preg_match('|^ccss/(.+)$|i', $url, $regs)) {
        $url = preg_replace('|ccss/|i', 'css/', $url);
        $filename = $url;
        $filepath = $url;
        $cachepath = CACHE . 'css' . DS . str_replace(array('/', '\\'), '-', $url);
        $parse = false ;
    } else {
        $filename = 'css/' . $regs[1];
        $filepath = CSS.$regs[1];
        $cachepath = CACHE . 'css' . DS . str_replace(array('/', '\\'), '-', $regs[1]);
        $parse = true ;
    }


if (!file_exists($filepath)) {
    die("Wrong file name. $filepath");
}
/*
$HTTP_ACCEPT_ENCODING = $_SERVER['HTTP_ACCEPT_ENCODING'];

if (headers_sent()) {
    $encoding = '';
     }elseif( strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false ){
         $encoding = 'x-gzip';
     }elseif( strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false ){
         $encoding = 'gzip';
} else {
    $encoding = '';
}
*/
$encoding = '';
//$encoding = '' ;
$cachepath = str_replace('.css', '', $cachepath) . $encoding . '.css';

if (file_exists($cachepath) && false ) { //
    $templateModified = filemtime($filepath);
    $cacheModified = filemtime($cachepath);

    if ( $templateModified > $cacheModified  ) {
        $output = make_clean_css($filepath, $filename);
        if ($encoding != '') {
            $size = strlen($output);
            $output = gzcompress($output, 9);
        //    $output = substr($output, 0, $size);
        }
        write_css_cache($cachepath, $output);
    } else {
        $output = file_get_contents($cachepath);
    }
} elseif ($parse) {
    $output = make_clean_css($filepath, $filename);
    if ($encoding != '') {
        $size = strlen($output);
        $encoding = '';
        $output = gzcompress($output, 9);
        $output = substr($output, 0, $size); // ?? 
    }
    write_css_cache($cachepath, $output);
    $templateModified = time();
} else {
    $output = file_get_contents($filepath);
    $templateModified = time();
}
/*
  header("Date: " . date("D, j M Y G:i:s ", $templateModified) . 'GMT');
  header("Content-Type: text/css");
  header("Expires: " . gmdate("D, d M Y H:i:s", time() + DAY) . " GMT");
  header("Cache-Control: max-age=86400, must-revalidate"); // HTTP/1.1
  header("Pragma: cache");        // HTTP/1.0
  print $output;
 */


header("Date: " . date("D, j M Y G:i:s", $templateModified) . " GMT");
header("Content-Type: text/css");
header("Expires: " . gmdate("D, j M Y H:i:s", time() + DAY * 45) . " GMT");
header("Cache-Control: max-age=" . (DAY * 45) . ", must-revalidate"); // HTTP/1.1
header("Pragma: cache_asset");        // HTTP/1.0
// var_dump($_SERVER);
if ($encoding != '') {
    header('Content-Encoding: ' . $encoding);
    print "\x1f\x8b\x08\x00\x00\x00\x00\x00";
    print($output);
} else {
    print $output;
}