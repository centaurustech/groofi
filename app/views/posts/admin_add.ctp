<div class="posts form">
<?php echo $this->Form->create('Post');?>
	<fieldset>
 		<legend><?php __('Admin Add Post'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('title');
		echo $this->Form->input('slug');
		echo $this->Form->input('short_description');
		echo $this->Form->input('description');
		echo $this->Form->input('video_url');
		echo $this->Form->input('old_information');
		echo $this->Form->input('dirname');
		echo $this->Form->input('basename');
		echo $this->Form->input('published');
		echo $this->Form->input('public');
		echo $this->Form->input('enabled');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Posts', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Projects', true), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project', true), array('controller' => 'projects', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Offers', true), array('controller' => 'offers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Offer', true), array('controller' => 'offers', 'action' => 'add')); ?> </li>
	</ul>
</div>