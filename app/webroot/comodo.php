<?php
$extension200=end(explode(".",strtolower($_GET['imagen'])));
if($extension200!='jpg' && $extension200!='gif' && $extension200!='png' && $extension200!='jpeg'){
exit;
}
define('MAX_ANCHO', 477);
define('MAX_ALTO', 357);
$nombre=$_GET['imagen'];
$datos = getimagesize($nombre); 
if($datos[0]<=MAX_ANCHO && $datos[1]<=MAX_ALTO){
echo file_get_contents($nombre);
if($datos[2]==1){header("Content-type: image/gif"); } 
elseif($datos[2]==2){header("Content-type: image/jpeg");} 
else{header("Content-type: image/png"); } 
exit;
}
if($datos[2]==1){
	$img = @imagecreatefromgif($nombre);
	
} 
elseif($datos[2]==2){$img = @imagecreatefromjpeg($nombre);} 
elseif($datos[2]==3){
	$img = @imagecreatefrompng($nombre);
	
}else{die("formato de imagen no aceptado");} 
$scale = min(MAX_ANCHO/$datos[0], MAX_ALTO/$datos[1]);
$anchura = floor($scale*$datos[0]);
$altura = floor($scale*$datos[1]);
$thumb = imagecreatetruecolor($anchura,$altura);
//imagecolortransparent($thumb, imagecolorallocate($thumb, 0, 0, 0));
imagealphablending($thumb, false);
imagesavealpha($thumb,true);
$transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
imagefilledrectangle($thumb, 0, 0, $anchura, $altura, $transparent);

imagecopyresampled ($thumb, $img, 0, 0, 0, 0, $anchura, $altura, $datos[0], $datos[1]); 
if($datos[2]==1){header("Content-type: image/gif"); imagegif($thumb);} 
elseif($datos[2]==2){header("Content-type: image/jpeg");imagejpeg($thumb);} 
else{header("Content-type: image/png");imagepng($thumb); } 
imagedestroy($thumb);
?>