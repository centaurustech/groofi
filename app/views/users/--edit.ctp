<?php /* @var $this ViewCC */ ?>

<?
    $this->set('titleClass', 'tabs');
    $this->set('pageTitle', __(up(sprintf('USER_EDIT_%s', $this->params['tab'])), true));
    $this->set('pageSubTitle', sprintf(__('OF %s', true), $this->Html->link(User::getName($this->data), User::getLink($this->data, null, false))));
?>

<ul class="pageElement tabs">
        <li class="<?= (low($this->params['tab']) == 'profile' ? 'active' : ''); ?>"><?= $this->Html->link(__('profile', true), array('controller' => 'users', 'action' => 'edit', 'tab' => 'profile',)); ?></li>
        <li class="<?= (low($this->params['tab']) == 'account' ? 'active' : ''); ?>"><?= $this->Html->link(__('account', true), array('controller' => 'users', 'action' => 'edit', 'tab' => 'account',)); ?></li>
</ul>

<?
    echo $this->Form->create('User', array('type' => 'file', 'url' => '/settings/' . low($this->params['tab'])));

    echo $this->Form->input('User.id');
?>


<div class="form col col-1 underline user-form user-form-profile" style="<?= (low($this->params['tab']) == 'profile' ? '' : 'display:none;'); ?>">
    <?php
        echo $this->element('common/page_title', array(
            'pageTitle' => __('MY_PROFILE_EDIT_PROFILE_TITLE', true),
            'pageSubTitle' => __('MY_PROFILE_EDIT_PROFILE_SUBTITLE', true),
            'tag' => 'h2'
            )
        );
    ?>

        <div class="col col-2">
        <?
            if ($this->Session->read('FB') && !$facebook_update) {
                 echo $this->element('common/message_box', array(
                    'title' => __('YOUR_PROFILE_INFO_IS_INCOMPLETE_TITLE', true),
                    'message' => sprintf(
                        __('YOUR_PROFILE_INFO_IS_INCOMPLETE_MESSAGE %s', true),
                        $this->Html->link(__('UPDATE_INCOMPLETE_INFO_LINK_TITLE', true),
                            Router::url(
                                array(
                                    'controller' => 'users',
                                    'action' => 'edit',
                                    'tab' => 'profile',
                                    'update' => true
                                )
                            )
                        )
                    ),
                    'icon' => 'facebook-quest'
                    )
                );
            }


            echo $this->Form->input('User.display_name');
            echo $this->Form->input('User.biography');
            echo $this->Form->input('User.birthday', array(
                'dateFormat' => 'DMY',
                'empty' => '-',
                'separator' => false,
                'maxYear' => date('Y', strtotime('-18 years')),
                'minYear' => date('Y', strtotime('-100 years'))
            ));
            echo $this->Form->input('User.gender');
            echo $this->Form->input('User.timezone');



            echo $this->Form->autoComplete('User.city', array(
                'url' => '/services/cities/query.php'
                ), array(
                'after' => $this->Form->error('location_id')
                , 'label' => 'USER_LOCATION_LABEL'
                )
            );
        ?>
        </div>



        <div class="col col-2">
        <?
            $username=$this->Form->value('User.slug');
            if ($facebook_update && empty($username)) {
                echo $this->Form->input('User.slug', array('value' => $this->Form->value('User.fb_username')));
            } elseif (empty($username)) {
                echo $this->Form->input('User.slug');
            } elseif (!empty($username)) {
                ?><div class="input text"><?
                echo $this->Form->label('User.slug');
                echo $this->Html->div('fakeField' , User::getLink($this->data, null, true));
                ?></div><?
            }



            echo $this->element('form/url', array('elements' => 10, 'helpMessage' => false  ,  'assocAlias' => 'Link'));
            echo $this->Form->submit(__('USER__PROFILE_SAVE', true));
        ?>
        </div>

</div>




<div class="form col col-3 underline right user-form user-form-profile" style="<?= (low($this->params['tab']) == 'profile' ? '' : 'display:none;'); ?>">
    <?php
            echo $this->element('common/page_title', array(
                'pageTitle' => __('MY_PHOTO_EDIT_PROFILE_TITLE', true),
                'pageSubTitle' => __('MY_PHOTO_EDIT_PROFILE_SUBTITLE', true),
                'tag' => 'h2'
                )
            );
    ?>
            <div class="padding" style="padding:20px 0px;">
        <?
            if ($facebook_update) {

                echo $this->Form->input('User.basename', array('type' => 'hidden'));
                echo $this->Form->input('User.dirname', array('type' => 'hidden'));
            }


            $file=$this->Media->file('m200/' . $this->data['User']['avatar_file']);
            $file=$this->Media->embed($file);
            $file=( empty($file) ? $this->Html->image('/img/assets/img_default_200px.png') : $file ) . $this->Form->input('User.avatar_file', array('type' => 'hidden'));
            echo $form->input('file', array('type' => 'file', 'label' => false, 'accept' => 'image/jpge , image/jpg , image/gif , image/png', 'before' => $file));
        ?>
        </div>
</div>


<div style="clear:both;width:100%;height:0px;">&nbsp;</div>


<div class="form  col col-3 user-form user-form-account user-form-account-notifications " style="<?= (low($this->params['tab']) == 'account' ? '' : 'display:none;'); ?>">
    <?php
            echo $this->element('common/page_title', array(
                'pageTitle' => __('NOTIFICATIONS_EDIT_PROFILE_TITLE', true),
                'pageSubTitle' => __('NOTIFICATIONS_EDIT_PROFILE_SUBTITLE', true),
                'tag' => 'h2'
                )
            );
    ?>
            <div class="padding">
        <?
            echo $this->Form->input('Notificationtype', array('options' => $notifications, 'multiple' => 'checkbox'));


            echo $this->Form->submit(__('SAVE', true));
        ?>
        </div>
</div>

<div class="form  col col-3 user-form user-form-account user-form-account-facebook " style="<?= (low($this->params['tab']) == 'account' ? '' : 'display:none;'); ?>">

    <?php
            echo $this->element('common/page_title', array(
                'pageTitle' => __('FACEBOOK_EDIT_PROFILE_TITLE', true),
                'pageSubTitle' => __('FACEBOOK_EDIT_PROFILE_SUBTITLE', true),
                'tag' => 'h2'
                )
            );
    ?>
            <div class="padding">
        <?php
            if (!$this->Session->read('FB')) {
                echo $this->Facebook->login(array('label' => __('FACEBOOK_CONNECT_APP', true), 'perms' => FacebookInfo::getConfig('perms.common')));
                echo $this->element('common/message_box', array(
                    'title' => __('FACEBOOK_MESSAGE_TITLE', true),
                    'message' => __('FACEBOOK_MESSAGE_MESSAGE', true),
                    'icon' => 'privacy'
                    )
                );
            } else {
                echo sprintf(__('FACEBOOK_CONNECTED_APP %s', true),
                    $this->Facebook->disconnect(
                        array(
                            'label' => __('FACEBOOK_DISCONNECT_APP', true),
                            'confirm' => __('FACEBOOK_DISCONNECT_APP_CONFIRM', true),
                        )
                    )
                );
            }
        ?>

        </div>
</div>
<!-- ---------------------------------------  -->
<div class="form  col col-3  user-form user-form-account user-form-account-password right" style="<?= (low($this->params['tab']) == 'account' ? '' : 'display:none;'); ?>">
    <?php
            echo $this->element('common/page_title', array(
                'pageTitle' => __('UPDATE_PASSWORD_EDIT_PROFILE_TITLE', true),
                'pageSubTitle' => __('UPDATE_PASSWORD_EDIT_PROFILE_SUBTITLE', true),
                'tag' => 'h2'
                )
            );
    ?>
            <div class="padding"><?
            //if (low($this->params['tab']) == 'account') {

            echo $this->Form->input('User.password');

            echo $this->Form->input('User.password_confirmation', array('type' => 'password'));

            echo $this->Form->submit(__('SAVE', true));
    ?>
            <a href="#deleteAccount" class="toggle"><? __('DELETE_GROFFI_ACCOUNT') ?></a>
        </div>
</div>






<? echo $this->Form->end(); ?>

            <div style="clear:both;width:100%;height:0px;">&nbsp;</div>

            <div class="form  col col-3 user-form right user-form-account user-form-account-delete " id="deleteAccount" style="display:none;">
    <?php
            echo $this->element('common/page_title', array(
                'pageTitle' => __('DELETE_ACCOUNT_EDIT_PROFILE_TITLE', true),
                'pageSubTitle' => __('DELETE_ACCOUNT_EDIT_PROFILE_SUBTITLE', true),
                'tag' => 'h2'
                )
            );
    ?>
            <div class="padding"><?
            echo $this->element('common/message_box', array(
                'title' => __('DELETE_ACCOUNT_MESSAGE_TITLE', true),
                'message' => __('DELETE_ACCOUNT_MESSAGE_MESSAGE', true),
                'icon' => 'privacy'
                )
            );
            echo $this->Form->create('User', array('type' => 'file', 'url' => '/settings/delete/'));
            echo $this->Form->input('User.id');
            echo $this->Form->input('deleteAccount.password', array('type' => 'password'));
            echo $this->Form->submit(__('DELETE_ACCOUNT', true));
            echo $this->Form->end();
    ?>
    </div>
</div>
<div style="clear:both;width:100%;height:0px;">&nbsp;</div>

<cake:script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#UserFile').bind('change',function(e){
                accept = String($(this).attr('accept')).toLowerCase().replace(/image\/|\s|\t/g,'').replace(/,\s*$/,  '').split(',');

                ext = $(this).val().split('.').pop().toLowerCase() ;

                if ( accept.in_array(ext) ) {
                    return true ;
                } else {
                    $(this).val('');
                    return false ;
                }
            }).customFileInput();
        });
    </script>
</cake:script>


<style type="text/css">

    .col-3 .titleBlock .content { width : 300px ;  }
    .col-3.user-form { border-bottom: 3px solid #EAEAEA ;}
    .col-3.user-form form { border: 0px none ;}
    .col-3.user-form div.input , .col-3 div.submit { padding: 0px ; }
    .col-3.user-form div.submit { padding: 20px 0px 0px 0px  ; }
    .col-3.user-form div.padding { padding: 20px 20px  ; }
    .col-3.user-form .message-box { padding : 0px 0px 0px 0px ;}

    .user-form-account-password a { display: block ; padding: 20px 0px 0px 0px ; font-size: 11px; text-decoration: none ; color : #338ABD }

    .user-form-account-delete div.submit input { background-color:  #B22224 ;}
    .user-form-account-delete div.submit input:hover { background-color:  #111111 ;}
    .user-form-account-delete   { position : relative ; top : -159px ;}

    .col-1 .col-2 { padding-top: 20px ;}
    .col-1 .col-2 .message-box { background-color:  #D5E7F0 ; margin-bottom: 20px ;}

    .user-form-account-notifications div.checkbox { margin-bottom:  5px}
    .user-form-account-notifications div.checkbox label { display: inline ; color : #999999 ;}

</style>