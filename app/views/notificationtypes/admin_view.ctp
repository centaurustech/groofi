<div class="notificationtypes view">
<h2><?php  __('Notificationtype');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $notificationtype['Notificationtype']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Model'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $notificationtype['Notificationtype']['model']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $notificationtype['Notificationtype']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $notificationtype['Notificationtype']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notification'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $notificationtype['Notificationtype']['notification']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $notificationtype['Notificationtype']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Disableable'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $notificationtype['Notificationtype']['disableable']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Notificationtype', true), array('action' => 'edit', $notificationtype['Notificationtype']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Notificationtype', true), array('action' => 'delete', $notificationtype['Notificationtype']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $notificationtype['Notificationtype']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Notificationtypes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Notificationtype', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Notifications', true), array('controller' => 'notifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Notification', true), array('controller' => 'notifications', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Notifications');?></h3>
	<?php if (!empty($notificationtype['Notification'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Notificationtype Id'); ?></th>
		<th><?php __('Model'); ?></th>
		<th><?php __('Model Id'); ?></th>
		<th><?php __('Text'); ?></th>
		<th><?php __('Template'); ?></th>
		<th><?php __('Data'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($notificationtype['Notification'] as $notification):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $notification['id'];?></td>
			<td><?php echo $notification['created'];?></td>
			<td><?php echo $notification['modified'];?></td>
			<td><?php echo $notification['notificationtype_id'];?></td>
			<td><?php echo $notification['model'];?></td>
			<td><?php echo $notification['model_id'];?></td>
			<td><?php echo $notification['text'];?></td>
			<td><?php echo $notification['template'];?></td>
			<td><?php echo $notification['data'];?></td>
			<td><?php echo $notification['user_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'notifications', 'action' => 'view', $notification['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'notifications', 'action' => 'edit', $notification['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'notifications', 'action' => 'delete', $notification['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $notification['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Notification', true), array('controller' => 'notifications', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
