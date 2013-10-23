
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

<style>
    @media (max-width: 1600px) and (min-width: 1441px){
        .datos_right{
            float: right;
            list-style: none outside none !important;
            margin-left: 0 !important;
            position: relative;
            width: 172px;
        }
        .datos_right1{
            float: right;
            list-style: none outside none !important;
            margin-left: 0 !important;
            width: 128px;

        }
        .actions_1{
            float: left;
            min-height: 87px;
        }
        .flags{
            float: left;
            min-height: 87px;
        }
        .flags .checkbox{
            display: block;
            float: left;
            overflow: hidden;
            text-align: left;
            width: 110px;
        }

        td.actions a.ui-button {
            display: block;
            margin: 5px 0;
            padding: 4px 7px;
            width: 185px;
        }
        .datos_users_email{
            margin-right: 0px!important;

        }

        .padre_user_subtitulos {
            float: left;
            height: 50px;
            margin-left: 0px;
            width: 1215px;
        }

        .datos_users_options{


        }
        .datos_users_actions{

        }


    }

    @media (max-width: 1920px) and (min-width: 1601px)  {


        .actions_1{
            float: left;
            min-height: 87px;
        }
        .flags{
            float: left;
            min-height: 87px;
        }
        .flags .checkbox{
            display: block;
            float: left;
            overflow: hidden;
            text-align: left;
            width: 110px;
        }

        td.actions a.ui-button {
            display: block;
            margin: 5px 0;
            padding: 4px 7px;
            width: 185px;
        }
        .datos_users_email{
            margin-right: 0px!important;

        }

        .padre_user_subtitulos {
            float: left;
            height: 50px;
            margin-left: 0px;
            width: 1210px;
        }
        .datos_right{
            float: right;
            list-style: none outside none !important;
            margin-left: 0 !important;
            position: relative;
            width: 172px;
        }
        .datos_right1{
            float: right;
            list-style: none outside none !important;
            margin-left: 0 !important;
            width: 195px;

        }
        .datos_users_options{


        }
        .datos_users_actions{

        }

    }
    @media (max-width: 1440px) and (min-width: 1361px) {


        #obj1{
            margin-left: 57px\9!important;
        }
        #main {
            overflow: hidden;
            padding-bottom: 30px;
        }
        .padre_user_subtitulos {
            height: 50px;
            margin-left: -75px;
            width: 1015px;
            float: left;
        }

        .user_subtitulos{
            font-size: 9px;
            margin-left:50px ;
            width: auto;
        }
        td.actions a.ui-button {
            display: block;
            margin: 5px 0;
            padding: 4px 7px;
            width: 100px;
        }

        table {
            background: none repeat scroll 0 0 #FFFFFF;
            border-right: 0 none;
            clear: both;
            font-size: 9px;
            margin-bottom: 10px;
            width: 100%;
        }

        td.actions a.ui-button {
            display: block;
            font-size: 9px;
            margin: 5px 0;
            padding: 4px 7px;
            width: 100px;
        }

        .propiedades_users_admin {
            display: block;
            margin-left: 0px!important;
        }

        .propiedades_users_admin span {
            display: block;
            float: left;
            margin-left: 25px;
            overflow: hidden;
            text-align: left;
            width: 75px;
        }
        .datos_users_id{
            width: 35px!important;

        }
        .datos_users_name{
            width: 110px!important;
            overflow: hidden;

        }
        .datos_users_mail{
            width: 110px!important;
            overflow: hidden;

        }
        .datos_users_registro{
            width: 140px !important;
            overflow: hidden;
        }
        .datos_users_denunce{
            margin-right: 175px !important;
        }
        .datos_users_options{
            margin-right: 38px !important;
        }
        .datos_right{
            float: right;
            list-style: none outside none !important;
            margin-left: 0 !important;
            position: relative;
            width: 140px;
        }
        .datos_right1{
            float: right;
            list-style: none outside none !important;
            margin-left: 0 !important;
            width: 130px;

        }
    }
    @media (max-width: 1360px) and (min-width: 1280px) {
        #obj1{
            margin-left: 57px\9!important;
        }
        #main {
            overflow: hidden;
            padding-bottom: 30px;
        }
        .padre_user_subtitulos {
            height: 50px;
            margin-left: -72px;
            width: 1015px;
            float: left;
        }

        .user_subtitulos{
            font-size: 9px;
            margin-left:50px ;
            width: auto;
        }
        td.actions a.ui-button {
            display: block;
            margin: 5px 0;
            padding: 4px 7px;
            width: 100px;
        }

        table {
            background: none repeat scroll 0 0 #FFFFFF;
            border-right: 0 none;
            clear: both;
            font-size: 9px;
            margin-bottom: 10px;
            width: 100%;
        }

        td.actions a.ui-button {
            display: block;
            font-size: 9px;
            margin: 5px 0;
            padding: 4px 7px;
            width: 100px;
        }

        .propiedades_users_admin {
            display: block;
            margin-left: 0px!important;
        }

        .propiedades_users_admin span {
            display: block;
            float: left;
            margin-left: 25px;
            overflow: hidden;
            text-align: left;
            width: 75px;
        }
        .datos_users_id{
            width: 35px!important;

        }
        .datos_users_name{
            width: 110px!important;
            overflow: hidden;

        }
        .datos_users_mail{
            width: 110px!important;
            overflow: hidden;

        }
        .datos_users_registro{
            width: 140px !important;
            overflow: hidden;
        }
        .datos_users_denunce{
            margin-right: 175px !important;
        }
        .datos_users_options{
            margin-right: 38px !important;
        }
        .datos_right{
            float: right;
            list-style: none outside none !important;
            margin-left: 0 !important;
            position: relative;
            width: 130px;
        }
        .datos_right1{
            float: right;
            list-style: none outside none !important;
            margin-left: 0 !important;
            width: 115px;

        }

    }
    .info {

    }

</style>
<script type="text/javascript" src="/js/css3-mediaqueries.js"></script>

    <table cellpadding="0" cellspacing="0">
        <tr>

            <ul class="padre_user_subtitulos padre_user_subtitulos_ie">
            <li class="user_subtitulos user_subtitulos_ie_id"><?php echo $this->Paginator->sort('User.id'); ?></li>
            <li class="user_subtitulos user_subtitulos_ie_name"><?php echo $this->Paginator->sort('User.display_name'); ?></li>
            <li class="user_subtitulos datos_users_email" style="margin-right: 50px"><?php echo $this->Paginator->sort('User.email'); ?></li>
            <li class="user_subtitulos user_subtitulos_ie_created"><?php echo $this->Paginator->sort('User.created'); ?></li>
            <li class="user_subtitulos user_subtitulos_ie_score"><?php echo $this->Paginator->sort('User.score'); ?></li>
            <li class="user_subtitulos datos_users_denunce"><?php echo $this->Paginator->sort('User.report_count'); ?></li>

            </ul>
            <ul class="datos_right1">
                <li class="datos_users_actions"><?php __('Actions'); ?></li>
            </ul>
            <ul class="datos_right">
              <li class="datos_users_options"><?php __('User.flags'); ?></li>
            </ul>

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
                        <span class="datos_users_id"><?= $result['User']['id'];?></span>
                        <span class="datos_users_name"><?= $result['User']['display_name'];?></span>
                        <span class="datos_users_mail"><?= $result['User']['email'];?></span>
                        <span class="datos_users_registro"><?= $result['User']['created'];?></span>
                        <span class="datos_users_score"><?= $result['User']['score'];?></span>
                        <span class="datos_users_count"><?= $result['User']['report_count'];?></span>


                    </div>
                </td>


                <td class="flags">
                    <?
                    echo $this->Form->input("User.{$result['User']['id']}.active", array('label' => 'ENABLED_USER', 'type' => 'checkbox','checked' => ( $result['User']['active'] ? true : false )));
                    ?>
                </td>


                <td class="actions actions_1">
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
    <script>
        $(document).ready(function(){
                    var obj1 = $('.padre_user_subtitulos_ie').children().get(0);
                    obj1.setAttribute("style","margin-left:180px");
                    obj1.setAttribute("id","obj1");

                }
        )
    </script>

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