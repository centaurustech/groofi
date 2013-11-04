<?php
function testcropadmin(){



/** Copyright (c) 2008 http://www.webmotionuk.com / http://www.webmotionuk.co.uk
* "Jquery image upload & crop for php"
* Date: 2008-11-21
* Ver 1.0
* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
* ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
* IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
* INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
* PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
* INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
* STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF
* THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* http://www.opensource.org/licenses/bsd-license.php
*/
#########################################################################################################
# CONSTANTS																								#
# You can alter the options below																		#
#########################################################################################################
//$_FILES['data']['name']['Project']['file'] = $_FILES;

//var_dump($_FILES);

$upload_dir = "../webroot/upload_sponsors";

$upload_path = $upload_dir."/";				// The path to where the image will be saved
//$image_handling_file = "vendors/crop/image_handling.php"; // The location of the file that will handle the upload and resizing (RELATIVE PATH ONLY!)
$large_image_prefix = "resize_"; 			// The prefix name to large image
$thumb_image_prefix = "thumbnail_";			// The prefix name to the thumb image
$large_image_name = $large_image_prefix.$_SESSION['random_key'];     // New name of the large image (append the timestamp to the filename)
$thumb_image_name = $thumb_image_prefix.$_SESSION['random_key'];     // New name of the thumbnail image (append the timestamp to the filename)
$max_file = "1"; 							// Maximum file size in MB
$max_width = "500";							// Max width allowed for the large image
$thumb_width = "250";						// Width of thumbnail image
$thumb_height = "100";						// Height of thumbnail image
// Only one of these image types should be allowed for upload
$allowed_image_types = array('image/pjpeg'=>"jpg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png",'image/x-png'=>"png",'image/gif'=>"gif");
$allowed_image_ext = array_unique($allowed_image_types); // Do not change this
$image_ext = "";
foreach ($allowed_image_ext as $mime_type => $ext) {
$image_ext.= strtoupper($ext)." ";
}


##########################################################################################################
# IMAGE FUNCTIONS																						 #
# You do not need to alter these functions																 #
##########################################################################################################
function resizeImage($image,$width,$height,$scale) {
$image_data = getimagesize($image);
$imageType = image_type_to_mime_type($image_data[2]);
$newImageWidth = ceil($width * $scale);
$newImageHeight = ceil($height * $scale);
$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
switch($imageType) {
case "image/gif":
$source=imagecreatefromgif($image);
break;
case "image/pjpeg":
case "image/jpeg":
case "image/jpg":
$source=imagecreatefromjpeg($image);
break;
case "image/png":
case "image/x-png":
$source=imagecreatefrompng($image);
break;
}
imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);

switch($imageType) {
case "image/gif":
imagegif($newImage,$image);
break;
case "image/pjpeg":
case "image/jpeg":
case "image/jpg":
imagejpeg($newImage,$image,90);
break;
case "image/png":
case "image/x-png":
imagepng($newImage,$image);
break;
}

chmod($image, 0777);
return $image;
}
//You do not need to alter these functions
function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
list($imagewidth, $imageheight, $imageType) = getimagesize($image);
$imageType = image_type_to_mime_type($imageType);

$newImageWidth = ceil($width * $scale);
$newImageHeight = ceil($height * $scale);
$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
switch($imageType) {
case "image/gif":
$source=imagecreatefromgif($image);
break;
case "image/pjpeg":
case "image/jpeg":
case "image/jpg":
$source=imagecreatefromjpeg($image);
break;
case "image/png":
case "image/x-png":
$source=imagecreatefrompng($image);
break;
}
imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
switch($imageType) {
case "image/gif":
imagegif($newImage,$thumb_image_name);
break;
case "image/pjpeg":
case "image/jpeg":
case "image/jpg":
imagejpeg($newImage,$thumb_image_name,90);
break;
case "image/png":
case "image/x-png":
imagepng($newImage,$thumb_image_name);
break;
}
chmod($thumb_image_name, 0777);
return $thumb_image_name;
}
//You do not need to alter these functions
function getHeight($image) {
$size = getimagesize($image);
$height = $size[1];
return $height;
}
//You do not need to alter these functions
function getWidth($image) {
$size = getimagesize($image);
$width = $size[0];
return $width;
}

//Image Locations
$large_image_location = $upload_path.$large_image_name;
$thumb_image_location = $upload_path.$thumb_image_name;


//Create the upload directory with the right permissions if it doesn't exist
if(!is_dir($upload_dir)){
mkdir($upload_dir, 0777);
chmod($upload_dir, 0777);
}


error_reporting (E_ALL ^ E_NOTICE);
/*
* Copyright (c) 2008 http://www.webmotionuk.com / http://www.webmotionuk.co.uk
* "Jquery image upload & crop for php"
* Date: 2008-11-21
* Ver 1.0
* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
* ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
* IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
* INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
* PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
* INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
* STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF
* THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* http://www.opensource.org/licenses/bsd-license.php
*/
#################################################################################################
#	IMAGE FUNCTIONS FILE  - Adjust directory as required									   	#
#	Please also adjust the directory to this file in the "index.php" page						#
//include("vendors/crop/image_functions.php"); 									#
#################################################################################################

########################################################
#	UPLOAD THE IMAGE								   #
########################################################
if ($_POST["upload"]=="Upload") {
//Get the file information
$userfile_name = $_FILES['image']['name'];
$userfile_tmp = $_FILES['image']['tmp_name'];
$userfile_size = $_FILES['image']['size'];
$userfile_type = $_FILES['image']['type'];
$filename = basename($_FILES['image']['name']);
$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));

//Only process if the file is a JPG and below the allowed limit
if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {

foreach ($allowed_image_types as $mime_type => $ext) {
//loop through the specified image types and if they match the extension then break out
//everything is ok so go and check file size
if($file_ext==$ext && $userfile_type==$mime_type){
$error = "";
break;
}else{
$error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
}
}
//check if the file size is above the allowed limit
if ($userfile_size > ($max_file*3048576)) {
$error.= "Images must be under ".$max_file."MB in size";
}

}else{
$error= "Please select an image for upload";
}
//Everything is ok, so we can upload the image.
if (strlen($error)==0){

if (isset($_FILES['image']['name'])){
//this file could now has an unknown file extension (we hope it's one of the ones set above!)
$large_image_location = $large_image_location.".".$file_ext;
$thumb_image_location = $thumb_image_location.".".$file_ext;

//put the file ext in the session so we know what file to look for once its uploaded
if($_SESSION['user_file_ext']!=$file_ext){
$_SESSION['user_file_ext']="";
$_SESSION['user_file_ext']=".".$file_ext;
}

move_uploaded_file($userfile_tmp, $large_image_location);
chmod($large_image_location, 0777);

$width = getWidth($large_image_location);
$height = getHeight($large_image_location);
//Scale the image if it is greater than the width set above
if ($width > $max_width){
$scale = $max_width/$width;
$uploaded = resizeImage($large_image_location,$width,$height,$scale);
}else{
$scale = 1;
$uploaded = resizeImage($large_image_location,$width,$height,$scale);
}
//Delete the thumbnail file so the user can create a new one
if (file_exists($thumb_image_location)) {
unlink($thumb_image_location);
}
$json = array('regular' => array("ubicacion"=>$large_image_location,"width"=>getWidth($large_image_location), "height"=>getHeight($large_image_location)),'thumbs' => array("ubicacion"=>$thumb_image_location,"width"=>getWidth($thumb_image_location), "height"=>getHeight($thumb_image_location)));
echo json_encode($json);

//echo "success|".$large_image_location."|".getWidth($large_image_location)."|".getHeight($large_image_location)."|".$thumb_image_location;
}
}else{
echo "error|".$error;
}
}

########################################################
#	CREATE THE THUMBNAIL							   #
########################################################
if ($_POST["save_thumb"]=="Save Thumbnail") {

//Get the new coordinates to crop the image.
$x1 = $_POST["x1"];
$y1 = $_POST["y1"];
$x2 = $_POST["x2"];
$y2 = $_POST["y2"];
$w = $_POST["w"];
$h = $_POST["h"];
//Scale the image to the thumb_width set above
$large_image_location = $large_image_location.$_SESSION['user_file_ext'];
$thumb_image_location = $thumb_image_location.$_SESSION['user_file_ext'];
$scale = $thumb_width/$w;



$cropped1 = resizeThumbnailImage('../webroot/upload_sponsors/'.$thumb_image_prefix.$_SESSION['random_key'].'.png', $large_image_location,336,121,$x1,$y1,1);


echo "success|".$large_image_location."|".$thumb_image_location;
$_SESSION['random_key']= "";
$_SESSION['user_file_ext']= "";
}

#####################################################
#	DELETE BOTH IMAGES								#
#####################################################
if ($_POST['a']=="delete" && strlen($_POST['large_image'])>0 && strlen($_POST['thumbnail_image'])>0){
//get the file locations
$large_image_location = $_POST['large_image'];
$thumb_image_location = $_POST['thumbnail_image'];
if (file_exists($large_image_location)) {
unlink($large_image_location);
}
if (file_exists($thumb_image_location)) {
unlink($thumb_image_location);
}
echo "success|Files have been deleted";
}
$this->autoRender=false;
//$this->redirect(array('controller' => 'projects', 'action' => 'index', 'admin' => true));
}
?>