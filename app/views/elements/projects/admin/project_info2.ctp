<?
$full = isset($full) ? $full : true;

echo $full?$this->Html->div('thumb', $this->Media->getImage('s64', $result['Project']['image_file'], '/img/assets/img_default_64px.png')):'';

?>
<h2>
    #<?php echo $result['Project']['id']; ?> | <?php echo $this->Text->truncate($result['Project']['title'], 60); ?>&nbsp;
    <? if ($full) { ?>
        (<?= Category::getName($result) ?>) 
    <? } ?>
	<? $creadopor=User::getUserFromId($result['Project']['user_id']);?>
    <?= __('FROM', true) . ' ' . $creadopor[0]['users']['display_name']; ?>

    <? if ($full) { ?>
        <span><? echo $this->Time->format($result['Project']['created'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y'); ?></span>
    <? } ?>
</h2>

<? if ($full) { ?>
    <p><?php echo $result['Project']['short_description']; ?>&nbsp;</p>
<? } ?>
