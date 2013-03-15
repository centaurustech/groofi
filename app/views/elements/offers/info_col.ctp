<?php /* @var $this ViewCC */ ?>
<div class="col col-5 right offer-info" >
<?php
    echo $this->element('offers/view_info'   , array('data' => $data));

    
    echo $this->element('offers/project_info'   , array('data' => $data));
    
    echo $this->element('offers/follow_info'   , array('data' => $data));
    
    
    
    echo $this->element('users/mini_info'      , array('data' => $data));
?>
</div>
