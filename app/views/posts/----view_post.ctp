<?php /* @var $this ViewCC */ ?>

<?
 
echo $this->element(low(Inflector::pluralize($model)) . '/view_menu', array(low($model) => $modelData));
?>


<!-- -->
<div class="col col-4 post" id="content" >
    <?
    echo $this->element('posts/view_post', array('data' => $this->data, 'full' => true));
    ?>



</div>

<? echo $this->element(low(Inflector::pluralize($model)) . '/info_col', array('data' => $modelData)); ?>