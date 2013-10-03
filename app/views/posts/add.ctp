
<?php
echo $this->Html->script('ckeditor/ckeditor');
echo $this->Html->script('ckfinder/ckfinder');
?>

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
    echo $this->Form->input('Post.title',array('id'=>'titulo','style'=>'margin-bottom:20px;'));?>
    <div class="ckeditor2">
        <p style=" clear: both;
    color: #666666;
    display: block;
    font-size: 13px;
    padding-bottom: 5px;"><? echo __("CREATE_UPDATE");?></p>
        <!--?echo $this->Form->input('Post.description', array('type' => 'textarea', 'class' => 'custom-html','id'=>'texto'));?-->
        <textarea tabindex=2 class="ckeditor" name="data[Post][description]" autocomplete="off" cols="30" rows="6"></textarea>
    </div>

    <?echo '<div style="visibility:hidden; height:10px; overflow:hidden">'.$this->Form->input('Post.public' , array('type'=>'checkbox','checked'=>'checked')).'</div>';
    ?>
    <?php echo $this->Form->end(__('SUBMIT', true)); ?>
</div>
<script type="text/javascript">

//var ck_newsContent = CKEDITOR.replace( 'data[Project][description]' );
CKEDITOR.replace( 'data[Post][description]',
{
/*filebrowserBrowseUrl : '/js/ckfinder/ckfinder.html',
filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?type=Images',
filebrowserFlashBrowseUrl : '/js/ckfinder/ckfinder.html?type=Flash',*/
filebrowserUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
filebrowserImageUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
/*filebrowserFlashUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'*/
});

//ck_newsContent.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );

</script>