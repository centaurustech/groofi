<?php /* @var $this ViewCC */
?>
<? $this->set('pageTitle', false); ?>
<?  //vd($this->params['url']['url']); ?>
  <?php if(isset($completarLoginFB)){
//$dataFB
  ?>
  <script>
  $("bglightbox2").style.display='block';$("bglightbox2").alfa(.8);
  $("sincro").style.display='block';
  <?php if(isset($validationErrorsArrayFB['email'])){ 
	  if($validationErrorsArrayFB['email']=='El E-mail ingresado pertenece a un usuario registrado'){
		echo "$('err_sincro_email').innerHTML='El E-mail ingresado pertenece a un usuario registrado pero la clave es incorrecta.';";
	  }else{
		echo "$('err_sincro_email').innerHTML='".$validationErrorsArrayFB['email']."';";
	  }
  } ?>
   <?php if(isset($validationErrorsArrayFB['password'])){ ?>
  $('err_sincro_pass').innerHTML='<?= $validationErrorsArrayFB['password'];?>';
  <?php } ?>
  <?php if(isset($validationErrorsArrayFB['password_confirmation'])){ ?>
  $('err_sincro_pass').innerHTML='<?= $validationErrorsArrayFB['password_confirmation'];?>';
  <?php } ?>

  </script>
  <?php } ?>

<div style="overflow:hidden">
<br />
<h1>LogIn</h1>
<span style=" font-style:italic"><?php echo __("LOGIN TO YOUR ACCOUNT OR REGISTER TO CREATE ONE");?></span><br><br>


<div id="capanorecordar" class="login_izq" style="position:relative;<? if(!$ErrorRecordarClave2){?>display:block<?}else{?>display:none<?}?>">
<form id="logininterno" action="/login" method="post">
<input type="hidden" name="procesologin" value="1">
<h3 style=" color:#FFF; font-size:16px; font-style:normal"><?php echo __("USERS");?></h3><br>
<p><?php echo __("LOGIN_SUBTITLE");?><br>

  <br>
	<?php echo __("USER__EMAIL");?><br>
	<div class="rounded_login">
	<input  value="<?php if (isset($_POST['procesologin']) && isset($_POST['data']['User']['email']))echo $_POST['data']['User']['email']; ?>" autocomplete="off" type="text" name="data[User][email]" />
    <!--div style="color:#9F0000;font-size:9px;position:relative; margin-top: 8px"><?php if (isset($validationErrorsArray['email']) && !empty($validationErrorsArray['email'])){echo $validationErrorsArray['email'];}?></div-->
    </div>
  <br>

	<?php echo __("USER__PASSWORD");?><br>
    	<div class="rounded_login">
	<input value="<?php if (isset($_POST['procesologin']) && isset($_POST['data']['User']['password']))echo $_POST['data']['User']['password']; ?>"  autocomplete="off" type="password" name="data[User][password]" />
    </div>
  <br>
  <div onclick="$('caparecordar').style.display='block';$('capanorecordar').style.display='none';$('errrecordar').innerHTML=$('errlogin0').innerHTML='';" class="recuperar_pass"><a href="javascript:;"><?php echo __("RECOVER-LINK-TITLE");?></a></div>
  <div class="boton_login <?echo 'boton_login'.$_SESSION["idioma"];?>">
  <a onclick="$('logininterno').submit();return false;" href="#";><?php echo __("LOGIN");?></a>
  <input class="enter" type="submit" />


  
  </div> <div class="clear"></div>
 

  
</p>
  <div id="errlogin0" style="font-size:11px; color:red; font-family:Arial, Helvetica, sans-serif;font-style:normal; width:300px: height:20px; position:absolute; bottom:-5px;left:0"><? if(isset($error) && $error === true){ ?><? __('INVALID_LOGIN_INFORMATION')?><? }?></div>
</form>
</div>

<div id="caparecordar" class="login_izq" style="position:relative; height:180px; <? if($ErrorRecordarClave2){?>display:block<?}else{?>display:none<?}?>">
<form id="recpassform" action="/forgotPassword" method="post">
<input type="hidden" name="procesorecpass" value="1">
<h3 style=" color:#FFF; font-size:13px; font-style:normal;width:220px; height:35px; line-height:40px; background:#454545; position:relative; top:-8px; padding-bottom:2px"><?php echo __("FORGOT_PASSWORD_TITLE");?></h3><br>
<p style="position:relative; top:-8px;"><?php echo __("FORGOT_PASSWORD_SUBTITLE");?><br>

  <br>
  E-Mail<br>
	<div class="rounded_login">
	<input  value="<?php if (isset($_POST['procesorecpass']) && isset($_POST['data']['User']['email']))echo $_POST['data']['User']['email']; ?>" autocomplete="off" type="text" name="data[User][email]" />
	
	<?
	//ErrorRecordarClave
	?>
    </div>
  <br>
  <div  onclick="$('errrecordar').innerHTML=$('errlogin0').innerHTML='';$('capanorecordar').style.display='block';$('caparecordar').style.display='none';" class="recuperar_pass"><a href="javascript:;"><?php echo __("CANCEL");?></a></div>
  <div class="boton_login <?echo 'boton_login1'.$_SESSION["idioma"];?>"><a onclick="$('recpassform').submit();return false;" href="#"><?php echo __("RESTORE");?></a>
  
  </div> <div class="clear"></div>
</form>
<div id="errrecordar" style="font-size:11px; color:red; font-family:Arial, Helvetica, sans-serif;font-style:normal;height:17px; width:300px;position:relative;top:-50px; left:5px"><? if($ErrorRecordarClave){?><?echo __('ERROR_EMAIL_RECORDAR');?><? } ?>&nbsp;</div>
</div>

<div class="form_registrarme" style="position:relative;">
<form action="/signup" method="post" id="formregistroint">
<input type="hidden" name="procesoregistro" value="1">
<h3 style=" color:#333; font-size:16px; font-style:normal"><?php echo __("REGISTER_TITLE");?></h3>
<p><?php echo __("USER__DISPLAY_NAME");?></p>
<div class="rounded">
<input value="<?php if (isset($_POST['procesoregistro']) && isset($_POST['data']['User']['display_name']))echo $_POST['data']['User']['display_name']; ?>" autocomplete="off" type="text" name="data[User][display_name]" />
</div>

<div style="font-size:11px; color:red; font-family:Arial, Helvetica, sans-serif;font-style:normal; padding-left:12px; height:17px;"><?php if (isset($_POST['procesoregistro']) && isset($validationErrorsArray['display_name']) && !empty($validationErrorsArray['display_name'])){ ?><?=$validationErrorsArray['display_name']?><?php } ?>&nbsp;</div>


<p><?php echo __("USER__EMAIL");?></p>
<div class="rounded">
<input value="<?php if (isset($_POST['procesoregistro']) &&  isset($_POST['data']['User']['email']))echo $_POST['data']['User']['email']; ?>"  autocomplete="off" type="text" name="data[User][email]" />
</div>

<div style="font-size:11px; color:red; font-family:Arial, Helvetica, sans-serif;font-style:normal; padding-left:12px;height:17px;"><?php if (isset($_POST['procesoregistro']) && isset($validationErrorsArray['email']) && !empty($validationErrorsArray['email'])){ ?><?=$validationErrorsArray['email']?><?php } ?>&nbsp;</div>


<p><?php echo __("USER__PASSWORD");?></p>
<div class="rounded">
<input  value="<?php if (isset($_POST['procesoregistro']) && isset($_POST['data']['User']['password']))echo $_POST['data']['User']['password']; ?>" autocomplete="off" type="password" name="data[User][password]" />
</div>

<div style="font-size:11px; color:red; font-family:Arial, Helvetica, sans-serif;font-style:normal; padding-left:12px;height:17px;"><?php if (isset($_POST['procesoregistro']) && isset($validationErrorsArray['password']) && !empty($validationErrorsArray['password'])){ ?><?=$validationErrorsArray['password']?><?php } ?>&nbsp;</div>


<p><?php echo __("USER__PASSWORD_CONFIRMATION");?></p>
<div class="rounded">
<input  value="<?php if (isset($_POST['procesoregistro']) && isset($_POST['data']['User']['password_confirmation']))echo $_POST['data']['User']['password_confirmation']; ?>" autocomplete="off" type="password" name="data[User][password_confirmation]" />
</div>

<div style="font-size:11px; color:red; font-family:Arial, Helvetica, sans-serif;font-style:normal; padding-left:12px;height:17px;"><?php if (isset($_POST['procesoregistro']) && isset($validationErrorsArray['password_confirmation']) && empty($validationErrorsArray['password_confirmation'])){ ?><?=$validationErrorsArray['password_confirmation']?><?php } ?>&nbsp;</div>

<div class="bot_registrar" onclick="$('formregistroint').submit();"><div class="titulo_registrarme"> <?php echo __("REGISTER_ME");?> </div>
  <input class="enter" type="submit" />
<div class="terminos"><?php echo __("TERMS_OF_USER_BODY %s");?>
<a href="/page/terminos-de-uso"><?php echo __("TERMS_CONDITIONS");?></a></div>

</div>
</form>
</div>

<div  class="entrar_con_facebook">
<h3 style=" color:#FFF; font-size:15px; font-style:normal"><?php echo __("FACEBOOK_LOGIN_TITLE");?></h3>
<div style="background:#464646; position:relative;left:-8px; padding-bottom:16px;overflow:hidden">
<p><?php echo __("FACEBOOK_LOGIN_SUBTITLE");?><br>
<div onclick="window.location='/fbConnect.php';" class="boton_facebook"></div>
<div  class="ingresar_con_facebook" onclick="window.location='/fbConnect.php';">
<?php echo __("FACEBOOK_LOGIN_TITLE");?>
</div>
<div style="margin-top:50px" class="texto_importante_facebook">
<div class="icono_importante_facebook"></div>
<p><strong><?php echo __("FACEBOOK_MESSAGE_TITLE");?></strong><br>
<?php echo __("FACEBOOK_MESSAGE_MESSAGE");?></p>
</div>
  </div>
 </div>
</p>






<div class="clear"></div>

</div>
