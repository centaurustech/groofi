<?php /* @var $this ViewCC */?>
<?php

if (!isset ($short_description_for_layout)) {
    $short_description_for_layout = __ ('DEFAULT_SITE_SHORT_DESCRIPTION', true);
}
if (!isset ($description_for_layout)) {
    $description_for_layout = __ ('DEFAULT_SITE_DESCRIPTION', true);
}
if (!isset ($author_for_layout)) {
    $author_for_layout = __ ('DEFAULT_SITE_AUTHOR', true);
}
$page = ( isset ($this->params['prefix']) ? $this->params['prefix'] . '_' : '' ) . $this->params['controller'] . '_' . $this->params['action'];

?>
<!DOCTYPE html>
<html>
<head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="image_src" href="<?=Router::url('/', true)?>img/assets/logo_groofi_header.png" />
<meta property="og:image" content="<?=Router::url('/', true)?>img/assets/logo_groofi_header.png"/>

<?php
if (low ($title_for_layout) == low ($this->params['controller'])) {
            $title_for_layout = up ($this->params['controller']) . '_' . up ($this->params['action']);
        }

?><title><?= __ ($title_for_layout, true) . ' | ' . SITE_NAME;?></title>
<?php
 echo $this->Html->meta ('icon', ASSETS_SERVER . '/favicon.ico', array ('type' => 'icon')) . "\r\n";
 $siteMeta = array (
            'title' => __ ($title_for_layout, true),
            'subject' => __ ($title_for_layout, true),
            'classification' => __ ($short_description_for_layout, true),
            'author' => __ ($author_for_layout, true),
            'keywords' => generateKeywords (__ ($description_for_layout . ' ' . $author_for_layout . ' ' . $title_for_layout, true)),
            'description' => __ ($description_for_layout, true),
            'revisit-after' => '1',
            'distribution' => 'Global',
            'Robots' => 'INDEX,FOLLOW',
        );
echo $this->Html->meta (array ('HTTP-EQUIV' => 'Expires', 'content' => date ('D, j M G:i:s ', strtotime ('+1 day')))) . "\r\n";
?>
<LINK REL='StyleSheet' HREF="/2012/style.css" TYPE="text/css" MEDIA='screen'>
<link href='http://fonts.googleapis.com/css?family=Asap:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="/js/panino/panino.js"></script>
<script type="text/javascript" src="/js/panino/comunes.js"></script>
<script type="text/javascript" src="/js/panino/transicion.js"></script>
<script type="text/javascript" src="/js/panino/transicionSimple.js"></script>
<script type="text/javascript" src="/js/panino/slide1.js"></script>
<script src="/js/panino/utils.js" type="text/javascript"></script>
<script type="text/javascript">
var ingresar='<?php echo __("LOGIN");?>';
var registrar='<?php echo __("REGISTER_ME");?>';
var perfi='<?php echo __("USER_PROFILE");?>';
var out='<?php echo __("USER_LOGOUT");?>';
var recupera='<?php echo __("RECOVER_PASSWORD_1");?>';
var conface='<?php echo __("FACEBOOK_LOGIN_TITLE_1");?>';
var newuser='<?php echo __("REGISTER_ME");?>';
var config='<?php echo __("USERS_EDIT");?>';

<?php
if ($this->Session->read ('Auth.User.id')) {
    $user = $this->Session->read ('Auth');
	$file = $this->Media->file ('s64/' . $user['User']['avatar_file']);
    $file = $this->Media->embed ($file, array ('width' => '64px', 'height' => '64px'));
    $file = ( empty ($file) ? $this->Html->image ('/img/assets/img_default_64px.png', array ('width' => '64px', 'height' => '64px')) : $file );
	$alias=explode(' ',$user['User']['display_name']);
	$alias=empty($user['User']['slug'])?$alias[0]:ucfirst($user['User']['slug']);
?>
ns.logueado=1;
DR(function(){
<? if($user['User']['message_count'] > 0){?>
var nummens='<div onclick="location=&quot;/messages&quot;;" title="mensajes no leídos" style="width:28px; height:28px; position:absolute; background:url(/2012/images/bolita.png) 0px 1px no-repeat; top:67px; left:145px; z-index:8000;color:#FFF;font-size:10px;text-align:center; line-height:31px; font-weight:bold;cursor:pointer;font-family: Asap, sans-serif;"><?=($user['User']['message_count']<1000)?$user['User']['message_count']:999;?></div>';
<? }else{?>
var nummens='';
<? } ?>
$('login_text').innerHTML='<a onclick="location=&quot;<?= User::getLink ($user)?>&quot;" id="gear3" href="<?= User::getLink ($user)?>">'+perfi+'</a> / <a href="<?=Router::url (array ('controller' => 'users', 'action' => 'logout'))?>">'+out+'</a>';
$('boxUser').innerHTML='<div id="picuserbox"><?=$file?></div><div id="nombreabreviado"><?php echo $alias ;?></div><div id="nombrecompleto"><?=$user['User']['display_name'];?></div><a onclick="window.location=&quot;<? echo User::getLink ($user);?>&quot;;return false;" id="miperfilboxexpand" href="<? echo User::getLink ($user);?>">'+perfi+'</a><a onclick="window.location=&quot;<? echo User::getLink ($user, 'settings');?>&quot;;return false;" id="settingsboxexpand" href="<? echo User::getLink ($user, 'settings');?>">'+config+'</a><img id="ikomse" onclick="location=&quot;/messages&quot;;return false;" style="position:absolute;top:67px;left:77px;cursor:pointer;" src="/2012/images/mensajes.png">'+nummens;


});

<?php }else{ ?>
ns.logueado=0;
<?php } ?>
</script>
</head>
<body>
<span id="tip"></span>
<div id="bglightbox2"></div>
<div id="bglightbox_private"></div>
<div id="videodelcasolb"></div>
<div id="sincro" >
<a onclick="$('bglightbox2').style.display='none';$('bglightbox2').alfa(0);  $('sincro').style.display='none'" id="closesincro" href="#"></a>
<form id="formulariosincronizacion" action="/sincro" method="post">
<input id="sincro_email" value="" autocomplete="off" type="text" name="data[User][email]" />
<div id="err_sincro_email"></div>
<input id="sincro_pass" value="" autocomplete="off" type="password" name="data[User][password]" />
<div id="err_sincro_pass"></div>
<input id="sincro_repitepass" value="" autocomplete="off" type="password" name="data[User][password_confirmation]" />
<div id="err_sincro_repitepass"></div>
<label id="checkrecordarloginsincro"><input type="checkbox" name="data[User][remember_me]" id="recordarloginsincro" /></label>
<input type="hidden" name="data[User][sincronice]" value="1" />
<a onclick="$('formulariosincronizacion').submit();return false;" href="#" id="submitsincro"></a>
</form>
</div>

<div id="fb-root"></div>
<div id="precarga"><img src="/2012/images/descubrirmenu.png" width="186" height="134"><img src="/2012/images/crearmenu.png" width="186" height="134"><img src="/2012/images/gear_over.gif" width="28" height="39"><img src="/2012/images/bgLogOff.png" width="180" height="193"><img src="/2012/images/BTFB.jpg" width="51" height="19"><img src="/2012/images/bgLogOn.png" width="210" height="140"></div>
<div id="boxUser"></div>
<div id="topgris"></div>
<div id="contenedor">

<div id="header">
  <a title="Groofi" href="/" id="logo"></a>
  <div id="buscador">
<div onclick="$('searchform').action='/search/projects/'+$('keybus').value;$('searchform').submit();" class="bot_search"></div>
<form onsubmit="this.action='/search/projects/'+$('keybus').value" id="searchform" method="post" action="/search/projects" accept-charset="utf-8"><input id="keybus" autocomplete="off" class="input_buscador"  name="data[Search][q]" type="text"></form></div>
  <div id="menu">
    <div class="grof">
    <a href="/discover/projects" class="header_letras1" id="descubri">
    <span class="descubri"></span>
    <?php echo __("DISCOVER_PRINCIPAL");?>
    </a></div>
    <div class="grof">
        <a href="<?= Router::url (array ('controller' => 'projects', 'action' => 'add'))?>" class="header_letras2" id="crea">
        <span class="crea"></span>
        <?php echo __("CREATE");?>
        </a></div>
    <div class="grof">
        <a href="http://blog.groofi.com/" class="header_letras3" id="blog">
        <span class="blog"></span>
        <?php echo __("BLOG");?>
        </a></div>
    <div class="clear"></div>
  </div>
</div>
<div id="sub_header"> 
<div<? if(ns.logueado && $user['User']['message_count'] > 0){?> style="visibility:visible;"<? } ?> onclick="location='/messages';" id="globomens1" title="mensajes no leídos"><?=($user['User']['message_count']<1000)?$user['User']['message_count']:999;?></div>
  <div id="sponsors"></div>
  <div id="tools">
    <div id="gear" class="gear"></div>

    <div id="login_text"><a id="gear2" href="#"><?php echo __("LOGIN");?></a><a href="/signup"><?php echo __("REGISTER_ME");?></a></div>
    <div class="line_separador"></div>
    <a href="http://www.facebook.com/pages/Groofi/214971778526056" rel="no-follow" target="_blank" class="facebook"></a>
    <a href="http://twitter.com/grooficom" rel="no-follow" target="_blank" class="twitter"></a>
    <a href="/contacto" class="mail"></a>
    <div class="line_separador"></div>
    <div onclick="window.location='<?= Router::url (array ('controller' => 'staticpages', 'action' => 'translate','?' => array('idioma' => 'es')))?>';" class="esp"></div>
    <div onclick="window.location='<?= Router::url (array ('controller' => 'staticpages', 'action' => 'translate','?' => array('idioma' => 'en')))?>';" class="ing"></div>
    <div onclick="window.location='<?= Router::url (array ('controller' => 'staticpages', 'action' => 'translate','?' => array('idioma' => 'it')))?>';" class="ita"></div>
    <div class="clear"></div>
    </div>
  <div id="logos"></div>
</div>
<div>
<div class="header_groofi">
<?php echo __("FINANCE_YOUR_THOUGHTS");?><br>
</div>



<?php echo $content_for_layout; ?>

<div class="clear"></div>
</div>
<div id="footer_contenedor">
  <div id="footer_categorias">
<h4 class="titulo_footer" style="text-transform:uppercase"><? __ ('SEARCH_BY_CATEGORY')?></h4>
<img class="misc_categorias" src="/2012/images/misc_categorias.png" width="8" height="7">
<div class="clear"></div>
<div style="width:225px" class="misc_separador_footer"></div><br>
<div class="listado_categorias">
<? foreach ($site_categories as $key => $category) {?>
<ul><?= $this->Html->link (Category::getName ($category), Category::getLink ($category))?></ul>
<? }?>


<a href="/discover/projects" class="ver_todas">Ver todas</a>
</div>


</div>
<div id="footer_facebook">
<h4 class="titulo_footer"><?php echo __("GROOFI_FOOTER");?></h4>
<img class="misc_categorias" src="/2012/images/misc_categorias.png" width="8" height="7">
<div class="clear"></div>
<div class="misc_separador_footer"></div><br>
<div class="fb-like" data-href="https://www.facebook.com/Groofi" data-send="false" data-width="340" data-show-faces="false"></div>
</div>

<div id="footer_contacto">
<h4 class="titulo_footer"><?php echo __("GROOFI_FOOTER_CONTACTATE");?></h4>
<img class="misc_categorias" src="/2012/images/misc_categorias.png" width="8" height="7">
<div class="clear"></div>
<div style="width:245px" class="misc_separador_footer"></div><br>
<div class="listado_contacto"> 
<a href="/guidelines"><?php echo __("GROOFI_SCHOOL");?></a>
<a style="background-position:6px -15px" href="/faq" >FAQ</a>
<a style="background-position:6px -35px" href="/como-funciona"><?php echo __("ABOUT_US_LINK");?></a>
<a style="background-position:6px -57px" href="/contacto"><?php echo __("CONTACT_US_LINK");?></a>
<a style="background-position:6px -75px" href="http://www.facebook.com/pages/Groofi/214971778526056" rel="no-follow" target="_blank">Facebook</a>
<a style="background-position:6px -95px" href="http://twitter.com/grooficom" rel="no-follow" target="_blank">Twitter</a>
</div>


</div>
<div id="footer_expand"></div>
<div id="footer" class="block">
<div class="bottom">
        <div class="content">
 <div class="left">
 <ul>
 <li><a href="/staticpages/terminos"   ><?php echo __("TERMS_CONDITIONS");?></a></li>
 <li><a href="/staticpages/politicasdeprivacidad" ><?php echo __("PRIVACY");?></a></li>
 <li><a href="/contacto" ><?php echo __("CONTACT");?></a></li>
  </ul>
 </div>
 <div class="right">
  <span><? __ ('SITE_COPYRIGHT')?></span>
                                <a href="/">
                                    <img src="/2012/images/logo_groofi_footer.png" alt="logo" />
                                </a>
          </div>
        </div>
      </div>
</div>

</div>


</div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=161780013885544";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-27693751-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

</script>
<?if($this->Session->check('promptPrivate')){?>
<script>
promptPrivate('<?=$this->Session->read('privateTitle')?>','<?=$this->Session->read('privateAutor')?>');
</script>
<form target="ifr" id="formprivate" action="/verifyPrivate" method="post"><input type="hidden" name="keyPrivate" id="keyPrivate"></form>
<? $this->Session->delete('promptPrivate');} ?>
<iframe name="ifr" style="width:0; height:o; position:absolute; top:-15000px;"></iframe>

</body>
</html>
