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
?>
<h3 class="breadcrumb title underline full">Modificar / borrar proyectos predefinidos:</h3>
<style>
th{ color:#FFF; background:#000; text-align:left}

</style>
<script>
function deletePredefinido(id){
	if(confirm('<?=utf8_encode('¿Está');?> seguro de eliminar este item?')){
		document.getElementById('ifr').src='/proceso.php?proceso=borrarPredefinido&id='+id;
	}
}
</script>
<table width="600" border="0">
  <tr>
    <th >T&iacute;tulo</th>
    <th >Imagen/Video</th>
    <th >Modificar</th>
    <th >Borrar</th>
  </tr>
  <? foreach($proyectoPredefinido as $v){?>
  <tr>
    <td><?=$v['title']?></td>
    <td><? if(!empty($v['video'])){echo getVideoFromURL($v['video']);}else{echo '<img style="max-width:560px" src="/'.$v['foto'].'">';}?></td>
    <td align="center"><a href="/admin/predefinidos/create/<?=$v['id']?>"><img border="0" src="/2012/images/edit.gif" width="38" height="34" /></a></td>
    <td align="center"><a onclick="deletePredefinido('<?=$v['id']?>');return false;" href="#"><img border="0" src="/2012/images/trash.gif" width="35" height="42" /></a></td>
  </tr>
  <? } ?>
</table>
<iframe id="ifr" name="ifr" style="width:0; height:0; position:absolute; top:-15000px;"></iframe>