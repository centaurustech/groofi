<?php /* @var $this ViewCC */ ?>
<div class="col col-5 right project-info" >
    <?php
    echo $this->element('projects/view_info', array('data' => $data));
    if (!Project::isFinished($data)) {
        echo $this->element('projects/view_prizes', array('data' => $data, 'model' => 'Project'));
    }
    echo $this->element('users/mini_info', array('data' => $data));
    ?>
</div>
