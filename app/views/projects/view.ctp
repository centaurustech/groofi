<?php /* @var $this ViewCC */

?>
<?
echo $this->Html->script('bjqs-1.3');
echo $this->Html->script('slider');
$project=$this->data;
$this->set('title_for_layout', Project::getName($project));
$this->set('pageTitle', Project::getName($project));
//vd(FULL_BASE_URL.$this->here);
//vd($this->data['Prize']);
unset($_SESSION['VOLVER']);
//vd($this->data['Prize']);
//vd($this->data['LOSLINKS']);
$moneda=Project::getMoneda($project);
//vd($moneda);
?>

<div style="width:100%; height:auto; margin-top:20px; ">
<div id="project_content">
<? if (Project::isOwnProject($project)) { ?>
	<? if(!Project::isEnabled($project)){?>
		
	    <? if(!Project::isPublic($project)){?>
			
			<a style="left:-20px" class="delproy" href="/projects/delete/<?=$project['Project']['id']?>"><span class="delp"></span>Borrar</a>
			<div class="misc_divisor" style="width:551px;clear:both;"></div>
		<?}?>
			
	<?}else{?>
		
			<? if(!Project::isPublic($project)){?>
			
			
				<a  class="lanzarproy" href="/project/<?=$project['Project']['id']?>/publish"><span class="lanzp"></span>Lanzar Proyecto</a>
				<a  class="editproy" href="/projects/edit/<?=$project['Project']['id']?>"><span class="editp"></span>Editar</a>
				<a  class="delproy" href="/projects/delete/<?=$project['Project']['id']?>"><span class="delp"></span>Borrar</a>
				<div class="misc_divisor" style="width:551px;clear:both;"></div>
			<?}else{?>
			<!--a  class="lanzaract" href="/project/<?=$project['Project']['id']?>/create-update"><span class="lanzact"></span><?//php echo __("CREATE_UPDATE");?></a-->
			<div class="misc_divisor" style="width:551px;clear:both;"></div>
			<? } ?>
	<? } ?>




<? }?>

<h1 style="font-weight:600; font-size:28px; line-height:24px;"><?=Project::getName($project)?></h1>

<span style=" font-style:italic; font-size:13px; color:#666; line-height:30px"><?php echo __("CATEGORY_OF PROJECT %s");?></span> <a href="<?=Category::getLink($project, 'projects')?>" style="font-weight:normal; color:#39a0c6; font-size:13px; font-style:italic; text-decoration:underline"><?=Category::getName($project);?></a>

<br>

<ul class="pageElement tabs" style="margin-top:10px">

    <li class="tab-projects  active"><a href="<?= Project::getLink($project); ?>"><? __('THE_PROJECT') ?></a></li>
<? if (Project::isOwnProject($project)) { ?>
    <li><a  class="lanzaract lanzaract1" href="/project/<?=$project['Project']['id']?>/create-update"><span class="lanzact" style="margin-left: -15px;text-align: center;"></span><?php echo __("CREATE_UPDATE");?></a></li>
        <?}?>
	 <? if (Project::isPublic($project)) { ?>
	    <li class="tab-sponsorships"><a href="<?= Project::getLink($project, 'sponsorships'); ?>"><? __('PROJECT_SPONSORS') ?> <span style="color:#1e455b; font-weight:600">(<?= $this->data['Project']['sponsorships_count']; ?>)</span></a></li>

    <li class="tab-comments"><a href="<?= Project::getLink($project, 'comments'); ?>"><? __('COMMENTS') ?>  <span style="color:#1e455b; font-weight:600">(<?= $this->data['Project']['comment_count']; ?>)</span></a></li>
        <? if ($project['Project']['post_count'] > 0 ) {?>
            <li class="tab-posts"><a href="<?= Project::getLink($project, 'updates'); ?>"><? __('UPDATES') ?> <span style="color:#1e455b; font-weight:600">(<?= $this->data['Project']['post_count']; ?>)</span></a></li>
        <? } ?>
	 <? } ?>
	
    

    </ul>
<br>	


<?php
        $video = getVideoEmbed($this->data['Project']['video_url']);
        if ($video) {
            echo $this->Html->div('project-video', $video);
        } else {
            $file = $this->Media->file('l560/' . $this->data['Project']['image_file']);
            $image = $this->Media->embed($file);
            echo ($image ? $this->Html->div('project-image', $image ): ''  );
        }
        ?>

<br><br>
<h3 class="cyan"><?php echo __("ABOUT_THIS_PROJECT");?></h3>
<div class="misc_separador"></div><br>
<p class="texto_proyecto"><?=nl2br($this->data['Project']['description'])?></p>
<? if (!empty($this->data['Project']['reason'])) {?>
<h3 class="cyan"><?php echo __("PROJECT_REASON");?></h3>
<div class="misc_separador"></div>
<p class="texto_proyecto">
<?=nl2br($this->data['Project']['reason'])?>
</p><br><br>
<? } ?>
<div class="usuario" style="margin-top:20px;">
<?
$file = $this->Media->getImage('s50', $this->data['User']['avatar_file'], '/img/assets/img_default_50px.png');
?>
<h3 class="cyan" style="font-weight:normal"><a class="cyan" href="<?=User::getLink($this->data)?>"><?=User::getName($this->data)?></a></h3>
<? foreach ($this->data['LOSLINKS'] as $k=>$v){?>
<a target="_blank" href="<?=$v['links']['link']?>" style="font-size:12px;line-height:21px;display:block; text:decoration:none; width:500px; height:21px; color:#4f444f"><img style="margin:0 3px 0 2px;" src="/2012/images/links.png"><?=$v['links']['link']?></a>
<?}?>
<div class="iconos_usuario"><img src="/2012/images/iconos_usuario.gif" width="20" height="41"></div>

<div class="info_usuario" style="overflow:hidden;"><?=$this->data['User']['city']?> <br><strong class="cyan"><a onclick="<?if (!$this->Session->read ('Auth.User.id')){$_SESSION['VOLVER']=$this->here;?>alerta('<?echo __("SEND_MESSAGE1");?> <?=User::getName($this->data)?>');<?}else{?>if($('fromoculto').style.display!='block')$('fromoculto').style.display='block';else $('fromoculto').style.display='none';<?}?>return false;" class="cyan" href="#"><?php echo __("SEND_MESSAGE");?></a></strong></div>
<div class="foto_usuario"><?=$file?></div>

</div>
<div id="fromoculto" style="height:auto;overflow:hidden;display:none; width:100%;">
<form id="messageForm"  method="post" target="ifr" action="/messages/add2" accept-charset="utf-8">


<input type="hidden" name="data[Message][user_id]" autocomplete="off" value="<?=$this->data['User']['id']?>" id="MessageUserId" />

<textarea style="position:relative; left:0px;" name="data[Message][message]" autocomplete="off" cols="30" rows="6" id="MessageMessage" ></textarea>

<div style="position:relative; left:12px;" onclick="$('messageForm').submit();"  class="bot_guardar"><?php echo __("SEND_MAYUSCULA");?></div>

</form> 
</div>
</div>

<div id="columna_der_project">
<?if (!empty($sponsors)) {?>
    <script type="text/javascript">
        $proyectosem='<?php echo __("Subtitle");?>';/*VARIABLE CAMBIO DE IDIOMA SLIDER*/

        DR(
                function(){
                    if($('corjurto1'))
                        createSlideHome(
                                [
                                <?
                                foreach ($sponsors as $k => $v){
                                    $img=explode('.jpg',$v["Sponsor"]["basename"]);

                                    ?>
                                        '<img src="/upload_sponsors/<?echo $img[0];?>"/>',
                                    <? } ?>

                                ],$('corjurto1'),$('thumbs_destacados1')
                        );

                });

    </script>


<div class="slider_sponsor">
<div id="corjurto1">

</div>
<div id="thumbs_destacados1" class="thumbs_destacados1" style="display: none">
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
    <? }else{ ?>
    <div class="slider_sponsor">
    <?echo '<img src="/2012/images/sponsor_groofi.jpg"/>' ;?>
    </div>
    <?}?>


<?php //Chanchada de Alvaro S. Zweig, para harcodear un sponsor ?>
<?php
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}


//if(curPageURL()=='http://www.groofi.com/profile/557/projects/expedicion-al-llullaillaco'){
//<!--?-->
//	<div class="espacio2_sponsor2"></div>
//<?php }else{
//<!--?-->
//	<div class="espacio_sponsor">

//	<div class="sponsor1">
  //  	<?php echo __("FINANCE_YOUR_THOUGHTS");?>
    	<!--/div-->
    <!--div class="sponsor2">
       	<?php echo __("SPACE_FOR");?>
       	</div>
    <div class="sponsor3">
           	<?php echo __("SPONSOR");?>
           	</div>
	</div>
<!--?php }?-->
<div class="financiado">
<h1 style="font-size:34px"><?= Project::getFundedValue($project) ?><span style=" font-size:21px; font-weight:400">%</span></h1>
<p style="font-size:13px; margin-top:-5px; margin-left:-8px"><?php echo __("FUNDED");?></p>
</div>
<div class="finaliza">
<? if($this->data['Project']['time_left']>0){?>
<h1 style="font-size:34px"><?= $this->data['Project']['time_left']; ?></h1>
<p style="font-size:13px; margin-top:-5px;"><?php echo __("DAYS_LEFT");?></p>
<? }elseif(!Project::isPublic($project)){?>
<p style="font-size:13px; margin-top:10px">No publicado</p>
<?}else{ ?>
<p style="font-size:13px; margin-top:10px"><?php echo __("PROJECT_FUNDED_STATUS");?></p>
<? } ?>
</div>
<div class="patrocinadores">
<h1 style="font-size:34px"><?= $this->data['Project']['sponsorships_count']; ?></h1>
<p style="font-size:13px; margin-top:-5px;"><?php echo __("%s SPONSORSHIPS");?></p>
</div>
<div class="recaudados">
<h1 style="font-size:34px"><span style=" font-size:18px; vertical-align:middle; font-weight:400"><?=$moneda?></span><?= Project::getCollectedValue($project) ?></h1>
<p style="font-size:13px; margin-top:-5px;"><?php echo __("AVAILABLE_FOUNDS_FROM %s");?><?=$this->data['Project']['funding_goal']?></p>
</div>


<div class="clear"></div>
<div class="texto_importante">
<div class="icono_importante"></div>
<p style="font-size:12px; font-family:arial"><strong>Importante</strong><br>
 <? echo sprintf(__('PROJECT_IMPORTANT_ADVICE %s %s %s', true), $this->Time->i18nFormat($this->data['Project']['end_date'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y'), $moneda,$this->data['Project']['funding_goal']); ?> </p>
</div>





<a href="#share"  rel="nofollow" class="addthis_button boton_difundir">

<p><strong><?php echo __("SHARE_THIS_PROJECT_SUBTITLE");?></strong><img src="/2012/images/compartir_fbtw.png" style="margin-left:4px; margin-top:-4px"><br>
<span style="font-size:12.5px; line-height:-8px; margin-top:-30px;"><?php echo __("SHARE_THIS_OFFER_TITLE");?></span></p>

</a>

<a id="btseg" onclick="<?php if ($this->Session->read ('Auth.User.id')){?>$('ff11').action='<?= Project::getLink($project, 'follow'); ?>';$('ff11').submit();return false;<?}else{?>alerta('Debe estar registrado para realizar esta acci&oacute;n');return false;<?}?>" style="<?= (Follow::isFollowing($project) ? 'display:none' : '') ?>" href="#" class="boton_seguir">
<p><strong><?php echo __("FOLLOW_THIS_PROJECT");?></strong><br>
<span style=" font-size:12.5px; line-height:8x;"><?php echo __("IF_YOU_STAY_UP_TO DATE");?></span></p>
</a>

<a id="btdej" onclick="<?php if ($this->Session->read ('Auth.User.id')){?>$('ff11').action='<?= Project::getLink($project, 'unfollow'); ?>';$('ff11').submit();return false;<?}else{?>alerta('Debe estar registrado para realizar esta acci&oacute;n');return false;<?}?>" style="<?= (!Follow::isFollowing($project) ? 'display:none' : '') ?>" href="#" class="boton_seguir">
<p><strong>ESTAS SIGUIENDO ESTE PROYECTO</strong><br>
<span style=" font-size:12.5px; line-height:8px;">Haz click en este bot&oacute;n para dejar de seguirlo</span></p>
</a>


<div class="redes_sociales">
<div style="position:absolute;top:0; left:0; width:360px; height:30px;">
 <div style="width:100px; height:30px; position:relative; float:left; left:0px;top:7px;"><a href="https://twitter.com/share" class="twitter-share-button">Tweet</a></div>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<div style="width:120px; height:30px;position:relative; float:left; left:0px;top:7px;" class="fb-like" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
<div style="width:120px; height:30px; position:relative; float:left; left:0px;top:7px;">
<g:plusone size="medium" annotation="inline" width="120"></g:plusone>
</div>
<script type="text/javascript">
  window.___gcfg = {lang: 'es'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
</div>
</div>
 <div class="beneficios_proyecto">
  
  
  
  <?

  $prizes=$this->data['Prize'];
  $clases=array('fondo_beneficio_personas','fondo_beneficio_empresas');$i=-1;
  $htmll1='';
  $htmll2='';
  foreach($prizes as $k=>$v){$i++;
  if($v['ente']=='P'){
  $htmll1.='<div class="beneficio">
  <div  onclick="location=\''.Project::getLink(array('Project' => $this->data['Project']), array('extra' => 'Back', 'prize' => $v['id'])).'\';" style="cursor:pointer;" class="'.$clases[0].'">
  <div class="aportar">'.__("HELP_WITH", true).'</div>
  <div class="currency">'.$moneda.'</div>
  <div class="amount">'.$v['value'].'+</div>
  <p class="texto_beneficio">'.$v['description'].'</p>
  </div>
  </div>';
  }else{
  $htmll2.='<div class="beneficio">
  <div  onclick="location=\''.Project::getLink(array('Project' => $this->data['Project']), array('extra' => 'Back', 'prize' => $v['id'])).'\';" style="cursor:pointer;" class="'.$clases[1].'">
  <div class="aportar">'.__("HELP_WITH", true).'</div>
  <div class="currency">'.$moneda.'</div>
  <div class="amount">'.$v['value'].'+</div>
  <p class="texto_beneficio">'.$v['description'].'</p>
  </div>
  </div>';
  }
  } 
  
  if($htmll1!='' && $this->data['Project']['time_left']>0){
	echo '<div class="beneficios_personas"><h4 class="cyan">'.__("Personas_patro", true).'</h4>'.$htmll1.'</div>';
  }
  if($htmll2!='' && $this->data['Project']['time_left']>0){
	echo '<div class="beneficios_personas"><h4 class="green">'.__("Personas_patro_gran", true).'</h4>'.$htmll2.'</div>';
  }
  ?>
  

  
  
  
  
  







  <div class="paypal_beneficio"></div>
  
  
  </div>


</div>

<script type="text/javascript">
        var addthis_config = {
            ui_click: true
            , ui_cobrand : 'Groofi'
            , ui_use_css : true
            ,ui_offset_top : 25
			,ui_offset_left : 15
            ,services_compact : 'facebook,twitter,myspace,live,orkut,sonico,tumblr,blogger,orkut,sonico'
            ,url : '<?= Project::getLink($data, array(), true); ?>'
            ,title : '<?= Project::getName($data); ?>'
            ,description : '<?= addslashes($data['Project']['short_description']); ?>'

        }
    </script>

    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=gmusante"></script>
<form id="ff11" method="post" target="ifr">
<input type="hidden" name="x">
</form>

<?if($this->Session->check('deletedok')){?>
<script>DR(function(){alerta("El proyecto ha sido eliminado");});</script>



<?
$this->Session->delete('deletedok');
}?>

<?if($this->Session->check('sipublicado')){?>
<script>DR(function(){alerta("El proyecto ha sido publicado.");});</script>
<?
$this->Session->delete('sipublicado');
}?>
