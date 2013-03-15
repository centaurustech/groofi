<?php echo $this->Form->create('Staticpage'); ?>
<?php

echo $this->Form->input('Staticpage.id');
echo $this->Form->input('Staticpage.title');
echo $this->Form->input('Staticpage.section');
echo $this->Form->input('Staticpage.slug', array('type' => 'hidden'));
echo $this->Form->input('Staticpage.subtitle');
echo $this->Form->input('Staticpage.content', array('class' => 'custom-html'));
echo $this->Form->input('Staticpage.template', array('type' => 'hidden'));
echo $this->element('form/url', array('elements' => 10, 'assocAlias' => 'Link' , 'helpMessage' => false ));
?>
<?php echo $this->Form->end(__('Submit', true)); ?>


