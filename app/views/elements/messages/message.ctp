<?php
/* @var $this ViewCC */
$sent = $data['Message']['sender_id'] == $this->Session->read('Auth.User.id'); // the message was sent by me ?
$text = $sent ? __('TO %s', true) : __('FROM %s', true); // ok
$sender = $sent ? array('User' => $data['User']) : array('User' => $data['Sender']);
$file = !$sender['User']['avatar_file'] ? $this->Html->image('/img/assets/img_default_50px.png') : $this->Media->embed($this->Media->file('s50/' . $sender['User']['avatar_file']));
?>
<div class="message box-message <?= $sent ? 'sent' : 'recived' ?>" id="message_<?= $data['Message']['id'] ?>">
    <div class="padding" >
        <div class="thumb"><?= $file ?></div>
        <div class="content">
            <? echo $this->Html->tag('h3', sprintf($text, $this->Html->link(User::getName($sender), User::getLink($sender))), array('class' => 'title', 'target' => '_blank')); ?>
            <? echo $this->Html->div('right', sprintf(__('SENT %s',true), $this->Time->timeAgoInWords($data['Message']['created']))); ?>
            <? echo $this->Html->div('message', $data['Message']['message'] , array('style'=>'word-wrap: break-word;float:none')); ?>

            <? if (!$sent){ ?>
                <div class="actions">
                    <?
                    echo $this->Html->image('/img/assets/ico_mensaje_eliminar.png', array('alt' => __('DELETE', true), 'url' => '/messages/delete/' . $data['Message']['id']));
                    if ($data['Message']['read'] == 0) {
                        echo $this->Html->image('/img/assets/ico_mensaje_leido.png', array('alt' => __('READ', true), 'url' => '/messages/read/' . $data['Message']['id']));
                    }
                    echo $this->Html->image('/img/assets/ico_mensaje_responder.png', array(
                        'alt' => __('REPLY', true), 'onclick' => "$('.message.box-message .form').hide();$('#reply_{$data['Message']['id']}').show();"
                            )
                    );
                    ?>
                </div>
                <div class="clearfix">&nbsp;</div>
                <div class="form" id="reply_<?= $data['Message']['id'] ?>">
                    <?
                    echo $this->Form->create('Message', array('id' => 'messageForm', 'url' => '/messages/add'));
                    echo $this->Form->input('Message.user_id', array('type' => 'hidden', 'value' => $sender['User']['id']));
                    echo $this->Form->input('Message.sender_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
                    echo $this->Form->input('Message.message', array('type' => 'textarea'));
                    ?>
                    <div class="submit">
                        <?
                        echo $this->Form->submit(__('SEND', true), array('div' => false, 'after' => $this->Form->button(__('CANCEL', true), array('onclick' => "$('#reply_{$data['Message']['id']}').hide();"))));
                        ?>
                    </div>
                    <?
                    echo $this->Form->end();
                    ?>
                </div>
            <? } ?>
        </div>
    </div>
    <div class="clearfix">&nbsp;</div>
</div>

<cake:script>
    <script type="text/javascript">
        $('#reply_<?= $data['Message']['id'] ?> form').submit(function(){
            e = $(this) ;
            $.post( e.attr('action') , e.serialize() , function(response){
                $('.error-message').remove();
                if (!response.error){
                    e.parent('.form').hide();
                } else {
                    e.children('.textarea').append($('<div>').addClass('error-message').text(response.error_msg));
                }
            });
            return false ;
        });


        $('#message_<?= $data['Message']['id'] ?> .actions a').click(function(){
            e = $(this) ;

            $.get(e.attr('href') , function(e) {

                window.location = window.location ;


            });

            return false ;
        })
    </script>
</cake:script>