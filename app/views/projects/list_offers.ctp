<?php /* @var $this ViewCC */ ?>


<?= $this->element('offers/view_menu', array('offer' => $offer)); ?>



<div class="col col-4 post"  id="content" >
<?

    foreach ($this->data as $project) {
        
        echo $this->element('projects/offer_project',array('project'=>$project,'data'=>$project)); 
        
    }

?>
</div>
<div class="col col-5 right offer-info"  id="content" >
    <?php
    echo $this->element('offers/info_col', array('data' => $offer));
    ?>
</div>