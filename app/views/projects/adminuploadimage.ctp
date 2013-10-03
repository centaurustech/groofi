
<?php

$this->set('pageTitle' , __("Browse_sponsor",$return = true));
$this->set('title_for_layout' ,__("Browse_sponsor",$return = true));
echo $this->Html->script('jquery.imgareaselect.min');
echo $this->Html->script('jquery.ocupload-packed');


//session_start(); //Do not remove this
//only assign a new timestamp if the session variable is empty
if (!isset($_SESSION['random_key']) || strlen($_SESSION['random_key'])==0){
    $_SESSION['random_key'] = strtotime(date('Y-m-d H:i:s')); //assign the timestamp to the session variable
    $_SESSION['user_file_ext']= "";
}
#########################################################################################################
# CONSTANTS																								#
# You can alter the options below																		#
#########################################################################################################

$upload_dir = "../webroot/upload_sponsors"; 				// The directory for the images to be saved in
$upload_path = $upload_dir."/";				// The path to where the image will be saved
//$image_handling_file = "vendors/crop/image_handling.php"; // The location of the file that will handle the upload and resizing (RELATIVE PATH ONLY!)
$large_image_prefix = "resize_"; 			// The prefix name to large image
$thumb_image_prefix = "thumbnail_";			// The prefix name to the thumb image
$large_image_name = $large_image_prefix.$_SESSION['random_key'];     // New name of the large image (append the timestamp to the filename)
$thumb_image_name = $thumb_image_prefix.$_SESSION['random_key'];     // New name of the thumbnail image (append the timestamp to the filename)
$max_file = "1"; 							// Maximum file size in MB
$max_width = "500";							// Max width allowed for the large image
$thumb_width = "150";						// Width of thumbnail image
$thumb_height = "100";						// Height of thumbnail image
// Only one of these image types should be allowed for upload
$allowed_image_types = array('image/pjpeg'=>"jpg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png",'image/x-png'=>"png",'image/gif'=>"gif");
$allowed_image_ext = array_unique($allowed_image_types); // Do not change this
$image_ext = "";
foreach ($allowed_image_ext as $mime_type => $ext) {
    $image_ext.= strtoupper($ext)." ";
}
?>
<?

?>

<div class="contenedor_sponsor">
<script type="text/javascript">
function showTip(e,user){
    var pos=getAbsolutePosMouse(e);
    $('tip').innerHTML=user;
    $('tip').style.top=pos.y+10+'px';
    if(pos.x<(document.body.offsetWidth/2))
        $('tip').style.left=pos.x+10+'px';
    else
        $('tip').style.left=pos.x-$('tip').offsetWidth-10+'px';
}
function hideTip(){
    $('tip').innerHTML='';
    $('tip').style.top='-1500px';
}

    function crop() {

        jQuery('#loader').hide();
        jQuery('#progress').hide();

        var myUpload = jQuery('#upload_link').upload({
            name: 'image',
            action: '/projects/testcropadmin',
            enctype: 'multipart/form-data',
            params: {upload:'Upload'},
            autoSubmit: true,
            onSubmit: function() {
                jQuery('#upload_status').html('').hide();
                loadingmessage('Please wait, uploading file...', 'show');
            },
            onComplete: function(response) {

                loadingmessage('', 'hide');
                //response = unescape(response);
                var response_new = jQuery.parseJSON(response);

                var regular_url = response_new.regular.ubicacion;

                regular_url = regular_url.split("../webroot/upload_sponsors/");
                var thumb_url = response_new.thumbs.ubicacion;
                thumb_url = thumb_url.split("../webroot/upload_sponsors/");

                /*var thumbname = response.split("thumbnail_");
                var response = response.split("|");
                var responseType = response[0];
                var responseMsg = response[1];*/
                //var new_response = responseMsg.split("../webroot/image/transfer/project/tmp/img/");
                //var new_response2 = thumbname.split("");


                if(regular_url != ''){
                    var current_width = response_new.regular.width;
                    var current_height = response_new.regular.height;
                    //display message that the file has been uploaded
                    jQuery('#upload_status').show().html('<h1>Success</h1><p>The image has been uploaded</p>');
                    //put the image in the appropriate div
                    jQuery('#uploaded_image').html('<img src="/upload_sponsors/'+regular_url[1]+'" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" /><div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;"> <img src="/upload_sponsors/'+regular_url[1]+'" style="position: relative;" id="thumbnail_preview" alt="Thumbnail Preview" /></div>');
                    //find the image inserted above, and allow it to be cropped
                    jQuery('#uploaded_image').find('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview });
                    //display the hidden form
                    jQuery('#thumbnail_form').show();

                    jQuery('#upload2').attr("value",thumb_url[1]);
                    //jQuery('#upload2').attr("value",thumb_url[1]);
                }else if(responseType=="error"){
                    jQuery('#upload_status').show().html('<h1>Error</h1><p>'+responseMsg+'</p>');
                    jQuery('#uploaded_image').html('');
                    jQuery('#thumbnail_form').hide();
                }else{
                    jQuery('#upload_status').show().html('<h1>Unexpected Error</h1><p>Please try again</p>'+response);
                    jQuery('#uploaded_image').html('');
                    jQuery('#thumbnail_form').hide();
                }
            }
        });

        //create the thumbnail
        jQuery('#save_thumb').click(function() {
            var x1 = jQuery('#x1').val();
            var y1 = jQuery('#y1').val();
            var x2 = jQuery('#x2').val();
            var y2 = jQuery('#y2').val();
            var w = jQuery('#w').val();
            var h = jQuery('#h').val();
            if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
                alert("You must make a selection first");
                return false;
            }else{
                //hide the selection and disable the imgareaselect plugin
                jQuery('#uploaded_image').find('#thumbnail').imgAreaSelect({ disable: true, hide: true });
                loadingmessage('Please wait, saving thumbnail....', 'show');
                jQuery.ajax({
                    type: 'POST',
                    url: '/projects/testcropadmin',
                    data: 'save_thumb=Save Thumbnail&x1='+x1+'&y1='+y1+'&x2='+x2+'&y2='+y2+'&w='+w+'&h='+h,
                    cache: false,
                    success: function(response){
                        loadingmessage('', 'hide');
                        response = unescape(response);
                        var response = response.split("|");
                        var responseType = response[0];
                        var responseLargeImage = response[1];
                        var responseThumbImage = response[2];
                        if(responseType=="success"){
                            jQuery('#upload_status').show().html('<h1>Success</h1><p>The thumbnail has been saved!</p>');
                            //load the new images
                            jQuery('#uploaded_image').html('<img src="'+responseLargeImage+'" alt="Large Image"/>&nbsp;<img src="'+responseThumbImage+'" alt="Thumbnail Image"/><br /><a href="javascript:deleteimage(\''+responseLargeImage+'\', \''+responseThumbImage+'\');">Delete Images</a>');
                            //hide the thumbnail form
                            jQuery('#thumbnail_form').hide();
                        }else{
                            jQuery('#upload_status').show().html('<h1>Unexpected Error</h1><p>Please try again</p>'+response);
                            //reactivate the imgareaselect plugin to allow another attempt.
                            jQuery('#uploaded_image').find('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview });
                            jQuery('#thumbnail_form').show();
                        }
                    }
                });

                return false;
            }
        });
    }





    DR(function(){

        crop();

    });
    DR(function(){

        crop();

    });
    //<![CDATA[

    //create a preview of the selection
    function preview(img, selection) {
        //get width and height of the uploaded image.
        var current_width = jQuery('#uploaded_image').find('#thumbnail').width();
        var current_height = jQuery('#uploaded_image').find('#thumbnail').height();

        var scaleX = <?php echo $thumb_width;?> / selection.width;
        var scaleY = <?php echo $thumb_height;?> / selection.height;

        jQuery('#uploaded_image').find('#thumbnail_preview').css({
            width: Math.round(scaleX * current_width) + 'px',
            height: Math.round(scaleY * current_height) + 'px',
            marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
            marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
        });
        jQuery('#x1').val(selection.x1);
        jQuery('#y1').val(selection.y1);
        jQuery('#x2').val(selection.x2);
        jQuery('#y2').val(selection.y2);
        jQuery('#w').val(selection.width);
        jQuery('#h').val(selection.height);
    }

    //show and hide the loading message
    function loadingmessage(msg, show_hide){
        if(show_hide=="show"){
            jQuery('#loader').show();
            jQuery('#progress').show().text(msg);
            jQuery('#uploaded_image').html('');
        }else if(show_hide=="hide"){
            jQuery('#loader').hide();
            jQuery('#progress').text('').hide();
        }else{
            jQuery('#loader').hide();
            jQuery('#progress').text('').hide();
            jQuery('#uploaded_image').html('');
        }
    }

    //delete the image when the delete link is clicked.
    function deleteimage(large_image, thumbnail_image){
        loadingmessage('Please wait, deleting images...', 'show');
        jQuery.ajax({
            type: 'POST',
            url: '/projects/testcropadmin',
            data: 'a=delete&large_image='+large_image+'&thumbnail_image='+thumbnail_image,
            cache: false,
            success: function(response){
                loadingmessage('', 'hide');
                response = unescape(response);
                var response = response.split("|");
                var responseType = response[0];
                var responseMsg = response[1];
                if(responseType=="success"){
                    jQuery('#upload_status').show().html('<h1>Success</h1><p>'+responseMsg+'</p>');
                    jQuery('#uploaded_image').html('');
                }else{
                    jQuery('#upload_status').show().html('<h1>Unexpected Error</h1><p>Please try again</p>'+response);
                }
            }
        });
    }








    //]]>
</script>


<div class="datos_proyecto_sponsor">
    <div class="bot_info_area_sponsor" onmouseout="hideTip()" onmousemove="showTip(event,'<?echo __("PROJECT__SHORT_DESCRIPTION__HELP_MESSAGE_TEXT");?>')"></div>
    <h1 style="font-family:"signika_negativeregular";color: #505050">UPLOAD IMAGENES PARA SPONSORS</h1>
    <div class="misc_separador" style="width:100%;margin-bottom: 25px"></div>
    <ul>
        <li><h3>TITULO PROYECTO</h3></li>

        <li><h3>AUTOR PROYECTO</h3></li>

        <li><h4><?=$Project['Project']['title'];?></h4></li>

        <li><h4><?=$Project['User']['display_name'];?></h4></li>


    </ul>

</div>
<div style="   display: block;
    font-size: 10px;
    height: 70px;
    margin-top: 70px;
    position: relative;
    width: 224px;">

    <h1>NOMBRE DEL SPONSOR</h1>


</div>
<h1 style="font-size: 20px; margin-top:50px; margin-bottom: 20px"><?echo __("Browse");?></h1>
<!--noscript>Javascript must be enabled!</noscript>
<h2>Upload Photo</h2-->
<div id="upload_status" style="font-size:12px; width:40%; margin:10px; padding:5px; display:none; border:1px #999 dotted; background:#eee;"></div>
<p><a id="upload_link" style="position:relative;display: block;background:#000000;text-align: center;padding-top: 5px; font-size: 16px; color: white;width: 120px; height: 25px" href="#"><?echo __("UPLOAD_BROWSE");?></a></p>
<span id="loader" style="display:none;"><img src="loader.gif" alt="Loading..."/></span> <span id="progress"></span>
<br />
<div id="uploaded_image"></div>
<div id="thumbnail_form" style="display:none;">


    <input type="submit" name="save_thumb" value="Save Thumbnail" id="save_thumb"/>

</div>

<form name="form" action="" method="post">
    <input type="hidden" name="x1" value="" id="x1" />
    <input type="hidden" name="y1" value="" id="y1" />
    <input type="hidden" name="x2" value="" id="x2" />
    <input type="hidden" name="y2" value="" id="y2" />
    <input type="hidden" name="w" value="" id="w" />
    <input type="hidden" name="h" value="" id="h" />


</form>



<form id="save_sponsor"  method="post" action="/projects/adminuploadimage" accept-charset="utf-8">

    <input type="text" value="<?=$Project['Sponsor']['nombre_sponsor'];?>" name="data[Sponsor][nombre_sponsor]" id="upload3">
    <input type="hidden" value="<?=$Project['Project']['id'];?>" name="data[Sponsor][id_project]" id="sponsor">
    <input type="hidden" value="" name="data[Sponsor][basename]" id="upload2">
    <!--input type="submit" name="save_imagen" value="save"/-->
</form>
<a onclick="$('save_sponsor').submit();return false;" class="bot_envnuevoproy" style="display: block;height: 37px;position: relative;width: 140px;" href="#"><?php echo __("SEND");?></a>
<div class="misc_separador" style="width:100%;margin-bottom: 25px"></div>


<ul style="float: left; display: block; width: 100%; list-style: none">

    <?php if (isset($show_sponsor)){

    foreach ($show_sponsor as $k => $v){?>

        <?$img=str_ireplace('.jpg','.png',$v["Sponsor"]["basename"]);?>

       <!--li style="float: left"><?echo $v['Sponsor']['id_project'];?></li-->
       <li style="width: 230px; display: block;margin-bottom: 10px; margin-top: 10px "><?= $v['Sponsor']['nombre_sponsor'];?></li>
       <li style="border:2px solid #0066cc;margin:10px 10px 10px 10px ;float: left;height: 121px;list-style: none ;width: 336px;"><img src="/upload_sponsors/<?echo $img;?>"/> </li>
       <a style="border:;width:50px!important;left: -25px;top: 115px;" class="delproy" href="/projects/delete_sponsor/<?=$v['Sponsor']['id']?>"><span class="delp"></span>Borrar</a>

    <?}
}?>

    </ul>

   </div>
