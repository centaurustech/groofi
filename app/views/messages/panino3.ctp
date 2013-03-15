<script>
<?php if($deleteok){?>
parent.location.reload();
<?php }else{ 
?>
parent.alerta("El mensaje no ha podido borrarse.<br>Por favor reint&eacute;ntelo.");
<?php } ?>
</script>