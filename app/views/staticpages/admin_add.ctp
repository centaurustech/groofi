<div class="staticpages form">
    <?php echo $this->Form->create('Staticpage'); ?>
        <fieldset>
            <legend><?php __('Admin Add Staticpage'); ?></legend>
        <?php
            echo $this->Form->input('title');
            echo $this->Form->input('section');
            echo $this->Form->input('slug');
            echo $this->Form->input('subtitle');
            echo $this->Form->input('content',array('class'=>'simple-editor'));
            echo $this->Form->input('template');

            echo $this->element('form/url', array('elements' => 10, 'assocAlias' => 'Link'));
        ?>
        </fieldset>
    <?php echo $this->Form->end(__('Submit', true)); ?>
</div>
