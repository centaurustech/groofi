    
<?php /* @var $this ViewCC */ 

$this->set('pageTitle' , 'Groofi Escuela' ) ;
$this->set('title_for_layout' ,'Groofi Escuela' ) ;

?>
<div style="width:100%; height:auto;overflow:hidden; margin-top:20px">
<h1 style="font-weight:normal; font-size:28px; line-height:32px"><?php echo __("GROOFI_SCHOOL");?></h1>

<span style="font-style:italic; color:#666; line-height:30px"><?php echo __("THE_GUIDE_OF_PROJECT");?></span>

<div class="misc_divisor"></div>
<br>
<div id="menu_guidelines">
<div class="guideline_titulo" onclick="location='#paso_1';" style="cursor:pointer;">
<div class="guideline_numero define"></div>
<div class="guideline_icono define"></div>
<h3><?php echo __("DEFINE_YOUR_PROJECT");?></h3>
<div class="misc_divisor" style="height:1px; width:296px"></div>

</div>
<div class="guideline_titulo" onclick="location='#paso_2';" style="cursor:pointer;">
<div class="guideline_numero crearecompensas"></div>
<div class="guideline_icono crearecompensas"></div>
<h3><?php echo __("CREATE_AWARDS");?></h3>
<div class="misc_divisor" style="height:1px; width:296px"></div>
</div>
<div class="guideline_titulo" onclick="location='#paso_3';" style="cursor:pointer;">
<div class="guideline_numero meta"></div>
<div class="guideline_icono meta"></div>
<h3><?php echo __("SET_YOUR_GOAL");?></h3>
<div class="misc_divisor" style="height:1px; width:296px"></div>
</div>
<div class="guideline_titulo" onclick="location='#paso_4';" style="cursor:pointer;">
<div class="guideline_numero video"></div>
<div class="guideline_icono video"></div>
<h3><?php echo __("MAKING_YOUR_VIDEO");?></h3>
<div class="misc_divisor" style="height:1px; width:296px"></div>
</div>
<div class="guideline_titulo" onclick="location='#paso_5';" style="cursor:pointer;">
<div class="guideline_numero armar"></div>
<div class="guideline_icono armar"></div>
<h3><?php echo __("ARM_YOUR_PROJECT");?></h3>
<div class="misc_divisor" style="height:1px; width:296px"></div>
</div>
<div class="guideline_titulo" onclick="location='#paso_6';" style="cursor:pointer;">
<div class="guideline_numero promocion"></div>
<div class="guideline_icono promocion"></div>
<h3><?php echo __("PROMOTING_YOUR_PROJECT");?></h3>
<div class="misc_divisor" style="height:1px; width:296px"></div>
</div>
<div class="guideline_titulo" onclick="location='#paso_7';" style="cursor:pointer;">
<div class="guideline_numero actualizacion"></div>
<div class="guideline_icono actualizacion"></div>
<h3><?php echo __("UPDATING_YOUR_PROJECT");?></h3>
<div class="misc_divisor" style="height:1px; width:296px"></div>
</div>
<div class="guideline_titulo" onclick="location='#paso_8';" style="cursor:pointer;">
<div class="guideline_numero cumplir"></div>
<div class="guideline_icono cumplir"></div>
<h3><?php echo __("COMPLY_WITH_REWARDS");?></h3>
<div class="misc_divisor" style="height:1px; width:296px"></div>
</div>
</div>

<div id="columna_der_guidelines">
<div class="respuesta_categoria">
<h4 class="cyan" id="paso_1"><?php echo __("STEP_1");?></h4>
<h2><?php echo __("DEFINE_YOUR_PROJECT");?></h2>
<div class="misc_divisor" style="width:625px"></div>
<div class="respuesta">
  
  <p class="texto_proyecto"><?php echo __("DEFINE_YOUR_PROJECT_CONCEPT");?>
<br><br>

<?php echo __("DEFINE_YOUR_PROJECT_CONCEPT_1");?>
<br><br>
<?php echo __("DEFINE_YOUR_PROJECT_CONCEPT_2");?>
<br><br>
<?php echo __("DEFINE_YOUR_PROJECT_CONCEPT_3");?>
<br><br>
<?php echo __("DEFINE_YOUR_PROJECT_CONCEPT_4");?>
</p><br>
</div>

</div>


<div class="respuesta_categoria">
<div  class="subir"><a style="position:relative; left:-10px;color:#3f3e3e" href="#"><?php echo __("GO_UP");?></a></div>
<h4 class="cyan" id="paso_2"><?php echo __("STEP_2");?></h4>
<h2><?php echo __("CREATE_AWARDS");?></h2>
<div class="misc_divisor" style="width:625px"></div>
<div class="respuesta">

  <p class="texto_proyecto">
  <?php echo __("CREATE_AWARDS_1");?>
<br><br>
<h3 class="guidelinescyan"><?php echo __("CREATE_AWARDS_2");?></h3>

<br>
<span class="texto_proyecto">
<?php echo __("CREATE_AWARDS_3");?>
<br><br>
<?php echo __("CREATE_AWARDS_4");?>
</span>
<br><br>
<ul class="texto_proyecto" style="list-style-position:inside;">
<li><?php echo __("CREATE_AWARDS_5");?></li>
<li><?php echo __("CREATE_AWARDS_6");?></li>
<li><?php echo __("CREATE_AWARDS_7");?></li>
<li><?php echo __("CREATE_AWARDS_8");?></li>
</ul>
<br><br>
<h3 class="guidelinescyan"><?php echo __("CREATE_AWARDS_9");?></h3>
<br>
<span class="texto_proyecto">
<?php echo __("CREATE_AWARDS_10");?>
<br><br>
<?php echo __("CREATE_AWARDS_11");?>
<br><br>
<?php echo __("CREATE_AWARDS_12");?>
</span>
  </p><br>
</div>

</div>



<div class="respuesta_categoria">
<div  class="subir"><a style="position:relative; left:-10px;color:#3f3e3e" href="#"><?php echo __("GO_UP");?></a></div>
<h4 class="cyan" id="paso_3"><?php echo __("STEP_3");?></h4>
<h2><?php echo __("SET_YOUR_GOAL");?></h2>
<div class="misc_divisor" style="width:625px"></div>
<div class="respuesta">

  <p class="texto_proyecto">
  <?php echo __("SET_YOUR_GOAL_1");?>

<br><br>
<h3 class="guidelinescyan"><?php echo __("SET_YOUR_GOAL_2");?></h3>

<br>
<span class="texto_proyecto">
<?php echo __("SET_YOUR_GOAL_3");?>
</span>
<br><br>
<h3 class="guidelinescyan"><?php echo __("SET_YOUR_GOAL_4");?></h3>


<br>

<span class="texto_proyecto">
<?php echo __("SET_YOUR_GOAL_5");?>
<br><br>

<h3 class="guidelinescyan"><?php echo __("SET_YOUR_GOAL_6");?></h3>
<br>
<?php echo __("SET_YOUR_GOAL_7");?>

<br><br>
<h3 class="guidelinescyan"><?php echo __("SET_YOUR_GOAL_8");?></h3>
<br>
<?php echo __("SET_YOUR_GOAL_9");?>
<br><br>
</span>
  </p><br>
</div>

</div>






<div class="respuesta_categoria">
<div  class="subir"><a style="position:relative; left:-10px;color:#3f3e3e" href="#"><?php echo __("GO_UP");?></a></div>
<h4 class="cyan" id="paso_4"><?php echo __("STEP_4");?></h4>
<h2><?php echo __(MAKING_YOUR_VIDEO);?></h2>
<div class="misc_divisor" style="width:625px"></div>
<div class="respuesta">

<p class="texto_proyecto">
<span class="texto_proyecto">
  <?php echo __(MAKING_YOUR_VIDEO_1);?>
<br><br>
<?php echo __(MAKING_YOUR_VIDEO_2);?>
<br><br>
<?php echo __(MAKING_YOUR_VIDEO_3);?>
<br><br>
<?php echo __(MAKING_YOUR_VIDEO_4);?>
</span>
<br><br>
<ul class="texto_proyecto" style="list-style-position:inside;">
<li><?php echo __(MAKING_YOUR_VIDEO_5);?></li>
<li><?php echo __(MAKING_YOUR_VIDEO_6);?></li>
<li><?php echo __(MAKING_YOUR_VIDEO_7);?></li>
<li><?php echo __(MAKING_YOUR_VIDEO_8);?></li>
<li><?php echo __(MAKING_YOUR_VIDEO_9);?></li>
<li><?php echo __(MAKING_YOUR_VIDEO_10);?></li>
</ul>
<br><br>
<span class="texto_proyecto">
<?php echo __(MAKING_YOUR_VIDEO_11);?>
<br><br>
<?php echo __(MAKING_YOUR_VIDEO_12);?>
<br><br>
<?php echo __(MAKING_YOUR_VIDEO_13);?>
</span>
<br><br>


  </p><br>
</div>

</div>





<div class="respuesta_categoria">
<div  class="subir"><a style="position:relative; left:-10px;color:#3f3e3e" href="#"><?php echo __("GO_UP");?></a></div>
<h4 class="cyan" id="paso_5"><?php echo __("STEP_5");?></h4>
<h2><?php echo __("ARM_YOUR_PROJECT");?></h2>
<div class="misc_divisor" style="width:625px"></div>
<div class="respuesta">

<p class="texto_proyecto">
<span class="texto_proyecto">
  <?php echo __("ARM_YOUR_PROJECT_1");?>
</span>
<br><br>
<h3 class="guidelinescyan"><?php echo __("ARM_YOUR_PROJECT_2");?></h3>
<br>
<span class="texto_proyecto">
<?php echo __("ARM_YOUR_PROJECT_3");?>
</span>
<br><br>
<h3 class="guidelinescyan"><?php echo __("ARM_YOUR_PROJECT_4");?></h3>
<br>
<span class="texto_proyecto">
<?php echo __("ARM_YOUR_PROJECT_5");?>
</span>
<br><br>
<h3 class="guidelinescyan"><?php echo __("ARM_YOUR_PROJECT_6");?></h3>
<br>
<span class="texto_proyecto">
<?php echo __("ARM_YOUR_PROJECT_7");?>
</span>
<br><br>
<h3 class="guidelinescyan"><?php echo __("ARM_YOUR_PROJECT_8");?></h3>
<br>
<span class="texto_proyecto">
<?php echo __("ARM_YOUR_PROJECT_9");?>
</span>
<br><br>


  </p><br>
</div>

</div>








<div class="respuesta_categoria">
<div  class="subir"><a style="position:relative; left:-10px;color:#3f3e3e" href="#"><?php echo __("GO_UP");?></a></div>
<h4 class="cyan" id="paso_6"><?php echo __("STEP_6");?></h4>
<h2><?php echo __("PROMOTING_YOUR_PROJECT");?></h2>
<div class="misc_divisor" style="width:625px"></div>
<div class="respuesta">

<p class="texto_proyecto">
<span class="texto_proyecto">
<?php echo __("PROMOTING_YOUR_PROJECT_1");?>
<br><br>
<?php echo __("PROMOTING_YOUR_PROJECT_2");?>
</span>
<br><br>
<h3 class="guidelinescyan"><?php echo __("PROMOTING_YOUR_PROJECT_3");?></h3>
<br>
<span class="texto_proyecto">
<?php echo __("PROMOTING_YOUR_PROJECT_4");?>
</span>
<br><br>
<h3 class="guidelinescyan"><?php echo __("PROMOTING_YOUR_PROJECT_5");?></h3>
<br>
<span class="texto_proyecto">
<?php echo __("PROMOTING_YOUR_PROJECT_6");?>
</span>
<br><br>
<h3 class="guidelinescyan"><?php echo __("PROMOTING_YOUR_PROJECT_7");?></h3>
<br>
<span class="texto_proyecto">
<?php echo __("PROMOTING_YOUR_PROJECT_8");?></span>
<br><br>
<h3 class="guidelinescyan"><?php echo __("PROMOTING_YOUR_PROJECT_9");?></h3>
<br>
<span class="texto_proyecto">
<?php echo __("PROMOTING_YOUR_PROJECT_10");?>
</span>
<br><br>


  </p><br>
</div>

</div>






<div class="respuesta_categoria">
<div  class="subir"><a style="position:relative; left:-10px;color:#3f3e3e" href="#"><?php echo __("GO_UP");?></a></div>
<h4 class="cyan" id="paso_7"><?php echo __("STEP_7");?></h4>
<h2><?php echo __("UPDATING_YOUR_PROJECT");?></h2>
<div class="misc_divisor" style="width:625px"></div>
<div class="respuesta">

<p class="texto_proyecto">
<span class="texto_proyecto">
<?php echo __("UPDATING_YOUR_PROJECT_1");?>
<br><br>

</span>

<h3 class="guidelinescyan"><?php echo __("UPDATING_YOUR_PROJECT_2");?></h3>
<br>
<span class="texto_proyecto">
<?php echo __("UPDATING_YOUR_PROJECT_3");?>
</span>
<br><br>
<h3 class="guidelinescyan"><?php echo __("UPDATING_YOUR_PROJECT_4");?></h3>
<br>
<span class="texto_proyecto">
<?php echo __("UPDATING_YOUR_PROJECT_5");?>
</span>
<br><br>
<h3 class="guidelinescyan"><?php echo __("UPDATING_YOUR_PROJECT_6");?></h3>
<br>
<span class="texto_proyecto">
<?php echo __("UPDATING_YOUR_PROJECT_7");?>


</span>
  </p><br>
</div>

</div>





<div class="respuesta_categoria">
<div  class="subir"><a style="position:relative; left:-10px;color:#3f3e3e" href="#"><?php echo __("GO_UP");?></a></div>
<h4 class="cyan" id="paso_8"><?php echo __("STEP_8");?></h4>
<h2><?php echo __("COMPLY_WITH_REWARDS");?></h2>
<div class="misc_divisor" style="width:625px"></div>
<div class="respuesta">

<p class="texto_proyecto">
<span class="texto_proyecto">
<?php echo __("COMPLY_WITH_REWARDS_1");?>
<br><br>

</span>

<h3 class="guidelinescyan"><?php echo __("COMPLY_WITH_REWARDS_2");?></h3>
<br>
<span class="texto_proyecto">
<?php echo __("COMPLY_WITH_REWARDS_3");?>
</span>
<br><br>
<h3 class="guidelinescyan"><?php echo __("COMPLY_WITH_REWARDS_4");?></h3>
<br>
<span class="texto_proyecto">
<?php echo __("COMPLY_WITH_REWARDS_5");?>
</span>
<br><br>
<h3 class="guidelinescyan"><?php echo __("COMPLY_WITH_REWARDS_6");?></h3>
<br>
<span class="texto_proyecto">
<?php echo __("COMPLY_WITH_REWARDS_7");?>

</span>
  </p><br>
</div>

</div>





  </div>



</div>

