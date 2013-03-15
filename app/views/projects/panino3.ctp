<script>
top.$('claveprivate').value='';
<? if($pass=='ok'){?>
top.location='<?=$this->Session->read('privateURL');?>';
<?}else{?>
top.$('claveprivadaerror').style.display='block';
<? } ?>
</script>