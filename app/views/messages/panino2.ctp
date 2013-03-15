<script>
<?php if($enviook){?>
parent.alerta("El mensaje ha sido enviado.");
parent.$('messageForm').reset();
parent.$('fromoculto').style.display='none';
<?php }else{ 
?>
parent.alerta("El mensaje no ha podido enviarse.<br>Por favor reint&eacute;ntelo.");
<?php } ?>
</script>