<?php /* @var $this ViewCC */ ?>

<?
    $this->set('pageTitle', false);
    $this->set('pageSubTitle', false);
?>


<div class="generic-message box share-module">
    <div class="arrow  arrow-grey arrow-top"></div>
    <h2 class="title">
        <? __($published ? 'PAGE_PUBLISHED_TITLE' : 'PAGE_SHARE_TITLE') ?>
    </h2>
    <p class="TerminalDosisLight">
        <? __($published ? 'PAGE_PUBLISHED_BODY' : 'PAGE_SHARE_BODY') ?>
    </p>
    <div
        class="addthis_toolbox addthis_default_style addthis_32x32_style"
        addthis:url="http://example.com"
        addthis:title="An Example Title"
        addthis:description="An Example Description"
        >

        <a class="addthis_button_facebook"></a>
        <a class="addthis_button_twitter"></a>
        <a class="addthis_button_googlebuzz"></a>
        <a class="addthis_button_linkedin"></a>
        <a class="addthis_button_formspring"></a>
        <a class="addthis_button_orkut"></a>
        <a class="addthis_button_myspace"></a>
        <a class="addthis_button_sonico"></a>
        <a class="addthis_button_email"></a>

        <!--
        <a class="addthis_button_facebook_like"></a>
        <a class="addthis_button_compact"></a>
        <a class="addthis_counter addthis_bubble_style"></a>
        -->
    </div>
</div>



<!-- AddThis Button BEGIN -->

<script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4dd6bbcb5e924df1"></script>
<!-- AddThis Button END -->
