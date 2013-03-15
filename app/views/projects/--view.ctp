<?php /* @var $this ViewCC */ ?>



<?= $this->element('projects/view_menu', array('project' => $this->data)); ?>




<div class="col col-4 post" id="content" >

    <div class="project-header">
        <?php
        $video = getVideoEmbed($this->data['Project']['video_url']);
        if ($video) {
            echo $this->Html->div('project-video', $video);
        } else {
            $file = $this->Media->file('l560/' . $this->data['Project']['image_file']);
            $image = $this->Media->embed($file);
            echo ($image ? $this->Html->div('project-image', $image ): ''  );
        }
        ?>
    </div>

    <?php
    echo $this->Html->tag('h2', __('ABOUT_THIS_PROJECT', true));
    echo $this->Html->tag('p', nl2br($this->data['Project']['description']));

    if (!empty($this->data['Project']['reason'])) {
        echo $this->Html->tag('h2', __('PROJECT_REASON', true));
        echo $this->Html->tag('p', nl2br($this->data['Project']['reason']));
    }
    ?>
</div>

<?= $this->element('projects/info_col', array('data' => $this->data)); ?>




