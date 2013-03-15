<?php /* @var $this ViewCC */ ?>


<?= $this->element('offers/view_menu', array('offer' => $offer)); ?>
<!-- -->

<div class="col col-4 post" id="content" >
    <?
        foreach ($this->data as $key => $postData) {
            echo $this->element('posts/offer_post', array('data' => $postData, 'isFirst' => ($key == 0 )));
        }
    ?>
</div>

<?= $this->element('offers/info_col', array('data' => $offer)); ?>