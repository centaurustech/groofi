<?php /* @var $this ViewCC */ ?>
<div class="box prize-box <?= $key % 2 ? 'blue' : 'green' ?>">
    <? if (!Project::isFinished(array('Project' => $modelData))) { ?>
        <a href="<?= Project::getLink(array('Project' => $modelData), array('extra' => 'Back', 'prize' => $data['Prize']['id'])) ?>">
    <? } ?>
        <h5 class="title">
            <?= __('HELP_WITH', true) ?>
            <b>USD <?= $data['Prize']['value'] ?>+</b>
        </h5>
        <?= $this->Html->tag('p', $data['Prize']['description']); ?>
        <div class="backers"><?= sprintf(__('%s BAKERS', true), $data['Prize']['sponsorships_count']) ?></div>

    <? if (!Project::isFinished(array('Project' => $modelData))) { ?>
        </a>
    <? } ?>

</div>