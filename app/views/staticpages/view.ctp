    
<?php /* @var $this ViewCC */ 

$this->set('pageTitle' , $this->data['Staticpage']['title'] ) ;
$this->set('title_for_layout' , $this->data['Staticpage']['title'] ) ;
$this->set('pageSubTitle' , !empty($this->data['Staticpage']['subtitle']) ? $this->data['Staticpage']['subtitle'] : false ) ;
?>
<div class="staticpages post">
    <?php
    echo nl2br($this->data['Staticpage']['content']);
    ?>
</div>

