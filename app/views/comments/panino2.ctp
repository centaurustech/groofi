<?
session_start();
$_SESSION['VOLVER']=$ori;
?>
<script>
if(parent.$('loading'))
parent.$('loading').css('visibility','hidden');
</script>
<?
if(isset($error) && is_array($error) && count($error)){
foreach($error as $k=>$v){
	if($k=='login'){
	$_SESSION['VOLVER']=$ori;
?>
	<script>
	if(parent.$('formposteador'))
	parent.$('formposteador').reset();
	parent.alerta("Debes estar logueado para dejar tu comentario acerca del proyecto.");
	</script>
	<?
	
	exit;
	}
	
	
	?>
	<script>
	parent.alerta("<?=$v?>");
	</script>
<? exit;} ?>
<? }else{ ?>
<script>
parent.location.reload();
</script>
<? } ?>