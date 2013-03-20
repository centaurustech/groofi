<?php
/* @var $this ViewCC */
//vd($validationErrorsArray);
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
<div id="relleno_crea_proyecto"></div>
</div>

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
echo $javascript->link('ckeditor/ckeditor');


?>


<div style="font-style:italic"><?php echo __("PROJECT_ADD_FIRST_BLOCK_SUBTITLE");?></div> <div class="misc_separador" style="width:100%"></div><br>
<script>
function validIm(action){
	var yaHayImg=<?=$yaHayImg;?>;
	if(!yaHayImg && $('foto1').value.length<1){
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





<div class="texto_how_izq" style="position:relative;">
<p style="font-size:12px"><?php echo __("Project.title");?></p>
<div class="rounded_crear">
<input onfocus="this.blur();" autocomplete="off" type="text" name="data[Project][title]" value="<?=$this->data['Project']['title'];?>" />

<div class="bot_info"  onmouseout="hideTip()" onmousemove="showTip(event,'Este es el t&iacute;tulo de tu proyecto. En esta instancia, ya no puedes editarlo.')"></div>
</div>
</div>
<div class="texto_how_izq">
<p style="font-size:12px"><?php echo __("PROJECT__CATEGORY");?></p>
<div class="rounded_crear">
<input autocomplete="off" type="hidden" name="data[Project][category_id]" value="<?=$this->data['Project']['category_id'];?>" />
<input onfocus="this.blur();"  autocomplete="off" type="text" name="vista" value="<?=$base_categories[$this->data['Project']['category_id']];?>" />



<div class="bot_info" onmouseout="hideTip()" onmousemove="showTip(event,'Esta es la categor&iacute;a que has elegido para tu proyecto. En esta instancia, ya no puedes editarla.')"></div>
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
<div class="bot_info_area"  onmouseout="hideTip()" onmousemove="showTip(event,'Esta es la descripci&oacute;n breve de tu proyecto. En esta instancia, ya no puedes editarla.')"></div>
</div>
<div style="width:370px; height:253px; background:url(/2012/images/proyectosprivados.png); position:absolute; top:174px;left:477px">

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

<div class="texto_how_izq" style="position:relative;">
<p style="font-size:12px"><?php echo __("PROJECT_MAIN_POST");?></p>
<div class="rounded_area_crear">
<textarea name="data[Project][description]" autocomplete="off" cols="30" rows="6"><?=$this->data['Project']['description'];?></textarea>
<div style="color:red;font-size:9px;position:relative; top:6px"><?php if (isset($validationErrorsArray['description']) && !empty($validationErrorsArray['description'])){echo $validationErrorsArray['description'];}?></div>
<div class="bot_info_area" onmouseout="hideTip()" onmousemove="showTip(event,'Describe en qu&eacute; consiste tu proyecto. Cuanto m&aacute;s completa sea esta descripci&oacute;n, mejor.')"></div>
</div>

</div>

<div class="texto_how_izq">
<p style="font-size:12px"><?php echo __("PROJECT_REASON");?></p>
<div class="rounded_area_crear">
<textarea class="ckeditor" name="data[Project][reason]" autocomplete="off" cols="30" rows="6"><?if(isset($this->data['Project']['reason'])){echo $this->data['Project']['reason'];}?></textarea>
<div style="color:red;font-size:9px;position:relative; top:6px"><?php if (isset($validationErrorsArray['reason']) && !empty($validationErrorsArray['reason'])){echo $validationErrorsArray['reason'];}?></div>
<div class="bot_info_area" onmouseout="hideTip()" onmousemove="showTip(event,'Cu&eacute;ntales a tus posibles patrocinadores por qu&eacute; deber&iacute;an aportar fondos para tu proyecto.')"></div>
</div>

</div>
<div class="clear"></div>
<div class="texto_how_izq">
<p style="font-size:12px">Website</p>
<div class="bot_info" style="top:26px;" onmouseout="hideTip()"  onmousemove="showTip(event,'Ingresa websites en los que podamos encontrar m&aacute;s informaci&oacute;n sobre tu proyecto. Esto ser&aacute; utilizado para evaluar tu propuesta.')"></div>

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
 <div id="extfoto2"><input onchange="if((this.value.toLowerCase().indexOf('.jpg')==-1) && (this.value.toLowerCase().indexOf('.jpeg')==-1) && (this.value.toLowerCase().indexOf('.gif')==-1) && (this.value.toLowerCase().indexOf('.png')==-1)){$('elfile2').innerHTML='<span style=&quot;color:red;font-size:9px&quot;>Formato de archivo no permitido.</span>';this.value='';return;}$('elfile2').innerHTML=this.value" onmouseover="$('bajofoto1').style.background='#237fb5';" onmouseout="$('bajofoto1').style.background='#000';" id="foto1"  name="data[Project][file]" autocomplete="off" type="file" /></div>



<br><div id="elfile2"><?php echo __("UPLOAD_NO_FILE_SELECTED");?></div>
<div style="color:red;font-size:9px;position:relative; top:6px"><?php if (isset($validationErrorsArray['file']) && !empty($validationErrorsArray['file'])){echo $validationErrorsArray['file'];}?></div>
<br>




<div class="bot_info img" onmouseout="hideTip()"  onmousemove="showTip(event,'Elige una imagen para ilustrar tu proyecto. La imagen no es todo, pero es muy importante.<br>Sube una imagen de buena calidad, con un aspecto de 4:3 y un m&aacute;ximo de 560 x 430 pixeles aproximadamente.')"></div>
</div>
<div style="clear:both"></div>


<div ><img width="280" src="<?=$laim;?>"></div>
<br>
<div class="misc_separador" style=" width:367px; height:1px;margin-bottom:30px;"></div>
<div class="texto_how_izq">
<p style="font-size:12px">Video (URL)</p>
<div class="rounded_crear">
<input value="<?if(isset($this->data['Project']['video_url'])){echo $this->data['Project']['video_url'];}?>" type="text"  autocomplete="off" name="data[Project][video_url]" />
<div class="bot_info" onmouseout="hideTip()"  onmousemove="showTip(event,'Ingresa la URL de un video propio sobre tu proyecto que hayas subido a YouTube.com o Vimeo.com (opcional).<br>El video es tu carta de presentaci&oacute;n. Demuestra la calidad de tu proyecto con un video de calidad. Tu proyecto se volver&aacute; mucho m&aacute;s confiable si les hablas a tus futuros patrocinadores y les demuestras tu capacidad y compromiso.')"></div>
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
<div class="tipo_moneda_us">
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
</div>

<div class="input_fondos">
<div id="quemoneda" style="color:#686b68; width:50px; height:30px; text-align:right; line-height:30px;font-size:15px;font-weight:normal; position:absolute; left:-45px;top:20px;font-family:Arial, Helvetica, sans-serif"><?if(!isset($this->data['Project']['moneda'])){?>USD<? }else{?><?=traducirMoneda($this->data['Project']['moneda'])?><? } ?></div>
<input value="<?if(isset($this->data['Project']['funding_goal'])){echo $this->data['Project']['funding_goal'];}?>" id="in_fondos" type="text" name="data[Project][funding_goal]" /></div>
<div style="color:red;font-size:9px;position:relative; top:116px; left:80px"><?php if (isset($validationErrorsArray['funding_goal']) && !empty($validationErrorsArray['funding_goal'])){echo $validationErrorsArray['funding_goal'];}?></div>

<div class="bot_info" onmouseout="hideTip()"  onmousemove="showTip(event,'Ingresa el monto en d&oacute;lares que necesitas para realizar tu proyecto. Podr&aacute;s modificar este importe una vez aprobada tu propuesta.<br>Recuerda que si al cabo del tiempo elegido a continuaci&oacute;n tu proyecto no recauda este monto, no ser&aacute; financiado. Piensa en una suma que est&eacute;s en condiciones de recaudar en el tiempo previsto.')"></div>
<div style="position:absolute; width:534px; height:148px; background:url(/2012/images/tipodemoneda.jpg); left:420px; top:0">

<label style="position:absolute; height:15px;width:300px;  left:0; top:98px; text-align:left; margin:0; padding:0" for="usd">
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
</label>

</div>
</div>

<div class="texto_how_izq">
<p style="font-size:12px"><?php echo __("PROJECT__PROJECT_DURATION");?></p><br>
<input name="data[Project][project_duration]" type="hidden" autocomplete="off" class="range" value="7" id="ProjectProjectDuration" />
<div style="position:relative; height:17px; width:360px">
<div id="indicadords" style="font-size:10px;">7 d&iacute;a/s</div>
<div  class="back_slider" style=" width:360px; height:10px; border:1px solid #eaeaea; position:relative; top:15px;">
<div id="blueLine" style="width:0%; height:100%;background:#338abd;"></div>
</div>
<div id="cursor" style="width:17px; height:17px; border:1px solid #d3d3d3; background:#e6e6e6;cursor:pointer; position:relative; top:24px;"></div>
</div>

<div class="bot_info duracion" onmouseout="hideTip()"  onmousemove="showTip(event,'Elige la cantidad de d&iacute;as que deseas que dure la recaudaci&oacute;n de fondos de tu proyecto. Podr&aacute;s modificar la duraci&oacute;n del proyecto una vez aprobada tu propuesta.<br>Cuanto m&aacute;s dure el proyecto, m&aacute;s posible ser&aacute; que alcances a recaudar los fondos necesarios.')"></div>
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
<div class="bot_info_beneficio" onmouseout="hideTip()"  onmousemove="showTip(event,'Ingresa los beneficios que recibir&aacute;n tus patrocinadores de acuerdo al monto que elijan aportar a tu proyecto.<br>Los beneficios son regalos o premios relacionados con el proyecto, que te comprometes a darles a tus patrocinadores.<br>Podr&aacute;s modificar esto una vez aprobada tu propuesta.<br>Ten en mente que muchos patrocinadores s&oacute;lo est&aacute;n interesados en los beneficios.<br>Ofrece recompensas atractivas y acorde al monto del aporte.')"></div>
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
<div class="bot_info_empresas"  onmouseout="hideTip()"  onmousemove="showTip(event,'Ingresa los beneficios que recibir&aacute;n tus patrocinadores de acuerdo al monto que elijan aportar a tu proyecto.<br>Los beneficios son regalos o premios relacionados con el proyecto, que te comprometes a darles a tus patrocinadores.<br>Podr&aacute;s modificar esto una vez aprobada tu propuesta.<br>Ten en mente que muchos patrocinadores s&oacute;lo est&aacute;n interesados en los beneficios.<br>Ofrece recompensas atractivas y acorde al monto del aporte.')"></div>
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
DR(function(){
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
function addBeneficio(monto, descripcion, entidad){
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
	var html='	<div id="'+id+'"><input type="hidden" name="data[Prize]['+window.memo.index+'][model]" autocomplete="off" value="Project" />	<input type="hidden" name="data[Prize]['+window.memo.index+'][value]" autocomplete="off" value="'+monto+'" />	<input name="data[Prize]['+window.memo.index+'][description]" type="hidden" autocomplete="off" value="'+descripcion+'" />	<input name="data[Prize]['+window.memo.index+'][ente]" type="hidden" autocomplete="off" value="'+elente+'" />	'+sep+'<div class="beneficio_creado'+ente+'"><h3 class="'+colortxt+'"><?php echo __("Providing");?><span class="lamonedaelegida">'+window.lamoneda+'</span> '+monto+' </h3><p class="texto_proyecto" style="color:#383938; height:60px; overflow:auto;">'+descripcion+'</p><div onclick="$(&quot;'+id+'&quot;).parentNode.removeChild($(&quot;'+id+'&quot;));" class="borrar_beneficio'+ente+'"></div><div onclick="$(&quot;'+campos[0]+'&quot;).value=&quot;'+monto+'&quot;;$(&quot;'+campos[1]+'&quot;).value=&quot;'+descripcion+'&quot;;$(&quot;'+id+'&quot;).parentNode.removeChild($(&quot;'+id+'&quot;));location=&quot;#beneficiosyrecompensas&quot;" class="editar_beneficio'+ente+'"></div></div></div>';
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
			addBeneficio('<?=$v['value']?>', '<?=$v['description']?>', 'empresa');
		<?}else{?>
			addBeneficio('<?=$v['value']?>', '<?=$v['description']?>', 'personas');
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
</script>
