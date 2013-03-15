<div class="notificationtypes form">
<?php echo $this->Form->create('Notificationtype');?>
	<fieldset>
		<legend><?php __('Add Notificationtype'); ?></legend>
	<?php
		echo $this->Form->input('model');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('notification');
		echo $this->Form->input('email');
		echo $this->Form->input('disableable');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Notificationtypes', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Notifications', true), array('controller' => 'notifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Notification', true), array('controller' => 'notifications', 'action' => 'add')); ?> </li>
	</ul>
</div>