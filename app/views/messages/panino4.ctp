<script>
<?php if($enviook){?>
parent.location.reload();
<?php }else{ 
?>
parent.alerta("El estado del mensaje no ha podido acualizarse.<br>Por favor reint&eacute;ntelo.");
<?php } ?>
</script>