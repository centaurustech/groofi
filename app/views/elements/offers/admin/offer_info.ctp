<?
$full = isset($full) ? $full : true;
echo $this->Html->div('thumb', $this->Media->getImage('s64', $result['Offer']['image_file'], '/img/assets/img_default_64px.png'));
?>

<h2>
    #<?php echo $result['Offer']['id']; ?> | <?php echo $this->Text->truncate($result['Offer']['title'], 60); ?>&nbsp;
    <? if ($full) { ?>
        (<?= Category::getName($result) ?>) 
    <? } ?>
    <?= __('FROM', true) . ' ' . User::getName($result); ?>

    <? if ($full) { ?>
        <span><? echo $this->Time->format($result['Offer']['created'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y'); ?></span>
    <? } ?>
</h2>

<? if ($full) { ?>
    <p><?php echo $result['Offer']['short_description']; ?>&nbsp;</p>
<? } ?>
