<script><?php
$textareas = explode(',',$textareas);
for($i=0;$i<count($textareas);$i++){?>
var editor<?php echo $i;?> = CKEDITOR.replace( '<?php echo $textareas[$i]?>' );
CKFinder.SetupCKEditor( editor<?php echo $i;?>, { BasePath : '/js/ckfinder/', RememberLastFolder : false } ) ;
    <?php    }?>
</script>