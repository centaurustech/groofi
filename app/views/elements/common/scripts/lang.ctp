<?php /* @var $this ViewCC */ ?>
<script type="text/javascript">
        //<![CDATA[
        var langTexts = {
            upload : {
                browse : '<?= __('UPLOAD_BROWSE') ?>' ,
                no_file_selected : '<?= __('UPLOAD_NO_FILE_SELECTED') ?>',
                change : '<?= __('CHANGE') ?>'
            },

            range : {
                text : {
                    plural   : '<?= __('::value:: DAYS') ?>' ,
                    singular : '<?= __('::value:: DAY') ?>'
                }
            },

            confirm : {
                ok      : '<?= __('OK') ?>' ,
                cancel  : '<?= __('CANCEL') ?>' ,
                title   : '<?= __('CONFIRM_TITLE') ?>',
                body    : '<?= __('ARE_YOU_SURE_DO_THIS_ACTION') ?>'
            },

            alert : {
                ok      : '<?= __('OK') ?>' ,
                title   : '<?= __('ALERT_TITLE') ?>'
            },
            
            media : {
                image : '<?= __('MEDIA_IMAGE') ?>' ,
                video : '<?= __('MEDIA_VIDEO') ?>' ,
                audio : '<?= __('MEDIA_AUDIO') ?>'
            }
        };

        var uID         =  <?= (isset($authUser['User']['id']) ? $authUser['User']['id'] : 'false'); // logued user id    ?> ;



        //]]>
</script>

