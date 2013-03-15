<div class="staticpages view">
<h2><?php  __('Staticpage');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $staticpage['Staticpage']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $staticpage['Staticpage']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $staticpage['Staticpage']['section']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Slug'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $staticpage['Staticpage']['slug']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sub Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $staticpage['Staticpage']['subtitle']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Content'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $staticpage['Staticpage']['content']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Template'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $staticpage['Staticpage']['template']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Staticpage', true), array('action' => 'edit', $staticpage['Staticpage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Staticpage', true), array('action' => 'delete', $staticpage['Staticpage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $staticpage['Staticpage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Staticpages', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Staticpage', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Links', true), array('controller' => 'links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link', true), array('controller' => 'links', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Links');?></h3>
	<?php if (!empty($staticpage['Link'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Model'); ?></th>
		<th><?php __('Model Id'); ?></th>
		<th><?php __('Link'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Media Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($staticpage['Link'] as $link):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $link['id'];?></td>
			<td><?php echo $link['model'];?></td>
			<td><?php echo $link['model_id'];?></td>
			<td><?php echo $link['link'];?></td>
			<td><?php echo $link['title'];?></td>
			<td><?php echo $link['description'];?></td>
			<td><?php echo $link['media_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'links', 'action' => 'view', $link['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'links', 'action' => 'edit', $link['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'links', 'action' => 'delete', $link['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $link['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Link', true), array('controller' => 'links', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
