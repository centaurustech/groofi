
<div class="staticpages form">
<?php echo $this->Form->create('Staticpage');?>
	<fieldset>
		<legend><?php __('Add Staticpage'); ?></legend>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('section');
		echo $this->Form->input('slug');
		echo $this->Form->input('subtitle');
		echo $this->Form->input('content');
		echo $this->Form->input('template');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Staticpages', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Links', true), array('controller' => 'links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link', true), array('controller' => 'links', 'action' => 'add')); ?> </li>
	</ul>
</div>