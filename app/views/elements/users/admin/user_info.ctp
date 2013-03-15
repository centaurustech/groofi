<?
$full = isset($full) ? $full : true;
echo $full?$this->Html->div('thumb', $this->Media->getImage('s64', $result['User']['avatar_file'], '/img/assets/img_default_64px.png')):'';
?>



<? if ($result['User']['admin'] == 0) { ?>
    <h2>
        <span class="ui-icon  <?= ($result['User']['confirmed'] == 1 ? 'ui-icon-key' : 'ui-icon-locked') ?>" >&nbsp;</span> 
        <?php echo $result['User']['id']; ?> | <?php echo $this->Text->truncate($result['User']['display_name'], 60); ?>
        <? if ($full) { ?>
            <span class="date"><? echo $this->Time->format($result['User']['created'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y'); ?></span>
        <? } ?>
    </h2>
<? } ?>


<a href="mailto:<?php echo $result['User']['email']; ?>"><?php echo $result['User']['email']; ?></a>

<span class="ui-icon <?= ($result['User']['confirmed'] == 1 ? 'ui-icon-check' : 'ui-icon-close') ?>" >&nbsp;</span>

<? if ($result['User']['admin'] == 0) { ?>
    <?php if ($result['User']['report_count'] > 0) { ?>
        <span class="ui-icon ui-icon-alert" >&nbsp;</span>
        (<?= sprintf(__('%s REPORTS', true), $result['User']['report_count']) ?>)
    <?php } ?>
    </p>
    <? if ($full) { ?>
        <div class="score">
            <?php for ($a = 0; $a < $result['User']['score']; $a++) { ?>
                <span class="ui-icon ui-icon-star" >&nbsp;</span>
            <?php } ?>
        </div>
    <? } ?>
<? } ?>
