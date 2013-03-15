<?php /* @var $this ViewCC */ ?>



 
<?= $this->element('offers/view_menu', array('offer' => $this->data)); ?>



<div class="col col-4 post"  id="content" >

    <div class="offer-header">
        <?php
        $video = getVideoEmbed($this->data['Offer']['video_url']);
        if ($video) {
            echo $this->Html->div('offer-video', $video);
        } else {
            $file = $this->Media->file('l560/' . $this->data['Offer']['image_file']);
            $image = $this->Media->embed($file);
            echo ($image ? $this->Html->div('offer-image', $image) : '' );
        }
        ?>
    </div>
    <?php
    echo $this->Html->tag('h2', __('ABOUT_THIS_OFFER', true));
    echo $this->Html->tag('p', nl2br($this->data['Offer']['description']));
    ?>
</div>
<div class="col col-5 right offer-info"  id="content" >
    <?php
    echo $this->element('offers/info_col', array('data' => $this->data));
    ?>
</div>