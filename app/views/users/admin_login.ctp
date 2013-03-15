<div class="common-login round">
<?
        if ($error) {
            echo $this->Html->div('error-message', __('LOGIN_ERROR', true));
        }
        echo $this->Form->create('User', array('url' => '', 'id' => 'userLoginForm'));
        echo $this->Form->input('User.username', array('label' => __('LOGIN_USER__USERNAME', true)));
        echo $this->Form->input('User.password');
        echo $this->Form->submit(__('LOGIN', true));
        echo $this->Form->end();
?>
</div>