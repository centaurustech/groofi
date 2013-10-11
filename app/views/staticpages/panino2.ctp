<script>
    var mensaje_enviado = '<? echo __('MONTO_FONDOS1', true);?>'
<?php if($error){?>
parent.alerta('<?=$error?>');
<?php }else{ ?>
parent.alerta(mensaje_enviado);
parent.$('contactform').reset();
<?php } ?>
</script>