<?php /* @var $this ViewCC */ 
	$this->set('title_for_layout', Project::getName($project));
    $this->set('pageTitle', Project::getName($project));
	//vd($selectedPrize['Prize']['id']);
	//vd($selectedPrize);
	//vd($project['Prize']);
	$personas=array();
	$empresas=array();
	for($i=0;$i<count($project['Prize']);$i++){
		if($project['Prize'][$i]['ente']=='P' /*&& $project['Prize'][$i]['id']!=$selectedPrize['Prize']['id']*/){
			$personas[]=$project['Prize'][$i];
		}else/*if($project['Prize'][$i]['id']!=$selectedPrize['Prize']['id'])*/{
			$empresas[]=$project['Prize'][$i];
		}
	}
//vd($this->data['Project']);
//vd($validationErrorsArray);
$moneda=Project::getMoneda($project);
//vd($moneda);
?>
<script>
function sendToMP(){
	
	$('datamp').value=1;
	$('sponsorshipContributionForm').target="ifr";
	$('sponsorshipContributionForm').action="/<?=$this->params['url']['url']?>";
	$('sponsorshipContributionForm').submit();
}
function sendToPaypal(){
	$('datamp').value=0;
	$('sponsorshipContributionForm').target="_top";
	$('sponsorshipContributionForm').action="/<?=$this->params['url']['url']?>";
	$('sponsorshipContributionForm').submit();
}
</script>

<div style="overflow:hidden;margin-top:30px;">
<form id="sponsorshipContributionForm" method="post" action="/<?=$this->params['url']['url']?>" accept-charset="utf-8">

<h1 style="font-weight:normal; font-size:28px; line-height:32px"><a class="titulolink" href="<?=Project::getLink($project)?>"><?=Project::getName($project)?></a></h1>

<span style=" font-style:italic; color:#666; line-height:30px"><?php echo __("CATEGORY_OF PROJECT %s");?></span> <span style="font-weight:bold; color:#39a0c6; text-decoration:underline"> <a  style="font-weight:bold; color:#39a0c6; text-decoration:underline" href="<?=Category::getLink($project, 'projects')?>"><?=Category::getName($project)?></a></span>

<div class="misc_divisor"></div>
<br>
<div class="pagar_izq">
<h3 class="cyan"><?php echo __("SPONSORSHIP_CREATE_TITLE");?></h3>
<p><?php echo __("SPONSORSHIP_CREATE_SUBTITLE");?></p>
<p><br>
</p>
<div id="beneficioElegido" class="importe_pagar">
  <div class="input_fondos">
  <div style="color:#686b68; width:50px; height:30px; text-align:right; line-height:30px;font-size:15px;font-weight:normal; position:absolute; left:-45px;top:20px;font-family:Arial, Helvetica, sans-serif"><?=$moneda?></div>
<input id="in_fondos" type="text" name="data[Sponsorship][contribution]" value="<?if(isset($this->data['Sponsorship']['contribution']) && !empty($this->data['Sponsorship']['contribution'])){ echo $this->data['Sponsorship']['contribution'];}else{echo $selectedPrize['Prize']['value'];}?>" />
<div id="retvvali" style="color:red;font-size:9px;position:relative; top:6px; left:-40px"><?php if (isset($validationErrorsArray['contribution']) && !empty($validationErrorsArray['contribution'])){echo $validationErrorsArray['contribution'];}?></div>
</div>
<input type="hidden" name="data[Prize][id]" autocomplete="off" value="<?=$selectedPrize['Prize']['id']?>" />
<input type="hidden" name="data[v]" autocomplete="off" value="1" />
<input type="hidden" id="datamp" name="data[mp]" autocomplete="off" value="0" />
<div class="beneficio_elegido">
<h4 id="titulobenefel"><?php echo __("PRIZE_");?></h4>
<p id="descbelegido"><?=$selectedPrize['Prize']['description']?></p>
</div>

</div>
<label style="position:relative;  text-align:left !important; font-size:12px; margin:0; padding:0; width:400px; display:block" for="SponsorshipNoPrize"><input onchange="if(this.checked){$('titulobenefel').style.display=$('descbelegido').style.display='none';}else{$('titulobenefel').style.display=$('descbelegido').style.display='block';}" style="display:inline; margin:5px;; padding:0; width:auto; position:relative; top:2px;" type="checkbox" name="data[Sponsorship][no_prize]" autocomplete="off" value="1" id="SponsorshipNoPrize" <?if(isset($this->data['Sponsorship']['no_prize']) && !empty($this->data['Sponsorship']['no_prize'])){echo ' checked="checked" ';}?>><?php echo __("YOU_SELECT_ONLY_HELP");?></label><br /><br />
<h3 style="color:#666; font-size:15px"><?php echo __("SPONSORSHIP_CREATE_PRIZES_TITLE");?></h3>
<div class="misc_separador"></div><br>
<? if(count($personas)>0){ ?>
<h4 class="cyan"><?php echo __("Personas_patro");?></h4><br>
<? for($i=0;$i<count($personas);$i++){?>
<div class="beneficio_creado_pagar">
<h3 class="cyan"><?php echo __("Providing");?> <?=$moneda?> <?=$personas[$i]['value']?> </h3>
<p class="texto_proyecto" style="color:#383938"><?=$personas[$i]['description']?></p>
<a class="btcambiarbeneficio" href="<?=Project::getLink(array('Project' => $this->data['Project']), array('extra' => 'Back', 'prize' => $personas[$i]['id']))?>"></a>
</div>
<div class="separador_azul_pagar"  <? if($i==count($personas)-1){?>style="height:2px"<? } ?>></div>
<? } ?>
<br>
<? } ?>
<? if(count($empresas)>0){ ?>
<h4 class="green"><?php echo __("Personas_patro_gran");?></h4><br>
<? for($i=0;$i<count($empresas);$i++){?>
<div class="beneficio_creado_pagar empresas">
<h3 class="green"><?php echo __("Providing");?><?=$moneda?> <?=$empresas[$i]['value']?> </h3>
<p class="texto_proyecto" style="color:#383938"><?=$empresas[$i]['description']?></p>
<a class="btcambiarbeneficio verde" href="<?=Project::getLink(array('Project' => $this->data['Project']), array('extra' => 'Back', 'prize' => $empresas[$i]['id']))?>"></a>
</div>
<div class="separador_verde_pagar" <? if($i==count($empresas)-1){?>style="height:2px"<? } ?>></div>
<? } ?>
<br>
<? } ?>
<br>
</div>
<div class="paypal_der">
<? if($_SESSION['idioma'] == 'esp'){ ?>
<h3 style="font-size:18px; font-weight:400; color:#333"><?php echo __("SPONSORSHIP_LAST_STEP_SUBTITLE");?></h3><br>
<div class="texto_importante_paypal">
<div class="icono_importante_paypal"></div>
<p><strong><?php echo __("IMPORTANT_PAYPAL_TITLE");?></strong><br>
<?php echo __("IMPORTANT_PAYPAL_BODY");?></p>
<p>&nbsp;</p>
</div>
<p><img src="/2012/images/paypal_cards.png" width="262" height="62"></p>
<p>&nbsp; </p>
<div onclick="sendToPaypal();" class="boton_paypal"><?php echo __("SPONSORSHIP_CREATE_SUBMIT");?></div>
<div style="height:25px; overflow:hidden; width:100%; background:#fff; border-bottom:2px solid #e1e1e1;margin-bottom:15px; visibility:hidden"></div>

    <h3 style="font-size:18px; font-weight:400; color:#333;"><?php echo __("PROCESO_MERCADO_PAGO");?></h3><br>
    <img src="/2012/images/mercadopago.png">
    <div onclick="sendToMP();" class="boton_paypal"><?php echo __("SPONSORSHIP_CREATE_SUBMIT");?></div>

<? }elseif($_SESSION['idioma'] == 'eng'){ ?>
    <h3 style="font-size:18px; font-weight:400; color:#333"><?php echo __("SPONSORSHIP_LAST_STEP_SUBTITLE");?></h3><br>
    <div class="texto_importante_paypal">
        <div class="icono_importante_paypal"></div>
        <p><strong><?php echo __("IMPORTANT_PAYPAL_TITLE");?></strong><br>
            <?php echo __("IMPORTANT_PAYPAL_BODY");?></p>
        <p>&nbsp;</p>
    </div>
    <p><img src="/2012/images/paypal_cards.png" width="262" height="62"></p>
    <p>&nbsp; </p>
    <div onclick="sendToPaypal();" class="boton_paypal"><?php echo __("SPONSORSHIP_CREATE_SUBMIT");?></div>
    <div style="height:25px; overflow:hidden; width:100%; background:#fff; border-bottom:2px solid #e1e1e1;margin-bottom:15px; visibility:hidden"></div>



<? }elseif($_SESSION['idioma'] == 'ita'){?>
    <h3 style="font-size:18px; font-weight:400; color:#333"><?php echo __("SPONSORSHIP_LAST_STEP_SUBTITLE");?></h3><br>
    <div class="texto_importante_paypal">
        <div class="icono_importante_paypal"></div>
        <p><strong><?php echo __("IMPORTANT_PAYPAL_TITLE");?></strong><br>
            <?php echo __("IMPORTANT_PAYPAL_BODY");?></p>
        <p>&nbsp;</p>
    </div>
    <p><img src="/2012/images/paypal_cards.png" width="262" height="62"></p>
    <p>&nbsp; </p>
    <div onclick="sendToPaypal();" class="boton_paypal"><?php echo __("SPONSORSHIP_CREATE_SUBMIT");?></div>
    <div style="height:25px; overflow:hidden; width:100%; background:#fff; border-bottom:2px solid #e1e1e1;margin-bottom:15px; visibility:hidden"></div>


<?}?>
<script type="text/javascript">
function pseudomodal(cual){
	if(!$('custom_ext2')){
				var ext=document.createElement('div');
				ext.style.opacity=0;
				ext.style.filter='alpha(opacity=0)';
				ext.id='custom_ext2';
				ext.style.width='532px';
				ext.style.height='312px';
				ext.style.background='url(/2012/images/'+cual+') no-repeat';
				ext.style.zIndex=21000;
				ext.style.position='fixed';
				ext.style.left='50%';
				ext.style.marginLeft='-266px';
				
				ext.style.display='none';
				
				ext.style.cursor='pointer';
				
				$('bglightbox2').onclick=ext.onclick=function(){closeAlert2();};
				
				document.body.appendChild(ext);
			 }
			 var meds=getWindowData();
			 $('custom_ext2').style.top='100px';
			 
			 $('bglightbox2').style.display=$('custom_ext2').style.display='block';
			 $('bglightbox2').onMotionFinished=function(){};
			 fx($('bglightbox2'),[{'inicio':0,'fin':.8,'u':'','propCSS':'opacity'}],500,true,senoidal);
			 fx($('custom_ext2'),[{'inicio':0,'fin':1,'u':'','propCSS':'opacity'}],500,true,senoidal);
}
function closeAlert2(){
	 fx($('bglightbox2'),[{'inicio':.8,'fin':0,'u':'','propCSS':'opacity'}],500,true,senoidal);
	 $('bglightbox2').onMotionFinished=function(){
		 $('bglightbox2').style.display=$('custom_ext2').style.display='none';
	};
	 fx($('custom_ext2'),[{'inicio':1,'fin':0,'u':'','propCSS':'opacity'}],500,true,senoidal);
	 
}

</script>
  </div>
</form> 

</div>
<script>
DR(function(){
	if($('SponsorshipNoPrize').checked){$('titulobenefel').style.display=$('descbelegido').style.display='none';}else{$('titulobenefel').style.display=$('descbelegido').style.display='block';}
});
</script>
<?if($this->Session->check('rta')){?>
<script>
DR(
function(){
	<?if($this->Session->read('rta')=='s'){?>
		pseudomodal('pago_acreditado.png');
	<? }else{ ?>
		pseudomodal('pago_incompleto.png');
	<? } ?>
});
</script>
<?
$this->Session->delete('rta');
}?>