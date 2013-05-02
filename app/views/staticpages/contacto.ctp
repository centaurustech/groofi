
<?php /* @var $this ViewCC */ 

$this->set('pageTitle' , 'Contacto' ) ;
$this->set('title_for_layout' ,'Contacto' ) ;

?>
<div style="width:100%; height:auto; margin-top:20px">

  <h1><?php echo __("CONTACT");?></h1>
<span style=" font-style:italic"><?php echo __("OUR_OFFICE");?></span><br><br>


<div class="texto_contacto_izq">
<h3 class="cyan">Groofi United Kingdom</h3>
  <br>
	Phone: +44 20 3528 7785<br>
 <span class="cyan"> uk@groofi.com</span>
</p>
</div>
<div class="texto_contacto_izq">
<h3 class="cyan">Groofi Buenos Aires</h3>
  <br>
	Tel.: +54 11 4795 1058<br>
 <span class="cyan"> buenosaires@groofi.com</span> </p>
</div>
<form id="contactform" action="/contacto" method="post" target="ifr">
<div class="form_contacto">
<h3><?php echo __("WRITE_US");?></h3>
<p><?php echo __("USER__DISPLAY_NAME");?></p>
<div class="rounded">
<input type="text" name="nombre" />
</div>
<br>
<p><?php echo __("USER__EMAIL");?></p>
<div class="rounded">
<input type="text" name="email" />
</div>
<br>
<p><?php echo __("COMMENTS");?></p>
<div class="rounded_area">
<textarea name="comentario" cols="1" rows="1"></textarea>
</div>
<div onClick="$('contactform').submit();" class="bot_enviar"><?php echo __("SEND");?></div>
</div>

</form>


</div>

