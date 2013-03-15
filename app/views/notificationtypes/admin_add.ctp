<div class="notificationtypes form">
    <?php echo $this->Form->create('Notificationtype'); ?>
        <fieldset>
            <legend><?php __('Admin Add Notificationtype'); ?></legend>
        <?php
            echo $this->Form->input('model');

            echo $this->Form->input('name');
            echo $this->Form->input('description');



            echo $this->Form->input('user_feed', array('type' => 'checkbox', 'label' => __('SHOW_AS_OWN_ACTIVITY', true)));
            echo $this->Form->input('activity_feed', array('type' => 'checkbox', 'label' => __('SHOW_AS_USER_ACTIVITY', true)));
            echo $this->Form->input('notification', array('type' => 'checkbox', 'label' => __('SHOW_AS_MESSAGE', true)));
            echo $this->Form->input('email', array('type' => 'checkbox', 'label' => __('SEND_AN_EMAIL', true)));
            echo $this->Form->input('disableable', array('type' => 'checkbox', 'label' => __('CAN_BE_DISABLED?', true)));
        ?>
        </fieldset>
    <?php echo $this->Form->end(__('Submit', true)); ?>
        </div>
        <div class="actions">
            <h3><?php __('Actions'); ?></h3>
            <ul>

                <li><?php echo $this->Html->link(__('List Notificationtypes', true), array('action' => 'index')); ?></li>
                <li><?php echo $this->Html->link(__('List Notifications', true), array('controller' => 'notifications', 'action' => 'index')); ?> </li>
                <li><?php echo $this->Html->link(__('New Notification', true), array('controller' => 'notifications', 'action' => 'add')); ?> </li>
    </ul>
</div>