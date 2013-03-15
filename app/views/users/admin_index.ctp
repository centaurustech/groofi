<?
echo $this->element('paginator/common');
echo $this->element('paginator/filters');
?>



<?
if (!empty($this->data['results'])) {
    echo $this->element('paginator/common', array('module' => 'legend', 'extraClass' => 'top'));
    echo $this->element('paginator/common', array('module' => 'paginator', 'extraClass' => 'top'));
    ?>


    <table cellpadding="0" cellspacing="0">
        <tr>


            <th><?php echo $this->Paginator->sort('User.id'); ?></th>
            <th><?php echo $this->Paginator->sort('User.display_name'); ?></th>
            <th><?php echo $this->Paginator->sort('User.email'); ?></th>
            <th><?php echo $this->Paginator->sort('User.created'); ?></th>
            <th><?php echo $this->Paginator->sort('User.score'); ?></th>
            <th><?php echo $this->Paginator->sort('User.report_count'); ?></th>





            <th><?php __('User.flags'); ?></th>
            <th class="actions"><?php __('Actions'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($this->data['results'] as $result):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>



                <td colspan="6" class="info">
                    <?= $this->element('users/admin/user_info', array('result' => $result)); ?>
                </td>


                <td class="flags">
                    <?
                    echo $this->Form->input("User.{$result['User']['id']}.active", array('label' => 'ENABLED_USER', 'type' => 'checkbox', 'checked' => ( $result['User']['active'] ? true : false )));
                    ?> 
                </td>


                <td class="actions">
                    <?php if ($result['User']['report_count'] > 0) { ?>
                        <?php echo $this->Html->link(__('RESET_REPORTS', true), array('controller' => 'reports', 'action' => 'delete', $this->name, $result['User']['id']), array('class' => 'auto-process confirm ajax remove')); ?>
                    <?php } ?>



                    <?php
                    if ($result['User']['confirmed'] == 0 && !(empty($result['Notification']))) {

                        $notification_id = array_shift(Set::extract('/Notification/id', $result));

                        echo $this->Html->link(__('RESEND_ACTIVATION', true), array('controller' => 'mails', 'action' => 'email', $notification_id), array('class' => 'auto-process ajax remove'));
                    }
                    ?>



                    <?php echo $this->Html->link(__('VIEW', true), User::getLink($result), array('target' => '_blank')); ?>


                    <?php if ($result['User']['admin'] == 1) { ?>
                        <?php echo $this->Html->link(__('EDIT', true), array('action' => 'edit', $result['User']['id'])); ?>
                    <?php } ?>
                </td>


            </tr>
        <?php endforeach; ?>
    </table>


    <?
    echo $this->element('paginator/common', array('module' => 'legend', 'extraClass' => 'bottom'));
    echo $this->element('paginator/common', array('module' => 'paginator', 'extraClass' => 'bottom'));
    ?>
<? } else { ?>

    <p class="alert-message info"><?= __('NO_RESULTS_FOUND', true) ?></p>
<? } ?>



<cake:script>

    <script type="text/javascript">
        $('.flags input[type=checkbox]').change(function(){
            var e = $(this).attr('disabled',true) ;
            data = {} ;
            data[e.attr('name')] = e.attr('checked') ? 1 : 0 ;
            $.post('/admin/users/flag', data ,function(response){
                e.attr('disabled',false);
            });
        });
        
    </script>
</cake:script>