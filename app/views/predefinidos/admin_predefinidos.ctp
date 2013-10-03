<?
function getVideoFromURL($u){
	$pos=strpos($u, 'vimeo');
	$code=end(explode('v=',$u));
	$code=end(explode('/',$code));
	if(strpos($code, '&')!==false){
		$code=explode('&',$code);
		$code=$code[0];
	}
	
	if($pos===false){
	    $ret='<iframe width="560" height="315" src="http://www.youtube.com/embed/'.$code.'" frameborder="0" allowfullscreen></iframe>';
	}else{
		$ret='<iframe src="http://player.vimeo.com/video/'.$code.'" width="560" height="315" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe> ';
	}
	return $ret;
}
$modificar=0;
if(isset($proyectoPredefinido) && !empty($proyectoPredefinido)){
    $modificar=1;
	$proyectoPredefinido=$proyectoPredefinido[0];
}
asort($base_categories);
?>
<style>

.tablapredefuno{width:239px !important; text-align:right;}
</style>
<script>
function _(x){return document.getElementById(x);}
function addBeneficio(tipo,monto,concepto){
	if(concepto.length>0 && monto.length>0 && concepto.length<10){
		alert('el concepto ingresado es demasiado breve');
		return;
	}
	_('colector'+tipo).innerHTML+='<div>        <strong>Monto: </strong><span class="moneda">'+window.lamoneda+'</span> '+monto+'<br />        <strong>Concepto: </strong>'+concepto+'<br />       <input onclick="this.parentNode.parentNode.removeChild(this.parentNode)" type="button" name="button3" id="button3" value="Eliminar" />   <input name="value[]" type="hidden" value="'+monto+'" />        <input name="description[]" type="hidden" value="'+concepto+'" />        <input name="ente[]" type="hidden" value="'+tipo.substr(0,1).toUpperCase()+'" />          <input name="model[]" type="hidden" value="Predefinido" />      </div>';
	_('v1').value=_('d1').value=_('v2').value=_('d2').value='';
}
function validar(e) { // 1
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
    patron =/\d/; // 4
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
} 
window.lamoneda='ARS';
function changeBoxesMoneda(){
	var els=getElementsByClassName('moneda'), l=els.length;
	for(var i=0;i<l;i++){
		els[i].innerHTML=window.lamoneda;
	}
}
function getElementsByClassName(rel,scope){
    var col=[];
	var sc=scope || document;
    var tCol=sc.getElementsByTagName('*');
    for(var ii=0;ii<tCol.length;ii++)
        if(tCol[ii].className==rel)
            col.push(tCol[ii])
    return col;
}  
function noenter(e){
	var evt=e || window.event;
	var key=evt.keyCode || evt.which;
	if(key==13)return false;
	return true;
}
function validaform(){
	
	if((_('short_description').value.length<50 || _('short_description').value.length>140)){
		alert("Ingrese una descripci<?=utf8_encode('�')?>n que posea entre 50 y 140 caracteres");
		return false;
	}
	return true;
}
</script>
<h3 class="breadcrumb title underline full"><?if(!$modificar){?>Ingresar<? }else{ ?>Modificar<? } ?> proyecto predefinido:</h3>
<form onsubmit="return validaform()" target="ifr" action="/proceso.php" method="post" enctype="multipart/form-data" name="f1" id="f1">
   <table width="600" border="0">
    <tr>
      <td class="tablapredefuno" width="239" align="right" valign="top"><?__("ADMIN_PROJECTS_FILTER_SORT_PROJECT.TITLE");?></td>
      <td width="351">
        <textarea autocomplete="off" name="title" id="title" cols="45" rows="5"><? if($modificar){?><?=$proyectoPredefinido['title'];?><? } ?></textarea>
      </td>
    </tr>
    <tr>
      <td  class="tablapredefuno" align="right" valign="top"><?__("PROJECT__CATEGORY");?></td>
      <td>
        <select autocomplete="off" name="category_id" id="category_id">
        <? foreach($base_categories as $k=>$v){ 
		$selected=($modificar && $proyectoPredefinido['category_id']==$k)?' selected="selected" ':'';
		?>
          <option<?=$selected;?> value="<?=$k?>"><?=$v?></option>
        <?php } ?>
        </select>
      </td>
    </tr>
	<tr>
      <td class="tablapredefuno" align="right" valign="top"><?__("PROJECT__SHORT_DESCRIPTION");?></td>
      <td><textarea autocomplete="off" name="short_description" id="short_description" cols="45" rows="5"><? if($modificar){?><?=$proyectoPredefinido['short_description'];?><? } ?></textarea></td>
    </tr>
    <tr>
      <td class="tablapredefuno" align="right" valign="top"><?__("PROJECT__DESCRIPTION");?></td>
      <td><textarea autocomplete="off" name="la_description" id="la_description" cols="45" rows="5"><? if($modificar){?><?=$proyectoPredefinido['description'];?><? } ?></textarea></td>
    </tr>
	<tr>
      <td class="tablapredefuno" align="right" valign="top"><?__("MOTIVATION_ADMIN");?></td>
      <td><textarea autocomplete="off" name="motivation" id="motivation" cols="45" rows="5"><? if($modificar){?><?=$proyectoPredefinido['motivation'];?><? } ?></textarea></td>
    </tr>
    <tr>
      <td class="tablapredefuno" align="right" valign="top"><?__("REASON");?>&nbsp;</td>
      <td><textarea autocomplete="off" name="reason" id="reason" cols="45" rows="5"><? if($modificar){?><?=$proyectoPredefinido['reason'];?><? } ?></textarea></td>
    </tr>
    <tr>
      <td  class="tablapredefuno" align="right" valign="top"><?__("PROJECT_IMAGE");?></td>
      <td>
        <input autocomplete="off" type="file" name="foto" id="foto" />
		<? if($modificar && !empty($proyectoPredefinido['foto'])){?><?='<br><img style="max-width:560px" src="/'.$proyectoPredefinido['foto'].'">';?><? } ?>
      </td>
    </tr>
    <tr>
      <td  class="tablapredefuno" align="right" valign="top"><?__("OFFER__VIDEO_URL");?></td>
      <td>
        <input value="<? if($modificar){?><?=$proyectoPredefinido['video'];?><? } ?>" autocomplete="off" style="width:300px" type="text" name="video" id="video" />
      <? if($modificar && !empty($proyectoPredefinido['video'])){?><?='<br>'.getVideoFromURL($proyectoPredefinido['video']);?><? } ?>
	  </td>
    </tr>
    <tr>
      <td  class="tablapredefuno" align="right" valign="top"><?__("FONDO");?></td>
      <td>
        <input value="<? if($modificar){?><?=$proyectoPredefinido['funding_goal'];?><? } ?>"   onkeypress="return validar(event)" autocomplete="off" type="text" name="funding_goal" id="funding_goal" />
      </td>
    </tr>
    <tr>
      <td  class="tablapredefuno" align="right" valign="top"><?__("Moneda");?></td>
      <td>
        <select onchange="window.lamoneda=this.value;changeBoxesMoneda();" autocomplete="off" name="moneda" id="moneda">
          <option<?if($modificar && $proyectoPredefinido['moneda']=='ARS'){echo ' selected="selected" ';}?> value="ARS">ARS</option>
          <option<?if($modificar && $proyectoPredefinido['moneda']=='USD'){echo ' selected="selected" ';}?> value="USD">USD</option>
        </select>
      </td>
    </tr>
	<tr>
      <td  class="tablapredefuno" align="right" valign="top"><?__("PROJECT__PROJECT_DURATION");?></td>
      <td>
        <input value="<? if($modificar){?><?=$proyectoPredefinido['project_duration'];?><? } ?>"   onkeypress="return validar(event)" autocomplete="off" type="text" name="project_duration" id="project_duration" />
      </td>
    </tr>
    <tr>
      <td  class="tablapredefuno" align="right" valign="top"><?__("BENEFISTS_FOR_PEOPLE");?></td>
      <td>Monto:<br />
        
          <input autocomplete="off"  onkeypress="return validar(event)" type="text" name="v1" id="v1" />
          <br />
          Concepto:<br />
          <textarea autocomplete="off" onkeypress="return noenter(event)" name="d1" id="d1" cols="45" rows="5"></textarea>
          <br />
          <input onclick="if(_('v1').value.length && _('d1').value.length)addBeneficio('personas',_('v1').value,_('d1').value)" type="button" name="button2" id="button2" value="<?__("ADD_ADMIN_BUTTON");?>" />
        
        <div id="colectorpersonas">
        
        </div></td>
    </tr>
    <tr>
      <td  class="tablapredefuno" align="right" valign="top"><?__("CORPORATE_BENEFIST");?></td>
      <td>Monto:<br />
        
          <input autocomplete="off"  onkeypress="return validar(event)" type="text" name="v2" id="v2" />
          <br />
          Concepto:<br />
          <textarea autocomplete="off" onkeypress="return noenter(event)" name="d2" id="d2" cols="45" rows="5"></textarea>
          <br />
          <input onclick="if(_('v2').value.length && _('d2').value.length)addBeneficio('empresas',_('v2').value,_('d2').value)" type="button" name="button2" id="button3" value="<?__("ADD_ADMIN_BUTTON");?>" />
        
        <div id="colectorempresas">
        
        </div></td>
    </tr>
     <tr>
      <td align="right" valign="top">&nbsp;</td>
      <td>
        <input type="submit" name="button" id="button" value="<?__("SEND");?>" />
		<? if($modificar){?>
		<input name="proceso" type="hidden" id="proceso" value="modificarpredefinido" />
		<input name="id" type="hidden" id="id" value="<?=$proyectoPredefinido['id'];?>" />
		<? }else{ ?>
		<input name="proceso" type="hidden" id="proceso" value="crearpredefinido" />
		<? } ?>
      </td>
    </tr>
  </table>
</form>
<? if($modificar){?>
<script>
<? foreach($pers as $v){?>
	addBeneficio('personas','<?=$v['value']?>','<?=$v['description']?>');
<? } ?>
<? foreach($empr as $v){?>
	addBeneficio('empresas','<?=$v['value']?>','<?=$v['description']?>');
<? } ?>
</script>
<? } ?>
<iframe id="ifr" name="ifr" style="width:0; height:0; position:absolute; top:-15000px;"></iframe>
