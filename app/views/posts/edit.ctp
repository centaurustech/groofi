<div class="posts full form" >
    <?php echo $this->Form->create('Post', array('url' => DS.$this->params['url']['url'])); ?>
    <?php
        echo $this->Form->input('Post.id');
        echo $this->Form->input('Post.title');
        echo $this->Form->input('Post.description', array('type' => 'textarea', 'class' => 'custom-html'));
        echo $this->Form->input('Post.public' , array('type'=>'checkbox'));
    ?>
  <?php echo $this->Form->end(__('SUBMIT', true)); ?>
</div>
