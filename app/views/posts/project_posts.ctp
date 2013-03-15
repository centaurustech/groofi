<?php
 
?>
<?= $this->element('projects/view_menu', array('project' => $project)); ?>


<div class="col col-4 post" id="content" >
    <?
        foreach ($this->data as $key => $postData) {
            echo $this->element('posts/project_post', array('data' => $postData, 'isFirst' => ($key == 0 )));
        }
    ?>
</div>
<?= $this->element('projects/info_col', array('data' => $project)); ?>