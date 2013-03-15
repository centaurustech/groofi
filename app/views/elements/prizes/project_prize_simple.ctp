<?php /* @var $this ViewCC */ ?>

<?
    $extraClass = isset($extraClass) ? $extraClass : '' ;
?>

<div class="box prize-box simple <?= $key % 2 ? 'blue' : 'green' ?> <?=$extraClass?>">
    <h5 class="title">
        <b value="<?=$data['Prize']['value']?>">USD <?= $data['Prize']['value'] ?>+</b>
        <input type="radio" id="PrizeId_<?=$data['Prize']['id']?>" name="data[Prize][id]" value="<?=$data['Prize']['id']?>" /> <!-- style="display:none" -->
    </h5>
    <?= $this->Html->tag('p', $data['Prize']['description']); ?>
</div>