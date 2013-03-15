<?php /* @var $this ViewCC */ ?>
<? $this->set('pageTitle', false); ?>

<? // vd($this->params['url']['url']); ?>


<div class="col col-3 login form" id="loginForm" style="display:<?= ( $this->params['url']['url'] != 'forgotPassword' ? 'block' : 'none') ?>"> <? // Do not show login errors on fields   ?>
    <?
    echo $this->element('common/page_title', array(
        'pageTitle' => __('LOGIN_TITLE', true),
        'pageSubTitle' => __('LOGIN_SUBTITLE', true),
        'tag' => 'h2'
            )
    );

    if ($this->params['url']['url'] != 'login') {
        $opt['error'] = false;
        $opt['value'] = false;
    } else {
        $opt = array();
    }

    echo $this->Form->create('User', array('url' => '/login'));

    if (isset($error) && $error === true) {

        echo $this->Html->div('error-message', __('INVALID_LOGIN_INFORMATION', true));
    }
	//echo '<input name="data[panino]" type="text" value="1" />';
    echo $this->Form->input('User.email', $opt);

    echo $this->Form->input('User.password', $opt);

    echo $this->Form->submit(__('LOGIN', true), array(
        'after' => $this->Form->button(__('FORGOT_PASSWORD', true), array(
            'id' => 'forgotPasswordBtn',
            'type' => 'button'
                )
        )
            )
    );
    echo $this->Form->end();
    ?>
</div>

<div class="col col-3 forgot-passwprd form" id="forgotPassword" style="display:<?= ( $this->params['url']['url'] == 'forgotPassword' ? 'block' : 'none') ?>"> <? // Do not show login errors on fields   ?>
    <?
    echo $this->element('common/page_title', array(
        'pageTitle' => __('FORGOT_PASSWORD_TITLE', true),
        'pageSubTitle' => __('FORGOT_PASSWORD_SUBTITLE', true),
        'tag' => 'h2'
            )
    );

    if ($this->params['url']['url'] != 'forgotPassword') {
        $opt['error'] = false;
        $opt['value'] = false;
    } else {
        $opt = array();
    }

    echo $this->Form->create('User', array('url' => '/forgotPassword'));

    if (isset($error) && $error === true) {

        echo $this->Html->div('error-message', __('INVALID_INFORMATION', true));
    }

    echo $this->Form->input('User.email', $opt);


    echo $this->Form->submit(__('RECOVER_PASSWORD', true), array('after' => $this->Form->button(__('CANCEL', true), array(
            'id' => 'loginBtn',
            'type' => 'button'
        ))));

    echo $this->Form->end();
    ?>
</div>



<div class="col col-3 register form" id="registerForm" >
<?
echo $this->element('common/page_title', array(
    'pageTitle' => __('REGISTER_TITLE', true),
    'pageSubTitle' => __('REGISTER_SUBTITLE', true),
    'tag' => 'h2'
        )
);

if ($this->params['url']['url'] != 'signup') {
    $opt['error'] = false;
    $opt['value'] = false;
} else {
    $opt = array();
}

echo $this->Form->create('User', array('url' => '/signup'));
echo $this->Form->input('User.facebook_id', am($opt, array('type' => 'hidden')));
echo $this->Form->input('User.display_name', $opt);
echo $this->Form->input('User.email', $opt); // if facebook account it's active, mail addres must be facebook email.
echo $this->Form->input('User.password', $opt);
echo $this->Form->input('User.password_confirmation', am($opt, array('type' => 'password')));

if ($this->Session->read('FB')) {
    echo $this->Form->input('User.slug');
    echo $this->Form->autoComplete('User.city', array(
        'url' => '/services/cities/query.php'
            ), array(
        'after' => $this->Form->error('location_id')
        , 'label' => 'USER_LOCATION_LABEL'
            )
    );
}


    echo $this->Html->div('terms-of-user', sprintf(__('TERMS_OF_USER_BODY %s',true), $this->Html->link(__('TERMS_OF_USE_LINK', true), '/page/terminos-de-uso')));

echo $this->Form->submit(__('REGISTER_ME', true));
echo $this->Form->end();
?>
</div>

<div class="col col-3 right facebook form" id="facebookForm" >

  <?
    echo $this->element('common/page_title', array(
        'pageTitle' => __('FACEBOOK_LOGIN_TITLE', true),
        'pageSubTitle' => __('FACEBOOK_LOGIN_SUBTITLE', true),
        'tag' => 'h2'
            )
    );
    ?>
    <div class="dummyform">
    <div class="padding">
    <?
    echo $this->Facebook->login(
            array(
                'perms' => FacebookInfo::getConfig('perms.common'),
                'label' => __('LOGIN_USING_FACEBOOK', true)
            )
    );
//	echo 'hola'.debug($facebookUser).'hola';
    echo $this->element('common/message_box', array(
        'title' => __('FACEBOOK_MESSAGE_TITLE', true),
        'message' => __('FACEBOOK_MESSAGE_MESSAGE', true),
        'icon' => 'privacy'
            )
    );

    ?>
    </div>
    </div>
</div>

<cake:script>
    <script type="text/javascript">

        $('#forgotPasswordBtn').click(function(){
            $('#loginForm').hide();
            $('#forgotPassword').show();
        });
        $('#loginBtn').click(function(){
            $('#forgotPassword').hide();
            $('#loginForm').show();
        });
    </script>
</cake:script>