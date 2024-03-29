<?php



//session_start(); //Do not remove this
//only assign a new timestamp if the session variable is empty

#########################################################################################################
# CONSTANTS																								#
# You can alter the options below																		#
#########################################################################################################

$upload_dir = "../webroot/media/transfer/project/tmp/img"; 				// The directory for the images to be saved in
$upload_path = $upload_dir."/";				// The path to where the image will be saved
//$image_handling_file = "vendors/crop/image_handling.php"; // The location of the file that will handle the upload and resizing (RELATIVE PATH ONLY!)
$large_image_prefix = "resize_"; 			// The prefix name to large image
$thumb_image_prefix = "thumbnail_";			// The prefix name to the thumb image
$large_image_name = $large_image_prefix.$_SESSION['random_key'];     // New name of the large image (append the timestamp to the filename)
$thumb_image_name = $thumb_image_prefix.$_SESSION['random_key'];     // New name of the thumbnail image (append the timestamp to the filename)
$max_file = "6"; 							// Maximum file size in MB
$max_width = "650";							// Max width allowed for the large image
$thumb_width = "200";						// Width of thumbnail image
$thumb_height = "150";						// Height of thumbnail image
// Only one of these image types should be allowed for upload
$allowed_image_types = array('image/pjpeg'=>"jpg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png",'image/x-png'=>"png",'image/gif'=>"gif");
$allowed_image_ext = array_unique($allowed_image_types); // Do not change this
$image_ext = "";
foreach ($allowed_image_ext as $mime_type => $ext) {
    $image_ext.= strtoupper($ext)." ";
}

/* @var $this ViewCC */
//vd($validationErrorsArray);die;
//vd($_POST['data']['Prize']);
asort($base_categories);
//vd($this->data['Link']);
function traducirMoneda($m){
	
	return $m;
}

?>

<div class="crear_proye">
<h2><?php echo __("CREATE_PROJECT1");?><br>
<?php echo __("CREATE_PROJECT1_1");?></h2><br>
<p><?php echo __("CREATE_PROJECT1_2");?><br>
<?php echo __("CREATE_PROJECT1_3");?><br>
<?php echo __("CREATE_PROJECT1_4");?>
<?php echo __("CREATE_PROJECT1_5");?><br>
<?php echo __("CREATE_PROJECT1_6");?><br></p>
</div>
<div class="crear_proye1">
<h2><?php echo __("CREATE_PROJECT2");?><br>
<?php echo __("CREATE_PROJECT2_1");?></h2><br>
<p><?php echo __("CREATE_PROJECT2_2");?><br>
<?php echo __("CREATE_PROJECT2_3");?><br>
<?php echo __("CREATE_PROJECT2_4");?>
<?php echo __("CREATE_PROJECT2_5");?><br></p>
</div>
<div class="crear_proye2">
<h2><?php echo __("CREATE_PROJECT3");?></h2><br>
<?php echo __("CREATE_PROJECT3_1");?><br>
<p><?php echo __("CREATE_PROJECT3_2");?><br>
<?php echo __("CREATE_PROJECT3_3");?><br>
<?php echo __("CREATE_PROJECT3_4");?>
<?php echo __("CREATE_PROJECT3_5");?><br>
<?php echo __("CREATE_PROJECT3_6");?><br></p>
</div>
<div style="width:100%; height:auto; margin-top:20px">
<h1><?php echo __("CREATE_YOUR_PROJECT");?></h1>
<span style=" font-style:italic"><?php echo __("HOW_WORK");?></span><br><br>
<div id="banner_crea_proyecto"><img src="/2012/images/info_crea_proyecto.png" width="957" height="286">



</div>
<div id="relleno_crea_proyecto"></div>

<div><img src="/2012/images/sombra_header.png" width="957" height="20">
<div class="casos_exito" onclick="window.location='/#proyecto_destacado';">
<h2><?php echo __("SEE_SUCCESFUL_CASES");?></h2><br>
</div>
<div class="casos_exito1" onclick="window.location='/#proyecto_destacado';">
<?php echo __("SEE_SUCCESFUL_CASES1");?><br>
</div>
<div class="casos_exito1_1" onclick="window.location='/#proyecto_destacado';">
<h2><?php echo __("SEE_SUCCESFUL_CASES1_1");?></h2><br>
</div>
<div class="casos_exito1_2" onclick="window.location='/#proyecto_destacado';">
<?php echo __("SEE_SUCCESFUL_CASES1_2");?><br>
</div>
<a href="/#proyecto_destacado" id="casos_de_exito"></a>
<a href="/guidelines" id="groofi_escuela"></a>

<br>
<br>


<?php
echo $this->Html->script('ckeditor/ckeditor');
echo $this->Html->script('ckfinder/ckfinder');


?>


<div style="font-style:italic"><?php echo __("PROJECT_ADD_FIRST_BLOCK_SUBTITLE");?></div> <div class="misc_separador" style="width:100%"></div><br>
<script>
function validIm(action){
	var yaHayImg= '<?=$this->data['Project']['basename'];?>';

	if(yaHayImg == '' && $('upload2').value.length<1 && $('upload3').value.length<1){
		$('elfile2').innerHTML='<span style="color:red;font-size:9px">Debe subir una imagen.</span>';
		scrollTo(0,0);
		return false;
	}
	if(action){
		$('fproy').action=action;
	}
	$('fproy').submit();
}
</script>
<form id="fproy" enctype="multipart/form-data" method="post" action="/projects/edit/<?=$this->data['Project']['id']?>" accept-charset="utf-8">

<input type="hidden" name="data[Project][id]" autocomplete="off" value="<?=$this->data['Project']['id']?>" id="ProjectId" />

<input type="hidden" name="data[Project][offer_id]" autocomplete="off" value="<?=$this->data['Project']['offer_id']?>" id="ProjectOfferId" />
<input type="hidden" name="data[Project][user_id]" autocomplete="off" value="<?=$this->Session->read('Auth.User.id')?>" id="ProjectUserId" />
<input type="hidden" name="data[Project][public]" autocomplete="off" value="<?=$this->data['Project']['public']?>" id="ProjectPublic" />
<input type="hidden" name="data[Project][status]" autocomplete="off" value="<?=$this->data['Project']['status']?>" id="ProjectStatus" />
<input type="hidden" name="data[Project][enabled]" autocomplete="off" value="<?=$this->data['Project']['enabled']?>" id="ProjectEnabled" />



<div class="texto_how_izq" style="position:relative;">
<p style="font-size:12px"><?php echo __("Project.title");?></p>
<div class="rounded_crear">
<input onfocus="this.blur();" autocomplete="off" type="text" name="data[Project][title]" value="<?=$this->data['Project']['title'];?>" />

<div class="bot_info"  onmouseout="hideTip()" onmousemove="showTip(event,'<?php echo __("PROJECT__TITLE_EDIT_HELP_MESSAGE_TEXT");?>')"></div>
</div>
</div>
<div class="texto_how_izq">
    <!--p style="font-size:12px"><?php echo __("COUNTRY");?></p>
   <div class="rounded_crear">
        <input autocomplete="off" type="hidden" name="data[Project][paislugar]" value="<!?=$this->data['Project']['paislugar'];?>" />
        <input onfocus="this.blur();"  autocomplete="off" type="text" name="vista" value="<!?=$base_categories[$this->data['Project']['paislugar']];?>" />

        <div id="restantes1" style="font-size:9px;position:absolute;left:0; top:28px; text-align:right; width:370px; height:15px;">Restan: <!?if(isset($_POST['data']['Project']['country'])){echo 50-intval((strlen(utf8_decode($_POST['data']['Project']['country']))));}else{echo '50';}?> caracteres</div>
        <div class="bot_info"  onmouseout="hideTip()" onmousemove="showTip(event,'Este ser&aacute; el t&iacute;tulo de tu proyecto. Una vez aprobado, no podr&aacute;s modificarlo.')"></div>
    </div-->
</div>

<div class="texto_how_izq">
<p style="font-size:12px"><?php echo __("PROJECT__CATEGORY");?></p>
<div class="rounded_crear">
<input autocomplete="off" type="hidden" name="data[Project][category_id]" value="<?=$this->data['Project']['category_id'];?>" />
<input onfocus="this.blur();"  autocomplete="off" type="text" name="vista" value="<?=$base_categories[$this->data['Project']['category_id']];?>" />



<div class="bot_info" onmouseout="hideTip()" onmousemove="showTip(event,'<?php echo __("PROJECT__CATEGORY_EDIT_HELP_MESSAGE_TEXT");?>')"></div>
</div>
</div>
<div class="texto_how_izq">
<p style="font-size:12px"><?php echo __("PROJECT__SHORT_DESCRIPTION");?></p>
<script>
function noenter(e){
	var evt=e || window.event;
	var key=evt.keyCode || evt.which;
	if(key==13)return false;
	return true;
}
</script>
<div class="rounded_area_crear">
<textarea  onfocus="this.blur();"  name="data[Project][short_description]" cols="30" rows="6" autocomplete="off"><?=$this->data['Project']['short_description'];?></textarea>
<div class="bot_info_area"  onmouseout="hideTip()" onmousemove="showTip(event,'<?php echo __("PROJECT__SHORT_DESCRIPTION_EDIT_HELP_MESSAGE_TEXT");?>')"></div>
</div>
<div style="width:370px; height:253px; background:url(/2012/images/proyectosprivados.png); position:absolute; top:950px;left:490px">

<div class="proyectos_privados0">
<?php echo __("PROYECTOS_PRIVADOS1");?>
</div>
<div class="proyectos_privados">
<p><?php echo __("PROYECTOS_PRIVADOS2");?><br>
<?php echo __("PROYECTOS_PRIVADOS3");?><br>
<?php echo __("PROYECTOS_PRIVADOS4");?><br>
<?php echo __("PROYECTOS_PRIVADOS5");?></p>
</div>
<div class="proyectos_privados1">
<?php echo __("PROYECTOS_PRIVADOS6");?>
</div>
<div class="proyectos_privados2">
<?php echo __("PROYECTOS_PRIVADOS7");?>
</div>
<div class="proyectos_privados3">
<?php echo __("PROYECTOS_PRIVADOS8");?>
</div>
<div class="proyectos_privados4">
<?php echo __("USER__PASSWORD");?>
</div>
<div class="proyectos_privados5">
<?php echo __("USER__PASSWORD_CONFIRMATION");?>
</div>

<label style="position:absolute;left:2px; top:156px ;width:70px; height:30px;"><input <? if(!isset($this->data['Project']['private']) || $this->data['Project']['private']=='0'){?>checked="checked"<? } ?> style="width:20px; height:20px" type="radio" name="data[Project][private]" id="private0" value="0" /></label>
<label style="position:absolute;left:70px; top:156px ;width:70px; height:30px;"><input <? if(isset($this->data['Project']['private']) && $this->data['Project']['private']=='1'){?>checked="checked"<? } ?> style=" width:20px; height:20px" type="radio" name="data[Project][private]" id="private1" value="1" /></label>
<input value="<? if(isset($this->data['Project']['private_pass'])){echo $this->data['Project']['private_pass'];}?>" style="border:none; background:url(/2012/images/Vacio.gif); position:absolute; width:165px;height:23px;left:2px; top:209px" type="password" id="claveprivado" name="data[Project][private_pass]">
<input value="<? if(isset($_POST['data']['Project']['private_pass2'])){echo $_POST['data']['Project']['private_pass2'];}?>" style="border:none; background:url(/2012/images/Vacio.gif); position:absolute; width:165px;height:23px;left:177px; top:209px;" type="password" id="claveprivado2" name="data[Project][private_pass2]">
<div style="color:red;font-size:9px;position:relative; top:256px"><?php if (isset($validationErrorsArray['private']) && !empty($validationErrorsArray['private'])){echo $validationErrorsArray['private'];}?></div>
</div>
</div>

<div class="ckeditor1">
<p style="font-size:12px"><?php echo __("PROJECT_MAIN_POST");?></p>
<div class="ckeditor1">
<textarea class="ckeditor" name="data[Project][description]" autocomplete="off" cols="30" rows="6"><?=$this->data['Project']['description'];?></textarea>
<!--div style="color:red;font-size:9px;position:relative; top:6px"><!?php if (isset($validationErrorsArray['description']) && !empty($validationErrorsArray['description'])){echo $validationErrorsArray['description'];}?></div-->
<div class="info_ckeditor" onmouseout="hideTip()" onmousemove="showTip(event,'<?php echo __("PROJECT__DESCRIPTION_EDIT_HELP_MESSAGE_TEXT");?>')"></div>
</div>

</div>



<div class="ckeditor2">
<p style="font-size:12px"><?php echo __("PROJECT_REASON");?></p>
<div class="ckeditor2">
<textarea class="ckeditor" name="data[Project][reason]" autocomplete="off" cols="30" rows="6"><?if(isset($this->data['Project']['reason'])){echo $this->data['Project']['reason'];}?></textarea>
<div style="color:red;font-size:9px;position:relative; top:6px"><?php if (isset($validationErrorsArray['reason']) && !empty($validationErrorsArray['reason'])){echo $validationErrorsArray['reason'];}?></div>
<div class="info_ckeditor1" onmouseout="hideTip()" onmousemove="showTip(event,'<?php echo __("PROJECT__REASON_EDIT_HELP_MESSAGE_TEXT");?>')"></div>
</div>

</div>
<div class="clear"></div>
<div class="texto_how_izq">
<p style="font-size:12px">Website</p>
<div class="bot_info" style="top:26px;" onmouseout="hideTip()"  onmousemove="showTip(event,'<?php echo __("PROJECT__URL__HELP_MESSAGE_TEXT");?>')"></div>

<div class="rounded_perfil">
<input value="<?if(isset($this->data['Link'][0]['link'])){echo $this->data['Link'][0]['link'];}?>" autocomplete="off"   id="web0" type="text" name="data[Link][0][link]" style="width:350px;"/>
<input  type="hidden" name="data[Link][0][model]" autocomplete="off" value="Project" />
</div>

<div class="rounded_perfil" style="display:none">
<input  value="<?if(isset($this->data['Link'][1]['link'])){echo $this->data['Link'][1]['link'];}?>" autocomplete="off"    id="web1" type="text" name="data[Link][1][link]" style="width:350px"/>
<input type="hidden" name="data[Link][1][model]" autocomplete="off" value="Project" />
</div>


<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($this->data['Link'][2]['link'])){echo $this->data['Link'][2]['link'];}?>"  autocomplete="off"    id="web2" type="text" name="data[Link][2][link]" style="width:350px"/>
<input type="hidden" name="data[Link][2][model]" autocomplete="off" value="Project" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($this->data['Link'][3]['link'])){echo $this->data['Link'][3]['link'];}?>"   autocomplete="off"  id="web3" type="text" name="data[Link][3][link]" style="width:350px"/>
<input type="hidden" name="data[Link][3][model]" autocomplete="off" value="Project" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($this->data['Link'][4]['link'])){echo $this->data['Link'][4]['link'];}?>"  autocomplete="off"   id="web4" type="text" name="data[Link][4][link]" style="width:350px"/>
<input type="hidden" name="data[Link][4][model]" autocomplete="off" value="Project" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($this->data['Link'][5]['link'])){echo $this->data['Link'][5]['link'];}?>"   autocomplete="off"   id="web5" type="text" name="data[Link][5][link]" style="width:350px"/>
<input type="hidden" name="data[Link][5][model]" autocomplete="off" value="Project" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($this->data['Link'][6]['link'])){echo $this->data['Link'][6]['link'];}?>"   autocomplete="off"   id="web6" type="text" name="data[Link][6][link]" style="width:350px"/>
<input type="hidden" name="data[Link][6][model]" autocomplete="off" value="Project" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($this->data['Link'][7]['link'])){echo $this->data['Link'][7]['link'];}?>"   autocomplete="off"   id="web7" type="text" name="data[Link][7][link]" style="width:350px"/>
<input type="hidden" name="data[Link][7][model]" autocomplete="off" value="Project" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($this->data['Link'][8]['link'])){echo $this->data['Link'][8]['link'];}?>"   autocomplete="off"   id="web8" type="text" name="data[Link][8][link]" style="width:350px"/>
<input type="hidden" name="data[Link][8][model]" autocomplete="off" value="Project" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($this->data['Link'][9]['link'])){echo $this->data['Link'][9]['link'];}?>"   autocomplete="off"   id="web9" type="text" name="data[Link][9][link]" style="width:350px"/>
<input type="hidden" name="data[Link][9][model]" autocomplete="off" value="Project" />
</div>

<div style="color:red;font-size:9px;position:relative; top:6px"><?php if (isset($validationErrorsArray['link']) && !empty($validationErrorsArray['link'])){echo $validationErrorsArray['link'];}?><?if(isset($validationErrorsArray['Link'])){echo 'La url ingresada no es v&aacute;lida';}?></div>



</div>
<div class="texto_how_izq">

</div>
<div style="font-style:italic;clear:both"><?php echo __("PROJECT_ADD_SECOND_BLOCK_TITLE");?></div> <div class="misc_separador" style="width:100%"></div><br>
<div class="texto_how_izq" style="margin-bottom:0 !important">
<p style="font-size:12px"><?php echo __("PROJECT_IMAGE");?></p>

<div id="bajofoto1"><?php echo __("UPLOAD_BROWSE");?></div>
 <!--div id="extfoto2"><input onchange="if((this.value.toLowerCase().indexOf('.jpg')==-1) && (this.value.toLowerCase().indexOf('.jpeg')==-1) && (this.value.toLowerCase().indexOf('.gif')==-1) && (this.value.toLowerCase().indexOf('.png')==-1)){$('elfile2').innerHTML='<span style=&quot;color:red;font-size:9px&quot;>Formato de archivo no permitido.</span>';this.value='';return;}$('elfile2').innerHTML=this.value" onmouseover="$('bajofoto1').style.background='#237fb5';" onmouseout="$('bajofoto1').style.background='#000';" id="foto1"  name="data[Project][file]" autocomplete="off" type="file" /></div-->

    <input type="hidden" value="" name="data[Project][country]" id="upload2">
    <input type="hidden" value="<?=$this->data['Project']['basename'];?>" name="data[Project][basename]" id="upload3">

<br><div id="elfile2"><?php echo __("UPLOAD_NO_FILE_SELECTED");?></div>
<div style="color:red;font-size:9px;position:relative; top:6px"><?php if (isset($validationErrorsArray['file']) && !empty($validationErrorsArray['file'])){echo $validationErrorsArray['file'];}?></div>
<br>




<div class="bot_info img" onmouseout="hideTip()"  onmousemove="showTip(event,'<?php echo __("PROJECT__FILE__HELP_MESSAGE_TEXT");?>')"></div>
</div>
<div style="clear:both"></div>


<div ><img width="280" src="<?=$laim;?>"></div>
<br>


<script type="text/javascript">
    //<![CDATA[
    var exito = '<?php echo __("SUCCES_UPLOAD");?>';
    var image_uploaded = '<?php echo __("IMAGE_UPLOADED");?>'
    var delete_images = '<?php echo __('DELETE_IMAGES');?>'
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
            url: '/projects/testcrop',
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

<!--h1>Photo Upload and Crop</h1>
<noscript>Javascript must be enabled!</noscript>
<h2>Upload Photo</h2>
<div id="upload_status" style="font-size:12px; width:80%; margin:10px; padding:5px; display:none; border:1px #999 dotted; background:#eee;"></div>
<p><a id="upload_link" style="background:#39f; font-size: 24px; color: white;" href="#">Click here to upload a photo</a></p>
<span id="loader" style="display:none;"><img src="loader.gif" alt="Loading..."/></span> <span id="progress"></span>
<br />
<div id="uploaded_image"></div>
<div id="thumbnail_form" style="display:none;">


    <input type="submit" name="save_thumb" value="Save Thumbnail" id="save_thumb" />

</div-->


<div class="texto_how_izq upload_image_crop">
    <!---h2>Upload Photo</h2-->
    <div style="font-size:12px;display: block; width: 370px; height: 100px"><? echo __("PROJECT__FILE_EDIT_TIP_MESSAGE_TEXT");?> </div>
    <div id="upload_status" style="font-size:12px; width:38%; margin:0 0 20px; padding:5px; display:none; border:1px #999 dotted; background:#eee;"></div>
    <a id="upload_link" style="cursor:pointer;position:relative;display: block;background:#000000; font-size: 18px; color: white;font-weight: normal;height: 30px;width: 120px; text-align: center" href="#"><?__('UPLOAD_BROWSE');?></a>
    <div style="float: left; position: relative; width: 900px; height: 25px"><? echo __("EDIT_IMAGE");?></div>

    <span id="loader" style="display:none;float: left;position: relative;width: 900px;"><img src="/2012/images/loader.gif" alt="Loading..."/></span>
    <span style="display:none;float: left;position: relative;width: 900px;" id="progress"></span>
    <div id="uploaded_image" style="display:block;float: left; position: relative; width: 900px; height: auto"></div>
    <div id="thumbnail_form" style="display:none;">


        <input style="background-color: #000000; width:140px;color:white;font-weight: bold" type="submit" name="save_thumb" value="<?echo __("SAVE_THUMBNAIL", true);?>" id="save_thumb" />

    </div>
</div>

<div class="misc_separador" style=" width:367px; height:1px;margin-bottom:30px;"></div>

<div class="texto_how_izq">
<p style="font-size:12px">Video (URL)</p>
<div class="rounded_crear">
<input value="<?if(isset($this->data['Project']['video_url'])){echo $this->data['Project']['video_url'];}?>" type="text"  autocomplete="off" name="data[Project][video_url]" />
<div class="bot_info" onmouseout="hideTip()"  onmousemove="showTip(event,'<?php echo __("PROJECT__VIDEO_URL__HELP_MESSAGE_TEXT");?><br><?php echo __("PROJECT__VIDEO_URL__TIP_MESSAGE_TEXT");?>')"></div>
</div>
</div>
<? $video = getVideoEmbed($this->data['Project']['video_url'], 280, 210);?>
<div class="clear"></div>
<? if($video){?>
<div style="margin-bottom:30px;"><?=$video?></div>
<? } ?>

<div style="font-style:italic"><?php echo __("PROJECT_ADD_THIRD_BLOCK_TITLE");?></div> <div class="misc_separador" style="width:100%"></div><br>
<div id="fondos_requeridos">

<div class="fond_reque">
<?php echo __("PROJECT_FUNDING_GOAL");?>
</div>
<div class="tipo_moneda">
<?php echo __("TYPE_OF_CURRENCY");?>
</div>
<div class="tipo_moneda_concept">
<?php echo __("TYPE_OF_CURRENCY_1");?>
</div>
<!--div class="tipo_moneda_us">
<?php echo __("TYPE_OF_CURRENCY_US");?>
</div>
<div class="tipo_moneda_eu">
<?php echo __("TYPE_OF_CURRENCY_EUR");?>
</div>
<div class="tipo_moneda_ar">
<?php echo __("TYPE_OF_CURRENCY_ARS");?>
</div>
<div class="tipo_moneda_gb">
<?php echo __("TYPE_OF_CURRENCY_GBP");?>
</div>
<div class="tipo_moneda_br">
<?php echo __("TYPE_OF_CURRENCY_BRL");?>
</div-->

<div class="input_fondos">
<div id="quemoneda" style="color:#686b68; width:50px; height:30px; text-align:right; line-height:30px;font-size:15px;font-weight:normal; position:absolute; left:-45px;top:20px;font-family:Arial, Helvetica, sans-serif"><?if(!isset($this->data['Project']['moneda'])){?>USD<? }else{?><?=traducirMoneda($this->data['Project']['moneda'])?><? } ?></div>
<input readonly="readonly" value="<?if(isset($this->data['Project']['funding_goal'])){echo $this->data['Project']['funding_goal'];}?>" id="in_fondos" type="text" name="data[Project][funding_goal]" /></div>
<div style="color:red;font-size:9px;position:relative; top:116px; left:80px"><?php if (isset($validationErrorsArray['funding_goal']) && !empty($validationErrorsArray['funding_goal'])){echo $validationErrorsArray['funding_goal'];}?></div>

<div class="bot_info" onmouseout="hideTip()"  onmousemove="showTip(event,'<?php echo __("PROJECT_GOAL", true);?><br><?php echo __("PROJECT__FUNDING_GOAL__TIP_MESSAGE_TEXT");?>')"></div>
<div style="position:absolute; width:534px; height:148px; background:url(/2012/images/tipodemoneda.jpg); left:420px; top:0">

<!--label style="position:absolute; height:15px;width:300px;  left:0; top:98px; text-align:left; margin:0; padding:0" for="usd">
    <input onchange="if(this.checked){$('quemoneda').innerHTML=this.value;window.lamoneda=this.value;changeBoxesMoneda();}" value="USD" style="margin:0; padding:0;width:15px;position:relative;top:-2px" type="radio" name="data[Project][moneda]" id="usd" <?if((isset($_POST['data']['Project']['moneda']) && $_POST['data']['Project']['moneda']=='USD') || !isset($_POST['data']['Project']['moneda'])){?>checked="checked"<? } ?>>
</label>
<label style="position:absolute; height:15px;width:300px;  left:0; top:125px; text-align:left; margin:0; padding:0" for="eur">
    <input onchange="if(this.checked){$('quemoneda').innerHTML='EUR';window.lamoneda='EUR';changeBoxesMoneda();}" value="EUR" style="margin:0; padding:0;width:15px;position:relative;top:-2px" type="radio" name="data[Project][moneda]" id="eur" <?if(isset($_POST['data']['Project']['moneda']) && $_POST['data']['Project']['moneda']=='EUR'){?>checked="checked"<? } ?>>
</label>
<label style="position:absolute; height:15px;width:300px;  left:0; top:152px; text-align:left; margin:0; padding:0" for="ars">
    <input onchange="if(this.checked){$('quemoneda').innerHTML='ARS';window.lamoneda='ARS';changeBoxesMoneda();}" value="ARS" style="margin:0; padding:0;width:15px;position:relative;top:-2px" type="radio" name="data[Project][moneda]" id="ars" <?if(isset($_POST['data']['Project']['moneda']) && $_POST['data']['Project']['moneda']=='ARS'){?>checked="checked"<? } ?>>
</label>
<label style="position:absolute; height:15px;width:300px;  left:0; top:179px; text-align:left; margin:0; padding:0" for="gbp">
    <input onchange="if(this.checked){$('quemoneda').innerHTML='GBP';window.lamoneda='GBP';changeBoxesMoneda();}" value="GBP" style="margin:0; padding:0;width:15px;position:relative;top:-2px" type="radio" name="data[Project][moneda]" id="gbp" <?if(isset($_POST['data']['Project']['moneda']) && $_POST['data']['Project']['moneda']=='GBP'){?>checked="checked"<? } ?>>
</label>
<label style="position:absolute; height:15px;width:300px;  left:0; top:206px; text-align:left; margin:0; padding:0" for="brl">
    <input onchange="if(this.checked){$('quemoneda').innerHTML='BRL';window.lamoneda='ARS';changeBoxesMoneda();}" value="BRL" style="margin:0; padding:0;width:15px;position:relative;top:-2px" type="radio" name="data[Project][moneda]" id="brl" <?if(isset($_POST['data']['Project']['moneda']) && $_POST['data']['Project']['moneda']=='BRL'){?>checked="checked"<? } ?>>
</label-->

</div>
</div>
<div class="tapar_duracion"></div>
<div class="texto_how_izq">
<p style="font-size:12px"><?php echo __("PROJECT__PROJECT_DURATION");?></p><br>
<input name="data[Project][project_duration]" type="hidden" autocomplete="off" class="range" value="7" id="ProjectProjectDuration" />
<div style="position:relative; height:17px; width:360px">
<div id="indicadords" style="font-size:10px;">7 d&iacute;a/s</div>
<div  class="back_slider" style=" background:#559C48;width:360px; height:10px; border:1px solid #eaeaea; position:relative; top:-40px;">
<div id="blueLine" style="width:0%; height:100%;background:#559c48;"></div>
</div>
<div id="cursor" style="width:17px; height:17px; border:1px solid #919191; background:#666666;cursor:pointer; position:relative; top:-15px;"></div>
</div>

<div class="bot_info duracion" onmouseout="hideTip()"  onmousemove="showTip(event,'<?php echo __("PROJECT__PROJECT_DURATION__HELP_MESSAGE_TEXT");?><br><?php echo __("PROJECT__PROJECT_DURATION__TIP_MESSAGE_TEXT");?>')"></div>
</div>

<div class="clear"></div>
<div class="misc_separador" style=" width:367px; height:1px; margin-top:-10px; margin-bottom:15px;"></div>
<div class="clear"></div>
<div id="beneficiosyrecompensas" style="font-style:italic"><?php echo __("BENEFITS_REWARDS");?></div> <div class="misc_separador" style="width:100%"></div><br>
<div class="titulos_beneficios"><?php echo __("BENEFISTS_FOR_PEOPLE");?></div>
<div class="titulos_beneficios empresas"><?php echo __("CORPORATE_BENEFIST");?></div>
<div class="clear"></div>
<div id="beneficios_personas_crear">
<div class="monto_crear"><p style="font-size:12px"><?php echo __("Prize_VALUE");?></p><br>
<div class="rounded_crear beneficio">
<input style="width:70px; " type="text" name="nombre" id="mminazul" />
</div>
</div>
<div class="desc_crear"><p style="font-size:12px"><?php echo __("Prize_TEXT");?></p><br>
<div class="rounded_area_beneficios">
<textarea onkeypress="return noenter(event)" name="comments" cols="1" rows="1" id="descrazul"></textarea>
<div id="errP" style="color:red;font-size:9px;position:relative; top:6px; left:10px"></div>
<div class="bot_info_beneficio" onmouseout="hideTip()"  onmousemove="showTip(event,'<?php echo __("PROJECT__PRIZE__HELP_MESSAGE_TEXT");?>')"></div>
<div class="bot_crear_nuevo" onclick="addBeneficio($('mminazul').value, $('descrazul').value, 'personas');"><?php echo __("CREATE");?></div>

</div>

</div>

<div class="separador_azul" style="height:0; overflow:hidden;"></div>
<div id="contazul">

</div>

</div>

<div id="beneficios_empresas_crear">

<div class="monto_crear"><p style="font-size:12px"><?php echo __("Prize_VALUE");?></p><br>
<div class="rounded_crear beneficio">
<input style="width:70px; " type="text" name="nombre" id="mminverde" />
</div>
</div>
<div class="desc_crear"><p style="font-size:12px"><?php echo __("Prize_TEXT");?></p><br>
<div class="rounded_area_beneficios">
<textarea onkeypress="return noenter(event)" name="comments" cols="1" rows="1" id="descverde"></textarea>
<div id="errE" style="color:red;font-size:9px;position:relative; top:6px; left:10px"></div>
    <div class="bot_info_empresas"  onmouseout="hideTip1()"  onmousemove="showTip1(event,'<?echo __("PROJECT__PRIZE__HELP_MESSAGE_TEXT");?><br><?echo __("PROJECT_-PRIZE__TIP_MESSAGE_TEXT");?>')"></div>
<div class="bot_crear_nuevo empresas" onclick="addBeneficio($('mminverde').value, $('descverde').value, 'empresa');"><?php echo __("CREATE");?></div>

</div>

</div>

<div class="separador_verde" style="height:0; overflow:hidden;"></div>
<div id="contverde">

</div>


</div>
<div style="clear:both"></div>
<div style="color:red;font-size:9px;position:relative; top:6px"><?php if (isset($validationErrorsArray['prize']) && !empty($validationErrorsArray['prize'])){echo $validationErrorsArray['prize'];}?></div>

</form>
<form name="form" action="" method="post">
    <input type="hidden" name="x1" value="" id="x1" />
    <input type="hidden" name="y1" value="" id="y1" />
    <input type="hidden" name="x2" value="" id="x2" />
    <input type="hidden" name="y2" value="" id="y2" />
    <input type="hidden" name="w" value="" id="w" />
    <input type="hidden" name="h" value="" id="h" />
    <input type="hidden" name="idproject" value="<?=$this->data['Project']['id']?>" id="idproject" />

</form>
<a onclick="validIm();return false;" class="bot_envnuevoproy" href="#"><?php echo __("SAVE");?></a>
<? if ($this->data['Project']['public'] == 0) {?>
<a onclick="validIm('<?= Project::getLink($this->data, 'publish') ?>');return false;" class="bot_envnuevoproy" href="#" style="position:relative; top:-66px; left:150px;"><?php echo __("PUBLISH_PROJECT");?></a>
<a class="bot_envnuevoproy" href="/projects/delete/<?=$this->data['Project']['id']?>" style="position:relative; top:-132px; left:299px;"><?php echo __("DELETE");?></a>
<? } ?>
</div>
<script>
function changeBoxesMoneda(){
	var els=getElementsByClassName('lamonedaelegida'), l=els.length;
	for(var i=0;i<l;i++){
		els[i].innerHTML=window.lamoneda;
	}
}
<?if(isset($this->data['Project']['moneda'])){?>
window.lamoneda='<?=traducirMoneda($this->data['Project']['moneda'])?>';
<? }else{ ?>
window.lamoneda=window.lamoneda || 'USD';
<? } ?>
function getElementPositionRelativeTo(contenedor) {
		var offsetTrail = this;
		var offsetLeft = 0;
		var offsetTop = 0;
		while (offsetTrail && offsetTrail!=contenedor) {
			offsetLeft += offsetTrail.offsetLeft;
			offsetTop += offsetTrail.offsetTop;
			offsetTrail = offsetTrail.offsetParent;
		}
		return {left:offsetLeft, top:offsetTop};
}
var DragableRestrict={
		makeDragableR:function (restrictx,restricty,callback,callbackEnd){
		this.restricty=restricty;
		this.restrictx=restrictx;
		this.callback=callback;
		this.callbackEnd=callbackEnd;
		var o=panino.getO(this);
		var pos=getElementPositionRelativeTo.call(o,o.parentNode);
		o.style.position='absolute';
		if(!this.restricty)
			o.style.top=pos.top+'px';
		o.style.left=pos.left+'px';
		this.cx0=0; 
        this.cy0=0;
		var backslider=getElementsByClassName('back_slider',panino.getO(o.parentNode))[0];//
		panino.getO(backslider).addEvent(
			'mouseout',
			function(e){
				cancelEvent(e); 
        		stopEvent(e); 
				panino.getO(o.parentNode)['okchildmove']=0;
			}
		);
		panino.getO(backslider).addEvent(
			'mouseover',
			function(e){
				cancelEvent(e); 
        		stopEvent(e); 
				panino.getO(o.parentNode)['okchildmove']=1;
			}
		);
		panino.getO(o.parentNode).addEvent(
			'mousedown',
			function(e){
				cancelEvent(e); 
        		stopEvent(e); 
				if(!this['okchildmove'])return;
				var p=getPos(e);
				if(parseInt(o.style.left)>=(p.x)){
					o.style.left=(p.x)+'px';				   
				}else{
					o.style.left=((p.x)-o.offsetWidth)+'px'
				}
				if(parseInt(o.style.left)<0){
					o.style.left='0px';
				}
				if(parseInt(o.style.left)>o.parentNode.offsetWidth+2-(o.offsetWidth)){
					o.style.left=(o.parentNode.offsetWidth+2-(o.offsetWidth))+'px';
				}
				o.callback(o.style.left);
				o.callbackEnd(o.style.left);
			}
		);
		this.addEvent('mousedown',
				 function(e){
					panino.actR=this;
					e=e || window.event; 
        			cancelEvent(e); 
        			stopEvent(e); 
        			this.cx0=e.clientX || 0; 
        			this.cy0=e.clientY || 0; 
        			this.ox=parseInt(o.style.left) || 0; 
        			if(!this.restricty)
						this.oy=parseInt(o.style.top) || 0;
					panino.getO(document).addEvent('mousemove',function(e){if(panino.actR)panino.actR.arrastrarR(e);});
					panino.getO(document).addEvent('mouseup',function(e){if(panino.actR)panino.actR.soltarR(e);});
				 }
		);
		return this;
	},
	arrastrarR:function(e){
		e=e || window.event;
		clearSelection();
		var o=panino.getO(this);
        cancelEvent(e); 
        stopEvent(e);
		if(!this.restrictx){
        	o.style.left=this.ox-this.cx0+e.clientX+'px';
			if(parseInt(o.style.left)<0){
				o.style.left='0px';
			}
			if(parseInt(o.style.left)>o.parentNode.offsetWidth+2-(o.offsetWidth)){
				o.style.left=(o.parentNode.offsetWidth+2-(o.offsetWidth))+'px';
			}
		}
		if(!this.restricty){
        	o.style.top=this.oy-this.cy0+e.clientY+'px'; 
		}
		this.callback(o.style.left);
		return this;
	},

	soltarR:function(e){
		var o=panino.getO(this);
		e=e || window.event; 
        cancelEvent(e); 
        stopEvent(e); 
       	panino.getO(document).removeEvent('mousemove',function(e){if(panino.actR)panino.actR.arrastrarR(e);});
		panino.getO(document).removeEvent('mouseup',function(e){if(panino.actR)panino.actR.soltarR(e);});
		
		this.callbackEnd(o.style.left);
		panino.actR=null;
		return this;
	},
	finalPositionR:function(){
		return {x:parseInt(this.style.left),y:parseInt(this.style.top)}
	}
	
}
function setBlueLine(r){
	var valor=Math.round((100*parseInt(r)/343)*365/100);
	if(valor<7)valor=7;
	$('indicadords').innerHTML=valor+' d&iacute;a/s';
	$('ProjectProjectDuration').value=valor;
	$('blueLine').style.width=(100*parseInt(r)/343)+'%';
}

DR(function(){
	panino.add(DragableRestrict);
	$('cursor').makeDragableR(0,1,setBlueLine,function(){});
});

</script>
<script>
var rest1 = '<?php echo __("Res1");?>'
var carac = '<?php echo __( "Carac");?>'
var ingre = '<?php echo __("INGRE");?>'
var benef = '<?echo __("ALERT_BENEFICIO");?>'
function openBoxUser3(){
    if(window.animationOn)return;
    clearTimeout(ns.timer);

    var pos=getElementPosition.call($('gear'));
    $('boxUser').style.left=(pos.left-171)+'px';
    $('boxUser').style.top=(pos.top+4)+'px';
    $('boxUser').style.width='210px';
    $('boxUser').style.height='140px';
    $('boxUser').style.background='url(/2012/images/bgLogOn.png)';
    $('boxUser').style.display='block';

}
jQuery.extend(jQuery.imgAreaSelect.prototype, {
    animateSelection: function (x1, y1, x2, y2, duration) {
        var fx = jQuery.extend(jQuery('<div/>')[0], {
            ias: this,
            start: this.getSelection(),
            end: { x1: x1, y1: y1, x2: x2, y2: y2 }
        });

        jQuery(fx).animate({
                    cur: 1
                },
                {
                    duration: duration,
                    step: function (now, fx) {
                        var start = fx.elem.start, end = fx.elem.end,
                                curX1 = Math.round(start.x1 + (end.x1 - start.x1) * now),
                                curY1 = Math.round(start.y1 + (end.y1 - start.y1) * now),
                                curX2 = Math.round(start.x2 + (end.x2 - start.x2) * now),
                                curY2 = Math.round(start.y2 + (end.y2 - start.y2) * now);
                        fx.elem.ias.setSelection(curX1, curY1, curX2, curY2);
                        fx.elem.ias.update();
                    }
                });
    }
});

function crop() {
    var message_wait = '<?php __("MESSAGE_WAIT");?>'
    jQuery('#loader').hide();
    jQuery('#progress').hide();

    var myUpload = jQuery('#upload_link').upload({
        name: 'image',
        action: '/projects/testcrop',
        enctype: 'multipart/form-data',
        params: {upload:'Upload'},
        autoSubmit: true,
        onSubmit: function() {
            jQuery('#upload_status').html('').hide();
            loadingmessage(message_wait,'show');
        },
        onComplete: function(response) {

            var img_time = '?'+Math.round(Math.random()*1000);

            loadingmessage('', 'hide');
            //response = unescape(response);
            var response_new = jQuery.parseJSON(response);
if(response_new.regular != ''){

            var regular_url = response_new.regular.ubicacion;

            regular_url = regular_url.split("../webroot/media/transfer/project/tmp/img/");
            var thumb_url = response_new.thumbs.ubicacion;
            thumb_url = thumb_url.split("../webroot/media/transfer/project/tmp/img/");

            /*var thumbname = response.split("thumbnail_");
            var response = response.split("|");
            var responseType = response[0];
            var responseMsg = response[1];*/
            //var new_response = responseMsg.split("../webroot/image/transfer/project/tmp/img/");
            //var new_response2 = thumbname.split("");


            if(regular_url != ''){

                jQuery('#uploaded_image, #thumbnail_preview').empty();

                var current_width = response_new.regular.width;
                var current_height = response_new.regular.height;
                if (current_width < 600){
                    alerta('<?php echo __("alert_imagen upload_add", true);?>');
                }else{
                //display message that the file has been uploaded
                jQuery('#upload_status').show().html('<h1>'+exito+'</h1><p>'+image_uploaded+'</p>');
                //put the image in the appropriate div
                jQuery('#uploaded_image').html('<img src="/media/transfer/project/tmp/img/'+regular_url[1]+img_time+'" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" /><div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;"> <img src="/media/transfer/project/tmp/img/'+regular_url[1]+img_time+'" style="position: relative;" id="thumbnail_preview" alt="Thumbnail Preview" /></div>');
                //find the image inserted above, and allow it to be cropped
                jQuery('#uploaded_image').find('#thumbnail').imgAreaSelect({minHeight: '420',minWidth:'560',instance: true,handles: true,parent:'#uploaded_image', aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview });
                //display the hidden form
                jQuery('#thumbnail_form').show();

                jQuery('#upload2').attr("value",thumb_url[1]);
                jQuery('#upload3').attr("value",thumb_url[1]);


                }
            }
}
           /*else if(responseType=="error"){

                jQuery('#upload_status').show().html('<h1>Error</h1><p>'+responseMsg+'</p>');
                jQuery('#uploaded_image').html('');
                jQuery('#thumbnail_form').hide();
            }*/else{


               jQuery('#upload_status').show().html('<h1>Error</h1><p>'+response_new.error.error+'</p>');
               jQuery('#uploaded_image').html('');
               jQuery('#thumbnail_form').hide();
                /*console.log('else');
                jQuery('#upload_status').show().html('<h1>Unexpected Error</h1><p>Please try again</p>'+response);
                jQuery('#uploaded_image').html('');
                jQuery('#thumbnail_form').hide();*/
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
        var idproject = jQuery('#idproject').val();
        if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
            alert("You must make a selection first");
            return false;
        }else{
            //hide the selection and disable the imgareaselect plugin
            jQuery('#uploaded_image').find('#thumbnail').imgAreaSelect({minHeight: '420',minWidth:'560',instance: true,handles: true,parent:'#uploaded_image', disable: true, hide: true });
            loadingmessage('Please wait, saving thumbnail....', 'show');
            jQuery.ajax({
                type: 'POST',
                url: '/projects/testcrop',
                data: 'save_thumb=Save Thumbnail&x1='+x1+'&y1='+y1+'&x2='+x2+'&y2='+y2+'&w='+w+'&h='+h+'&idproject='+idproject,
                cache: false,
                success: function(response){
                    loadingmessage('', 'hide');
                    response = unescape(response);
                    var response = response.split("|");
                    var responseType = response[0];
                    var responseLargeImage = response[1];

                    //regular_url = response[1].split("../webroot/media/transfer/project/tmp/img/thumbnail_");
                    thumb_url = response[2].split("../webroot/media/transfer/project/tmp/img/thumbnail_");

                    var responseThumbImage = response[2];

                    if(responseType=="success"){
                        jQuery('#upload_status').show().html('<h1>'+exito+'</h1><p>'+image_uploaded+'</p>');
                        //load the new images
                        //jQuery('#uploaded_image').html('<img src="/media/transfer/project/tmp/img/thumbnail_'+ regular_url[1]+'" alt="Large Image"/>&nbsp;<img src="'+thumb_url[1]+'" alt="Thumbnail Image"/><br /><a href="javascript:deleteimage(\''+ regular_url[1]+'\', \''+thumb_url[1]+'\');">Delete Images</a>');
                        jQuery('#uploaded_image').html('<img src="/media/transfer/project/tmp/img/thumbnail_'+ thumb_url[1]+'" alt="Large Image"/>');
                        //hide the thumbnail form
                        jQuery('#thumbnail_form').hide();

                    }else{
                        jQuery('#upload_status').show().html('<h1>Unexpected Error</h1><p>Please try again</p>'+response);
                        //reactivate the imgareaselect plugin to allow another attempt.
                        jQuery('#uploaded_image').find('#thumbnail').imgAreaSelect({minHeight: '420',minWidth:'560',instance: true,handles: true,parent:'#uploaded_image',  aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview });
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
	for(var i=0;i<10;i++){
		
			if($('web'+i).value.length>1){
				$('web'+i).parentNode.style.display='block';
				if($('web'+(i+1))){
					$('web'+(i+1)).parentNode.style.display='block';
				}
			}
		
		$('web'+i).addEvent(
			'keyup',
			function(e){
				var o=e.target || e.srcElement;
				var indice=(o.id).substring(3);
				if(o.value.length){
					if($('web'+(parseInt(indice,10)+1))){
						$('web'+(parseInt(indice,10)+1)).parentNode.style.display='block';
					}
				}else{
					o.parentNode.style.display='none';
				}
				
			}
		);
	}
});
window.memo={};
window.memo.index=-1;
function addBeneficio(monto, descripcion, entidad, bakes, sponsors){
	var id='__id'+(+new Date()); 
	
	window.memo.index++;
	if(entidad=='empresa'){
		var ente=' empresas';
		var colortxt='green';
		var sep='<div style="height:2px;background:#72bb62;position:relative; left:-10px; width:395px;"></div>';
		var campos=['mminverde','descverde'];
		var elente='E';
	}else{
		var ente='';
		var colortxt='cyan';
		var sep='<div style="height:2px;background:#5eaac6;position:relative; left:-10px; width:395px;"></div>';
		var campos=['mminazul','descrazul'];
		var elente='P';
	}
	//errE
	var patron = /\d/; 
	if(!patron.test(monto)){
		$('err'+elente).innerHTML='El monto ingresado es inv&aacute;lido';
		return;
	}
	if(descripcion.length<10){
		$('err'+elente).innerHTML='La descripci&oacute;n ingresada es demasiado breve';
		return;
	}
	$(campos[0]).value=$(campos[1]).value='';
	$('err'+elente).innerHTML='';
    if (bakes<=0){
        var habilitado = '<div data="'+bakes+'" onclick="$(&quot;'+campos[0]+'&quot;).value=&quot;'+monto+'&quot;;$(&quot;'+campos[1]+'&quot;).value=&quot;'+descripcion+'&quot;;$(&quot;'+id+'&quot;).parentNode.removeChild($(&quot;'+id+'&quot;));location=&quot;#beneficiosyrecompensas&quot;" class="editar_beneficio'+ente+'"></div>';
    }
    else{
        var habilitado = '';
    }
	var html='	<div id="'+id+'"><input type="hidden" name="data[Prize]['+window.memo.index+'][model]" autocomplete="off" value="Project" />	<input type="hidden" name="data[Prize]['+window.memo.index+'][value]" autocomplete="off" value="'+monto+'" />	<input name="data[Prize]['+window.memo.index+'][description]" type="hidden" autocomplete="off" value="'+descripcion+'" />	<input name="data[Prize]['+window.memo.index+'][ente]" type="hidden" autocomplete="off" value="'+elente+'" />	'+sep+'<div class="beneficio_creado'+ente+'"><h3 class="'+colortxt+'"><?php echo __("Providing");?><span class="lamonedaelegida">'+window.lamoneda+'</span> '+monto+' </h3><p class="texto_proyecto" style="color:#383938; height:60px; overflow:auto;">'+descripcion+'</p><div onclick="$(&quot;'+id+'&quot;).parentNode.removeChild($(&quot;'+id+'&quot;));" class="borrar_beneficio'+ente+'"></div>'+habilitado+'</div></div>';
	if(entidad=='empresa'){
		$('contverde').innerHTML+=html;
	}else{
		$('contazul').innerHTML+=html;
	}
}
function xrestantes(campo,label,mx,mi){
	if(campo.value.length>mx){
				campo.value=campo.value.substr(0,mx);
	}
	if(mi){
		var ingresados='Ingresados: '+campo.value.length+' caracteres. ';
	}else{
		var ingresados='';
	}		
	label.innerHTML=ingresados+'Restan: '+(mx-campo.value.length)+' caracteres';	
}
<?if(isset($this->data['Project']['project_duration'])){?>
DR(function(){

	$('ProjectProjectDuration').value=<?=$this->data['Project']['project_duration']?>;
	var r=Math.round($('ProjectProjectDuration').value/365*343);
	$('cursor').style.left=r+'px';
	setBlueLine(r)
});
<? } ?>
<? if(isset($this->data['Prize'])){?>
	
DR(function(){
<?	
	foreach($this->data['Prize'] as $k=>$v){
		if($v['ente']=='E'){
			?>
			addBeneficio('<?=$v['value']?>', '<?=$v['description']?>', 'empresa','<?=$v['bakes_count']?>','<?=$v['sponsorships_count']?>');
		<?}else{?>
			addBeneficio('<?=$v['value']?>', '<?=$v['description']?>', 'personas','<?=$v['bakes_count']?>','<?=$v['sponsorships_count']?>');
		<?
		}
	}
?>
});
<? } ?>
function getAbsolutePosMouse(e){
	var ev=e || window.event;
	var xScroll=self.pageXOffset || (document.documentElement.scrollLeft+document.body.scrollLeft) || 0;
	var yScroll=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop) || 0;
	var posX=ev.clientX+xScroll;
	var posY=ev.clientY+yScroll;
	return {x:posX,y:posY}
}
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
function showTip1(e,user){
    var pos=getAbsolutePosMouse(e);
    $('tip1').innerHTML=user;
    $('tip1').style.top=pos.y+10+'px';
    if(pos.x<(document.body.offsetWidth/2))
        $('tip1').style.left=pos.x+10+'px';
    else
        $('tip1').style.left=pos.x-$('tip1').offsetWidth-10+'px';
}
function hideTip1(){
    $('tip1').innerHTML='';
    $('tip1').style.top='-1500px';
}
</script>
<script type="text/javascript">

    //var ck_newsContent = CKEDITOR.replace( 'data[Project][description]' );
    CKEDITOR.replace( 'data[Project][description]',
            {
                //filebrowserBrowseUrl : '/js/ckfinder/ckfinder.html',
                //filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?type=Images',
                //filebrowserFlashBrowseUrl : '/js/ckfinder/ckfinder.html?type=Flash',
                filebrowserUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                //filebrowserFlashUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
            });

    //ck_newsContent.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );

</script>
<script type="text/javascript">

    //var ck_newsContent = CKEDITOR.replace( 'data[Project][description]' );
    CKEDITOR.replace( 'data[Project][reason]',
            {
                //filebrowserBrowseUrl : '/js/ckfinder/ckfinder.html',
                //filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?type=Images',
                //filebrowserFlashBrowseUrl : '/js/ckfinder/ckfinder.html?type=Flash',
                filebrowserUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                //filebrowserFlashUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
            });

    //ck_newsContent.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );

</script>
