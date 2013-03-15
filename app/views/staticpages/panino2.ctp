<script>
<?php if($error){?>
parent.alerta('<?=$error?>');
<?php }else{ ?>
parent.alerta('El mensaje se ha enviado correctamente');
parent.$('contactform').reset();
<?php } ?>
</script>