<?php
/**
 * Index
 *
 * The Front Controller for handling every request
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
/**
 * Use the DS to separate the directories in other defines
 */
	if (!defined('DS')) {
		define('DS', DIRECTORY_SEPARATOR);
	}
/**
 * These defines should only be edited if you have cake installed in
 * a directory layout other than the way it is distributed.
 * When using custom settings be sure to use the DS and do not add a trailing DS.
 */

/**
 * The full path to the directory which holds "app", WITHOUT a trailing DS.
 *
 */
	if (!defined('ROOT')) {
		define('ROOT', dirname(dirname(dirname(__FILE__))));
	}
/**
 * The actual directory name for the "app".
 *
 */
	if (!defined('APP_DIR')) {
		define('APP_DIR', basename(dirname(dirname(__FILE__))));
	}
/**
 * The absolute path to the "cake" directory, WITHOUT a trailing DS.
 *
 */
	if (!defined('CAKE_CORE_INCLUDE_PATH')) {
		define('CAKE_CORE_INCLUDE_PATH', ROOT);
	}

/**
 * Editing below this line should NOT be necessary.
 * Change at your own risk.
 *
 */
	if (!defined('WEBROOT_DIR')) {
		define('WEBROOT_DIR', basename(dirname(__FILE__)));
	}
	if (!defined('WWW_ROOT')) {
		define('WWW_ROOT', dirname(__FILE__) . DS);
	}
	if (!defined('CORE_PATH')) {
		if (function_exists('ini_set') && ini_set('include_path', CAKE_CORE_INCLUDE_PATH . PATH_SEPARATOR . ROOT . DS . APP_DIR . DS . PATH_SEPARATOR . ini_get('include_path'))) {
			define('APP_PATH', null);
			define('CORE_PATH', null);
		} else {
			define('APP_PATH', ROOT . DS . APP_DIR . DS);
			define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
		}
	}
	if (!include(CORE_PATH . 'cake' . DS . 'bootstrap.php')) {
		trigger_error("CakePHP core could not be found.  Check the value of CAKE_CORE_INCLUDE_PATH in APP/webroot/index.php.  It should point to the directory containing your " . DS . "cake core directory and your " . DS . "vendors root directory.", E_USER_ERROR);
	}
	
if(App::import('Core','Session')) { 
   $session = new CakeSession(); 
   $session->start(); 
} 
include '../config/site/groofi__database.php';
$db=new DATABASE_CONFIG;
mysql_connect($db->default['host'],$db->default['login'],$db->default['password']);
mysql_select_db($db->default['database']);

if ( !function_exists('json_decode') ){
    function json_decode($json){
		$comment = false;
    	$out = '$x=';
   
    	for ($i=0; $i<strlen($json); $i++)
    	{
        	if (!$comment)
        	{
           	 if ($json[$i] == '{')        $out .= ' array(';
            else if ($json[$i] == '}')    $out .= ')';
            else if ($json[$i] == ':')    $out .= '=>';
            else                         $out .= $json[$i];           
        	}
        	else $out .= $json[$i];
        	if ($json[$i] == '"')    $comment = !$comment;
    	}
    eval($out . ';');
	$ret=new stdClass;
	foreach ($x as $k=>$v){
			$ret->$k=$v;
	}
    return $ret; 
	}
}
function js_encode($s){  
    $texto='';
    $lon=strlen($s);
    for($i=0;$i<$lon;++$i){
        $num=ord($s[$i]);
        if($num<16) $texto.='\x0'.dechex($num);
        else $texto.='\x'.dechex($num);
    }
    return $texto;
}
function resize($im,$MAX_ANCHO,$MAX_ALTO,$name){
	$datos = getimagesize($im); 
	if($datos[0]<=$MAX_ANCHO && $datos[1]<=$MAX_ALTO){
		file_put_contents($name,implode('',file($im)));
		return;
	}
	if($datos[2]==1){
		$img = @imagecreatefromgif($im);
	}elseif($datos[2]==2){
		$img = @imagecreatefromjpeg($im);
	}elseif($datos[2]==3){
		$img = @imagecreatefrompng($im);
	}else{
		return;
	} 
	$scale = min($MAX_ANCHO/$datos[0], $MAX_ALTO/$datos[1]);
	$anchura = floor($scale*$datos[0]);
	$altura = floor($scale*$datos[1]);
	$thumb = imagecreatetruecolor($anchura,$altura); 
	imagealphablending($thumb, false);
	imagesavealpha($thumb,true);
	//$transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
	//imagefilledrectangle($thumb, 0, 0, $anchura, $altura, $transparent);
	imagecopyresampled ($thumb, $img, 0, 0, 0, 0, $anchura, $altura, $datos[0], $datos[1]); 
	if($datos[2]==1){
		imagegif($thumb,$name);
	}elseif($datos[2]==2){
		imagejpeg($thumb,$name,90);
	}else{
		imagepng($thumb,$name);
	} 
	imagedestroy($thumb);
}
function getCodeFromURL($u){
	$code=end(explode('v=',$u));
	$code=end(explode('/',$code));
	if(strpos($code, '&')!==false){
		$code=explode('&',$code);
		$code=$code[0];
	}
	return $code;
}
switch($_REQUEST['proceso']){
	case 'weekProject':
	if(!isset($_SESSION['Admin']))exit;
	$data=json_decode(stripslashes($_REQUEST['json']));
	$week=$data->checked;
	$id= $data->projectId;
	$qry=mysql_query("update projects set week='$week' where id=$id");
	break;
	case 'weekOffer':
	if(!isset($_SESSION['Admin']))exit;
	$data=json_decode($_REQUEST['json']);
	$week=$data->checked;
	$id= $data->projectId;
	$qry=mysql_query("update offers set week='$week' where id=$id");
	break;
	case 'saveVideo':
	if(!isset($_SESSION['Admin']))exit;
	$_REQUEST['json']=str_replace("\'",'"',$_REQUEST['json']);
	$_REQUEST['json']=str_replace("'",'"',$_REQUEST['json']);
	$data=json_decode($_REQUEST['json']);
	$id= $data->projectId;
	$tipo= $data->tipo;
	$videoId= $data->videoId;
	$videoId= getCodeFromURL($videoId);//por las dudas
    $qry=mysql_query("update projects set videoid='$videoId', videotype='$tipo' where id=$id");
	
    if($tipo=='youtube'){
		echo "<script>top._('videocaso".$id."').innerHTML='<p><h3 style=\"clear:both; color:#000; padding-top:10px\">Video del caso:</h3><iframe width=\"400\" height=\"225\" src=\"http://www.youtube.com/embed/".$videoId."\" frameborder=\"0\" allowfullscreen></iframe></p>';top._('bglightbox2').style.display=top._('addVideo').style.display='none';var l=top.losifrs.length;for(var i=0;i<l;i++)top.losifrs[i].style.visibility='visible';</script>";
	}else{
		echo "<script>top._('videocaso".$id."').innerHTML='<p><h3 style=\"clear:both; color:#000; padding-top:10px\">Video del caso:</h3><iframe src=\"http://player.vimeo.com/video/".$videoId."\" width=\"400\" height=\"225\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></p>';top._('bglightbox2').style.display=top._('addVideo').style.display='none';var l=top.losifrs.length;for(var i=0;i<l;i++)top.losifrs[i].style.visibility='visible';</script>";
	}
	break;
	
	case 'crearpredefinido':
	$imagen='';
	if(isset($_FILES['foto']['name']) && $_FILES['foto']['name']!=''){
		$archivo=$_FILES['foto']['name'];
		$archivotemp=$_FILES['foto']['tmp_name'];
		$dir='medio/';
		$foto2=md5(uniqid(rand())).time().'.jpg';
		$extension200=end(explode(".",strtolower($archivo)));
			if($extension200!='jpg' && $extension200!='gif' && $extension200!='png' && $extension200!='jpeg'){
				echo '<script>
				parent.alert("El formato del archivo seleccionado es incorrecto");
				</script>';
				exit;
			}
			if(($_FILES["foto"]["size"] / 1024/1024) > 1){
				echo '<script>
				parent.alert("El tama&ntilde;o del archivo no puede ser mayor que 1 MB");
				</script>';
				exit;
			}
			resize($archivotemp,720,720,$dir.$foto2);
			$imagen=$dir.$foto2;
	}
	$qry=mysql_query("
					 insert into predefinidos 
					 (
					  category_id,
					  title,
					  description,
					  funding_goal,
					  foto,
					  video,
					  reason,
					  moneda,
					  motivation,
					  short_description,
					  project_duration
					  ) values 
					 (
					  '{$_REQUEST['category_id']}',
					  '{$_REQUEST['title']}',
					  '{$_REQUEST['la_description']}',
					  '{$_REQUEST['funding_goal']}',
					  '$imagen',
					  '{$_REQUEST['video']}',
					  '{$_REQUEST['reason']}',
					  '{$_REQUEST['moneda']}',
					  '{$_REQUEST['motivation']}',
					  '{$_REQUEST['short_description']}',
					  '{$_REQUEST['project_duration']}'
					  )");
	$id=mysql_insert_id();
	
	for($i=0;$i<count($_POST['value']);$i++){
		mysql_query("insert into prizes 
					(
					 value,
					 description,
					 model,
					 model_id,
					 ente
					 ) values 
					(
					 '".$_POST['value'][$i]."',
					 '".$_POST['description'][$i]."',
					'".$_POST['model'][$i]."',
					'".$id."',
					 '".$_POST['ente'][$i]."'
					 )");
		
	}
	echo '<script>top.location="/admin/predefinidos/list";</script>';
	exit;
	break;
	case 'modificarpredefinido':
	$qry=mysql_query("
					 update predefinidos 
					 set 
					 category_id='{$_REQUEST['category_id']}',
					  title= '{$_REQUEST['title']}',
					  description='{$_REQUEST['la_description']}',
					  funding_goal='{$_REQUEST['funding_goal']}',
					  video='{$_REQUEST['video']}',
					  reason='{$_REQUEST['reason']}',
					  moneda='{$_REQUEST['moneda']}',
					  motivation='{$_REQUEST['motivation']}',
					  short_description='{$_REQUEST['short_description']}',
					  project_duration='{$_REQUEST['project_duration']}'
					  where 
					  id='{$_REQUEST['id']}'
					  ") or die(mysql_error());
	if(isset($_FILES['foto']['name']) && $_FILES['foto']['name']!=''){
		$archivo=$_FILES['foto']['name'];
		$archivotemp=$_FILES['foto']['tmp_name'];
		$dir='medio/';
		$foto2=md5(uniqid(rand())).time().'.jpg';
		$extension200=end(explode(".",strtolower($archivo)));
			if($extension200!='jpg' && $extension200!='gif' && $extension200!='png' && $extension200!='jpeg'){
				echo '<script>
				parent.alert("El formato del archivo seleccionado es incorrecto");
				</script>';
				exit;
			}
			if(($_FILES["foto"]["size"] / 1024/1024) > 1){
				echo '<script>
				parent.alert("El tama&ntilde;o del archivo no puede ser mayor que 1 MB");
				</script>';
				exit;
			}
			resize($archivotemp,720,720,$dir.$foto2);
			$imagen=$dir.$foto2;
			$qry=mysql_query("
					 update predefinidos 
					 set foto='$imagen'  where 
					  id='{$_REQUEST['id']}'");
	}
	$qry=mysql_query("delete from prizes where model_id='{$_REQUEST['id']}' and model='Predefinido'");
	for($i=0;$i<count($_POST['value']);$i++){
		mysql_query("insert into prizes 
					(
					 value,
					 description,
					 model,
					 model_id,
					 ente
					 ) values 
					(
					 '".$_POST['value'][$i]."',
					 '".$_POST['description'][$i]."',
					'".$_POST['model'][$i]."',
					'".$_REQUEST['id']."',
					 '".$_POST['ente'][$i]."'
					 )");
		
	}
	echo '<script>top.location="/admin/predefinidos/list";</script>';
	exit;
	break;
	case 'borrarPredefinido':
	$qry=mysql_query("delete from prizes where model_id='{$_REQUEST['id']}' and model='Predefinido'");
	$qry=mysql_query("delete from predefinidos where id='{$_REQUEST['id']}'");
	echo '<script>top.location="/admin/predefinidos/list";</script>';
	exit;
	break;
}

?>