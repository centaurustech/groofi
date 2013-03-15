<?php
header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT'); 
extract($_GET);
/* Configurar longitud del lado del cuadrado de cropeo:
--------------------------------
*/
$anchura=120;
/*
--------------------------------
Fin de Configuración
*/
$hmax=$anchura;
$image_filename=$imagen;
list($ow, $oh,$tipo) = getimagesize($image_filename);
if($tipo==1){$big  = @imagecreatefromgif($image_filename);
} 
elseif($tipo==2){$big  = @imagecreatefromjpeg($image_filename);} 
elseif($tipo==3){$big  = @imagecreatefrompng($image_filename);}else{die("formato de imagen no aceptado");}
$thumb = imagecreatetruecolor($anchura,$hmax);
//imagecolortransparent($thumb, imagecolorallocate($thumb, 0, 0, 0));

if ($ow > $oh) {
   $off_w = ($ow-$oh)/2;
   $off_h = 0;
   $ow = $oh;
} elseif ($oh > $ow) {
   $off_w = 0;
   $off_h = ($oh-$ow)/2;
   $oh = $ow;
} else {
   $off_w = 0;
   $off_h = 0;
}
imagealphablending($thumb, false);
imagesavealpha($thumb,true);
$transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
imagefilledrectangle($thumb, 0, 0, $anchura, $anchura, $transparent);

imagecopyresampled($thumb, $big, 0, 0, $off_w, $off_h, $anchura, $hmax, $ow, $oh); 

if($tipo==1){header("Content-type: image/gif"); imagegif($thumb);} 
elseif($tipo==2){header("Content-type: image/jpeg");imagejpeg($thumb);} 
else{header("Content-type: image/png");imagepng($thumb); } 
imagedestroy($thumb);

?>