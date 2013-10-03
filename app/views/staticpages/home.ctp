<?php /* @var $this ViewCC */

?>
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
    jQuery(document).ready(function(){
        jQuery('#busqueda_filtro').submit(function(){

            var cat = jQuery('#categoria_proyecto1').val();
            var show = jQuery('#categoria_proyecto2').val();
            var pais= jQuery('#ProjectCountryId').val();
            if (cat == '' || show == '' || pais=='' ){
            alert('No se selecciono algun campo');

            }else{
                window.location= '/projects/index/'+pais+'/'+cat+'/'+show;




            }
            return false;
        });


    })
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
                                    $button=($v['Project']['leading']==1 && strlen($v['Project']['videoid'])>2 && strlen($v['Project']['videotype'])>2)?'<div onclick="verVideo(&quot;'.$v['Project']['videoid'].'&quot;,&quot;'.$v['Project']['videotype'].'&quot;,&quot;'.$modules->js_encode($v['Project']['title']).'&quot;,&quot;'.$modules->js_encode($v['User']['display_name']).'&quot;,&quot;'.Project::getLink($v).'&quot;,&quot;'.User::getLink($v).'&quot;)" class="boton_videocaso"><span class="texto_boton texto_boton_'.$_SESSION['idioma'].'">'.__("SHOW_VIDEO",$return=true).'<span></div>':'<div onclick="window.location=&quot;'.Project::getLink($v).'&quot;;" class="boton_explorar">'.__("PROJECT_EXPLORER",$return=true).'</div>';

                                    $informacion_proyecto ='<div class="tabla_proyectos"><div class="muestra2 texto_'.$_SESSION['idioma'].'">'.Project::getFundedValue($v).'%</div><div class="muestra2 texto1_'.$_SESSION['idioma'].'" >'.Project::getCollectedValue($v).'</div><div class="muestra2">'.$v["Project"]["sponsorships_count"].'</div></div>';
                                    ?>
                                    '<div id="foto" style="background:url( <?=$img ?>) center center no-repeat"></div><div id="descripcion"><h2 style="color:#FFF"><?=$descw?></h2><h5 class="titulo_categoria" style="color:#666;"><a href="/projects/search_category/<?=Category::slugCategory($v['Project']['category_id']);?>"><?=$modules->js_encode(Category::getName($v));?></a></h5><br><h3 class=titulo_proyecto><a href="<?=$modules->js_encode(Project::getLink($v));?>"><?=$modules->js_encode($v['Project']['title']);?></h3><span class="autor"><?php echo __("by");?><a href="<?=User::getLink($v)?>"><?=$modules->js_encode($v['User']['display_name']);?></a></span><br><p class="texto_destacado"><?=$modules->js_encode($v['Project']['short_description']);?></p><br>	<?= $informacion_proyecto?><!--img src="/2012/images/<!--?=$imgficha?--><!--.png"--><!-- width="288" height="16"--> <?=$button?></div>',
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
<style>




       /*padding:9px;
        margin: 0;
        border-radius:4px;
        -webkit-box-shadow:
            0 0px 0 #ccc,
            0 0px #fff inset;
        background: url('http://i45.tinypic.com/309nb74.png') no-repeat right, -moz-linear-gradient(top, #FBFBFB 0%, #E9E9E9 100%);
        background: url('http://i45.tinypic.com/309nb74.png') no-repeat right, -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FBFBFB), color-stop(100%,#E9E9E9));
        color:black;
        border:none;
        outline:none;
        display: inline-block;
        -webkit-appearance:none;
        cursor:pointer;
width: 200px;
        z-index: 99999;*/

    option{
        text-transform: uppercase;

    }
</style>
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
<div  class="homeslider">
    <div class="muestra3"><?php echo __("VIEW_FUNDED_ADMIN_INDEX1");?></div>
    <div class="muestra3"><?php echo __("|");?></div>
    <div class="muestra3"><?php echo __("RECAUDADOS");?></div>
    <div class="muestra3"><?php echo __("|");?></div>
    <div class="muestra3"><?php echo __("SPONSORSHIPS_INDEX");?></div>
</div>
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
<form action="" METHOD="GET" class="buscar_proyectos" id="busqueda_filtro">
<div id="filtro">
<div id="filtro_categorias">
<!--h4  style="cursor:pointer"  class="titulo_footer"><?php echo __("SEARCH_BY_CATEGORY");?></h4-->
<!--img  style="cursor:pointer"   class="misc_categorias02" src="/2012/images/misc_categorias02.png" width="19" height="16"-->
<div class="clear"></div>
<div style="width:956px" class="misc_separador"></div><br>
<div class="listado_categorias">

    <select  class="estilo_select" autocomplete="off" id="categoria_proyecto1" style="color: #597FA9;" name="data[Project][cat]">
        <option value="" style="text-decoration-color: #1e90ff"><?php echo __("SEARCH_BY_CATEGORY");?></option>
<?php
$categorias=Project::getCategories('categorias');

foreach($categorias as $k=>$v){

?>
<ul><option value="<?=$v['categories']['slug']?>"><?=$v['categories']['slug']?></option></ul>
<?php } ?>
    </select>
</div>
</div>
<div id="mostrar">
<!--h4  style="cursor:pointer"  class="titulo_footer"><?php echo __("FILTER_TITLE_LIMIT");?></h4-->
<!--img  style="cursor:pointer"  class="misc_categorias02" src="/2012/images/misc_categorias02.png" width="19" height="16"-->
<div class="clear"></div>
<div style="width:2px" class="misc_separador"></div><br>
<div class="listado_categorias listado_categorias1">
    <select class="estilo_select1" autocomplete="off" id="categoria_proyecto2" style="color: #597FA9;" name="data[Project][show]">
        <option value="" style="text-decoration-color: #1e90ff"><?php echo __("FILTER_TITLE_LIMIT");?></option>
<?php
$mostrar=Project::getCategories('mostrar');
foreach($mostrar as $k=>$v){

?>
<ul><option value="<?= $v; ?>"><?= $v; ?></option></ul>
<?php } ?>
        </select>
</div>

</div>



<div id="ubicacion">


    <!--h4  style="cursor:pointer"  class="titulo_footer"><?php echo __("LOCATION");?></h4-->
<!--img  style="cursor:pointer"  class="misc_categorias02" src="/2012/images/misc_categorias02.png" width="19" height="16"-->
<div class="clear"></div>
<div style="width:2px" class="misc_separador"></div><br>




    <div class="ubicacion_proyecto" id="categoria_proyecto3" >

        <select  class="estilo_select2" style="color: #597FA9;" autocomplete="off"  name="data[Project][paislugar]"  id="ProjectCountryId">
            <option value="" style="text-decoration-color: #1e90ff"><?php echo __("LOCATION");?></option>
            <? foreach($base_countries as $k=>$v){ ?>
            <option <?if(isset($_POST['data']['Project']['paislugar']) && $_POST['data']['Project']['paislugar']==$k['c']['PAI_ISO2']){echo ' selected="selected" ';}?> value="<?=$v['c']['PAI_ISO2']?>"><?=$v['c']['PAI_NOMBRE']?></option>

            <? } ?>

        </select>
        <ul style="margin-top: 30px;float: left;font-family: phoenica_std_demoregular;font-size: 14px;font-weight: 600;overflow: hidden;text-transform: uppercase;">
            <a style=" display: block;
    margin-left: 177px;
    position: relative;" href="/show_projects" ><?__("ADMIN_PROJECTS_MENU_ALL");?></a></ul>

    </div>
 <?php
    echo $this->Form->submit('Buscar',array('class' => 'buscar_proyectos submit_proyectos', 'title' => 'Custom Title'));

    ?>

</div>



<!---div class="listado_ubicaciones">
<ul><a href="/discover/projects"><?php echo __("ALL_COUNTRIES");?></a></ul>
<?php
$ubicacion=Project::getCategories('ubicacion');
$ciudades=array();
for($i=0;$i<count($ubicacion);$i++){
$ciudades['City']=$ubicacion[$i]['cities'];
?>
<ul><a href="<? echo City::getLink($ciudades,  array('extra' => 'projects'));?>"><? echo City::getName($ciudades);?></a></ul>
<?php } ?>

</div-->
    <!--input style=" background: #597FA9;border-radius: 2px 2px 2px 2px;bottom: 250px;color: #FFFFFF;cursor: pointer;float: left;position: relative;text-align: center;width: 150px;float: right" type="submit" name="Submit" value="Buscar Proyectos"-->

</div>
<div class="clear"></div>

</div>

</form>
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
	<div style="height:220px;">
	<h5 class="titulo_categoria"><a href="/projects/search_category/<?=Category::slugCategory($v['Project']['category_id']);?>"><?=Category::getName($v)?></a></h5>
<div class="misc_categoria"></div>
<h3 class=titulo_proyecto><a href="<?= Project::getLink($v)?>"><?=$v['Project']['title']?></a></h3>
<span class="autor"><?php echo __("by");?>&nbsp;<a href="<?=User::getLink($v)?>"><?=$v['User']['display_name']?></a></span>


<p class="texto_proyecto"><?=$v['Project']['short_description']?></p>
<div style="color:#8a8a8a; background:url(/2012/images/dias_para_final.png) no-repeat; padding-left:20px; height:14px; line-height:14px; font-size:12px; margin-top:20px; margin-bottom:14px;"><?if($v['Project']['time_left']>0){echo $v['Project']['time_left']; ?> <?php echo __("DAYS_LEFT");?><?}else{?><?php echo __("PROJECT_FINISHED");?><?}?></div>
</div>
     <table   class="texto_tabla" style="position:relative;display:inline-block"  width="300"  border="0" align="left">
         <tr style="font-weight: bold; font-family: helvetica">
             <td width="100" align="left"><?= Project::getFundedValue($v) ?>%</td>
             <td align="center"><?php echo __("");?></td>
             <td width="100" align="left"><?= Project::getCollectedValue($v) ?></td>
             <td align="center"><?php echo __("");?></td>
             <td width="100" align="left"><?= $v['Project']['sponsorships_count']; ?></td>
         </tr>


         <tr style="text-transform: uppercase; color: gray; font-size: 12px">
             <td width="100" align="left" class="text_proyectos_ <?echo 'text_proyectos_'.$_SESSION["idioma"];?>"><?php echo __("VIEW_FUNDED_ADMIN_INDEX1");?><!--?php echo ("    |");?--></td>
             <td align="left" class="text_proyectos_1 <?echo 'text_proyectos_1'.$_SESSION["idioma"];?>"><?php echo __("|");?></td>
             <td width="100" align="left" class="text_proyectos_ <?echo 'text_proyectos_'.$_SESSION["idioma"];?>"><?php echo __("RECAUDADOS");?><!--?php echo ("     |");?--></td>
             <td align="left" class="text_proyectos_1 <?echo 'text_proyectos_1'.$_SESSION["idioma"];?>"><?php echo __("|");?></td>
             <td width="100" align="left" style="padding-right: 20px"><?php echo __("SPONSORSHIPS_INDEX");?></td>
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

	<div style="height:250px;">
	<h5 class="titulo_categoria"><a href="/projects/search_category/<?=$keys_categories[$v['predefinidos' ]['category_id']]?>"><?=$base_categories[$v['predefinidos' ]['category_id']]?></a></h5>
<div class="misc_categoria"></div>
<h3 class=titulo_proyecto><a href="/predefined/<?=$v['predefinidos' ]['id']?>/<?=friendlyUrl($v['predefinidos' ]['title']);?>"><?=$v['predefinidos']['title']?></a></h3>
<span class="autor"><?php echo __("by");?><a href="/como-funciona">Groofi</a></span>


        <p class="texto_proyecto"><?php if ($_SESSION["idioma"]== "esp"){echo $v['predefinidos']['short_description'];}else{ echo $v['predefinidos']['short_description_'.$_SESSION["idioma"]];}?></p>

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

