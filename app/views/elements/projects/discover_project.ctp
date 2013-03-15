<?php /* @var $this ViewCC */ ?>
<? ?>



<div class="box project-box discover <?= $extraClass ?>" id="project_<?= $data['Project']['id'] ?>" >
    <div class="content">
        <?
        $extra = Project::isFunded($data) ? '<div class="fundedProject"></div>' : '';
        echo $this->Html->div("thumb", $this->Media->getImage('m188', $data['Project']['image_file'], '/img/assets/img_default_188x141px.png') . $extra
                , array('url' => Project::getLink($data))
        );
        echo $this->Html->tag('h3', $this->Html->link(
                        $this->Text->truncate(Project::getName($data), 24)
                        , Project::getLink($data), array('title' => Project::getName($data)))
                . $this->Html->div('sub-title', sprintf(
                                __('BY %s', true), $this->Html->link($this->Text->truncate(User::getName($data, 'User'), 30), User::getLink($data))
                        )
                )
                , array(
            'class' => 'title'
                )
        );
        ?>
        <?= $this->Html->tag('p', $this->Text->truncate($data['Project']['short_description'], 135), array('class' => 'description')); ?>
    </div>
    <div class="projectStats stats">
        <div class="graph">
            <div class="bar"></div>
            <div class="progress"></div>
        </div>
        <div class="statBox top left tl"><b><?= Project::getFundedValue($data) ?>% </b><? __('FUNDED') ?></div>
        <div class="statBox top right tr"><b>$<?= Project::getCollectedValue($data); ?></b><? __('PLEDGED') ?></div>
        <div class="statBox bottom left bl"><b><?= $data['Project']['sponsorships_count']; ?></b><? __('SPONSORSHIPS') ?></div>
<? if ($data['Project']['time_left'] > 0) { ?>
            <div class="statBox bottom right br"><b><?= $data['Project']['time_left']; ?></b><? __('DAYS_LEFT') ?></div>
        <? } ?>
    </div>
</div>
<cake:script>
    <script type="text/javascript">
        $('#project_<?= $data['Project']['id'] ?> .progress').width(0).animate({
            'width' : '<?= Project::getFundedValue($data, 100) ?>%'
        }, 1000 );
    </script>
</cake:script>