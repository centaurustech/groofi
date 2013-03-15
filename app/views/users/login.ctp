

<?

    if (!$status) {
        if (FacebookInfo::getConfig('appId')) {
            echo $this->Html->meta(array('property' => 'fb:app_id', 'content' => FacebookInfo::getConfig('appId'))) . "\r\n";
            if (isset($facebook_info)) {
                foreach ($facebook_info as $name => $content) {
                    echo $this->Html->meta(array('property' => $name, 'content' => $content)) . "\r\n";
                }
            }
            echo $this->Facebook->init();
        }

        echo $this->element('common/page_title', array(
            'pageTitle' => __('LOGIN_TITLE', true),
            'pageSubTitle' => __('LOGIN_SUBTITLE', true),
            'tag' => 'h2'
            )
        );
?>
<div class="common-login" style="width: 48%;float : left ; margin-top: 20px ;background: #FFFFFF;  ">
<?
        if ($error) {
            echo $this->Html->div('error-message', __('LOGIN_ERROR', true));
       
        }
        echo $this->Form->create('User', array('url' => DS . $this->params['url']['url'], 'id' => 'userLoginForm'));
        echo $this->Form->input('User.email');
        echo $this->Form->input('User.password');
        echo $this->Form->submit(__('LOGIN', true));
        echo $this->Form->end();
?>
</div>

<div class="facebook-login" style="width: 48%; height :182px ; float : right ;margin-top: 20px ; padding: 20px ; background: #D5E7F0 ">
<?

?>
<?
        echo $this->Facebook->login(
            array(
                'perms' => FacebookInfo::getConfig('perms.common'),
                'label' => __('LOGIN_USING_FACEBOOK', true)
            )
        );

        echo $this->element('common/message_box', array(
            'title' => __('FACEBOOK_MESSAGE_TITLE', true),
            'message' => __('FACEBOOK_MESSAGE_MESSAGE', true),
            'icon' => 'privacy'
            )
        );
?>
</div>


        <script type="text/javascript">
            $('#userLoginForm').submit(function(){
                $.post( $(this).attr('action') , $(this).serialize() , function(data){
                    $('#userLoginForm').parents('.ajax.login.form').html(data);
                });
                return false ;
            });
        </script>
<? } else {
?>
        <script type="text/javascript">
            Auth.process(<?= $this->params['named']['f'] ?>);
        </script>
<? } ?>