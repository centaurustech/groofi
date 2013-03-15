<?php /* @var $this ViewCC */ ?>



<div id="projectDetails" class="module project-details-module">
    <div id="Sponsors" class="statsbox tl">
        <span style="font-size:36px;font-weight:bold;    letter-spacing: -1px;" class="TerminalDosisLight" ><?= $data['Project']['sponsorships_count']; ?></span>
        <p><? __('SPONSORS') ?></p>
    </div>

    <? if (!Project::isFinished($data)) { ?>
        <div id="TimeLeft" class="statsbox tr">
            <span style="font-size:36px;font-weight:bold;    letter-spacing: -1px;" class="TerminalDosisLight" >0<?= $data['Project']['time_left']; ?></span>
            <p><? __('DAYS_LEFT') ?></p>
        </div>
    <? } else { ?>
        <? if (Project::isFunded($data)) { ?>
            <div id="projectStatus" class="statsbox tr">
                <p><? __('STATUS_OF_PROJECT') ?></p>
                <span style="font-size:36px;font-weight:bold;    letter-spacing: -1px;" class="TerminalDosisLight" ><? __('PROJECT_FUNDED_INFO') ?></span>
            </div>
        <? } else { ?>
            <div id="projectStatus" class="statsbox tr">
                <p><? __('STATUS_OF_PROJECT') ?></p>
                <span style="font-size:36px;font-weight:bold;    letter-spacing: -1px;" class="TerminalDosisLight" ><? __('PROJECT_NOT_FUNDED_INFO') ?></span>
            </div>
        <? } ?>
    <? } ?>





    <div id="Money" class="statsbox bf">
        <span style="font-size:36px;font-weight:bold;    letter-spacing: -1px;" class="TerminalDosisLight" >USD <?= Project::getCollectedValue($data); ?></span>
        <p><?= sprintf(__('AVAILABLE_FOUNDS_FROM %s', true), $data['Project']['funding_goal']) ?></p>
    </div>



    <? if (!Project::isFinished($data)) { ?>
        <div id="projectAdvice" class="infoBox advice">
            <span class="ui-icon site-icon small icon-advice">&nbsp;</span>
            <b><? __('PROJECT_IMPORTANT_ADVICE_TITLE') ?></b><br />
            <? echo sprintf(__('PROJECT_IMPORTANT_ADVICE %s %s', true), $this->Time->i18nFormat($data['Project']['end_date'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y'), $data['Project']['funding_goal']); ?>
        </div>
<? if(Offer::isPublic($data)) { ?>
        <div class="infoBox btn" >
            <h4><? __('SUPPORT_THIS_PROJECT') ?></h4>
            <a href="<?= Project::getLink($data, 'back'); ?>"  rel="nofollow" id="supportThisProject">
                <? __('SUPPORT_THIS_PROJECT_SUBLINE') ?>
            </a>
        </div>
    <? } ?>
    <? } ?>


    <? if (Project::isPublic($data)) { ?>
    <div class="infoBox btn" >
        <h4><? __('SHARE_THIS_PROJECT_TITLE') ?></h4>
        <a href="#share"  rel="nofollow" class="addthis_button" id="shareThisProject">
            <? __('SHARE_THIS_PROJECT_SUBTITLE') ?>
        </a>
    </div>
    <? } ?>




    <!-- AddThis Button BEGIN -->
    <script type="text/javascript">
        var addthis_config = {
            ui_click: true
            , ui_cobrand : 'Groofi'
            , ui_use_css : false
            ,ui_offset_top : -15
            ,services_compact : 'facebook,twitter,myspace,live,orkut,sonico,tumblr,blogger,orkut,sonico'
            ,url : '<?= Project::getLink($data, array(), true); ?>'
            ,title : '<?= Project::getName($data); ?>'
            ,description : '<?= addslashes($data['Project']['short_description']); ?>'

        }
    </script>

    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=gmusante"></script>
    <!-- AddThis Button END -->



    <div class="clearfix">&nbsp;</div>
</div>
