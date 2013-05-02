<?php /* @var $this ViewCC */ ?>
<?

function friendlyUrl ($str = '') {

    $friendlyURL = htmlentities($str, ENT_COMPAT, "UTF-8", false); 
    $friendlyURL = preg_replace('/&([a-z]{1,2})(?:acute|lig|grave|ring|tilde|uml|cedil|caron);/i','\1',$friendlyURL);
    $friendlyURL = html_entity_decode($friendlyURL,ENT_COMPAT, "UTF-8"); 
    $friendlyURL = preg_replace('/[^a-z0-9-]+/i', '-', $friendlyURL);
    $friendlyURL = preg_replace('/-+/', '-', $friendlyURL);
    $friendlyURL = trim($friendlyURL, '-');
    $friendlyURL = strtolower($friendlyURL);
    return $friendlyURL;

}
$this->set('pageTitle', false); ?>

<? if($this->data['WeekProjects']) { ?>
<script type="text/javascript">
    $proyectosem='<?php echo __("Subtitle");?>';/*VARIABLE CAMBIO DE IDIOMA SLIDER*/

    DR(
            function(){
                if($('corjurto'))
                    createSlideHome(
                            [
                                <?
                                foreach($this->data['WeekProjects'] as $v){
                                $img=str_replace('.jpg','.png','media/filter/l560/'.$v['Project']['dirname'].'/'.$v['Project']['basename']);

                                if (file_exists($img) ){
                                    $img='/comodo.php?imagen=media/filter/l560/'.$v['Project']['dirname'].'/'.$v['Project']['basename'];
                                    $img=str_replace('.jpg','.png',$img);

                                }else{
                                    $img='/comodo.php?imagen=img/assets/img_default_280x210px.png';
                                }
                                $imgficha=$v['Project']['moneda']=='USD'?'ficha':'fichapesos';
                                if($v['Project']['leading']==1 && strlen($v['Project']['videoid'])>2 && strlen($v['Project']['videotype'])>2){
                                    $descw = __("SUCCESFUL_PROJECT",$return = true);
                                }else{
                                    $descw= __("HIGHLIGHT_PROJECTS_TITLE1",$return = true);
                                }
                                //$descw=($v['Project']['leading']==1 && strlen($v['Project']['videoid'])>2 && strlen($v['Project']['videotype'])>2)?'CASOS DE &Eacute;XITO': __("RECOVER_PASSWORD_1");/*ACA ESTO*/
                                $button=($v['Project']['leading']==1 && strlen($v['Project']['videoid'])>2 && strlen($v['Project']['videotype'])>2)?'<div onclick="verVideo(&quot;'.$v['Project']['videoid'].'&quot;,&quot;'.$v['Project']['videotype'].'&quot;,&quot;'.$modules->js_encode($v['Project']['title']).'&quot;,&quot;'.$modules->js_encode($v['User']['display_name']).'&quot;,&quot;'.Project::getLink($v).'&quot;,&quot;'.User::getLink($v).'&quot;)" class="boton_videocaso"><span class="texto_boton">'.__("SHOW_VIDEO",$return=true).'<span></div>':'<div onclick="window.location=&quot;'.Project::getLink($v).'&quot;;" class="boton_explorar">'.__("PROJECT_EXPLORER",$return=true).'</div>';
                                ?>
                                '<div id="foto" style="background:url( <?=$img ?>) center center no-repeat"></div><div id="descripcion"><h2 style="color:#FFF"><?=$descw?></h2><h5 class="titulo_categoria" style="color:#666;"><a href="<?=$modules->js_encode(Category::getLink($v));?>"><?=$modules->js_encode(Category::getName($v));?></a></h5><br><h3 class=titulo_proyecto><a href="<?=$modules->js_encode(Project::getLink($v));?>"><?=$modules->js_encode($v['Project']['title']);?></h3><span class="autor"><?php echo __("by");?><a href="<?=User::getLink($v)?>"><?=$modules->js_encode($v['User']['display_name']);?></a></span><br><p class="texto_destacado"><?=$modules->js_encode($v['Project']['short_description']);?></p><br>	<table  style="position:relative; display:inline-block" width="200" border="0" align="center" class="tabla_proyectos">	  <tr>    	<td width="71" align="center"><?= Project::getFundedValue($v) ?>%</td>	    <td width="121" align="center"><?= Project::getCollectedValue($v) ?></td>	    <td width="81" align="center"><?= $v['Project']['sponsorships_count']; ?></td>	  </tr>	</table>	<img src="/2012/images/<?=$imgficha?>.png" width="288" height="16"> <?=$button?></div>',
                                <? } ?>

                            ],$('corjurto'),$('thumbs_destacados')
                    );

            });

</script>
<? } ?>
<script type="text/javascript">
function setVideoPersonas(){
	$('pestana_personas_on').style.backgroundPosition='0px 0px';
	$('pestana_empresas_out').style.backgroundPosition='-150px -54px';
	$('video_home').innerHTML='<iframe src="http://player.vimeo.com/video/44255570?title=0&amp;byline=0&amp;portrait=0&amp;color=008ed3" width="480" height="270" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
	$('pestana_personas_on').style.top='8px';
	$('pestana_empresas_out').style.top='10px';
	$('video_home').style.background='#08659b';
}
function setVideoEmpresas(){
	$('pestana_personas_on').style.backgroundPosition='0px -54px';
	$('pestana_empresas_out').style.backgroundPosition='-150px 0px';
	$('video_home').innerHTML='<iframe src="http://player.vimeo.com/video/46236159?title=0&amp;byline=0&amp;portrait=0&amp;color=68bc58" width="480" height="270" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
	$('pestana_personas_on').style.top='10px';
	$('pestana_empresas_out').style.top='8px';
	$('video_home').style.background='#58aa4a';
}
</script>
<img style="position:absolute; left:50%; margin-left:-478px; top:541px;" src="/2012/images/sombra_header.png" width="957" height="20">
<div id="banner">
<div id="welcome">
<h1><?php echo __("WELCOME-TITLE");?>Groofi.com</h1><br>
<p class="subtitle_banner"><?php echo __("GROOFI_INTRODUCTION");?></p><br>
<p style="font-size:13px"><?php echo __("GROOFI_INTRODUCTION_SUB");?></p><br>
<div class="boton_crear" onclick="window.location='<?= Router::url (array ('controller' => 'projects', 'action' => 'add'))?>';"><?php echo __("PROJECT_ADD_FIRST_BLOCK_TITLE");?>!</div>
<div class="boton_how"  onclick="window.location='/como-funciona'"><?php echo __("HOW_WORK");?></div>
  <div class="clear"></div>
</div>
<div id="video_home"><iframe src="http://player.vimeo.com/video/44255570?title=0&amp;byline=0&amp;portrait=0&amp;color=008ed3" width="480" height="270" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>
  <div class="clear"></div>
<div onclick="setVideoPersonas();" id="pestana_personas_on"><?php echo __("%s MEMBERS");?></div>
<div onclick="setVideoEmpresas();" id="pestana_empresas_out"><?php echo __("BUSI_NESS");?></div>
<div class="clear"></div>
<div id="relleno_izq"></div>

</div>
<? if($this->data['WeekProjects']) { ?>
<br>
    <table  style="position:absolute; display:inline-block" width="300" border="0" align="center" class="homeslider">	  <tr>
        <td width="120" align="center"><?php echo __("VIEW_FUNDED_ADMIN_INDEX1");?></td>
        <td width="120" align="center"><?php echo __("|");?></td>
        <td width="120" align="center"><?php echo __("RECAUDADOS");?></td>
        <td width="120" align="center"><?php echo __("|");?></td>
        <td width="120" align="center"><?php echo __("SPONSORSHIPS_INDEX");?></td>	  </tr>
    </table>
<div id="proyecto_destacado">
  <div id="tool"><a href="#" id="play"></a><a href="#" id="pause"></a><a href="#" id="at"></a><a href="#" id="ad"></a></div>
<div id="corjurto"> 

</div>

    <div class="clear"></div>
    <div id="thumbs_destacados" class="thumbs_destacados">
	 <? $i=0;foreach($this->data['WeekProjects'] as $v){ 
					$img=str_replace('.jpg','.png','media/filter/m200/'.$v['Project']['dirname'].'/'.$v['Project']['basename']);
					if (file_exists($img) ){
						$img='/crop_120.php?imagen=media/filter/m200/'.$v['Project']['dirname'].'/'.$v['Project']['basename'];
						$img=str_replace('.jpg','.png',$img);
					}else{
						$img='/crop_120.php?imagen=img/assets/img_default_280x210px.png';	
					}
					
	?>
      <div class="thumb"><img onMouseOver="overThumb(this.getAttribute('data-index'),parseInt(this.getAttribute('data-index'))+1,this.getAttribute(''))" onclick="clickTn(<?=$i?>)" data-index="<?=$i?>" data-titulo="<?=htmlentities($v['Project']['title'],ENT_QUOTES,'UTF-8');?>" src="<?=$img ?>" width="120" height="120"></div>	
     <? $i++;} ?>
	  <div id="velo"></div>
        <div id="titulovelo"></div>  
      <div onClick="clickTn(parseInt(this.getAttribute('custom'))-1)" onMouseOut="outThumb()" id="titulovelo2"></div>
         <div   id="velo2"></div>
      
      <div class="clear"></div>
    </div>

   
</div>
<br>
<? } ?>
<? if($this->data['HighlightProjects']) { ?>
<br>
<h2 class="cyan"><?php echo __("PROJECTS CREATED");?></h2>

<br><br>
<div id="filtro">
<div id="filtro_categorias">
<h4  style="cursor:pointer"  class="titulo_footer"><?php echo __("SEARCH_BY_CATEGORY");?></h4>
<img  style="cursor:pointer"   class="misc_categorias02" src="/2012/images/misc_categorias02.png" width="19" height="16">
<div class="clear"></div>
<div style="width:956px" class="misc_separador"></div><br>
<div class="listado_categorias">
<?php 
$categorias=Project::getCategories('categorias');

for($i=0;$i<count($categorias);$i++){

?>
<ul><a href="<? echo Category::getLink($categorias[$i]['categories']);?>"><? echo Category::getName($categorias[$i]['categories']);?></a></ul>
<?php } ?>
</div>
</div>
<div id="mostrar">
<h4  style="cursor:pointer"  class="titulo_footer"><?php echo __("FILTER_TITLE_LIMIT");?></h4>
<img  style="cursor:pointer"  class="misc_categorias02" src="/2012/images/misc_categorias02.png" width="19" height="16">
<div class="clear"></div>
<div style="width:2px" class="misc_separador"></div><br>
<div class="listado_categorias">
<?php 
$mostrar=Project::getCategories('mostrar');
foreach($mostrar as $k=>$v){

?>
<ul><a href="/discover/<?=$k?>/projects"><?= $v; ?></a></ul>
<?php } ?>
</div>

</div>



<div id="ubicacion">


    <h4  style="cursor:pointer"  class="titulo_footer"><?php echo __("LOCATION");?></h4>
<img  style="cursor:pointer"  class="misc_categorias02" src="/2012/images/misc_categorias02.png" width="19" height="16">
<div class="clear"></div>
<div style="width:2px" class="misc_separador"></div><br>




    <!--div class="ubicacion_proyecto">

        <select autocomplete="off"  name="data[Project][paislugar]" autocomplete="off" id="ProjectCountryId">
            <? foreach($base_countries as $k=>$v){ ?>
            <option <?if(isset($_POST['data']['Project']['paislugar']) && $_POST['data']['Project']['paislugar']==$k['Country']['PAI_ISO2']){echo ' selected="selected" ';}?> value="<?=$v['Country']['PAI_ISO2']?>"><?=$v['Country']['PAI_NOMBRE']?></option>

            <? } ?>

        </select>


    </div>
</div-->



<div class="listado_ubicaciones">
<ul><a href="/discover/projects"><?php echo __("ALL_COUNTRIES");?></a></ul>
<?php
$ubicacion=Project::getCategories('ubicacion');
$ciudades=array();
for($i=0;$i<count($ubicacion);$i++){
$ciudades['City']=$ubicacion[$i]['cities'];
?>
<ul><a href="<? echo City::getLink($ciudades,  array('extra' => 'projects'));?>"><? echo City::getName($ciudades);?></a></ul>
<?php } ?>

</div>

</div>
<div class="clear"></div>
</div>

<div id="proyectos_creados">
<?php
$clases=array('proyecto_izq','proyecto_centro','proyecto_der');
$i=0;
foreach($this->data['HighlightProjects'] as $v){ 
					$img=str_replace('.jpg','.png','media/filter/l560/'.$v['Project']['dirname'].'/'.$v['Project']['basename']);
					if (file_exists($img)){
						$img='/comodo_284_179.php?imagen=media/filter/l560/'.$v['Project']['dirname'].'/'.$v['Project']['basename'];
						$img=str_replace('.jpg','.png',$img);
					}else{
						$img='/comodo_284_179.php?imagen=img/assets/img_default_280x210px.png';	
					}
					$imgficha=$v['Project']['moneda']=='USD'?'tabla_proyectos':'tabla_proyectospesos';
?>
  <div  class="<?php echo $clases[$i%3];?>">
 <div style="position:absolute; width:100%; left:0;">
	<a href="<?= Project::getLink($v)?>"><img border="0" src="<?=$img?>"></a>
	<? if(!(Project::getFundedValue($v)>=100) && Project::getPrivacityStatus($v['Project']['id']) ){?>
  <img src="/2012/images/privado_icon.png" style="position:absolute;right:10px;top:148px">
  
  <? } ?>
	
	<? if(Project::getFundedValue($v)>=100){?>
  <img src="/2012/images/bolsa_icon.png" style="position:absolute;left:-11px;top:8px;">
  
  <? } ?>
	<div style="height:200px;">
	<h5 class="titulo_categoria"><a href="<?=Category::getLink($v)?>"><?=Category::getName($v)?></a></h5>
<div class="misc_categoria"></div>
<h3 class=titulo_proyecto><a href="<?= Project::getLink($v)?>"><?=$v['Project']['title']?></a></h3>
<span class="autor"><?php echo __("by");?><a href="<?=User::getLink($v)?>"><?=$v['User']['display_name']?></a></span>


<p class="texto_proyecto"><?=$v['Project']['short_description']?></p>
<div style="color:#8a8a8a; background:url(/2012/images/dias_para_final.png) no-repeat; padding-left:20px; height:14px; line-height:14px; font-size:12px; margin-top:20px; margin-bottom:14px;"><?if($v['Project']['time_left']>0){echo $v['Project']['time_left']; ?> <?php echo __("DAYS_LEFT");?><?}else{?><?php echo __("PROJECT_FINISHED");?><?}?></div>
</div>
    <td width="121" align="center"><?= Project::getCollectedValue($v) ?></td>
    <td width="81" align="center"><?= $v['Project']['sponsorships_count']; ?></td>
  </tr>
 
</table>
<img src="/2012/images/<?=$imgficha?>.gif" width="286" height="19">
<div class="ext">
<div class="bar" style="left:<?php $p=Project::getFundedValue($v)>100?100:Project::getFundedValue($v); echo -280-((-282/100)*$p) ?>px"></div>
<div class="arr"></div>
</div>


</div>
</div>
<?php if($i==2){ ?>
<div class="clear"></div><div class="misc_divisor"></div>
<?php } ?>
<?php $i++;} ?>

  </div>
 <? } ?>
    <div><img  style="padding: 10px 0" src="/2012/images/paypal.jpg" width="956" height="132"></div>
<br><br>
<!------------------------------------------------>
<? if($this->data['PredefinedProjects']) { ?>
<div id="ofrecimientos">
<h2 class="green"><?php echo __("GROUPAL_GIFTS");?></h2>
<?php
$clases=array('proyecto_izq','proyecto_centro','proyecto_der');
$i=0;
foreach($this->data['PredefinedProjects'] as $v){ 
					$img=$v['predefinidos' ]['foto'];
					if (file_exists($img)){
						$img='/comodo_284_179.php?imagen='.$img;
						
					}else{
						$img='/comodo_284_179.php?imagen=img/assets/img_default_280x210px.png';	
					}
					
?>
  <div style="height:356px;"  class="<?php echo $clases[$i%3];?>">
 <div style="position:absolute; width:100%; left:0;">
	<a href="/predefined/<?=$v['predefinidos' ]['id']?>/<?=friendlyUrl($v['predefinidos' ]['title']);?>"><img border="0" src="<?=$img?>"></a>
	
	<div style="height:200px;">
	<h5 class="titulo_categoria"><a href="/discover/projects/in/<?=$keys_categories[$v['predefinidos' ]['category_id']]?>"><?=$base_categories[$v['predefinidos' ]['category_id']]?></a></h5>
<div class="misc_categoria"></div>
<h3 class=titulo_proyecto><a href="/predefined/<?=$v['predefinidos' ]['id']?>/<?=friendlyUrl($v['predefinidos' ]['title']);?>"><?=$v['predefinidos']['title']?></a></h3>
<span class="autor">por <a href="/como-funciona">Groofi</a></span>


<p class="texto_proyecto"><?=$v['predefinidos']['short_description']?></p>

</div>






</div>
</div>
<?php if($i==2){ ?>
<div class="clear"></div><div class="misc_divisor"></div>
<?php } ?>
<?php $i++;} ?>

  </div>
 

<div style="height:30px;clear:both;"></div>
<? } ?>
<!------------------------------------------------>

<div class="empresas_curadoras">
<h2><?php echo __("BUSISSNES");?></h2>
</div>
<div class="empresas_curadoras_1">
<h2><?php echo __("CURADORAS");?></h2>
</div>
<div class="curadoras">
<div class="empezar_proyecto_sponsor" onclick="location='/contacto';"><?php echo __("BE_GROOFI_SPONSOR");?></div>
<img  src="/2012/images/empresas_curadoras.png" width="958" height="189"></div>

