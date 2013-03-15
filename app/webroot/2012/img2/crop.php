<?php 
function createImage($anchura,$imagen){
$hmax=$anchura;
$image_filename=$imagen;
list($ow, $oh,$tipo) = getimagesize($image_filename);
if($tipo==1){$big  = @imagecreatefromgif($image_filename);} 
elseif($tipo==2){$big  = @imagecreatefromjpeg($image_filename);} 
elseif($tipo==3){$big  = @imagecreatefrompng($image_filename);}else{die("formato de imagen no aceptado");}
$thumb = imagecreatetruecolor($anchura,$hmax);
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
imagecopyresampled($thumb, $big, 0, 0, $off_w, $off_h, $anchura, $hmax, $ow, $oh); 
$black = imagecolorallocate($thumb, 0, 0, 0);
imagerectangle($thumb,0,0,($anchura-1),($hmax-1),$black);
if($tipo==1){ imagegif($thumb,$imagen);} 
elseif($tipo==2){imagejpeg($thumb,$imagen);} 
else{imagepng($thumb,$imagen); } 
imagedestroy($thumb);
}
foreach(glob("../img/*.jpg") as $k=> $v){
	createImage(50,$v);
	//echo '<br>'.$v;
}
echo listo;
?>