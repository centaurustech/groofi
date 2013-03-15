
<? echo $this->element(low(Inflector::pluralize($model)) . '/view_menu', array(low($model) => $modelData));?>
<div class="col col-4 post" id="content" >
    <?
    foreach ($this->data as $key => $postData) {
        echo $this->element('posts/project_post', array('data' => $postData, 'isFirst' => ($key == 0 )));
    }
    ?>
</div>
<? echo $this->element(low(Inflector::pluralize($model)) . '/info_col', array('data' => $modelData)); ?>