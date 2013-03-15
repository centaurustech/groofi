<?php /* @var $this ViewCC */ ?>

<?
    $this->set('titleClass', 'tabs');
    $this->set('pageTitle', __(up(sprintf('USER_EDIT_%s', $this->params['tab'])), true));
    $this->set('pageSubTitle', sprintf(__('OF %s', true), $this->Html->link(User::getName($this->data), User::getLink($this->data, null, false))));
?>
<?php
$checkeados=array();
$enbase=User::getUsersNotifications($this->data['User']['id']);
foreach($enbase as $k=>$v){
	$checkeados[]=$v['notificationtype_users']['notificationtype_id'];
}
//vd($checkeados);
?>
<?
//vd($validationErrorsArray);
?>
<form id="formchangesettings" enctype="multipart/form-data" method="post" action="/settings/profile" accept-charset="utf-8" style="overflow:visible">
<input type="hidden" name="data[User][id]" value="<?php echo $this->data['User']['id'];?>" id="UserId" />
<input type="hidden" name="tab2" value="tab2" />
<input type="hidden" name="que" id="que" value="1" />
<input value="<?=$this->data['User']['display_name']?>" type="hidden" name="data[User][display_name]" />
<h1 style="font-weight:normal; font-size:28px; line-height:32px; margin-top:30px"><?php echo __("USERS_EDIT");?></h1>
<span style=" font-style:italic"><?php echo __("CATEGORY_FROM %s");?><a onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'" style="color:#57a2be;" href="<?php echo User::getLink($this->data, null, false); ?>" class="cyan"><?php echo User::getName($this->data);?></a></span><br>
<div class="misc_separador" style="height:1px; width:100%"></div>

<div onclick="location='<?=Router::url (array ('controller' => 'users', 'action' => 'edit', 'tab' => 'profile'))?>';" class="tit_mi_perfil"></div>
<div onclick="location='<?=Router::url (array ('controller' => 'users', 'action' => 'edit', 'tab' => 'account'))?>';" class="tit_mi_cuenta selected"></div><br>
<div class="clear"></div><br><br>
<div style="width:100%; height:auto; ">
<?
if(isset($_SESSION['Message']['flash']['message']) && !empty($_SESSION['Message']['flash']['message'])){
echo '<div style="width:100%; line-height:20px; border:1px solid #eaeaea; background:#f4f4f4; padding:10px; margin-bottom:20px;font-size:12px; border-bottom:3px">'.$_SESSION['Message']['flash']['message'].'</div>';
unset($_SESSION['Message']['flash']['message']);
}
?>
<div onclick="location='<?=Router::url (array ('controller' => 'users', 'action' => 'edit', 'tab' => 'profile'))?>';" class="perfil_user"><?php echo __("USER_PROFILE");?></div>
<div onclick="location='<?=Router::url (array ('controller' => 'users', 'action' => 'edit', 'tab' => 'account'))?>';" class="cuenta_user"><?php echo __("account");?></div>
<h2 style="cyan"><?php echo __("account");?></h2>
<div class="perfil_izq">
<h3><?php echo __("NOTIFICATIONS_EDIT_PROFILE_TITLE");?></h3>
<?php echo __("NOTIFICATIONS_EDIT_PROFILE_SUBTITLE");?>
<div class="misc_separador"></div><br>
<div><?php echo __("NOTIFICATIONTYPE");?></div><br>
<? foreach($notifications as $k=>$v){
$ch='';
if(in_array($k,$checkeados)){
	$ch=' checked="checked" ';
}
?>
<div class="checkbox"><input type="checkbox" name="data[Notificationtype][Notificationtype][]" <?=$ch?> value="<?=$k?>" id="NotificationtypeNotificationtype<?=$k?>" /><label for="NotificationtypeNotificationtype<?=$k?>" class="selected"><?=__($v)?></label></div>
<? } ?>
<div onclick="$('que').disabled=1;$('formchangesettings').submit();" class="bot_guardar"><?php echo __("USER__PROFILE_SAVE");?></div><br><br>
</div>
<? if(empty($this->data['User']['facebook_id'])){?>
<div class="perfil_izq">

<h3>Facebook</h3>
<?php echo __("FACEBOOK_EDIT_PROFILE_SUBTITLE");?><br>
<div onclick="window.location='/fbConnect.php';" class="ingresar_con_facebook1"><?php echo __("FACEBOOK_LOGIN_TITLE");?></div>
<div class="misc_separador"></div><br>
	<div  onclick="window.location='/fbConnect.php';" class="boton_facebook"></div>
  <br><br>
<div class="texto_importante_facebook">
<div class="icono_importante_facebook"></div>
<p><strong><?php echo __("PRIVACY");?></strong><br>
<?php echo __("FACEBOOK_MESSAGE_MESSAGE");?></p>
</div>

</div>
<? } ?>
<div class="perfil_der" style="overflow:visible" >
<h3><?php echo __("UPDATE_PASSWORD_EDIT_PROFILE_TITLE");?></h3>
<?php echo __("UPDATE_PASSWORD_EDIT_PROFILE_SUBTITLE");?><br>
<div class="misc_separador"></div><br>
<p><?php echo __("USER__PASSWORD");?></p>
<div class="rounded_modificar">
<input type="password" name="data[User][password]" autocomplete="off"  style="width:200px"/>
</div>

<div style="color:red;font-size:9px;"><?php if (isset($validationErrorsArray['password']) && !empty($validationErrorsArray['password'])){echo $validationErrorsArray['password'];}?></div>
<br>
<p><?php echo __("USER__PASSWORD_CONFIRMATION");?></p>
<div class="rounded_modificar">
<input type="password" name="data[User][password_confirmation]" autocomplete="off"  style="width:200px" />
</div>
<div style="color:red;font-size:9px;"><?php if (isset($validationErrorsArray['password_confirmation']) && !empty($validationErrorsArray['password_confirmation'])){echo $validationErrorsArray['password_confirmation'];}?></div>
<br>
<!--<div class="eliminar">
<a onclick="return false;" href="#"><?php echo __("DELETE_GROFFI_ACCOUNT");?></a></div>-->
<div onclick="$('que').disabled=0;$('formchangesettings').submit();" class="bot_guardar"><?php echo __("USER__PROFILE_SAVE");?></div>
<!--<div style="position:relative;top:20px; left:0px; width:322px;height:289px;">
<form enctype="multipart/form-data" method="post" action="/settings/delete/" accept-charset="utf-8">
<img src="/2012/images/eliminar_cuenta.jpg" />
<input type="hidden" name="data[User][id]" autocomplete="off" value="<?php echo $this->data['User']['id'];?>">
<input type="password" name="data[deleteAccount][password]" autocomplete="off" id="deleteAccountPassword">
<a href="#" id="elimbt"></a>
</form>
</div>-->
</div>




<div class="clear"></div>
</div>
</form>