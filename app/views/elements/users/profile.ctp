<div style="width:100%; height:auto;position:relative !important;">
<div class="column col-1  col-profile">
    <?php /* @var $this ViewCC */ ?>
    <?
    $user = isset($user) ? $user : $this->data;
    $this->set('pageTitle', $this->Html->link(User::getName($user, 'User'), User::getLink($this->data, null, false)));
    $this->set('pageSubTitle', City::getName($user));
    $this->set('class', 'profile');
    $file = !$user['User']['avatar_file'] ? $this->Html->image('/img/assets/img_default_200px.png') : $this->Media->embed($this->Media->file('m200/' . $user['User']['avatar_file']));
    ?>
    <div class="thumb"><?= $file ?></div>
    <ul class="user-info">

        <? if ($this->Session->read('Auth.User')) { ?>
            <? if ($this->Session->read('Auth.User.id') == $user['User']['id']) { ?>
                <li class="editProfile ">
                    <a href="<?= User::getLink($this->data, 'settings') ?>" rel="no-follow">
                        <span class="ui-icon site-icon medium icon-edit">&nbsp;</span>
                        <? __('EDIT_PROFILE') ?>
                    </a>

                </li>
            <? } else { ?>


                <? if (Sponsorship::isSponsoring($this->Session->read('Auth.User.id'), $user)) { ?>
                    <li class="rank underline topline">
                        <?
                        $score = (int) $this->data['User']['score'];
                        ?>
                        <a href="<?= User::getLink($this->data, array('extra' => 'vote', 'value' => 1)) ?>" class="<?= $score >= 1 ? 'active' : '' ?>" rel="no-follow">&nbsp;</a>
                        <a href="<?= User::getLink($this->data, array('extra' => 'vote', 'value' => 2)) ?>" class="<?= $score >= 2 ? 'active' : '' ?>" rel="no-follow">&nbsp;</a>
                        <a href="<?= User::getLink($this->data, array('extra' => 'vote', 'value' => 3)) ?>" class="<?= $score >= 3 ? 'active' : '' ?>" rel="no-follow">&nbsp;</a>
                        <a href="<?= User::getLink($this->data, array('extra' => 'vote', 'value' => 4)) ?>" class="<?= $score >= 4 ? 'active' : '' ?>" rel="no-follow">&nbsp;</a>
                        <a href="<?= User::getLink($this->data, array('extra' => 'vote', 'value' => 5)) ?>" class="<?= $score >= 5 ? 'active' : '' ?>" rel="no-follow">&nbsp;</a>
                        <span><?= __('VOTE', true) ?></span>
                    </li>
                <? } ?>

                <li class="sendMessage underline">

                    <a href="#send-message" class="toggle" rel="no-follow">
                        <span class="ui-icon site-icon medium icon icon-message">&nbsp;</span>
                        <? __('SEND_MESSAGE') ?>
                    </a>
                    <div class="mini form" id="send-message" style="float:left;clear:both;width:100%;clear:both;margin-bottom: 10px;display:none;"><!---->
                        <?
                        echo $this->Form->create('Message', array('id' => 'messageForm', 'url' => '/messages/add'));
                        echo $this->Form->input('Message.user_id', array('type' => 'hidden', 'value' => $user['User']['id']));
                        echo $this->Form->input('Message.message', array('type' => 'textarea', 'label' => false));
                        echo $this->Form->submit(__('SEND', true));
                        echo $this->Form->end();
                        ?>
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
                </li>


                <? if (!Report::hasReported($this->data)) { ?>
                    <li class="reportProfile">
                        <a href="<?= User::getLink($this->data, 'report') ?>" class="ajax" rel="no-follow">
                            <span class="ui-icon site-icon medium icon-report">&nbsp;</span>
                            <? __('REPORT_USER') ?>
                        </a>
                    </li>
                <? } ?>
            <? } ?>

        <? } ?>

        <? if ($user['User']['biography'] != '') { ?>
            <li>
                <h2><?= __('USER_BIO') ?></h2>
                <p>
                    <?= nl2br($user['User']['biography']) ?>
                </p>
            </li>
        <? } ?>


        <? if (count($user['Link']) >= 1) { ?>
            <li>
                <h2><?= __('USER_BIO') ?></h2>
                <ul class="user-links">
                    <? foreach ($user['Link'] as $link) { ?>
                        <li>
                            <?= $this->Html->link($link['link'], $link['link'], array('target' => '_blank')); ?>
                        </li>
                    <? } ?>
                </ul>
            </li>
        <? } ?>
    </ul>
</div>

<cake:script>
    <script type="text/javascript">
    
        var count = <?= $score ?>;
        $('.rank a').hover(
        function(){ 
            count = $('.rank a.active').length ;
            $('.rank a').removeClass('active');
            $(this).prevAll('a').addClass('hover') ; 
        
        },
        function(){ 
            for ( a=0 ; a < count ; a++ ) {
                $('.rank a').eq(a).addClass('active');
            }
            $(this).prevAll('a').removeClass('hover');
        }
    );
        
        
            
        $('.reportProfile a').click(function(){
            var e = $(this);
            Auth.exec(function(){
                $.get(e.attr('href'),function(){
                    e.parents('li.reportProfile').remove();
                });
            });
                
                
            return false ;
        });
        
        
        $('.rank a').click(function(){
            var e = $(this);
            Auth.exec(function(){
                $.get(e.attr('href'),function(r){
                    var score = r.score ; 
                
                    $('.rank a').removeClass('active').each(function(c,e){
                        if ((c+1)<=score) {
                            $(e).addClass('active');
                        }
                    });
                
                    // e.parents('li.reportProfile').remove();
                   
                });
            });
                
                
            return false ;
        });
    </script>
</cake:script>
