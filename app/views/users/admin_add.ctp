<?php /* @var $this ViewCC */ ?>

<?

echo $this->Form->create('User');

echo $this->Form->input('User.username');

echo $this->Form->input('User.email');
echo $this->Form->input('User.password');
echo $this->Form->input('User.password_confirmation',array('type'=>'password')) ;
echo $this->Form->input('User.level',array('type'=>'hidden' , 'value' => USER_LEVEL_ADMIN )) ;

echo $this->Form->submit(__('SAVE', true));
echo $this->Form->end();
?>