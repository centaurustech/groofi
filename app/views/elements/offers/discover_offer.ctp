<?php /* @var $this ViewCC */ ?>


<div class="box offer-box discover <?= $extraClass ?>" id="offer_<?=$data['Offer']['id']?>" >
    <div class="content">
        <?= $this->Html->div('thumb', $this->Media->getImage('m188', $data['Offer']['image_file'], '/img/assets/img_default_188x141px.png'), array('url' => Offer::getLink($data))); ?>
        <?
        echo $this->Html->tag('h3', $this->Html->link(
                        $this->Text->truncate(Offer::getName($data), 24)
                        , Offer::getLink($data)
                        , array( 'title' => Offer::getName($data))
                )
                . $this->Html->div('sub-title', sprintf(
                                __('BY %s', true), $this->Html->link($this->Text->truncate(User::getName($data, 'User'), 30), User::getLink($data))
                        )
                )
                , array(
            'class' => 'title'
                )
        );
        ?>
        <?= $this->Html->tag('p', $this->Text->truncate( $data['Offer']['short_description'] ,135), array('class' => 'description')); ?>
    </div>
    <div class="offerStats stats" style="display:none;">
        &nbsp;
        

    </div>
</div>
