<div class="staticpages index">
	<h2><?php __('Staticpages');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('section');?></th>
			<th><?php echo $this->Paginator->sort('slug');?></th>
			<th><?php echo $this->Paginator->sort('subtitle');?></th>
			<th><?php echo $this->Paginator->sort('content');?></th>
			<th><?php echo $this->Paginator->sort('template');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($staticpages as $staticpage):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $staticpage['Staticpage']['id']; ?>&nbsp;</td>
		<td><?php echo $staticpage['Staticpage']['title']; ?>&nbsp;</td>
		<td><?php echo $staticpage['Staticpage']['section']; ?>&nbsp;</td>
		<td><?php echo $staticpage['Staticpage']['slug']; ?>&nbsp;</td>
		<td><?php echo $staticpage['Staticpage']['subtitle']; ?>&nbsp;</td>
		<td><?php echo $staticpage['Staticpage']['content']; ?>&nbsp;</td>
		<td><?php echo $staticpage['Staticpage']['template']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $staticpage['Staticpage']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $staticpage['Staticpage']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $staticpage['Staticpage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $staticpage['Staticpage']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Staticpage', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Links', true), array('controller' => 'links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link', true), array('controller' => 'links', 'action' => 'add')); ?> </li>
	</ul>
</div>