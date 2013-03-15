<?php
session_start();
?>
<script>
<?php if($loginok && isset($agregar) && !$eselautor){?>
parent.$('btseg').style.display='none';parent.$('btdej').style.display='';
<?php }elseif($loginok && isset($agregar) && $eselautor){?>
parent.alerta('No puedes seguir un proyecto del cual eres autor.');
<?php }elseif($loginok && isset($borrar)){?>
parent.$('btseg').style.display='';parent.$('btdej').style.display='none';
<?php }elseif(!$loginok && isset($agregar)){?>
parent.alerta('Debes estar registrado para realizar esta acci&oacute;n');
<?php }elseif($loginok && isset($borrar)){?>
parent.alerta('Debes estar registrado para realizar esta acci&oacute;n');
<?php } ?>
</script>