<?
session_start();
if(!isset($_SESSION['VOLVER']) || empty($_SESSION['VOLVER'])){
	$_SESSION['VOLVER']=(isset($_SESSION['Auth']['redirect']))?$_SESSION['Auth']['redirect']:0;
	
}
?>
<script>
<?php if($loginok && (!isset($_SESSION['VOLVER'] ) || empty($_SESSION['VOLVER']))){?>
parent.location='/news';
<?php }elseif($loginok && isset($_SESSION['VOLVER']) && !empty($_SESSION['VOLVER'])){?>
parent.location='<?=$_SESSION['VOLVER']?>';
<? $_SESSION['VOLVER']=0;unset($_SESSION['VOLVER']);}else{ ?>
parent.alerta('<?php echo __("USER_PASS");?>',1);

<?php } ?>
</script>