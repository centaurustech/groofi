<div class="titleBlock   single-line" style="margin-top:30px"><div class="content"><div class="padding"><h1><?php echo __("MESSAGES_INDEX_TITLE");?></h1> </div></div></div>
<div class="content">
                    <div class="padding">
                        <div id="flashMessage">
                                                                                </div>

                        <div class="full">
                            <ul class="pageElement tabs">
        <li <?if($tab=='unread'){?>class="active"<? } ?>><a href="/messages"><?php echo __("UNREAD_MESSAGES");?></a></li>
        <li <?if($tab=='read'){?>class="active"<? } ?>><a href="/messages/read"><?php echo __("READ_MESSAGES");?></a></li>
        <li <?if($tab=='all'){?>class="active"<? } ?>><a href="/messages/all"><?php echo __("ALL_MESSAGES");?></a></li>
        <li <?if($tab=='sent'){?>class="active"<? } ?>><a href="/messages/sent"><?php echo __("SENT_MESSAGES");?></a></li>
</ul>

<div class="full post" id="content">
<?
 if (!empty($this->data)){
 foreach($this->data as $message){
 
?>

<?php
/* @var $this ViewCC */
$sent = $message['Message']['sender_id'] == $this->Session->read('Auth.User.id'); // the message was sent by me ?
$text = $sent ? 'Para' : 'De'; // ok
$sender = $sent ? array('User' => $message['User']) : array('User' => $message['Sender']);
$file = !$sender['User']['avatar_file'] ? $this->Html->image('/img/assets/img_default_50px.png') : $this->Media->embed($this->Media->file('s50/' . $sender['User']['avatar_file']));
?>

<div class="message box-message recived" id="message_<?= $message['Message']['id'] ?>">
    <div class="padding">
        <div class="thumb"><a style="text-decoration:none" target="_blank" href="<?=User::getLink($sender)?>"><?=$file?></a></div>
        <div class="content">
            <h3 class="title"><?=$text ?> <a target="_blank" href="<?=User::getLink($sender)?>"><?=User::getName($sender)?></a></h3>            <div class="right">&nbsp; | Enviado <?=$this->Time->timeAgoInWords($message['Message']['created'])?></div>            
			<div style="word-wrap: break-word;float:none" class="message">
			<?=$message['Message']['message']?>
			</div>
                    
					<div class="actions">
                    <a title="Eliminar" target="ifr" href="/messages/delete2/<?= $message['Message']['id'] ?>"><img src="/2012/images/ico_mensaje_eliminar.png" alt="Eliminar"></a>
					<? if ($message['Message']['read'] == 0) {?>
					<a title="Marcar como le&iacute;do" target="ifr" href="/messages/read2/<?= $message['Message']['id'] ?>"><img src="/2012/images/ico_mensaje_leido.png" alt="READ"></a>
					<? } ?>
					<? if (!$sent){ ?>
					<a title="Responder" onClick="$('oculto<?= $message['Message']['id'] ?>').css('display','block');return false;" href="#"><img src="/2012/images/ico_mensaje_responder.png" alt="REPLY"></a>
					</div>
					
                <div class="clear">&nbsp;</div>
                <div class="form" id="oculto<?= $message['Message']['id'] ?>">
                    <form target="ifr" id="messageForm" method="post" action="/messages/add2" accept-charset="utf-8">
					
					<input type="hidden" name="data[Message][user_id]" autocomplete="off" value="<?=$sender['User']['id']?>" id="MessageUserId">
					<input type="hidden" name="data[Message][sender_id]" autocomplete="off" value="<?=$this->Session->read('Auth.User.id')?>" id="MessageSenderId">
					<div class="input textarea required">
					<label for="MessageMessage"><?php echo __("COMMENT__COMMENT");?></label><textarea name="data[Message][message]" autocomplete="off" cols="30" rows="6" id="MessageMessage"></textarea>
					</div>                    <div class="submit">
                        <input type="submit" value="Enviar"><input style="text-align:center; width:auto;" type="button" onClick="$('oculto<?= $message['Message']['id'] ?>').css('display','none');" value="Cancelar"></div>
                    </form>                </div>
					<?}?>
                    </div>
    </div>
    <div class="clear">&nbsp;</div>
</div>
<? }}else{?>
		<div class="generic-message">
            <?php 
               __('NO_MESSAGES_TO_SHOW');
            ?>
        </div>
<? } ?>





</div>
<style type="text/css">


    .message.box-message { padding: 20px 0px ; border-bottom: 1px solid #EAEAEA ; width :100% }
    .message.box-message .thumb { width : 50px ; margin-right: 10px ; float : left ; }
    .message.box-message .content { float : left ; clear : none ; width:940px  }
    .message.box-message .content .title {  font-size: 13px ; color : #999999 ; font-weight: normal ; font-family: Tahoma ; float : left ; margin-bottom:10px;}
    .message.box-message .content .title a { font-family: Tahoma ; }
    .message.box-message .content .message {  font-size: 13px ; color : #666666 ; float : left ; clear: both ; line-height:16px; margin-bottom:10px;}
    .message.box-message .content .right {  font-size: 13px ; color : #999999 ; padding-left:10px;}
    .message.box-message .actions { float : left ; clear : both ;}
    .message.box-message .actions a {display: inline-block  ; }
    .message.box-message .actions img {display: inline-block  ; margin-left: 5px ;}

    .message.box-message .form {
        background-color: #F8F8F8 ;
        padding: 20px 20px 0px 20px ;
        border-top : 1px solid #EAEAEA ;
        border-bottom : 3px solid #EAEAEA ;
        clear : both ;
        margin-top: 10px ;
        margin-bottom: 0px ;
        display : none ;
    }

    .message.box-message .form textarea { width : 800px ; }
</style>           