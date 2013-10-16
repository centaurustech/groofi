<?php /* @var $this ViewCC */ ?>
<?
$project=$this->data;
$this->set('title_for_layout', $project['title']);
$this->set('pageTitle', $project['title']);
//vd(FULL_BASE_URL.$this->here);
//vd($this->data['Prize']);
unset($_SESSION['VOLVER']);
//vd($this->data['Prize']);
//vd($this->data['LOSLINKS']);
$moneda=$project['moneda'];
//vd($moneda);
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

<div style="width:100%; height:auto; margin-top:20px; ">
<div id="project_content">


<h1 style="font-weight:normal; font-size:28px; line-height:32px;"><?=$project['title']?></h1>

<span style=" font-style:italic; color:#666; line-height:30px"><?__("CATEGORY_OF PROJECT %s");?></span> <a href="/discover/projects/in/<?=$keys_categories[$project['category_id']]?>" style="font-weight:bold; color:#39a0c6; text-decoration:underline"><?=$base_categories[$project['category_id']]?></a>

<br>

<ul class="pageElement tabs" style="margin-top:10px">

    <li class="tab-projects  active"><a style="display:block; position:relative; z-index:5000;cursor:pointer !important" href="#"><? __('THE_PROJECT') ?></a></li>
	
	
    

    </ul>
<br>	


<?php
        
		
		
        if (!empty($project['video'])) {
            echo getVideoFromURL($project['video']);
        } else {
            echo '<img style="max-width:560px" src="/'.$project['foto'].'">';
        }
        ?>

<br><br>
<h3 class="cyan"><?php echo __("ABOUT_THIS_PROJECT");?></h3>
<div class="misc_separador"></div><br>
<p class="texto_proyecto" style="margin-bottom:30px"><?php if($_SESSION["idioma"]== "esp"){echo nl2br($project['description']);} else{echo nl2br($project['description_'.$_SESSION["idioma"]]);}?></p>

<? if (!empty($project['reason'])) {?>
<h3 class="cyan"><?php echo __("PROJECT_REASON");?></h3>
<div class="misc_separador"></div>
<p class="texto_proyecto">
<?=nl2br($project['reason'])?>
</p><br><br>
<? } ?>
<div class="usuario" style="margin-top:20px;">
<?
$file = $this->Media->getImage('s50', $this->data['User']['avatar_file'], '/img/assets/img_default_50px.png');
?>
<h3 class="cyan" style="font-weight:normal"><a class="cyan" href="/como-funciona">Groofi</a></h3>

<div class="iconos_usuario"><img src="/2012/images/iconos_usuario.gif" width="20" height="41"></div>

<div class="info_usuario" style="overflow:hidden;">Buenos Aires, Argentina <br><strong class="cyan"><a class="cyan" href="/contacto"><?php echo __("SEND_MESSAGE");?></a></strong></div>
<div class="foto_usuario"><?=$file?></div>

</div>

</div>
<div  id="columna_der_project" style="background:url(/2012/images/columna_der_predefinidos.png) no-repeat">
<div class="financiado">
<h1 style="font-size:42px;"><span style=" font-size:21px; font-weight:400"><?=$moneda.'&nbsp;'?></span><?=$project['funding_goal']?></h1>
<p style="width:150px;position:relative;left:0px; text-align:center;"><?php echo __("FONDOS_SUGERIDOS");?></p>
</div>
<div class="finaliza2" >
<h1 style="font-size:42px;"><?=$q;?></h1>
<p style="width:150px;position:relative;left:0px; text-align:center;top:8px;"><?php echo __("PEOPLE_WHO_WANT");?></p>

</div>


<img style="position:absolute; left:-2px; top:170px;" src="/2012/images/proyecto_predefinido_separador.png">
<div class="clear" style=" height:275px"></div>


    <div class="difundir_idea"><?php echo __("DIFUNDIR_IDEA");?><br><p><?php echo __("SHARE_THIS_OFFER_TITLE");?></p></div>

    <div class="quiero_hacer"><?php echo __("QUIERO_HACER");?><br><p><?php echo __("THIS_OFFER");?></p></div>

    <div class="beneficios_sugeridos"><?php echo __("SUGGESTED BENEFITS");?></div>


<a href="#share"  rel="nofollow" class="addthis_button boton_difundir_predefinido">
    <!--p><strong><?php echo __("SHARE_THIS_PROJECT_SUBTITLE");?></strong><br>
        <span style=" font-size:12.5px; line-height:14px;"><?php echo __("SHARE_THIS_OFFER_TITLE");?></span></p-->



</a>

<a id="btseg"  style="" href="/createFromPredefined/<?=$project['id']?>" class="boton_seguir_predefinido">

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
 <div class="beneficios_proyecto" style="margin-top:92px">
  
  
  
  <? 
 
  $clases=array('fondo_beneficio_personas','fondo_beneficio_empresas');$i=-1;
  $htmll1='';
  $htmll2='';
  foreach($prizes as $k=>$v){$i++;
  if($v['ente']=='P'){
  $htmll1.='<div class="beneficio">
  <div   class="'.$clases[0].'">
  <div class="aportar">'.__("HELP_WITH", true).'</div>
  <div class="currency">'.$moneda.'</div>
  <div class="amount">'.$v['value'].'+</div>
  <p class="texto_beneficio">'.$v['description'].'</p>
  </div>
  </div>';
  }else{
  $htmll2.='<div class="beneficio">
  <div   class="'.$clases[1].'">
  <div class="aportar">'.__("HELP_WITH", true).'</div>
  <div class="currency">'.$moneda.'</div>
  <div class="amount">'.$v['value'].'+</div>
  <p class="texto_beneficio">'.$v['description'].'</p>
  </div>
  </div>';
  }
  } 
  
  if($htmll1!=''){
	echo '<div class="beneficios_personas"><h4 class="cyan">'.__("Personas_patro",true).'</h4>'.$htmll1.'</div>';
  }
  if($htmll2!='' ){
	echo '<div class="beneficios_personas"><h4 class="cyan">'.__("Personas_patro_gran", true).'</h4>'.$htmll2.'</div>';
  }
  ?>














  
  
  
  </div>


</div>

<script type="text/javascript">
        var addthis_config = {
            ui_click: true
            , ui_cobrand : 'Groofi'
            , ui_use_css : true
            ,ui_offset_top : -35
			,ui_offset_left : 15
            ,services_compact : 'facebook,twitter,myspace,live,orkut,sonico,tumblr,blogger,orkut,sonico'
            ,url : ''
            ,title : ''
            ,description : '<?= addslashes($project['description']); ?>'

        }
    </script>

    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=gmusante"></script>
<form id="ff11" method="post" target="ifr">
<input type="hidden" name="x">
</form>

