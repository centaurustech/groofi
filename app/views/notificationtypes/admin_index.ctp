<div class="notificationtypes index">
    <h2><?php __('Notificationtypes'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('user_feed'); ?></th>
            <th><?php echo $this->Paginator->sort('activity_feed'); ?></th>
            <th><?php echo $this->Paginator->sort('notification'); ?></th>
            <th><?php echo $this->Paginator->sort('email'); ?></th>
            <th><?php echo $this->Paginator->sort('disableable'); ?></th>
            <th class="actions"><?php __('Actions'); ?></th>
        </tr>
        <?php
            $i=0;
            foreach ($notificationtypes as $notificationtype):
                $class=null;
                if ($i++ % 2 == 0) {
                    $class=' class="altrow"';
                }
        ?>
                <tr<?php echo $class; ?>>
                    <td><?php echo $notificationtype['Notificationtype']['id']; ?>&nbsp;</td>
                    <td><?php echo $notificationtype['Notificationtype']['name']; ?>&nbsp;<br /><?php echo $notificationtype['Notificationtype']['description']; ?></td>


        
                    <td class="center"><?= $this->element('common/enabled_disabled', array('status' => $notificationtype['Notificationtype']['user_feed'])) ?></td>
                    <td class="center"><?= $this->element('common/enabled_disabled', array('status' => $notificationtype['Notificationtype']['activity_feed'])) ?></td>
                    <td class="center"><?= $this->element('common/enabled_disabled', array('status' => $notificationtype['Notificationtype']['notification'])) ?></td>
                    <td class="center"><?= $this->element('common/enabled_disabled', array('status' => $notificationtype['Notificationtype']['email'])) ?></td>
                    <td class="center"><?= $this->element('common/enabled_disabled', array('status' => $notificationtype['Notificationtype']['disableable'])) ?></td>

                    <td class="actions">
                <?php echo $this->Html->link(__('View', true), array('action' => 'view', $notificationtype['Notificationtype']['id'])); ?>
                <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $notificationtype['Notificationtype']['id'])); ?>
                <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $notificationtype['Notificationtype']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $notificationtype['Notificationtype']['id'])); ?>
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
        <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')); ?>
                                                	 | 	<?php echo $this->Paginator->numbers(); ?>
                    |
        <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
                </div>
            </div>
            <div class="actions">
                <h3><?php __('Actions'); ?></h3>
                <ul>
                    <li><?php echo $this->Html->link(__('New Notificationtype', true), array('action' => 'add')); ?></li>
                    <li><?php echo $this->Html->link(__('List Notifications', true), array('controller' => 'notifications', 'action' => 'index')); ?> </li>
                    <li><?php echo $this->Html->link(__('New Notification', true), array('controller' => 'notifications', 'action' => 'add')); ?> </li>
    </ul>
</div>