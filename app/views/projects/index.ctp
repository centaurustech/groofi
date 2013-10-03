<?php
/* @var $this ViewCC */


$subtitleText = isset($status) ? sprintf(__('%s', true), $statusName) : __('DISCOVER_ALL_PROJECTS', true);
$subtitleText .= isset($categoryName) ? ' ' . sprintf(__('CATEGORY_FROM %s', true), $categoryName) : '';
$subtitleText .= isset($country) ? ' ' . sprintf(__('CITY_IN %s', true), $cityName) : '';

$this->set('pageSubTitle', $subtitleText);
$this->Paginator->options(array('url' => $baseUrl));

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
    <form action="/projects/index" METHOD="GET" class="buscar_proyectos">
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
	
	<div style="height:210px;">
	<h5 class="titulo_categoria"><a href="<?=Category::getLink($v)?>"><?=Category::getName($v)?></a></h5>
	<div class="misc_categoria"></div>
<h3 class=titulo_proyecto><a href="<?= Project::getLink($v)?>"><?=$v['Project']['title']?></a></h3>
<span class="autor"><?php echo __("by");?><a href="<?=User::getLink($v)?>"><?=$v['User']['display_name']?></a></span>



<p class="texto_proyecto"><?=$v['Project']['short_description']?></p>
<div style="color:#8a8a8a; background:url(/2012/images/dias_para_final.png) no-repeat; padding-left:20px; height:14px; line-height:14px; font-size:12px; margin-top:20px; margin-bottom:14px;"><?if($v['Project']['time_left']>0){echo $v['Project']['time_left']; ?><?php echo __("DAYS_LEFT");?><?}else{?><?php echo __("PROJECT_FINISHED");?><?}?></div>
</div>
<div class="misc_separador"></div>
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
        echo __("NO_FOUND_PROJECT", true);
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