<script>
function validPosteo(){
	if($('titulo').value.length<3){
		alerta('Por favor ingresa un t&iacute;tulo m&aacute;s extenso');return false;
	}
	if($('texto').value.length<10){
		alerta('El texto de la actualizaci&oacute;n es demasiado breve');return false;
	}
	
}
</script>
<div style="height:20px; overflow:hidden;"></div>
<div class="posts full form" >
    <?php echo $this->Form->create('Post', array('url' => '/'.$this->params['url']['url'],'onsubmit'=>'return validPosteo()')); ?>
    <?php
        echo $this->Form->input('Post.title',array('id'=>'titulo','style'=>'margin-bottom:20px;'));
        echo $this->Form->input('Post.description', array('type' => 'textarea', 'class' => 'custom-html','id'=>'texto'));
        echo '<div style="visibility:hidden; height:10px; overflow:hidden">'.$this->Form->input('Post.public' , array('type'=>'checkbox','checked'=>'checked')).'</div>';
    ?>
    <?php echo $this->Form->end(__('SUBMIT', true)); ?>
</div>
