<?php /* @var $this ViewCC */ ?>



<div id="offerDetails" class="module offer-details-module">

    <? if(Offer::isFinished($data)) { ?>
        <div class="statsbox bf">
            <span style="font-size:36px;font-weight:bold;    letter-spacing: -1px;" class="TerminalDosisLight" ><? __('OFFERS_FINISHED_STATUS') ?></span>
            <p><? __('OFFERS_FINISHED_STATUS_FINISHED') ?></p>
        </div>
    <? } ?>


    <div class="statsbox tl">
        <span style="font-size:36px;font-weight:bold;    letter-spacing: -1px;" class="TerminalDosisLight" ><?=$data['Offer']['project_count']?></span>
        <p><? __('PEOPLE_WHO_ACCEPT_OFFER') ?></p>
    </div>

    <div class="statsbox tr">
        <span style="font-size:36px;font-weight:bold;    letter-spacing: -1px;" class="TerminalDosisLight" >USD <?= $data['Offer']['funding_sponsorships_founds'] ?></span>
        <p><?= __('AVAILABLE_FOUNDS_FOR_EACH_PROJECT', true) ?></p>
    </div>


    <? if(!Offer::isFinished($data)) { ?>
        <div id="offerAdvice" class="infoBox advice">
            <span class="ui-icon site-icon small icon-advice">&nbsp;</span>
            <b><? __('OFFER_IMPORTANT_ADVICE_TITLE') ?></b><br />
            <? echo sprintf(__('OFFER_IMPORTANT_ADVICE %s', true), $data['Offer']['offer_sponsorships']); ?>
        </div>

        <div class="infoBox btn">
            <h4><? __('I_WANT_TO_DO_IT_HEADLINE') ?></h4>
            <a href="<?= Router::url(array('controller' => 'projects', 'action' => 'add', $data['Offer']['id'])); ?>" id="iWantToDoIt">
                <? __('I_WANT_TO_DO_IT') ?>
            </a>
        </div>

        <? if(!Offer::isOwnOffer($data)) { ?>
            <? if($data['Offer']['offer_public'] == 1) { ?>

                <div class="infoBox btn action ajax follow" style="<?= (Follow::isFollowing($data) ? 'display:none' : '') ?>">
                    <h4><? __('I_WANT_TO_BE_PART_HEADLINE') ?></h4>
                    <a href="<?= Offer::getLink($data, 'follow'); ?>"  rel="nofollow" id="iWantToBePart">
                        <? __('I_WANT_TO_BE_PART') ?>
                    </a>
                </div>


                <div class="infoBox btn action ajax unfollow" style="<?= (!Follow::isFollowing($data) ? 'display:none' : '') ?>">
                    <h4><? __('I_WANT_NOT_TO_BE_PART_HEADLINE') ?></h4>
                    <a href="<?= Offer::getLink($data, 'unfollow'); ?>"  rel="nofollow" id="iWantNotToBePart">
                        <? __('I_WANT_NOT_TO_BE_PART') ?>
                    </a>
                </div>

            <? } ?>

            <? if(Offer::isPublic($data)) { ?>
                <div class="infoBox btn sharing">
                    <h4><? __('SHARE_THIS_OFFER_TITLE') ?></h4>
                    <a href="<?= Offer::getLink($data); ?>"  rel="nofollow" class="addthis_button" id="shareThisOffer">
                        <? __('SHARE_THIS_OFFER_SUBTITLE') ?>
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
                    ,url : '<?= Offer::getLink($data, array(), true); ?>'
                    ,title : '<?= Offer::getName($data); ?>'
                    ,description : '<?= addslashes($data['Offer']['short_description']); ?>'
                }
            </script>

            <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=gmusante"></script>
            <!-- AddThis Button END -->
        <? } ?>








    <? } ?>

    <div class="clearfix">&nbsp;</div>
</div>
