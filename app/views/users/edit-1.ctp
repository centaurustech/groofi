<?php /* @var $this ViewCC */ ?>
<?
    $this->set('titleClass', 'tabs');
    $this->set('pageTitle', __(up(sprintf('USER_EDIT_%s', $this->params['tab'])), true));
    $this->set('pageSubTitle', sprintf(__('OF %s', true), $this->Html->link(User::getName($this->data), User::getLink($this->data, null, false))));
?>
<?php
//vd($_SESSION['Message']['flash']['message']);
?>

<h1 style="font-weight:normal; font-size:28px; line-height:32px; margin-top:30px"><?php echo __("USER_EDIT_");?></h1>
<span style=" font-style:italic"><?php echo __("OF");?><a onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'" style="color:#57a2be;" href="<?php echo User::getLink($this->data, null, false); ?>" class="cyan"><?php echo User::getName($this->data);?></a></span><br>
<div class="misc_separador" style="height:1px; width:100%"></div>

<div onclick="location='<?=Router::url (array ('controller' => 'users', 'action' => 'edit', 'tab' => 'profile'))?>';" class="tit_mi_perfil selected"></div>
<div onclick="location='<?=Router::url (array ('controller' => 'users', 'action' => 'edit', 'tab' => 'account'))?>';" class="tit_mi_cuenta"></div><br>
<div class="clear"></div><br><br>
<?
if(isset($_SESSION['Message']['flash']['message']) && !empty($_SESSION['Message']['flash']['message'])){
echo '<div style="width:100%; line-height:20px; border:1px solid #eaeaea; background:#f4f4f4; padding:10px; margin-bottom:20px;font-size:12px; border-bottom:3px">'.$_SESSION['Message']['flash']['message'].'</div>';
unset($_SESSION['Message']['flash']['message']);
}
?>
<div onclick="location='<?=Router::url (array ('controller' => 'users', 'action' => 'edit', 'tab' => 'profile'))?>';" class="perfil_user"><?php echo __("USER_PROFILE")?;></div>
<div onclick="location='<?=Router::url (array ('controller' => 'users', 'action' => 'edit', 'tab' => 'account'))?>';" class="cuenta_user"><?php echo __("account")?;></div>
<h2 style="cyan"><?php echo __("USER_PROFILE");?></h2>
<p><?php echo __("PROJECT_ADD_FIRST_BLOCK_SUBTITLE");?></p>
<div class="misc_separador"></div>
<form id="formchangesettings" enctype="multipart/form-data" method="post" action="/settings/profile" accept-charset="utf-8" style="overflow:hidden">
<input type="hidden" name="data[User][id]" value="<?php echo $this->data['User']['id'];?>" id="UserId" />

<div class="foto">
<?php echo __("MY_PHOTO_EDIT_PROFILE_TITLE");?>
<br>
<?
$file=$this->Media->file('m200/' . $this->data['User']['avatar_file']);
$file=$this->Media->embed($file);
$file=( empty($file) ? $this->Html->image('/img/assets/img_default_200px.png') : $file);
echo $file;
?>

 <div id="bajofoto1"><?php echo __("UPLOAD_BROWSE");?></div>
 <div id="extfoto1"><input onchange="if((this.value.toLowerCase().indexOf('.jpg')==-1) && (this.value.toLowerCase().indexOf('.jpeg')==-1) && (this.value.toLowerCase().indexOf('.gif')==-1) && (this.value.toLowerCase().indexOf('.png')==-1)){$('elfile').innerHTML='<span style=&quot;color:red;font-size:9px&quot;>Formato de archivo no permitido.</span>';return;}$('elfile').innerHTML=this.value" onmouseover="$('bajofoto1').style.background='#237fb5';" onmouseout="$('bajofoto1').style.background='#000';" id="foto1"  name="data[User][file]" autocomplete="off" type="file" /></div>



<br><div id="elfile"><?php echo __("UPLOAD_NO_FILE_SELECTED");?></div><br>
</div>

<div class="perfil_izq" style="width:500px; height:auto; overflow:hidden">
<p><?php echo __("USER__DISPLAY_NAME");?></p>
<div class="rounded_perfil">
<input value="<?=$this->data['User']['display_name']?>" type="text" name="data[User][display_name]" style="width:330px"/>
</div>

<div style="color:red;font-size:9px;"><?php if (isset($validationErrorsArray['display_name']) && !empty($validationErrorsArray['display_name'])){echo $validationErrorsArray['display_name'];}?></div>
<br>
<p>BIO</p>
<div class="rounded_area_perfil">
<textarea name="data[User][biography]" cols="1" rows="1" style="width:350px;height:127px; resize:none;"><?=$this->data['User']['biography']?></textarea>
</div><br>
<p><?php echo __("USER__GENDER");?></p>
<div class="select_perfil">
<select style="border:1px solid #e1e1e1; background:#f6f7f6" name="data[User][gender]" autocomplete="off" class="styled">
	<?php foreach($genders as $k=>$v){
	$selected='';
	if($this->data['User']['gender']==$k){
		$selected=' selected="selected" ';
	}
	?>
    <option<?=$selected?> value="<?php echo $k ?>"><?php echo $v ?></option>
	<?php }?>
</select>
</div>

<br>
<p><?php echo __("USER__TIMEZONE");?></p>
<div class="select_perfil">
<select style="border:1px solid #e1e1e1; background:#f6f7f6" name="data[User][timezone]" autocomplete="off" class="styled">
    <?php foreach($timezones as $k=>$v){
	$selected='';
	if($this->data['User']['timezone']==$k){
		$selected=' selected="selected" ';
	}
	?>
    <option<?=$selected?> value="<?php echo $k ?>"><?php echo $v ?></option>
	<?php }?>
</select>
</div>

<br>
<p><?php echo __("USER_LOCATION_LABEL");?></p>
<div class="rounded_perfil">
<input value="<?=$this->data['User']['city']?>" type="text" name="data[User][city]"  autocomplete="off"  style="width:330px"/>
<input type="hidden" name="data[User][city_id]" autocomplete="off" id="UserCityId" />
</div>

<br>
<p><?php echo __("USER_WEBSITES");?></p>
<div class="rounded_perfil2">
<?php
$urls=Link::getUsersLinks($this->data['User']['id']);
?>
<div class="rounded_perfil">
<input value="<? if(isset($urls[0]['links']['link']))echo $urls[0]['links']['link']?>" id="web0" type="text" name="data[Link][0][link]" style="width:330px"/>
<input  type="hidden" name="data[Link][0][model]" autocomplete="off" value="User" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<? if(isset($urls[1]['links']['link']))echo $urls[1]['links']['link']?>"   id="web1" type="text" name="data[Link][1][link]" style="width:330px"/>
<input type="hidden" name="data[Link][1][model]" autocomplete="off" value="User" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<? if(isset($urls[2]['links']['link']))echo $urls[2]['links']['link']?>"   id="web2" type="text" name="data[Link][2][link]" style="width:330px"/>
<input type="hidden" name="data[Link][2][model]" autocomplete="off" value="User" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<? if(isset($urls[3]['links']['link']))echo $urls[3]['links']['link']?>"   id="web3" type="text" name="data[Link][3][link]" style="width:330px"/>
<input type="hidden" name="data[Link][3][model]" autocomplete="off" value="User" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<? if(isset($urls[4]['links']['link']))echo $urls[4]['links']['link']?>"   id="web4" type="text" name="data[Link][4][link]" style="width:330px"/>
<input type="hidden" name="data[Link][4][model]" autocomplete="off" value="User" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<? if(isset($urls[5]['links']['link']))echo $urls[5]['links']['link']?>"   id="web5" type="text" name="data[Link][5][link]" style="width:330px"/>
<input type="hidden" name="data[Link][5][model]" autocomplete="off" value="User" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<? if(isset($urls[6]['links']['link']))echo $urls[6]['links']['link']?>"   id="web6" type="text" name="data[Link][6][link]" style="width:330px"/>
<input type="hidden" name="data[Link][6][model]" autocomplete="off" value="User" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<? if(isset($urls[7]['links']['link']))echo $urls[7]['links']['link']?>"   id="web7" type="text" name="data[Link][7][link]" style="width:330px"/>
<input type="hidden" name="data[Link][7][model]" autocomplete="off" value="User" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<? if(isset($urls[8]['links']['link']))echo $urls[8]['links']['link']?>"   id="web8" type="text" name="data[Link][8][link]" style="width:330px"/>
<input type="hidden" name="data[Link][8][model]" autocomplete="off" value="User" />
</div>
<div class="rounded_perfil" style="display:none">
<input value="<? if(isset($urls[9]['links']['link']))echo $urls[9]['links']['link']?>"   id="web9" type="text" name="data[Link][9][link]" style="width:330px"/>
<input type="hidden" name="data[Link][9][model]" autocomplete="off" value="User" />
</div>
</div>
<div style="color:red;font-size:9px;"><?php if (isset($validationErrorsArray['Link']) && !empty($validationErrorsArray['Link'])){echo 'Por favor ingrese una url v&aacute;lida';}?></div>
<br>

<div onclick="$('formchangesettings').submit();" class="bot_guardar"><?php echo __("USER__PROFILE_SAVE");?></div>
</div>
</form>
<script>
DR(function(){
	for(var i=0;i<10;i++){
		
			if($('web'+i).value.length>1){
				$('web'+i).parentNode.style.display='block';
				if($('web'+(i+1))){
					$('web'+(i+1)).parentNode.style.display='block';
				}
			}
		
		$('web'+i).addEvent(
			'keyup',
			function(e){
				var o=e.target || e.srcElement;
				var indice=(o.id).substring(3);
				if(o.value.length){
					if($('web'+(parseInt(indice,10)+1))){
						$('web'+(parseInt(indice,10)+1)).parentNode.style.display='block';
					}
				}else{
					o.parentNode.style.display='none';
				}
				
			}
		);
	}
});
</script>