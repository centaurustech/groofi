<?php
/* @var $this ViewCC */

$subtitleText = isset($status) ? sprintf(__('%s', true), $statusName) : __('DISCOVER_ALL_PROJECTS', true);
$subtitleText .= isset($category) ? ' ' . sprintf(__('CATEGORY_FROM %s', true), $categoryName) : '';
$subtitleText .= isset($country) ? ' ' . sprintf(__('CITY_IN %s', true), $cityName) : '';
$this->set('pageSubTitle', $subtitleText);
$this->Paginator->options(array('url' => $baseUrl));
//vd($baseUrl);
//vd($this->here.'--'.preg_replace("#(.*?)/[0-9]*?$#",'$1',$this->here));
?>

<div style="width:100%; height:auto; margin-top:20px">

<h1><?php echo __("PROJECTS_INDEX_TITLE");?></h1>
<?if(empty($baseUrl)){?>
<span style=" font-style:italic"><?php echo __("HOW_WORK");?></span><br><br>
<div id="banner_crea_proyecto">
<div onclick="location='/projects/add'" class="empezar_proyecto"><?php echo __("I_WANT_START_MY_PROJECT");?></div><img src="/2012/images/info_descubre_proyectos.png" width="958" height="298">
<div id="relleno_crea_proyecto"></div>


</div>
<div class="como_funciona1">
<h2><?php echo __("DISCOVER");?><br>
<?php echo __("DISCOVER1_1");?></h2><br>
<p><?php echo __("DISCOVER1_2");?><br>
<?php echo __("DISCOVER1_3");?><br>
<?php echo __("DISCOVER1_4");?></p>
</div>
<div class="como_funciona2">
<h2><?php echo __("DISCOVER2");?><br>
<?php echo __("DISCOVER2_1");?></h2><br>
<p><?php echo __("DISCOVER2_2");?><br>
<?php echo __("DISCOVER2_3");?><br>
<?php echo __("DISCOVER2_4");?><br>
<?php echo __("DISCOVER2_5");?><br></p>
</div>
<div class="como_funciona3">
<h2><?php echo __("DISCOVER3");?><br>
<?php echo __("DISCOVER3_1");?></h2><br>
<p><?php echo __("DISCOVER3_2");?><br>
<?php echo __("DISCOVER3_3");?><br>
<?php echo __("DISCOVER3_4");?><br></p>
</div>


<div><img src="/2012/images/sombra_header.png" width="957" height="20"></div>
<br>
<? }else{
$prep='';
if(isset($baseUrl['category'])){
	$prep='en';
}else if(isset($baseUrl['status'])){
	$prep='';
}else if(isset($baseUrl['city'])){
	$prep='en';
}
?>
<span style=" font-style:italic; color:#666"><?php echo __("DISCOVER_ALL_PROJECTS");?> <?=$prep?></span> <a href="<?=preg_replace("#(.*?)/[0-9]*?$#",'$1',$this->here)?>" style="font-weight:bold; color:#39a0c6; text-decoration:underline"><?=str_replace(array('Todos los proyectos de ','Todos los proyectos en '),array(' ',' '),$subtitleText)?></a><br><br>
<? } ?>
<div id="filtro">
<div id="filtro_categorias">
<h4 class="titulo_footer"><?php echo __("SEARCH_BY_CATEGORY");?></h4>
<img class="misc_categorias02" src="/2012/images/misc_categorias02.png" width="19" height="16">
<div class="clear"></div>
<div style="width:956px" class="misc_separador"></div><br>
<div class="listado_categorias">
<?php 
$categorias=Project::getCategories('categorias');
for($i=0;$i<count($categorias);$i++){
$destacado='';
if(isset($baseUrl['category']) && strpos(Category::getLink($categorias[$i]['categories']),$baseUrl['category'])!==false){

$destacado=' style="text-decoration:underline" ';
}

?>
<ul><a<?=$destacado?> href="<? echo Category::getLink($categorias[$i]['categories']);?>"><? echo Category::getName($categorias[$i]['categories']);?></a></ul>
<?php } ?>
</div>
</div>
<div id="mostrar">
<h4 class="titulo_footer"><?php echo __("FILTER_TITLE_LIMIT");?></h4>
<img class="misc_categorias02" src="/2012/images/misc_categorias02.png" width="19" height="16">
<div class="clear"></div>
<div style="width:2px" class="misc_separador"></div><br>
<div class="listado_categorias">
<?php 
$mostrar=Project::getCategories('mostrar');
foreach($mostrar as $k=>$v){

$destacado='';
if(isset($baseUrl['status']) && strpos($k,$baseUrl['status'])!==false){

$destacado=' style="text-decoration:underline" ';
}

?>
<ul><a<?=$destacado?> href="/discover/<?=$k?>/projects"><?= $v; ?></a></ul>
<?php } ?>
</div>

</div>

<div id="ubicacion">
<h4 class="titulo_footer"><?php echo __("USER_LOCATION_LABEL");?></h4>
<img class="misc_categorias02" src="/2012/images/misc_categorias02.png" width="19" height="16">
<div class="clear"></div>
<div style="width:2px" class="misc_separador"></div><br>
<div class="listado_ubicaciones">
<ul><a<?if(empty($baseUrl)){echo ' style="text-decoration:underline" ';}?> href="/discover/projects"><?php echo __("ALL_CATEGORIES");?></a></ul>
<?php 
$ubicacion=Project::getCategories('ubicacion');
$ciudades=array();
for($i=0;$i<count($ubicacion);$i++){
$ciudades['City']=$ubicacion[$i]['cities'];
$destacado='';
if(isset($baseUrl['city']) && strpos(City::getLink($ciudades,  array('extra' => 'projects')),$baseUrl['city'])!==false){

$destacado=' style="text-decoration:underline" ';
}
?>
<ul><a<?=$destacado?> href="<? echo City::getLink($ciudades,  array('extra' => 'projects'));?>"><? echo City::getName($ciudades);?></a></ul>
<?php } ?>
</div>

</div>
<div class="clear"></div>
</div>
<br>

<div id="proyectos_creados">
  
 <?php
$clases=array('proyecto_izq','proyecto_centro','proyecto_der');
$i=0;
//vd($this->data);
foreach($this->data as $k=>  $v){ 
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
	
	<div style="height:190px;">
	<h5 class="titulo_categoria"><a href="<?=Category::getLink($v)?>"><?=Category::getName($v)?></a></h5>
	<div class="misc_categoria"></div>
<h3 class=titulo_proyecto><a href="<?= Project::getLink($v)?>"><?=$v['Project']['title']?></a></h3>
<span class="autor">por <a href="<?=User::getLink($v)?>"><?=$v['User']['display_name']?></a></span>



<p class="texto_proyecto"><?=$v['Project']['short_description']?></p>
<div style="color:#8a8a8a; background:url(/2012/images/dias_para_final.png) no-repeat; padding-left:20px; height:14px; line-height:14px; font-size:12px; margin-top:20px; margin-bottom:14px;"><?if($v['Project']['time_left']>0){echo $v['Project']['time_left']; ?><?php echo __("DAYS_LEFT");?><?}else{?><?php echo __("PROJECT_FINISHED");?><?}?></div>
</div>
<div class="misc_separador"></div>
<table width="286" border="0" align="left" class="tabla_proyectos">
  <tr>
    <td width="71" align="center"><?= Project::getFundedValue($v) ?>%</td>
    <td width="121" align="center"><?= Project::getCollectedValue($v) ?></td>
    <td width="81" align="center"><?= $v['Project']['sponsorships_count']; ?></td>
  </tr>
 
</table>
<img src="/2012/images/<?=$imgficha?>.gif" width="286" height="19">
<div class="ext">
<div class="bar" style="left:<?php $p=Project::getFundedValue($v)>100?100:Project::getFundedValue($v);echo -280-((-282/100)*$p) ?>px"></div>
<div class="arr"></div>
</div>


</div>
</div>
<?php if($i==2){ ?>
<div class="clear"></div><div class="misc_divisor"></div>
<?php } ?>
<?php $i++;} ?>

    
</div>
    <div class="clear"></div>
<br><br>
<div class="misc_divisor"></div>
 <? if ($this->data) { ?> 
 <? if ( $this->Paginator->hasPrev() || $this->Paginator->hasNext()) { ?>
            <div class="paging">
                <div class="content">
                    <?
                    echo $this->Paginator->prev(__('PREV_PAGE', true), array('tag' => 'div'), __('PREV_PAGE', true), array('tag' => 'div'));

                    echo $this->Html->div('numbers', $this->Paginator->numbers(array(
                                'separator' => false,
                                'tag' => 'div',
                                'modulus' => 9
                            )));
                    echo $this->Paginator->next(__('NEXT_PAGE', true), array('tag' => 'div'), __('NEXT_PAGE', true), array('tag' => 'div'));
                    ?>
                </div>
            </div>
        <? } ?>
<?} else {
        echo 'No se encontraron resultados.';
    }
?> 
<br><br>
<div class="empresas_curadoras">
<h2><?php echo __("BUSISSNES");?></h2>
</div>
<div class="empresas_curadoras_1">
<h2><?php echo __("CURADORAS");?></h2>
</div>
<div class="curadoras">
<div class="empezar_proyecto_sponsor" onclick="location='/contacto';"><?php echo __("BE_GROOFI_SPONSOR");?></div>
<img src="/2012/images/empresas_curadoras.png" width="958" height="189"></div>

</div>