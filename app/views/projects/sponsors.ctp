<?php /* @var $this ViewCC */ ?>


<?

$this->set('title_for_layout', Project::getName($this->data));
$this->set('pageTitle', Project::getName($this->data));

if(!Project::belongsToOffer($this->data)) {
    $this->set('pageSubTitle', sprintf(__('PROJECT_BY %s IN CATEGORY %s', true)
                    , $this->Html->tag('span', User::getName($this->data), array('class' => 'highlight user-name', 'url' => User::getLink($this->data)))
                    , $this->Html->tag('span', Category::getName($this->data), array('class' => 'highlight category-name', 'url' => Category::getLink($this->data, 'projects')))
            )
    );
} else {

    $this->set('pageSubTitle', sprintf(__('PROJECT_BY %s IN CATEGORY %s IN RESPONSE OF %s', true)
                    , $this->Html->tag('span', User::getName($this->data), array('class' => 'highlight user-name', 'url' => User::getLink($this->data)))
                    , $this->Html->tag('span', Category::getName($this->data), array('class' => 'highlight category-name', 'url' => Category::getLink($this->data, 'projects')))
                    , $this->Html->tag('span', Offer::getName($this->data), array('class' => 'highlight offer-name', 'url' => Offer::getLink($this->data)))
            )
    );
}

?>



<div class="col col-full post" id="content" style="margin-top:30px;" >


    <?

    if(!empty($this->data['Sponsorship'])) {

        foreach($this->data['Sponsorship'] as $sponsorship) {

            ?>
            <div class="user sponsorship info">
                <?

                echo $this->Html->link(
                        $this->Media->getImage('s50', $sponsorship['User']['avatar_file'], '/img/assets/img_default_50px.png'), User::getLink($sponsorship), array('escape' => false, 'class' => 'thumb')
                );

                ?>
                <div style="float:left;">
                    <?

                    echo $this->Html->tag('h3', User::getName($this->data), array('url' => User::getLink($sponsorship)));

                    echo $this->Html->link($sponsorship['User']['email'], 'mailto:' . $sponsorship['User']['email'], array('style' => 'display:block;padding:3px 0px;clear:both;'));

                    $text = !empty($sponsorship['Prize']) ? sprintf(__('HAS_SUPPORTED_YOU_WITH USD %s AND_SELECTED_THE PRIZE "%s"', true), $sponsorship['contribution'], $sponsorship['Prize']['description']) : sprintf(__('HAS_SUPPORTED_YOU_WITH USD %s', true), $sponsorship['contribution']);

                    echo $this->Html->tag('p', $text);

                    ?>
                </div>
            </div>
        <? } ?>
        <?

    } else {

        ?>


        <div class="not-found-msg">
            <?=

            sprintf(
                    __('THIS_PROJECT_WAS_NOT_SUPPORTED_YET %s', true), $this->Html->link(__('BE_THE_FIRST', true), Project::getLink($this->data, 'back'))
            );

            ?>



        </div>

<? } ?>
</div>





