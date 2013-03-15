<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script>
function _(x){return document.getElementById(x);}
function validar(e) { // 1
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
    patron =/\d/; // 4
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
} 
function addBeneficio(tipo,monto,concepto){
	_('colector'+tipo).innerHTML+='<div>        <strong>Monto: </strong><span class="moneda">'+window.lamoneda+'</span> '+monto+'<br />        <strong>Concepto: </strong>'+concepto+'<br />       <input onclick="this.parentNode.parentNode.removeChild(this.parentNode)" type="button" name="button3" id="button3" value="Eliminar" />   <input name="value[]" type="hidden" value="'+monto+'" />        <input name="description[]" type="hidden" value="'+concepto+'" />        <input name="ente[]" type="hidden" value="'+tipo.substr(0,1).toUpperCase()+'" />          <input name="model[]" type="hidden" value="Predefinido" />      </div>';
	_('v1').value=_('d1').value=_('v2').value=_('d2').value='';
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
</script>
</head>

<body>
<form action="/proceso.php" method="post" enctype="multipart/form-data" name="f1" id="f1">
  <table width="600" border="0">
    <tr>
      <td class="tablapredefuno" width="239" align="right" valign="top">T&iacute;tulo&nbsp;</td>
      <td width="351"><label>
        <textarea autocomplete="off" name="title" id="title" cols="45" rows="5"></textarea>
      </label></td>
    </tr>
    <tr>
      <td  class="tablapredefuno" align="right" valign="top">Categor&iacute;a&nbsp;</td>
      <td><label>
        <select name="category_id" id="category_id">
        <? foreach($base_categories as $k=>$v){ ?>
          <option value="<?=$k?>"><?=$v?></option>
        <?php } ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td class="tablapredefuno" align="right" valign="top">Descripci&oacute;n&nbsp;</td>
      <td><textarea name="description" id="description" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td class="tablapredefuno" align="right" valign="top">Razones para patrocinar el proyecto&nbsp;</td>
      <td><textarea name="reason" id="reason" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td  class="tablapredefuno" align="right" valign="top">Imagen&nbsp;</td>
      <td><label>
        <input type="file" name="foto" id="foto" />
      </label></td>
    </tr>
    <tr>
      <td  class="tablapredefuno" align="right" valign="top">Video (URL)&nbsp;</td>
      <td><label>
        <input style="width:300px" type="text" name="video" id="video" />
      </label></td>
    </tr>
    <tr>
      <td  class="tablapredefuno" align="right" valign="top">Fondos&nbsp;</td>
      <td><label>
        <input type="text" name="funding_goal" id="funding_goal" />
      </label></td>
    </tr>
    <tr>
      <td  class="tablapredefuno" align="right" valign="top">Moneda&nbsp;</td>
      <td><label>
        <select name="moneda" id="moneda">
          <option value="ARS">ARS</option>
          <option value="USD">USD</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td  class="tablapredefuno" align="right" valign="top">Beneficios para personas&nbsp;</td>
      <td>Monto:<br />
        <label>
          <input onkeypress="return validar(event)" type="text" name="v1" id="v1" />
          <br />
          Concepto:<br />
          <textarea onkeypress="return noenter(event)" name="d1" id="d1" cols="45" rows="5"></textarea>
          <br />
          <input onclick="if(_('v1').value.length && _('d1').value.length)addBeneficio('personas',_('v1').value,_('d1').value)" type="button" name="button2" id="button2" value="A&ntilde;adir" />
        </label>
        <div id="colectorpersonas">
        
        </div></td>
    </tr>
    <tr>
      <td  class="tablapredefuno" align="right" valign="top">Beneficio para empresas</td>
      <td>Monto:<br />
        <label>
          <input onkeypress="return validar(event)" type="text" name="v2" id="v2" />
          <br />
          Concepto:<br />
          <textarea onkeypress="return noenter(event)" name="d2" id="d2" cols="45" rows="5"></textarea>
          <br />
          <input onclick="if(_('v2').value.length && _('d2').value.length)addBeneficio('empresas',_('v2').value,_('d2').value)" type="button" name="button2" id="button3" value="A&ntilde;adir" />
        </label>
        <div id="colectorempresas">
        
        </div></td>
    </tr>
     <tr>
      <td align="right" valign="top">&nbsp;</td>
      <td><label>
        <input type="submit" name="button" id="button" value="Enviar" />
        <input name="proceso" type="hidden" id="proceso" value="crearpredefinido" />
      </label></td>
    </tr>
  </table>
</form>
<iframe id="ifr" name="ifr" style="width:0; height:0; position:absolute; top:-15000px;"></iframe>

</body>
</html>