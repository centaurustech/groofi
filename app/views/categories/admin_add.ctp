<?php

    /* @var $this ViewCC */
echo $html->link('Back',array('action'=>'index'));

echo $form->create('Category');
echo $form->input('name');
echo $form->input('parent_id', array('selected'=>$this->data['Category']['parent_id']));
echo $form->end('Create');
?>

