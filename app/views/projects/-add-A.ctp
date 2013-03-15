<?php
/* @var $this ViewCC */
//vd($validationErrorsArray);
//vd($_POST['data']['Prize']);
asort($base_categories);
//vd($this->data);
function traducirMoneda($m){
	
	return $m;
}
function getVideoFromURL($u){
	$pos=strpos($u, 'vimeo');
	$code=end(explode('v=',$u));
	$code=end(explode('/',$code));
	if(strpos($code, '&')!==false){
		$code=explode('&',$code);
		$code=$code[0];
	}
	
	if($pos===false){
	    $ret='<iframe width="280" height="210" src="http://www.youtube.com/embed/'.$code.'" frameborder="0" allowfullscreen></iframe>';
	}else{
		$ret='<iframe src="http://player.vimeo.com/video/'.$code.'" width="280" height="210" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe> ';
	}
	return $ret;
}
?>

<div style="width:100%; height:auto; margin-top:20px">
<h1>Crea tu Proyecto</h1>
<span style=" font-style:italic">&#191;C&oacute;mo funciona?</span><br><br>
<div id="banner_crea_proyecto"><img src="/2012/images/info_crea_proyecto.png" width="957" height="286">
<div id="relleno_crea_proyecto"></div>


</div>
<div><img src="/2012/images/sombra_header.png" width="957" height="20"></div>
<a href="/guidelines" id="groofi_escuela"></a>
<br>
<br>
<div style="font-style:italic">Completa la siguiente informaci&oacute;n</div> <div class="misc_separador" style="width:100%"></div><br>
<form id="fproy" enctype="multipart/form-data" method="post" action="/projects/add" accept-charset="utf-8">
<input type="hidden" name="data[Project][user_id]" autocomplete="off" value="<?=$this->Session->read('Auth.User.id')?>" id="ProjectUserId" />

<div class="texto_how_izq" style="position:relative;">
<p style="font-size:12px">T&iacute;tulo</p>
<div class="rounded_crear">
<input onkeyup="xrestantes(this,$('restantes1'),50)" onkeydown="xrestantes(this,$('restantes1'),50)" onchange="xrestantes(this,$('restantes1'),50)" autocomplete="off" type="text" name="data[Project][title]" value="<?if(isset($_POST['data']['Project']['title'])){echo $_POST['data']['Project']['title'];}?>" />
<div style="color:red;font-size:9px;position:relative; top:6px"><?php if (isset($validationErrorsArray['title']) && !empty($validationErrorsArray['title'])){echo $validationErrorsArray['title'];}?></div>
<div id="restantes1" style="font-size:9px;position:absolute;left:0; top:28px; text-align:right; width:370px; height:15px;">Restan: <?if(isset($_POST['data']['Project']['title'])){echo 50-intval((strlen(utf8_decode($_POST['data']['Project']['title']))));}else{echo '50';}?> caracteres</div>
<div class="bot_info"  onmouseout="hideTip()" onmousemove="showTip(event,'Este ser&aacute; el t&iacute;tulo de tu proyecto. Una vez aprobado, no podr&aacute;s modificarlo.')"></div>
</div>
</div>
<div class="texto_how_izq">
<p style="font-size:12px">Categor&iacute;a</p>
<div class="rounded_crear" style=background:none>
<select autocomplete="off" style="width:373px; height:27px; position:relative;top:0; left:0;border:1px solid #e1e1e1; background:#f6f7f6" name="data[Project][category_id]" autocomplete="off" id="ProjectCategoryId">
<? foreach($base_categories as $k=>$v){ ?>
<option <?if(isset($_POST['data']['Project']['category_id']) && $_POST['data']['Project']['category_id']==$k){echo ' selected="selected" ';}?> value="<?=$k?>"><?=$v?></option>

<? } ?>

</select>
<div class="bot_info" onmouseout="hideTip()" onmousemove="showTip(event,'Elige la categor&iacute;a que mejor describa a tu proyecto. Una vez aprobado, no podr&aacute;s modificarla.')"></div>
</div>
</div>
<div class="texto_how_izq">
<p style="font-size:12px">Cuentanos tu motivaci&oacute;n para realizar este proyecto</p>

<div class="rounded_area_crear">
<textarea name="data[Project][motivation]" cols="30" rows="6" autocomplete="off"><?if(isset($_POST['data']['Project']['motivation'])){echo $_POST['data']['Project']['motivation'];}?></textarea>
<div class="bot_info_area"  onmouseout="hideTip()" onmousemove="showTip(event,'Esta informaci&oacute;n nos ser&aacute; &uacute;til para evaluar tu propuesta. No la publicaremos.')"></div>
</div>

</div>

<div class="texto_how_izq" style="position:relative;">
<p style="font-size:12px">Descripci&oacute;n breve</p>
<div class="rounded_area_crear">
<textarea onkeyup="xrestantes(this,$('restantes2'),140,50)" onkeydown="xrestantes(this,$('restantes2'),140,50)" onchange="xrestantes(this,$('restantes2'),140,50)" name="data[Project][short_description]" autocomplete="off" cols="30" rows="6"><?if(isset($_POST['data']['Project']['short_description'])){echo $_POST['data']['Project']['short_description'];}?></textarea>
<div style="color:red;font-size:9px;position:relative; top:6px"><?php if (isset($validationErrorsArray['short_description']) && !empty($validationErrorsArray['short_description'])){echo $validationErrorsArray['short_description'];}?></div>
<div   id="restantes2" style="font-size:9px;position:absolute;left:0; top:118px; text-align:right; width:370px; height:15px;">Ingresados: <?if(isset($_POST['data']['Project']['short_description'])){echo intval((strlen(utf8_decode($_POST['data']['Project']['short_description']))));}else{echo '0';}?> caracteres. Restan: <?if(isset($_POST['data']['Project']['short_description'])){echo 140-intval((strlen(utf8_decode($_POST['data']['Project']['short_description']))));}else{echo '140';}?> caracteres</div>
<div class="bot_info_area" onmouseout="hideTip()" onmousemove="showTip(event,'Describe en pocas palabras la idea de tu proyecto. Una vez aprobado, no podr&aacute;s modificarla.')"></div>
</div>
<div style="width:370px; height:253px; background:url(/2012/images/proyectosprivados.png); position:absolute; top:150px">
<label style="position:absolute;left:2px; top:156px ;width:70px; height:30px;"><input <? if(!isset($_POST['data']['Project']['private']) || $_POST['data']['Project']['private']=='0'){?>checked="checked"<? } ?> style="width:20px; height:20px" type="radio" name="data[Project][private]" id="private0" value="0" /></label>
<label style="position:absolute;left:70px; top:156px ;width:70px; height:30px;"><input <? if(isset($_POST['data']['Project']['private']) && $_POST['data']['Project']['private']=='1'){?>checked="checked"<? } ?> style=" width:20px; height:20px" type="radio" name="data[Project][private]" id="private1" value="1" /></label>
<input value="<? if(isset($_POST['data']['Project']['private_pass'])){echo $_POST['data']['Project']['private_pass'];}?>" style="border:none; background:url(/2012/images/Vacio.gif); position:absolute; width:165px;height:23px;left:2px; top:209px" type="password" id="claveprivado" name="data[Project][private_pass]">
<input value="<? if(isset($_POST['data']['Project']['private_pass2'])){echo $_POST['data']['Project']['private_pass2'];}?>" style="border:none; background:url(/2012/images/Vacio.gif); position:absolute; width:165px;height:23px;left:177px; top:209px;" type="password" id="claveprivado2" name="data[Project][private_pass2]">
<div style="color:red;font-size:9px;position:relative; top:256px"><?php if (isset($validationErrorsArray['private']) && !empty($validationErrorsArray['private'])){echo $validationErrorsArray['private'];}?></div>
</div>
</div>


<div class="texto_how_izq">
<p style="font-size:12px">Descripci&oacute;n</p>
<div class="rounded_area_crear">
<textarea name="data[Project][description]" autocomplete="off" cols="30" rows="6"><?if(isset($_POST['data']['Project']['description'])){echo $_POST['data']['Project']['description'];}?></textarea>
<div style="color:red;font-size:9px;position:relative; top:6px"><?php if (isset($validationErrorsArray['description']) && !empty($validationErrorsArray['description'])){echo $validationErrorsArray['description'];}?></div>
<div class="bot_info_area" onmouseout="hideTip()" onmousemove="showTip(event,'Describe tu proyecto en extenso. Podr&aacute;s editar esta descripci&oacute;n una vez aprobado tu proyecto.<br>Cuanta m&aacute;s informaci&oacute;n pongas y m&aacute;s claro seas en esta descripci&oacute;n, m&aacute;s confiable resultar&aacute; tu proyecto para los patrocinadores.')"></div>
</div>

</div>
<div class="clear"></div>
<div class="texto_how_izq">
<p style="font-size:12px">Website</p>
<div class="bot_info" style="top:26px;" onmouseout="hideTip()"  onmousemove="showTip(event,'Ingresa websites en los que podamos encontrar m&aacute;s informaci&oacute;n sobre tu proyecto. Esto ser&aacute; utilizado para evaluar tu propuesta.')"></div>

<div class="rounded_perfil">
<input value="<?if(isset($_POST['data']['Link'][0]['link'])){echo $_POST['data']['Link'][0]['link'];}?>" autocomplete="off"   id="web0" type="text" name="data[Link][0][link]" style="width:350px;"/>
<input  type="hidden" name="data[Link][0][model]" autocomplete="off" value="Project" />
</div>

<div class="rounded_perfil" style="display:none">
<input  value="<?if(isset($_POST['data']['Link'][1]['link'])){echo $_POST['data']['Link'][1]['link'];}?>" autocomplete="off"    id="web1" type="text" name="data[Link][1][link]" style="width:350px"/>
<input type="hidden" name="data[Link][1][model]" autocomplete="off" value="Project" />
</div>


<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($_POST['data']['Link'][2]['link'])){echo $_POST['data']['Link'][2]['link'];}?>"  autocomplete="off"    id="web2" type="text" name="data[Link][2][link]" style="width:350px"/>
<input type="hidden" name="data[Link][2][model]" autocomplete="off" value="Project" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($_POST['data']['Link'][3]['link'])){echo $_POST['data']['Link'][3]['link'];}?>"   autocomplete="off"  id="web3" type="text" name="data[Link][3][link]" style="width:350px"/>
<input type="hidden" name="data[Link][3][model]" autocomplete="off" value="Project" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($_POST['data']['Link'][4]['link'])){echo $_POST['data']['Link'][4]['link'];}?>"  autocomplete="off"   id="web4" type="text" name="data[Link][4][link]" style="width:350px"/>
<input type="hidden" name="data[Link][4][model]" autocomplete="off" value="Project" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($_POST['data']['Link'][5]['link'])){echo $_POST['data']['Link'][5]['link'];}?>"   autocomplete="off"   id="web5" type="text" name="data[Link][5][link]" style="width:350px"/>
<input type="hidden" name="data[Link][5][model]" autocomplete="off" value="Project" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($_POST['data']['Link'][6]['link'])){echo $_POST['data']['Link'][6]['link'];}?>"   autocomplete="off"   id="web6" type="text" name="data[Link][6][link]" style="width:350px"/>
<input type="hidden" name="data[Link][6][model]" autocomplete="off" value="Project" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($_POST['data']['Link'][7]['link'])){echo $_POST['data']['Link'][7]['link'];}?>"   autocomplete="off"   id="web7" type="text" name="data[Link][7][link]" style="width:350px"/>
<input type="hidden" name="data[Link][7][model]" autocomplete="off" value="Project" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($_POST['data']['Link'][8]['link'])){echo $_POST['data']['Link'][8]['link'];}?>"   autocomplete="off"   id="web8" type="text" name="data[Link][8][link]" style="width:350px"/>
<input type="hidden" name="data[Link][8][model]" autocomplete="off" value="Project" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<?if(isset($_POST['data']['Link'][9]['link'])){echo $_POST['data']['Link'][9]['link'];}?>"   autocomplete="off"   id="web9" type="text" name="data[Link][9][link]" style="width:350px"/>
<input type="hidden" name="data[Link][9][model]" autocomplete="off" value="Project" />
</div>

<div style="color:red;font-size:9px;position:relative; top:6px"><?php if (isset($validationErrorsArray['link']) && !empty($validationErrorsArray['link'])){echo $validationErrorsArray['link'];}?><?if(isset($validationErrorsArray['Link'])){echo 'La url ingresada no es v&aacute;lida';}?></div>



</div>
<div class="texto_how_izq">

</div>
<div style="font-style:italic;clear:both">Imagen & Video</div> <div class="misc_separador" style="width:100%"></div><br>
<div class="texto_how_izq">
<p style="font-size:12px">Imagen</p>

<div id="bajofoto1">Examinar...</div>
 <div id="extfoto2"><input onchange="if((this.value.toLowerCase().indexOf('.jpg')==-1) && (this.value.toLowerCase().indexOf('.jpeg')==-1) && (this.value.toLowerCase().indexOf('.gif')==-1) && (this.value.toLowerCase().indexOf('.png')==-1)){$('elfile2').innerHTML='<span style=&quot;color:red;font-size:9px&quot;>Formato de archivo no permitido.</span>';return;}$('elfile2').innerHTML=this.value" onmouseover="$('bajofoto1').style.background='#237fb5';" onmouseout="$('bajofoto1').style.background='#000';" id="foto1"  name="data[Project][file]" autocomplete="off" type="file" /></div>



<br><div id="elfile2">Selecciona un archivo</div>
<div style="color:red;font-size:9px;position:relative; top:6px"><?php if (isset($validationErrorsArray['file']) && !empty($validationErrorsArray['file'])){echo $validationErrorsArray['file'];}?></div>
<br>
<? if($this->Session->check('predefinido') && isset($fotito) && strlen($fotito)>4 && (!isset($_FILES['data']['name']['Project']['file']) || $_FILES['data']['name']['Project']['file']=='')){?>
<img style="max-width:280px" src="/<?=$fotito;?>">
<? } ?>

<div class="misc_separador" style=" width:367px; height:1px;"></div>
<div class="bot_info img" onmouseout="hideTip()"  onmousemove="showTip(event,'Elige una imagen para ilustrar tu proyecto. La imagen no es todo, pero es muy importante.<br>Sube una imagen de buena calidad, con un aspecto de 4:3 y un m&aacute;ximo de 560 x 430 pixeles aproximadamente.')"></div>
</div>
<div class="clear"></div>

<div class="texto_how_izq">
<p style="font-size:12px">Video (URL)</p>
<div class="rounded_crear">
<input value="<?if(isset($_POST['data']['Project']['video_url'])){echo $_POST['data']['Project']['video_url'];}?>" type="text"  autocomplete="off" name="data[Project][video_url]" />
<div class="bot_info" onmouseout="hideTip()"  onmousemove="showTip(event,'Ingresa la URL de un video propio sobre tu proyecto que hayas subido a YouTube.com o Vimeo.com (opcional).<br>El video es tu carta de presentaci&oacute;n. Demuestra la calidad de tu proyecto con un video de calidad. Tu proyecto se volver&aacute; mucho m&aacute;s confiable si les hablas a tus futuros patrocinadores y les demuestras tu capacidad y compromiso.')"></div>
</div>
<? if($this->Session->check('predefinido') && isset($_POST['data']['Project']['video_url']) && !empty($_POST['data']['Project']['video_url'])){ ?>
<?='<div style="height:20px"></div>'.getVideoFromURL($_POST['data']['Project']['video_url'])?>
<? } ?>
</div>
<div class="clear"></div>
<div style="font-style:italic">Recaudaci&oacute;n de fondos</div> <div class="misc_separador" style="width:100%"></div><br>
<div id="fondos_requeridos">
<div class="input_fondos">
<div id="quemoneda" style="color:#686b68; width:50px; height:30px; text-align:right; line-height:30px;font-size:15px;font-weight:normal; position:absolute; left:-45px;top:20px;font-family:Arial, Helvetica, sans-serif"><?if(!isset($_POST['data']['Project']['moneda'])){?>USD<? }else{?><?=traducirMoneda($_POST['data']['Project']['moneda'])?><? } ?></div>
<input value="<?if(isset($_POST['data']['Project']['funding_goal'])){echo $_POST['data']['Project']['funding_goal'];}?>" id="in_fondos" type="text" name="data[Project][funding_goal]" /></div>
<div style="color:red;font-size:9px;position:relative; top:116px; left:80px"><?php if (isset($validationErrorsArray['funding_goal']) && !empty($validationErrorsArray['funding_goal'])){echo $validationErrorsArray['funding_goal'];}?></div>

<div class="bot_info" onmouseout="hideTip()"  onmousemove="showTip(event,'Ingresa el monto en d&oacute;lares que necesitas para realizar tu proyecto. Podr&aacute;s modificar este importe una vez aprobada tu propuesta.<br>Recuerda que si al cabo del tiempo elegido a continuaci&oacute;n tu proyecto no recauda este monto, no ser&aacute; financiado. Piensa en una suma que est&eacute;s en condiciones de recaudar en el tiempo previsto.')"></div>
<div style="position:absolute; width:534px; height:148px; background:url(/2012/images/tipodemoneda.jpg); left:420px; top:0">
<label style="position:absolute; height:15px;width:300px;  left:0; top:98px; text-align:left; margin:0; padding:0" for="usd">
    <input onchange="if(this.checked){$('quemoneda').innerHTML=this.value;window.lamoneda=this.value;changeBoxesMoneda();}" value="USD" style="margin:0; padding:0;width:15px;position:relative;top:-2px" type="radio" name="data[Project][moneda]" id="usd" <?if((isset($_POST['data']['Project']['moneda']) && $_POST['data']['Project']['moneda']=='USD') || !isset($_POST['data']['Project']['moneda'])){?>checked="checked"<? } ?>>
</label>
<label style="position:absolute; height:15px;width:300px;  left:0; top:125px; text-align:left; margin:0; padding:0" for="ars">
    <input onchange="if(this.checked){$('quemoneda').innerHTML='ARS';window.lamoneda='ARS';changeBoxesMoneda();}" value="ARS" style="margin:0; padding:0;width:15px;position:relative;top:-2px" type="radio" name="data[Project][moneda]" id="ars" <?if(isset($_POST['data']['Project']['moneda']) && $_POST['data']['Project']['moneda']=='ARS'){?>checked="checked"<? } ?>>
</label>
</div>
</div>

<div class="texto_how_izq">
<p style="font-size:12px">Duraci&oacute;n del proyecto</p><br>
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
<div id="beneficiosyrecompensas" style="font-style:italic">Beneficios & Recompensas</div> <div class="misc_separador" style="width:100%"></div><br>
<div class="titulos_beneficios">Beneficios para Personas</div>
<div class="titulos_beneficios empresas">Beneficios para Empresas</div>
<div class="clear"></div>
<div id="beneficios_personas_crear">
<div class="monto_crear"><p style="font-size:12px">Monto M&iacute;nimo</p><br>
<div class="rounded_crear beneficio">
<input style="width:70px; " type="text" name="nombre" id="mminazul" />
</div>
</div>
<div class="desc_crear"><p style="font-size:12px">Descripci&oacute;n</p><br>
<script>
function noenter(e){
	var evt=e || window.event;
	var key=evt.keyCode || evt.which;
	if(key==13)return false;
	return true;
}
</script>
<div class="rounded_area_beneficios">
<textarea onkeypress="return noenter(event)" name="comments" cols="1" rows="1" id="descrazul"></textarea>
<div id="errP" style="color:red;font-size:9px;position:relative; top:6px; left:10px"></div>
<div class="bot_info_beneficio" onmouseout="hideTip()"  onmousemove="showTip(event,'Ingresa los beneficios que recibir&aacute;n tus patrocinadores de acuerdo al monto que elijan aportar a tu proyecto.<br>Los beneficios son regalos o premios relacionados con el proyecto, que te comprometes a darles a tus patrocinadores.<br>Podr&aacute;s modificar esto una vez aprobada tu propuesta.<br>Ten en mente que muchos patrocinadores s&oacute;lo est&aacute;n interesados en los beneficios.<br>Ofrece recompensas atractivas y acorde al monto del aporte.')"></div>
<div class="bot_crear_nuevo" onclick="addBeneficio($('mminazul').value, $('descrazul').value, 'personas');">CREAR</div>

</div>

</div>

<div class="separador_azul" style="height:0; overflow:hidden;"></div>
<div id="contazul">

</div>

</div>

<div id="beneficios_empresas_crear">

<div class="monto_crear"><p style="font-size:12px">Monto M&iacute;nimo</p><br>
<div class="rounded_crear beneficio">
<input style="width:70px; " type="text" name="nombre" id="mminverde" />
</div>
</div>
<div class="desc_crear"><p style="font-size:12px">Descripci&oacute;n</p><br>
<div class="rounded_area_beneficios">
<textarea onkeypress="return noenter(event)" name="comments" cols="1" rows="1" id="descverde"></textarea>
<div id="errE" style="color:red;font-size:9px;position:relative; top:6px; left:10px"></div>
<div class="bot_info_empresas"  onmouseout="hideTip()"  onmousemove="showTip(event,'Ingresa los beneficios que recibir&aacute;n tus patrocinadores de acuerdo al monto que elijan aportar a tu proyecto.<br>Los beneficios son regalos o premios relacionados con el proyecto, que te comprometes a darles a tus patrocinadores.<br>Podr&aacute;s modificar esto una vez aprobada tu propuesta.<br>Ten en mente que muchos patrocinadores s&oacute;lo est&aacute;n interesados en los beneficios.<br>Ofrece recompensas atractivas y acorde al monto del aporte.')"></div>
<div class="bot_crear_nuevo empresas" onclick="addBeneficio($('mminverde').value, $('descverde').value, 'empresa');">CREAR</div>

</div>

</div>

<div class="separador_verde" style="height:0; overflow:hidden;"></div>
<div id="contverde">

</div>


</div>
<div style="clear:both"></div>
<div style="color:red;font-size:9px;position:relative; top:6px"><?php if (isset($validationErrorsArray['prize']) && !empty($validationErrorsArray['prize'])){echo $validationErrorsArray['prize'];}?></div>

</form>
<a onclick="$('fproy').submit();return false;" class="bot_envnuevoproy" href="#">ENVIAR PROPUESTA</a>
</div>
<script>
function changeBoxesMoneda(){
	var els=getElementsByClassName('lamonedaelegida'), l=els.length;
	for(var i=0;i<l;i++){
		els[i].innerHTML=window.lamoneda;
	}
}
<?if(isset($_POST['data']['Project']['moneda'])){?>
window.lamoneda='<?=traducirMoneda($_POST['data']['Project']['moneda'])?>';
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
	var html='	<div id="'+id+'"><input type="hidden" name="data[Prize]['+window.memo.index+'][model]" autocomplete="off" value="Project" />	<input type="hidden" name="data[Prize]['+window.memo.index+'][value]" autocomplete="off" value="'+monto+'" />	<input name="data[Prize]['+window.memo.index+'][description]" type="hidden" autocomplete="off" value="'+descripcion+'" />	<input name="data[Prize]['+window.memo.index+'][ente]" type="hidden" autocomplete="off" value="'+elente+'" />	'+sep+'<div class="beneficio_creado'+ente+'"><h3 class="'+colortxt+'">Aportando <span class="lamonedaelegida">'+window.lamoneda+'</span> '+monto+'</h3><p class="texto_proyecto" style="color:#383938; height:60px; overflow:auto;">'+descripcion+'</p><div onclick="$(&quot;'+id+'&quot;).parentNode.removeChild($(&quot;'+id+'&quot;));" class="borrar_beneficio'+ente+'"></div><div onclick="$(&quot;'+campos[0]+'&quot;).value=&quot;'+monto+'&quot;;$(&quot;'+campos[1]+'&quot;).value=&quot;'+descripcion+'&quot;;$(&quot;'+id+'&quot;).parentNode.removeChild($(&quot;'+id+'&quot;));location=&quot;#beneficiosyrecompensas&quot;" class="editar_beneficio'+ente+'"></div></div></div>';
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
<?if(isset($_POST['data']['Project']['project_duration'])){?>
DR(function(){
	
	$('ProjectProjectDuration').value=<?=$_POST['data']['Project']['project_duration']?>;
	var r=Math.round($('ProjectProjectDuration').value/365*343);
	$('cursor').style.left=r+'px';
	setBlueLine(r)
});
<? } ?>
<? if(isset($_POST['data']['Prize'])){?>
	
DR(function(){
<?	
	foreach($_POST['data']['Prize'] as $k=>$v){
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
