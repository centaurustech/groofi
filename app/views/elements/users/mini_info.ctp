<?php
/* @var $this ViewCC */
$user['User'] = $data['User'];
?>
<div class="box user-box mini-profile" style="float:left;width:100%;">
    <?
    $file = $this->Media->getImage('s50', $user['User']['avatar_file'], '/img/assets/img_default_50px.png');
    echo $this->Html->link($file, User::getLink($user), array('class' => 'thumb', 'escape' => false));
    ?>

    <?= $this->Html->tag('h4', User::getName($user), array('class' => 'title', 'url' => User::getLink($user))); ?>  
    <ul class="list info-list user-info">
        <? if ($user['User']['city']) { ?>
            <li class="icon location-icon"> <span><?= $user['User']['city'] ?></span></li>
        <? } ?>
        <? foreach ($user['User']['Link'] as $link) { ?>
            <li class="icon url-icon"><?= $this->Html->link($link['link'], $link['link'], array('target' => 'blank', 'rel' => 'nofollow')) ?></li> <!-- user link -->
        <? } ?>

        <? if ($user['User']['id'] != $this->Session->read('Auth.User.id')) { ?>  
            <li class="icon message-icon">
                <a href="#send-message"  id="open-message-form" class="toggle" rel="nofollow"><? __('SEND_MESSAGE') ?></a>
                <div class="mini form" id="send-message" style="float:left;clear:both;width:100%;clear:both;margin-bottom: 10px;display:none;"><!---->
                    <?
                    echo $this->Form->create('Message', array('id' => 'messageForm', 'url' => '/messages/add'));
                    echo $this->Form->input('Message.user_id', array('type' => 'hidden', 'value' => $user['User']['id']));
                    echo $this->Form->input('Message.message', array('type' => 'textarea', 'label' => false));
                    echo $this->Form->submit(__('SEND', true));
                    echo $this->Form->end();
                    ?>
                </div>
            </li>
        <? } ?>


    </ul>
    <p style="clear:both;">
        <?= $user['User']['biography'] ?>
    </p>
</div>

<cake:script>
    <script type="text/javascript">
        $('#messageForm').submit(function(){
            var element = $(this) ;
            Auth.exec(function(){
                if (!element.hasClass('working')) {
                    element.addClass('working');
                    $.post( element.attr('action') , element.serialize() , function(response){
                        if (response.error == false ){
                            $('#send-message').hide();
                            $('<div>').addClass('susses-message').text('<? __('MESSAGE_SENT') ?>').insertAfter('#send-message')
                            setTimeout(function(){ $('.susses-message').hide(); },5000);
                        } else {
                            $('#messageForm .error-message').remove();
                            $('<div>').addClass('error-message').text(response.error_msg).insertAfter('#messageForm div.input.textarea textarea');
                        }
                        element.removeClass('working');
                    });
                }
            });
            return false ;
        })
    </script>
</cake:script>