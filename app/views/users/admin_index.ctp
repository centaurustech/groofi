<?
//echo 'asdasdasdasdasdasdasdadas'.$_SESSION['idioma'];

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

            <div class="padre_user_subtitulos">
            <li class="user_subtitulos"><?php echo $this->Paginator->sort('User.id'); ?></li>
            <li class="user_subtitulos"><?php echo $this->Paginator->sort('User.display_name'); ?></li>
            <li class="user_subtitulos"><?php echo $this->Paginator->sort('User.email'); ?></li>
            <li class="user_subtitulos"><?php echo $this->Paginator->sort('User.created'); ?></li>
            <li class="user_subtitulos"><?php echo $this->Paginator->sort('User.score'); ?></li>
            <li class="user_subtitulos"><?php echo $this->Paginator->sort('User.report_count'); ?></li>
            <li class="user_subtitulos" style="margin-left: 275px; color: #555555; font-size: 12px;font-weight: bold;list-style: none outside none;right: 13px;text-transform: uppercase"><?php __('User.flags'); ?></li>
            <li class="actions user_subtitulos" style="color: #555555; font-size: 12px;font-weight: bold;list-style: none outside none;right: 13px;text-transform: uppercase"><?php __('Actions'); ?></li>
            </div>
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
                    <!--?= $this->element('users/admin/user_info', array('result' => $result)); ?-->
                    <!--?= $result['Project']['id'];?-->
                    <div class="propiedades_users_admin">
                        <div class="thumb">
                            <?if ( $result['User']['dirname'] == true) {?>
                            <? $imagen_extension = explode('.',$result['User']['basename'])?>
                            <img style="display: block" src="/media/filter/s64/<?= $result['User']['dirname'].'/'.$imagen_extension[0].'.png';?>" width="64" height="64">
                            <?}else{?>

                            <img style="display: block" src="/img/assets/img_default_64px.png" width="64" height="64">
                            <?}?>
                        </div>
                        <span><?= $result['User']['id'];?></span>
                        <span><?= $result['User']['display_name'];?></span>
                        <span><?= $result['User']['email'];?></span>
                        <span><?= $result['User']['created'];?></span>
                        <span><?= $result['User']['score'];?></span>
                        <span><?= $result['User']['report_count'];?></span>


                    </div>
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

                        //echo $this->Html->link(__('RESEND_ACTIVATION', true), array('controller' => 'mails', 'action' => 'email', $notification_id), array('class' => 'auto-process ajax remove'));
                    echo '<a class="auto-process ajax remove ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" href="/mails/email/'.$notification_id.'">Re-enviar mail de activación</a>';
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