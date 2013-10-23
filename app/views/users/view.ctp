<?php /* @var $this ViewCC */
if (isset($fb_login)){

echo '<div id="fb-root"></div><div id="mfs"></div>
<script src="//connect.facebook.net/es_LA/all.js"></script>
<script>
    /*Quitar cuando se agregue la app original*/
    window.fbAsyncInit = function() {
        FB.init({appId: "312785135481965",
            status: true,
            cookie: true,
            xfbml: true});


    };
</script>
<script>
    var usersID = [];
    function sendRequest() {

        FB.ui({method: "apprequests",
            //to: sendUIDs,
            title: "Recomendar Groofi a tus amigos",
            message: "Visita http://groofi.com!",
            filters: [{name: "Suggested", user_ids: usersID}]
        }, callback);
    }

    function callback(response) {
        console.log(response);
    }

    jQuery(document).ready(function(){
        FB.getLoginStatus(function(response) {
            if (response.status === "connected") {
                var uid = response.authResponse.userID;
                var accessToken = response.authResponse.accessToken;
                FB.api("/me/friends", function(response) {
                    for(var i = 0; i < response.data.length; i++) {
                        usersID.push(response.data[i].id);
                    }
                        sendRequest();
                });
            } else if (response.status === "not_authorized") {

            } else {
                FB.login(function(response) {
                    if (response.authResponse) {

                        FB.api("/me/friends", function(response) {

                        for(var i = 0; i < response.data.length; i++) {
                            usersID.push(response.data[i].id);
                        }
                            sendRequest();
                        });
                    } else {
                        console.log("error");
                    }
                });
            }
        });
    });
</script>
';
}
?>

<!--------------------------->
<?
//vd($this->Session->check('deletedok'));
    $user = isset($user) ? $user : $this->data;
    $this->set('pageTitle', $this->Html->link(User::getName($user, 'User'), User::getLink($this->data, null, false)));
    $this->set('pageSubTitle', City::getName($user));
    $this->set('class', 'profile');
    $file = !$user['User']['avatar_file'] ? $this->Html->image('/img/assets/img_default_200px.png') : $this->Media->embed($this->Media->file('m200/' . $user['User']['avatar_file']));
	$owner = User::isOwner($this->data);
	$offerCount = ( $owner ? $this->data['User']["offer_count"] + $this->data['User']["offer_proposal_count"] : $this->data['User']["offer_count"] ) + $this->data['User']["follow_offer_count"];
    $projectCount = $owner ? $this->data['User']["project_count"] + $this->data['User']["project_proposal_count"] : $this->data['User']["project_count"];
	
	?>

<div style="overflow:hiddden; width:935px;">

<div class="clear"></div><br><br>
<div class="izquierda_perfil">

<div class="foto_perfil"><?= $file ?></div>
 <? if ($this->Session->read('Auth.User.id') == $user['User']['id']) { ?>
<li class="editProfile">
                     <a href="/settings" rel="no-follow">
                        <span class="ui-icon site-icon medium icon-edit">&nbsp;</span>
                        <?php echo __("EDIT_PROFILE");?></a>

                </li>
<? } ?>

<div class="bio_perfil">
<? if ($user['User']['biography'] != '') { ?>
	<h4 class="tit_bio_perfil">BIO</h4>
	<div class="separa_perfil"></div>
	<p class="texto_bio"><?= nl2br($user['User']['biography']) ?></p><br>
<? } ?>
<? if (count($user['Link']) >= 1) { ?>
<h4 class="tit_bio_perfil">Websites</h4>
<div class="separa_perfil"></div>
 <? foreach ($user['Link'] as $link) { ?>
<p class="texto_bio"> <?= $this->Html->link($link['link'], $link['link'], array('target' => '_blank')); ?></p>
<? } ?>


<? } ?>
</div>
</div>





<div class="perfil_derecha">
<div style="overflow:hiddden;">
	<h1 class="nombre_perfil"><?= $this->Html->link(User::getName($user, 'User'), User::getLink($this->data, null, false));?></h1>
	<div class="ubicacion_perfil"><?= City::getName($user);?></div><br>
	<div class="solapas_perfil">
<? if ($owner) {?>
<div class="tit_novedades"><a href="<?= Router::url(array('controller' => 'notifications', 'action' => 'wall')) ?>" class="tit_actividad<? if($section=='wall'){?> selected<? } ?>"><?php echo __("ACTIVITY");?></a></div>
<? } ?>

<div class="tit_actividad"><a href="<?=User::getLink($this->data,'activity')?>" class="tit_actividad<? if($section=='activity'){?> selected<? } ?>"><?php echo __("USER_ACTIVITY");?><span style="color:#1e455b; font-weight:500"></span></a></div>


<div class="tit_proyectos">
<? if ($projectCount > 0) { ?>
<a href="<?=User::getLink($this->data, 'projects')?>" class="tit_proyectos<? if($section=='projects'){?> selected<? } ?>"><?php echo __("USER_PROJECTS %s");?> <span style="color:#1e455b; font-weight:500">(<?=$projectCount?>)</span></a>
<? }else{ ?>
<a href="/projects/add" class="tit_proyectos<? if($section=='projects'){?> selected<? } ?>"><?php echo __("PROJECTS_ADD");?></a>
<? } ?>
</div>

<? if ($this->data['User']["sponsorships_count"] > 0) { ?>
<div class="tit_patrocinando"><a href="<?=User::getLink($this->data, 'bakes')?>" class="tit_patrocinando<? if($section=='sponsorships'){?> selected<? } ?>">Patrocinando <span style="color:#1e455b; font-weight:500">(<?=$this->data['User']["sponsorships_count"]?>)</span></a></div>
<? } ?>

<? if ($this->data['User']["follow_count"]  > 0) { ?>
<div class="tit_siguiendo"><a href="<?=User::getLink($this->data, 'follows')?>" class="tit_siguiendo<? if($section=='follows'){?> selected<? } ?>">Siguiendo <span style="color:#1e455b; font-weight:500">(<?=$this->data['User']["follow_count"]?>)</span></a></div>
<? } ?>
	</div>
	
<br><br><br><br>
<?
switch($section){
case 'activity':
case 'wall':
$data =$this->data;
$notifications = $data['Notifications'];
$search=array(
'POST_COMMENTED',
'PROJECT_COMMENTED',
'PROJECT_NEW_UPDATE',
'PROJECT_CREATED',
'PROJECT_ABOUT_TO_FINISH',
'PROJECT_FUNDED',
'PROJECT_DONT_FUNDED'
);
//vd($data['Notifications']);
if ( !empty($data['Notifications']) && is_array($data['Notifications'])) {
    foreach ($notifications as $key => $notification) {
	//$elementPath = 'notifications'.DS.$type.DS.Inflector::pluralize($notification['Notificationtype']['model']) . DS .low($notification['Notificationtype']['name']);
	//echo $this->element($elementPath,array('data' => unserialize($notification['Notification']['data'])));
	//echo $elementPath.'<br/>';
	$data=unserialize($notification['Notification']['data']);
	
	
?>

<div class="novedad">
<div class="info_usuario_novedad">
<h4 class="nombre_usuario_novedad"><?= $this->Html->link(User::getName($data), User::getLink($data), array('class' => 'username')); ?></h4>
<span class="ui-icon site-icon auto-icon medium">&nbsp;</span>
<p class="novedad_titulo">
<?
/*echo $this->Time->format($notification['Notification']['created'], '%A %d  ');die;*/
$replace=array(
'Coment&oacute; una actualizaci&oacute;n -'.$this->Time->format($notification['Notification']['created'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y'),
'Coment&oacute; un proyecto -'.$this->Time->format($notification['Notification']['created'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y'),
sprintf(
                __("ADD_UPDATE_PROJECT", true).'-%s- %s', $this->Html->link(Project::getName($data), Project::getLink($data)), $this->Time->format($notification['Notification']['created'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y')
        ),
sprintf(
                __("PUBLISH_PROJECT", true).'%s -%s-', $this->Html->link(Project::getName($data), Project::getLink($data)), $this->Time->format($notification['Notification']['created'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y')
        ),
sprintf(
                __("24_HS_LEFT ", true).'%s -%s-', $this->Html->link(Project::getName($data), Project::getLink($data)), $this->Time->format($notification['Notification']['created'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y')
        ),
sprintf(
                __("YOUR_PROJECT", true).'to'.__("PROJECT_IS_FINISHED", true).'o. -%s-', $this->Html->link(Project::getName($data), Project::getLink($data)), $this->Time->format($notification['Notification']['created'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y')
        ),
sprintf(
                __("YOUR_PROJECT", true).' %s'.__("PROJECT_IS_FINISHED", true).'-%s-', $this->Html->link(Project::getName($data), Project::getLink($data)), $this->Time->format($notification['Notification']['created'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y')
        )		
		
		
);
?>
<?=str_replace($search,$replace,$notification['Notificationtype']['name']);
        ?></p>
<br>

<h5 class="novedad_actualizacion"><a href="<?=Post::getLink($data)?>"><?=Post::getName($data)?></a></h5>
<div class="separa_novedad"></div>
<p class="txt_novedad"><?=$this->Text->truncate(strip_tags($data['Post']['description']), 400, array('ending' => '... ' . $this->Html->link(__('VIEW_UPDATE', true), Post::getLink($data)))) ?></p>
<div class="foto_usuario_novedad">
        <?
        $file = !$data['User']['avatar_file'] ? $this->Html->image('/img/assets/img_default_50px.png') : $this->Media->embed($this->Media->file('s50/' . $data['User']['avatar_file']));
        echo $this->Html->link($file, User::getLink($data), array('escape' => false, 'class' => 'thumb'));
        ?>
</div>
</div>
<br><br><br><br>
</div>

<? } 
} else {
    ?>
    <div class="not-found-msg">
        <p class="txt_novedad" style="position:relative; left:1px"><?__('THIS_USER_HAS_NOT_ANY_ACTIVITY_YET');?></p>
    </div>
    <?
}
?>

<?
//fin case activity//wall
break;
case 'projects':
case 'sponsorships':
case 'follows':
$data=$this->data;
if ( (isset($data['Projects']) && is_array($data['Projects'])) || isset($data['Follows']) && is_array($data['Follows'])) {
if($section!='follows')
	$projects = $data['Projects'];
else
	$projects = $data['Follows'];
foreach ($projects as $key => $project) {
 $owner=($this->Session->read('Auth.User.id') == $project['Project']['user_id']);
 if ($project) {
?>
<div class="novedad">

<div class="feed-content" style="float : right ; width : 720px ; margin-top:-15px;position:relative; z-index:2000;">
      <div style="display: block">
<div id="project_<?= $project['Project']['id'] ?>" class="box box-project box-profile-project">
    <div class="thumb2">
	<?if(Project::isEnabled($project)){?>
	<a style="text-decoration:none" href="<?=Project::getLink($project)?>"><?}?><?=$this->Media->getImage('l280', $project['Project']['image_file'], '/img/assets/img_default_280x210px.png');?><?if(Project::isPublic($project)){?></a><?}?>
	  
	  
	  <? if(Project::getPrivacityStatus($project['Project']['id']) && !(Project::getFundedValue($project)>=100) ){?><div class="candadoProject"></div><? } ?>
      <? if(Project::getFundedValue($project)>=100 ){?><div class="fundedProject"></div><? } ?>
	  
	  </div><div class="info"><h3 class="title"><?if(Project::isEnabled($project)){?><a href="<?=Project::getLink($project)?>"><?}?><?=$project['Project']['title']?><?if(Project::isPublic($project)){?></a><?}?></h3><h4 class="sub-title"><?php echo __("USER_INFO");?><a href="<?=User::getLink($data)?>"><?=User::getName($data)?></a></h4>
	  <p class="description"><?=$project['Project']['short_description']?></p>
	  <a class="category tag" href="<?=Category::getLink($project, 'projects')?>"><span class="site-icon small icon-tag">&nbsp;</span><?=Category::getName($project)?></a>
	  </div>            <div class="projectStats stats">

<div class="ext">
<div class="bar" style="left:<?php $p=Project::getFundedValue($project)>100?100:Project::getFundedValue($project); echo -280-((-282/100)*$p) ?>px"></div>
<div class="arr_perfil"></div>
</div>

                <div class="statBox bottom left bl"><b><?= Project::getFundedValue($project) ?>% </b><?php echo __("PROJECT_FUNDED_INFO");?></div>

                <div class="statBox bottom left bl"><b><span style="font-size:10px; font-family:Verdana, Geneva, sans-serif"><?=Project::getMoneda($project);?></span> <?= Project::getCollectedValue($project) ?></b><?php echo __("PLEDGED");?></div>

                <div class="statBox bottom left bl"><b><?= $project['Project']['sponsorships_count']; ?></b><?php echo __("PROJECT_BAKES");?></div>
				
				
				
				
				<? if(Project::getFundedValue($project)>=100){?>
                <div class="statBox bottom right br green"><b><?php echo __("FUNDED");?>!</b>&nbsp;</div>
				<? }elseif(!Project::isEnabled($project)){ ?>
				<div class="statBox bottom right br green"><b><?php echo __("PENDING_APPROVAL");?></b>&nbsp;</div>
				<? }elseif(!Project::isPublic($project)){ ?>
				<div class="statBox bottom right br green"><b>No publicado</b>&nbsp;</div>
                <? }elseif($project['Project']['time_left']>=0){ ?>
				<div class="statBox bottom left bl"><b><?= intval($project['Project']['time_left']); ?></b><?php echo __("DAYS_LEFT");?></div>
				<? }elseif($project['Project']['time_left']<0){ ?>
				<div class="statBox bottom right br green"><b>Finalizado!</b>&nbsp;</div>
				<? } ?>
				
				
				
                <div class="clear">&nbsp;</div>
            </div>
        <div class="clear"></div>
		<div style="padding-top:10px;">
		<? if(!Project::isEnabled($project)){?>
		
			<? if(!Project::isPublic($project)){?>
			
			<a style="left:-20px" class="delproy" href="/projects/delete/<?=$project['Project']['id']?>"><span class="delp"></span><?php echo __("DELETE");?></a>
			<?}?>
			
		<?}else{?>
		
			<? if(!Project::isPublic($project)){?>
			
			<a  class="lanzarproy" href="/project/<?=$project['Project']['id']?>/publish"><span class="lanzp"></span><?php echo __("PUBLISH_PROJECT");?></a>
			<a  class="editproy" href="/projects/edit/<?=$project['Project']['id']?>"><span class="editp"></span><?php echo __("edit");?></a>
			<a  class="delproy" href="/projects/delete/<?=$project['Project']['id']?>"><span class="delp"></span><?php echo __("DELETE");?></a>
			<?}else{?>
			<? if($owner){?>

                    <a  style="border-right: none!important;" class="editproy" href="/projects/edit/<?=$project['Project']['id']?>"><span class="editp"></span><?php echo __("edit");?></a>
                    <a  class="lanzaract" href="/project/<?=$project['Project']['id']?>/create-update"><span class="lanzact"></span><?php echo __("CREATE_UPDATE");?></a>

			<? } ?>
			<? } ?>
		<? } ?>
		</div>
		</div><!--</div>-->
<? } ?>

<? } ?>

<? } ?>



    </div>

    </div><div class="clear"></div>
    </div>
<div class="clear"></div>
</div>
<?
break;
}?>
</div>


<div style="clear:both"></div>

</div>
<?if($this->Session->check('deletedok')){?>
<script>DR(function(){alerta("El proyecto ha sido eliminado");});</script>
<?
$this->Session->delete('deletedok');
}?>
<!--------------------------->



