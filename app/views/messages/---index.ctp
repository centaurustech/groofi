<?php /* @var $this ViewCC */ ?>

<ul class="pageElement tabs">
        <li class="<?=$tab=='unread'?'active':''?>" ><a href="/messages"><? __('UNREAD_MESSAGES') ?></a></li>
        <li class="<?=$tab=='read'?'active':''?>" ><a href="/messages/read"><? __('READ_MESSAGES') ?></a></li>
        <li class="<?=$tab=='all'?'active':''?>" ><a href="/messages/all"><? __('ALL_MESSAGES') ?></a></li>
        <li class="<?=$tab=='sent'?'active':''?>" ><a href="/messages/sent"><? __('SENT_MESSAGES') ?></a></li>
</ul>

<div class="full post" id="content" >

<?



    if (!empty($this->data)){
        foreach ($this->data as $message ) {

                echo $this->element('messages/message',array('data'=>$message));

        }
    } else {
        ?>
        <div class="generic-message">
            <?php 
               __('NO_MESSAGES_TO_SHOW');
            ?>
        </div>
        <?
    }

?>

</div>

<style type="text/css">


    .message.box-message { padding: 20px 0px ; border-bottom: 1px solid #EAEAEA ; width :100% }
    .message.box-message .thumb { width : 50px ; margin-right: 10px ; float : left ; }
    .message.box-message .content { float : left ; clear : none ; width :840px ;  }
    .message.box-message .content .title {  font-size: 13px ; color : #999999 ; font-weight: normal ; font-family: Tahoma ; float : left ;}
    .message.box-message .content .title a { font-family: Tahoma ; }
    .message.box-message .content .message {  font-size: 11px ; color : #666666 ; float : left ; clear: both ; }
    .message.box-message .content .right {  font-size: 11px ; color : #999999 ; float : right ;}
    .message.box-message .actions { float : right ; clear : both ;}
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